<?php

namespace App\Providers;

use App\Interfaces\IAuthRepository;
use App\Interfaces\ILoanInterestRepository;
use App\Interfaces\ILoanRepaymentRepository;
use App\Interfaces\ILoanRepository;
use App\Interfaces\ILoanTypeRepository;
use App\Interfaces\IRepaymentTypeRepository;
use App\Repositories\AuthRepository;
use App\Repositories\LoanInterestRepository;
use App\Repositories\LoanRepaymentRepository;
use App\Repositories\LoanRepository;
use App\Repositories\LoanTypeRepository;
use App\Repositories\RepaymentTypeRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ILoanInterestRepository::class, LoanInterestRepository::class);
        $this->app->bind(ILoanTypeRepository::class, LoanTypeRepository::class);
        $this->app->bind(ILoanRepository::class, LoanRepository::class);
        $this->app->bind(IAuthRepository::class, AuthRepository::class);
        $this->app->bind(ILoanRepaymentRepository::class, LoanRepaymentRepository::class);
        $this->app->bind(IRepaymentTypeRepository::class, RepaymentTypeRepository::class);
    }
}
