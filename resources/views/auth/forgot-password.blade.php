<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ParaSante | Mot de passe oublié</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            overflow: hidden;
        }

        /* أنيميشن الطفو والجاذبية المستقرة */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .floating-card {
            animation: float 6s ease-in-out infinite;
        }

        /* الكانفاس التفاعلي */
        #particle-canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        /* تأثير الزجاج الفاخر عالي النقاء */
        .glass-panel {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
    </style>
</head>
<body class="bg-slate-950 min-h-screen flex items-center justify-center p-4 antialiased relative">

    <!-- جافاسكريبت كانفاس للخلفية الحية المنسجمة مع باقي الصفحات -->
    <canvas id="particle-canvas"></canvas>

    <div class="w-full max-w-md relative z-10 floating-card">
        
        <!-- Premium Glassmorphic Card with Soft Emerald Glow -->
        <div class="glass-panel rounded-3xl border border-white/40 shadow-[0_0_50px_rgba(16,185,129,0.15)] p-8 sm:p-10 transition-all duration-500 hover:shadow-[0_0_60px_rgba(16,185,129,0.25)] hover:border-emerald-200/50">
            
            <!-- Header Logo & Title -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center gap-2 mb-3">
                    <div class="h-11 w-11 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center font-extrabold text-white shadow-lg shadow-emerald-600/30">🌱</div>
                    <span class="text-2xl font-black tracking-tight text-slate-900">
                        PARA<span class="text-emerald-600">SANTE</span>
                    </span>
                </div>
                <h2 class="text-lg font-bold text-slate-800 tracking-tight">Mot de passe oublié ?</h2>
                <p class="text-xs text-slate-500 mt-1">Entrez votre email et nous vous enverrons un lien de réinitialisation.</p>
            </div>

            <!-- Success message (Laravel Status) -->
            @if (session('status'))
                <div class="mb-6 p-4 bg-emerald-50/90 backdrop-blur-sm border border-emerald-100 rounded-2xl text-center text-xs text-emerald-700 font-semibold shadow-sm flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf

                <!-- Email Input Field -->
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-700 tracking-wide block">Adresse Email</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="off" placeholder="votre@email.com"
                            class="w-full pl-10 pr-4 py-3 bg-white/50 border border-slate-200/80 rounded-xl text-sm font-medium text-slate-800 placeholder-slate-400 focus:outline-none focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-500/5 transition-all duration-200">
                    </div>
                    
                    @error('email')
                        <div class="text-[11px] text-rose-500 font-semibold mt-1 flex items-center gap-1">
                            <span class="w-1 h-1 rounded-full bg-rose-500"></span>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Interactive Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold py-3 px-4 rounded-xl text-sm transition-all duration-200 active:scale-[0.98] shadow-md shadow-emerald-600/10 hover:shadow-xl hover:shadow-emerald-600/20 cursor-pointer flex items-center justify-center gap-2">
                        <span>Envoyer le lien</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    </button>
                </div>
            </form>

            <!-- Back to Login Link -->
            <div class="text-center mt-8 pt-6 border-t border-slate-100">
                <p class="text-xs font-medium text-slate-400">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 font-bold text-emerald-600 hover:text-emerald-700 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Retour à la connexion
                    </a>
                </p>
            </div>

        </div>
    </div>

    <!-- JavaScript التفاعلية الموحدة لتحريك جزيئات الخلفية بشكل حيوي -->
    <script>
        const canvas = document.getElementById('particle-canvas');
        const ctx = canvas.getContext('2d');

        let particles = [];
        const particleCount = 60;

        function resizeCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
        }
        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();

        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width;
                this.y = Math.random() * canvas.height;
                this.radius = Math.random() * 2 + 1;
                this.vx = (Math.random() - 0.5) * 0.4;
                this.vy = (Math.random() - 0.5) * 0.4;
                this.alpha = Math.random() * 0.5 + 0.2;
            }

            draw() {
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(16, 185, 129, ${this.alpha})`;
                ctx.fill();
            }

            update() {
                this.x += this.vx;
                this.y += this.vy;

                if (this.x < 0 || this.x > canvas.width) this.vx *= -1;
                if (this.y < 0 || this.y > canvas.height) this.vy *= -1;
            }
        }

        function init() {
            particles = [];
            for (let i = 0; i < particleCount; i++) {
                particles.push(new Particle());
            }
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            let gradient = ctx.createRadialGradient(canvas.width/2, canvas.height/2, 10, canvas.width/2, canvas.height/2, canvas.width);
            gradient.addColorStop(0, '#0f172a');
            gradient.addColorStop(1, '#020617');
            ctx.fillStyle = gradient;
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            for (let i = 0; i < particles.length; i++) {
                for (let j = i + 1; j < particles.length; j++) {
                    let dx = particles[i].x - particles[j].x;
                    let dy = particles[i].y - particles[j].y;
                    let dist = Math.sqrt(dx * dx + dy * dy);

                    if (dist < 120) {
                        ctx.beginPath();
                        ctx.moveTo(particles[i].x, particles[i].y);
                        ctx.lineTo(particles[j].x, particles[j].y);
                        ctx.strokeStyle = `rgba(16, 185, 129, ${0.15 * (1 - dist/120)})`;
                        ctx.lineWidth = 0.6;
                        ctx.stroke();
                    }
                }
                particles[i].update();
                particles[i].draw();
            }
            requestAnimationFrame(animate);
        }

        init();
        animate();
    </script>

</body>
</html>