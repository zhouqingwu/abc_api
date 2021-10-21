<?php

namespace Database\Seeders;

use App\Models\PurchaseTransaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class PurchaseTransactionSeeder extends Seeder
{
    public static $count = 100;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->count(self::$count)->create();
        PurchaseTransaction::factory()->count(self::$count*10)->create();
    }
}
