<?php

namespace App\Livewire;

use App\Models\Accommodation;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public array $stats = [];
    public string $tab = 'stats';
    public $users;

    public function mount(): void
    {
        $this->statistics();
        $this->loadUsers();
    }

    public function statistics(): void
    {
        $this->stats = [
            'Total Users'          => User::whereDoesntHave('roles', fn($q) => $q->where('name', 'admin'))->whereNull('is_banned')->count(),
            'Banned Users'         => User::whereNotNull('is_banned')->count(),
            'Total Accommodations' => Accommodation::where('state', 'active')->count(),
        ];
    }

    public function loadUsers(): void
    {
        $this->users = User::whereDoesntHave('roles', fn($q) => $q->where('name', 'admin'))->orderBy('created_at', 'desc')->get();
    }

    public function switchTab(string $tab): void
    {
        $this->tab = $tab;
    }

   public function ban(int $id): void
{
    $user = User::find($id);
    $user->is_banned = now();
    $user->save();
    $this->statistics();
}

public function unban(int $id): void
{
    $user = User::find($id);
    $user->is_banned = null;
    $user->save();
    $this->statistics();
}

    public function render()
    {
        return view('livewire.backoffice.dashboard', [
            'stats' => $this->stats,
            'users' => $this->users,
        ]);
    }
}