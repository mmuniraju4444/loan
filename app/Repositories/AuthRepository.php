<?php

namespace App\Repositories;

use App\Http\Resources\User\UserLogin;
use App\Http\Resources\User\UserRegister;
use App\Interfaces\IAuthRepository;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthRepository implements IAuthRepository
{
    /**
     * User Register
     *
     * @param Request $request
     * @return UserRegister|JsonResponse
     */
    public function register(array $request, string $userType = 'Applicant')
    {
        $rules = [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ];

        $input = Arr::only($request, ['name', 'email', 'password']);
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            throw new \Exception('Validation Fail! Missing Fields - ' . implode(',', $validator->getMessageBag()->keys()));
        }
        $name = $request['name'];
        $email = $request['email'];
        $password = $request['password'];
        $user = User::where('email', $email)->first();
        if(!empty($user)) {
            throw new \Exception("Email {$email} Already Exist");
        }
        $user = User::create(['name' => $name, 'email' => $email, 'password' => Hash::make($password), 'type' => $userType]);
        return new UserRegister($user);

    }

    /**
     * User Login
     * @param array $request
     * @return UserLogin|JsonResponse
     */
    public function login(array $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];

        $input = Arr::only($request, ['email', 'password']);

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            throw new \Exception('Validation Fail!');
        }

        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            $user = Auth::user();
            $token = Str::uuid();
            $user->api_token = $token;
            if ($user->save()) {
                return new UserLogin($user);
            }
            throw new \Exception('Failed to Generate Login Token!');
        }
        throw new \Exception('Invalid Email or Password!');
    }
}
