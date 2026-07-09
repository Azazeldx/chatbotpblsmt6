</div>
</form>
</div>
</div>

<!-- Custom Confirmation Modal -->
<div x-show="showResetModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto"
    aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

        <!-- Background overlay -->
        <div x-show="showResetModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
            @click="showResetModal = false"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal panel -->
        <div x-show="showResetModal" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div
                        class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Mulai Percakapan Baru?
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Tindakan ini akan menghapus riwayat obrolan Anda yang sekarang dan memulai sesi
                                percakapan yang benar-benar baru. Anda yakin?
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                <button @click="confirmResetChat()" type="button"
                    class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                    Ya, Mulai Baru
                </button>
                <button @click="showResetModal = false" type="button"
                    class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2563eb] sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<script>
    function fullChatbot() {
        return {
            messages: [],
            newMessage: '',
            isLoading: false,
            sessionId: null,
            showResetModal: false,

            init() {
                // Gunakan session yang sama dengan chatbot floating jika ada
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
                    } catch (e) {
                        this.messages = [];
                    }
                }

                // Save messages automatically when updated
                this.$watch('messages', (value) => {
                    localStorage.setItem('chatbot_messages', JSON.stringify(value));
                }, { deep: true });

                // Fokus ke input text saat halaman dimuat
                setTimeout(() => {
                    if (this.$refs.chatInput) {
                        this.$refs.chatInput.focus();
                    }
                }, 100);
            },

            resizeTextarea() {
                const el = this.$refs.chatInput;
                el.style.height = '56px';
                el.style.height = (el.scrollHeight) + 'px';
            },

            confirmResetChat() {
                this.messages = [];
                this.sessionId = 'guest_' + Math.random().toString(36).substring(2, 15);
                localStorage.setItem('chatbot_guest_session', this.sessionId);
                localStorage.removeItem('chatbot_messages');
                this.showResetModal = false;
                setTimeout(() => this.$refs.chatInput.focus(), 100);
            },

            formatMessage(text) {
                // Basic markdown to HTML formatting
                let formatted = text
                    .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>') // Bold
                    .replace(/\*(.*?)\*/g, '<em>$1</em>') // Italic
                    .replace(/\n/g, '<br>'); // Newlines

                // Format bullet points
                formatted = formatted.replace(/- (.*?)<br>/g, '<li class="ml-4">$1</li>');
                formatted = formatted.replace(/(<li.*<\/li>)/g, '<ul class="list-disc my-2">$1</ul>');

                return formatted;
            },

            sendSuggestion(text) {
                this.newMessage = text;
                this.sendMessage();
            },

            async sendMessage() {
                if (!this.newMessage.trim() || this.isLoading) return;

                const userMessage = this.newMessage;
                this.messages.push({ sender: 'user', message: userMessage });
                this.newMessage = '';
                this.isLoading = true;

                // Reset textarea height
                if (this.$refs.chatInput) {
                    this.$refs.chatInput.style.height = '56px';
                }

                this.scrollToBottom();

                try {
                    const response = await fetch("{{ route('api.chatbot.public.send') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
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
                        throw new Error('No reply from server');
                    }
                } catch (error) {
                    this.messages.push({ sender: 'bot', message: 'Mohon maaf, saya sedang mengalami kendala teknis. Silakan coba lagi nanti.' });
                    console.error('Chat error:', error);
                } finally {
                    this.isLoading = false;
                    this.scrollToBottom();
                    setTimeout(() => {
                        if (this.$refs.chatInput) {
                            this.$refs.chatInput.focus();
                        }
                    }, 100);
                }
            },

            scrollToBottom() {
                setTimeout(() => {
                    const container = document.getElementById('full-chat-messages');
                    if (container) {
                        container.scrollTop = container.scrollHeight;
                    }
                }, 50);
            }
        }
    }
</script>