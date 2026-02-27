<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class AccommondationList extends Component
{
    public $accommondations;

    public function mount(): void
    {
        $this->loadAccommodations();
    }

    public function loadAccommodations(): void
    {
        $this->accommondations = Auth::user()
            ->accommodations()
            ->withPivot('role', 'left_at', 'created_at')
            ->orderByPivot('created_at','desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.Frontoffice.accommondation-list');
    }
}