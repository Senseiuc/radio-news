<?php

namespace Database\Factories;

use App\Models\Ad;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdFactory extends Factory
{
    protected $model = Ad::class;

    public function definition(): array
    {
        $types = ['custom','banner','in-article','auto'];
        $placementKeys = array_keys(Ad::PLACEMENTS);
        $type = $this->faker->randomElement($types);

        return [
            'name' => $this->faker->sentence(3),
            'slot_id' => $type === 'custom' ? null : (string) $this->faker->numberBetween(1000000000, 9999999999),
            'type' => $type,
            'placement' => $this->faker->randomElement($placementKeys),
            'is_active' => true,
            'custom_code' => $type === 'custom' ? ['html' => '<div>Ad</div>'] : null,
        ];
    }

    public function inactive(): self
    {
        return $this->state(fn() => ['is_active' => false]);
    }

    public function placement(string $placement): self
    {
        return $this->state(fn() => ['placement' => $placement]);
    }
}
