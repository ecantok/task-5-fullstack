<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PassportAuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|max:55',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors()]);
        }

        $data['password'] = Hash::make($data['password']);

        User::create($data);
        $resp['code'] = 200;
        $resp['message'] = 'User succesfully registered, you may now login';
        return response()->json($resp);
    }

    public function login(Request $request)
    {
        $login = [
            'email'=> $request->email,
            'password'=> $request->password
        ];

        if (Auth::attempt($login)) {
            $token = Auth::user()->createToken('authToken')->accessToken;
            $resp['code'] = 200;
            $resp['message'] = 'success';
            $resp['access-token'] = $token;
            return response()->json($resp);
        }
        $resp['message'] = 'Invalid Login Credentials';
        return response()->json($resp, 422);
    }
}
