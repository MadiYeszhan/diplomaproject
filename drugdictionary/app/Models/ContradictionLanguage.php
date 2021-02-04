<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContradictionLanguage extends Model
{
    use HasFactory;

    public function contradiction(){
        return $this->belongsTo(Contradiction::class);
    }
}
