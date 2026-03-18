<?php

namespace App\Http\Controllers;

use App\Models\Departments;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{

    public function index()
    {
        return response()->json(Departments::all());
    }

    public function show($id)
    {
        $departments = Departments::findOrFail($id);
        return response()->json($departments);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $departments = Departments::create($validated);
        return response()->json($departments, 201);
    }

    public function update(Request $request, $id)
    {
        $departments = Departments::findOrFail($id);
        $validated = $request->validate($this->rules());
        $departments->update($validated);
        return response()->json($departments);
    }

    public function destroy($id)
    {
        $departments = Departments::findOrFail($id);
        $departments->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    private function rules()
    {
        return [
            'name' => 'required',
            'code' => 'required',
            'description' => 'nullable'
        ];
    }
}
