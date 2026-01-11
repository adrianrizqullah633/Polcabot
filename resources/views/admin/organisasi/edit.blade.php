@extends('admin.layout')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <div class="bg-white rounded-lg shadow-md p-6">
        
        <!-- Header -->
        <h2 class="text-2xl font-bold mb-6">Edit Dataset Organisasi</h2>
        
        <!-- Form -->
        <form action="{{ route('admin.organisasi.update', $dataset->id) }}" method="POST">
            @csrf
            @method('PUT')
            
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
                    placeholder="Masukkan pertanyaan..."
                    required
                >{{ old('question', $dataset->question) }}</textarea>
                
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
                    placeholder="Masukkan jawaban..."
                    required
                >{{ old('answer', $dataset->answer) }}</textarea>
                
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
                @php
                    $keywordsValue = old('keywords');
                    if (!$keywordsValue && $dataset->keywords) {
                        $keywords = is_string($dataset->keywords) ? json_decode($dataset->keywords, true) : $dataset->keywords;
                        $keywordsValue = is_array($keywords) ? implode(', ', $keywords) : $dataset->keywords;
                    }
                @endphp
                <input 
                    type="text" 
                    id="keywords" 
                    name="keywords" 
                    value="{{ $keywordsValue }}"
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
                    value="{{ old('source', $dataset->source) }}"
                    class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 {{ $errors->has('source') ? 'border-red-500' : 'border-gray-300' }}"
                    placeholder="https://example.com/source"
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
                
                <!-- Tombol Update -->
                <button 
                    type="submit" 
                    class="px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors">
                    Update Dataset
                </button>
            </div>
        </form>
        
    </div>
</div>
@endsection