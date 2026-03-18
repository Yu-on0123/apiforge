<?php

namespace App\Http\Controllers;

use App\Models\Enrollments;
use Illuminate\Http\Request;

class EnrollmentsController extends Controller
{

    public function index()
    {
        return response()->json(Enrollments::all());
    }

    public function show($id)
    {
        $enrollments = Enrollments::findOrFail($id);
        return response()->json($enrollments);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $enrollments = Enrollments::create($validated);
        return response()->json($enrollments, 201);
    }

    public function update(Request $request, $id)
    {
        $enrollments = Enrollments::findOrFail($id);
        $validated = $request->validate($this->rules());
        $enrollments->update($validated);
        return response()->json($enrollments);
    }

    public function destroy($id)
    {
        $enrollments = Enrollments::findOrFail($id);
        $enrollments->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    private function rules()
    {
        return [
            'student_id' => 'required',
            'course_id' => 'required',
            'enrolled_at' => 'required',
            'status' => 'nullable'
        ];
    }
}
