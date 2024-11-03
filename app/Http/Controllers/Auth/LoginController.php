<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'refreshToken']);
    }

    public function login(Request $request)
    {
        $input = $request->all();

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        if (!$token = auth()->attempt(['username' => $input['username'], 'password' => $input['password']])) {
            return redirect()
                ->route('login')
                ->with('error', 'Incorrect username or password!');
        }

        $user = auth()->user();
        session()->put('token', $token);
        return redirect()->route($user->role == 'admin' ? 'admin.home' : 'home');
    }

    public function apiLogin(Request $request)
    {
        $authToken = $request->bearerToken();
        $staticToken = env('API_BEARER_TOKEN');

        if ($authToken !== $staticToken) {
            return Response::json(['error' => 'Unauthorized'], 401);
        }

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        if (!$token = JWTAuth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return response()->json(['success' => false, 'message' => 'Incorrect username or password.'], 401);
        }

        $user = auth()->user();
        return response()->json([
            'success' => true,
            'code' => 200,
            'message' => 'Login successful.',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username,
                'role' => $user->role,
                'email' => $user->email,
                'place_of_birth' => $user->place_of_birth,
                'date_of_birth' => $user->date_of_birth,
                'specialization' => $user->specialization,
                'disease' => $user->disease,
            ],
            'token' => $token
        ], 200);
    }

    public function refreshToken()
    {
        try {
            $newToken = JWTAuth::parseToken()->refresh();
            return response()->json(['success' => true, 'token' => $newToken], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not refresh token'], 401);
        }
    }

    public function logout(Request $request)
    {
        $token = session('token');
        
        if (!$token) {
            return response()->json(['error' => 'Token is required'], 400);
        }
        
        try {
            // JWTAuth::setToken($token)->invalidate();
            session()->forget('jwt_token');
            return response()->json(['message' => 'Successfully logged out']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to logout, please try again'], 500);
        }
    }
    
}
