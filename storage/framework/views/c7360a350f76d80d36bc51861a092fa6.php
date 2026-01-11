<section id="home">
    <div class="home-content">
        <h1>
            Selamat Datang di
            <span style="color:white;">P</span><span style="color:orange;">o</span><span style="color:white;">l</span><span style="color:#1e90ff;">CaBot</span>
        </h1>
        <p class="tagline">
            PolCaBot adalah aplikasi chatbot berbasis AI yang dirancang untuk membantu menjawab pertanyaan seputar akademik dan administrasi kampus.
        </p>

        <!-- Tombol Get Started: arahkan ke LOGIN kalau belum login, ke DASHBOARD kalau sudah login -->
        <?php if(auth()->guard()->guest()): ?>
            <a href="<?php echo e(route('login')); ?>" class="btn-main">Get Started</a>
        <?php endif; ?>

        <?php if(auth()->guard()->check()): ?>
            <a href="<?php echo e(route('dashboard')); ?>" class="btn-main">Get Started</a>
        <?php endif; ?>
    </div>
</section>

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
        <!-- Header -->
        <div class="polcabot-header">
            <div class="polcabot-header-info">
                <div class="polcabot-header-avatar">🤖</div>
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

        <!-- Admin Panel (Hidden by default) -->
        <div class="admin-panel" id="adminPanel">
            <h4>🔐 Mode Admin - Tambah Dataset</h4>
            <input type="password" id="adminCode" placeholder="Masukkan Admin Code" />
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
            <button class="admin-submit-btn" onclick="submitAdminData()">
                ✅ Tambah Dataset
            </button>
        </div>

        <!-- Input Area -->
        <div class="polcabot-input-area">
            <div class="mode-switch" id="modeSwitch" title="Klik 3x untuk Admin Mode">
                💡 Klik 3x untuk Admin Mode
            </div>
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

        <!-- Powered By -->
        <div class="powered-by">
            Powered by <a href="https://polibatam.ac.id" target="_blank">Politeknik Negeri Batam</a>
        </div>
    </div>
</div>



<script>
// ========== POLCABOT WIDGET JAVASCRIPT (FIXED) ==========
(function() {
    let clickCount = 0;
    let clickTimer;
    let isAdminMode = false;

    // Toggle Widget
    const bubble = document.getElementById('polcabotBubble');
    const widget = document.getElementById('polcabotWindow');
    const closeBtn = document.getElementById('polcabotClose');
    const badge = document.querySelector('.notification-badge');

    bubble.addEventListener('click', () => {
        widget.classList.toggle('active');
        if (widget.classList.contains('active')) {
            badge.style.display = 'none';
            document.getElementById('polcabotInput').focus();
        }
    });

    closeBtn.addEventListener('click', () => {
        widget.classList.remove('active');
    });

    // Auto-resize textarea
    const input = document.getElementById('polcabotInput');
    input.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });

    // Enter to send (Shift+Enter for new line)
    input.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            sendMessage();
        }
    });

    // Triple click for Admin Mode
    const modeSwitch = document.getElementById('modeSwitch');
    modeSwitch.addEventListener('click', () => {
        clickCount++;
        clearTimeout(clickTimer);
        
        if (clickCount === 3) {
            toggleAdminMode();
            clickCount = 0;
        } else {
            clickTimer = setTimeout(() => clickCount = 0, 500);
        }
    });

    // Toggle Admin Mode
    window.toggleAdminMode = function() {
        isAdminMode = !isAdminMode;
        const adminPanel = document.getElementById('adminPanel');
        adminPanel.classList.toggle('active', isAdminMode);
        
        if (isAdminMode) {
            addBotMessage('🔐 Mode Admin aktif. Masukkan admin code untuk menambah dataset.');
        } else {
            addBotMessage('👤 Kembali ke Mode User.');
        }
    };

    // Send Message Function (FIXED: Route ke /widget/chat)
    window.sendMessage = async function() {
        const message = input.value.trim();
        if (!message) return;

        addUserMessage(message);
        input.value = '';
        input.style.height = 'auto';

        showTypingIndicator();

        try {
            // 🔧 FIX: Gunakan route widget (tanpa auth)
            const response = await fetch('<?php echo e(route("widget.chat")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({ message: message })
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
            console.error('Chat error:', error);
            addBotMessage('❌ Gagal menghubungi server. Periksa koneksi Anda.');
        }
    };

    // Quick Message
    window.sendQuickMessage = function(message) {
        input.value = message;
        sendMessage();
    };

    // Submit Admin Data (FIXED)
    window.submitAdminData = async function() {
        const code = document.getElementById('adminCode').value;
        const table = document.getElementById('adminTable').value;
        const question = document.getElementById('adminQuestion').value;
        const keywords = document.getElementById('adminKeywords').value;
        const answer = document.getElementById('adminAnswer').value;
        const source = document.getElementById('adminSource').value;

        if (!code || !question || !keywords || !answer) {
            alert('⚠️ Harap isi semua field yang wajib!');
            return;
        }

        try {
            // 🔧 FIX 1: Verify admin code first
            const verifyResponse = await fetch('<?php echo e(route("widget.verify-admin")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({ admin_code: code })
            });

            const verifyData = await verifyResponse.json();
            
            if (!verifyData.success) {
                alert('❌ Admin code tidak valid!');
                return;
            }

            // 🔧 FIX 2: Add to knowledge base
            const addResponse = await fetch('<?php echo e(route("widget.add-knowledge")); ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                },
                body: JSON.stringify({
                    admin_code: code,
                    table: table,
                    question: question,
                    keywords: keywords,
                    answer: answer,
                    source: source || 'Widget Admin'
                })
            });

            const addData = await addResponse.json();

            if (addData.success) {
                alert('✅ Dataset berhasil ditambahkan!');
                
                // Clear form
                document.getElementById('adminQuestion').value = '';
                document.getElementById('adminKeywords').value = '';
                document.getElementById('adminAnswer').value = '';
                document.getElementById('adminSource').value = '';
                
                addBotMessage('✅ Dataset berhasil ditambahkan ke knowledge base!');
            } else {
                alert('❌ Gagal menambahkan dataset: ' + (addData.message || 'Unknown error'));
            }
        } catch (error) {
            alert('❌ Terjadi kesalahan koneksi');
            console.error('Admin submit error:', error);
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
</script><?php /**PATH C:\laragon\www\Polcabot-9\resources\views/components/home.blade.php ENDPATH**/ ?>