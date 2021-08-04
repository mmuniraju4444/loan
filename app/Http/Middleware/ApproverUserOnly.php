<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class ApproverUserOnly
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->type == User::TYPE_APPROVER)
            return $next($request);
        return response()->json(['status' => false, 'message' => 'Not a Valid user']);
    }
}
