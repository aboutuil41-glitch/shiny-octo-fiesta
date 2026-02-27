<?php

namespace App\Livewire;

use App\Models\{Accommodation, AccommodationUser, Category, Expense, Invitation, Payment};
use App\Mail\InvitationMail;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Accommondation extends Component
{
    public $accommodation, $category, $title, $amount, $cataname, $inviteEmail, $generatedLink;

    public bool $Expensemodel = false;
    public bool $Catamodel    = false;
    public bool $Invitemodel  = false;

    public string $filterMonth = '';  // e.g. '2025-06', empty = all months

    public array $balances = [];
    public array $debts    = [];

    public function mount($id): void
    {
        $this->accommodation = Accommodation::with([
            'users'            => fn($q) => $q->withPivot('role', 'left_at'),
            'expenses.category',
            'categories',
            'payments',
        ])->findOrFail($id);

        $this->calculateBalances();
    }

    private function loadAccommodation(): void
    {
        $this->accommodation = Accommodation::with([
            'users'            => fn($q) => $q->withPivot('role', 'left_at'),
            'expenses.category',
            'categories',
            'payments',
        ])->findOrFail($this->accommodation->id);
    }

    private function isOwner(): bool
    {
        return $this->accommodation->users
            ->firstWhere('id', auth()->id())
            ?->pivot->role === 'owner';
    }

    // Returns expenses filtered by the selected month (or all if no filter)
    public function filteredExpenses()
    {
        return $this->accommodation->expenses->when($this->filterMonth, fn($e) =>
            $e->filter(fn($ex) => str_starts_with($ex->created_at->toDateString(), $this->filterMonth))
        );
    }

    // Returns all distinct year-month values from expenses, for the filter dropdown
    public function expenseMonths()
    {
        return $this->accommodation->expenses
            ->map(fn($e) => $e->created_at->format('Y-m'))
            ->unique()
            ->sortDesc()
            ->values();
    }

    private function calculateBalances(): void
    {
        $members = $this->accommodation->users->filter(fn($u) => is_null($u->pivot->left_at));

        if ($members->isEmpty()) {
            $this->balances = [];
            $this->debts    = [];
            return;
        }

        $share = $this->accommodation->expenses->sum('amount') / $members->count();

        $paid = $members->mapWithKeys(fn($m) => [
            $m->id => $this->accommodation->expenses->where('paid_by', $m->id)->sum('amount'),
        ])->toArray();

        foreach ($this->accommodation->payments as $p) {
            $paid[$p->payer_id]    = ($paid[$p->payer_id]    ?? 0) + $p->amount;
            $paid[$p->receiver_id] = ($paid[$p->receiver_id] ?? 0) - $p->amount;
        }

        $this->balances = $members->mapWithKeys(fn($m) => [
            $m->id => [
                'user'    => $m,
                'paid'    => $paid[$m->id],
                'share'   => $share,
                'balance' => $paid[$m->id] - $share,
            ],
        ])->toArray();

        $this->debts = $this->simplifyDebts($this->balances);
    }

    // Pairs up who owes who with the minimum number of transfers
    private function simplifyDebts(array $balances): array
    {
        $creditors = collect($balances)->filter(fn($b) => $b['balance'] >  0.01)->sortByDesc('balance')->values()->all();
        $debtors   = collect($balances)->filter(fn($b) => $b['balance'] < -0.01)->sortBy('balance')->values()->all();

        $debts = [];
        $i = $j = 0;

        while ($i < count($creditors) && $j < count($debtors)) {
            $amount = min($creditors[$i]['balance'], abs($debtors[$j]['balance']));

            $debts[] = ['from' => $debtors[$j]['user'], 'to' => $creditors[$i]['user'], 'amount' => round($amount, 2)];

            $creditors[$i]['balance'] -= $amount;
            $debtors[$j]['balance']   += $amount;

            if ($creditors[$i]['balance'] < 0.01)    $i++;
            if (abs($debtors[$j]['balance']) < 0.01) $j++;
        }

        return $debts;
    }

    public function markAsPaid(int $fromId, int $toId, float $amount): void
    {
        Payment::create([
            'accommodation_id' => $this->accommodation->id,
            'payer_id'         => $fromId,
            'receiver_id'      => $toId,
            'amount'           => $amount,
            'paid_at'          => now(),
        ]);

        $this->loadAccommodation();
        $this->calculateBalances();
    }

    public function leave()
    {
        $user  = auth()->user();
        $pivot = AccommodationUser::where('user_id', $user->id)
            ->where('accommodation_id', $this->accommodation->id)
            ->first();

        if (!$pivot || $pivot->role === 'owner') return;

        $balance = $this->balances[$user->id]['balance'];
        $user->increment('reputation', $balance >= -0.01 ? 1 : -1);
        $pivot->update(['left_at' => now()]);

        return redirect()->route('view.Accommondations');
    }

    public function removeMember(int $userId)
    {
        if (!$this->isOwner()) return;

        $member = $this->accommodation->users->firstWhere('id', $userId);
        if (!$member || $member->pivot->role === 'owner') return;

        $balance = $this->balances[$userId]['balance'];

        if ($balance < -0.01) {
            Payment::create([
                'accommodation_id' => $this->accommodation->id,
                'payer_id'         => auth()->id(),
                'receiver_id'      => $userId,
                'amount'           => abs($balance),
                'paid_at'          => now(),
            ]);
        }

        $member->increment('reputation', $balance >= -0.01 ? 1 : -1);

        AccommodationUser::where('user_id', $userId)
            ->where('accommodation_id', $this->accommodation->id)
            ->update(['left_at' => now()]);

        $this->loadAccommodation();
        $this->calculateBalances();
    }

    public function cancelAccommodation()
    {
        if (!$this->isOwner()) return;

        foreach ($this->balances as $data) {
            $data['user']->increment('reputation', $data['balance'] >= -0.01 ? 1 : -1);
        }

        $this->accommodation->update(['state' => 'canceled']);

        AccommodationUser::where('accommodation_id', $this->accommodation->id)
            ->whereNull('left_at')
            ->update(['left_at' => now()]);

        return redirect()->route('view.Accommondations');
    }

    public function OpenModelExpense(): void { $this->Expensemodel = true; }
    public function OpenModelCata(): void    { $this->Catamodel    = true; }
    public function OpenModelInvite(): void  { $this->Invitemodel  = true; }

    public function closeModelExpense(): void { $this->Expensemodel = false; }
    public function closeModelCata(): void    { $this->Catamodel    = false; }
    public function closeModelInvite(): void  { $this->Invitemodel  = false; $this->reset(['inviteEmail', 'generatedLink']); }

    public function invite(): void
    {
        $this->validate(['inviteEmail' => 'required|email']);

        $invitation = Invitation::create([
            'accommodation_id' => $this->accommodation->id,
            'email'            => $this->inviteEmail,
            'token'            => \Str::uuid(),
            'status'           => 'pending',
            'expires_at'       => now()->addDays(7),
        ]);

        Mail::to($this->inviteEmail)->send(new InvitationMail($invitation));

        $this->generatedLink = route('invitation.show', $invitation->token);
        $this->reset('inviteEmail');
    }

    public function generateLink(): void
    {
        $invitation = Invitation::create([
            'accommodation_id' => $this->accommodation->id,
            'email'            => 'link@generated',
            'token'            => \Str::uuid(),
            'status'           => 'pending',
            'expires_at'       => now()->addDays(7),
        ]);

        $this->generatedLink = route('invitation.show', $invitation->token);
    }

    public function addCata(): void
    {
        $this->validate(['cataname' => 'required|string|max:255']);

        Category::create(['accommodation_id' => $this->accommodation->id, 'name' => $this->cataname]);

        $this->reset('cataname');
        $this->Catamodel = false;
        $this->loadAccommodation();
    }

    public function addExpense(): void
    {
        $this->validate([
            'title'    => 'required|string|max:255',
            'amount'   => 'required|numeric|min:0.01',
            'category' => 'required|exists:categories,id',
        ]);

        Expense::create([
            'accommodation_id' => $this->accommodation->id,
            'paid_by'          => auth()->id(),
            'category_id'      => $this->category,
            'title'            => $this->title,
            'amount'           => $this->amount,
        ]);

        $this->reset(['title', 'amount', 'category']);
        $this->Expensemodel = false;
        $this->loadAccommodation();
        $this->calculateBalances();
    }

    public function render()
    {
        return view('livewire.Frontoffice.accommondation', [
            'filteredExpenses' => $this->filteredExpenses(),
            'expenseMonths'    => $this->expenseMonths(),
        ]);
    }
}