<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Schema;
use App\Models\Category;
use App\Models\StatusProduct;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminProductController extends Controller
{
    //get all products
    public function index(Request $request)
    {
        $selectCategory = 0;
        if ($request->category) {
            $selectCategory = $request->category;
        }
        if ($selectCategory == 0) {
            $products = Product::orderBy('id', 'desc')->get();
        } else {
            $categoryid = $request->category;
            $products = Product::where('category_id', $categoryid)->orderBy('id', 'desc')->get();
        }
        $images = DB::table('products')->select('image')->get();
        //dd($images);
        return view(
            'admin.product.adminProduct',
            [
                'products' => $products,
                'categories' => Category::all(),
                'current_category' => $selectCategory,
                'images' => json_decode($images),
            ]
        );
    }

    public function create(Request $request)
    {
        return view(
            'admin.product.createProduct',
            [
                'categories' => Category::all(),
                'status_products' => StatusProduct::all(),
            ]
        );
    }
    public function store(Request $request)
    {
        $request->validate([
            'filenames' => 'required',
            'filenames.*' => 'mimes:jpeg,jpg,png,gif,csv,txt,pdf|max:2048'
        ]);

        if ($request->hasfile('filenames')) {
            foreach ($request->file('filenames') as $key => $file) {
                if ($key === array_key_first($request->file('filenames'))) {
                    $thumbnail = $file->getClientOriginalName();
                }
                $name = $file->getClientOriginalName();
                $file->move(public_path() . '/uploads/imagesProduct/', $name);
                $imgData[] = $name;
            }
        }
        $product = new Product;
        $product->fill([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'image' => json_encode($imgData),
            'thumbnail' => $thumbnail,
            'desc' => $request->desc,
            'price' => $request->price,
            'status_product_id' => $request->status_product_id,
        ])->save();

        return redirect()->route('listInfoProduct', $product->id);
    }
    public function edit($id)
    {
        return view(
            'admin\product\editproduct',
            [
                'product' => Product::findOrFail($id),
                'images' => json_decode(Product::findOrFail($id)->image),
                'categories' => Category::all(),
                'status_products' => StatusProduct::all(),
            ]
        );
    }

    public function update(Request $request, $product_id)
    {
        Product::where('id', $product_id)
            ->update([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'short_desc' => $request->short_desc,
                'price' => $request->price,
                'status_product_id' => $request->status_product_id,
            ]);
        return redirect()->route('adminProduct.index');
    }
    public function destroy($id)
    {
        Product::where('id', $id)->delete();
        return redirect()->route('adminProduct.index');;
    }
}
