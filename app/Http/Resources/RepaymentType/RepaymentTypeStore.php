<?php

namespace App\Http\Resources\RepaymentType;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RepaymentTypeStore extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return RepaymentType
     */
    public function toArray($request)
    {
        return new RepaymentType($this->resource);
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
