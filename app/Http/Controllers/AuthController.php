<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class AuthController extends BaseController
{
    /**
     * Store a new user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function register(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        try {

            $user = new User;
            $user->name = $request->input('name');
            $user->username = $request->input('email');
            $user->email = $request->input('email');
            $user->role_id = 2;
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);
            $user->save();

            //return successful response
            return response()->json(['user' => $user, 'message' => 'success'], 201);

        } catch (\Exception $e) {
            //return error message
            return response()->json(['message' => 'User Registration Failed!'], 409);
        }

    }

    public function login(Request $request)
    {
        //validate incoming request 
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['username', 'password']);

        if (! $data = Auth::attempt($credentials)) {
            return $this->json(
                    Response::HTTP_OK,
                    "Username atau Password Salah."
                );
        }

        if (Auth::user()->role != 'admin') {
            return $this->json(
                    Response::HTTP_OK,
                    "Login sebagai Admin."
                );
        }

        return $this->json(
            Response::HTTP_CREATED,
            "Login Successfully.",
            $data
        );
    }

    public function logout()
    {
        Auth::logout(); 
        return redirect('login');
    }
}