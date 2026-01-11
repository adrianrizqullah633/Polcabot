@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">🔐 Widget Admin Settings</h1>
        <p class="text-gray-600 mb-8">Kelola admin code untuk widget landing page</p>

        <!-- Current Admin Code -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">Admin Code Saat Ini</h2>
            
            @if($has_code)
                <div class="bg-gray-50 p-4 rounded border mb-4">
                    <code class="text-lg font-mono">{{ $admin_code }}</code>
                    <p class="text-sm text-gray-500 mt-2">Admin code disimpan dalam bentuk hash untuk keamanan</p>
                </div>
            @else
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                    <p class="text-yellow-700">⚠️ Belum ada admin code yang terdaftar. Generate kode baru di bawah.</p>
                </div>
            @endif

            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-4">
                <h3 class="font-bold text-blue-900 mb-2">ℹ️ Cara Menggunakan Admin Code:</h3>
                <ol class="list-decimal list-inside text-sm text-blue-800 space-y-1">
                    <li>Buka landing page (halaman depan website)</li>
                    <li>Klik bubble chat di pojok kanan bawah</li>
                    <li>Klik 3x pada teks "💡 Klik 3x untuk Admin Mode"</li>
                    <li>Panel admin akan muncul</li>
                    <li>Masukkan admin code</li>
                    <li>Isi form dan submit dataset baru</li>
                </ol>
            </div>

            <!-- Generate New Code Button -->
            <button 
                onclick="generateNewCode()" 
                class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:from-blue-600 hover:to-blue-700 transition-all"
            >
                🔄 Generate Admin Code Baru
            </button>
        </div>

        <!-- New Code Display (Hidden by default) -->
        <div id="newCodeDisplay" class="bg-green-50 border-2 border-green-400 rounded-lg p-6 mb-6" style="display: none;">
            <h2 class="text-xl font-bold text-green-900 mb-4">✅ Admin Code Baru Berhasil Di-Generate!</h2>
            
            <div class="bg-white p-4 rounded border-2 border-green-300 mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Admin Code Baru:</label>
                <div class="flex gap-2">
                    <input 
                        type="text" 
                        id="newCodeValue" 
                        readonly 
                        class="flex-1 px-4 py-3 border-2 border-gray-300 rounded-lg font-mono text-lg bg-gray-50"
                        value=""
                    />
                    <button 
                        onclick="copyCode()" 
                        class="px-6 py-3 bg-blue-500 text-white rounded-lg font-bold hover:bg-blue-600"
                    >
                        📋 Copy
                    </button>
                </div>
            </div>

            <div class="bg-red-50 border-l-4 border-red-400 p-4">
                <p class="text-red-800 font-bold">⚠️ PENTING:</p>
                <ul class="text-sm text-red-700 mt-2 space-y-1">
                    <li>• <strong>Simpan admin code ini dengan aman!</strong></li>
                    <li>• Code hanya ditampilkan sekali dan tidak bisa dilihat lagi</li>
                    <li>• Setelah generate, code lama tidak bisa digunakan lagi</li>
                    <li>• Berikan code ini hanya kepada admin yang terpercaya</li>
                </ul>
            </div>
        </div>

        <!-- Info Section -->
        <div class="bg-gray-50 rounded-lg p-6">
            <h3 class="font-bold text-gray-800 mb-3">📖 Tentang Admin Code</h3>
            <div class="text-sm text-gray-600 space-y-2">
                <p><strong>Fungsi:</strong> Admin code digunakan untuk mengautentikasi admin saat menambah dataset dari widget landing page tanpa perlu login ke dashboard.</p>
                
                <p><strong>Keamanan:</strong> Code disimpan dalam bentuk hash (encrypted) di database. Sistem akan memverifikasi code yang dimasukkan dengan hash yang tersimpan.</p>
                
                <p><strong>Best Practice:</strong></p>
                <ul class="list-disc list-inside ml-4">
                    <li>Generate code baru secara berkala (minimal 3 bulan sekali)</li>
                    <li>Jangan bagikan code via email atau chat yang tidak aman</li>
                    <li>Jika code bocor, segera generate code baru</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
async function generateNewCode() {
    if (!confirm('Generate admin code baru?\n\nCode lama akan tidak bisa digunakan lagi.')) {
        return;
    }

    try {
        const response = await fetch('{{ route("admin.widget.generate-code") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        const data = await response.json();

        if (data.success) {
            // Show new code
            document.getElementById('newCodeDisplay').style.display = 'block';
            document.getElementById('newCodeValue').value = data.admin_code;
            
            // Scroll to new code
            document.getElementById('newCodeDisplay').scrollIntoView({ 
                behavior: 'smooth', 
                block: 'center' 
            });

            // Auto-select code for easy copying
            document.getElementById('newCodeValue').select();
        } else {
            alert('❌ Gagal generate code: ' + data.message);
        }
    } catch (error) {
        console.error(error);
        alert('❌ Terjadi kesalahan koneksi');
    }
}

function copyCode() {
    const codeInput = document.getElementById('newCodeValue');
    codeInput.select();
    document.execCommand('copy');
    
    alert('✅ Admin code berhasil di-copy!\n\nSimpan code ini dengan aman.');
}
</script>
@endsection