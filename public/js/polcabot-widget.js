/**
 * PolCaBot Widget - Embeddable Chatbot
 * Version: 1.0.0
 */

(function() {
    'use strict';

    class PolCaBotWidget {
        constructor(config) {
            this.config = {
                apiUrl: config.apiUrl || 'https://your-domain.com/api/widget',
                widgetKey: config.widgetKey,
                position: 'bottom-right',
                primaryColor: '#3b82f6',
                title: 'PolCaBot',
                subtitle: 'Asisten Virtual Kampus',
                welcomeMessage: 'Halo! Ada yang bisa saya bantu?',
                ...config
            };

            this.isOpen = false;
            this.isAdminMode = false;
            this.messages = [];
            
            this.init();
        }

        init() {
            this.loadConfig();
            this.injectStyles();
            this.createWidget();
            this.attachEventListeners();
        }

        async loadConfig() {
            try {
                const response = await fetch(`${this.config.apiUrl}/config`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ widget_key: this.config.widgetKey })
                });
                
                const data = await response.json();
                if (data.success) {
                    Object.assign(this.config, data.config);
                    this.updateWidgetStyles();
                }
            } catch (error) {
                console.warn('Failed to load widget config:', error);
            }
        }

        injectStyles() {
            const styles = `
                #polcabot-widget * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                }

                #polcabot-button {
                    position: fixed;
                    ${this.config.position.includes('right') ? 'right: 20px' : 'left: 20px'};
                    bottom: 20px;
                    width: 60px;
                    height: 60px;
                    border-radius: 50%;
                    background: ${this.config.primaryColor};
                    border: none;
                    cursor: pointer;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    z-index: 9998;
                    transition: transform 0.3s, box-shadow 0.3s;
                }

                #polcabot-button:hover {
                    transform: scale(1.1);
                    box-shadow: 0 6px 16px rgba(0,0,0,0.2);
                }

                #polcabot-button svg {
                    width: 30px;
                    height: 30px;
                    fill: white;
                }

                #polcabot-chat-window {
                    position: fixed;
                    ${this.config.position.includes('right') ? 'right: 20px' : 'left: 20px'};
                    bottom: 90px;
                    width: 380px;
                    height: 600px;
                    max-height: calc(100vh - 120px);
                    background: white;
                    border-radius: 16px;
                    box-shadow: 0 8px 32px rgba(0,0,0,0.12);
                    display: none;
                    flex-direction: column;
                    z-index: 9999;
                    overflow: hidden;
                }

                #polcabot-chat-window.open {
                    display: flex;
                    animation: slideUp 0.3s ease-out;
                }

                @keyframes slideUp {
                    from {
                        opacity: 0;
                        transform: translateY(20px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                #polcabot-header {
                    background: ${this.config.primaryColor};
                    color: white;
                    padding: 20px;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }

                #polcabot-header-info h3 {
                    font-size: 18px;
                    margin-bottom: 4px;
                }

                #polcabot-header-info p {
                    font-size: 13px;
                    opacity: 0.9;
                }

                #polcabot-close {
                    background: none;
                    border: none;
                    color: white;
                    cursor: pointer;
                    font-size: 24px;
                    width: 30px;
                    height: 30px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    border-radius: 50%;
                    transition: background 0.2s;
                }

                #polcabot-close:hover {
                    background: rgba(255,255,255,0.2);
                }

                #polcabot-messages {
                    flex: 1;
                    overflow-y: auto;
                    padding: 20px;
                    background: #f8fafc;
                }

                .polcabot-message {
                    margin-bottom: 16px;
                    display: flex;
                    gap: 8px;
                }

                .polcabot-message.user {
                    flex-direction: row-reverse;
                }

                .polcabot-message-content {
                    max-width: 75%;
                    padding: 12px 16px;
                    border-radius: 12px;
                    font-size: 14px;
                    line-height: 1.5;
                }

                .polcabot-message.bot .polcabot-message-content {
                    background: white;
                    border: 1px solid #e2e8f0;
                }

                .polcabot-message.user .polcabot-message-content {
                    background: ${this.config.primaryColor};
                    color: white;
                }

                #polcabot-input-area {
                    padding: 16px;
                    background: white;
                    border-top: 1px solid #e2e8f0;
                }

                #polcabot-mode-switch {
                    font-size: 11px;
                    color: #64748b;
                    margin-bottom: 8px;
                    cursor: pointer;
                    user-select: none;
                }

                #polcabot-mode-switch:hover {
                    color: ${this.config.primaryColor};
                }

                #polcabot-input-wrapper {
                    display: flex;
                    gap: 8px;
                }

                #polcabot-input {
                    flex: 1;
                    padding: 12px 16px;
                    border: 1px solid #e2e8f0;
                    border-radius: 24px;
                    font-size: 14px;
                    outline: none;
                    transition: border-color 0.2s;
                }

                #polcabot-input:focus {
                    border-color: ${this.config.primaryColor};
                }

                #polcabot-send {
                    width: 44px;
                    height: 44px;
                    background: ${this.config.primaryColor};
                    border: none;
                    border-radius: 50%;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    transition: transform 0.2s;
                }

                #polcabot-send:hover {
                    transform: scale(1.1);
                }

                #polcabot-send:disabled {
                    opacity: 0.5;
                    cursor: not-allowed;
                }

                #polcabot-send svg {
                    width: 20px;
                    height: 20px;
                    fill: white;
                }

                .polcabot-typing {
                    display: inline-block;
                    padding: 12px 16px;
                    background: white;
                    border: 1px solid #e2e8f0;
                    border-radius: 12px;
                }

                .polcabot-typing span {
                    display: inline-block;
                    width: 8px;
                    height: 8px;
                    border-radius: 50%;
                    background: ${this.config.primaryColor};
                    margin: 0 2px;
                    animation: typing 1.4s infinite;
                }

                .polcabot-typing span:nth-child(2) {
                    animation-delay: 0.2s;
                }

                .polcabot-typing span:nth-child(3) {
                    animation-delay: 0.4s;
                }

                @keyframes typing {
                    0%, 60%, 100% {
                        transform: translateY(0);
                    }
                    30% {
                        transform: translateY(-10px);
                    }
                }

                .polcabot-admin-form {
                    display: none;
                    padding: 16px;
                    background: #fef3c7;
                    border-top: 2px solid #fbbf24;
                }

                .polcabot-admin-form.active {
                    display: block;
                }

                .polcabot-admin-form input,
                .polcabot-admin-form textarea {
                    width: 100%;
                    padding: 8px 12px;
                    margin-bottom: 8px;
                    border: 1px solid #d1d5db;
                    border-radius: 6px;
                    font-size: 13px;
                }

                .polcabot-admin-form textarea {
                    min-height: 60px;
                    resize: vertical;
                }

                .polcabot-admin-form select {
                    width: 100%;
                    padding: 8px 12px;
                    margin-bottom: 8px;
                    border: 1px solid #d1d5db;
                    border-radius: 6px;
                    font-size: 13px;
                }

                .polcabot-admin-submit {
                    width: 100%;
                    padding: 10px;
                    background: #10b981;
                    color: white;
                    border: none;
                    border-radius: 6px;
                    cursor: pointer;
                    font-weight: 600;
                }

                @media (max-width: 480px) {
                    #polcabot-chat-window {
                        width: calc(100vw - 40px);
                        height: calc(100vh - 120px);
                    }
                }
            `;

            const styleSheet = document.createElement('style');
            styleSheet.textContent = styles;
            document.head.appendChild(styleSheet);
        }

        createWidget() {
            const container = document.createElement('div');
            container.id = 'polcabot-widget';
            container.innerHTML = `
                <button id="polcabot-button" aria-label="Open chat">
                    <svg viewBox="0 0 24 24">
                        <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z"/>
                    </svg>
                </button>
                
                <div id="polcabot-chat-window">
                    <div id="polcabot-header">
                        <div id="polcabot-header-info">
                            <h3>${this.config.title}</h3>
                            <p>${this.config.subtitle}</p>
                        </div>
                        <button id="polcabot-close" aria-label="Close chat">×</button>
                    </div>
                    
                    <div id="polcabot-messages"></div>
                    
                    <div class="polcabot-admin-form" id="polcabot-admin-panel">
                        <h4 style="font-size: 14px; margin-bottom: 12px; color: #92400e;">
                            🔐 Admin Mode - Tambah Dataset
                        </h4>
                        <input type="password" id="polcabot-admin-code" placeholder="Kode Admin" />
                        <select id="polcabot-admin-table">
                            <option value="organisasi_knowledge">Organisasi</option>
                            <option value="beasiswa_knowledge">Beasiswa</option>
                            <option value="jurusan_knowledge">Jurusan</option>
                            <option value="daftar_knowledge">Pendaftaran</option>
                            <option value="event_knowledge">Event</option>
                        </select>
                        <input type="text" id="polcabot-admin-question" placeholder="Pertanyaan (contoh: Apa itu UKM Futsal?)" />
                        <input type="text" id="polcabot-admin-keywords" placeholder="Keywords (contoh: ukm, futsal, olahraga)" />
                        <textarea id="polcabot-admin-answer" placeholder="Jawaban lengkap"></textarea>
                        <input type="url" id="polcabot-admin-source" placeholder="Sumber URL (opsional)" />
                        <button class="polcabot-admin-submit" id="polcabot-admin-submit-btn">
                            Tambah Dataset
                        </button>
                    </div>
                    
                    <div id="polcabot-input-area">
                        <div id="polcabot-mode-switch">💡 Klik 3x untuk Admin Mode</div>
                        <div id="polcabot-input-wrapper">
                            <input 
                                type="text" 
                                id="polcabot-input" 
                                placeholder="Ketik pesan..." 
                                autocomplete="off"
                            />
                            <button id="polcabot-send" aria-label="Send message">
                                <svg viewBox="0 0 24 24">
                                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            `;

            document.body.appendChild(container);
            
            // Show welcome message
            setTimeout(() => {
                this.addMessage('bot', this.config.welcomeMessage);
            }, 500);
        }

        attachEventListeners() {
            const button = document.getElementById('polcabot-button');
            const closeBtn = document.getElementById('polcabot-close');
            const input = document.getElementById('polcabot-input');
            const sendBtn = document.getElementById('polcabot-send');
            const modeSwitch = document.getElementById('polcabot-mode-switch');
            const adminSubmit = document.getElementById('polcabot-admin-submit-btn');

            button.addEventListener('click', () => this.toggleWidget());
            closeBtn.addEventListener('click', () => this.toggleWidget());
            
            sendBtn.addEventListener('click', () => this.sendMessage());
            input.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') this.sendMessage();
            });

            // Triple click to toggle admin mode
            let clickCount = 0;
            let clickTimer;
            modeSwitch.addEventListener('click', () => {
                clickCount++;
                clearTimeout(clickTimer);
                
                if (clickCount === 3) {
                    this.toggleAdminMode();
                    clickCount = 0;
                } else {
                    clickTimer = setTimeout(() => clickCount = 0, 500);
                }
            });

            adminSubmit.addEventListener('click', () => this.submitAdminData());
        }

        toggleWidget() {
            this.isOpen = !this.isOpen;
            const window = document.getElementById('polcabot-chat-window');
            window.classList.toggle('open', this.isOpen);
        }

        toggleAdminMode() {
            this.isAdminMode = !this.isAdminMode;
            const panel = document.getElementById('polcabot-admin-panel');
            panel.classList.toggle('active', this.isAdminMode);
            
            if (this.isAdminMode) {
                this.addMessage('bot', '🔐 Admin Mode aktif. Masukkan kode admin untuk menambah dataset.');
            } else {
                this.addMessage('bot', '👤 Kembali ke User Mode.');
            }
        }

        async sendMessage() {
            const input = document.getElementById('polcabot-input');
            const message = input.value.trim();
            
            if (!message) return;

            this.addMessage('user', message);
            input.value = '';
            
            this.showTyping();

            try {
                const response = await fetch(`${this.config.apiUrl}/chat`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        message: message,
                        widget_key: this.config.widgetKey
                    })
                });

                const data = await response.json();
                this.hideTyping();

                if (data.success) {
                    this.addMessage('bot', data.reply);
                } else {
                    this.addMessage('bot', '⚠️ Terjadi kesalahan. Silakan coba lagi.');
                }
            } catch (error) {
                this.hideTyping();
                this.addMessage('bot', '❌ Gagal menghubungi server. Periksa koneksi Anda.');
            }
        }

        async submitAdminData() {
            const code = document.getElementById('polcabot-admin-code').value;
            const table = document.getElementById('polcabot-admin-table').value;
            const question = document.getElementById('polcabot-admin-question').value;
            const keywords = document.getElementById('polcabot-admin-keywords').value;
            const answer = document.getElementById('polcabot-admin-answer').value;
            const source = document.getElementById('polcabot-admin-source').value;

            if (!code || !question || !keywords || !answer) {
                alert('Harap isi semua field yang wajib!');
                return;
            }

            try {
                const response = await fetch(`${this.config.apiUrl}/admin/add-knowledge`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        admin_code: code,
                        table: table,
                        question: question,
                        keywords: keywords,
                        answer: answer,
                        source: source
                    })
                });

                const data = await response.json();

                if (data.success) {
                    alert('✅ Dataset berhasil ditambahkan!');
                    // Clear form
                    document.getElementById('polcabot-admin-question').value = '';
                    document.getElementById('polcabot-admin-keywords').value = '';
                    document.getElementById('polcabot-admin-answer').value = '';
                    document.getElementById('polcabot-admin-source').value = '';
                } else {
                    alert('❌ ' + (data.message || 'Gagal menambahkan dataset'));
                }
            } catch (error) {
                alert('❌ Terjadi kesalahan koneksi');
            }
        }

        addMessage(sender, text) {
            const messagesDiv = document.getElementById('polcabot-messages');
            const messageDiv = document.createElement('div');
            messageDiv.className = `polcabot-message ${sender}`;
            
            const contentDiv = document.createElement('div');
            contentDiv.className = 'polcabot-message-content';
            contentDiv.innerHTML = text;
            
            messageDiv.appendChild(contentDiv);
            messagesDiv.appendChild(messageDiv);
            
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }

        showTyping() {
            const messagesDiv = document.getElementById('polcabot-messages');
            const typingDiv = document.createElement('div');
            typingDiv.id = 'polcabot-typing-indicator';
            typingDiv.className = 'polcabot-message bot';
            typingDiv.innerHTML = `
                <div class="polcabot-typing">
                    <span></span><span></span><span></span>
                </div>
            `;
            messagesDiv.appendChild(typingDiv);
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }

        hideTyping() {
            const typingDiv = document.getElementById('polcabot-typing-indicator');
            if (typingDiv) typingDiv.remove();
        }

        updateWidgetStyles() {
            // Re-inject styles with new config
            this.injectStyles();
        }
    }

    // Initialize widget when script loads
    window.PolCaBotWidget = PolCaBotWidget;

    // Auto-initialize if data attributes are present
    if (document.currentScript && document.currentScript.dataset.widgetKey) {
        new PolCaBotWidget({
            apiUrl: document.currentScript.dataset.apiUrl,
            widgetKey: document.currentScript.dataset.widgetKey
        });
    }
})();