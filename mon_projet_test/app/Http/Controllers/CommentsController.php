<?php

namespace App\Http\Controllers;

use App\Models\Comments;
use Illuminate\Http\Request;

class CommentsController extends Controller
{

    public function index()
    {
        return response()->json(Comments::all());
    }

    public function show($id)
    {
        $comments = Comments::findOrFail($id);
        return response()->json($comments);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $comments = Comments::create($validated);
        return response()->json($comments, 201);
    }

    public function update(Request $request, $id)
    {
        $comments = Comments::findOrFail($id);
        $validated = $request->validate($this->rules());
        $comments->update($validated);
        return response()->json($comments);
    }

    public function destroy($id)
    {
        $comments = Comments::findOrFail($id);
        $comments->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    private function rules()
    {
        return [
            'content' => 'required',
            'user_id' => 'required',
            'post_id' => 'required'
        ];
    }
}
