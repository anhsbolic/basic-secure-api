<?php

namespace App\Http\Controllers;

use App\User;
use App\UserProfile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function profile($id_user) {
        // find user  
        $user = User::find($id_user);

        // find user profile
        $profile = UserProfile::find($id_user);

        // response
        $response = [
            'code' => 2,
            'message' => 'User Profile',
            'data' => [
                'user' => $user,
                'profile' => $profile,
            ]
        ];
        return response()->json($response, 200);
    }

    public function updateProfile(Request $request, $id_user) {
        
    }
}
