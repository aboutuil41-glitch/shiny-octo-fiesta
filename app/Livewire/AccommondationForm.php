<?php

namespace App\Livewire;

use App\Models\Accommodation;
use App\Models\AccommodationUser;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class AccommondationForm extends Component
{
    public $name;
    public $description;

    public function save()
    {
        $accommodation = Accommodation::create([
        'name' => $this->name,
        'description' => $this->description,
         ]);

        AccommodationUser::create([
            'user_id' => auth()->id(),
            'accommodation_id' => $accommodation->id,
            'role' => 'owner',
        ]);

        return redirect()->route('Home');

    }
    public function render()
    {
        return view('livewire.Frontoffice.accommondation-form');
    }
}
