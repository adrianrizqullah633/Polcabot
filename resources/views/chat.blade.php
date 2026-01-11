@extends('layouts.dashboard')

@section('title', 'Chat - ChatBot')

@section('dashboard-content')
<div class="p-6">
  <h2 class="text-xl font-semibold mb-4">Percakapan ID: {{ $chatId }}</h2>

  <div id="chatBox" class="border rounded-lg p-4 h-[400px] overflow-y-auto bg-gray-50 mb-4 prose prose-slate">
      @if ($question)
          <div class="text-right mb-2">
              <div class="inline-block bg-sky-100 px-3 py-2 rounded-lg">
                  <b>Anda:</b> {{ $question }}
              </div>
          </div>
          <div id="botReply" class="text-left text-gray-600 italic">Menunggu jawaban ChatBot...</div>
      @endif
  </div>

  <form id="chatForm" class="flex gap-2">
      <input 
          type="text" 
          id="chatInput" 
          placeholder="Ketik pesan..." 
          class="flex-1 border p-2 rounded-lg" 
          autocomplete="off"
      >
      <button 
          type="submit" 
          class="bg-sky-600 text-white px-4 py-2 rounded-lg hover:bg-sky-700">
          Kirim
      </button>
  </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const chatBox = document.getElementById('chatBox');
    const chatForm = document.getElementById('chatForm');
    const chatInput = document.getElementById('chatInput');

    const initialQuestion = @json($question);
    if (initialQuestion) sendMessage(initialQuestion);

    chatForm.addEventListener('submit', e => {
        e.preventDefault();
        const message = chatInput.value.trim();
        if (!message) return;
        chatInput.value = '';
        appendMessage('Anda', message, 'right');
        sendMessage(message);
    });

    function appendMessage(sender, text, side = 'left', isHtml = false) {
        const msg = document.createElement('div');
        msg.className = side === 'right' ? 'text-right mb-2' : 'text-left mb-2';
        msg.innerHTML = `
            <div class="inline-block px-3 py-2 rounded-lg max-w-[80%] ${
                side === 'right' ? 'bg-sky-100' : 'bg-gray-100'
            }">${isHtml ? text : `<b>${sender}:</b> ${text}`}</div>
        `;
        chatBox.appendChild(msg);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    async function sendMessage(message) {
        appendMessage('ChatBot', '...', 'left');
        const res = await fetch('{{ route("chatbot.chat") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message })
        });
        const data = await res.json();
        chatBox.lastChild.remove(); 
        appendMessage('ChatBot', data.reply, 'left', true);
    }
});
</script>
@endsection
