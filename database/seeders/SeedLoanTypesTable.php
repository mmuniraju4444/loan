<?php

namespace Database\Seeders;

use App\Models\LoanType;
use Illuminate\Database\Seeder;

class SeedLoanTypesTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LoanType::firstOrCreate(['name' => 'Vehicle']);
        LoanType::firstOrCreate(['name' => 'Home']);
        LoanType::firstOrCreate(['name' => 'Personal']);
    }
}
