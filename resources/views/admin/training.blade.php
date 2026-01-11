@extends('admin.layout')

@section('content')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training AI</title>

    <style>
  /* Main Container */
  .training-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 40px;
    background: white;
    border-bottom: 1px solid #e5e5e5;
    margin-bottom: 0;
  }

  .dark-mode .training-header {
    background: #1f2937;
    border-bottom-color: #374151;
  }

  .training-title {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .training-title h2 {
    margin: 0;
    font-size: 22px;
    font-weight: 700;
    color: #1f2937;
  }

  .dark-mode .training-title h2 {
    color: #f3f4f6;
  }

  .training-title p {
    margin: 5px 0 0 0;
    font-size: 13px;
    color: #6b7280;
  }

  .dark-mode .training-title p {
    color: #9ca3af;
  }

  .edit-prompt-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: white;
    border: 2px solid #3b82f6;
    border-radius: 8px;
    color: #3b82f6;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .edit-prompt-btn:hover {
    background: #3b82f6;
    color: white;
  }

  .dark-mode .edit-prompt-btn {
    background: #1f2937;
    border-color: #60a5fa;
    color: #60a5fa;
  }

  .dark-mode .edit-prompt-btn:hover {
    background: #60a5fa;
    color: #1f2937;
  }

  /* Chat Container */
  .chat-wrapper {
    display: flex;
    flex-direction: column;
    height: calc(100vh - 200px);
    background: #f5f5f5;
    transition: background 0.3s ease;
    margin: 0;
  }

  .dark-mode .chat-wrapper {
    background: #1a1a2e;
  }

  .chat-content {
    flex: 1;
    overflow-y: auto;
    padding: 30px 20px 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .chat-messages-container {
    width: 100%;
    max-width: 900px;
    display: flex;
    flex-direction: column;
    gap: 30px;
  }

  /* Message Wrapper */
  .message-item {
    display: flex;
    gap: 15px;
    align-items: flex-start;
  }

  .message-item.user-message {
    flex-direction: row-reverse;
  }

  /* Avatar */
  .message-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
  }

  .message-item.bot-message .message-avatar {
    background: #3b82f6;
  }

  .message-item.user-message .message-avatar {
    background: #f97316;
  }

  .message-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  /* Message Bubble */
  .message-group {
    max-width: 70%;
    display: flex;
    flex-direction: column;
    gap: 10px;
  }

  .message-bubble {
    padding: 16px 20px;
    border-radius: 20px;
    line-height: 1.6;
    box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
  }

  .message-item.bot-message .message-bubble {
    background: #3b82f6;
    color: #ffffff;
    border-bottom-left-radius: 4px;
  }

  .message-item.user-message .message-bubble {
    background: #1e40af;
    color: white;
    border-bottom-right-radius: 4px;
  }

  .dark-mode .message-item.bot-message .message-bubble {
    background: #4f46e5;
    box-shadow: 0 2px 6px rgba(0,0,0,0.3);
  }

  .dark-mode .message-item.user-message .message-bubble {
    background: #1e3a8a;
    box-shadow: 0 2px 6px rgba(0,0,0,0.3);
  }

  /* Action Buttons */
  .message-actions {
    display: flex;
    gap: 10px;
    padding-left: 5px;
  }

  .message-item.user-message .message-actions {
    justify-content: flex-end;
    padding-left: 0;
    padding-right: 5px;
  }

  .action-button {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    background: white;
    border: 1px solid #e5e5e5;
    border-radius: 6px;
    font-size: 13px;
    color: #666;
    cursor: pointer;
    transition: all 0.2s ease;
  }

  .action-button:hover {
    background: #f5f5f5;
    border-color: #d4d4d4;
    color: #333;
  }

  .dark-mode .action-button {
    background: #2d3748;
    border-color: #4a5568;
    color: #cbd5e0;
  }

  .dark-mode .action-button:hover {
    background: #374151;
    border-color: #6b7280;
    color: #e5e7eb;
  }

  .action-button svg {
    width: 14px;
    height: 14px;
  }

  /* Input Container */
  .chat-input-area {
    position: relative;
    bottom: 0;
    left: 0;
    right: 0;
    background: #f5f5f5;
    padding: 20px 40px 30px;
    display: flex;
    justify-content: center;
    border-top: 1px solid #e5e5e5;
    transition: all 0.3s ease;
  }

  .dark-mode .chat-input-area {
    background: #1a1a2e;
    border-top-color: #374151;
  }

  .chat-input-box {
    width: 100%;
    max-width: 900px;
    display: flex;
    align-items: center;
    background: white;
    border: 1px solid #e5e5e5;
    border-radius: 30px;
    padding: 8px 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
  }

  .dark-mode .chat-input-box {
    background: #374151;
    border-color: #4a5568;
    box-shadow: 0 2px 8px rgba(0,0,0,0.3);
  }

  .chat-input-box input {
    flex: 1;
    background: transparent;
    border: none;
    outline: none;
    padding: 10px 15px;
    font-size: 15px;
    color: #333;
    transition: color 0.3s ease;
  }

  .dark-mode .chat-input-box input {
    color: #e5e7eb;
  }

  .chat-input-box input::placeholder {
    color: #999;
  }

  .dark-mode .chat-input-box input::placeholder {
    color: #6b7280;
  }

  .chat-send-button {
    width: 42px;
    height: 42px;
    background: #0ea5e9;
    border: none;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background 0.2s ease;
    flex-shrink: 0;
  }

  .chat-send-button:hover {
    background: #0284c7;
  }

  .dark-mode .chat-send-button {
    background: #0ea5e9;
  }

  .dark-mode .chat-send-button:hover {
    background: #06b6d4;
  }

  .chat-send-button:active {
    transform: scale(0.95);
  }

  .chat-send-button svg {
    width: 20px;
    height: 20px;
    fill: white;
  }

  /* Modal Styles */
  .modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
    align-items: center;
    justify-content: center;
  }

  .modal-overlay.active {
    display: flex;
  }

  .modal-content {
    background: white;
    border-radius: 16px;
    padding: 30px;
    width: 90%;
    max-width: 550px;
    max-height: 85vh;
    overflow-y: auto;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    animation: modalSlideIn 0.3s ease;
  }

  .dark-mode .modal-content {
    background: #1f2937;
  }

  @keyframes modalSlideIn {
    from {
      transform: translateY(-50px);
      opacity: 0;
    }
    to {
      transform: translateY(0);
      opacity: 1;
    }
  }

  .modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
  }

  .modal-header h3 {
    margin: 0;
    font-size: 20px;
    font-weight: 600;
  }

  .modal-close {
    background: transparent;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #666;
    padding: 0;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 4px;
    transition: all 0.2s ease;
  }

  .modal-close:hover {
    background: #f3f4f6;
    color: #333;
  }

  .dark-mode .modal-close {
    color: #9ca3af;
  }

  .dark-mode .modal-close:hover {
    background: #374151;
    color: #e5e7eb;
  }

  .modal-body {
    margin-bottom: 20px;
  }

  .modal-body label {
    display: block;
    margin-bottom: 10px;
    font-weight: 500;
    color: #333;
  }

  .dark-mode .modal-body label {
    color: #e5e7eb;
  }

  .modal-body textarea {
    width: 100%;
    min-height: 250px;
    padding: 15px;
    border: 1px solid #e5e5e5;
    border-radius: 8px;
    font-size: 14px;
    line-height: 1.7;
    resize: vertical;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    box-sizing: border-box;
  }

  .dark-mode .modal-body textarea {
    background: #374151;
    border-color: #4a5568;
    color: #e5e7eb;
  }

  .modal-body textarea:focus {
    outline: none;
    border-color: #3b82f6;
  }

  .modal-footer {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    gap: 10px;
  }

  .btn-cancel,
  .btn-save,
  .btn-reset {
    padding: 10px 24px;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    border: none;
  }

  .btn-reset {
    background: #dc2626;
    color: white;
  }

  .btn-reset:hover {
    background: #b91c1c;
  }

  .dark-mode .btn-reset {
    background: #ef4444;
  }

  .dark-mode .btn-reset:hover {
    background: #dc2626;
  }

  .btn-cancel {
    background: #f3f4f6;
    color: #333;
  }

  .btn-cancel:hover {
    background: #e5e7eb;
  }

  .dark-mode .btn-cancel {
    background: #374151;
    color: #e5e7eb;
  }

  .dark-mode .btn-cancel:hover {
    background: #4b5563;
  }

  .btn-save {
    background: #3b82f6;
    color: white;
  }

  .btn-save:hover {
    background: #2563eb;
  }

  /* Typing Indicator */
  .typing-indicator {
    display: flex;
    gap: 4px;
    padding: 16px 20px;
  }

  .typing-dot {
    width: 8px;
    height: 8px;
    background: rgba(255,255,255,0.7);
    border-radius: 50%;
    animation: typing 1.4s infinite;
  }

  .typing-dot:nth-child(2) {
    animation-delay: 0.2s;
  }

  .typing-dot:nth-child(3) {
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

  /* FORCE ALL BOT TEXT TO WHITE */
  .message-item.bot-message .message-bubble,
  .message-item.bot-message .message-bubble * {
      color: #ffffff !important;
  }

  /* DARK MODE FORCE WHITE */
  .dark-mode .message-item.bot-message .message-bubble,
  .dark-mode .message-item.bot-message .message-bubble * {
      color: #ffffff !important;
  }

  /* FIX LINKS IN BOT MESSAGE */
  .message-item.bot-message .message-bubble a {
      text-decoration: underline;
  }

  /* === RESPONSIVE STYLES === */
  @media (max-width: 768px) {
    .training-header {
      flex-direction: column;
      gap: 15px;
      align-items: flex-start;
      padding: 15px 20px;
    }

    .training-title h2 {
      font-size: 20px;
    }

    .training-title p {
      font-size: 12px;
    }

    .edit-prompt-btn {
      width: 100%;
      justify-content: center;
      padding: 12px 20px;
      font-size: 14px;
    }

    .edit-prompt-btn svg {
      width: 16px;
      height: 16px;
    }

    .chat-wrapper {
      height: calc(100vh - 240px);
    }

    .chat-content {
      padding: 20px 15px 15px;
    }

    .chat-messages-container {
      max-width: 100%;
      gap: 20px;
    }

    .message-item {
      gap: 10px;
    }

    .message-avatar {
      width: 40px;
      height: 40px;
    }

    .message-group {
      max-width: 75%;
    }

    .message-bubble {
      padding: 12px 16px;
      font-size: 14px;
    }

    .message-actions {
      flex-wrap: wrap;
      gap: 8px;
    }

    .action-button {
      padding: 8px 12px;
      font-size: 12px;
    }

    .action-button span {
      display: none;
    }

    .action-button svg {
      width: 16px;
      height: 16px;
    }

    .chat-input-area {
      padding: 15px 15px 20px;
    }

    .chat-input-box {
      max-width: 100%;
      padding: 6px 10px;
    }

    .chat-input-box input {
      padding: 8px 12px;
      font-size: 14px;
    }

    .chat-send-button {
      width: 38px;
      height: 38px;
    }

    .chat-send-button svg {
      width: 18px;
      height: 18px;
    }

    .modal-content {
      width: 95%;
      padding: 20px;
      max-height: 90vh;
    }

    .modal-header h3 {
      font-size: 18px;
    }

    .modal-body textarea {
      min-height: 200px;
      font-size: 13px;
    }

    .modal-footer {
      flex-direction: column-reverse;
      gap: 10px;
    }

    .modal-footer > div {
      display: none;
    }

    .btn-cancel,
    .btn-save,
    .btn-reset {
      width: 100%;
      padding: 12px 20px;
      justify-content: center;
    }
  }

  @media (max-width: 480px) {
    .training-header {
      padding: 12px 15px;
    }

    .training-title h2 {
      font-size: 18px;
    }

    .edit-prompt-btn {
      font-size: 13px;
      padding: 10px 16px;
    }

    .chat-wrapper {
      height: calc(100vh - 220px);
    }

    .chat-content {
      padding: 15px 10px 10px;
    }

    .message-avatar {
      width: 35px;
      height: 35px;
    }

    .message-group {
      max-width: 80%;
    }

    .message-bubble {
      padding: 10px 14px;
      font-size: 13px;
    }

    .chat-input-area {
      padding: 12px 10px 15px;
    }

    .chat-input-box input {
      font-size: 13px;
    }

    .chat-send-button {
      width: 36px;
      height: 36px;
    }

    .modal-content {
      padding: 15px;
    }

    .modal-body textarea {
      min-height: 180px;
    }
  }
</style>
</head>

<body>

<!-- Header with Edit Prompt Button -->
<div class="training-header">
    <div class="training-title">
        <div>
            <h2>🧠 Training AI</h2>
            <p>Halaman untuk melatih model AI agar chatbot semakin cerdas.</p>
        </div>
    </div>
    <button class="edit-prompt-btn" onclick="openEditModal()">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
            <path d="M20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83zM3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25z"/>
        </svg>
        <span>EDIT PROMPT</span>
    </button>
</div>

<div class="chat-wrapper">
    <!-- Chat Messages -->
    <div class="chat-content" id="chatContent">
        <div class="chat-messages-container" id="chatMessages"></div>
    </div>

    <!-- Input -->
    <div class="chat-input-area">
        <div class="chat-input-box">
            <input type="text" id="chatInput" placeholder="Ketik Pertanyaan..." autocomplete="off">
            <button class="chat-send-button" id="sendButton">
                <svg viewBox="0 0 24 24">
                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"></path>
                </svg>
            </button>
        </div>
    </div>
</div>

<!-- Edit Prompt Modal -->
<div class="modal-overlay" id="editModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>EDIT PROMPT</h3>
            <button class="modal-close" onclick="closeEditModal()">&times;</button>
        </div>
        <div class="modal-body">
            <label>System Prompt untuk AI Chatbot</label>
            <textarea id="promptText" placeholder="Masukkan system prompt untuk AI..."></textarea>
            <small style="color: #6b7280; display: block; margin-top: 8px;">
                💡 Tips: Jelaskan peran AI, gaya bahasa, dan batasan topik yang boleh dijawab.
            </small>
        </div>
        <div class="modal-footer">
            <button class="btn-reset" onclick="resetToDefault()">Reset Default</button>
            <div style="flex: 1"></div>
            <button class="btn-cancel" onclick="closeEditModal()">Cancel</button>
            <button class="btn-save" onclick="savePrompt()">Save</button>
        </div>
    </div>
</div>

<script>
const chatMessages = document.getElementById('chatMessages');
const chatContent = document.getElementById('chatContent');
const chatInput = document.getElementById('chatInput');
const sendButton = document.getElementById('sendButton');
const editModal = document.getElementById('editModal');
const promptText = document.getElementById('promptText');

// Auto scroll to bottom
function scrollToBottom() {
  chatContent.scrollTop = chatContent.scrollHeight;
}

// Add message to chat
function addMessage(role, text) {
  const messageDiv = document.createElement('div');
  messageDiv.className = `message-item ${role === 'bot' ? 'bot-message' : 'user-message'}`;

  const avatarIcon = role === 'bot' 
    ? 'https://cdn-icons-png.flaticon.com/512/4712/4712027.png'
    : 'https://cdn-icons-png.flaticon.com/512/4140/4140048.png';

  const actions = role === 'bot' 
    ? `<button class="action-button" onclick="copyMessage(this)">
        <svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"/>
        </svg>
        <span>Salin</span>
      </button>
      <button class="action-button" onclick="regenerate()">
        <svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/>
        </svg>
        <span>Ulang</span>
      </button>`
    : `<button class="action-button" onclick="copyMessage(this)">
        <svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"/>
        </svg>
        <span>Salin</span>
      </button>
      <button class="action-button" onclick="editMessage(this)">
        <svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
        </svg>
        <span>Edit</span>
      </button>`;

  messageDiv.innerHTML = `
    <div class="message-avatar">
      <img src="${avatarIcon}" alt="${role}">
    </div>
    <div class="message-group">
      <div class="message-bubble">${text}</div>
      <div class="message-actions">${actions}</div>
    </div>
  `;

  chatMessages.appendChild(messageDiv);
  scrollToBottom();
}

// Show typing indicator
function showTypingIndicator() {
  const typingDiv = document.createElement('div');
  typingDiv.className = 'message-item bot-message';
  typingDiv.id = 'typingIndicator';

  typingDiv.innerHTML = `
    <div class="message-avatar">
      <img src="https://cdn-icons-png.flaticon.com/512/4712/4712027.png" alt="Bot">
    </div>
    <div class="message-group">
      <div class="message-bubble typing-indicator">
        <div class="typing-dot"></div>
        <div class="typing-dot"></div>
        <div class="typing-dot"></div>
      </div>
    </div>
  `;

  chatMessages.appendChild(typingDiv);
  scrollToBottom();
}

// Remove typing indicator
function removeTypingIndicator() {
  const indicator = document.getElementById('typingIndicator');
  if (indicator) {
    indicator.remove();
  }
}

// Send message
async function sendMessage() {
  const message = chatInput.value.trim();
  if (!message) return;

  addMessage('user', message);
  chatInput.value = '';
  showTypingIndicator();

  try {
    const response = await fetch('{{ route("chatbot.chat") }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      body: JSON.stringify({ message: message })
    });

    const data = await response.json();
    removeTypingIndicator();
    addMessage('bot', data.reply || 'Maaf, terjadi kesalahan. Silakan coba lagi.');
    
  } catch (error) {
    console.error('Error:', error);
    removeTypingIndicator();
    addMessage('bot', 'Maaf, terjadi kesalahan koneksi. Silakan coba lagi.');
  }
}

