<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ParaSante | Vérification d'email</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            overflow: hidden;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .floating-card {
            animation: float 6s ease-in-out infinite;
        }

        #particle-canvas {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
        }
    </style>
</head>
<body class="bg-slate-950 min-h-screen flex items-center justify-center p-4 antialiased relative">

    <canvas id="particle-canvas"></canvas>

    <div class="w-full max-w-md relative z-10 floating-card">
        
        <div class="glass-panel rounded-3xl border border-white/40 shadow-[0_0_50px_rgba(16,185,129,0.15)] p-8 sm:p-10 transition-all duration-500 hover:shadow-[0_0_60px_rgba(16,185,129,0.25)] hover:border-emerald-200/50 text-center">
            
            <div class="mb-4">
                <div class="inline-flex items-center gap-2 mb-3">
                    <div class="h-11 w-11 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center font-extrabold text-white shadow-lg shadow-emerald-600/30">🌱</div>
                    <span class="text-2xl font-black tracking-tight text-slate-900">
                        PARA<span class="text-emerald-600">SANTE</span>
                    </span>
                </div>
            </div>

            <div class="mx-auto h-16 w-16 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-600 mb-4 animate-pulse">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l8-5.333a2 2 0 012.22 0l8 5.333A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-2.25-1.5a2 2 0 00-2.22 0l-2.25 1.5M12 14v7"></path></svg>
            </div>

            <h3 class="text-lg font-bold text-slate-800 tracking-tight">Merci pour votre inscription !</h3>
            <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                Veuillez vérifier votre adresse email en cliquant على الموّجه (lien) envoyé. Si vous n'avez pas reçu l'email, nous vous en enverrons un autre volontiers.
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="my-4 p-3 bg-emerald-50/90 backdrop-blur-sm border border-emerald-100 rounded-xl text-xs text-emerald-700 font-semibold flex items-center justify-center gap-1.5 shadow-sm">
                    <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Un nouveau lien de vérification a été envoyé.</span>
                </div>
            @endif

            <div class="flex flex-col sm:flex-row gap-3 items-center justify-between mt-6 pt-5 border-t border-slate-100">
                
                <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
                    @csrf
                    <button type="submit" class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold py-2.5 px-4 rounded-xl text-xs transition-all duration-200 active:scale-[0.98] cursor-pointer flex items-center justify-center gap-1.5 shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        <span>Renvoyer l'email</span>
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                    @csrf
                    <button type="submit" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold py-2.5 px-4 rounded-xl text-xs transition border border-slate-200/40 cursor-pointer flex items-center justify-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span>Déconnexion</span>
                    </button>
                </form>

            </div>

        </div>
    </div>

    <script>
        const canvas = document.getElementById('particle-canvas');
        const ctx = canvas.getContext('2d');
        let particles = [];
        const particleCount = 60;
        function resizeCanvas() { canvas.width = window.innerWidth; canvas.height = window.innerHeight; }
        window.addEventListener('resize', resizeCanvas); resizeCanvas();
        class Particle {
            constructor() {
                this.x = Math.random() * canvas.width; this.y = Math.random() * canvas.height;
                this.radius = Math.random() * 2 + 1; this.vx = (Math.random() - 0.5) * 0.4;
                this.vy = (Math.random() - 0.5) * 0.4; this.alpha = Math.random() * 0.5 + 0.2;
            }
            draw() { ctx.beginPath(); ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2); ctx.fillStyle = `rgba(16, 185, 129, ${this.alpha})`; ctx.fill(); }
            update() { this.x += this.vx; this.y += this.vy; if (this.x < 0 || this.x > canvas.width) this.vx *= -1; if (this.y < 0 || this.y > canvas.height) this.vy *= -1; }
        }
        function init() { for (let i = 0; i < particleCount; i++) particles.push(new Particle()); }
        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            let gradient = ctx.createRadialGradient(canvas.width/2, canvas.height/2, 10, canvas.width/2, canvas.height/2, canvas.width);
            gradient.addColorStop(0, '#0f172a'); gradient.addColorStop(1, '#020617'); ctx.fillStyle = gradient; ctx.fillRect(0, 0, canvas.width, canvas.height);
            for (let i = 0; i < particles.length; i++) {
                for (let j = i + 1; j < particles.length; j++) {
                    let dx = particles[i].x - particles[j].x, dy = particles[i].y - particles[j].y, dist = Math.sqrt(dx * dx + dy * dy);
                    if (dist < 120) {
                        ctx.beginPath(); ctx.moveTo(particles[i].x, particles[i].y); ctx.lineTo(particles[j].x, particles[j].y);
                        ctx.strokeStyle = `rgba(16, 185, 129, ${0.15 * (1 - dist/120)})`; ctx.lineWidth = 0.6; ctx.stroke();
                    }
                }
                particles[i].update(); particles[i].draw();
            }
            requestAnimationFrame(animate);
        }
        init(); animate();
    </script>
</body>
</html>