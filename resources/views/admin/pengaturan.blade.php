@extends('admin.layout')

@section('content')
<h2>⚙️ Pengaturan Sistem</h2>
<p>Atur preferensi sistem chatbot PolCaBot di halaman ini.</p>

<div class="card-grid">
    <div class="card">
        <h3>Bahasa Chatbot</h3>
        <p>Indonesia 🇮🇩</p>
    </div>
    <div class="card">
        <h3>Mode Balasan</h3>
        <p>AI & Manual</p>
    </div>
    <div class="card">
        <h3>Status Server</h3>
        <p>Online ✅</p>
    </div>
</div>
@endsection