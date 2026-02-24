<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Models\Expense;
use App\Models\Payment;


#[Layout('layouts.app')]
class Home extends Component
{
    public function render()
    {
        $user = Auth::user();

        $totalExpenses = Expense::where('paid_by', $user->id)->sum('amount');

        $expenseHistory = Expense::where('paid_by', $user->id)
            ->with(['category', 'accommodation'])
            ->latest()
            ->take(10)
            ->get();

        $accommodations = $user->accommodations()->withPivot('role')->get();

        $expenseCount = Expense::where('paid_by', $user->id)->count();
        $paymentCount = Payment::where('payer_id', $user->id)->count();
        $reputation   = $expenseCount + ($paymentCount * 2);

        return view('livewire.Frontoffice.home', [
            'totalExpenses'  => $totalExpenses,
            'expenseHistory' => $expenseHistory,
            'accommodations' => $accommodations,
            'reputation'     => $reputation,
        ]);
    }
}