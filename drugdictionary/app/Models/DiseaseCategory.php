<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiseaseCategory extends Model
{
    use HasFactory;

    public function disease_category_languages(){
        return $this->hasMany(DiseaseCategoryLanguage::class);
    }

    public function diseases(){
        return $this->hasMany(Disease::class);
    }
}
