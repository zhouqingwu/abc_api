<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class PurchaseTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (App::environment('local')) {
            $count =  env('SEEDER_LIMIT', 0);
            User::factory()->count($count)->hasPurchaseTransactions(4)->create();
        }
    }
}
