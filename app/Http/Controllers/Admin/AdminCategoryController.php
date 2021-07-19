<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminCategoryController extends Controller
{
    //
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->paginate(10);
        return view(
            'admin.category.adminCategory',
            [
                'categories' => $categories,
            ]
        );
    }
    public function create()
    {
        //
        return view('admin.category.createCategory');
    }
    public function store(Request $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->desc = $request->desc;
        $category->save();
        return redirect()->route('adminCategory.index');
    }

    public function destroy($id)
    {
        $productincategory = Product::where('category_id', $id)->get();

        foreach ($productincategory as $product) {
            $product->deleted_at = Carbon::now()->date;
            $product->category_id = null;
            $product->save();
        }

        Category::where('id', $id)->delete();
        return redirect()->route('adminCategory.index');
    }

    public function edit($id)
    {
        return  view(
            'admin.category.editCategory',
            [
                'category' => Category::findOrFail($id),
            ]
        );
    }
    public function update(Request $request, $id)
    {
        Category::where('id', $id)->update(['name' => $request->name, 'desc' => $request->desc]);
        return redirect()->route('adminCategory.index');
    }
}
