{{-- Ganti bagian widget di resources/views/landing.blade.php --}}

<!-- ========== POLCABOT BUBBLE CHAT WIDGET ========== -->
<div id="polcabotWidget">
    <!-- Bubble Button -->
    <div class="polcabot-bubble" id="polcabotBubble">
        <svg viewBox="0 0 24 24">
            <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z"/>
        </svg>
        <span class="notification-badge">1</span>
    </div>

    <!-- Chat Window -->
    <div class="polcabot-widget" id="polcabotWindow">
        <!-- Verification Overlay -->
        <div class="verification-overlay" id="verificationOverlay">
            <div class="verification-content">
                <h3>🔐 Verifikasi Admin</h3>
                <p>Masukkan kode admin untuk mengakses mode administrator</p>
                <input type="password" id="adminCodeInput" placeholder="Kode Admin" />
                <div class="verification-buttons">
                    <button class="verify-btn" onclick="verifyAdminCode()">Verifikasi</button>
                    <button class="cancel-btn" onclick="cancelAdminMode()">Batal</button>
                </div>
            </div>
        </div>

        <!-- Header -->
        <div class="polcabot-header">
            <div class="polcabot-header-info">
                <img src="{{ asset('images/logo.png') }}" alt="PolCaBot Logo" class="polcabot-header-avatar">
                <div class="polcabot-header-text">
                    <h3>PolCaBot</h3>
                    <div class="polcabot-header-status">
                        <span class="status-dot"></span>
                        <span>Online & Siap Membantu</span>
                    </div>
                </div>
            </div>
            <button class="polcabot-close" id="polcabotClose">&times;</button>
        </div>

        <!-- Mode Tabs -->
        <div class="mode-tabs">
            <button class="mode-tab active" data-mode="user" onclick="switchMode('user')">
                👤 Mode User
            </button>
            <button class="mode-tab" data-mode="admin" onclick="requestAdminMode()">
                🔐 Mode Admin
            </button>
        </div>

        <!-- User Mode Content -->
        <div class="tab-content active" id="userMode">
            <!-- Messages Area -->
            <div class="polcabot-messages" id="polcabotMessages">
                <!-- Welcome Message -->
                <div class="welcome-message">
                    <h4>👋 Halo! Selamat datang di PolCaBot</h4>
                    <p>Saya siap membantu Anda dengan informasi seputar Polibatam</p>
                </div>

                <!-- Quick Actions -->
                <div class="quick-actions">
                    <button class="quick-action-btn" onclick="sendQuickMessage('Apa itu organisasi HMPS?')">
                        🎓 Organisasi Kampus
                    </button>
                    <button class="quick-action-btn" onclick="sendQuickMessage('Info beasiswa tersedia?')">
                        💰 Beasiswa
                    </button>
                    <button class="quick-action-btn" onclick="sendQuickMessage('Jurusan apa saja yang ada?')">
                        📚 Jurusan
                    </button>
                    <button class="quick-action-btn" onclick="sendQuickMessage('Cara daftar kuliah?')">
                        📝 Pendaftaran
                    </button>
                </div>
            </div>

            <!-- Input Area -->
            <div class="polcabot-input-area">
                <div class="input-wrapper">
                    <textarea 
                        id="polcabotInput" 
                        class="polcabot-input" 
                        placeholder="Ketik pesan Anda..."
                        rows="1"
                        maxlength="500"
                    ></textarea>
                    <button class="send-button" id="sendButton" onclick="sendMessage()">
                        <svg viewBox="0 0 24 24">
                            <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Admin Mode Content -->
        <div class="tab-content" id="adminMode">
            <div class="polcabot-messages" style="max-height: 300px; overflow-y: auto; padding: 20px;">
                <!-- Dataset Section -->
                <div class="admin-section">
                    <h4>📋 Tambah Dataset</h4>
                    <select id="adminTable">
                        <option value="organisasi_knowledge">📋 Organisasi</option>
                        <option value="beasiswa_knowledge">💰 Beasiswa</option>
                        <option value="jurusan_knowledge">📚 Jurusan</option>
                        <option value="daftar_knowledge">📝 Pendaftaran</option>
                        <option value="event_knowledge">🎉 Event</option>
                    </select>
                    <input type="text" id="adminQuestion" placeholder="Pertanyaan (contoh: Apa itu UKM Futsal?)" />
                    <input type="text" id="adminKeywords" placeholder="Keywords (contoh: ukm, futsal, olahraga)" />
                    <textarea id="adminAnswer" placeholder="Jawaban lengkap..."></textarea>
                    <input type="url" id="adminSource" placeholder="Sumber URL (opsional)" />
                    <button class="admin-submit-btn" onclick="submitDataset()">
                        ✅ Tambah Dataset
                    </button>
                </div>

                <!-- AI Prompt Section -->
                <div class="admin-section" style="background: #dbeafe;">
                    <h4>🤖 Ubah AI Prompt</h4>
                    <textarea id="adminPrompt" placeholder="System prompt untuk AI..." style="min-height: 120px;"></textarea>
                    <button class="admin-submit-btn" onclick="updateAIPrompt()" style="background: linear-gradient(135deg, #1e90ff 0%, #0d6efd 100%);">
                        💾 Update Prompt
                    </button>
                </div>
            </div>
        </div>

        <!-- Powered By -->
        <div class="powered-by">
            Powered by <a href="https://polibatam.ac.id" target="_blank">Politeknik Negeri Batam</a>
        </div>
    </div>
