<?php

namespace App\Observers;

use App\Models\LoanType;
use Illuminate\Support\Str;

class LoanTypeObserver
{
    /**
     * Handle the LoanType "creating" event.
     *
     * @param LoanType $model
     * @return void
     */
    public function creating(LoanType $model)
    {
        $model->uuid = (string)Str::uuid();
    }
}
