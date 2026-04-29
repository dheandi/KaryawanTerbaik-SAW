<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'jabatan'];

    public function scores()
    {
        return $this->hasMany(Score::class);
    }
}
