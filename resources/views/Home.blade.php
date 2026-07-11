<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ParaSante | Accueil</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        html { scroll-behavior: smooth; }

        /* 🍃 [1] أنيميشن العناصر العائمة في الخلفية (Floating Shapes) */
        @keyframes float-slow {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(10deg); }
        }
        @keyframes float-reverse {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(25px) rotate(-15deg); }
        }
        .animate-float-1 { animation: float-slow 8s ease-in-out infinite; }
        .animate-float-2 { animation: float-reverse 12s ease-in-out infinite; }

        /* ✨ [2] الأنيميشنز الأساسية ديال الـ Hero Section */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(50px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        .animate-fade-up { animation: fadeInUp 0.8s ease-out forwards; }
        .animate-slide-left { animation: slideInLeft 0.8s ease-out forwards; }
        .animate-slide-right { animation: slideInRight 0.8s ease-out forwards; }

        /* 📦 [3] تأثير كارت المنتج المتقدم والمحرك (Premium Hover) */
        .product-card-premium {
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .product-card-premium:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(34, 197, 94, 0.12);
        }

        /* ⚡ [4] تأثير الظهور السينمائي عند السكرول المصلح (Scroll Reveal) */
        .reveal { 
            opacity: 0; 
            transform: translateY(35px); 
            transition: opacity 0.8s cubic-bezier(0.16, 1, 0.3, 1), transform 0.8s cubic-bezier(0.16, 1, 0.3, 1); 
        }
        .reveal.active { 
            opacity: 1; 
            transform: translateY(0); 
        }

        /* إخفاء السكرول بار ديال الـ Slider باش يجي نقي */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-gray-50 antialiased text-gray-800">

    <!-- 🌌 الـ Navbar المستقبلية (تأثير الزجاج الفخم مع خط إضاءة تفاعلي من التحت) -->
    <nav class="bg-white/80 backdrop-blur-xl border-b border-green-500/10 sticky top-0 z-40 shadow-[0_2px_20px_-5px_rgba(34,197,94,0.08)] transition-all duration-300">
        <!-- خط علوي متحرك خفيف كيعطي مظهر تكنولوجي حديث -->
        <div class="h-[3px] w-full bg-gradient-to-r from-green-500 via-teal-400 to-blue-600 bg-[length:200%_auto] animate-pulse"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center gap-4">
                
                <!-- الـ Logo مع توهج (Glow Effect) فخم عند مرور الماوس -->
                <div class="flex items-center flex-shrink-0 transform hover:scale-105 hover:drop-shadow-[0_0_15px_rgba(34,197,94,0.4)] transition duration-300">
                    <a href="/" class="text-2xl font-black text-green-600 tracking-tight">
                        PARA<span class="text-blue-600 relative">SANTE<span class="absolute -top-1 -right-2 text-[10px] text-teal-400 animate-ping">✦</span></span>
                    </a>
                </div>

                <!-- القائمة الرئيسية مع تأثير خط متحرك تحت الروابط (Underline Slide) -->
                <div class="hidden lg:flex items-center gap-6 text-sm font-bold text-gray-600 flex-shrink-0">
                    <a href="/" class="text-green-600 hover:text-green-700 relative py-1 after:absolute after:bottom-0 after:left-0 after:w-full after:h-0.5 after:bg-green-600">Accueil</a>
                    <a href="{{ route('pages.apropos') }}" class="hover:text-green-600 transition relative py-1 group">
                        À Propos
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-500 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('pages.sav') }}" class="hover:text-green-600 transition relative py-1 group">
                        Service SAV
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-500 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                    <a href="{{ route('pages.contact') }}" class="hover:text-green-600 transition relative py-1 group">
                        Contact
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-green-500 transition-all duration-300 group-hover:w-full"></span>
                    </a>
                </div>

                <!-- شريط البحث الذكي متطور وأكثر أناقة -->
                <div class="flex-1 max-w-md mx-4 relative hidden md:block">
                    <div class="flex items-center bg-slate-50/60 border border-slate-200/80 rounded-full focus-within:border-green-500 focus-within:ring-4 focus-within:ring-green-100 focus-within:bg-white transition duration-300 shadow-inner">
                        <span class="pl-4 text-slate-400">
                            <i class="fa-solid fa-magnifying-glass text-xs animate-pulse"></i>
                        </span>
                        <input 
                            type="text" 
                            id="live-search-input" 
                            autocomplete="off"
                            placeholder="Rechercher un produit, une marque..." 
                            class="w-full py-2.5 px-3 text-xs text-slate-700 bg-transparent rounded-full focus:outline-none placeholder:text-slate-400"
                        >
                    </div>

                    <div 
                        id="search-results-dropdown" 
                        class="hidden absolute left-0 right-0 mt-3 bg-white/95 backdrop-blur-xl rounded-2xl shadow-2xl border border-slate-100 max-h-96 overflow-y-auto z-50 divide-y divide-slate-50"
                    >
                    </div>
                </div>

                <!-- أزرار الحساب والسلة المعدلة بتأثيرات حركية فائقة النعومة -->
                <div class="flex items-center gap-4 flex-shrink-0">
                    
                    <a href="{{ route('cart.index') }}" class="relative flex items-center text-gray-700 hover:text-green-600 transition p-2.5 bg-gray-50 border border-gray-100 hover:border-green-200 hover:bg-green-50/60 rounded-full hover:scale-110 duration-300 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform group-hover:rotate-12 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        
                        @if(session('panier') && count(session('panier')) > 0)
                            <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-gradient-to-r from-red-500 to-pink-500 text-[10px] font-black text-white shadow-md shadow-red-500/30 animate-bounce">
                                @php
                                    $item_count = 0;
                                    foreach(session('panier') as $id => $details) {
                                        $item_count += $details['quantite'];
                                    }
                                @endphp
                                {{ $item_count }}
                            </span>
                        @endif
                    </a>

                    @auth
                        <div class="flex items-center gap-2 bg-gray-50/80 p-1 rounded-full border border-gray-200/60 shadow-xs backdrop-blur-md">
                            <span class="text-xs font-bold text-gray-700 pl-2">👋 {{ auth()->user()->name }}</span>
                            
                            <a href="{{ route('client.commandes') }}" class="text-[10px] font-black text-gray-600 hover:text-green-600 bg-white border border-gray-200 px-3 py-1.5 rounded-full transition-all hover:shadow-xs uppercase tracking-wider flex items-center gap-1">
                                📦 Commandes
                            </a>

                            <form method="POST" action="{{ route('logout') }}" class="inline m-0">
                                @php echo csrf_field(); @endphp
                                <button type="submit" class="text-[10px] font-black text-red-600 hover:text-white bg-red-50 hover:bg-gradient-to-r hover:from-red-500 hover:to-pink-500 px-3 py-1.5 rounded-full transition-all uppercase tracking-wider border-none cursor-pointer shadow-xs">
                                    Quitter
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex items-center gap-3">
                            <a href="{{ route('login') }}" class="text-xs font-bold text-gray-600 hover:text-green-600 transition">Connexion</a>
                            <a href="{{ route('register') }}" class="bg-gradient-to-r from-green-600 to-teal-600 text-white text-[11px] font-black px-5 py-2.5 rounded-full hover:from-green-700 hover:to-teal-700 transition shadow-md shadow-green-500/20 transform hover:scale-105 duration-200 uppercase tracking-wider">
                                S'inscrire
                            </a>
                        </div>
                    @endauth

                </div>
            </div>
        </div>
    </nav>

    <!-- التنبيهات المضافة تلقائياً بـ FadeIn النظيف -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 animate-fade-up">
            <div class="bg-gradient-to-r from-green-500 to-teal-500 text-white p-4 rounded-2xl font-bold text-sm shadow-lg shadow-green-500/20 flex justify-between items-center border border-green-400/20">
                <span class="flex items-center gap-2">🎉 {{ session('success') }}</span>
                <span class="text-[10px] bg-white/20 backdrop-blur-md px-2.5 py-1 rounded-lg uppercase font-black tracking-wide">Mis à jour</span>
            </div>
        </div>
    @endif

    <!-- 🌌 الـ Header الخيالي (العناصر العائمة ثلاثية الأبعاد + الـ Typewriter Effect التفاعلي) -->
    <header class="relative bg-gradient-to-br from-green-50/50 via-white to-blue-50/40 overflow-hidden py-24 lg:py-32">
        <!-- ⚡ فقاعات خيالية مضيئة ومتحركة في الخلفية (Abstract Magical Orbs) -->
        <div class="absolute top-10 left-10 w-80 h-80 bg-green-300/20 rounded-full blur-3xl animate-float-1 pointer-events-none"></div>
        <div class="absolute bottom-10 right-10 w-[450px] h-[450px] bg-blue-300/15 rounded-full blur-3xl animate-float-2 pointer-events-none"></div>
        
        <!-- أيقونات طبيعية طائرة خفيفة في الخلفية تمنح شعوراً بالعمق البصري -->
        <div class="absolute top-1/4 right-1/3 text-green-500/10 text-8xl animate-float-1 pointer-events-none select-none hidden lg:block">🍃</div>
        <div class="absolute bottom-1/3 left-1/4 text-blue-500/10 text-7xl animate-float-2 pointer-events-none select-none hidden lg:block">✨</div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row items-center gap-16 relative z-10">
            
            <!-- الجزء الأيسر: الكتابة الآلية المذهلة -->
            <div class="lg:w-1/2 text-center lg:text-left space-y-6">
                <span class="inline-flex items-center gap-1.5 py-2 px-4 rounded-full text-xs font-black bg-gradient-to-r from-green-50 to-teal-50 text-green-700 border border-green-200/50 mb-2 shadow-sm uppercase tracking-wider">
                    <i class="fa-solid fa-sparkles text-[11px] text-amber-500 animate-pulse"></i> 100% Produits Authentiques & Bio
                </span>
                
                <!-- 🎯 هنا قمت بربط الـ Typewriter ومزج العنوان بطريقة مذهلة لتغيير الكلمات تلقائياً -->
                <h1 class="text-4xl font-black text-slate-900 sm:text-5xl md:text-6xl tracking-tight leading-[1.15]">
                    Prenez soin de <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-600 via-teal-500 to-blue-600" id="typewriter-text"></span>
                    <span class="text-green-500 animate-pulse">|</span>
                </h1>
                
                <p class="text-base md:text-lg text-slate-500 max-w-xl leading-relaxed font-medium">
                    Découvrez notre sélection premium de parapharmacie. Des soins d'experts, des compléments certifiés et des offres flash quotidiennes sélectionnés pour votre santé.
                </p>
                
                <div class="flex flex-wrap justify-center lg:justify-start gap-4 pt-4">
                    <a href="#produits" class="bg-gradient-to-r from-green-600 to-teal-600 text-white px-8 py-4 rounded-2xl font-bold shadow-lg shadow-green-500/20 hover:shadow-green-600/40 hover:-translate-y-1 transition duration-300 flex items-center gap-2 group">
                        Voir les produits <i class="fa-solid fa-arrow-right text-xs transform group-hover:translate-x-1 transition"></i>
                    </a>
                    <button onclick="openFrontModal('aproposModal')" class="bg-white/80 backdrop-blur border border-slate-200 text-slate-700 px-8 py-4 rounded-2xl font-bold hover:bg-slate-50/80 hover:border-slate-300 transition shadow-xs">
                        En savoir plus
                    </button>
                </div>
            </div>
            
            <!-- الجزء الأيمن: تصميم ثلاثي الأبعاد زجاجي خيالي (Futuristic Glass Card) -->
            <div class="lg:w-1/2 w-full px-4 flex justify-center lg:justify-end">
                <div class="relative bg-white/40 backdrop-blur-2xl rounded-[2.5rem] p-12 border-4 border-white shadow-[0_30px_60px_-15px_rgba(15,23,42,0.08)] flex flex-col items-center justify-center text-center group overflow-hidden h-80 lg:h-[420px] w-full max-w-md transition-all duration-500 hover:scale-[1.02] hover:shadow-[0_40px_80px_-15px_rgba(34,197,94,0.15)]">
                    
                    <!-- إضاءة نيون خلفية تتفاعل وتكبر عند مرور الماوس فوق الكارت -->
                    <div class="absolute -right-20 -top-20 w-60 h-60 bg-gradient-to-br from-green-400/20 to-blue-400/20 rounded-full blur-3xl group-hover:scale-150 transition duration-700"></div>
                    <div class="absolute -left-20 -bottom-20 w-60 h-60 bg-gradient-to-br from-teal-400/10 to-emerald-400/20 rounded-full blur-3xl group-hover:scale-150 transition duration-700"></div>
                    
                    <!-- الأيقونة النابضة بالتأثير ثلاثي الأبعاد -->
                    <div class="h-24 w-24 bg-gradient-to-tr from-green-500 via-teal-500 to-blue-600 rounded-3xl flex items-center justify-center text-white shadow-xl shadow-green-500/20 mb-8 transform group-hover:rotate-6 group-hover:scale-110 transition duration-300 relative">
                        <i class="fa-solid fa-heart-pulse text-5xl animate-pulse"></i>
                        <span class="absolute top-0 right-0 flex h-3 w-3">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-sky-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-3 w-3 bg-sky-500"></span>
                        </span>
                    </div>
                    
                    <span class="font-black text-3xl text-slate-800 tracking-tight transition group-hover:text-green-600 duration-300">E-ParaSante</span>
                    <div class="w-16 h-1.5 bg-gradient-to-r from-green-500 via-teal-500 to-blue-500 rounded-full my-4"></div>
                    <p class="text-sm text-slate-500 font-semibold max-w-sm leading-relaxed">
                        Votre parapharmacie de confiance à Marrakech. Commandez en toute sécurité et profitez d'une livraison rapide partout au Maroc.
                    </p>
                </div>
            </div>

        </div>
    </header>

    <!-- 🌟 الـ Features Section (مربعات الميزات المتفاعلة بـ Hover خيالي) -->
    <section class="bg-white border-b border-gray-100 py-8 shadow-xs relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-4 text-center divide-y md:divide-y-0 md:divide-x divide-gray-100/70">
                
                <!-- الميزة 1 -->
                <div class="flex items-center justify-center gap-4 md:pb-0 pb-4 group cursor-pointer p-4 rounded-2xl hover:bg-slate-50/60 transition duration-300">
                    <div class="h-12 w-12 rounded-2xl bg-green-50 border border-green-100/50 flex items-center justify-center text-green-600 transition-all group-hover:scale-110 group-hover:bg-green-500 group-hover:text-white shadow-sm duration-300">
                        <i class="fa-solid fa-truck-fast text-lg"></i>
                    </div>
                    <div class="text-left">
                        <p class="text-sm font-black text-gray-900 group-hover:text-green-600 transition">Livraison Partout au Maroc</p>
                        <p class="text-xs text-gray-400 font-bold">Gratuite à Marrakech dès 300 DH</p>
                    </div>
                </div>

                <!-- الميزة 2 -->
                <div class="flex items-center justify-center gap-4 pt-4 md:pt-0 md:pb-0 pb-4 group cursor-pointer p-4 rounded-2xl hover:bg-slate-50/60 transition duration-300">
                    <div class="h-12 w-12 rounded-2xl bg-blue-50 border border-blue-100/50 flex items-center justify-center text-blue-600 transition-all group-hover:scale-110 group-hover:bg-blue-500 group-hover:text-white shadow-sm duration-300">
                        <i class="fa-solid fa-shield-halved text-lg"></i>
                    </div>
                    <div class="text-left md:pl-4">
                        <p class="text-sm font-black text-gray-900 group-hover:text-blue-600 transition">Produits 100% Authentiques</p>
                        <p class="text-xs text-gray-400 font-bold">Certifiés par les grands laboratoires</p>
                    </div>
                </div>

                <!-- الميزة 3 -->
                <div class="flex items-center justify-center gap-4 pt-4 md:pt-0 group cursor-pointer p-4 rounded-2xl hover:bg-slate-50/60 transition duration-300">
                    <div class="h-12 w-12 rounded-2xl bg-emerald-50 border border-emerald-100/50 flex items-center justify-center text-emerald-600 transition-all group-hover:scale-110 group-hover:bg-emerald-500 group-hover:text-white shadow-sm duration-300">
                        <i class="fa-brands fa-whatsapp text-xl"></i>
                    </div>
                    <div class="text-left md:pl-4">
                        <p class="text-sm font-black text-gray-900 group-hover:text-emerald-600 transition">Conseil Pharmaceutique</p>
                        <p class="text-xs text-gray-400 font-bold">Assistance en direct via WhatsApp</p>
                    </div>
                </div>

            </div>
        </div>
    </section>
   <section class="relative min-h-[85vh] flex items-center bg-gradient-to-br from-green-50/60 via-white to-blue-50/40 overflow-hidden pt-20">
    <div class="absolute top-12 left-10 w-72 h-72 bg-green-200/30 rounded-full blur-3xl animate-float-1 pointer-events-none"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 bg-blue-200/20 rounded-full blur-3xl animate-float-2 pointer-events-none"></div>
    
    <div class="absolute top-1/4 right-1/4 text-green-500/10 text-9xl animate-float-1 pointer-events-none select-none hidden lg:block">🍃</div>
    <div class="absolute bottom-1/4 left-1/3 text-teal-500/10 text-7xl animate-float-2 pointer-events-none select-none hidden lg:block">✨</div>

    <div class="container mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center relative z-10">
        <div class="space-y-6 text-center lg:text-left">
            <span class="inline-flex items-center gap-1.5 bg-green-100/80 backdrop-blur-md text-green-700 text-xs font-black px-4 py-2 rounded-full uppercase tracking-wider shadow-sm border border-green-200/40">
                🌱 100% Produits Authentiques & Bio
            </span>
            
            <h1 class="text-4xl md:text-6xl font-black text-gray-900 tracking-tight leading-[1.15]">
                Votre Santé & Éclat
            </h1>
            
            <p class="text-base text-gray-500 font-medium max-w-xl mx-auto lg:mx-0 leading-relaxed min-h-[60px]">
                <span id="typewriter-paragraph"></span><span class="text-green-600 font-bold animate-pulse">|</span>
            </p>
            
            <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4 pt-4">
                <a href="#produits" class="bg-gradient-to-r from-green-600 to-teal-600 hover:from-green-700 hover:to-teal-700 text-white font-bold px-8 py-4 rounded-2xl shadow-lg shadow-green-200 transition transform hover:-translate-y-0.5 duration-200 text-center">
                    🛒 Explorer la Boutique
                </a>
               
            </div>
        </div>

        <div class="relative flex justify-center lg:justify-end">
            <div class="relative w-full max-w-md md:max-w-xl rounded-[2.5rem] overflow-hidden shadow-2xl border-4 border-white bg-white/40 backdrop-blur-md p-4 transition-transform duration-500 hover:scale-[1.01]">
                <img src="https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?auto=format&fit=crop&w=800&q=80" alt="Parapharmacie" class="rounded-[2rem] w-full h-[450px] object-cover">
                
                <div class="absolute bottom-8 left-8 bg-white/80 backdrop-blur-xl border border-white/40 p-4 rounded-2xl shadow-xl flex items-center gap-3 animate-float-1">
                    <span class="text-3xl bg-green-500 text-white p-2.5 rounded-xl">⚡</span>
                    <div>
                        <h4 class="text-xs font-black text-gray-900 uppercase tracking-wide">Packs Promotionnels</h4>
                        <p class="text-[11px] text-green-700 font-bold mt-0.5">Offres Flash</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const phrases = [
            "Découvrez notre sélection premium de parapharmacie. Des soins d'experts, des compléments certifiés et des offres flash quotidiennes pour prendre soin de vous.",
            "Des produits 100% authentiques sélectionnés par des professionnels pour votre bien-être au quotidien.",
            "Profitez de nos offres flash exclusives avec livraison rapide partout au Maroc."
        ];
        
        let phraseIndex = 0;
        let charIndex = 0;
        let isDeleting = false;
        const targetElement = document.getElementById("typewriter-paragraph");
        let speed = 40; // سرعة الكتابة حيت الفقرة طويلة باش تجي خفيفة ونقية

        function typeParagraph() {
            if (!targetElement) return;
            
            const currentPhrase = phrases[phraseIndex];
            
            if (isDeleting) {
                targetElement.textContent = currentPhrase.substring(0, charIndex - 1);
                charIndex--;
                speed = 15; // سرعة أكبر ف المسح
            } else {
                targetElement.textContent = currentPhrase.substring(0, charIndex + 1);
                charIndex++;
                speed = 30; // سرعة معتدلة ف الكتابة
            }

            // إذا كملت الجملة كاملة
            if (!isDeleting && charIndex === currentPhrase.length) {
                speed = 3000; // كتبقى الجملة باينة 3 ثواني باش يقراها الكليان واللجنة
                isDeleting = true;
            } 
            // إذا تمسحات الجملة كاملة وداز للثانية
            else if (isDeleting && charIndex === 0) {
                isDeleting = false;
                phraseIndex = (phraseIndex + 1) % phrases.length;
                speed = 500;
            }

            setTimeout(typeParagraph, speed);
        }

        typeParagraph();
    });
