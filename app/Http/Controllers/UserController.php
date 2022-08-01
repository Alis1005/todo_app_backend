<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;



class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 401);
        } else {
            $domain = explode('@', $request->input('email'))[1];
            if (checkdnsrr($domain)) {

                $email_exist = User::where('email', $request->input('email'))->first();

                if($email_exist){
                    return response(['message' => 'Email already exist!'], 401);
                }else{
                    $user = User::create([
                        'email' => $request->input('email'),
                        'password' => Hash::make($request->input('password'))
                    ]);
                    Auth::loginUsingId($user->id);
                    $user = Auth::user();
                    $token = $user->createToken('token')->plainTextToken;
                    return response([
                        'token' => $token,
                        'data' => $user
                    ]);
                }
            } else {
                return response(['message' => 'Invalid Domain'], 401);
            }
        }
    }
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response(['message' => 'Invalid credentials'], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();
        $token = $user->createToken('token')->plainTextToken;
        return response([
            'token' => $token,
            'data' => $user
        ]);
    }
    public function user(Request $request)
    {
       return  Auth::user();
    }
}
