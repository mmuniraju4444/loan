<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\LoanApplication\LoanApplicationIndex;
use App\Interfaces\ILoanRepository;
use App\Repositories\LoanRepository;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * @var LoanRepository
     */
    protected $repo;

    /**
     * LoanController constructor.
     */
    public function __construct()
    {
        $this->repo = app(ILoanRepository::class);

    }

    /**
     * Display a listing of the resource.
     *
     * @return LoanApplicationIndex
     */
    public function index(Request $request)
    {
        return $this->repo->getAll($request->all());
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        return $this->repo->save($request->all());
    }

    /**
     * @param Request $request
     */
    public function status(string $uuid, Request $request)
    {
        return $this->repo->updateStatus($uuid, $request->all());
    }

    /**
     * @param Request $request
     */
    public function show(string $uuid)
    {
        return $this->repo->get($uuid);
    }
}
