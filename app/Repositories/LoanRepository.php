<?php

namespace App\Repositories;

use App\Http\Resources\LoanApplication\LoanApplication as LoanApplicationJson;
use App\Http\Resources\LoanApplication\LoanApplicationIndex;
use App\Models\LoanApplication;
use App\Models\LoanType;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LoanRepository
{

    /**
     * @param array $request
     * @return LoanApplicationIndex|null
     */
    public function getAll(array $request): ?LoanApplicationIndex
    {
        return new LoanApplicationIndex(LoanApplication::all());
    }

    /**
     * @throws Exception
     */
    public function save(array $request): ?LoanApplicationJson
    {
        $rules = [
            'loan_type_id' => 'required',
            'term' => 'required',
            'amount' => 'required'
        ];

        $validator = Validator::make($request, $rules);
        if ($validator->fails()) {
            throw new \Exception('Validation Fail! Missing Fields - ' . implode(',', $validator->getMessageBag()->keys()));
        }

        return new LoanApplicationJson($this->saveOrUpdatePage($request));
    }

    /**
     * @param array $attributes
     * @return LoanApplication
     * @throws Exception
     */
    protected function saveOrUpdatePage(array $attributes): LoanApplication
    {
        DB::beginTransaction();
        try {
            $model = LoanApplication::updateOrCreate(
                [
                    'uuid' => Arr::get($attributes, 'uuid')
                ],
                [
                    'loan_type_id' => LoanType::getId($attributes['loan_type_id']),
                    'term' => $attributes['term'],
                    'amount' => $attributes['amount'],
                    'emi' => Arr::get($attributes, 'emi', null),
                    'is_approved' => Arr::get($attributes, 'is_approved', false),
                    'pending_payment_count' => Arr::get($attributes, 'pending_payment_count', null),
                    'approved_by' => Arr::get($attributes, 'approved_by', null),
                    'approved_at' => Arr::get($attributes, 'approved_by', null),
                ]);
            DB::commit();
            return $model;
        } catch (Exception $ex) {
            DB::rollBack();
            throw $ex;
        }
    }

    /**
     * Update the Status of the Loan Application
     * @throws Exception
     */
    public function updateStatus(string $uuid, array $request): ?LoanApplicationJson
    {
        $rules = [
            'status' => 'required|boolean'
        ];

        $validator = Validator::make($request, $rules);
        if ($validator->fails()) {
            throw new \Exception('Validation Error in - ' . implode(',', $validator->getMessageBag()->keys()));
        }

        $model = $this->getModel($uuid);
        $emi = $model->total_amount;
        $model = $model->toArray();
        $model['loan_type_id'] = LoanType::getUUID($model['loan_type_id']);
        $model['is_approved'] = !empty($request['status']);
        $model['approved_by'] = auth()->user()->id;
        $model['approved_at'] = Carbon::now();
        if($request['status']) {
            $model['pending_payment_count'] = Carbon::now()->diffInWeeks(Carbon::now()->addYears($model['term']));
            $model['emi'] = round($emi / $model['pending_payment_count']);
        }
        return new LoanApplicationJson($this->saveOrUpdatePage($model));
    }

    /**
     * @param string $uuid
     * @return LoanApplication|null
     */
    public function getModel(string $uuid, array $with = []): ?LoanApplication
    {
        return LoanApplication::getModel($uuid, $with);
    }

    /**
     * @param string $uuid
     * @return LoanApplicationJson
     */
    public function get(string $uuid)
    {
        $model = $this->getModel($uuid, ['loanType', 'loanInterest', 'approvedBy']);
        return new LoanApplicationJson($model);
    }
}
