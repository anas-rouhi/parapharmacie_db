<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Produit;

class ChatbotController extends Controller
{
    public function respond(Request $request)
    {
        $userMessage = $request->input('message');

        if (empty($userMessage)) {
            return response()->json(['message' => 'Veuillez décrire vos symptômes.']);
        }

        // 1. نجيبو كاع سميات المنتجات لي عندك ف السيت باش الـ IA يعرف شنو عندك
        $availableProducts = Produit::pluck('nom')->toArray();
        $productsListString = implode(', ', $availableProducts);

        // 2. إعداد الـ System Prompt باش نوجهو الذكاء الاصطناعي
        $systemPrompt = "Tu es un assistant pharmacien virtuel expert pour un site de parapharmacie nommé ParaSanté. "
            . "Le client va t'expliquer ses symptômes ou ses besoins (parfois en Français, parfois en Arabe/Darija marocain comme 'fya skhana', 'peau sèche', etc.). "
            . "Tu dois faire deux choses : "
            . "1. Lui répondre gentiment en Français avec des conseils clairs (2 à 3 phrases max). "
            . "2. Identifier les mots-clés de recherche ou les noms de produits correspondants parmi cette liste de produits disponibles chez nous : [{$productsListString}]. "
            . "Tu DOIS obligatoirement renvoyer ta réponse sous forme d'un objet JSON strict avec exactement deux clés: 'conseil' (la réponse textuelle pour le client) et 'mots_cles' (un tableau de chaînes de caractères pour la recherche SQL, exemple: ['crème', 'hydratant']). "
            . "Ne renvoie rien d'autre que du JSON pur, pas de markdown, pas de ```json.";

        // 3. الاتصال بـ API ديال Gemini
        // غانحطو الـ API Key ف ملف .env من بعد
        $apiKey = env('GEMINI_API_KEY');

        try {
            // نجيبو الـ Key ديريكت من الـ .env
            $apiKey = env('GEMINI_API_KEY');

            $response = Http::withoutVerifying() // 🔥 هادي غاتخلي الطلب يدوز بلا ما يتبلوكا بسبب الـ SSL ف اللوكال
                ->withHeaders([
                    'Content-Type' => 'application/json'
                ])
                ->withQueryParameters([
                    'key' => $apiKey
                ])
                ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent", [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $systemPrompt . "\n\nMessage du client : " . $userMessage]
                            ]
                        ]
                    ],
                    // 🔒 كنجبرو الـ IA يرجع JSON نقي بلا Markdown باش الـ parsing يكون مضمون
                    'generationConfig' => [
                        'responseMimeType' => 'application/json',
                    ],
                ]);

            if ($response->successful()) {
                $result = $response->json();
                $aiRawResponse = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';

                // 🔥 تنظيف قوي للرد: إزالة أي Markdown أو أسطر زائدة لضمان قراءة الـ JSON
                $cleanJson = trim($aiRawResponse);
                if (strpos($cleanJson, '```json') === 0) {
                    $cleanJson = substr($cleanJson, 7);
                }
                if (strpos($cleanJson, '```') === 0) {
                    $cleanJson = substr($cleanJson, 3);
                }
                if (substr($cleanJson, -3) === '```') {
                    $cleanJson = substr($cleanJson, 0, -3);
                }
                $cleanJson = trim($cleanJson);

                // تفكيك الـ JSON المُنظّف
                $aiData = json_decode($cleanJson, true);

                // إيلا الـ JSON تفركع بنجاح
                if (json_last_error() === JSON_ERROR_NONE) {
                    $conseil = $aiData['conseil'] ?? "Voici nos recommandations :";
                    $motsCles = $aiData['mots_cles'] ?? [];

                    // البحث في قاعدة البيانات
                    $query = Produit::query();
                    if (!empty($motsCles)) {
                        $query->where(function ($q) use ($motsCles) {
                            foreach ($motsCles as $mot) {
                                $q->orWhere('nom', 'LIKE', '%' . $mot . '%')
                                    ->orWhere('description', 'LIKE', '%' . $mot . '%');
                            }
                        });
                    }

                    $produitsTrouves = $query->take(3)->get(['id', 'nom', 'prix', 'image']);

                    return response()->json([
                        'status' => 'success',
                        'message' => $conseil,
                        'produits' => $produitsTrouves
                    ]);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }

        return response()->json([
            'status' => 'error',
            'message' => "Désolé, je rencontre un petit problème technique. Pouvez-vous reformuler ?"
        ]);
    }
}
