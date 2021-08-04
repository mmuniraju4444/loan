<?php

namespace App\Services\Traits;

use App\Scope\UserScope;

trait UserDataOnly
{
    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope(new UserScope());
    }
}