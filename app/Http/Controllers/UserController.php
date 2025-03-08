<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOTP;


class UserController extends Controller
{

    //all user for admin to check
    public function index()
    {
        return response()->json([
            'users' => User::paginate(30)
        ]);
    }
    // show user info
    public function show($id)
    {
        $user = User::find($id);
        return $user
            ? response()->json(['user' => $user])
            : response()->json(['message' => 'User not found'], 404);
    }
    // User login
    public function Login(Request $request)
    {
        try {
            //
            $credentials = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string|min:6'
            ]);
            //
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                return response()->json([
                    'user' => $user,
                    'message' => 'Login successful'
                ], 200);
            }
            // Return error response for invalid credentials
            return response()->json(['message' => 'Invalid credentials'], 401);
            //error handling
        } catch (Exception) {
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
    // sign up
    public function Signup(Request $request)
    {
        try {
            //validation
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'phone' => 'required|string|unique:users',
                'password' => 'required|string|min:6',
                'profile_p' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'bio' => 'nullable|string|max:500',
                'specialization' => 'nullable|string|max:255',
            ]);
            // Handle profile picture upload
            if ($request->hasFile('profile_p')) {
                $path = $request->file('profile_p')->store('profile_pictures', 'public');
                $data['profile_p'] = $path;
            }
            // create in user table
            $user = User::create([
                ...$data,
                'password' => Hash::make($data['password'])
            ]);
            //return user 
            return response()->json([
                'message' => 'User registered successfully. Please verify your account.',
                'user' => $user
            ], 201);
            //error handling 
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (Exception) {
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    //update user
    public function updateuser(Request $request, $id)
    {
        try {
            // Find user
            $user = User::findOrFail($id);
            // Validation
            $data = $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|email|unique:users,email,' . $user->id,
                'phone' => 'sometimes|string|unique:users,phone,' . $user->id,
                'profile_p' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'bio' => 'sometimes|string|max:500',
                'specialization' => 'sometimes|string|max:255',
            ]);
            // need to fix this
            if ($request->hasFile('profile_p')) {
                $path = $request->file('profile_p')->store('profile_pictures', 'public');
                $data['profile_p'] = $path;
            }
            // Update user
            $user->update($data);
            //
            return response()->json([
                'message' => 'User updated successfully',
                'user' => $user
            ]);
            //
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (Exception) {
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    // send random number to email and to server client for check forget password
    public function otp(Request $request)
    {
        try {
            // Validate request data
            $data = $request->validate([
                'email' => 'required|email|exists:users,email',
            ]);
            // Generate  random number
            $otp = random_int(100000, 999999);
            // Send OTP via email
            Mail::to($data['email'])->queue(new SendOTP($otp));
            //
            return response()->json([
                'message' => 'OTP sent to email successfully',
                'otp' =>  $otp
            ]);
            //
        } catch (Exception $e) {
            return response()->json(['message' => 'Failed to send OTP'], 500);
        }
    }

    //forget password change password
    public function forgetpassword(Request $request)
    {
        try {
            // Validate request data
            $data = $request->validate([
                'email' => 'required|email|exists:users,email',
                'new_password' => 'required|string|min:6'
            ]);
            // Find user by email
            $user = User::where('email', $data['email'])->first();
            // Update password with hashed value
            $user->update([
                'password' => Hash::make($data['new_password'])
            ]);
            //
            return response()->json([
                'message' => 'Password updated successfully',
                'user' => $user
            ]);
            //
        } catch (Exception) {
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function UpdateUserFunction(Request $request, $id)
    {
        try {
            // Find user
            $user = User::findOrFail($id);
            // Validation
            $data = $request->validate([
                'profile_p' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            // need to fix this
            if ($request->hasFile('profile_p')) {
                $path = $request->file('profile_p')->store('profile_pictures', 'public');
                $data['profile_p'] = $path;
            }
            // Update user
            $user->update($data);
            //
            return response()->json([
                'message' => 'User updated successfully',
                'user' => $user
            ]);
            //
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (Exception) {
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function UpdatePassword(Request $request, $id)
    {
        try {
            // Find user
            $user = User::findOrFail($id);
            // Validate input
            $data = $request->validate([
                'password' => 'required|string',
                'new_password' => 'required|string|min:6',
            ]);
            // Check if old password matches the current one
            if (!Hash::check($data['password'], $user->password)) {
                return response()->json(['message' => 'Old password is incorrect'], 403);
            }
            // Update the password
            $user->update([
                'password' => Hash::make($data['new_password']),
            ]);
            //
            return response()->json([
                'message' => 'Password updated successfully',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (Exception) {
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }
}
