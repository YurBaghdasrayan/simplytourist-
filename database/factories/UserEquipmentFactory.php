<?php

namespace Database\Factories;

use App\Models\UserEquipment;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserEquipmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserEquipment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->word,
        'equipment_id' => $this->faker->randomDigitNotNull,
        'equipment_type_id' => $this->faker->randomDigitNotNull,
        'note' => $this->faker->text,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s'),
        'deleted_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