</script>

<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 reveal">
    <div class="text-center md:text-left mb-8">
        <h2 class="text-xl font-extrabold text-gray-900 uppercase tracking-wide">
            <span class="text-green-600">✦</span> Vos Besoins Spécifiques
        </h2>
        <p class="text-sm text-gray-400 mt-1">Trouvez rapidement la solution adaptée à votre profil</p>
    </div>
    
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        
        <a href="{{ url('/?search=anti') }}#produits" class="group bg-gradient-to-b from-red-50/50 to-white p-5 rounded-2xl border border-red-100/40 text-center hover:shadow-xl hover:border-red-200 transition duration-300">
            <div class="h-12 w-12 bg-red-100 text-red-600 rounded-xl flex items-center justify-center mx-auto mb-3 transform group-hover:rotate-6 transition duration-300">
                <i class="fa-solid fa-wand-magic-sparkles text-xl"></i>
            </div>
            <h3 class="font-bold text-gray-800 text-sm group-hover:text-red-600 transition">Anti-Imperfections</h3>
            <p class="text-[11px] text-gray-400 mt-1 font-medium">Boutons & Taches</p>
        </a>

        <a href="{{ url('/?category=1') }}#produits" class="group bg-gradient-to-b from-amber-50/50 to-white p-5 rounded-2xl border border-amber-100/40 text-center hover:shadow-xl hover:border-amber-200 transition duration-300">
            <div class="h-12 w-12 bg-amber-100 text-amber-600 rounded-xl flex items-center justify-center mx-auto mb-3 transform group-hover:scale-110 transition duration-300">
                <i class="fa-solid fa-sun text-xl"></i>
            </div>
            <h3 class="font-bold text-gray-800 text-sm group-hover:text-amber-600 transition">Écran Solaire</h3>
            <p class="text-[11px] text-gray-400 mt-1 font-medium">Protection UV</p>
        </a>

        <a href="{{ url('/?category=2') }}#produits" class="group bg-gradient-to-b from-blue-50/50 to-white p-5 rounded-2xl border border-blue-100/40 text-center hover:shadow-xl hover:border-blue-200 transition duration-300">
            <div class="h-12 w-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mx-auto mb-3 transform group-hover:-rotate-6 transition duration-300">
                <i class="fa-solid fa-droplet text-xl"></i>
            </div>
            <h3 class="font-bold text-gray-800 text-sm group-hover:text-blue-600 transition">Hydratation</h3>
            <p class="text-[11px] text-gray-400 mt-1 font-medium">Peaux Sèches</p>
        </a>

        <a href="{{ url('/?search=bio') }}#produits" class="group bg-gradient-to-b from-emerald-50/50 to-white p-5 rounded-2xl border border-emerald-100/40 text-center hover:shadow-xl hover:border-emerald-200 transition duration-300">
            <div class="h-12 w-12 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center mx-auto mb-3 transform group-hover:scale-110 transition duration-300">
                <i class="fa-solid fa-seedling text-xl"></i>
            </div>
            <h3 class="font-bold text-gray-800 text-sm group-hover:text-emerald-600 transition">Énergie & Bio</h3>
            <p class="text-[11px] text-gray-400 mt-1 font-medium">Vitamines & Forme</p>
        </a>

        <a href="{{ url('/?search=age') }}#produits" class="group bg-gradient-to-b from-purple-50/50 to-white p-5 rounded-2xl border border-purple-100/40 text-center hover:shadow-xl hover:border-purple-200 transition duration-300">
            <div class="h-12 w-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center mx-auto mb-3 transform group-hover:rotate-12 transition duration-300">
                <i class="fa-solid fa-hourglass-half text-xl"></i>
            </div>
            <h3 class="font-bold text-gray-800 text-sm group-hover:text-purple-600 transition">Anti-Âge & Rides</h3>
            <p class="text-[11px] text-gray-400 mt-1 font-medium">Rétinol & Fermeté</p>
        </a>

        <a href="{{ url('/?search=bebe') }}#produits" class="group bg-gradient-to-b from-pink-50/50 to-white p-5 rounded-2xl border border-pink-100/40 text-center hover:shadow-xl hover:border-pink-200 transition duration-300">
            <div class="h-12 w-12 bg-pink-100 text-pink-600 rounded-xl flex items-center justify-center mx-auto mb-3 transform group-hover:scale-110 transition duration-300">
                <i class="fa-solid fa-baby text-xl"></i>
            </div>
            <h3 class="font-bold text-gray-800 text-sm group-hover:text-pink-600 transition">Bébé & Maman</h3>
            <p class="text-[11px] text-gray-400 mt-1 font-medium">Soins Doux & Laits</p>
        </a>

        <a href="{{ url('/?category=3') }}#produits" class="group bg-gradient-to-b from-indigo-50/50 to-white p-5 rounded-2xl border border-indigo-100/40 text-center hover:shadow-xl hover:border-indigo-200 transition duration-300">
            <div class="h-12 w-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center mx-auto mb-3 transform group-hover:-rotate-6 transition duration-300">
                <i class="fa-solid fa-scissors text-xl"></i>
            </div>
            <h3 class="font-bold text-gray-800 text-sm group-hover:text-indigo-600 transition">Soins Capillaires</h3>
            <p class="text-[11px] text-gray-400 mt-1 font-medium">Chute & Shampoing</p>
        </a>

        <a href="{{ url('/?search=corps') }}#produits" class="group bg-gradient-to-b from-teal-50/50 to-white p-5 rounded-2xl border border-teal-100/40 text-center hover:shadow-xl hover:border-teal-200 transition duration-300">
            <div class="h-12 w-12 bg-teal-100 text-teal-600 rounded-xl flex items-center justify-center mx-auto mb-3 transform group-hover:scale-110 transition duration-300">
                <i class="fa-solid fa-shower text-xl"></i>
            </div>
            <h3 class="font-bold text-gray-800 text-sm group-hover:text-teal-600 transition">Hygiène & Corps</h3>
            <p class="text-[11px] text-gray-400 mt-1 font-medium">Déodorants & Gels</p>
        </a>

    </div>
