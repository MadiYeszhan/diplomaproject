<?php

namespace Database\Factories;

use App\Models\Disease;
use App\Models\Drug;
use App\Models\DrugReview;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DrugReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DrugReview::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::pluck('id')->random(),
            'drug_id' => Drug::pluck('id')->random(),
            'disease_id' => Disease::pluck('id')->random(),
            'language' => rand(1,3),
            'rating' => rand(1,10),
            'comment' => $this->faker->sentence(5)
        ];
    }
}
