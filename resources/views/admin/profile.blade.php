@extends('admin.layout')

@section('content')
<style>
    /* --- Container utama --- */
    .profile-wrapper {
        background: #f1f5f9;
        padding: 40px;
        min-height: 100vh;
    }

    .profile-card {
        max-width: 700px;
        margin: 0 auto;
        background: white;
        border-radius: 20px;
        box-shadow: 0 6px 15px rgba(0,0,0,0.05);
        padding: 40px 50px;
    }

    .profile-header {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 30px;
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 20px;
    }

    .profile-avatar {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        border: 3px solid #0099ff;
        object-fit: cover;
        background: #f0f8ff;
        flex-shrink: 0;
    }

    .profile-info {
        flex: 1;
        min-width: 0;
    }

    .profile-header h3 {
        margin: 0;
        font-size: 22px;
        color: #333;
        font-weight: 700;
        word-wrap: break-word;
    }

    .profile-header p {
        margin: 3px 0 0;
        color: #666;
        font-size: 15px;
        word-wrap: break-word;
    }

    .form-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 6px;
        display: block;
        font-size: 15px;
    }

    .form-control {
        width: 100%;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 12px 14px;
        font-size: 15px;
        margin-bottom: 18px;
        outline: none;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }

    .form-control:focus {
        border-color: #0099ff;
        box-shadow: 0 0 4px rgba(0,153,255,0.3);
    }

    .form-help-text {
        display: block;
        color: #666;
        font-size: 13px;
        margin-top: -12px;
        margin-bottom: 18px;
    }

    .btn-save {
        background: #0099ff;
        color: white;
        font-weight: 600;
        border: none;
        padding: 12px 30px;
        border-radius: 10px;
        cursor: pointer;
        opacity: 1;
        transition: all 0.3s ease;
        font-size: 15px;
    }

    .btn-save:hover {
        background: #0088ee;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,153,255,0.3);
    }

    .btn-save:active {
        transform: translateY(0);
    }

    .alert-info {
        text-align: center;
        background: #e7f4ff;
        color: #007bff;
        border: 1px solid #b3e0ff;
        border-radius: 10px;
        padding: 10px;
        margin-bottom: 25px;
        font-size: 14px;
    }

    .alert-error {
        text-align: center;
        background: #ffe7e7;
        color: #dc3545;
        border: 1px solid #ffb3b3;
        border-radius: 10px;
        padding: 10px;
        margin-bottom: 25px;
        font-size: 14px;
    }

    .form-actions {
        text-align: center;
        margin-top: 25px;
    }

    /* Tambahan animasi halus */
    .profile-card {
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .profile-wrapper {
            padding: 20px 15px;
        }

        .profile-card {
            padding: 25px 20px;
            border-radius: 15px;
        }

        .profile-header {
            flex-direction: column;
            text-align: center;
            gap: 15px;
        }

        .profile-avatar {
            width: 90px;
            height: 90px;
        }

        .profile-header h3 {
            font-size: 20px;
        }

        .profile-header p {
            font-size: 14px;
        }

        .form-label {
            font-size: 14px;
        }

        .form-control {
            padding: 11px 13px;
            font-size: 14px;
            margin-bottom: 16px;
        }

        .form-help-text {
            font-size: 12px;
            margin-top: -10px;
            margin-bottom: 16px;
        }

        .btn-save {
            padding: 11px 25px;
            font-size: 14px;
            width: 100%;
        }

        .alert-info,
        .alert-error {
            font-size: 13px;
            padding: 10px 12px;
        }
    }

    @media (max-width: 480px) {
        .profile-wrapper {
            padding: 15px 10px;
        }

        .profile-card {
            padding: 20px 15px;
            border-radius: 12px;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
            border-width: 2px;
        }

        .profile-header h3 {
            font-size: 18px;
        }

        .profile-header p {
            font-size: 13px;
        }

        .form-label {
            font-size: 13px;
            margin-bottom: 5px;
        }

        .form-control {
            padding: 10px 12px;
            font-size: 13px;
            margin-bottom: 14px;
            border-radius: 8px;
        }

        .form-help-text {
            font-size: 11px;
            margin-top: -8px;
            margin-bottom: 14px;
        }

        .btn-save {
            padding: 10px 20px;
            font-size: 13px;
            border-radius: 8px;
        }

        .alert-info,
        .alert-error {
            font-size: 12px;
            padding: 9px 10px;
            border-radius: 8px;
        }
    }
</style>

<div class="profile-wrapper">
    <div class="profile-card">
        <div class="profile-header">
            <img
                src="{{ $user->profile_photo
                    ? asset('storage/profile/' . $user->profile_photo) . '?v=' . time()
                    : 'https://cdn-icons-png.flaticon.com/512/4712/4712107.png' }}"
                class="profile-avatar"
                alt="Admin">

            <div class="profile-info">
                <h3>{{ $user->username }}</h3>
                <p>{{ $user->email }}</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-info">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
            @csrf
            <label class="form-label">Nama</label>
            <input
                type="text"
                name="name"
                class="form-control"
                value="{{ old('name', $user->username) }}"
                placeholder="Masukkan nama">

            <label class="form-label">Email</label>
            <input 
                type="email" 
                class="form-control" 
                value="{{ $user->email }}" 
                readonly
                style="background-color: #f5f5f5; cursor: not-allowed;">

            <label class="form-label">Password Baru</label>
            <input 
                type="password" 
                name="password" 
                class="form-control" 
                placeholder="Masukkan password baru">
            <small class="form-help-text">
                Kosongkan password jika tidak ingin mengubah
            </small>

            <label class="form-label">Konfirmasi Password</label>
            <input
                type="password"
                name="password_confirmation"
                class="form-control"
                placeholder="Konfirmasi password baru">

            <label class="form-label">Foto Profil</label>
            <input 
                type="file" 
                name="profile_photo" 
                class="form-control"
                accept="image/*">

            <div class="form-actions">
                <button type="submit" class="btn-save">
                    💾 Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection