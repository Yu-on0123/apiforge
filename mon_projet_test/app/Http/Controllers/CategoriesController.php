<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{

    public function index()
    {
        return response()->json(Categories::all());
    }

    public function show($id)
    {
        $categories = Categories::findOrFail($id);
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $categories = Categories::create($validated);
        return response()->json($categories, 201);
    }

    public function update(Request $request, $id)
    {
        $categories = Categories::findOrFail($id);
        $validated = $request->validate($this->rules());
        $categories->update($validated);
        return response()->json($categories);
    }

    public function destroy($id)
    {
        $categories = Categories::findOrFail($id);
        $categories->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    private function rules()
    {
        return [
            'name' => 'required',
            'description' => 'required'
        ];
    }
}
