<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\AuditLog; // زيرنا الموديل هنا

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = auth()->user();

        // 🔥 تسجيل عملية الدخول بنجاح ف السجل
        AuditLog::create([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'action' => 'Connexion',
            'description' => "L'utilisateur a connecté avec le rôle [{$user->role}].",
            'ip_address' => $request->ip(),
        ]);

        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }

        if ($user->role === 'client') {
            return redirect()->intended(route('staff.dashboard'));
        }

        return redirect()->intended(route('client.commandes'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $user = auth()->user();

        if ($user) {
            // 🔥 تسجيل عملية تسجيل الخروج
            AuditLog::create([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'action' => 'Déconnexion',
                'description' => "L'utilisateur [{$user->name}] s'est déconnecté.",
                'ip_address' => $request->ip(),
            ]);
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
