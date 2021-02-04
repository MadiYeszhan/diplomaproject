<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiseaseCategoryLanguage extends Model
{
    use HasFactory;

    public function disease_category(){
        return $this->belongsTo(DiseaseCategory::class);
    }
}
