@extends('admin.layout')

@section('content')
<style>
    /* === DASHBOARD STYLES === */
    .content h2 {
        font-size: 28px;
        color: #333;
        margin-bottom: 10px;
    }

    .content > p {
        color: #666;
        margin-bottom: 15px;
        line-height: 1.6;
    }

    .card-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        margin-top: 30px;
    }

    .card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s, box-shadow 0.3s;
        text-align: center;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 123, 255, 0.2);
    }

    .card h3 {
        font-size: 18px;
        color: #007bff;
        margin-bottom: 15px;
        font-weight: 600;
    }

    .card p {
        font-size: 36px;
        font-weight: 700;
        color: #333;
        margin: 0;
    }

    .card small {
        display: block;
        margin-top: 10px;
        font-size: 12px;
        color: #999;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .card-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
    }

    @media (max-width: 768px) {
        .content h2 {
            font-size: 24px;
        }

        .card-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .card {
            padding: 25px;
        }

        .card p {
            font-size: 32px;
        }
    }

    @media (max-width: 480px) {
        .content h2 {
            font-size: 22px;
        }

        .content > p {
            font-size: 14px;
        }

        .card {
            padding: 20px;
        }

        .card h3 {
            font-size: 16px;
        }

        .card p {
            font-size: 28px;
        }
    }
</style>

<h2>📊 Dashboard</h2>
<p>Selamat datang di halaman dashboard admin PolCaBot.</p>
<p>Di sini Anda dapat memantau statistik sistem chatbot.</p>

<div class="card-grid">
    <div class="card">
        <h3>Total Pengguna</h3>
        <p>{{ $totalUsers ?? 0 }}</p>
        <small>Pengguna terdaftar</small>
    </div>
    <div class="card">
        <h3>Total Chat</h3>
        <p>{{ $totalChats ?? 0 }}</p>
        <small>Percakapan tersimpan</small>
    </div>
    <div class="card">
        <h3>Knowledge Base</h3>
        <p>{{ $totalKnowledgeBase ?? 0 }}</p>
        <small>
            @if(isset($knowledgeDetails))
                Organisasi: {{ $knowledgeDetails['organisasi'] }} | 
                Beasiswa: {{ $knowledgeDetails['beasiswa'] }} | 
                Jurusan: {{ $knowledgeDetails['jurusan'] }} | 
                Daftar: {{ $knowledgeDetails['daftar'] }}
            @endif
        </small>
    </div>
</div>
@endsection