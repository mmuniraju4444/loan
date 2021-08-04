<?php

namespace App\Observers;

use App\Models\LoanInterest;
use Illuminate\Support\Str;

class LoanInterestObserver
{
    /**
     * Handle the LoanInterest "creating" event.
     *
     * @param LoanInterest $model
     * @return void
     */
    public function creating(LoanInterest $model)
    {
        $model->uuid = (string)Str::uuid();
    }
}
