<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactez-nous | ParaSante</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <x-site-header />

    <main class="max-w-5xl mx-auto px-6 py-12 lg:py-20">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <div class="lg:col-span-5 space-y-6">
                <div>
                    <h1 class="text-4xl font-black text-gray-900 tracking-tight">Contactez-nous</h1>
                    <p class="text-gray-500 text-sm mt-3 leading-relaxed">
                        Une question ou une suggestion ? N'hésitez pas à nous laisser un message.
                    </p>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center space-x-4">
                    <div class="bg-green-50 p-3 rounded-xl text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.94.725l.548 2.2a1 1 0 01-.321.988l-1.305.98a10.582 10.582 0 004.872 4.872l.98-1.305a1 1 0 01.988-.321l2.2.548a1 1 0 01.725.94V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Téléphone</span>
                        <span class="text-base font-bold text-gray-800">+212 6 00 00 00 00</span>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center space-x-4">
                    <div class="bg-blue-50 p-3 rounded-xl text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/xl" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">E-mail</span>
                        <span class="text-base font-bold text-gray-800">contact@parapharmacie.md</span>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm flex items-center space-x-4">
                    <div class="bg-red-50 p-3 rounded-xl text-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-gray-400 uppercase tracking-wider">Adresse</span>
                        <span class="text-base font-bold text-gray-800">Gueliz, Marrakech, Maroc</span>
                    </div>
                </div>
            </div>

            
            <div class="lg:col-span-7 bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
    <h2 class="text-xl font-bold text-gray-900 mb-6">Envoyer un message</h2>
    
    <form id="contactForm" class="space-y-5">
        @csrf
        
        <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">Nom complet</label>
            <input type="text" id="nom" name="nom" placeholder="Ex: Anas Rouhi" 
                class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 text-sm transition font-medium" required>
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">Adresse Email</label>
            <input type="email" id="email" name="email" placeholder="votre@email.com" 
                class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 text-sm transition font-medium" required>
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-500 mb-2">Message</label>
            <textarea id="message" name="message" rows="5" placeholder="Écrivez votre message ici..." 
                class="w-full p-3.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-green-500 text-sm transition font-medium resize-none" required></textarea>
        </div>

        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-4 rounded-xl font-extrabold text-sm uppercase tracking-wider transition shadow-md">
            Envoyer
        </button>
    </form>
</div>
        </div>
    </main>

    <script>
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);
        
        Swal.fire({
            title: "Envoi en cours...",
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        fetch("{{ route('contact.store') }}", {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                Swal.fire({
                    title: "Génial ! 🎉",
                    text: data.success,
                    icon: "success",
                    confirmButtonColor: "#22c55e"
                });
                document.getElementById('contactForm').reset(); // خوي الفورم
            } else {
                Swal.fire("Erreur", "Une erreur est survenue lors de l'envoi.", "error");
            }
        })
        .catch(error => {
            Swal.fire("Erreur", "Une erreur est survenue lors de l'envoi.", "error");
        });
    });
</script>

</body>
</html>