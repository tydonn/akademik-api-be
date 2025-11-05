<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //
    protected $fillable = ['name', 'nim', 'email'];

    public function grades() {
        return $this->hasMany(Grade::class);
    }

    use HasFactory;
}
