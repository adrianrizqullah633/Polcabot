<div class="chat-input-container fixed bottom-6 right-6 z-50">
  <div class="chat-input bg-white border rounded-full shadow-lg flex items-center p-2">
    <input type="text" id="chatMessage" placeholder="Ketik Pertanyaan..." class="flex-1 border-0 outline-none px-2">
    <button onclick="createChatSession()">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/>
      </svg>
    </button>
  </div>
</div>

<script>
async function createChatSession() {
  const message = document.getElementById('chatMessage').value;
  if (!message.trim()) return;

  const res = await fetch('{{ route("chat.create") }}', {
    method: 'POST',
    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
  });
  const data = await res.json();
  window.location.href = `/chat/${data.chat_id}?message=${encodeURIComponent(message)}`;
}

// Tambahan: kirim pertanyaan dengan tombol Enter
document.addEventListener('DOMContentLoaded', () => {
  const input = document.getElementById('chatMessage');
  if (input) {
    input.addEventListener('keypress', (e) => {
      if (e.key === 'Enter' && input.value.trim() !== '') {
        e.preventDefault();
        createChatSession();
      }
    });
  }
});
</script>
