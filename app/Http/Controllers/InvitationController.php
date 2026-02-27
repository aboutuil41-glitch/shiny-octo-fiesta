<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitation;
use App\Models\AccommodationUser;

class InvitationController extends Controller
{

private function userHasActiveAccommodation(): bool
{
    return AccommodationUser::where('user_id', auth()->id())
        ->whereNull('left_at')
        ->exists();
}

public function show(string $token)
{
    $invitation = Invitation::with('accommodation')
        ->where('token', $token)
        ->where('status', 'pending')
        ->where('expires_at', '>', now())
        ->firstOrFail();

    return view('invitation.show', compact('invitation'));
}

public function accept(string $token)
{
    if ($this->userHasActiveAccommodation()) {
        return redirect()->route('404-page');
    }
    
    $invitation = Invitation::where('token', $token)
        ->where('status', 'pending')
        ->where('expires_at', '>', now())
        ->firstOrFail();

    AccommodationUser::firstOrCreate(
        ['user_id' => auth()->id(), 'accommodation_id' => $invitation->accommodation_id],
        ['role' => 'member']
    );

    $invitation->update(['status' => 'accepted']);

    return redirect()->route('view.Accommondation', $invitation->accommodation_id);
}

public function decline(string $token)
{
    $invitation = Invitation::where('token', $token)
        ->where('status', 'pending')
        ->firstOrFail();

    $invitation->update(['status' => 'declined']);

    return redirect('/');
}
}
