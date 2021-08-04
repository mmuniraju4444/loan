<?php

namespace App\Observers;

use App\Models\LoanApplication;
use App\Models\LoanInterest;
use Illuminate\Support\Str;

class LoanApplicationObserver
{
    /**
     * Handle the LoanApplication "creating" event.
     *
     * @param LoanApplication $model
     * @return void
     */
    public function creating(LoanApplication $model)
    {
        $model->uuid = (string)Str::uuid();
        $model->user_id = auth()->user()->id;
        // Get Loan Interest based on the selected Loan Type (consider only active entries)
        $loanInterest = LoanInterest::where('loan_type_id', $model->loan_type_id)
            ->where('is_active', 1)->latest()->first();
        $model->loan_interest_id = $loanInterest->id;
        $model->request_id = uniqid();
    }
}
