<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande Confirmée !</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">

    <div class="max-w-md w-full bg-white p-8 rounded-3xl shadow-lg text-center border border-gray-100">
        <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        
        <h1 class="text-2xl font-black text-gray-900 mb-2">Merci pour votre commande !</h1>
        <p class="text-gray-500 text-sm mb-8">Votre commande a été enregistrée avec succès. Notre équipe va vous contacter par téléphone pour confirmer la livraison.</p>

        <a href="/" class="block w-full bg-green-600 text-white py-3.5 rounded-xl font-bold hover:bg-green-700 transition shadow-md">
            Retour à l'accueil
        </a>
        @if(request()->id)
    <div class="mt-6 text-center">
        <a href="{{ route('facture.download', request()->id) }}" class="inline-flex items-center bg-green-600 text-white px-6 py-3 rounded-xl font-bold shadow-md hover:bg-green-700 transition">
            📄 Télécharger votre Facture (PDF)
        </a>
    </div>
@endif
    </div>

</body>
</html>