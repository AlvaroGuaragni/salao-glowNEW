<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cliente; 
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB; 
class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'cpf' => ['required', 'string', 'max:20', 'unique:'.Cliente::class], 
            'telefone' => ['nullable', 'string', 'max:20'], 
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'client', 
            ]);

            Cliente::create([
                'user_id' => $user->id,
                'nome' => $request->name,
                'email' => $request->email,
                'cpf' => $request->cpf,
                'telefone' => $request->telefone,
            ]);

            DB::commit(); 

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ocorreu um erro ao criar seu registro. Tente novamente.');
        }

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}