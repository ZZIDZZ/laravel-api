<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $products = Product::all();
        return $products;
    }
    public function store()
    {
        $validator = Validator::make(request()->all(), [
            'product_code' => 'required|unique:products',
            'product_name' => 'required|max:100',
            'uom_id' => 'required|exists:uoms,id',
            'unit_price' => 'required',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
        
        $product = new Product();
        $product->product_code = request("product_code", "");
        $product->product_name = request("product_name", "");
        $product->uom_id = request("uom_id", "");
        $product->description = request("description", "");
        $product->unit_price = request("unit_price", "");
        $product->save();
        return $product;
    }
    public function update($id)
    {
        $product = Product::find($id);
        $validator = Validator::make(request()->all(), [
            'product_code' => 'required|unique:products,product_code,'.$product->id,
            'product_name' => 'required|max:100',
            'uom_id' => 'required|exists:uoms,id',
            'unit_price' => 'required',
        ]);
 
        if ($validator->fails()) {
            return $validator->errors();
        }
        $product->product_code = request("product_code", "");
        $product->product_name = request("product_name", "");
        $product->uom_id = request("uom_id", "");
        $product->description = request("description", "");
        $product->unit_price = request("unit_price", "");
        $product->save();
        return $product;
    }
    public function delete($id)
    {
        $product = Product::find($id);
        $product->delete();
        return[
            "msg" => "product deleted succesfully"
        ];
    }
}
