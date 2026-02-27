<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccommodationUser extends Model
{
    protected $table = 'accommodation_users';

    protected $fillable = ['user_id', 'accommodation_id', 'role', 'left_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }
}
