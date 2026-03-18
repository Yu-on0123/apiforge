<?php

namespace App\Http\Controllers;

use App\Models\Assignments;
use Illuminate\Http\Request;

class AssignmentsController extends Controller
{

    public function index()
    {
        return response()->json(Assignments::all());
    }

    public function show($id)
    {
        $assignments = Assignments::findOrFail($id);
        return response()->json($assignments);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $assignments = Assignments::create($validated);
        return response()->json($assignments, 201);
    }

    public function update(Request $request, $id)
    {
        $assignments = Assignments::findOrFail($id);
        $validated = $request->validate($this->rules());
        $assignments->update($validated);
        return response()->json($assignments);
    }

    public function destroy($id)
    {
        $assignments = Assignments::findOrFail($id);
        $assignments->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    private function rules()
    {
        return [
            'course_id' => 'required',
            'title' => 'required',
            'description' => 'nullable',
            'due_date' => 'required',
            'max_score' => 'nullable'
        ];
    }
}
