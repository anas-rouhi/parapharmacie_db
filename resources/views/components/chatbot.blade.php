<button id="chatbot-toggle" class="fixed bottom-6 right-6 bg-green-600 hover:bg-green-700 text-white p-4 rounded-full shadow-2xl transition-all duration-300 transform hover:scale-110 flex items-center justify-center border border-green-500 z-[9999]">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
    </svg>
</button>

<div id="chatbot-window" class="fixed bottom-24 right-6 w-80 md:w-96 h-[500px] bg-white rounded-2xl shadow-2xl border border-gray-200 hidden flex-col justify-between overflow-hidden transition-all duration-300 z-[9999]">
    
    <div class="bg-gradient-to-r from-green-600 to-blue-600 p-4 flex justify-between items-center text-white shrink-0">
        <div class="flex items-center gap-2">
            <span class="text-2xl animate-pulse">🤖</span>
            <div>
                <h3 class="font-bold text-sm">Assistant ParaSanté</h3>
                <p class="text-[10px] text-green-200">En ligne - Conseil IA</p>
            </div>
        </div>
        <button id="chatbot-close" class="text-white hover:text-gray-200 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div id="chatbot-messages" class="p-4 flex-1 overflow-y-auto bg-gray-50 flex flex-col gap-3 text-sm">
        <div class="flex items-start gap-2">
            <div class="bg-white text-gray-800 p-3 rounded-tr-xl rounded-br-xl rounded-bl-xl max-w-[85%] shadow-sm border border-gray-100 leading-relaxed">
                Bonjour ! 👋 Je suis votre conseiller IA. Décrivez-moi vos symptômes ou ce que vous recherchez, et je vous proposerai les meilleurs produits adaptés !
            </div>
        </div>
    </div>

    <div class="p-3 border-t border-gray-100 bg-white flex gap-2 shrink-0">
        <input type="text" id="chatbot-input" placeholder="Ex: J'ai la peau sèche / Mal de tête..." class="flex-1 bg-gray-50 border border-gray-200 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 text-sm">
        <button id="chatbot-send" class="bg-green-600 hover:bg-green-700 text-white p-2 rounded-xl transition shadow flex items-center justify-center w-10 h-10 shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
            </svg>
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatToggle = document.getElementById('chatbot-toggle');
    const chatWindow = document.getElementById('chatbot-window');
    const chatClose = document.getElementById('chatbot-close');
    const chatInput = document.getElementById('chatbot-input');
    const chatSend = document.getElementById('chatbot-send');
    const chatMessages = document.getElementById('chatbot-messages');

    if (chatToggle && chatWindow && chatClose) {
        // فتح وإغلاق النافذة بسلاسة
        chatToggle.addEventListener('click', () => {
            if (chatWindow.classList.contains('hidden')) {
                chatWindow.classList.remove('hidden');
                chatWindow.classList.add('flex');
            } else {
                chatWindow.classList.remove('flex');
                chatWindow.classList.add('hidden');
            }
        });

        chatClose.addEventListener('click', () => {
            chatWindow.classList.remove('flex');
            chatWindow.classList.add('hidden');
        });
    }

    // دالة إرسال الرسالة عبر AJAX
    function sendMessage() {
        if (!chatInput || !chatMessages) return;
        
        const text = chatInput.value.trim();
        if (!text) return;

        // عرض رسالة المستخدم
        appendMessage(text, 'user');
        chatInput.value = '';

        // عرض مؤشر التحميل
        const loadingId = appendLoading();

        // إرسال الطلب لـ Laravel
        fetch("{{ route('chatbot.message') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: text })
        })
        .then(res => res.json())
        .then(data => {
            const loadingEl = document.getElementById(loadingId);
            if (loadingEl) loadingEl.remove();

            if(data.status === 'success') {
                appendMessage(data.message, 'bot');
                if(data.produits && data.produits.length > 0) {
                    appendProducts(data.produits);
                }
            } else {
                appendMessage(data.message, 'bot');
            }
        })
        .catch(() => {
            const loadingEl = document.getElementById(loadingId);
            if (loadingEl) loadingEl.remove();
            appendMessage("Désolé, une erreur est survenue. Réessayez.", 'bot');
        });
    }

    if (chatSend) chatSend.addEventListener('click', sendMessage);
    if (chatInput) {
        chatInput.addEventListener('keypress', (e) => { 
            if(e.key === 'Enter') sendMessage(); 
        });
    }

    function appendMessage(text, sender) {
        const msgDiv = document.createElement('div');
        msgDiv.className = `flex items-start gap-2 ${sender === 'user' ? 'justify-end' : ''}`;
        
        const contentClass = sender === 'user' 
            ? 'bg-green-600 text-white p-3 rounded-tl-xl rounded-bl-xl rounded-br-xl max-w-[85%] shadow-sm' 
            : 'bg-white text-gray-800 p-3 rounded-tr-xl rounded-br-xl rounded-bl-xl max-w-[85%] shadow-sm border border-gray-100 leading-relaxed';
            
        msgDiv.innerHTML = `<div class="${contentClass}">${text}</div>`;
        chatMessages.appendChild(msgDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function appendLoading() {
        const id = 'loading-' + Date.now();
        const loadingDiv = document.createElement('div');
        loadingDiv.id = id;
        loadingDiv.className = 'flex items-start gap-2';
        loadingDiv.innerHTML = `<div class="bg-gray-200 text-gray-500 p-2.5 rounded-xl animate-pulse text-xs">L'assistant réfléchit...</div>`;
        chatMessages.appendChild(loadingDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
        return id;
    }

    function appendProducts(produits) {
        const prodWrapper = document.createElement('div');
        prodWrapper.className = 'flex flex-col gap-2 mt-2 border-t border-gray-100 pt-2 w-full';
        
        const title = document.createElement('p');
        title.className = 'text-[11px] font-bold text-blue-600 uppercase tracking-wider';
        title.innerText = 'Produits recommandés :';
        prodWrapper.appendChild(title);

        produits.forEach(p => {
            const pLink = document.createElement('a');
            pLink.href = `/products/${p.id}`; 
            pLink.className = 'flex items-center gap-3 bg-white p-2 rounded-xl border border-gray-100 hover:border-green-300 transition shadow-sm w-full';
            
            const imgUrl = p.image ? `/images/products/${p.image}` : '/images/default.png';
            
            pLink.innerHTML = `
                <img src="${imgUrl}" class="w-10 h-10 object-cover rounded-lg bg-gray-50 shrink-0">
                <div class="flex-1 min-w-0">
                    <h4 class="text-xs font-bold text-gray-800 truncate">${p.nom}</h4>
                    <span class="text-xs font-black text-green-600">${p.prix} DH</span>
                </div>
                <span class="text-blue-500 font-bold text-xs px-2 py-1 bg-blue-50 rounded-lg hover:bg-blue-100 shrink-0">Voir</span>
            `;
            prodWrapper.appendChild(pLink);
        });

        chatMessages.appendChild(prodWrapper);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
});
</script>