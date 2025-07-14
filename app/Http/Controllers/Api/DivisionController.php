<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\Get(
 *     path="/api/divisions",
 *     summary="Get All Divisions",
 *     tags={"Division"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Parameter(
 *         name="name",
 *         in="query",
 *         description="Filter divisions by name",
 *         required=false,
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of divisions"
 *     )
 * )
 */


class DivisionController extends Controller
{
    public function index(Request $request)
    {
        $query = Division::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $divisions = $query->paginate(5);
        return response()->json([
            'status' => 'success',
            'message' => 'Get divisions success',
            'data' => [
                $divisions->items(),
            ],

            'pagination' => [
                'current_page' => $divisions->currentPage(),
                'last_page' => $divisions->lastPage(),
                'total_page' => $divisions->total(),
                'per_page' => $divisions->perPage(),
            ]

        ]);
    }

    public function show(Request $request, $id)
    {
        $division = Division::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Get division success',
            'data' => [
                $division
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ]);
        }

        $division = Division::create([
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Create division success',
            'data' => [
                $division
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 422);
        }

        $division = Division::findOrFail($id);

        $division->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Update division success',
        ]);
    }

    public function destroy($id)
    {
        $division = Division::findOrFail($id);

        $division->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Delete division success',
        ]);
    }
}
