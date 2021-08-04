<?php

namespace App\Http\Resources\LoanRepayment;

use App\Http\Resources\LoanApplication\LoanApplication;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanRepayment extends JsonResource
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
            'transaction_id' => $this->transaction_id,
            'loan_application' => new LoanApplication($this->whenLoaded('loanApplication')),
            'amount' => $this->amount
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
