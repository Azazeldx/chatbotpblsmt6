<div x-data="chatbot()" x-init="init()">
    <style>
        .chatbot-window {
            position: fixed;
            bottom: 100px;
            left: 20px;
            right: 20px;
            height: 560px;
            max-height: 78vh;
            z-index: 10000;
            display: flex;
            flex-direction: column;
            background: #ffffff;
            border-radius: 1.25rem;
            box-shadow: 0 20px 45px -12px rgba(15, 23, 42, 0.35), 0 8px 18px -10px rgba(15, 23, 42, 0.25);
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        @media (min-width: 640px) {
            .chatbot-window {
                width: 400px;
                left: auto;
                right: 30px;
                bottom: 110px;
            }
        }

        /* Area pesan & layar sambutan */
        .chatbot-body {
            background: linear-gradient(180deg, #ffffff 0%, #eff4ff 45%, #dbe7ff 100%);
        }

        .chatbot-suggestion {
            width: 100%;
            text-align: left;
            background: #ffffff;
            border: 1px solid #dbe4f3;
            color: #334155;
            border-radius: 0.75rem;
            padding: 0.7rem 0.9rem;
            font-size: 0.8rem;
            transition: all 0.15s ease;
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
        }

        .chatbot-suggestion:hover {
            border-color: #2563eb;
            color: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 4px 10px -4px rgba(37, 99, 235, 0.35);
        }

        /* Typing indicator (bot sedang mengetik) */
        .typing-indicator {
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .typing-indicator span {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #94a3b8;
            display: inline-block;
            animation: typing-bounce 1.2s infinite ease-in-out;
        }

        .typing-indicator span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-indicator span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typing-bounce {
            0%, 60%, 100% {
                transform: translateY(0);
                opacity: 0.4;
            }
            30% {
                transform: translateY(-4px);
                opacity: 1;
            }
        }
    </style>

    <!-- Chat Window -->
    <div x-show="open"
         x-transition.opacity
         class="chatbot-window"
         @click.away="open = false">

        <!-- Header -->
        <div class="px-4 py-3 flex items-center justify-between" style="background: linear-gradient(120deg, #1e293b 0%, #0f172a 100%);">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-white/10 border border-white/15 flex items-center justify-center">
                    <i class="fas fa-robot text-white text-sm"></i>
                </div>
                <div class="flex flex-col leading-tight">
                    <span class="text-white font-semibold text-sm">Asisten RPJMD</span>
                    <span class="text-[11px] text-slate-300 flex items-center gap-1">
                        <span class="inline-block w-1.5 h-1.5 rounded-full"
                              :class="isLoading ? 'bg-amber-300 animate-pulse' : 'bg-emerald-400'"></span>
                        <span x-text="isLoading ? 'Sedang mengetik...' : 'Kabupaten Pasuruan'"></span>
                    </span>
                </div>
            </div>
            <div class="flex items-center gap-1 text-slate-300">
                <button @click="showClearConfirm = true" title="Hapus percakapan"
                        :disabled="isLoading"
                        :class="isLoading ? 'opacity-40 cursor-not-allowed' : ''"
                        class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white/10 hover:text-white transition">
                    <i class="fas fa-trash-alt text-sm"></i>
                </button>
                <button @click="open = false" title="Kecilkan"
                        class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white/10 hover:text-white transition">
                    <i class="fas fa-minus text-sm"></i>
                </button>
                <button @click="open = false" title="Tutup"
                        class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-white/10 hover:text-white transition">
                    <i class="fas fa-times text-base"></i>
                </button>
            </div>
        </div>

        <!-- Messages Area -->
        <div id="chat-messages" class="chatbot-body flex-1 overflow-y-auto p-4 space-y-3 text-[13px]">

            <!-- Layar sambutan (saat belum ada pesan) -->
            <div x-show="messages.length === 0" class="flex flex-col items-center text-center pt-6 px-1">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mb-4 shadow-lg"
                     style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); box-shadow: 0 10px 20px -6px rgba(37,99,235,0.55);">
                    <i class="fas fa-robot text-white text-2xl"></i>
                </div>
                <h3 class="text-slate-800 font-bold text-base mb-1">Halo! Saya Asisten RPJMD</h3>
                <p class="text-slate-500 text-[12.5px] leading-relaxed mb-5 max-w-[85%]">
                    Tanyakan apapun tentang RPJMD dan pembangunan Kabupaten Pasuruan.
                </p>

                <div class="w-full space-y-2.5">
                    <template x-for="(prompt, i) in suggestions" :key="i">
                        <button type="button" class="chatbot-suggestion" @click="sendMessage(prompt)" x-text="prompt"></button>
                    </template>
                </div>
            </div>

            <!-- Percakapan -->
            <template x-for="(msg, index) in messages" :key="index">
                <div :class="msg.sender === 'user' ? 'flex justify-end' : 'flex justify-start'">
                    <div :class="msg.sender === 'user'
                        ? 'bg-[#2563eb] text-white px-3 py-2 rounded-2xl rounded-br-sm max-w-[85%] shadow-sm'
                        : 'bg-white text-slate-700 px-3 py-2 rounded-2xl rounded-bl-sm border border-slate-100 max-w-[85%] shadow-sm'"
                        style="white-space: pre-wrap; word-break: break-word;" x-text="msg.message">
                    </div>
                </div>
            </template>

            <!-- Typing indicator: bot sedang mengetik -->
            <div x-show="isLoading" x-transition class="flex justify-start">
                <div class="bg-white px-3 py-2 rounded-2xl rounded-bl-sm border border-slate-100 flex items-center gap-2 shadow-sm">
                    <i class="fas fa-robot text-[#2563eb]"></i>
                    <span class="typing-indicator">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Dialog konfirmasi hapus percakapan -->
        <div x-show="showClearConfirm"
             x-transition.opacity
             class="absolute inset-0 z-20 flex items-center justify-center px-6"
             style="background: rgba(15, 23, 42, 0.45); backdrop-filter: blur(2px);"
             @click.self="showClearConfirm = false">
            <div x-show="showClearConfirm"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="bg-white rounded-2xl shadow-2xl w-full max-w-[290px] p-5 text-center">
                <div class="w-12 h-12 mx-auto rounded-full bg-red-50 flex items-center justify-center mb-3">
                    <i class="fas fa-trash-alt text-red-500 text-lg"></i>
                </div>
                <h4 class="text-slate-800 font-semibold text-[15px] mb-1">Hapus percakapan?</h4>
                <p class="text-slate-500 text-[12.5px] leading-relaxed mb-4">
                    Seluruh riwayat chat ini akan dihapus dan tidak bisa dikembalikan.
                </p>
                <div class="flex gap-2">
                    <button type="button" @click="showClearConfirm = false"
                        class="flex-1 py-2 rounded-lg text-[13px] font-medium text-slate-600 bg-slate-100 hover:bg-slate-200 transition">
                        Batal
                    </button>
                    <button type="button" @click="clearChat()"
                        class="flex-1 py-2 rounded-lg text-[13px] font-medium text-white bg-red-500 hover:bg-red-600 transition">
                        Hapus
                    </button>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="bg-white border-t border-slate-100 px-3 pt-3 pb-2.5">
            <form @submit.prevent="sendMessage()" class="flex items-center gap-2">
                <input type="text" x-model="newMessage" placeholder="Ketik pesan Anda..."
                    class="flex-1 text-[13px] px-4 py-2.5 border border-slate-200 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500/40 focus:border-blue-500 transition"
                    :disabled="isLoading">
                <button type="submit"
                    class="w-11 h-11 flex items-center justify-center rounded-full text-white transition disabled:opacity-50 disabled:cursor-not-allowed hover:scale-105 active:scale-95"
                    style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);"
                    :disabled="isLoading || !newMessage.trim()">
                    <i class="fas fa-paper-plane text-sm"></i>
                </button>
            </form>
            <p class="text-center text-[11px] text-slate-400 mt-2">Tekan Enter untuk kirim</p>
        </div>
    </div>

    <!-- Toggle Button -->
    <button @click="open = !open; if(open) scrollToBottom()"
        class="text-white rounded-full flex items-center justify-center transition-all hover:scale-105 active:scale-95 shadow-lg hover:shadow-xl group"
        style="position: fixed; bottom: 30px; right: 30px; width: 60px; height: 60px; z-index: 10001; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
        <i x-show="!open" class="fas fa-comments text-2xl relative z-10"></i>
        <i x-show="open" class="fas fa-times text-2xl relative z-10"></i>

        <!-- Notification Dot -->
        <span x-show="!open"
            class="absolute top-2 right-2 w-3 h-3 bg-red-500 border-2 border-white rounded-full"></span>
    </button>
</div>

<script>
    function chatbot() {
        return {
            open: false,
            messages: [],
            newMessage: '',
            isLoading: false,
            sessionId: null,
            showClearConfirm: false,
            suggestions: [
                'Apa itu RPJMD Kabupaten Pasuruan?',
                'Apa visi pembangunan daerah?',
                'Program unggulan apa yang ada?',
            ],

            init() {
                // Restore or create guest session
                this.sessionId = localStorage.getItem('chatbot_guest_session');
                if (!this.sessionId) {
                    this.sessionId = 'guest_' + Math.random().toString(36).substring(2, 15);
                    localStorage.setItem('chatbot_guest_session', this.sessionId);
                }

                // Restore chat history
                const savedMessages = localStorage.getItem('chatbot_messages');
                if (savedMessages) {
                    try {
                        this.messages = JSON.parse(savedMessages);
                    } catch(e) {
                        this.messages = [];
                    }
                }

                // Save messages automatically when updated
                this.$watch('messages', (value) => {
                    localStorage.setItem('chatbot_messages', JSON.stringify(value));
                }, { deep: true });
            },

            // Bersihkan percakapan & mulai session baru (dipanggil dari dialog konfirmasi)
            clearChat() {
                if (this.isLoading) return;

                this.messages = [];
                this.newMessage = '';
                localStorage.removeItem('chatbot_messages');

                // Mulai session guest baru agar histori lama tidak terbawa
                this.sessionId = 'guest_' + Math.random().toString(36).substring(2, 15);
                localStorage.setItem('chatbot_guest_session', this.sessionId);

                this.showClearConfirm = false;
            },

            // Menerima teks opsional (dari tombol saran) atau memakai input
            async sendMessage(presetMessage = null) {
                const userMessage = (presetMessage ?? this.newMessage).trim();
                if (!userMessage || this.isLoading) return;

                this.messages.push({ sender: 'user', message: userMessage });
                this.newMessage = '';
                this.isLoading = true;
                this.scrollToBottom();

                try {
                    const response = await fetch('{{ route("api.chatbot.public.send") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        },
                        body: JSON.stringify({
                            message: userMessage,
                            session_id: this.sessionId
                        })
                    });

                    const data = await response.json();

                    if (data.reply) {
                        this.messages.push({ sender: 'bot', message: data.reply });
                    } else {
                        throw new Error('No reply');
                    }
                } catch (error) {
                    console.error('Chatbot error:', error);
                    this.messages.push({
                        sender: 'bot',
                        message: 'Mohon maaf, terjadi gangguan koneksi. Silakan coba lagi.'
                    });
                } finally {
                    this.isLoading = false;
                    this.scrollToBottom();
                }
            },

            scrollToBottom() {
                setTimeout(() => {
                    const container = document.getElementById('chat-messages');
                    if (container) {
                        container.scrollTo({
                            top: container.scrollHeight,
                            behavior: 'smooth'
                        });
                    }
                }, 100);
            }
        }
    }
</script>
