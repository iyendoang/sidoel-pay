<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryObserver
{

    public function creating(Category $category)
    {
        if (Auth::check()) {
            $category->created_by = Auth::user()->name;
        }
    }

    public function updating(Category $category)
    {
        if (Auth::check()) {
            $category->updated_by = Auth::user()->name;
        }
    }
}
