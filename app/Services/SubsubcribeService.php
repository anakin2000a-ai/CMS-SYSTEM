<?php
namespace App\Services;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class SubsubcribeService
{
    public function NewSubsubcriber(Request $request){
          $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'password'  => Hash::make($validated['password']),
            'is_author' => false,
            'is_active' => true,
            'bio' => $request->bio,
            'avatar' => $request->avatar,
            'categories' => $request->categories,

        ]);

        return response()->json([
            'message' => 'User registered successfully',
            'user'    => $user,
        ]);
    }
    public function UnSubscribeService($id){
         // Check if the user exists
    $user = User::findOrFail($id);  // If the user is not found, a ModelNotFoundException will be thrown

    // Toggle the 'is_active' status (if 'is_active' is true, change it to false, and vice versa)
    $user->is_active = false;

    // Save the updated user data in the database
    $user->save();

    // Return a success response with the updated user data
    return response()->json([
        'message' => 'User status updated successfully=>Un Subscribe ',  // Success message
        'user'    => $user,  // The updated user data
    ], 200);  // HTTP status code 200 for "OK"
    
    }

}