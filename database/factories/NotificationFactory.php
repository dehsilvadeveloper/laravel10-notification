<?php

namespace Database\Factories;

use App\Enums\NotificationCategoryEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'recipient_id' => fake()->randomNumber(9),
            'content' => fake()->sentence(),
            'category' => fake()->randomElement(NotificationCategoryEnum::class)
        ];
    }

    /**
     * Indicate that the notification is read.
     */
    public function read(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'read_at' => now()
            ];
        });
    }

    /**
     * Indicate that the notification is canceled.
     */
    public function canceled(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'canceled_at' => now()
            ];
        });
    }
}
