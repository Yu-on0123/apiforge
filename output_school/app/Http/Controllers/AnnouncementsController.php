<?php

namespace App\Http\Controllers;

use App\Models\Announcements;
use Illuminate\Http\Request;

class AnnouncementsController extends Controller
{

    public function index()
    {
        return response()->json(Announcements::all());
    }

    public function show($id)
    {
        $announcements = Announcements::findOrFail($id);
        return response()->json($announcements);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $announcements = Announcements::create($validated);
        return response()->json($announcements, 201);
    }

    public function update(Request $request, $id)
    {
        $announcements = Announcements::findOrFail($id);
        $validated = $request->validate($this->rules());
        $announcements->update($validated);
        return response()->json($announcements);
    }

    public function destroy($id)
    {
        $announcements = Announcements::findOrFail($id);
        $announcements->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    private function rules()
    {
        return [
            'course_id' => 'required',
            'teacher_id' => 'required',
            'title' => 'required',
            'content' => 'required',
            'is_pinned' => 'nullable'
        ];
    }
}
