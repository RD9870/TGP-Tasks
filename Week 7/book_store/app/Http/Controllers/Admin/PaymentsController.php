<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PaymentMethod::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string'],
        ]);
        $newMethod = PaymentMethod::create($data);
        return response()-> json(
            [
                "message" => "new payment method was created",
                "data" => $newMethod,
            ],
            201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return PaymentMethod::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $method = PaymentMethod::findOrFail($id);
        $data = request()->validate([
            'name' => 'required | string',
        ]);
        $method->update($data);

        return response()->json([
            'message' => "the paymeny method with id: $id was updated",
            'data' => $method,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $method = PaymentMethod::findOrFail($id);
        $method->delete();
        return response()->json([
                'message' => "the paymeny method with id: $id was deleted",
        ]);
    }
}
