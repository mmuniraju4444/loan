<?php

namespace App\Observers;

use App\Models\LoanRepayment;
use Illuminate\Support\Str;

class LoanRepaymentObserver
{
    /**
     * Handle the LoanRepayment "creating" event.
     *
     * @param LoanRepayment $model
     * @return void
     */
    public function creating(LoanRepayment $model)
    {
        $model->uuid = (string)Str::uuid();
        $model->user_id = auth()->user()->id;
        // Generate Transaction ID
        $model->transaction_id = uniqid();
    }

    /**
     * Handle the LoanRepayment "created" event.
     *
     * @param LoanRepayment $model
     * @return void
     */
    public function created(LoanRepayment $model)
    {
        // Increment the Count of the Payment Count
        $loanModel = $model->loanApplication;
        $loanModel->payment_count = $loanModel->payment_count + 1;
        $loanModel->save();
    }
}
