<?php

namespace App\Http\Resources\LoanApplication;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanApplicationStore extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return LoanApplication
     */
    public function toArray($request)
    {
        return new LoanApplication($this->resource);
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
