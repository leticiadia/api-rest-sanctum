<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all();
        return response($product, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'price' => 'required'
        ]);

        $product = Product::create($request->all());

        return response(['message' => $product], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        return response($product, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if(empty($product)) {
            return response(['message' => 'Product not found'], 404);
        }

        $product->update($request->all());

        return response($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        Product::destroy($id);

        if(empty($product)) {
            return response(['message' => 'Product not found'], 404);
        }

        return response(['message' => 'Product deleted successfully'], 200);

    }
    
    /**
     * Search for a name
     *
     * @param str $name  
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $params = $request->name;
        $search = Product::where('name', 'like', '%'.$params.'%')->get();
        return $search;
    }
}
