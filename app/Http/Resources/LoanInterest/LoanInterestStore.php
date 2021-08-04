<?php

namespace App\Http\Resources\LoanInterest;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanInterestStore extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return LoanInterest
     */
    public function toArray($request)
    {
        return new LoanInterest($this->resource);
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
