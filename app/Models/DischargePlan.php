<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DischargePlan extends Model
{
  use HasFactory;
  protected $fillable = [
    'patient_id',
    'ipd_case_id',
    'treatment_in_hospital',
    'treatment_in_home',
    'operative_findings',
  ];

  public function patient()
  {
    return $this->belongsTo(Patient::class, 'patient_id', 'id');
  }
  public function ipdCase()
  {
    return $this->belongsTo(IpdCase::class, 'ipd_case_id', 'id');
  }
}
