<?php

use Illuminate\Database\Seeder;
use App\Models\Balance;

class BalanceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Initiate the balance
        $balance = new Balance();
        $balance->balance = 0;

        // Save it to the data base
        $balance->save();
    }
}