</section>

    <!-- Flash Sale Section with Countdown -->
@if(isset($flashProduct) && $flashProduct)
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 reveal">
    <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 rounded-3xl overflow-hidden shadow-2xl border border-white/10 relative">
        
        <div class="absolute -right-16 -bottom-16 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -left-16 -top-16 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl"></div>

        <div class="p-8 md:p-12 flex flex-col lg:flex-row items-center justify-between gap-8 relative z-10">
            
            <div class="text-center lg:text-left max-w-xl">
                <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-[10px] font-black bg-red-500 text-white uppercase tracking-widest mb-4 animate-pulse">
                    <i class="fa-solid fa-bolt"></i> Offre Flash Limitée
                </span>
                <h2 class="text-2xl md:text-4xl font-extrabold text-white tracking-tight leading-none">
                    Profitez de <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-orange-400">Offre Spéciale : {{ $flashProduct->nom }}</span>
                </h2>
                
                <div class="mt-4 bg-white/5 rounded-2xl p-4 border border-white/5 text-left">
                    <p class="text-xs font-bold text-amber-400 uppercase tracking-wider mb-2"><i class="fa-solid fa-box-open"></i> Ce pack contient :</p>
                    <ul class="space-y-1.5 text-xs text-slate-200 font-medium pl-1">
                        @php
                            $pack_items = json_decode($flashProduct->pack_products ?? '[]', true) ?? [];
                        @endphp
                        @if(count($pack_items) > 0)
                            @foreach($pack_items as $item)
                                <li class="flex items-center gap-2">
                                    <i class="fa-solid fa-circle-check text-emerald-400 text-[10px]"></i> {{ $item }}
                                </li>
                            @endforeach
                        @else
                            <li class="text-slate-400 italic">Consultez la description pour voir les détails.</li>
                        @endif
                    </ul>
                </div>

                <div class="mt-6 flex justify-center lg:justify-start gap-3 text-white">
                    <div class="bg-white/10 backdrop-blur border border-white/10 rounded-2xl p-3 min-w-[70px] text-center">
                        <span id="timer-hours" class="block text-2xl font-black text-amber-400 tabular-nums">00</span>
                        <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Heures</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur border border-white/10 rounded-2xl p-3 min-w-[70px] text-center">
                        <span id="timer-minutes" class="block text-2xl font-black text-amber-400 tabular-nums">00</span>
                        <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Min</span>
                    </div>
                    <div class="bg-white/10 backdrop-blur border border-white/10 rounded-2xl p-3 min-w-[70px] text-center">
                        <span id="timer-seconds" class="block text-2xl font-black text-orange-400 tabular-nums">00</span>
                        <span class="text-[10px] uppercase font-bold text-slate-400 tracking-wider">Sec</span>
                    </div>
                </div>
            </div>

            <div class="bg-white/5 backdrop-blur-xl border border-white/10 p-6 rounded-2xl text-center min-w-[280px] shadow-xl">
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Prix Spécial Pack</p>
                <div class="flex items-center justify-center gap-3 my-2">
                    <span class="text-3xl font-black text-white">{{ $flashProduct->prix_flash }} DH</span>
                    <span class="text-sm font-bold text-slate-400 line-through">{{ $flashProduct->prix }} DH</span>
                </div>
                <p class="text-[11px] text-emerald-400 font-semibold mb-4"><i class="fa-solid fa-circle-check"></i> Livraison Gratuite incluse</p>
                
                <form action="{{ route('cart.add', $flashProduct->id) }}" method="GET" class="inline">
                    <input type="hidden" name="buy_type" value="pack">
                    <button type="submit" class="w-full bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-black px-6 py-3 rounded-xl text-xs uppercase tracking-wider shadow-md transition transform active:scale-95 cursor-pointer">
                        <i class="fa-solid fa-basket-shopping mr-1"></i> Acheter le Pack
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>


