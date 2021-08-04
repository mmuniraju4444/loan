<?php


namespace App\Repositories;

use App\Http\Resources\RepaymentType\RepaymentTypeIndex;
use App\Models\RepaymentType;

class RepaymentTypeRepository
{
    /**
     * @param array $request
     * @return RepaymentTypeIndex|null
     */
    public function getAll(array $request): ?RepaymentTypeIndex
    {
        return new RepaymentTypeIndex(RepaymentType::all());
    }
}
