<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $awards = (['diploma', 'bachelor']);
        $gender = (['male', 'female']);
        $level = ['first year', 'second year', 'third year', 'fourth year'];
        $student_type = ['fresher', 'continuous', 'foreigner', 'disabled'];
        $sponsor = ['government', 'private', 'heslb'];

        $genderNumber = $this->faker->numberBetween(0,1);
        return [
            'name' => $this->faker->name($gender[$genderNumber]),
            'username' => $this->faker->unique()->numberBetween(210230022210, 22102999999),
            'award' => $awards[$this->faker->numberBetween(0,1)],
            // 'department' => $this->faker,
            // 'programme' => $this->faker,
            'level' => $level[$this->faker->numberBetween(0,3)],
            'phone' => $this->faker->unique()->phoneNumber(),
            'email' => $this->faker->unique()->email(),
            'gender_id' => $genderNumber+1,
            'student_type' => $student_type[$this->faker->numberBetween(0,3)],
            'sponsor' => $sponsor[$this->faker->numberBetween(0,2)],
            'verified' => 1,
        ];
    }
}
