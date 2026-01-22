<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DivisionResource;
use App\Models\MemberField;
use Illuminate\Http\Request;

class DivisionController extends Controller
{
    public function index()
    {
        try {
            $divisions = MemberField::all();
            return response()->json([
                'response' => 200,
                'success' => true,
                'message' => 'Divisions retrieved successfully',
                'data' => DivisionResource::collection($divisions)
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'response' => 500,
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
