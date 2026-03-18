<?php

namespace App\Http\Controllers;

use App\Models\Grades;
use Illuminate\Http\Request;

class GradesController extends Controller
{

    public function index()
    {
        return response()->json(Grades::all());
    }

    public function show($id)
    {
        $grades = Grades::findOrFail($id);
        return response()->json($grades);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $grades = Grades::create($validated);
        return response()->json($grades, 201);
    }

    public function update(Request $request, $id)
    {
        $grades = Grades::findOrFail($id);
        $validated = $request->validate($this->rules());
        $grades->update($validated);
        return response()->json($grades);
    }

    public function destroy($id)
    {
        $grades = Grades::findOrFail($id);
        $grades->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    private function rules()
    {
        return [
            'enrollment_id' => 'required',
            'grade' => 'nullable',
            'letter_grade' => 'nullable',
            'graded_at' => 'required',
            'comment' => 'nullable'
        ];
    }
}
