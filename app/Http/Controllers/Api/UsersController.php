<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function getAllUsers(){
        $users = User::with('details')->get();
        $responseData = [];
        foreach ($users as $user) {
            $responseData[] = [
                'user' => $user,
                'details' => $user->details,
            ];
        }

        return response()->json($responseData);
    }

    public function createUser(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => 'string|required|max:225',
            'last_name' => 'string|required|max:225',
            'email' => 'string|email|unique:users|required|max:225',
            'password' => 'required|string|min:4',
            'address' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422); // Unprocessable Entity
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $userDetails = null;
        if ($request->has('address')) {
            $userDetails = UserDetail::create([
                'user_id' => $user->id,
                'address' => $request->address,
            ]);
        }

        // Return a JSON response with user and details data
        return response()->json([
            'user' => $user,
            'details' => $userDetails,
        ], 201);
    }

    public function updateUser(Request $request)
    {
        $user = User::with('details')->where('id', $request->id)->first();
    
        if (!$user) {
            return response()->json([
                'message' => "User with ID {$request->id} not found",
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'string|max:225',
            'last_name' => 'string|max:225',
            'email' => 'string|email|unique:users,email,' . $user->id . '|max:225', // Exclude current user for email validation
            'password' => 'nullable|string|min:4',
            'address' => 'nullable',
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        $user->update($request->only('first_name', 'last_name', 'email', 'password'));
    
        if ($request->has('address') && $user->details) {
            $user->details->update([
                'address' => $request->address,
            ]);
        }
    
        $user->refresh(); // Refresh user data after update
    
        return response()->json([
            'message' => "User with ID {$user->id} has been updated successfully",
            'user' => $user->toArray(), 
        ], 200);
    }
    

    public function destroyUser(Request $request)
    {
        $user = User::where('id', $request->id)->with('details')->first();
        if($user){
            $user->delete();
            if($user->details){
                $user->details->delete();
            }
            return response()->json([
                'message' => "User with ID ".$request->id." has been deleted successfully",
            ], 200);
        }

        return response()->json([
            'message' => "User with ID ".$request->id." not found",
        ], 404);
        
    }
}
