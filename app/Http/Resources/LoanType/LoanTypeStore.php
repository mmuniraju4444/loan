<?php

namespace App\Http\Resources\LoanType;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanTypeStore extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return LoanType
     */
    public function toArray($request)
    {
        return new LoanType($this->resource);
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
