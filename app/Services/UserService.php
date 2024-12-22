<?php

namespace App\Services;

use Illuminate\Contracts\Auth\Authenticatable;

class UserService
{
    public function getCurrentUser(): ?Authenticatable
    {
        return auth()->user();
    }
}