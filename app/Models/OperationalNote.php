<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationalNote extends Model
{
  use HasFactory;

  protected $table = 'operational_notes';

  protected $primaryKey = 'id';

  protected $fillable = [
    'patient_id',
    'ipd_case_id',
    'procedure_name',
    'surgeon_id',
    'assistant_id',
    'indication_of_surgery',
    'operative_findings',
    'post_operation_orders',
    'special_instruction',
  ];

  public function patient()
  {
    return $this->belongsTo(Patient::class, 'patient_id', 'id');
  }
  public function doctor()
  {
    return $this->belongsTo(User::class, 'surgeon_id');
  }
  public function ipdCase()
  {
    return $this->belongsTo(IpdCase::class, 'ipd_case_id');
  }
}
