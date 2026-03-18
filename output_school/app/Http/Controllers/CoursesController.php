<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use Illuminate\Http\Request;

class CoursesController extends Controller
{

    public function index()
    {
        return response()->json(Courses::all());
    }

    public function show($id)
    {
        $courses = Courses::findOrFail($id);
        return response()->json($courses);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $courses = Courses::create($validated);
        return response()->json($courses, 201);
    }

    public function update(Request $request, $id)
    {
        $courses = Courses::findOrFail($id);
        $validated = $request->validate($this->rules());
        $courses->update($validated);
        return response()->json($courses);
    }

    public function destroy($id)
    {
        $courses = Courses::findOrFail($id);
        $courses->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    private function rules()
    {
        return [
            'title' => 'required',
            'code' => 'required',
            'description' => 'nullable',
            'credits' => 'required',
            'department_id' => 'required',
            'teacher_id' => 'required',
            'max_students' => 'nullable',
            'is_active' => 'nullable'
        ];
    }
}
