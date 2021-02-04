<?php

namespace Database\Factories;

use App\Models\DiseaseCategory;
use App\Models\DiseaseCategoryLanguage;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiseaseCategoryLanguageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DiseaseCategoryLanguage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'disease_category_id' => DiseaseCategory::pluck('id')->random(),
            'language' => rand(1,3),
            'title' => $this->faker->sentence(2)
        ];
    }
}
