<?php

namespace App\Http\Controllers;

use App\Models\Teachers;
use Illuminate\Http\Request;

class TeachersController extends Controller
{

    public function index()
    {
        return response()->json(Teachers::all());
    }

    public function show($id)
    {
        $teachers = Teachers::findOrFail($id);
        return response()->json($teachers);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $teachers = Teachers::create($validated);
        return response()->json($teachers, 201);
    }

    public function update(Request $request, $id)
    {
        $teachers = Teachers::findOrFail($id);
        $validated = $request->validate($this->rules());
        $teachers->update($validated);
        return response()->json($teachers);
    }

    public function destroy($id)
    {
        $teachers = Teachers::findOrFail($id);
        $teachers->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    private function rules()
    {
        return [
            'user_id' => 'required',
            'department_id' => 'required',
            'specialization' => 'nullable',
            'hire_date' => 'required',
            'salary' => 'nullable'
        ];
    }
}
