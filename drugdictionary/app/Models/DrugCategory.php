<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrugCategory extends Model
{
    use HasFactory;
    
    public function drug_category_languages(){
        return $this->hasMany(DrugCategoryLanguage::class);
    }
}
