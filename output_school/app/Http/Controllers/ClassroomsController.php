<?php

namespace App\Http\Controllers;

use App\Models\Classrooms;
use Illuminate\Http\Request;

class ClassroomsController extends Controller
{

    public function index()
    {
        return response()->json(Classrooms::all());
    }

    public function show($id)
    {
        $classrooms = Classrooms::findOrFail($id);
        return response()->json($classrooms);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $classrooms = Classrooms::create($validated);
        return response()->json($classrooms, 201);
    }

    public function update(Request $request, $id)
    {
        $classrooms = Classrooms::findOrFail($id);
        $validated = $request->validate($this->rules());
        $classrooms->update($validated);
        return response()->json($classrooms);
    }

    public function destroy($id)
    {
        $classrooms = Classrooms::findOrFail($id);
        $classrooms->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    private function rules()
    {
        return [
            'name' => 'required',
            'capacity' => 'required',
            'location' => 'nullable',
            'has_projector' => 'nullable'
        ];
    }
}
