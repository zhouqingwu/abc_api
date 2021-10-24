<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Voucher;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoucherFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Voucher::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => Str::orderedUuid(),
            'batch' => date('ymdh'),
            'stock' => 1,
            'amount' => 50,
            'code' => Str::random(8),
        ];
    }
}
