<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrugImage extends Model
{
    use HasFactory;

    public function drug(){
        return $this->belongsTo(Drug::class);
    }
}
