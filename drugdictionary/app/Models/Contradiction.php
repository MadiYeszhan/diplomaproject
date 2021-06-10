<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contradiction extends Model
{
    use HasFactory;

    public function drug(){
        return $this->belongsTo(Drug::class);
    }

    public function contradiction_languages(){
        return $this->hasMany(ContradictionLanguage::class);
    }

    public function diseases(){
        return $this->belongsToMany(Disease::class);
    }
}
