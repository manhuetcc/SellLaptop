<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InfoProduct;
use App\Models\Product;

class AdminInfoProductController extends Controller
{
    public function listInfo(Request $request, $product_id)
    {
        $listInfo = InfoProduct::where('product_id', $product_id)
            ->get();
        $product = Product::where('id', $product_id)
            ->get()->first();
        return view(
            'admin.infoProduct.adminInfoProduct',
            [
                'listInfo' => $listInfo,
                'product' => $product
            ]
        );
    }
    //
    public function createInfo(Request $request, $product_id)
    {
        $info = new InfoProduct();
        $info->fill([
            'product_id' => $product_id,
            'property' => $request->attribute,
            'feature' => $request->information,
        ])->save();
        return redirect()->route('listInfoProduct', $product_id);
    }
    //
    public function updateInfo(Request $request, $product_id, $info_id)
    {
        InfoProduct::where('id', $info_id)
            ->update([
                'property' => $request->property,
                'feature' => $request->feature,
            ]);
        return redirect()->route('listInfoProduct', $product_id);
    }
    //
    public function editInfo($product_id, $info_id)
    {
        return view('admin.infoProduct.editInfoProduct', [
            'product' => Product::where('id', $product_id)->get()->first(),
            'info' => InfoProduct::Where('id', $info_id)->get()->first(),
        ]);
    }
    //
    public function delete($product_id, $info_id)
    {
        InfoProduct::where('product_id', $product_id)
            ->where('id', $info_id)
            ->delete();
        return redirect()->route('listInfoProduct', $product_id);
    }
}
