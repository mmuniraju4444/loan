<?php

namespace App\Scope;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\App;

class UserScope implements Scope
{

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param Builder $builder
     * @param Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if (!App::runningInConsole() && !auth()->user()->type == User::TYPE_APPROVER) {
            $builder->where($model->getTable() . '.user_id', '=', auth()->user()->id);
        }
    }
}
