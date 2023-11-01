<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    public function creating(User $user)
    {
        if (Auth::check()) {
            $user->created_by = Auth::user()->name;
        }
    }

    public function updating(User $user)
    {
        if (Auth::check()) {
            $user->updated_by = Auth::user()->name;
        }
    }
}
