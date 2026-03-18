<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{

    public function index()
    {
        return response()->json(Payments::all());
    }

    public function show($id)
    {
        $payments = Payments::findOrFail($id);
        return response()->json($payments);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $payments = Payments::create($validated);
        return response()->json($payments, 201);
    }

    public function update(Request $request, $id)
    {
        $payments = Payments::findOrFail($id);
        $validated = $request->validate($this->rules());
        $payments->update($validated);
        return response()->json($payments);
    }

    public function destroy($id)
    {
        $payments = Payments::findOrFail($id);
        $payments->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    private function rules()
    {
        return [
            'student_id' => 'required',
            'amount' => 'required',
            'payment_date' => 'required',
            'method' => 'required',
            'status' => 'nullable',
            'reference' => 'nullable'
        ];
    }
}
