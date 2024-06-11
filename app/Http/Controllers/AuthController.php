<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
//    public static function middleware(): array
//    {
//        return [
//            'auth',
//            new Middleware('comment', only: ['logout']),
//            new Middleware('subscribed', except: ['store']),
//        ];
//    }
    public function register(Request $request)
    {


        view('auth.layouts.register');

        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])

        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token

        ];
//        dd(auth()->user());
//        auth()->login($user);

        return response($response, 201);

    }

    public function login(Request $request)
    {
        return view ('auth.layouts.login');
        dd(auth()->user());
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);
    }

    public function logout(Request $request)
    {
//        dd(Auth::user());
        if (
            auth()->user() ?? 0
        )
        {
//            dd(1111);
            auth()->user()->tokens()->delete();
//            auth()->logout();
//            $request->session()->invalidate();
//            $request->session()->regenerateToken();
        }


//        Auth::logout();
//
//        $request->session()->invalidate();
//
//        $request->session()->regenerateToken();
//
//        return redirect('/');

        return [
            'message' => 'Logged out'
        ];
    }
    //
}
