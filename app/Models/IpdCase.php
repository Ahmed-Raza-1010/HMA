<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpdCase extends Model
{
  use HasFactory;


  protected $fillable = [
    'patient_id',
    'doctor_id',
    'visit_no',
    'doctor_id',
    'bed',
    'appointment_date',
    'presenting_complaint',
    'history',
    'follow_up_days',
    'provisional_diagnose',
    'treatment',
    'special_instruction',
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
  public function dischargePlans()
  {
    return $this->hasMany(DischargePlan::class, 'ipd_case_id', 'id');
  }
}
