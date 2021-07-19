<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    //get all category by id
    public function index()
    {
        return Category::all();
    }

    public function productInCategory($id)
    {
        $category = DB::table('products')
            ->where('category_id', $id)
            ->whereNull('deleted_at')
            ->paginate(20);
        return $category;
    }
    public function show($id)
    {
        $category = Category::find($id);
        return $category;
    }
}
