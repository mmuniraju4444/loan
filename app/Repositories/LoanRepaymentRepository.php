<?php

namespace App\Repositories;

use App\Http\Resources\LoanRepayment\LoanRepayment as LoanRepaymentJson;
use App\Http\Resources\LoanRepayment\LoanRepaymentIndex;
use App\Interfaces\ILoanRepository;
use App\Models\LoanApplication;
use App\Models\LoanRepayment;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class LoanRepaymentRepository
{
    /**
     * @var null
     */
    protected $loanModel;

    /**
     * @var LoanRepository
     */
    protected $loanRepo;

    /**
     * LoanRepaymentRepository constructor.
     */
    public function __construct()
    {
        $this->loanModel = null;
        $this->loanRepo = app(ILoanRepository::class);
    }

    /**
     * @param string $uuid
     * @param array $request
     * @return LoanRepaymentIndex|null
     */
    public function getAll(string $uuid, array $request): ?LoanRepaymentIndex
    {
        return new LoanRepaymentIndex(LoanRepayment::where('loan_application_id', LoanApplication::getId($uuid))->get());
    }

    /**
     * @throws Exception
     */
    public function save(string $uuid, array $request): LoanRepaymentJson|JsonResponse|null
    {
        $this->loanModel = $this->loanRepo->getModel($uuid);
        // Check if the Loan is Fully Paid
        if ($this->loanModel->is_fully_paid) {
            $amount = Arr::get($request, 'amount', $this->loanModel->emi);
            // Check if the payment amount is more the balance
            if ($amount > $this->loanModel->total_balance_amount) {
                throw new \Exception('Loan EMI cant be more than ' . $this->loanModel->total_balance_amount);
            }

            $request['loan_application_id'] = $this->loanModel->uuid;
            $request['amount'] = $amount;
            return new LoanRepaymentJson($this->saveOrUpdatePage($request));
        }
        throw new \Exception('Loan EMI Fully Paid');
    }

    /**
     * @param array $attributes
     * @return LoanApplication
     * @throws Exception
     */
    protected function saveOrUpdatePage(array $attributes): LoanRepayment
    {
        DB::beginTransaction();
        try {
            $model = LoanRepayment::updateOrCreate(
                [
                    'uuid' => Arr::get($attributes, 'uuid')
                ],
                [
                    'loan_application_id' => LoanApplication::getId($attributes['loan_application_id']),
                    'amount' => Arr::get($attributes, 'amount')
                ]);
            DB::commit();
            return $model;
        } catch (Exception $ex) {
            DB::rollBack();
            throw $ex;
        }
    }

    /**
     * @param string $uuid
     * @return LoanRepaymentJson|null
     */
    public function get(string $uuid): ?LoanRepaymentJson
    {
        $model = $this->getModel($uuid);
        return new LoanRepaymentJson($model);
    }

    /**
     * @param string $uuid
     * @return LoanRepayment|null
     */
    protected function getModel(string $uuid, array $with = []): ?LoanRepayment
    {
        return LoanRepayment::getModel($uuid, $with);
    }

}
