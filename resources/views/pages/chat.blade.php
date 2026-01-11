@extends('layouts.dashboard')
@section('title', 'Chat - PolCaBot')

@push('styles')
<style>
  /* Chat Container */
  .chat-wrapper {
    display: flex;
    flex-direction: column;
    height: calc(100vh - 70px);
    background: #f5f5f5;
    transition: background 0.3s ease;
    margin-left: 0;
  }

  .dark-mode .chat-wrapper {
    background: #1a1a2e;
  }

  .chat-content {
    flex: 1;
    overflow-y: auto;
    padding: 110px 20px 120px;
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
    background: #2563eb;
    transition: background 0.3s ease;
  }

  .dark-mode .message-avatar {
    background: #3b82f6;
  }

  .message-item.user-message .message-avatar {
    background: #f97316;
  }

  .dark-mode .message-item.user-message .message-avatar {
    background: #fb923c;
  }

  .message-avatar img {
    width: 30px;
    height: 30px;
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
    background: #3b82f6;
    color: white;
    transition: all 0.3s ease;
  }

  .message-item.bot-message .message-bubble {
    border-bottom-left-radius: 4px;
  }

  .message-item.user-message .message-bubble {
    background: #1e40af;
    border-bottom-right-radius: 4px;
  }

  /* Dark Mode Bubble Colors */
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

  /* Dark Mode Action Buttons */
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
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: #f5f5f5;
    padding: 20px;
    display: flex;
    justify-content: center;
    border-top: 1px solid #e5e5e5;
    transition: all 0.3s ease;
    z-index: 100;
  }

  .dark-mode .chat-input-area {
    background: #1a1a2e;
    border-top-color: #374151;
  }

  .chat-input-box {
    width: 100%;
    max-width: 700px;
    display: flex;
    align-items: center;
    background: #d1d5db;
    border-radius: 30px;
    padding: 8px 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
  }

  .dark-mode .chat-input-box {
    background: #374151;
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
    color: #666;
  }

  .dark-mode .chat-input-box input::placeholder {
    color: #9ca3af;
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

  /* Responsive */
  @media (max-width: 768px) {
    .chat-messages-container {
      max-width: 100%;
    }

    .message-group {
      max-width: 80%;
    }

    .chat-input-box {
      max-width: 100%;
    }
    
    .chat-content {
      padding: 80px 15px 100px;
    }
  }
</style>
@endpush

@section('dashboard-content')
<div class="chat-wrapper">
  <!-- Chat Content -->
  <div class="chat-content" id="chatContent">
    <div class="chat-messages-container" id="chatMessages">
      <!-- Messages akan ditambahkan di sini oleh JavaScript -->
    </div>
  </div>

  <!-- Input Area -->
  <div class="chat-input-area">
    <div class="chat-input-box">
      <input 
        type="text" 
        id="chatInput" 
        placeholder="Ketik Pertanyaan..." 
        autocomplete="off"
      >
      <button class="chat-send-button" id="sendButton">
        <svg viewBox="0 0 24 24">
          <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
        </svg>
      </button>
    </div>
  </div>
</div>

@push('scripts')
<script>
(function() {
  'use strict';
  
  console.log('🚀 Chat page initializing...');
  
  // ========== SIDEBAR & DARK MODE INITIALIZATION ==========
  function initChatPageFeatures() {
    // Initialize Sidebar Toggle
    const menuToggle = document.querySelector('.menu-toggle');
    const sidebar = document.querySelector('.sidebar');
    const overlay = document.querySelector('.sidebar-overlay');
    const sidebarLinks = document.querySelectorAll('.sidebar-menu li, .profile-card');
    
    if (menuToggle && sidebar) {
      console.log('✅ Initializing sidebar for chat page');
      
      function toggleSidebar() {
        const isActive = sidebar.classList.toggle('active');
        
        if (overlay) {
          overlay.classList.toggle('active', isActive);
        }
        
        if (window.innerWidth <= 768) {
          document.body.style.overflow = isActive ? 'hidden' : '';
        }
        
        console.log(isActive ? '📂 Sidebar opened' : '📁 Sidebar closed');
      }
      
      menuToggle.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        toggleSidebar();
      });
      
      if (overlay) {
        overlay.addEventListener('click', function() {
          sidebar.classList.remove('active');
          overlay.classList.remove('active');
          document.body.style.overflow = '';
        });
      }
      
      sidebarLinks.forEach(link => {
        link.addEventListener('click', function() {
          if (window.innerWidth <= 768) {
            sidebar.classList.remove('active');
            if (overlay) {
              overlay.classList.remove('active');
            }
            document.body.style.overflow = '';
          }
        });
      });
    }
    
    // Initialize Dark Mode
    const darkModeToggle = document.querySelector('.dark-mode-toggle');
    const toggleSwitch = document.querySelector('.toggle-switch');
    
    if (darkModeToggle && toggleSwitch) {
      console.log('✅ Initializing dark mode for chat page');
      
      // Load saved preference
      const savedMode = localStorage.getItem('darkMode');
      const isDarkMode = savedMode === 'true';
      
      if (isDarkMode) {
        document.body.classList.add('dark-mode');
        document.body.classList.remove('light-mode');
        toggleSwitch.classList.add('active');
      }
      
      function toggleDarkMode() {
        const body = document.body;
        const wasDark = body.classList.contains('dark-mode');
        
        if (wasDark) {
          body.classList.remove('dark-mode');
          body.classList.add('light-mode');
          toggleSwitch.classList.remove('active');
          localStorage.setItem('darkMode', 'false');
          console.log('☀️ Light mode');
        } else {
          body.classList.add('dark-mode');
          body.classList.remove('light-mode');
          toggleSwitch.classList.add('active');
          localStorage.setItem('darkMode', 'true');
          console.log('🌙 Dark mode');
        }
      }
      
      toggleSwitch.addEventListener('click', function(e) {
        e.stopPropagation();
        toggleDarkMode();
      });
      
      darkModeToggle.addEventListener('click', function(e) {
        if (e.target === toggleSwitch || toggleSwitch.contains(e.target)) {
          return;
        }
        toggleDarkMode();
      });
    }
  }
  
  // ========== CHAT FUNCTIONALITY ==========
  const chatMessages = document.getElementById('chatMessages');
  const chatContent = document.getElementById('chatContent');
  const chatInput = document.getElementById('chatInput');
  const sendButton = document.getElementById('sendButton');

  // Auto scroll to bottom
  function scrollToBottom() {
    chatContent.scrollTop = chatContent.scrollHeight;
  }

  // Add message to chat
  function addMessage(role, text) {
    const messageDiv = document.createElement('div');
    messageDiv.className = `message-item ${role === 'bot' ? 'bot-message' : 'user-message'}`;

    const avatarIcon = role === 'bot' 
      ? '{{ asset("images/logo.png") }}'
      : 'https://cdn-icons-png.flaticon.com/512/4140/4140048.png';
    
    const avatarSize = role === 'bot' ? 40 : 30;
    const actions = role === 'bot' 
      ? `<button class="action-button" onclick="copyMessage(this)">
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"/>
          </svg>
          Salin
        </button>
        <button class="action-button" onclick="regenerate()">
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/>
          </svg>
          Ulang
        </button>`
      : `<button class="action-button" onclick="copyMessage(this)">
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"/>
          </svg>
          Salin
        </button>
        <button class="action-button" onclick="editMessage(this)">
          <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
          </svg>
          Edit
        </button>`;

    messageDiv.innerHTML = `
      <div class="message-avatar">
        <img src="${avatarIcon}" alt="${role}" width="${avatarSize}" height="${avatarSize}" style="width:${avatarSize}px;height:${avatarSize}px;">
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
        <img src="{{ asset("images/logo.png") }}" alt="Bot" width="40" height="40" style="width:40px;height:40px;">
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
      const response = await fetch('{{ url("/chatbot/send") }}', {
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

  // Global functions for buttons
  window.copyMessage = function(btn) {
    const bubble = btn.closest('.message-group').querySelector('.message-bubble');
    const text = bubble.textContent.trim();
    navigator.clipboard.writeText(text);
    
    const originalHTML = btn.innerHTML;
    btn.innerHTML = '<span>✓ Tersalin</span>';
    setTimeout(() => {
      btn.innerHTML = originalHTML;
    }, 2000);
  };

  window.regenerate = function() {
    const messages = chatMessages.querySelectorAll('.user-message');
    if (messages.length > 0) {
      const lastUserMessage = messages[messages.length - 1];
      const text = lastUserMessage.querySelector('.message-bubble').textContent.trim();
      
      showTypingIndicator();
      
      setTimeout(async () => {
        try {
          const response = await fetch('{{ url("/chatbot/send") }}', {
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
  };

  window.editMessage = function(btn) {
    const bubble = btn.closest('.message-group').querySelector('.message-bubble');
    const text = bubble.textContent.trim();
    chatInput.value = text;
    chatInput.focus();
  };

  // Event listeners
  chatInput.addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
      sendMessage();
    }
  });

  sendButton.addEventListener('click', sendMessage);

  // Check for auto message from URL
  const urlParams = new URLSearchParams(window.location.search);
  const autoMessage = urlParams.get('message');
  if (autoMessage) {
    chatInput.value = autoMessage;
    sendMessage();
  }

  // Initialize features
  initChatPageFeatures();
  scrollToBottom();
  
  console.log('✅ Chat page fully initialized');
})();
</script>
@endpush
@endsection