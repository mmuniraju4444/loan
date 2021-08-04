<?php

namespace App\Http\Controllers\API;

use App\Interfaces\ILoanRepaymentRepository;
use App\Repositories\LoanRepaymentRepository;
use Exception;
use Illuminate\Http\Request;

class LoanRepaymentController extends Controller
{
    /**
     * @var LoanRepaymentRepository
     */
    protected $repo;

    /**
     * LoanRepaymentController constructor.
     */
    public function __construct()
    {
        $this->repo = app(ILoanRepaymentRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(string $uuid, Request $request)
    {
        return $this->repo->getAll($uuid, $request->all());
    }

    /**
     * @param Request $request
     * @throws Exception
     */
    public function store(string $uuid, Request $request)
    {
        return $this->repo->save($uuid, $request->all());
    }

    public function show(string $uuid)
    {
        return $this->repo->get($uuid);
    }
}
