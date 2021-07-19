<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    //lay toan bo san pham
    public function show($id)
    {
        $product = Product::find($id);
        return response()->json([
            $product,
        ]);
    }
    public function index(Request $request)
    {
        if ($request->key) {
            $result = DB::table('products')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->select('categories.name as category_name', 'products.*')
                ->whereNull('products.deleted_at')
                ->where(function ($query) {
                    global $request;
                    $query->where('categories.name', 'like', "%$request->key%")
                        ->orWhere('products.name', 'like', "%$request->key%");
                })
                ->orderBy('products.updated_at')
                ->paginate(20);
            return $result;
        }
        return Product::orderBy('id')->paginate(20);
    }

    //api get info product by id
    public function prodDetail($id)
    {
        $product = Product::find($id);
        return response()->json([
            $product,
            $product->status_product,
            $product->category,
            $product->info_products,
        ]);
    }

    //get all comment in 1 product
    public function comment($id)
    {
        $comment = DB::table('comments')
            ->join('users', 'users.id', '=', 'comments.user_id')
            ->select('comments.id', 'comments.id', 'users.name', 'comments.content', 'comments.created_at')
            ->where('comments.product_id', '=', $id)
            ->orderBy('id')
            ->get();
        return $comment;
    }

    //post comment
    public function postComment(Request $request)
    {
        $comment = new Comment();
        $comment->user_id = $request->user_id;
        $comment->product_id = $request->product_id;
        $comment->content = $request->content;
        $comment->save();
        return;
    }

    public function hotProduct()
    {
        $topProduct = DB::table('products')
            ->selectRaw('products.id, sum(orders.quantity) as totalsell')
            ->join('orders', 'products.id', '=', 'orders.product_id')
            ->whereNull('products.deleted_at')
            ->groupBy('products.id')
            ->orderByDesc('totalsell')
            ->take(4)
            ->get();

        $infoProduct = DB::table('products')
            ->whereIn('id', $topProduct->pluck('id'))
            ->get();
        return $infoProduct;
    }

    //api get san pham moi
    public function newProduct()
    {
        $newproduct = DB::table('products')
            ->whereNull('deleted_at')
            ->orderBy('id', 'desc')
            ->take(4)
            ->get();
        return $newproduct;
    }
}