// Copy message
function copyMessage(btn) {
  const bubble = btn.closest('.message-group').querySelector('.message-bubble');
  const text = bubble.textContent.trim();
  navigator.clipboard.writeText(text);
  
  const originalHTML = btn.innerHTML;
  btn.innerHTML = '<svg viewBox="0 0 24 24" fill="currentColor" style="width:14px;height:14px"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg><span>Tersalin</span>';
  setTimeout(() => {
    btn.innerHTML = originalHTML;
  }, 2000);
}

// Regenerate response
function regenerate() {
  const messages = chatMessages.querySelectorAll('.user-message');
  if (messages.length > 0) {
    const lastUserMessage = messages[messages.length - 1];
    const text = lastUserMessage.querySelector('.message-bubble').textContent.trim();
    
    showTypingIndicator();
    
    setTimeout(async () => {
      try {
        const response = await fetch('{{ route("chatbot.chat") }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({ message: text })
        });

        const data = await response.json();
        removeTypingIndicator();
        addMessage('bot', data.reply || 'Maaf, terjadi kesalahan. Silakan coba lagi.');
        
      } catch (error) {
        console.error('Error:', error);
        removeTypingIndicator();
        addMessage('bot', 'Maaf, terjadi kesalahan koneksi. Silakan coba lagi.');
      }
    }, 500);
  }
}

