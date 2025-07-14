<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with('divisions');

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        };

        if ($request->has('divisions_id')) {
            $query->where('division_id', $request->divisions_id);
        }

        $employee = $query->paginate(5);

        return response()->json([
            'status' => 'success',
            'message' => 'Get employees success',
            'data' => [
                $employee->items(),
            ],
            'pagination' => [
                'current_page' => $employee->currentPage(),
                'last_page' => $employee->lastPage(),
                'per_page' => $employee->perPage(),
                'total_page' => $employee->total(),
            ]
        ]);
    }

    public function show(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'message' => 'Get employee success',
            'data' => [
                $employee
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'position' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'image' => 'nullable|string',
            'divisions' => 'required|exist:divisions_id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 422);
        };

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('employee', 'public');
        }

        $employee = Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'image' => $imagePath,
            'phone' => $request->phone,
            'divisions_id' => $request->divisions,
            'positions' => $request->position
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Create employee success',
            'data' => [
                $employee
            ]

        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'position' => 'required|string|max:255',
            'divisions' => 'required|exist:divisions_id',
            'phone' => 'required|string|max:20',
            'image' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 422);
        };

        $employee = Employee::findOrFail($id);

        $imagePath = null;
        if ($request->hasFile('image')) {
            if ($employee->image) {
                Storage::disk('public')->delete($employee->image);
            };

            $employee->image = $request->file('image')->store('employee', 'public');
        }

        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'divisions_id' => $request->divisions,
            'image' => $imagePath,
            'positions' => $request->position
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Update employee'
        ]);
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);

        if ($employee->image) {
            Storage::disk('public')->delete($employee->image);
        }

        $employee->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Delete employee success',
        ]);
    }
}
