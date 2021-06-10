<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SideEffectLanguage extends Model
{
    use HasFactory;

    public function side_effect()
    {
        return $this->belongsTo(SideEffect::class);
    }
}
