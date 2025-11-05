<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\JsonResponse;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login page.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('auth/login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse|JsonResponse
    {
        try {
            $request->authenticate();
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Ha AJAX kérés, JSON-t küldünk vissza
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Helytelen email cím vagy jelszó!'
                ], 422);
            }
            
            // Egyéb esetben flash üzenettel visszairányítjuk
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput($request->only('email'))
                ->with('login_error', 'Helytelen email cím vagy jelszó!');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