</div>

@push('scripts')
<script>
// ========== POLCABOT WIDGET JAVASCRIPT ==========
(function() {
    // Get widget key from database
    const WIDGET_KEY = '{{ $widgetKey ?? "pk_default" }}'; // Akan kita set nanti
    const API_URL = '/api/widget';
    
    let isAdminMode = false;
    let isAdminVerified = false;
    let adminCode = '';

    // Initialize widget
    const bubble = document.getElementById('polcabotBubble');
    const widget = document.getElementById('polcabotWindow');
    const closeBtn = document.getElementById('polcabotClose');
    const badge = document.querySelector('.notification-badge');
    const input = document.getElementById('polcabotInput');

    // Toggle Widget
    bubble.addEventListener('click', () => {
        widget.classList.toggle('active');
        if (widget.classList.contains('active')) {
            badge.style.display = 'none';
            input.focus();
        }
    });

    closeBtn.addEventListener('click', () => {
        widget.classList.remove('active');
    });

    // Auto-resize textarea
    input.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });

    // Enter to send
    input.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    // Switch Mode
    window.switchMode = function(mode) {
        if (mode === 'admin' && !isAdminVerified) {
            requestAdminMode();
            return;
        }

        document.querySelectorAll('.mode-tab').forEach(tab => {
            tab.classList.toggle('active', tab.dataset.mode === mode);
        });

        document.getElementById('userMode').classList.toggle('active', mode === 'user');
        document.getElementById('adminMode').classList.toggle('active', mode === 'admin');

        isAdminMode = (mode === 'admin');

        // Load current prompt if admin mode
        if (isAdminMode && isAdminVerified) {
            loadCurrentPrompt();
        }
    };

    // Request Admin Mode
    window.requestAdminMode = function() {
        document.getElementById('verificationOverlay').classList.add('active');
        document.getElementById('adminCodeInput').value = '';
        document.getElementById('adminCodeInput').focus();
    };

    // Verify Admin Code
    window.verifyAdminCode = async function() {
        const code = document.getElementById('adminCodeInput').value.trim();
        
        if (!code) {
            alert('⚠️ Masukkan kode admin!');
            return;
        }

        try {
            const response = await fetch(`${API_URL}/admin/verify`, {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({
                    admin_code: code,
                    widget_key: WIDGET_KEY
                })
            });

            const data = await response.json();

            if (data.success) {
                adminCode = code;
                isAdminVerified = true;
                document.getElementById('verificationOverlay').classList.remove('active');
                switchMode('admin');
                addBotMessage('✅ Selamat datang di Mode Admin!');
            } else {
                alert('❌ Kode admin tidak valid!');
            }
        } catch (error) {
            alert('❌ Gagal verifikasi: ' + error.message);
        }
    };

    // Cancel Admin Mode
    window.cancelAdminMode = function() {
        document.getElementById('verificationOverlay').classList.remove('active');
        switchMode('user');
    };

    // Send Message
    window.sendMessage = async function() {
        const message = input.value.trim();
        if (!message) return;

        addUserMessage(message);
        input.value = '';
        input.style.height = 'auto';

        showTypingIndicator();

        try {
            const response = await fetch(`${API_URL}/chat`, {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({
                    message: message,
                    widget_key: WIDGET_KEY
                })
            });

            const data = await response.json();
            hideTypingIndicator();

            if (data.success && data.reply) {
                addBotMessage(data.reply);
            } else {
                addBotMessage('⚠️ Maaf, terjadi kesalahan. Silakan coba lagi.');
            }
        } catch (error) {
            hideTypingIndicator();
            addBotMessage('❌ Gagal menghubungi server: ' + error.message);
        }
    };

    // Quick Message
    window.sendQuickMessage = function(message) {
        input.value = message;
        sendMessage();
    };

    // Submit Dataset
    window.submitDataset = async function() {
        const table = document.getElementById('adminTable').value;
        const question = document.getElementById('adminQuestion').value.trim();
        const keywords = document.getElementById('adminKeywords').value.trim();
        const answer = document.getElementById('adminAnswer').value.trim();
        const source = document.getElementById('adminSource').value.trim();

        if (!question || !keywords || !answer) {
            alert('⚠️ Harap isi semua field yang wajib!');
            return;
        }

        try {
            const response = await fetch(`${API_URL}/admin/add-knowledge`, {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({
                    admin_code: adminCode,
                    widget_key: WIDGET_KEY,
                    table: table,
                    question: question,
                    keywords: keywords,
                    answer: answer,
                    source: source || 'Widget Admin'
                })
            });

            const data = await response.json();

            if (data.success) {
                alert('✅ Dataset berhasil ditambahkan!');
                // Clear form
                document.getElementById('adminQuestion').value = '';
                document.getElementById('adminKeywords').value = '';
                document.getElementById('adminAnswer').value = '';
                document.getElementById('adminSource').value = '';
            } else {
                alert('❌ ' + (data.message || 'Gagal menambahkan dataset'));
            }
        } catch (error) {
            alert('❌ Terjadi kesalahan: ' + error.message);
        }
    };

    // Load Current Prompt
    async function loadCurrentPrompt() {
        try {
            const response = await fetch(`${API_URL}/admin/get-prompt`, {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({
                    admin_code: adminCode,
                    widget_key: WIDGET_KEY
                })
            });

            const data = await response.json();

            if (data.success) {
                document.getElementById('adminPrompt').value = data.prompt || '';
            }
        } catch (error) {
            console.error('Failed to load prompt:', error);
        }
    }

    // Update AI Prompt
    window.updateAIPrompt = async function() {
        const prompt = document.getElementById('adminPrompt').value.trim();

        if (!prompt) {
            alert('⚠️ Prompt tidak boleh kosong!');
            return;
        }

        try {
            const response = await fetch(`${API_URL}/admin/update-prompt`, {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                },
                body: JSON.stringify({
                    admin_code: adminCode,
                    widget_key: WIDGET_KEY,
                    system_prompt: prompt
                })
            });

            const data = await response.json();

            if (data.success) {
                alert('✅ System prompt berhasil diperbarui!');
            } else {
                alert('❌ ' + (data.message || 'Gagal memperbarui prompt'));
            }
        } catch (error) {
            alert('❌ Terjadi kesalahan: ' + error.message);
        }
    };

    // UI Helper Functions
    function addUserMessage(text) {
        const messagesDiv = document.getElementById('polcabotMessages');
        const messageDiv = document.createElement('div');
        messageDiv.className = 'polcabot-message user';
        messageDiv.innerHTML = `
            <div class="message-avatar">👤</div>
            <div class="message-content">${escapeHtml(text)}</div>
        `;
        messagesDiv.appendChild(messageDiv);
        scrollToBottom();
    }

    function addBotMessage(html) {
        const messagesDiv = document.getElementById('polcabotMessages');
        const messageDiv = document.createElement('div');
        messageDiv.className = 'polcabot-message bot';
        messageDiv.innerHTML = `
            <div class="message-avatar">🤖</div>
            <div class="message-content">${html}</div>
        `;
        messagesDiv.appendChild(messageDiv);
        scrollToBottom();
    }

    function showTypingIndicator() {
        const messagesDiv = document.getElementById('polcabotMessages');
        const typingDiv = document.createElement('div');
        typingDiv.id = 'typingIndicator';
        typingDiv.className = 'polcabot-message bot';
        typingDiv.innerHTML = `
            <div class="message-avatar">🤖</div>
            <div class="typing-indicator">
                <span></span><span></span><span></span>
            </div>
        `;
        messagesDiv.appendChild(typingDiv);
        scrollToBottom();
    }

    function hideTypingIndicator() {
        const typingDiv = document.getElementById('typingIndicator');
        if (typingDiv) typingDiv.remove();
    }

    function scrollToBottom() {
        const messagesDiv = document.getElementById('polcabotMessages');
        messagesDiv.scrollTop = messagesDiv.scrollHeight;
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
})();
</script>
@endpush