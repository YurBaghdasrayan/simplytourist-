<?php

namespace Database\Factories;

use App\Models\TourEquipment;
use Illuminate\Database\Eloquent\Factories\Factory;

class TourEquipmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TourEquipment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tour_id' => $this->faker->randomDigitNotNull,
        'equipment_id' => $this->faker->randomDigitNotNull,
        'equipment_type_id' => $this->faker->randomDigitNotNull,
        'equipment_note' => $this->faker->text,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