<script>
    let countdownDate = new Date("{{ $flashProduct->flash_sale_end }}").getTime();
    
    let x = setInterval(function() {
        let now = new Date().getTime();
        let distance = countdownDate - now;

        let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById("timer-hours").innerHTML = hours < 10 ? "0" + hours : hours;
        document.getElementById("timer-minutes").innerHTML = minutes < 10 ? "0" + minutes : minutes;
        document.getElementById("timer-seconds").innerHTML = seconds < 10 ? "0" + seconds : seconds;

        if (distance < 0) {
            clearInterval(x);
            document.getElementById("timer-hours").innerHTML = "00";
            document.getElementById("timer-minutes").innerHTML = "00";
            document.getElementById("timer-seconds").innerHTML = "00";
        }
    }, 1000);
</script>
@endif



<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-gradient-to-br from-emerald-500 via-teal-600 to-indigo-600 rounded-3xl p-8 md:p-12 text-center relative overflow-hidden shadow-xl border border-white/10">
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl"></div>
        
        <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-[10px] font-black bg-white text-emerald-600 uppercase tracking-widest mb-4 shadow-sm">
            <i class="fa-solid fa-sparkles"></i> Nouveau & Intelligent
        </span>
        <h2 class="text-2xl md:text-4xl font-black text-white tracking-tight">
            Trouvez Votre Routine Idéale en 1 Minute
        </h2>
        <p class="mt-3 text-sm text-emerald-50 max-w-xl mx-auto font-medium">
            Répondez à 3 questions simples et laissez notre système intelligent analyser vos besoins pour vous proposer les soins parfaits.
        </p>
        <button onclick="toggleDiagnosticModal(true)" class="mt-8 inline-flex items-center gap-2 bg-white text-emerald-700 text-xs font-black px-8 py-4 rounded-xl hover:bg-emerald-50 transition shadow-lg transform hover:scale-105 duration-200 uppercase tracking-wider cursor-pointer">
            <i class="fa-solid fa-wand-magic-sparkles"></i> Commencer le Diagnostic
        </button>
    </div>
</section>
{{-- <section id="packs" class="py-16 bg-white relative">
    <div class="container mx-auto px-6">
        <div class="flex justify-between items-end mb-10">
            <div>
                <span class="text-xs font-black text-amber-600 uppercase tracking-widest block">Offres Limitées</span>
                <h2 class="text-2xl md:text-4xl font-black text-gray-900 mt-2 flex items-center gap-2">
                    ⚡ Nos Packs & Offres Flash
                </h2>
            </div>
            <div class="flex gap-2">
                <button onclick="scrollSlider('left')" class="h-11 w-11 rounded-xl bg-gray-50 border border-gray-200 flex items-center justify-center hover:bg-gray-100 transition shadow-sm cursor-pointer text-lg">🫲</button>
                <button onclick="scrollSlider('right')" class="h-11 w-11 rounded-xl bg-gray-50 border border-gray-200 flex items-center justify-center hover:bg-gray-100 transition shadow-sm cursor-pointer text-lg">🫱</button>
            </div>
        </div>

        <div id="flash-slider" class="flex gap-6 overflow-x-auto no-scrollbar scroll-smooth pb-6 snap-x snap-mandatory">
            
            @foreach($produits->where('is_flash_sale', 1) as $p)
            <div class="min-w-[290px] md:min-w-[340px] max-w-[340px] bg-slate-50 rounded-[2rem] border border-gray-200/60 p-4 snap-start product-card-premium relative">
                <span class="absolute top-4 left-4 bg-amber-500 text-white text-[10px] font-black px-2.5 py-1 rounded-lg uppercase tracking-wider z-20">
                    ⚡ Offre Flash
                </span>
                
                <div class="h-48 w-full rounded-2xl overflow-hidden bg-white border border-gray-100 relative">
                    <img src="{{ $p->image ? asset('storage/'.$p->image) : 'https://placehold.co/300x200.png?text=ParaSante' }}" class="w-full h-full object-cover" alt="{{ $p->nom }}">
                </div>

                <div class="mt-4 space-y-2">
                    <h3 class="text-base font-black text-gray-800 truncate">{{ $p->nom }}</h3>
                    <div class="flex items-center justify-between">
                        <div>
                            <span class="text-xs text-gray-400 line-through block">{{ $p->prix }} DH</span>
                            <span class="text-lg font-black text-green-600">{{ $p->prix_flash }} DH</span>
                        </div>
                        
                        <form action="{{ route('cart.add', $p->id) }}" method="GET" class="m-0">
                            <button type="submit" class="bg-gray-900 hover:bg-green-600 text-white font-bold text-xs py-2.5 px-4 rounded-xl transition-all duration-300 shadow-md flex items-center gap-1 cursor-pointer transform active:scale-95">
                                Ajouter 🛒
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section> --}}

