<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;

class OrdersController extends Controller
{

    public function index()
    {
        return response()->json(Orders::all());
    }

    public function show($id)
    {
        $orders = Orders::findOrFail($id);
        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $orders = Orders::create($validated);
        return response()->json($orders, 201);
    }

    public function update(Request $request, $id)
    {
        $orders = Orders::findOrFail($id);
        $validated = $request->validate($this->rules());
        $orders->update($validated);
        return response()->json($orders);
    }

    public function destroy($id)
    {
        $orders = Orders::findOrFail($id);
        $orders->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

    private function rules()
    {
        return [
            'product_id' => 'required',
            'quantity' => 'required',
            'total' => 'required'
        ];
    }
}
