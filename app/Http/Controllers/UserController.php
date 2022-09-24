<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
        ];

        $messages = [
            'name.required' => 'El nombre es requerido',
            'email.required' => 'El correo es requerido',
            'email.email' => 'Correo invalido',
            'email.unique' => 'El correo ya existe',
            'password.required' => 'La contraseña es requerida',
            'password.min' => 'Contraseña debe tener al menos 6 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden'
        ];

        $this->validate($request, $rules, $messages);

        try {
            DB::beginTransaction();
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'status' => 1
            ]);

            if ($user) {
                Auth::login($user);
                DB::commit();
                return redirect()->route('home');
            } else {
                return back()->with('errors', 'Error al crear el usuario');
                DB::commit();
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function validateLogin(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];

        $messages = [
            'email.required' => 'El correo es requerido',
            'email.email' => 'Correo invalido',
            'password.required' => 'La contraseña es requerida'
        ];

        $this->validate($request, $rules, $messages);

        $credentials = $request->only('email', 'password');

        $user = User::where('email', $request->email)->first();

        if ($user->status == 0) {
            return back()->with('errors', 'Usuario inactivo');
        } else {
            if (Auth::attempt($credentials)) {
                return redirect()->route('home');
            } else {
                return back()->with('errors', 'Credenciales incorrectas');
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function home()
    {
        return view('auth.home');
    }
}
