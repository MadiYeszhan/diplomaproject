<?php

namespace Database\Factories;

use App\Models\Contradiction;
use App\Models\Drug;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContradictionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contradiction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'drug_id' => Drug::pluck('id')->random()
        ];
    }
}
