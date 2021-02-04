<?php

namespace Database\Factories;

use App\Models\DrugCategory;
use App\Models\DrugCategoryLanguage;
use Illuminate\Database\Eloquent\Factories\Factory;

class DrugCategoryLanguageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DrugCategoryLanguage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'drug_category_id' => DrugCategory::pluck('id')->random(),
            'language' => rand(1,3),
            'title' => $this->faker->sentence(2)
        ];
    }
}
