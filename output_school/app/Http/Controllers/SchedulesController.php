<?php

namespace App\Http\Controllers;

use App\Models\Schedules;
use Illuminate\Http\Request;

class SchedulesController extends Controller
{

    public function index()
    {
        return response()->json(Schedules::all());
    }

    public function show($id)
    {
        $schedules = Schedules::findOrFail($id);
        return response()->json($schedules);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $schedules = Schedules::create($validated);
        return response()->json($schedules, 201);
    }

    public function update(Request $request, $id)
    {
        $schedules = Schedules::findOrFail($id);
        $validated = $request->validate($this->rules());
        $schedules->update($validated);
        return response()->json($schedules);
    }

    public function destroy($id)
    {
        $schedules = Schedules::findOrFail($id);
        $schedules->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    private function rules()
    {
        return [
            'course_id' => 'required',
            'classroom_id' => 'required',
            'day_of_week' => 'required',
            'start_time' => 'required',
            'end_time' => 'required'
        ];
    }
}
