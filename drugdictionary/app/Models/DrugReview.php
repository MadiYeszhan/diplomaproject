<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrugReview extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function drug(){
        return $this->belongsTo(Drug::class);
    }

    public function disease(){
        return $this->belongsTo(Disease::class);
    }
}
