<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;
    protected $table = 'medicines';
    protected $fillable = [
        'ipd_case_id',
        'opd_case_id',
        'medicine_name',
        'dose',
        'frequency',
        'duration',
    ];
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;
    public function opdCase()
    {
        return $this->belongsTo(OpdCase::class, 'opd_case_id');
    }
    public function ipdCase()
    {
        return $this->belongsTo(IPDCase::class, 'ipd_case_id');
    }
}
