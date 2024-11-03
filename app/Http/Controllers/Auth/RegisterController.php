<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', 'in:0,1'],
        ];

        if ($data['role'] == '1') {
            $rules['specialization'] = ['required', 'string', 'max:255'];
            $rules['pin'] = ['required'];
        } elseif ($data['role'] == '0') {
            $rules['disease'] = ['required', 'string', 'max:255'];
        }

        return Validator::make($data, $rules);
    }

    public function index()
    {
        $doctors = User::where('role', '1')->get();
        return view('auth.register', compact('doctors'));
    }

    protected function create(array $data)
    {
        return User::create([
            'id' => User::max('id') + 1,
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'date_of_birth' => $data['date_of_birth'],
            'place_of_birth' => $data['place_of_birth'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'specialization' => $data['role'] == '1' ? $data['specialization'] : null,
            'disease' => $data['role'] == '0' ? $data['disease'] : null,
            'doctor_id' => $data['role'] === '0' ? $data['doctor_id'] : null,
        ]);
    }

    public function apiRegister(Request $request)
    {
        $authToken = $request->bearerToken();
        $staticToken = env('API_BEARER_TOKEN');

        if ($authToken !== $staticToken) {
            return Response::json(['error' => 'Unauthorized'], 401);
        }

        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if ($request->role == '1') {
            $expectedPin = env('DOCTOR_REGISTRATION_PIN');
            if ($request->pin !== $expectedPin) {
                return response()->json(['error' => 'Invalid Registration PIN for Doctors'], 403);
            }
        }

        $user = $this->create($request->all());

        $token = JWTAuth::fromUser($user);

        return response()->json(['message' => 'Akun berhasil dibuat, silahkan login!', 'code' => 200, 'user' => $user, 'token' => $token], 201);
    }
}
