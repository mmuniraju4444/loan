<?php


namespace App\Repositories;


use App\Http\Resources\LoanType\LoanTypeIndex;
use App\Models\LoanType;

class LoanTypeRepository
{
    /**
     * @param array $request
     * @return LoanTypeIndex|null
     */
    public function getAll(array $request): ?LoanTypeIndex
    {
        return new LoanTypeIndex(LoanType::all());
    }
}
