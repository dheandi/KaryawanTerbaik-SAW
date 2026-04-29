<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'criteria_id', 'nilai'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function criterion()
    {
        return $this->belongsTo(Criterion::class, 'criteria_id');
    }
}
