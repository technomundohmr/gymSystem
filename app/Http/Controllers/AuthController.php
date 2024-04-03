<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;

class AuthController extends Controller
{
    /**
     * use login method
     */
    public function login(Request $request)
    {
        $credenciales = $request->only('email', 'password');
        if (Auth::attempt($credenciales)) {
            $user = Auth::user();
            $token = $user->createToken('superadminToken')->plainTextToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Credenciales no válidas'], 401);
        }
    }

    /**
     * use register method
     */
    public function register(UserRequest $request) {
        $register_data = $request->validated();
        dump($register_data);
        die;
        if(!empty($register_data['id_number'] && $register_data['tipo_id'])) {
            $register_data['full_id'] = $register_data['tipo_id'] . '-' . $register_data['id_number'];
        } else {
            return response()->json(['message' => 'los campos de identificación no existen']);
        }

        if(!empty($register_data['password'])) {
            $register_data['password'] = bcrypt( $register_data['password']);
        }

        if(!empty($register_data['role_id'])) {
            $role_name = $register_data['role_id'];
            $role = Roles::where('machine_id', '=', $register_data['role_id'] )->first();
            if(!empty($role)){
                $register_data['role_id'] = $role->getAttribute('id');
            } else{
                return response()->json(['message' => 'there was an error: El rol seleccionado no existe']);
            }

            switch ($role_name) {
                case 'gym':
                    $user = $this->_create_gym($register_data);
                    break;
                
                default:
                    # code...
                    break;
            }
        }

        if(empty($user['error'])) {
            $token = $user->createToken('superadminToken')->plainTextToken;
            return response()->json([
                'message' => 'user created succesfully',
                'token' => $token
            ]);
        }else {
            return response()->json($user);
        }

    }

    public function _create_gym($data) {
        //@todo in frontend ask owner if want to register same gym data 
        try {
            $user = User::create($data);
            return $user;
        } catch (\Throwable $th) {
            return ['error' => $th];
        }
    }

    public function _create_owner($data) {
        //@todo in frontend ask owner if want to register same gym data 
        try {
            $user = User::create($data);
            return $user;
        } catch (\Throwable $th) {
            return ['error' => $th];
        }
    }
}
