@extends('admin.layout')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <h2 class="text-2xl font-bold mb-2">📚 Knowledge Base</h2>
    <p class="text-gray-600 mb-8">Kelola pertanyaan dan jawaban yang diketahui oleh PolCaBot.</p>
    
    <!-- Grid dengan 2 Card -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl">
        
        <!-- Card 1: Jurusan / Prodi -->
        <div class="border-2 border-blue-500 rounded-lg p-6 bg-white hover:shadow-lg transition-shadow">
            <!-- Logo IF -->
            <div class="flex justify-center mb-4">
                <div class="w-50 h-50 rounded-lg overflow-hidden shadow-md bg-gray-100 flex items-center justify-center">
                    <img src="{{ asset('images/if.png') }}" alt="IF Foto" class="object-cover w-full h-full">
                </div>
            </div>
            
            
            <!-- Judul Card -->
            <h3 class="text-xl font-semibold mb-2">Jurusan / Prodi</h3>
            
            <!-- Deskripsi -->
            <p class="text-gray-600 text-sm mb-6">
                Please add your content here. Keep it short and simple. And smile :)
            </p>
            
            <!-- Tombol Masuk -->
            <a href="{{ route('admin.jurusan.index') }}" 
               class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-full text-sm font-medium transition-colors">
                Masuk
            </a>
        </div>

        <!-- Card 2: Organisasi -->
        <div class="border-2 border-blue-500 rounded-lg p-6 bg-white hover:shadow-lg transition-shadow">
            <!-- Logo HMIF -->
            <div class="flex justify-center mb-4">
                <div class="w-50 h-50 rounded-lg overflow-hidden shadow-md bg-gray-100 flex items-center justify-center">
                    <img src="{{ asset('images/hmti.jpg') }}" alt="HMTI Foto" class="object-cover w-full h-full">
                </div>
            </div>
            
            <!-- Judul Card -->
            <h3 class="text-xl font-semibold mb-2">Organisasi</h3>
            
            <!-- Deskripsi -->
            <p class="text-gray-600 text-sm mb-6">
                Please add your content here. Keep it short and simple. And smile :)
            </p>
            
            <!-- Tombol Masuk dengan Link ke Halaman Organisasi -->
            <a href="{{ route('admin.organisasi.index') }}" 
               class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-full text-sm font-medium transition-colors">
                Masuk
            </a>
        </div>

        <!-- Card 3: Daftar ulang -->
        <div class="border-2 border-blue-500 rounded-lg p-6 bg-white hover:shadow-lg transition-shadow">
            <!-- Logo HMIF -->
            <div class="flex justify-center mb-4">
                <div class="w-50 h-50 rounded-lg overflow-hidden shadow-md bg-gray-100 flex items-center justify-center">
                    <img src="{{ asset('images/Polibatam.png') }}" alt="Polibatam Foto" class="object-cover w-full h-full">
                </div>
            </div>
            
            <!-- Judul Card -->
            <h3 class="text-xl font-semibold mb-2">Daftar Ulang</h3>
            
            <!-- Deskripsi -->
            <p class="text-gray-600 text-sm mb-6">
                Please add your content here. Keep it short and simple. And smile :)
            </p>
            
            <!-- Tombol Masuk dengan Link ke Halaman daftar -->
            <a href="{{ route('admin.daftar.index') }}" 
               class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-full text-sm font-medium transition-colors">
                Masuk
            </a>
        </div>

        <!-- Card 4: Beasiswa -->
        <div class="border-2 border-blue-500 rounded-lg p-6 bg-white hover:shadow-lg transition-shadow">
            <!-- Logo HMIF -->
            <div class="flex justify-center mb-4">
                <div class="w-50 h-50 rounded-lg overflow-hidden shadow-md bg-gray-100 flex items-center justify-center">
                    <img src="{{ asset('images/topi.jpg') }}" alt="Beasiswa Foto" class="object-cover w-full h-full">
                </div>
            </div>
            
            <!-- Judul Card -->
            <h3 class="text-xl font-semibold mb-2">Beasiswa</h3>
            
            <!-- Deskripsi -->
            <p class="text-gray-600 text-sm mb-6">
                Please add your content here. Keep it short and simple. And smile :)
            </p>
            
            <!-- Tombol Masuk dengan Link ke Halaman Beasiswa -->
            <a href="{{ route('admin.beasiswa.index') }}" 
               class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-full text-sm font-medium transition-colors">
                Masuk
            </a>
        </div>
        
    </div>
</div>
@endsection