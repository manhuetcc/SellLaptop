<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    //get all category by id
    public function show($id)
    {
        $category = Category::find($id);
        $totalProducts = DB::table('categories')
            ->selectRaw('count(*) as total')
            ->join('products', 'categories.id', '=', 'products.category_id')
            ->where('categories.id', $id)
            ->whereNull('deleted_at')
            ->get();

        return $category;
    }
}
