<?php

namespace Database\Factories;

use App\Models\Manufacturer;
use App\Models\ManufacturerLanguage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ManufacturerLanguageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ManufacturerLanguage::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'manufacturer_id' => Manufacturer::pluck('id')->random(),
            'language' => rand(1,3),
            'description' => $this->faker->sentence(5)
        ];
    }
}
