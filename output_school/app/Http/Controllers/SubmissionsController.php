<?php

namespace App\Http\Controllers;

use App\Models\Submissions;
use Illuminate\Http\Request;

class SubmissionsController extends Controller
{

    public function index()
    {
        return response()->json(Submissions::all());
    }

    public function show($id)
    {
        $submissions = Submissions::findOrFail($id);
        return response()->json($submissions);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $submissions = Submissions::create($validated);
        return response()->json($submissions, 201);
    }

    public function update(Request $request, $id)
    {
        $submissions = Submissions::findOrFail($id);
        $validated = $request->validate($this->rules());
        $submissions->update($validated);
        return response()->json($submissions);
    }

    public function destroy($id)
    {
        $submissions = Submissions::findOrFail($id);
        $submissions->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    private function rules()
    {
        return [
            'assignment_id' => 'required',
            'student_id' => 'required',
            'content' => 'nullable',
            'score' => 'nullable',
            'submitted_at' => 'required',
            'is_late' => 'nullable'
        ];
    }
}
