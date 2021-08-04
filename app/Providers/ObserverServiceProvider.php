<?php

namespace App\Providers;


use App\Models\LoanApplication;
use App\Models\LoanInterest;
use App\Models\LoanRepayment;
use App\Models\LoanType;
use App\Models\RepaymentType;
use App\Observers\LoanApplicationObserver;
use App\Observers\LoanInterestObserver;
use App\Observers\LoanRepaymentObserver;
use App\Observers\LoanTypeObserver;
use App\Observers\RepaymentTypeObserver;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        LoanType::observe(LoanTypeObserver::class);
        LoanInterest::observe(LoanInterestObserver::class);
        RepaymentType::observe(RepaymentTypeObserver::class);
        LoanApplication::observe(LoanApplicationObserver::class);
        LoanRepayment::observe(LoanRepaymentObserver::class);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
