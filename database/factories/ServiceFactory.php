<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\User; // Import User model
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Service::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => ServiceCategory::factory(), // Automatically creates a category
            'name' => $this->faker->unique()->word() . ' Service',
            'description' => $this->faker->paragraph(),
            'price' => $this->faker->randomFloat(2, 10, 500),
            // 'user_id' is intentionally omitted here to be assigned via `for()` or specific state in tests
        ];
    }

    /**
     * Indicate that the service belongs to a specific user.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function forUser(User $user)
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => $user->id,
        ]);
    }
}