// Edit message
function editMessage(btn) {
  const bubble = btn.closest('.message-group').querySelector('.message-bubble');
  const text = bubble.textContent.trim();
  chatInput.value = text;
  chatInput.focus();
}

// Modal functions
async function openEditModal() {
  try {
    const response = await fetch('{{ route("admin.training.get") }}');
    const data = await response.json();
    
    if (data.success && data.prompt) {
      promptText.value = data.prompt;
    }
  } catch (error) {
    console.error('Error loading prompt:', error);
  }
  
  editModal.classList.add('active');
}

function closeEditModal() {
  editModal.classList.remove('active');
}

function savePrompt() {
  const newPrompt = promptText.value.trim();
  
  if (!newPrompt) {
    alert('Prompt tidak boleh kosong!');
    return;
  }

  const saveBtn = document.querySelector('.btn-save');
  const originalText = saveBtn.textContent;
  saveBtn.textContent = 'Menyimpan...';
  saveBtn.disabled = true;

  fetch('{{ route("admin.training.update") }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
    body: JSON.stringify({ prompt: newPrompt })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      closeEditModal();
      alert('✓ Prompt berhasil diperbarui!');
    } else {
      alert('✗ ' + (data.message || 'Gagal memperbarui prompt'));
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('✗ Gagal memperbarui prompt. Silakan coba lagi.');
  })
  .finally(() => {
    saveBtn.textContent = originalText;
    saveBtn.disabled = false;
  });
}

editModal.addEventListener('click', function(e) {
  if (e.target === editModal) {
    closeEditModal();
  }
});

function resetToDefault() {
  if (!confirm('Apakah Anda yakin ingin mereset prompt ke default? Perubahan yang belum disimpan akan hilang.')) {
    return;
  }

  fetch('{{ route("admin.training.reset") }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      promptText.value = data.prompt;
      alert('✓ Prompt berhasil direset ke default!');
    } else {
      alert('✗ Gagal mereset prompt');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('✗ Gagal mereset prompt. Silakan coba lagi.');
  });
}

chatInput.addEventListener('keypress', function(event) {
  if (event.key === 'Enter') {
    sendMessage();
  }
});

sendButton.addEventListener('click', sendMessage);

const urlParams = new URLSearchParams(window.location.search);
const autoMessage = urlParams.get('message');
if (autoMessage) {
  chatInput.value = autoMessage;
  sendMessage();
}

scrollToBottom();
</script>

</body>
</html>
@endsection