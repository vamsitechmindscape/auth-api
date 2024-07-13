<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {

        $products = Product::get();

        if ($products) {
            return response()->json($products);
        } else {
            return response()->json(['message' => 'No record available'], 200);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>'All fields are required',
                'error'=>$validator->messages(),
            ],422);
        }

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);
        return response()->json(['message' => 'product is created', 'data' => $product], 200);
    }

    public function show(Product $product)

    {
        return response()->json(['message' => 'product fetched successfully ', 'data' => $product], 200);
    }
    public function update(Request $request, Product $product )
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'message'=>'All fields are required',
                'error'=>$validator->messages(),
            ],422);
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);
        return response()->json(['message' => 'product updated successfully', 'data' => $product], 200);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['message' => 'product Deleted successfully', 'data' => $product], 200);
    }
}
