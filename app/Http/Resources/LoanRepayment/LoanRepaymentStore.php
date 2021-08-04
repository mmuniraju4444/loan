<?php

namespace App\Http\Resources\LoanRepayment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanRepaymentStore extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return LoanRepayment
     */
    public function toArray($request)
    {
        return new LoanRepayment($this->resource);
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
