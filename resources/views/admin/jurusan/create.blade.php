@extends('admin.layout')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <div class="bg-white rounded-lg shadow-md p-6">
        
        <!-- Header -->
        <h2 class="text-2xl font-bold mb-6">Tambah Dataset Jurusan Baru</h2>
        
        <!-- Form -->
        <form action="{{ route('admin.jurusan.store') }}" method="POST">
            @csrf
            
            <!-- Field: Question (Pertanyaan) -->
            <div class="mb-4">
                <label for="question" class="block text-sm font-medium text-gray-700 mb-2">
                    Pertanyaan <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="question" 
                    name="question" 
                    rows="3"
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('question') ? 'border-red-500' : 'border-gray-300' }}"
                    placeholder="Contoh: Apakah ada organisasi yang berfokus pada olahraga?"
                    required
                >{{ old('question') }}</textarea>
                
                @error('question')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Field: Answer (Jawaban) -->
            <div class="mb-4">
                <label for="answer" class="block text-sm font-medium text-gray-700 mb-2">
                    Jawaban <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="answer" 
                    name="answer" 
                    rows="4"
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('answer') ? 'border-red-500' : 'border-gray-300' }}"
                    placeholder="Contoh: Ada, yaitu Komite Olahraga POlibatam"
                    required
                >{{ old('answer') }}</textarea>
                
                @error('answer')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Field: Keywords (Kata Kunci) -->
            <div class="mb-4">
                <label for="keywords" class="block text-sm font-medium text-gray-700 mb-2">
                    Keywords / Tags
                    <span class="text-gray-500 text-xs font-normal">(pisahkan dengan koma)</span>
                </label>
                <input 
                    type="text" 
                    id="keywords" 
                    name="keywords" 
                    value="{{ old('keywords') }}"
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('keywords') ? 'border-red-500' : 'border-gray-300' }}"
                    placeholder="Contoh: olahraga, komite, polibatam, futsal, basket"
                >
                <p class="text-xs text-gray-500 mt-1">
                    💡 Tips: Gunakan keywords untuk memudahkan pencarian. Pisahkan dengan koma (,)
                </p>
                
                @error('keywords')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Field: Source (URL Sumber) -->
            <div class="mb-6">
                <label for="source" class="block text-sm font-medium text-gray-700 mb-2">
                    Sumber (URL) <span class="text-red-500">*</span>
                </label>
                <input 
                    type="url" 
                    id="source" 
                    name="source" 
                    value="{{ old('source') }}"
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('source') ? 'border-red-500' : 'border-gray-300' }}"
                    placeholder="https://www.instagram.com/komiteolahragapolibatam/"
                    required
                >
                
                @error('source')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Buttons -->
            <div class="flex justify-end gap-3">
                <!-- Tombol Batal -->
                <a href="{{ route('admin.organisasi.index') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                    Batal
                </a>
                
                <!-- Tombol Simpan -->
                <button 
                    type="submit" 
                    class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors">
                    Simpan Dataset
                </button>
            </div>
        </form>
        
    </div>
</div>
@endsection