<?php

namespace Database\Factories;

use App\Models\Disease;
use App\Models\DiseaseCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class DiseaseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Disease::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'disease_category_id' => DiseaseCategory::pluck('id')->random(),
        ];
    }
}
