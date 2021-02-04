<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    use HasFactory;

    public function disease_category(){
        return $this->belongsTo(DiseaseCategory::class);
    }

    public function disease_languages(){
        return $this->hasMany(DiseaseLanguage::class);
    }

    public function drug_reviews(){
        return $this->hasMany(DrugReview::class);
    }

    public function contradictions(){
        return $this->belongsToMany(Contradiction::class);
    }
}
