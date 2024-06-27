<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use AuthenticatesUsers;
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
        $fields = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password'])

        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        Auth::setUser($user);
        return response()->json([
            Auth::user(),
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
