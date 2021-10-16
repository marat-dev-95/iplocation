<?php

namespace Database\Factories;

use App\Models\IpLocation;
use Illuminate\Database\Eloquent\Factories\Factory;

class IpLocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = IpLocation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'country_name' => $this->faker->country(),
            'ip_address' => $this->faker->ipv4(),
        ];
    }
}
