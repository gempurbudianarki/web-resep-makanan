<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'banned_at' => 'datetime',
    ];

    public function isBanned(): bool
    {
        return $this->banned_at !== null;
    }

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function bookmarkedRecipes()
    {
        return $this->belongsToMany(Recipe::class, 'bookmarks');
    }
}
