<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;
use Log;
use Carbon\Carbon;

class LoginController extends Controller
{

  public function login(Request $request){

        $login = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::get()->where('email', trim($request->input('email')))->first();

        if ($user == null) {
            return response()->json(
                [
                    'name' => 'login',
                    'response' => 400,
                    'success' => false,
                    'message' => 'User does not exist'
                ], 400);
        }
        
        if (!Auth::attempt($login)) {
            if ($user == null || !isset($user)) {
                return response()->json(
                    [
                        'name' => 'login',
                        'response' => 400,
                        'success' => false,
                        'message' => 'User does not exist'
                    ], 400);
            } else {
                return response()->json(
                    [
                        'name' => 'login',
                        'response' => 400,
                        'success' => false,
                        'message' => 'Invalid login credentials'
                    ], 400);
            }
        }

        // $user->save();
        
        // $token = Auth::user()->createToken('authToken');
        // $accessToken = $token->accessToken;
        // $expiration = $token->token;
        // $expiration->expires_at = Carbon::now()->addMinutes(30);
        // $expiration->save();

        return response(
                [
                'user' => Auth::user()
              ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return response()->json(
            [
                'name' => 'logout',
                'response' => 200,
                'success' => true,
                'message' => 'Successfully logged out'
            ], 200);
    }
}
