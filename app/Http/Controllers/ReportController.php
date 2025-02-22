<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{

    public function index(Request $request)
    {
        try {
            // 
            $validated = $request->validate([
                'folder_id' => 'required|exists:folders,id',
            ]);
            // 
            $reports = Report::where('folder_id', $validated['folder_id'])->get();
            // Return the reports
            return response()->json(['reports' => $reports], 200);
            //
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }


    public function show($id)
    {
        try {
            $report = Report::with('folder')->findOrFail($id);
            //
            return response()->json(['report' => $report], 200);
            //
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Report not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }


    public function store(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'folder_id' => 'required|exists:folders,id',
                'user_id' => 'required|exists:users,id',
                'message' => 'required|string|max:500',
            ]);
            // Create a new report
            $report = Report::create($validated);
            //
            return response()->json(['message' => 'Report created successfully', 'report' => $report], 201);
            //
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $report = Report::findOrFail($id);
            // 
            $validated = $request->validate([
                'folder_id' => 'sometimes|required|exists:folders,id',
                'user_id' => 'sometimes|required|exists:users,id',
                'message' => 'sometimes|required|string|max:500',
            ]);
            //
            $report->update($validated);
            //
            return response()->json(['message' => 'Report updated successfully', 'report' => $report], 200);
            //
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Report not found'], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $report = Report::findOrFail($id); 
            // Delete the report
            $report->delete();
            //
            return response()->json(['message' => 'Report deleted successfully'], 200);
            //
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Report not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }
    
}
