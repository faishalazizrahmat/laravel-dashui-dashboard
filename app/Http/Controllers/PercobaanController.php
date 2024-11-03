<?php

namespace App\Http\Controllers;

use App\Models\Percobaan;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;

class PercobaanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $data = Percobaan::all();
        return response()->json($data);
    }

    public function show($id)
    {
        $data = Percobaan::find($id);

        if (!$data) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jumlah_gerakan' => 'required|string|max:255',
            'waktu_gerakan' => 'required|string|max:255',
            'jarak_perpindahan' => 'required|string|max:255',
            'user_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = Percobaan::create($request->all());

        return response()->json(['message' => 'Data created successfully', 'data' => $data], 201);
    }

    public function update(Request $request, $id)
    {
        $data = Percobaan::find($id);

        if (!$data) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'jumlah_gerakan' => 'sometimes|string|max:255',
            'waktu_gerakan' => 'sometimes|string|max:255',
            'jarak_perpindahan' => 'sometimes|string|max:255',
            'user_id' => 'sometimes|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data->update($request->all());

        return response()->json(['message' => 'Data updated successfully', 'data' => $data]);
    }

    public function destroy($id)
    {
        $data = Percobaan::find($id);

        if (!$data) {
            return response()->json(['error' => 'Data not found'], 404);
        }

        $data->delete();

        return response()->json(['message' => 'Data deleted successfully']);
    }
}
