<?php


namespace App\Http\Controllers\API;


use App\Interfaces\ILoanTypeRepository;
use App\Repositories\LoanTypeRepository;
use Illuminate\Http\Request;

class LoanTypeController extends Controller
{
    /**
     * @var LoanTypeRepository
     */
    protected $repo;

    /**
     * LoanTypeController constructor.
     */
    public function __construct()
    {
        $this->repo = app(ILoanTypeRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        return $this->repo->getAll($request->all());
    }
}
