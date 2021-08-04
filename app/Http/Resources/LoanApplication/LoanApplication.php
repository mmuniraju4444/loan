<?php

namespace App\Http\Resources\LoanApplication;

use App\Http\Resources\LoanInterest\LoanInterest;
use App\Http\Resources\LoanType\LoanType;
use App\Http\Resources\User\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanApplication extends JsonResource
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
            'request_id' => $this->request_id,
            'loan_type' => new LoanType($this->whenLoaded('loanType')),
            'loan_interest' => new LoanInterest($this->whenLoaded('loanInterest')),
            'term' => $this->term,
            'amount' => $this->amount,
            'emi' => $this->emi,
            'total' => $this->total_amount,
            'balance' => $this->total_balance_amount,
            'is_approved' => $this->is_approved,
            'payment_count' => $this->payment_count,
            'pending_payment_count' => $this->pending_payment_count,
            'approved_by' => new User($this->whenLoaded('approvedBy')),
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
