<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
  use HasFactory;

  protected $primaryKey = 'id';
  public $incrementing = true;
  protected $keyType = 'int';
  protected $fillable = [
    'mrn',
    'name',
    'gender',
    'age',
    'city',
    'phone',
    'address',
    'height',
    'weight',
    'pulse',
    'blood_pressure',
    'temperature',
    'respiratory',
  ];

  public function opdCases()
  {
    return $this->hasMany(OpdCase::class, 'patient_id', 'id');
  }
  public function ipdCases()
  {
    return $this->hasMany(IpdCase::class, 'patient_id', 'id');
  }

  public function operationalNotes()
  {
    return $this->hasMany(OperationalNote::class, 'patient_id', 'id');
  }
}
