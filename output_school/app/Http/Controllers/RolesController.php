<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;

class RolesController extends Controller
{

    public function index()
    {
        return response()->json(Roles::all());
    }

    public function show($id)
    {
        $roles = Roles::findOrFail($id);
        return response()->json($roles);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $roles = Roles::create($validated);
        return response()->json($roles, 201);
    }

    public function update(Request $request, $id)
    {
        $roles = Roles::findOrFail($id);
        $validated = $request->validate($this->rules());
        $roles->update($validated);
        return response()->json($roles);
    }

    public function destroy($id)
    {
        $roles = Roles::findOrFail($id);
        $roles->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    private function rules()
    {
        return [
            'name' => 'required',
            'description' => 'nullable'
        ];
    }
}
