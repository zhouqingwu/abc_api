<?php

namespace App\Console\Commands;

use App\Models\Voucher;
use Illuminate\Console\Command;

class VoucherStart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'voucher:start {batch}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start Voucher Campaign By Batch Number';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $batch = $this->argument('batch');
        $count = $this->ask('Please input the number of vouchers? (must same as in database)');

        // check in DB
        $vouchers = Voucher::whereBatch($batch)->get();

        $countBatch = count($vouchers);
        if (!$countBatch) {
            $this->error('Voucher batch: ' .$batch . ' was not found!');
            return Command::FAILURE;
        }

        //voucher count same as database
        if ($count != $countBatch) {
            $this->error('The number of vouchers in database is ' .$countBatch);
            return Command::FAILURE;
        }

        // check in cache
        if (cache()->has('voucher_batch_'.$batch)) {
            $this->error('Voucher batch: ' .$batch . ' is already in Cache');
            return Command::FAILURE;
        }

        // set voucher count limit
        cache()->forever('voucher_batch_'.$batch, $count);

        //Todo:: vouchers to cache

        $this->info('Started Successfully');
        $this->newLine(1);
        return Command::SUCCESS;
    }
}
