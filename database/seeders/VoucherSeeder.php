<?php

namespace Database\Seeders;

use App\Models\Voucher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (App::environment('local')) {
            // generate voucher code for testing
            $count = 1000;
            $vouchers = Voucher::factory()->count($count)->make()->toArray();
            array_walk($vouchers, function (&$voucher) {
                $voucher['created_at'] =  $voucher['updated_at'] = now()->toDateTimeString();
            });

            Voucher::insert($vouchers);
        }
    }
}
