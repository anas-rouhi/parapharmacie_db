<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Si le service d'e-mail (Resend) refuse l'envoi, l'exception remontait jusqu'à
        // une page d'erreur 500. On l'intercepte pour afficher un message exploitable.
        try {
            $status = Password::sendResetLink(
                $request->only('email')
            );
        } catch (\Throwable $e) {
            report($e);

            // En local/debug, on affiche la VRAIE raison renvoyée par le fournisseur
            // (ex. Resend en bac à sable : « You can only send testing emails to your own
            // email address » → il faut vérifier un domaine sur resend.com/domains).
            $message = config('app.debug')
                ? "Échec de l'envoi de l'e-mail : " . $e->getMessage()
                : "L'e-mail de réinitialisation n'a pas pu être envoyé pour le moment. Merci de réessayer plus tard.";

            return back()->withInput($request->only('email'))->withErrors([
                'email' => $message,
            ]);
        }

        return $status == Password::RESET_LINK_SENT
                    ? back()->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}
