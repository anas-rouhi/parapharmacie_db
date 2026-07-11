{{--
    Pied de page réutilisable pour tout le site : <x-site-footer />
    Auto-suffisant (icônes SVG inline) — ne dépend d'aucune librairie externe.
--}}
<footer class="bg-gray-950 text-gray-400 pt-16 pb-8 border-t border-gray-900 mt-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">

        {{-- Marque + réseaux --}}
        <div class="space-y-4">
            <a href="{{ route('home') }}" class="flex items-center gap-2.5">
                <span class="h-10 w-10 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-lg shadow-lg shadow-emerald-600/25">🌱</span>
                <span class="text-2xl font-black tracking-tight leading-none">
                    <span class="text-white">PARA</span><span class="text-emerald-500">SANTE</span>
                </span>
            </a>
            <p class="text-sm text-gray-400 leading-relaxed pt-1">
                Votre partenaire bien-être et santé de confiance au Maroc. Une sélection rigoureuse de produits parapharmaceutiques 100% authentiques, livrés rapidement à domicile.
            </p>
            <div class="flex items-center gap-3 pt-2">
                <a href="#" aria-label="Facebook" class="h-9 w-9 bg-gray-900 rounded-full flex items-center justify-center text-white hover:bg-blue-600 hover:scale-110 transition duration-200">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                </a>
                <a href="#" aria-label="Instagram" class="h-9 w-9 bg-gray-900 rounded-full flex items-center justify-center text-white hover:bg-pink-600 hover:scale-110 transition duration-200">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                </a>
                <a href="#" aria-label="WhatsApp" class="h-9 w-9 bg-gray-900 rounded-full flex items-center justify-center text-white hover:bg-green-600 hover:scale-110 transition duration-200">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.885-9.885 9.885M20.52 3.449C18.24 1.245 15.24 0 12.045 0 5.463 0 .104 5.335.101 11.892c0 2.096.549 4.142 1.595 5.945L0 24l6.335-1.652a12.062 12.062 0 005.71 1.454h.006c6.585 0 11.946-5.335 11.949-11.893a11.821 11.821 0 00-3.487-8.46"/></svg>
                </a>
            </div>
        </div>

        {{-- Liens utiles --}}
        <div>
            <h3 class="text-white font-bold text-base uppercase tracking-wider mb-5 border-l-4 border-emerald-500 pl-3">Liens Utiles</h3>
            <ul class="space-y-3 text-sm">
                <li><a href="{{ route('home') }}" class="hover:text-emerald-400 transition">Accueil</a></li>
                <li><a href="{{ route('boutique') }}" class="hover:text-emerald-400 transition">Boutique</a></li>
                <li><a href="{{ route('pages.apropos') }}" class="hover:text-emerald-400 transition">À Propos de nous</a></li>
                <li><a href="{{ route('pages.sav') }}" class="hover:text-emerald-400 transition">Service Après-Vente</a></li>
                <li><a href="{{ route('pages.contact') }}" class="hover:text-emerald-400 transition">Contact</a></li>
            </ul>
        </div>

        {{-- Contact --}}
        <div>
            <h3 class="text-white font-bold text-base uppercase tracking-wider mb-5 border-l-4 border-teal-500 pl-3">Contactez-nous</h3>
            <ul class="space-y-4 text-sm text-gray-400">
                <li class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-teal-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.828 0l-4.243-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>Boulevard Abdelkrim Al Khattabi, Gueliz,<br><b class="text-gray-300">Marrakech, Maroc</b></span>
                </li>
                <li class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span class="text-gray-300 font-medium">+212 6 00 00 00 00</span>
                </li>
                <li class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-rose-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span class="text-gray-300">contact@parasante.ma</span>
                </li>
            </ul>
        </div>

        {{-- Disponibilité --}}
        <div>
            <h3 class="text-white font-bold text-base uppercase tracking-wider mb-5 border-l-4 border-green-500 pl-3">Disponibilité</h3>
            <p class="text-sm leading-relaxed mb-3">Notre équipe de pharmaciens et conseillers est à votre écoute :</p>
            <div class="bg-gray-900/60 p-4 rounded-xl border border-gray-900">
                <p class="text-xs font-bold text-emerald-400 uppercase tracking-wider mb-1">📅 Lundi - Samedi</p>
                <p class="text-sm text-white font-semibold">09:00 H – 20:00 H</p>
            </div>
        </div>

    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 border-t border-gray-900 pt-8 text-center text-xs flex flex-col sm:flex-row justify-between items-center gap-4 text-gray-500">
        <p>&copy; {{ date('Y') }} ParaSante. Tous droits réservés.</p>
        <div class="flex items-center gap-3 text-[11px] font-semibold text-gray-400">
            <span class="bg-gray-900 px-2.5 py-1 rounded border border-gray-800">💵 Cash à la livraison</span>
            <span class="bg-gray-900 px-2.5 py-1 rounded border border-gray-800">💳 CMI / Visa</span>
        </div>
    </div>
</footer>
