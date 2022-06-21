<?php

namespace Database\Factories;

use App\Models\Tours;
use Illuminate\Database\Eloquent\Factories\Factory;

class ToursFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tours::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tour_name' => $this->faker->word,
        'country_iso' => $this->faker->word,
        'tour_type_id' => $this->faker->randomDigitNotNull,
        'tour_type_rating' => $this->faker->word,
        'tour_condition_id' => $this->faker->randomDigitNotNull,
        'tour_condition_rating' => $this->faker->word,
        'tour_date_start' => $this->faker->date('Y-m-d H:i:s'),
        'tour_date_end' => $this->faker->date('Y-m-d H:i:s'),
        'tour_description' => $this->faker->text,
        'tour_link' => $this->faker->text,
        'tour_creator' => $this->faker->word,
        'tour_created_datetime' => $this->faker->date('Y-m-d H:i:s'),
        'attendees_min' => $this->faker->word,
        'attendees_max' => $this->faker->word,
        'open_places' => $this->faker->word,
        'guide_needed' => $this->faker->word,
        'guided' => $this->faker->word,
        'estimated_costs' => $this->faker->word,
        'tour_status' => $this->faker->word,
        'edit_lock' => $this->faker->word,
        'tour_private' => $this->faker->word,
        'target_longitude' => $this->faker->word,
        'target_latitude' => $this->faker->word,
        'target_coordinates' => $this->faker->word,
        'deleted_at' => $this->faker->date('Y-m-d H:i:s'),
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
