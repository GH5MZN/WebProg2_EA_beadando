<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.required' => 'A név megadása kötelező.',
            'name.max' => 'A név maximum 255 karakter lehet.',
            'email.required' => 'Az email cím megadása kötelező.',
            'email.email' => 'Érvényes email címet adjon meg.',
            'email.unique' => 'Ez az email cím már használatban van.',
            'password.required' => 'A jelszó megadása kötelező.',
            'password.confirmed' => 'A jelszó megerősítése nem egyezik.',
        ]);

        try {
            $user = User::create([
                'name' => trim($request->name),
                'email' => strtolower(trim($request->email)),
                'password' => Hash::make($request->password),
            ]);

            event(new Registered($user));

            // Auth::login($user);  // Automatikus bejelentkezés kikapcsolva

            return redirect()->route('home')->with('success', 
                'Sikeres regisztráció! Most már bejelentkezhet a fiókjába! 🏁 (ID: ' . $user->id . ')');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('error', 'Hiba történt a regisztráció során. Kérjük próbálja újra.');
        }
    }
}
