<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function register()
    {
        return view('register');
    }

    public function loginView()
    {
        return view('login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'account_type' => ['string', Rule::in(User::TYPE_BUSINESS, User::TYPE_INDIVIDUAL)],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'account_type' => $request->account_type,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('transactions.index');
    }

    public function login(Request $request)
    {
        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return redirect()->back()->withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        $request->session()->regenerate();
        return redirect()->intended('/');
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
