<?php

namespace App\Http\Resources\LoanInterest;

use App\Http\Resources\LoanType\LoanType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanInterest extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'uuid' => $this->uuid,
            'loan_type' => new LoanType($this->whenLoaded('loanType')),
            'interest_rate' => $this->interest_rate
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param Request $request
     * @return array
     */
    public function with($request)
    {
        return [
            'status' => true
        ];
    }
}
