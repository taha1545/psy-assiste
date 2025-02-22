<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use Illuminate\Http\Request;
use App\Models\User;


class FolderController extends Controller
{

    public function index($id)
    {
        try {
            //
            if (!User::find($id)) return response()->json(['message' => 'User not found'], 404);
            //
            $folders = Folder::where('user_id', $id)->get();
            //
            return response()->json(['folders' => $folders]);
            //
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            //
            $folder = Folder::with('reports')->findOrFail($id);
            //
            return response()->json(['folder' => $folder], 200);
            //
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Folder not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'folder_name' => 'required|string|max:255',
                'user_id' => 'required|exists:users,id',
                'full_address' => 'nullable|string',
                'birth_date' => 'required|date',
                'region' => 'nullable|string|max:255',
                'phone_number' => 'required|string|max:15',
                'family_number' => 'nullable|integer|min:0',
                'total_siblings' => 'nullable|integer|min:0',
                'sibling_position' => 'nullable|integer|min:0',
                'start_date' => 'nullable|date',
                'education_level' => 'nullable|string|max:255',
            ]);
            // Create the folder
            $folder = Folder::create($validated);
            //
            return response()->json(['message' => 'Folder created successfully', 'folder' => $folder], 201);
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
            $folder = Folder::findOrFail($id);
            //
            $validated = $request->validate([
                'folder_name' => 'sometimes|required|string|max:255',
                'user_id' => 'sometimes|required|exists:users,id',
                'full_address' => 'nullable|string',
                'birth_date' => 'sometimes|required|date',
                'region' => 'nullable|string|max:255',
                'phone_number' => 'sometimes|required|string|max:15',
                'family_number' => 'nullable|integer|min:0',
                'total_siblings' => 'nullable|integer|min:0',
                'sibling_position' => 'nullable|integer|min:0',
                'start_date' => 'nullable|date',
                'education_level' => 'nullable|string|max:255',
            ]);
            // Update only the provided fields
            $folder->update($validated);
            //
            return response()->json([
                'message' => 'Folder updated successfully',
                'folder' => $folder
            ]);
            //
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Folder not found'], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }


    public function destroy($id)
    {
        try {
            $folder = Folder::findOrFail($id);
            //
            $folder->delete();
            //
            return response()->json(['message' => 'Folder deleted successfully']);
            //
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Folder not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Something went wrong', 'error' => $e->getMessage()], 500);
        }
    }
}
