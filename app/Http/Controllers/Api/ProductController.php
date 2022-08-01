<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json([
        "success" => true,
        "message" => "Product List",
        "data" => $products
        ]);
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $uuid = (string) Str::uuid();
        $request->validate([
        'name' => 'required',
        'type' => 'required',
        'price' => 'required',
        'quantity' => 'required'
        ]);


        $product = Product::create([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'uuid' => $uuid ,
        ]);
        return response()->json([
        "success" => true,
        "message" => "Product created successfully.",
        "data" => $product
        ]);
    }

    public function update(Request $request, Product $product){
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'price' => 'required',
            'quantity' => 'required',
        ]);
        $uuid = (string) Str::uuid();
        $product = Product::findOrFail($product->id);
        $product -> update([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'uuid' => $uuid ,
        ]);
        return response()->json([
            "success" => true,
            "message" => "Product Update successfully.",
            "data" => $product
        ]);

    }

    public function show($uuid)
    {
        $product = Product::find($uuid);
        if (is_null($product)) {
        return response()->json([
            "success" => false,
            "message" => "Product Null.",
            ]);
        }
        return response()->json([
        "success" => true,
        "message" => "Product retrieved successfully.",
        "data" => $product
        ]);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([
        "success" => true,
        "message" => "Product deleted successfully.",
        "data" => $product
    ]);
}
}
