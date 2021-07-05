<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //lay toan bo san pham
    public function show()
    {
        $allProducts = DB::table('products')
            ->paginate(20);
        return $allProducts;
    }
}
