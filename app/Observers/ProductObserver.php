<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductObserver
{

    public function creating(Product $product)
    {
        if (Auth::check()) {
            $product->created_by = Auth::user()->name;
        }
    }

    public function updating(Product $product)
    {
        if (Auth::check()) {
            $product->updated_by = Auth::user()->name;
        }
    }
}
