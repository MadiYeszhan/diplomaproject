<?php

namespace Database\Seeders;

use App\Models\Contradiction;
use App\Models\ContradictionLanguage;
use App\Models\Disease;
use App\Models\DiseaseCategory;
use App\Models\DiseaseCategoryLanguage;
use App\Models\DiseaseLanguage;
use App\Models\Drug;
use App\Models\DrugCategory;
use App\Models\DrugCategoryLanguage;
use App\Models\DrugLanguage;
use App\Models\DrugReview;
use App\Models\DrugTitle;
use App\Models\Manufacturer;
use App\Models\ManufacturerLanguage;
use App\Models\SideEffect;
use App\Models\SideEffectLanguage;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();

        DiseaseCategory::factory(10)->create();
        DiseaseCategoryLanguage::factory(10)->create();

        DrugCategory::factory(10)->create();
        DrugCategoryLanguage::factory(10)->create();

        Manufacturer::factory(10)->create();
        ManufacturerLanguage::factory(10)->create();

        Disease::factory(10)->create();
        DiseaseLanguage::factory(10)->create();

        Drug::factory(10)->create();
        DrugLanguage::factory(10)->create();

        DrugTitle::factory(10)->create();

        SideEffect::factory(10)->create();
        SideEffectLanguage::factory(10)->create();

        Contradiction::factory(10)->create();
        ContradictionLanguage::factory(10)->create();

        DrugReview::factory(10)->create();
    }
}
