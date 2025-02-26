<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpdCase extends Model
{
  use HasFactory;
  protected $table = 'opd_cases';
  protected $primaryKey = 'id';
  public $incrementing = true;
  protected $fillable = [
    'patient_id',
    'doctor_id',
    'visit_no',
    'appointment_date',
    'presenting_complaint',
    'history',
    'provisional_diagnose',
    'treatment',
    'special_instruction',
    'follow_up_days',
    'medicine',
    'dose',
    'frequency',
    'duration'
  ];

  public function patient()
  {
    return $this->belongsTo(Patient::class, 'patient_id', 'id');
  }

  public function doctor()
  {
    return $this->belongsTo(User::class, 'doctor_id', 'id');
  }

  public function medicine()
  {
    return $this->hasMany(Medicine::class);
  }
  public function medication()
  {
    return $this->hasMany(Medication::class);
  }
}
