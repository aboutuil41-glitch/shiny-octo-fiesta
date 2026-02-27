<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Models\Expense;



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

        $accommodation = $user->accommodations()
        ->withPivot('role', 'left_at')
      
        ->wherePivotNull('left_at')
        ->where('state', 'active')
        ->first();

        return view('livewire.Frontoffice.home', [
            'totalExpenses'  => $totalExpenses,
            'expenseHistory' => $expenseHistory,
            'accommodation' => $accommodation,
            'reputation' => $user->reputation?? 0,
        ]);
    }
}