<div id="diagnostic-modal" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl border border-slate-100 overflow-hidden transform transition-all duration-300 flex flex-col max-h-[90vh]">
        
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <div class="flex items-center gap-2">
                <div class="w-2.5 h-2.5 bg-emerald-500 rounded-full animate-pulse"></div>
                <h3 class="font-black text-slate-800 text-base uppercase tracking-wide">Diagnostic Peau Intelligent</h3>
            </div>
            <button onclick="toggleDiagnosticModal(false)" class="text-slate-400 hover:text-slate-600 transition text-lg cursor-pointer">&times;</button>
        </div>

        <div class="p-8 overflow-y-auto flex-1">
            
            <div id="diag-step-1" class="diag-step">
            <h4 class="text-lg font-extrabold text-slate-900 mb-6">Quel est votre type de peau ?</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                
                <label class="flex items-center gap-4 p-4 border-2 border-slate-100 rounded-2xl cursor-pointer">
                    <input type="radio" name="skin_type" value="1" class="w-4 h-4 text-emerald-600">
                    <div><p class="text-sm font-bold text-slate-800">Peau Sèche</p></div>
                </label>

                <label class="flex items-center gap-4 p-4 border-2 border-slate-100 rounded-2xl cursor-pointer">
                    <input type="radio" name="skin_type" value="2" class="w-4 h-4 text-emerald-600">
                    <div><p class="text-sm font-bold text-slate-800">Peau Grasse</p></div>
                </label>
                
            </div>
            <div class="mt-8 flex justify-end">
                <button onclick="nextDiagStep(2)" class="bg-slate-900 text-white text-xs font-bold px-6 py-3 rounded-xl">Suivant</button>
            </div>
        </div>

        <div id="diag-step-2" class="diag-step hidden">
            <h4 class="text-lg font-extrabold text-slate-900 mb-6">Quelle est votre préoccupation majeure ?</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                
                <label class="flex items-center gap-4 p-4 border-2 border-slate-100 rounded-2xl cursor-pointer">
                    <input type="radio" name="skin_problem" value="3" class="w-4 h-4 text-emerald-600">
                    <div><p class="text-sm font-bold text-slate-800">Boutons & Acné</p></div>
                </label>

                <label class="flex items-center gap-4 p-4 border-2 border-slate-100 rounded-2xl cursor-pointer">
                    <input type="radio" name="skin_problem" value="4" class="w-4 h-4 text-emerald-600">
                    <div><p class="text-sm font-bold text-slate-800">Rides & Signes d'âge</p></div>
                </label>
                
            </div>
            <div class="mt-8 flex justify-between">
                <button onclick="nextDiagStep(1)" class="border border-slate-200 text-slate-600 text-xs font-bold px-6 py-3 rounded-xl">Retour</button>
                <button onclick="submitDiagnostic()" class="bg-emerald-600 text-white text-xs font-bold px-6 py-3 rounded-xl">Voir ma routine</button>
            </div>
        </div>

            <div id="diag-step-2" class="diag-step hidden">
                <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider">Étape 2 sur 3</span>
                <h4 class="text-lg font-extrabold text-slate-900 mt-1 mb-6">Quelle est votre préoccupation majeure ?</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <label class="flex items-center gap-4 p-4 border-2 border-slate-100 rounded-2xl hover:border-emerald-500 cursor-pointer transition group">
                        <input type="radio" name="skin_problem" value="acne" class="w-4 h-4 text-emerald-600 focus:ring-emerald-500">
                        <div>
                            <p class="text-sm font-bold text-slate-800 group-hover:text-emerald-600 transition">Boutons & Acné</p>
                            <p class="text-xs text-slate-400 font-medium">Imperfections, points noirs</p>
                        </div>
                    </label>
                    <label class="flex items-center gap-4 p-4 border-2 border-slate-100 rounded-2xl hover:border-emerald-500 cursor-pointer transition group">
                        <input type="radio" name="skin_problem" value="taches" class="w-4 h-4 text-emerald-600 focus:ring-emerald-500">
                        <div>
                            <p class="text-sm font-bold text-slate-800 group-hover:text-emerald-600 transition">Taches & Teint terne</p>
                            <p class="text-xs text-slate-400 font-medium">Hyperpigmentation, manque d'éclat</p>
                        </div>
                    </label>
                    <label class="flex items-center gap-4 p-4 border-2 border-slate-100 rounded-2xl hover:border-emerald-500 cursor-pointer transition group">
                        <input type="radio" name="skin_problem" value="rides" class="w-4 h-4 text-emerald-600 focus:ring-emerald-500">
                        <div>
                            <p class="text-sm font-bold text-slate-800 group-hover:text-emerald-600 transition">Rides & Signes d'âge</p>
                            <p class="text-xs text-slate-400 font-medium">Relâchement, ridules d'expression</p>
                        </div>
                    </label>
                </div>
                <div class="mt-8 flex justify-between">
                    <button onclick="nextDiagStep(1)" class="border border-slate-200 text-slate-600 text-xs font-bold px-6 py-3 rounded-xl hover:bg-slate-50 transition">Retour</button>
                    <button onclick="submitDiagnostic()" class="bg-emerald-600 text-white text-xs font-bold px-6 py-3 rounded-xl hover:bg-emerald-700 transition">Voir ma routine</button>
                </div>
            </div>

            <div id="diag-step-result" class="diag-step hidden">
                <div class="text-center mb-6">
                    <span class="text-3xl">✨</span>
                    <h4 class="text-xl font-black text-slate-900 mt-2">Votre Routine Personnalisée</h4>
                    <p class="text-xs text-slate-400 font-medium mt-1">Voici les produits parfaitement adaptés à votre profil :</p>
                </div>
                
                <div id="diagnostic-products-container" class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-h-64 overflow-y-auto p-1">
                    </div>

                <div class="mt-8 flex justify-center border-t border-slate-100 pt-6">
                    <button onclick="toggleDiagnosticModal(false)" class="bg-slate-900 text-white text-xs font-black px-8 py-3.5 rounded-xl uppercase tracking-wider hover:bg-slate-800 transition">Génial, Merci !</button>
                </div>
            </div>

        </div>
    </div>
</div>

  <main id="produits" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 reveal">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-10 gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-gray-900 sm:text-3xl">
                @if(request('search'))
                    Résultats de recherche pour "{{ request('search') }}"
                @elseif(request('category'))
                    Résultats de la catégorie sélectionnée
                @else
                    Nos Meilleurs Produits
                @endif
            </h2>
            <p class="text-sm text-gray-400 mt-1">Articles authentiques et certifiés</p>
        </div>
        
        @if(request('search') || request('category'))
            <a href="{{ url('/') }}#produits" class="text-sm font-semibold text-red-500 hover:underline flex items-center gap-1">
                <i class="fa-solid fa-circle-xmark"></i> Annuler les filtres
            </a>
        @else
            <a href="#produits" class="text-green-600 font-bold hover:text-green-700 transition text-sm flex items-center gap-1">
                Voir tout <i class="fa-solid fa-arrow-right-long text-xs"></i>
            </a>
        @endif
    </div>

    <div class="flex flex-wrap items-center gap-3 mb-10 bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
        <span class="text-sm font-bold text-gray-400 uppercase tracking-wider mr-2 flex items-center gap-1">
            <i class="fa-solid fa-filter text-xs"></i> Filtrer par :
        </span>
        
        <a href="{{ url('/') }}#produits" 
           class="px-5 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider transition duration-200 {{ !request('category') ? 'bg-green-600 text-white shadow-md shadow-green-600/20' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 border border-gray-100' }}">
              Tous les produits
        </a>

        @foreach($categories as $cat)
            <a href="{{ url('/?category=' . $cat->id) }}#produits" 
               class="px-5 py-2.5 rounded-full text-xs font-bold uppercase tracking-wider transition duration-200 {{ request('category') == $cat->id ? 'bg-green-600 text-white shadow-md shadow-green-600/20' : 'bg-gray-50 text-gray-600 hover:bg-gray-100 border border-gray-100' }}">
                {{ $cat->nom }}
            </a>
        @endforeach
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
        @forelse($produits as $item)
            <div class="group bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition duration-300 flex flex-col justify-between relative">
                <div>
                    <div class="h-52 bg-gray-50 relative overflow-hidden">
                        <a href="{{ route('products.show', $item->id) }}" class="block h-full w-full">
                            @if($item->image)
                                <img src="{{ asset('images/products/' . $item->image) }}" alt="{{ $item->nom }}" class="h-full w-full object-cover group-hover:scale-110 transition duration-500">
                            @else
                                <div class="absolute inset-0 flex items-center justify-center text-gray-400 bg-gray-100">
                                    <span class="text-xs italic font-semibold uppercase tracking-widest">Image non disponible</span>
                                </div>
                            @endif
                        </a>
                        <span class="absolute top-3 left-3 bg-green-500 text-white text-[9px] px-2.5 py-1 rounded-md font-black uppercase tracking-wider z-10 shadow-sm">Nouveau</span>

                        @if($item->stock <= 0)
                            <span class="absolute top-3 right-3 bg-red-600 text-white text-[9px] px-2.5 py-1 rounded-md font-black uppercase tracking-wider z-10 shadow-sm">Rupture</span>
                        @elseif($item->stock <= 3)
                            <span class="absolute top-3 right-3 bg-orange-500 text-white text-[9px] px-2.5 py-1 rounded-md font-black uppercase tracking-wider animate-pulse z-10 shadow-sm">Stock Limité ({{ $item->stock }})</span>
                        @else
                            <span class="absolute top-3 right-3 bg-blue-500 text-white text-[9px] px-2.5 py-1 rounded-md font-black uppercase tracking-wider z-10 shadow-sm">En Stock</span>
                        @endif

                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center z-20">
                            <button type="button" 
                                    onclick="openQuickView('{{ $item->nom }}', '{{ $item->prix }}', '{{ $item->image ? asset('images/products/' . $item->image) : '' }}', '{{ addslashes($item->description) }}', '{{ route('cart.add', $item->id) }}', '{{ $item->stock }}')" 
                                    class="bg-white/90 backdrop-blur text-gray-900 text-xs font-bold py-2.5 px-4 rounded-xl shadow-lg hover:bg-green-600 hover:text-white transition transform translate-y-4 group-hover:translate-y-0 duration-300">
                                <i class="fa-solid fa-eye mr-1"></i> Aperçu rapide
                            </button>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <p class="text-[10px] text-green-600 font-extrabold uppercase tracking-widest mb-1.5">
                            {{ $item->categorie->nom ?? 'Parapharmacie' }}
                        </p>
                        <a href="{{ route('products.show', $item->id) }}">
                            <h3 class="text-base font-bold text-gray-800 group-hover:text-green-600 transition truncate">{{ $item->nom }}</h3>
                        </a>
                        <p class="text-xs text-gray-400 mt-2 line-clamp-2 leading-relaxed">{{ $item->description }}</p>
                    </div>
                </div>

                <div class="p-6 pt-0">
                    <div class="mt-2 flex items-center justify-between border-t border-gray-50 pt-4">
                        <span class="text-lg font-black text-gray-900">{{ $item->prix }} DH</span>
                        
                        <a href="{{ route('cart.add', $item->id) }}?buy_type=normal" class="bg-gray-900 text-white p-3 rounded-xl hover:bg-green-600 hover:shadow-lg hover:shadow-green-600/20 transition transform active:scale-95 duration-200 flex items-center justify-center shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center bg-white rounded-3xl border border-gray-100 shadow-sm">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                    <i class="fa-solid fa-face-frown text-3xl"></i>
                </div>
                <p class="text-gray-500 font-semibold text-lg">Aucun produit trouvé</p>
                <p class="text-sm text-gray-400 mt-1">Essayez d'autres mots clés ou catégories.</p>
            </div>
        @endforelse
    </div>
