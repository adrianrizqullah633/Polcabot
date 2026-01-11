@extends('admin.layout')

@section('content')
<style>
    /* Responsive Styles */
    @media (max-width: 768px) {
        .header-container {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 1rem;
        }

        .search-actions {
            width: 100%;
            flex-direction: column;
            gap: 0.75rem;
        }

        .search-actions form {
            width: 100%;
        }

        .search-actions input {
            width: 100%;
        }

        .action-buttons-mobile {
            display: flex;
            width: 100%;
            gap: 0.5rem;
        }

        .filter-btn {
            flex: 0 0 auto;
        }

        .add-btn {
            flex: 1;
            text-align: center;
            white-space: nowrap;
            font-size: 0.875rem;
            padding: 0.625rem 1rem;
        }

        .table-header-desktop {
            display: none;
        }

        .table-row-mobile {
            display: block !important;
            padding: 1rem !important;
            margin-bottom: 1rem;
        }

        .mobile-card-item {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .mobile-card-item:last-child {
            border-bottom: none;
        }

        .mobile-label {
            font-weight: 600;
            color: #4b5563;
            font-size: 0.875rem;
        }

        .mobile-value {
            text-align: right;
            color: #1f2937;
            font-size: 0.875rem;
            max-width: 60%;
            word-break: break-word;
        }

        .pagination-mobile {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start !important;
        }

        .pagination-mobile p {
            font-size: 0.75rem;
        }
    }

    @media (max-width: 480px) {
        .container {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        h2 {
            font-size: 1.5rem !important;
        }

        .add-btn {
            font-size: 0.75rem;
            padding: 0.5rem 0.75rem;
        }

        .mobile-value {
            font-size: 0.75rem;
        }

        .mobile-label {
            font-size: 0.75rem;
        }
    }
</style>

<div class="container mx-auto px-4 py-8">
    
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif
    
    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        {{ session('error') }}
    </div>
    @endif

    <div class="flex justify-between items-center mb-6 header-container">
        <h2 class="text-3xl font-bold">Daftar</h2>
        
        <div class="flex items-center gap-4 search-actions">
            <form action="{{ route('admin.daftar.index') }}" method="GET" class="relative">
                <input 
                    type="text" 
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="cari disini..." 
                    class="border border-gray-300 rounded-lg px-4 py-2 pr-10 focus:outline-none focus:border-blue-500"
                >
                <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </form>
            
            <div class="action-buttons-mobile">
                <button class="p-2 hover:bg-gray-100 rounded-lg filter-btn">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                </button>
                
                <a href="{{ route('admin.daftar.create') }}" 
                   class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg font-medium add-btn">
                    ADD NEW DATASET
                </a>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg overflow-hidden">
        <div class="grid grid-cols-12 gap-4 px-4 py-3 bg-gray-50 border-b text-sm font-medium text-gray-600 table-header-desktop">
            <div class="col-span-1">Number</div>
            <div class="col-span-3">Question</div>
            <div class="col-span-3">Answer</div>
            <div class="col-span-3">Source</div>
            <div class="col-span-1">Date of addition</div>
            <div class="col-span-1"></div>
        </div>
        
        @forelse($datasets as $index => $data)
        <div class="hidden md:grid grid-cols-12 gap-4 px-4 py-4 border-2 border-blue-300 rounded-lg mb-2 mx-2 mt-2 items-center">
            <div class="col-span-1 text-center font-medium">
                {{ $datasets->firstItem() + $index }}.
            </div>
            <div class="col-span-3 text-sm">
                {{ $data->question }}
            </div>
            <div class="col-span-3 text-sm">
                {{ $data->answer }}
            </div>
            <div class="col-span-3 text-sm">
                <a href="{{ $data->source }}" target="_blank" class="text-blue-600 hover:underline break-all">
                    {{ Str::limit($data->source, 50) }}
                </a>
            </div>
            <div class="col-span-1 text-sm text-center">
                {{ \Carbon\Carbon::parse($data->created_at)->format('d-M-Y') }}
            </div>
            <div class="col-span-1 flex gap-2 justify-end">
                <a href="{{ route('admin.daftar.edit', $data->id) }}" class="text-yellow-500 hover:text-yellow-600">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                    </svg>
                </a>
                <form action="{{ route('admin.daftar.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <div class="md:hidden border-2 border-blue-300 rounded-lg mb-3 mx-2 mt-2 table-row-mobile">
            <div class="mobile-card-item">
                <span class="mobile-label">Number:</span>
                <span class="mobile-value font-medium">{{ $datasets->firstItem() + $index }}</span>
            </div>
            <div class="mobile-card-item">
                <span class="mobile-label">Question:</span>
                <span class="mobile-value">{{ Str::limit($data->question, 60) }}</span>
            </div>
            <div class="mobile-card-item">
                <span class="mobile-label">Answer:</span>
                <span class="mobile-value">{{ Str::limit($data->answer, 60) }}</span>
            </div>
            <div class="mobile-card-item">
                <span class="mobile-label">Source:</span>
                <a href="{{ $data->source }}" target="_blank" class="mobile-value text-blue-600 hover:underline break-all">
                    {{ Str::limit($data->source, 35) }}
                </a>
            </div>
            <div class="mobile-card-item">
                <span class="mobile-label">Date:</span>
                <span class="mobile-value">{{ \Carbon\Carbon::parse($data->created_at)->format('d-M-Y') }}</span>
            </div>
            <div class="mobile-card-item border-0 pt-3">
                <span class="mobile-label">Actions:</span>
                <div class="flex gap-3">
                    <a href="{{ route('admin.daftar.edit', $data->id) }}" class="text-yellow-500 hover:text-yellow-600">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                        </svg>
                    </a>
                    <form action="{{ route('admin.daftar.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-600">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        @empty
        <div class="text-center py-8 text-gray-500">
            Tidak ada data yang ditemukan.
        </div>
        @endforelse
    </div>
    
    <div class="flex justify-between items-center mt-4 px-2 pagination-mobile">
        <p class="text-sm text-gray-600">
            Showing {{ $datasets->firstItem() ?? 0 }} to {{ $datasets->lastItem() ?? 0 }} of {{ $datasets->total() }} entries
        </p>
        <div class="flex gap-2">
            {{ $datasets->links() }}
        </div>
    </div>
</div>
@endsection