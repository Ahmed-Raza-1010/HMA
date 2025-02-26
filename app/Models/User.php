<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, HasRoles, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'email',
    'designation',
    'phone',
    'city',
    'address',
    'gender',
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
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
  ];
  public function opdCases()
  {
    return $this->hasMany(OpdCase::class, 'doctor_id', 'id');
  }
  public function ipdCases()
  {
    return $this->hasMany(IpdCase::class, 'doctor_id', 'id');
  }

  public function operationalNotes()
  {
    return $this->hasMany(OperationalNote::class, 'surgeon_id')
      ->orWhere('assistant_id', $this->id);
  }
}