</main>

    <div id="quickViewModal" class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4 hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-3xl max-w-2xl w-full p-6 md:p-8 shadow-2xl relative transform scale-95 transition-transform duration-300 flex flex-col md:flex-row gap-6 max-h-[90vh] overflow-y-auto">
            <button onclick="closeQuickViewModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 bg-gray-50 h-8 w-8 rounded-full flex items-center justify-center transition z-10">
                <i class="fa-solid fa-xmark"></i>
            </button>
            
            <div class="md:w-1/2 bg-gray-50 rounded-2xl overflow-hidden flex items-center justify-center p-4 border border-gray-100 h-64 md:h-auto">
                <img id="qv-image" src="" alt="" class="max-h-full max-w-full object-contain rounded-xl">
                <div id="qv-no-image" class="hidden text-gray-400 italic text-xs">Image non disponible</div>
            </div>

            <div class="md:w-1/2 flex flex-col justify-between">
                <div>
                    <span id="qv-stock-badge" class="inline-block text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-md mb-3"></span>
                    <h2 id="qv-nom" class="text-xl font-extrabold text-gray-900 leading-tight"></h2>
                    <p id="qv-prix" class="text-2xl font-black text-green-600 my-3"></p>
                    <hr class="border-gray-100 my-3">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Description :</p>
                    <p id="qv-description" class="text-xs text-gray-500 leading-relaxed max-h-32 overflow-y-auto pr-1"></p>
                </div>

                <div class="mt-6">
                    <a id="qv-add-btn" href="#" class="w-full bg-gray-900 text-white font-bold py-3.5 rounded-xl hover:bg-green-600 transition shadow-md flex items-center justify-center gap-2 text-sm uppercase tracking-wider">
                        <i class="fa-solid fa-cart-plus"></i> Ajouter au panier
                    </a>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-gray-950 text-gray-400 pt-16 pb-8 border-t border-gray-900 reveal">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
            
            <div class="space-y-4">
                <a href="/" class="text-2xl font-extrabold text-green-500 tracking-tight block">
                    PARA<span class="text-blue-500">SANTE</span>
                </a>
                <p class="text-sm text-gray-400 leading-relaxed pt-2">
                    Votre partenaire bien-être et santé de confiance à Marrakech. Nous offrons une sélection rigoureuse de produits parapharmaceutiques de qualité supérieure pour répondre à tous vos besoins.
                </p>
                <div class="flex items-center gap-4 pt-4">
                    <a href="#" class="h-9 w-9 bg-gray-900 rounded-full flex items-center justify-center text-white hover:bg-blue-600 hover:scale-110 transition duration-200"><i class="fa-brands fa-facebook-f text-sm"></i></a>
                    <a href="#" class="h-9 w-9 bg-gray-900 rounded-full flex items-center justify-center text-white hover:bg-pink-600 hover:scale-110 transition duration-200"><i class="fa-brands fa-instagram text-sm"></i></a>
                    <a href="#" class="h-9 w-9 bg-gray-900 rounded-full flex items-center justify-center text-white hover:bg-green-600 hover:scale-110 transition duration-200"><i class="fa-brands fa-whatsapp text-sm"></i></a>
                </div>
            </div>

            <div>
                <h3 class="text-white font-bold text-base uppercase tracking-wider mb-5 border-l-4 border-green-500 pl-3">Liens Utiles</h3>
                <ul class="space-y-3 text-sm">
                    <li><a href="/" class="hover:text-green-400 transition flex items-center gap-1.5"> <i class="fa-solid fa-chevron-right text-[10px]"></i> Accueil</a></li>
                    <li><button onclick="openFrontModal('aproposModal')" class="hover:text-green-400 transition flex items-center gap-1.5"> <i class="fa-solid fa-chevron-right text-[10px]"></i> À Propos de nous</button></li>
                    <li><button onclick="openFrontModal('savModal')" class="hover:text-green-400 transition flex items-center gap-1.5"> <i class="fa-solid fa-chevron-right text-[10px]"></i> Service Après-Vente</button></li>
                </ul>
            </div>

            <div>
                <h3 class="text-white font-bold text-base uppercase tracking-wider mb-5 border-l-4 border-blue-500 pl-3">Contactez-nous</h3>
                <ul class="space-y-4 text-sm text-gray-400">
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-location-dot text-blue-500 mt-1"></i>
                        <span>Boulevard Abdelkrim Al Khattabi, Gueliz,<br><b class="text-gray-300">Marrakech, Maroc</b></span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fa-solid fa-phone text-green-500"></i>
                        <span class="text-gray-300 font-medium">+212 6 00 00 00 00</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fa-solid fa-envelope text-red-400"></i>
                        <span class="text-gray-300">contact@parapharmacie.ma</span>
                    </li>
                </ul>
            </div>

            <div>
                <h3 class="text-white font-bold text-base uppercase tracking-wider mb-5 border-l-4 border-emerald-500 pl-3">Disponibilité</h3>
                <p class="text-sm leading-relaxed mb-3">Notre équipe de pharmaciens et conseillers est à votre écoute :</p>
                <div class="bg-gray-900/60 p-4 rounded-xl border border-gray-900">
                    <p class="text-xs font-bold text-green-400 uppercase tracking-wider mb-1">📅 Lundi - Samedi</p>
                    <p class="text-sm text-white font-semibold">09:00 H – 20:00 H</p>
                </div>
            </div>

        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 border-t border-gray-950 pt-8 text-center text-xs flex flex-col sm:flex-row justify-between items-center gap-4 text-gray-500">
            <p>&copy; 2026 ParaSante. Tous droits réservés. Réalisé dans le cadre du projet de fin d'études.</p>
            <div class="flex gap-4 text-sm">
                <i class="fa-brands fa-cc-visa text-gray-600 hover:text-white transition"></i>
                <i class="fa-brands fa-cc-mastercard text-gray-600 hover:text-white transition"></i>
                <i class="fa-solid fa-truck text-gray-600 hover:text-white transition"></i>
            </div>
        </div>
    </footer>

    <div id="aproposModal" class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4 hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-3xl max-w-2xl w-full p-8 shadow-2xl relative transform scale-95 transition-transform duration-300 overflow-hidden">
            <div class="absolute -right-16 -top-16 w-32 h-32 bg-green-50 rounded-full"></div>
            <button onclick="closeFrontModal('aproposModal')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 bg-gray-50 h-8 w-8 rounded-full flex items-center justify-center transition"><i class="fa-solid fa-xmark"></i></button>
            <div class="flex items-center gap-3 mb-6">
                <div class="h-12 w-12 bg-green-100 rounded-2xl flex items-center justify-center text-green-600 text-xl"><i class="fa-solid fa-building-shield"></i></div>
                <h2 class="text-2xl font-extrabold text-gray-900">À Propos de ParaSante</h2>
            </div>
            <div class="space-y-4 text-gray-600 leading-relaxed text-sm">
                <p><b>ParaSante</b> est une plateforme e-commerce marocaine spécialisée dans la distribution de produits parapharmaceutiques, de soins cosmétiques, et de compléments alimentaires de haute qualité.</p>
                <p>Fondée à <b>Marrakech</b> par des professionnels passionnés, notre mission est de faciliter l'accès au bien-être au quotidien. Nous travaillons en étroite collaboration avec les plus grands laboratoires pour vous garantir l’authenticité de chaque product en rayon.</p>
                <p class="bg-gray-50 p-4 rounded-xl border-l-4 border-green-500 font-medium italic text-gray-700">"Votre santé est notre priorité absolue. Nous nous engageons à offrir l’excellence, de la commande jusqu'à la livraison à votre porte."</p>
            </div>
        </div>
    </div>

    <div id="savModal" class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4 hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-3xl max-w-2xl w-full p-8 shadow-2xl relative transform scale-95 transition-transform duration-300">
            <button onclick="closeFrontModal('savModal')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 bg-gray-50 h-8 w-8 rounded-full flex items-center justify-center transition"><i class="fa-solid fa-xmark"></i></button>
            <div class="flex items-center gap-3 mb-6">
                <div class="h-12 w-12 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 text-xl"><i class="fa-solid fa-truck-ramp-box"></i></div>
                <h2 class="text-2xl font-extrabold text-gray-900">Service Après-Vente (SAV)</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2 mb-2"> <i class="fa-solid fa-truck text-green-500"></i> Livraison Rapide</h3>
                    <p class="text-gray-500 text-xs leading-relaxed">Livraison à domicile partout au Maroc. Gratuite à Marrakech pour toute commande supérieure à 300 DH.</p>
                </div>
                <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2 mb-2"> <i class="fa-solid fa-rotate-left text-blue-500"></i> Retours Souples</h3>
                    <p class="text-gray-500 text-xs leading-relaxed">Possibilité d'échange ou de retour des produits non ouverts sous un délai de 7 jours suivant la réception.</p>
                </div>
                <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2 mb-2"> <i class="fa-solid fa-user-doctor text-emerald-500"></i> Conseil d'Expert</h3>
                    <p class="text-gray-500 text-xs leading-relaxed">Besoin d'un conseil ? Notre équipe vous accompagne par téléphone ou WhatsApp pour choisir le bon produit.</p>
                </div>
                <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2 mb-2"> <i class="fa-solid fa-shield-halved text-purple-500"></i> Garantie 100% Authentique</h3>
                    <p class="text-gray-500 text-xs leading-relaxed">Tous nos produits proviennent directement de circuits de distribution officiels et contrôlés.</p>
                </div>
            </div>
        </div>
    </div>

    <div id="contactModal" class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4 hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-3xl max-w-4xl w-full p-8 shadow-2xl relative transform scale-95 transition-transform duration-300 flex flex-col md:flex-row gap-8">
            <button onclick="closeFrontModal('contactModal')" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 bg-gray-50 h-8 w-8 rounded-full flex items-center justify-center transition z-10"><i class="fa-solid fa-xmark"></i></button>
            
            <div class="md:w-1/2 space-y-6">
                <div>
                    <h2 class="text-2xl font-extrabold text-gray-900 mb-2">Contactez-nous</h2>
                    <p class="text-sm text-gray-500">Une question ou une suggestion ? N'hésitez pas à nous laisser un message.</p>
                </div>
                <div class="space-y-4 text-sm text-gray-600">
                    <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-xl">
                        <i class="fa-solid fa-phone text-green-600 text-lg"></i>
                        <div><p class="font-bold text-xs text-gray-400 uppercase">Téléphone</p><p class="text-gray-800 font-semibold">+212 6 00 00 00 00</p></div>
                    </div>
                    <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-xl">
                        <i class="fa-solid fa-envelope text-blue-600 text-lg"></i>
                        <div><p class="font-bold text-xs text-gray-400 uppercase">E-mail</p><p class="text-gray-800 font-semibold">contact@parapharmacie.ma</p></div>
                    </div>
                    <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-xl">
                        <i class="fa-solid fa-location-dot text-red-500 text-lg"></i>
                        <div><p class="font-bold text-xs text-gray-400 uppercase">Adresse</p><p class="text-gray-800 font-semibold">Gueliz, Marrakech, Maroc</p></div>
                    </div>
                </div>
            </div>

            <div class="md:w-1/2 bg-gray-50 p-6 rounded-2xl border border-gray-100">
                <h3 class="font-bold text-gray-800 text-base mb-4">Envoyer un message</h3>
              <form action="{{ route('contact.store') }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    <div>
                        <label class="block font-bold text-gray-500 mb-1">Nom complet</label>
                        <input type="text" name="nom" required class="w-full border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none" placeholder="Ex: Anas Rouhi">
                    </div>
                    <div>
                        <label class="block font-bold text-gray-500 mb-1">Adresse Email</label>
                        <input type="email" name="email" required class="w-full border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none" placeholder="votre@email.com">
                    </div>
                    <div>
                        <label class="block font-bold text-gray-500 mb-1">Message</label>
                        <textarea name="message" required rows="3" class="w-full border border-gray-200 rounded-lg p-2.5 focus:ring-2 focus:ring-green-500 focus:outline-none" placeholder="Écrivez votre message ici..."></textarea>
                    </div>
                    <button type="submit" class="w-full bg-green-600 text-white font-bold py-3 rounded-lg hover:bg-green-700 transition uppercase tracking-wider text-center">
                        Envoyer
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // دالات فتح وإغلاق المودالز العادية ديالك
        function openFrontModal(id) {
            const modal = document.getElementById(id);
            if(modal) {
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.classList.remove('opacity-0');
                    modal.querySelector('.transform').classList.remove('scale-95');
                }, 10);
            }
        }

        function closeFrontModal(id) {
            const modal = document.getElementById(id);
            if(modal) {
                modal.classList.add('opacity-0');
                modal.querySelector('.transform').classList.add('scale-95');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }
        }

        // دالة الـ Quick View الديناميكية الجديدة
        function openQuickView(nom, prix, imageSrc, description, actionUrl, stock) {
            document.getElementById('qv-nom').innerText = nom;
            document.getElementById('qv-prix').innerText = prix + ' DH';
            document.getElementById('qv-description').innerText = description ? description : 'Aucune description disponible pour ce produit.';
            document.getElementById('qv-add-btn').setAttribute('href', actionUrl);

            const imgEl = document.getElementById('qv-image');
            const noImgEl = document.getElementById('qv-no-image');
            
            if(imageSrc) {
                imgEl.src = imageSrc;
                imgEl.alt = nom;
                imgEl.classList.remove('hidden');
                noImgEl.classList.add('hidden');
            } else {
                imgEl.classList.add('hidden');
                noImgEl.classList.remove('hidden');
            }

            const badge = document.getElementById('qv-stock-badge');
            badge.className = "inline-block text-[10px] font-black uppercase tracking-wider px-2.5 py-1 rounded-md mb-3";
            if(parseInt(stock) <= 0) {
                badge.innerText = "Rupture";
                badge.classList.add('bg-red-600', 'text-white');
            } else if(parseInt(stock) <= 3) {
                badge.innerText = "Stock Limité (" + stock + ")";
                badge.classList.add('bg-orange-500', 'text-white', 'animate-pulse');
            } else {
                badge.innerText = "En Stock";
                badge.classList.add('bg-blue-500', 'text-white');
            }

            const modal = document.getElementById('quickViewModal');
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.querySelector('.transform').classList.remove('scale-95');
            }, 10);
        }

        function closeQuickViewModal() {
            const modal = document.getElementById('quickViewModal');
            modal.classList.add('opacity-0');
            modal.querySelector('.transform').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // تأثير السكرول (Reveal Animation)
        window.addEventListener('scroll', () => {
            const reveals = document.querySelectorAll('.reveal');
            reveals.forEach(reveal => {
                const windowHeight = window.innerHeight;
                const revealTop = reveal.getBoundingClientRect().top;
                const revealPoint = 150;
                if(revealTop < windowHeight - revealPoint) {
                    reveal.classList.add('active');
                }
            });
        });
        
        // تشغيل تأثير السكرول عند أول تحميل للصفحة
        window.dispatchEvent(new Event('scroll'));
    </script>


    <script>
        // 1. فتح الـ Modals بسلاسة و أنيميشن نقي
        function openFrontModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.firstElementChild.classList.remove('scale-95');
            }, 20);
        }

        // 2. إغلاق الـ Modals
        function closeFrontModal(id) {
            const modal = document.getElementById(id);
            modal.classList.add('opacity-0');
            modal.firstElementChild.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // 3. تأثير الـ Reveal الجميل عند الهبوط (Scroll Animation) اللي كيبهر اللجنة
        function revealElements() {
            const reveals = document.querySelectorAll('.reveal');
            reveals.forEach(windowElement => {
                const windowHeight = window.innerHeight;
                const elementTop = windowElement.getBoundingClientRect().top;
                const elementVisible = 100;
                
                if (elementTop < windowHeight - elementVisible) {
                    windowElement.classList.add('active');
                }
            });
        }
        window.addEventListener('scroll', revealElements);
        // تفعيلها في البداية للملفات الظاهرة
        document.addEventListener("DOMContentLoaded", revealElements);

        document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault(); // حبس الفورم ما تفرشش الصفحة

        let formData = new FormData(this);
        
        // إظهار Loading خفيف بـ SweetAlert
        Swal.fire({
            title: "Envoi en cours...",
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

    fetch("{{ route('contact.store') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
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
                }
            })
            .catch(error => {
                Swal.fire("Erreur", "Une erreur est survenue lors de l'envoi.", "error");
            });
        });
    </script>

    @if(session('success_order'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Commande Réussie !',
            text: "{{ session('success_order') }}",
            confirmButtonColor: '#16a34a'
        });
    </script>
    @endif

    <script>
                // إعداد تاريخ انتهاء العرض (مثلاً: كيسالي من هنا 24 ساعة ملي كيدخل الزبون، أو حدد تاريخ ثابت)
        // هنا غنديروه كيسالي دائماً مع نهاية اليوم الحالي باش يبقى ديما خدام
        let countdownDate = new Date();
        countdownDate.setHours(23, 59, 59, 999); 

        const updateTimer = () => {
            const now = new Date().getTime();
            const distance = countdownDate - now;

            // حساب الساعات، الدقائق والثواني
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // عرض النتيجة ف الـ HTML مع إضافة 0 إذا كان الرقم أقل من 10
            document.getElementById("timer-hours").innerText = hours < 10 ? "0" + hours : hours;
            document.getElementById("timer-minutes").innerText = minutes < 10 ? "0" + minutes : minutes;
            document.getElementById("timer-seconds").innerText = seconds < 10 ? "0" + seconds : seconds;

            // إذا تسالا الوقت، كنعاودو الـ العداد (باش السيت ما يبانش فيه خطأ قدام اللجنة)
            if (distance < 0) {
                countdownDate = new Date();
                countdownDate.setHours(23, 59, 59, 999);
            }
        };

        // تشغيل العداد مباشرة وتحديثه كل ثانية
        updateTimer();
        setInterval(updateTimer, 1000);
    </script>

    <script>
            document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('live-search-input');
        const resultsDropdown = document.getElementById('search-results-dropdown');

        if (searchInput && resultsDropdown) {
            searchInput.addEventListener('input', function() {
                const query = this.value.trim();

                // إذا مسح الكتابة، نخفيو الصندوق ونحبسو
                if (query.length < 2) {
                    resultsDropdown.innerHTML = '';
                    resultsDropdown.classList.add('hidden');
                    return;
                }

                // إرسال الطلب لـ Laravel عبر Fetch API
                fetch(`/live-search?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(products => {
                        resultsDropdown.innerHTML = ''; // مسح النتائج القديمة

                        if (products.length === 0) {
                            // إذا مالقاش برودوي
                            resultsDropdown.innerHTML = `
                                <div class="p-4 text-center text-sm text-slate-400 font-medium">
                                    <i class="fa-solid fa-circle-info mr-1"></i> Aucun produit trouvé
                                </div>`;
                            resultsDropdown.classList.remove('hidden');
                            return;
                        }

                        // عرض المنتجات اللي لقانا السيستم
                        products.forEach(product => {
                            // تحديد مسار الصورة الافتراضية أو الصورة من الداتابيز
                            const imageSrc = product.image ? `/images/products/${product.image}` : '/images/default-product.png';
                            
                            const productItem = document.createElement('a');
                            productItem.href = `/product/${product.id}`;
                            productItem.className = 'flex items-center gap-4 p-3 hover:bg-slate-50 transition duration-150 group';
                            
                            productItem.innerHTML = `
                                <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden flex-shrink-0 border border-slate-100">
                                    <img src="${imageSrc}" alt="${product.nom}" class="w-full h-full object-cover group-hover:scale-105 transition duration-200">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-semibold text-slate-800 truncate group-hover:text-indigo-600 transition">${product.nom}</h4>
                                    <p class="text-xs font-bold text-indigo-600 mt-0.5">${product.prix} DH</p>
                                </div>
                                <div class="text-slate-300 group-hover:text-indigo-500 pr-2 transition">
                                    <i class="fa-solid fa-chevron-right text-xs"></i>
                                </div>
                            `;
                            resultsDropdown.appendChild(productItem);
                        });

                        resultsDropdown.classList.remove('hidden');
                    })
                    .catch(error => console.error('Error fetching search results:', error));
            });

            // إخفاء الصندوق إلا كليكا المستعمل ف أي بلاصة خرى ف الشاشة
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !resultsDropdown.contains(e.target)) {
                    resultsDropdown.classList.add('hidden');
                }
            });
        }
    });
    </script>

    <script>
        // فتح وإغلاق المودال
function toggleDiagnosticModal(show) {
    const modal = document.getElementById('diagnostic-modal');
    if (show) {
        modal.classList.remove('hidden');
        nextDiagStep(1); // البدء دائماً من الخطوة الأولى فاش يتفتح
    } else {
        modal.classList.add('hidden');
    }
}

// التنقل بين الخطوات
function nextDiagStep(step) {
    // إخفاء جميع الخطوات
    document.querySelectorAll('.diag-step').forEach(el => el.classList.add('hidden'));
    
    // إظهار الخطوة المحددة
    if (step === 1) document.getElementById('diag-step-1').classList.remove('hidden');
    if (step === 2) document.getElementById('diag-step-2').classList.remove('hidden');
    if (step === 'result') document.getElementById('diag-step-result').classList.remove('hidden');
}

// إرسال الاستبيان ومعالجة النتيجة بـ AJAX
function submitDiagnostic() {
    const skinTypeEl = document.querySelector('input[name="skin_type"]:checked');
    const skinProblemEl = document.querySelector('input[name="skin_problem"]:checked');

    // التأكد بلي المستعمل جاوب على الأسئلة
    if (!skinTypeEl || !skinProblemEl) {
        alert('Veuillez sélectionner votre type de peau et votre préoccupation majeure.');
        return;
    }

    const skinType = skinTypeEl.value;
    const skinProblem = skinProblemEl.value;
    const container = document.getElementById('diagnostic-products-container');
    
    // إظهار رسالة شحن خفيفة (Loading)
    container.innerHTML = '<div class="col-span-2 text-center text-slate-500 py-8"><i class="fa-solid fa-spinner animate-spin text-xl mr-2"></i> Analyse de votre peau en cours...</div>';
    nextDiagStep('result');

    // إرسال الطلب لـ Laravel بـ Fetch API
    // كود الجافاسكريبت المطور لعرض النتائج مقسمة باحترافية
fetch(`/diagnostic-submit?type=${skinType}&problem=${skinProblem}`)
    .then(response => response.json())
    .then(products => {
        container.innerHTML = ''; 

        if (products.length === 0) {
            container.innerHTML = '<div class="col-span-2 text-center text-slate-400 py-4">Aucun produit trouvé.</div>';
            return;
        }

        // إنشاء العناوين الاحترافية داخل المودال
        let typeHtml = `<div class="col-span-2"><h5 class="text-xs font-black text-indigo-600 uppercase tracking-wider mb-2">1. Base Hydratation (Pour votre type de peau)</h5></div>`;
        let problemHtml = `<div class="col-span-2 mt-4"><h5 class="text-xs font-black text-emerald-600 uppercase tracking-wider mb-2">2. Traitement Ciblé (Pour votre préoccupation)</h5></div>`;

        let hasTypeProd = false;
        let hasProblemProd = false;

        products.forEach(product => {
            const img = product.image ? `/images/products/${product.image}` : '/images/default-product.png';
            const cardHtml = `
                <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-2xl border border-slate-150 shadow-xs">
                    <img src="${img}" class="w-12 h-12 object-cover rounded-xl border bg-white">
                    <div class="flex-1 min-w-0">
                        <h6 class="text-xs font-bold text-slate-800 truncate">${product.nom}</h6>
                        <p class="text-xs font-black text-slate-900 mt-0.5">${product.prix} DH</p>
                    </div>
                    <a href="/product/${product.id}" class="text-[10px] font-black bg-white border border-slate-200 text-slate-700 px-2.5 py-1.5 rounded-lg hover:bg-slate-900 hover:text-white transition">Voir</a>
                </div>
            `;

            // إذا كان البرودوي تابع لكاتيكوري نوع البشرة
            if(product.category_id == skinType) {
                typeHtml += cardHtml;
                hasTypeProd = true;
            } else { // إذا كان تابع لكاتيكوري المشكل
                problemHtml += cardHtml;
                hasProblemProd = true;
            }
        });

        // دمج كولشي ف الـ Modal
        container.innerHTML = (hasTypeProd ? typeHtml : '') + (hasProblemProd ? problemHtml : '');
    });
}
    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // كنتاكدو واش الرابط فيه #produits
        if (window.location.hash === "#produits") {
            const targetElement = document.getElementById("produits");
            if (targetElement) {
                // كنعطيوها مهلة صغيرة د 300ms باش يتشارجاو الصور والأنميشنز عاد يهبط
                setTimeout(() => {
                    targetElement.scrollIntoView({ 
                        behavior: "smooth", 
                        block: "start" 
                    });
                }, 300);
            }
        }
    });
</script>
<script>
    // 🌟 1. تأثير الكتابة التلقائية (Typewriter Effect)
    const words = ["Naturels.", "Certifiés.", "Pour Votre Peau.", "Au Meilleur Prix."];
    let wordIndex = 0;
    let timer;

    function typingEffect() {
        const targetElement = document.getElementById('typewriter-text');
        if (!targetElement) return; 
        
        let currentWord = words[wordIndex].split("");
        var loopTyping = function() {
            if (currentWord.length > 0) {
                targetElement.innerHTML += currentWord.shift();
            } else {
                setTimeout(deletingEffect, 2000);
                return false;
            }
            timer = setTimeout(loopTyping, 100);
        };
        loopTyping();
    }

    function deletingEffect() {
        const targetElement = document.getElementById('typewriter-text');
        if (!targetElement) return;

        let currentWord = words[wordIndex].split("");
        var loopDeleting = function() {
            if (currentWord.length > 0) {
                currentWord.pop();
                targetElement.innerHTML = currentWord.join("");
            } else {
                if (words.length > (wordIndex + 1)) wordIndex++;
                else wordIndex = 0;
                setTimeout(typingEffect, 500);
                return false;
            }
            timer = setTimeout(loopDeleting, 60);
        };
        loopDeleting();
    }

    // 🌟 2. تأثير الظهور السينمائي المطور عند النزول (Scroll Reveal via Intersection Observer)
    function initScrollReveal() {
        // الكود كيمشي يقلب على كاع الكروت والـ Sections اللي عطيناهم هاد الكلاسات
        const revealElements = document.querySelectorAll('.product-card-premium, #packs h2, #packs .flex, .reveal');
        
        revealElements.forEach(el => el.classList.add('reveal'));

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active'); // كيزيد كلاس active باش تظهر الحركة
                    observer.unobserve(entry.target); // كيحبس المراقبة باش السيت يبقى خفيف وطاير
                }
            });
        }, {
            threshold: 0.12, // يظهر المنتج ملي يدخل منو شوية للشاشة
            rootMargin: "0px 0px -20px 0px"
        });

        revealElements.forEach(el => observer.observe(el));
    }

    // 🌟 3. التحكم في أزرار السلايدر الأفقي (Packs Slider)
    function scrollSlider(direction) {
        const slider = document.getElementById('flash-slider');
        const scrollAmount = 350;
        if(slider) {
            if(direction === 'left') {
                slider.scrollLeft -= scrollAmount;
            } else {
                slider.scrollLeft += scrollAmount;
            }
        }
    }

    // تشغيل كلشي دقة واحدة غير الصفحة تكمل التحميل
    document.addEventListener("DOMContentLoaded", function() {
        typingEffect();    
        initScrollReveal(); 
    });
</script>
    
@include('components.chatbot')

</body>
</html>