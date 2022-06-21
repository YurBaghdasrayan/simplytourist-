<?php

namespace Database\Factories;

use App\Models\ToursTypesRatings;
use Illuminate\Database\Eloquent\Factories\Factory;

class ToursTypesRatingsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ToursTypesRatings::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tour_type_id' => $this->faker->randomDigitNotNull,
        'tour_type_rating' => $this->faker->word,
        'description_de' => $this->faker->text,
        'description_en' => $this->faker->text,
        'description_ru' => $this->faker->text,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
