<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\User\UserLogin;
use App\Http\Resources\User\UserRegister;
use App\Interfaces\IAuthRepository;
use App\Models\User;
use App\Repositories\AuthRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class AuthController
{
    /**
     * @var AuthRepository
     */
    protected $repo;

    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->repo = app(IAuthRepository::class);
    }

    /**
     * Applicant User Register
     *
     * @param Request $request
     * @return UserRegister|JsonResponse
     */
    public function registerApplicant(Request $request)
    {
        return $this->repo->register($request->all(), User::TYPE_APPLICANT);
    }

    /**
     * Approver User Register
     *
     * @param Request $request
     * @return UserRegister|JsonResponse
     */
    public function registerApprover(Request $request)
    {
        return $this->repo->register($request->all(), User::TYPE_APPROVER);
    }

    /**
     *  User Login
     * @param Request $request
     * @return UserLogin|JsonResponse
     */
    public function login(Request $request)
    {
        return $this->repo->login($request->all());
    }
}
