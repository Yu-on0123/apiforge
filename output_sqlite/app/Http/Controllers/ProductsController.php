<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{

    public function index()
    {
        return response()->json(Products::all());
    }

    public function show($id)
    {
        $products = Products::findOrFail($id);
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $products = Products::create($validated);
        return response()->json($products, 201);
    }

    public function update(Request $request, $id)
    {
        $products = Products::findOrFail($id);
        $validated = $request->validate($this->rules());
        $products->update($validated);
        return response()->json($products);
    }

    public function destroy($id)
    {
        $products = Products::findOrFail($id);
        $products->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    private function rules()
    {
        return [
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required'
        ];
    }
}
