<?php

namespace Database\Seeders;

use App\Models\RepaymentType;
use Illuminate\Database\Seeder;

class SeedRepaymentTypesTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RepaymentType::firstOrCreate(['name' => 'Weekly']);
    }
}
