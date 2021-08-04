<?php

namespace Database\Seeders;

use App\Models\LoanInterest;
use Illuminate\Database\Seeder;

class SeedLoanInterestsTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LoanInterest::firstOrCreate(['loan_type_id' => 1, 'interest_rate' => 9]);
        LoanInterest::firstOrCreate(['loan_type_id' => 2, 'interest_rate' => 8]);
        LoanInterest::firstOrCreate(['loan_type_id' => 3, 'interest_rate' => 10]);
    }
}
