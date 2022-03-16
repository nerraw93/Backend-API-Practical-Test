<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'username',
    'email',
    'password',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
    'pivot'
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  public function tweets()
  {
    return $this->hasMany(\App\Models\Tweet::class);
  }

  public function followers()
  {
    return $this->belongsToMany(\App\Models\User::class, 'follows', 'follower_id', 'following_id')->withTimestamps();
  }

  public function following()
  {
    return $this->belongsToMany(\App\Models\User::class, 'follows', 'following_id', 'follower_id')->withTimestamps();
  }
}