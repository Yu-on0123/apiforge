<?php

namespace App\Http\Controllers;

use App\Models\UserRoles;
use Illuminate\Http\Request;

class UserRolesController extends Controller
{

    public function index()
    {
        return response()->json(UserRoles::all());
    }

    public function show($id)
    {
        $user_roles = UserRoles::findOrFail($id);
        return response()->json($user_roles);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $user_roles = UserRoles::create($validated);
        return response()->json($user_roles, 201);
    }

    public function update(Request $request, $id)
    {
        $user_roles = UserRoles::findOrFail($id);
        $validated = $request->validate($this->rules());
        $user_roles->update($validated);
        return response()->json($user_roles);
    }

    public function destroy($id)
    {
        $user_roles = UserRoles::findOrFail($id);
        $user_roles->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    private function rules()
    {
        return [
            'user_id' => 'required',
            'role_id' => 'required',
            'assigned_at' => 'required'
        ];
    }
}
