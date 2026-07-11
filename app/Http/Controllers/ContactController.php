<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // 1. الـ Validation بالأسماء الحقيقية ديال الداتابيز ديالك (nom)
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // 2. خزن ف الـ DB بـ 'nom' كيف عندك ف الـ Migration
        Message::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'message' => $request->message,
        ]);

        // 3. هاد السطر هو اللي كيتسناه السكريبت باش يطلق SweetAlert الأخضر
        return response()->json([
            'success' => 'Votre message a été envoyé avec succès !'
        ]);
    }
}
