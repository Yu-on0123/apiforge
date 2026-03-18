<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;

class PostsController extends Controller
{

    public function index()
    {
        return response()->json(Posts::all());
    }

    public function show($id)
    {
        $posts = Posts::findOrFail($id);
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $posts = Posts::create($validated);
        return response()->json($posts, 201);
    }

    public function update(Request $request, $id)
    {
        $posts = Posts::findOrFail($id);
        $validated = $request->validate($this->rules());
        $posts->update($validated);
        return response()->json($posts);
    }

    public function destroy($id)
    {
        $posts = Posts::findOrFail($id);
        $posts->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    private function rules()
    {
        return [
            'title' => 'required',
            'content' => 'required',
            'user_id' => 'required',
            'category_id' => 'required'
        ];
    }
}
