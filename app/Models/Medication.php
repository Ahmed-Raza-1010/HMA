<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    use HasFactory;
    protected $table = 'medications';
    protected $fillable = [
        'name',
        'dose',
        'frequency',
    ];
    public function opdCase()
    {
        return $this->belongsTo(OpdCase::class, 'opd_case_id');
    }
    public function ipdCase()
    {
        return $this->belongsTo(IPDCase::class, 'ipd_case_id');
    }
}
