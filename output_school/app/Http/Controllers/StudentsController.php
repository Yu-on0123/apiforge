<?php

namespace App\Http\Controllers;

use App\Models\Students;
use Illuminate\Http\Request;

class StudentsController extends Controller
{

    public function index()
    {
        return response()->json(Students::all());
    }

    public function show($id)
    {
        $students = Students::findOrFail($id);
        return response()->json($students);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $students = Students::create($validated);
        return response()->json($students, 201);
    }

    public function update(Request $request, $id)
    {
        $students = Students::findOrFail($id);
        $validated = $request->validate($this->rules());
        $students->update($validated);
        return response()->json($students);
    }

    public function destroy($id)
    {
        $students = Students::findOrFail($id);
        $students->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    private function rules()
    {
        return [
            'user_id' => 'required',
            'student_code' => 'required',
            'department_id' => 'nullable',
            'enrollment_year' => 'required',
            'status' => 'nullable'
        ];
    }
}
