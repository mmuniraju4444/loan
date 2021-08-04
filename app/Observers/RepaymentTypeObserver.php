<?php

namespace App\Observers;

use App\Models\RepaymentType;
use Illuminate\Support\Str;

class RepaymentTypeObserver
{
    /**
     * Handle the RepaymentType "creating" event.
     *
     * @param RepaymentType $model
     * @return void
     */
    public function creating(RepaymentType $model)
    {
        $model->uuid = (string)Str::uuid();
    }
}
