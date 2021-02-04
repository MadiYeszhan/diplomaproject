<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    use HasFactory;

    public function drug_category()
    {
        return $this->belongsTo(DrugCategory::class);
    }

    public function disease()
    {
        return $this->belongsTo(Disease::class);
    }

    public function drug()
    {
        return $this->belongsTo(Drug::class);
    }

    public function drugs()
    {
        return $this->hasMany(Drug::class);
    }

    public function drug_languages()
    {
        return $this->hasMany(DrugLanguage::class);
    }

    public function drug_titles(){
        return $this->hasMany(DrugTitle::class);
    }

    public function drug_images(){
        return $this->hasMany(DrugImage::class);
    }

    public function side_effect(){
        return $this->hasOne(SideEffect::class);
    }

    public function contradiction(){
        return $this->hasOne(Contradiction::class);
    }

    public function drug_reviews(){
        return $this->hasMany(DrugReview::class);
    }

    public function manufacturers(){
        return $this->belongsToMany(Manufacturer::class);
    }
}
