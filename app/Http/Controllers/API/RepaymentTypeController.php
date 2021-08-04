<?php


namespace App\Http\Controllers\API;


use App\Interfaces\IRepaymentTypeRepository;
use App\Repositories\RepaymentTypeRepository;
use Illuminate\Http\Request;

class RepaymentTypeController extends Controller
{
    /**
     * @var RepaymentTypeRepository
     */
    protected $repo;

    /**
     * RepaymentTypeController constructor.
     */
    public function __construct()
    {
        $this->repo = app(IRepaymentTypeRepository::class);
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
