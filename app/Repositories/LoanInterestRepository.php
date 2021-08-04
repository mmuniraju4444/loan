<?php


namespace App\Repositories;

use App\Http\Resources\LoanInterest\LoanInterestIndex;
use App\Models\LoanInterest;

class LoanInterestRepository
{
    /**
     * @param array $request
     * @return LoanInterestIndex|null
     */
    public function getAll(array $request): ?LoanInterestIndex
    {
        return new LoanInterestIndex(LoanInterest::where('is_active', true)->get());
    }
}
