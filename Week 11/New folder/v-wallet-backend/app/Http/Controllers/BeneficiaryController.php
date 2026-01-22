<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\beneficiariesValidation;
class BeneficiaryController extends Controller
{
     public function index()
    {
        return Beneficiary::with('beneficiary')
            ->where('user_id', Auth::id())
            ->get();
    }
public function store(beneficiariesValidation $request)
{
    $userId = Auth::id();

    if (!$userId) {
        return response()->json([
            'message' => 'Unauthorized.'
        ], 401);
    }

    $data = $request->validated();

    $beneficiaryUser = User::where('phone', $data['phone'])->first();

    if (!$beneficiaryUser) {
        return response()->json([
            'message' => 'User with this phone does not exist.'
        ], 404);
    }

    if ($beneficiaryUser->id === $userId) {
        return response()->json([
            'message' => 'You cannot add yourself as a beneficiary.'
        ], 400);
    }

    if (Beneficiary::where('user_id', $userId)
        ->where('beneficiary_id', $beneficiaryUser->id)
        ->exists()) {

        return response()->json([
            'message' => 'Beneficiary already exists.'
        ], 409);
    }

    $beneficiary = Beneficiary::create([
        'user_id' => $userId,
        'beneficiary_id' => $beneficiaryUser->id,
    ]);

    return response()->json([
        'message' => 'Beneficiary added successfully.',
        'data' => $beneficiary
    ], 201);
}


     public function show($id)
    {
        return Beneficiary::where('user_id', Auth::id())
            ->with('beneficiary')
            ->findOrFail($id);
    }

  public function destroy($beneficiaryId)
{
    $beneficiary = Beneficiary::where('user_id', Auth::id())
        ->where('beneficiary_id', $beneficiaryId)
        ->first();

    if (!$beneficiary) {
        return response()->json([
            'message' => 'Beneficiary not found for this user.'
        ], 404);
    }

    $beneficiary->delete();

    return response()->json([
        'message' => 'Beneficiary removed successfully.'
    ]);
}

}
