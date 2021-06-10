<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrugCategoryLanguage extends Model
{
    use HasFactory;

    public function drug_category(){
        return $this->belongsTo(DrugCategory::class);
    }
}
