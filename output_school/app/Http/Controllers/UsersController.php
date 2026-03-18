<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;

class UsersController extends Controller
{

    public function index()
    {
        return response()->json(Users::all());
    }

    public function show($id)
    {
        $users = Users::findOrFail($id);
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $users = Users::create($validated);
        return response()->json($users, 201);
    }

    public function update(Request $request, $id)
    {
        $users = Users::findOrFail($id);
        $validated = $request->validate($this->rules());
        $users->update($validated);
        return response()->json($users);
    }

    public function destroy($id)
    {
        $users = Users::findOrFail($id);
        $users->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    private function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'phone' => 'nullable',
            'is_active' => 'nullable'
        ];
    }
}
