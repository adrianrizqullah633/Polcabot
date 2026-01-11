@extends('layouts.dashboard')
@section('title', 'History Chat - PolCaBot')

@push('styles')
<style>
  .history-container {
    padding: 30px;
    max-width: 1200px;
    margin: 0 auto;
    min-height: calc(100vh - 70px);
  }

  .history-header {
    margin-bottom: 30px;
  }

  .history-header h1 {
    font-size: 28px;
    font-weight: 600;
    color: #333;
    margin-bottom: 10px;
  }

  .dark-mode .history-header h1 {
    color: #fff;
  }

  .history-header p {
    color: #666;
    font-size: 14px;
  }

  .dark-mode .history-header p {
    color: #999;
  }

  .search-box {
    margin-bottom: 30px;
  }

  .search-box input {
    width: 100%;
    max-width: 500px;
    padding: 12px 20px;
    border: 1px solid #e5e5e5;
    border-radius: 10px;
    font-size: 15px;
    transition: all 0.3s ease;
  }

  .search-box input:focus {
    outline: none;
    border-color: #3b82f6;
  }

  .dark-mode .search-box input {
    background: #2d3748;
    border-color: #4a5568;
    color: #fff;
  }

  .history-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
  }

  .history-card {
    background: white;
    border: 1px solid #e5e5e5;
    border-radius: 12px;
    padding: 20px;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
  }

  .history-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transform: translateY(-2px);
  }

  .dark-mode .history-card {
    background: #2d3748;
    border-color: #4a5568;
  }

  .dark-mode .history-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
  }

  .card-title {
    font-size: 16px;
    font-weight: 600;
    color: #333;
    margin-bottom: 10px;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
  }

  .dark-mode .card-title {
    color: #fff;
  }

  .card-preview {
    font-size: 14px;
    color: #666;
    margin-bottom: 15px;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
  }

  .dark-mode .card-preview {
    color: #999;
  }

  .card-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 12px;
    color: #999;
  }

  .card-actions {
    position: absolute;
    top: 15px;
    right: 15px;
    opacity: 0;
    transition: opacity 0.2s ease;
  }

  .history-card:hover .card-actions {
    opacity: 1;
  }

  .btn-delete-small {
    background: #ef4444;
    color: white;
    border: none;
    padding: 6px 10px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 12px;
  }

  .btn-delete-small:hover {
    background: #dc2626;
  }

  .empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #999;
  }

  .empty-state svg {
    width: 100px;
    height: 100px;
    margin-bottom: 20px;
    opacity: 0.3;
  }

  .empty-state h3 {
    font-size: 20px;
    margin-bottom: 10px;
  }

  .empty-state p {
    font-size: 14px;
  }
</style>
@endpush

@section('dashboard-content')
<div class="history-container">
  <div class="history-header">
    <h1>Riwayat Chat</h1>
    <p>Lihat dan lanjutkan percakapan sebelumnya dengan PolCaBot</p>
  </div>

  <div class="search-box">
    <input 
      type="text" 
      id="searchHistory" 
      placeholder="Cari riwayat chat..."
    >
  </div>

  <div class="history-grid" id="historyGrid">
    <!-- History cards akan dimuat di sini -->
  </div>
</div>

<script>
let conversations = [];
const csrfToken = '{{ csrf_token() }}';

function formatTime(timestamp) {
  const date = new Date(timestamp);
  const now = new Date();
  const diffMs = now - date;
  const diffDays = Math.floor(diffMs / 86400000);
  
  if (diffDays === 0) return 'Hari ini';
  if (diffDays === 1) return 'Kemarin';
  if (diffDays < 7) return `${diffDays} hari lalu`;
  return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
}

async function loadHistory() {
  try {
    const response = await fetch('/api/chat/conversations', {
      headers: {
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json'
      }
    });
    
    if (!response.ok) throw new Error('Failed to load history');
    
    conversations = await response.json();
    renderHistory(conversations);
  } catch (error) {
    console.error('Error loading history:', error);
    document.getElementById('historyGrid').innerHTML = `
      <div class="empty-state" style="grid-column: 1/-1;">
        <p>Gagal memuat riwayat chat. Silakan refresh halaman.</p>
      </div>
    `;
  }
}

function renderHistory(convs) {
  const grid = document.getElementById('historyGrid');
  
  if (convs.length === 0) {
    grid.innerHTML = `
      <div class="empty-state" style="grid-column: 1/-1;">
        <svg viewBox="0 0 24 24" fill="currentColor">
          <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z"/>
        </svg>
        <h3>Belum ada riwayat chat</h3>
        <p>Mulai percakapan baru dengan PolCaBot untuk melihat riwayat di sini</p>
      </div>
    `;
    return;
  }
  
  grid.innerHTML = convs.map(conv => `
    <div class="history-card" onclick="openConversation('${conv.id}')">
      <div class="card-actions">
        <button class="btn-delete-small" onclick="event.stopPropagation(); deleteConversation('${conv.id}')">
          Hapus
        </button>
      </div>
      <div class="card-title">${conv.title}</div>
      <div class="card-preview">${conv.lastMessage || 'Tidak ada pesan'}</div>
      <div class="card-meta">
        <span>${formatTime(conv.timestamp)}</span>
        <span>${conv.messageCount} pesan</span>
      </div>
    </div>
  `).join('');
}

function openConversation(conversationId) {
  window.location.href = `/chat?conv=${conversationId}`;
}

async function deleteConversation(conversationId) {
  if (!confirm('Hapus percakapan ini?')) return;
  
  try {
    const response = await fetch(`/api/chat/conversations/${conversationId}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json'
      }
    });
    
    if (!response.ok) throw new Error('Failed to delete');
    
    conversations = conversations.filter(c => c.id !== conversationId);
    renderHistory(conversations);
  } catch (error) {
    console.error('Error deleting conversation:', error);
    alert('Gagal menghapus percakapan');
  }
}

function searchHistory(query) {
  const filtered = conversations.filter(conv => 
    conv.title.toLowerCase().includes(query.toLowerCase())
  );
  renderHistory(filtered);
}

document.getElementById('searchHistory').addEventListener('input', (e) => {
  searchHistory(e.target.value);
});

loadHistory();
</script>
@endsection