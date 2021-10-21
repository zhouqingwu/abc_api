<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\PurchaseTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseTransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PurchaseTransaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $total_saving = $this->faker->randomFloat(2, 1, 100);
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'total_spent' => $total_saving / $this->faker->randomFloat(2, 0.01, 0.2),
            'total_saving' => $total_saving,
        ];
    }
}
