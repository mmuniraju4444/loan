<?php


namespace App\Http\Controllers\API;


use App\Interfaces\ILoanInterestRepository;
use App\Repositories\LoanInterestRepository;
use Illuminate\Http\Request;

class LoanInterestController extends Controller
{
    /**
     * @var LoanInterestRepository
     */
    protected $repo;

    /**
     * LoanInterestController constructor.
     */
    public function __construct()
    {
        $this->repo = app(ILoanInterestRepository::class);
    }

    /**
     * Display active listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        return $this->repo->getAll($request->all());
    }
}
