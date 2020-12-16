<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function store (Request $request) {
        $input = $request -> all ();
        $input['password'] = bcrypt ($input['password']);

        $rules = [
            'name' => 'required',
            'last_name' => 'required',
            'telephone' => 'required',
            'birthday' => 'required',
            'email' => 'required',
            'password' => 'required | min:4',
        ];

        $messages = [
            'name.required' => 'Name field is required',
            'last_name.required' => 'Last Name field is required',
            'telephone' => 'Telephone field must be a number',
            'telephone.required' => 'Telephone number field is required',
            'email.required' => 'Email field is required',
            'email.unique' => 'This email has already exist',
            'password.required' => 'Password field is required',
        ];

        $validator = validator::make ($input, $rules, $messages);

        if ($validator -> fails()) {
            return response () -> json ([$validator -> errors ()], 400);
        }
        else {
            $user = User::create ($input);
            return $user;
        }
    }

    public function login (Request $request) {
        $credentials = $request -> only ('email', 'password');

        if ( Auth::attempt (['email' => $credentials['email'], 'password' => $credentials['password']] )) {
            $user = Auth::user ();
            $token = $user->createToken('authToken')->accessToken;

            $respuesta = [];
            $respuesta ['name'] = $user->name;
            $respuesta ['token'] = $token;

            return response () -> json (['Login correcto', $user, $respuesta,  200]);
        }
        else {
            return response () -> json (['error' => 'Fallo en la autenticación'], 400);
        }
    }

    public function logout (Request $request) {
        $request -> user () -> token () -> revoke ();
        // $token -> revoke ();

        return response () -> json (['Has cerrado la sesión con éxito', 200]);
    }

    public function show ($id) {
        $user = User::with ('appointments') -> find ($id);

        return $user;
    }

    public function index () {
        $users = User::all ();

        return $users;
    }

    public function update (Request $request, $id) {
        $user = User::findOrFail ($id);

        $request -> has([
            'name',
            'last_name',
            'telephone',
            'birthday',
            'email',
            'password',
        ]);

        $rules = [
            'name' => 'required',
            'last_name' => 'required',
            'telephone' => 'required',
            'birthday' => 'required',
            'email' => 'required',
            'password' => 'required',
        ];

        $messages = [
            'name.required' => 'Name field is required',
            'last_name.required' => 'Last Name field is required',
            'telephone.required' => 'Telephone number field is required',
            'email.required' => 'Email field is required',
            'email.unique' => 'This email has already exist',
            'password.required' => 'Password field is required',
        ];

        $request['password'] = bcrypt ($request['password']);

        $validator = validator::make($rules, $messages);

        if ($validator -> fails ()) {
            return response () -> json ([$validator -> errors ()], 400);
        }
        else {
            $user -> update ($request -> all ());

            return $user;
        }
    }

    public function destroy (User $user) {
        $user -> delete ();

        return 'Usuario eliminado con éxito';
    }
}
