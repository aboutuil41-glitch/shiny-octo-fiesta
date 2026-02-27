<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    protected $fillable = ['name', 'state','description'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'accommodation_users')
                    ->withPivot('role','left_at')
                    ->withTimestamps();
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }
}
