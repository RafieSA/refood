@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    @if(session('success'))
        <div id="success-alert" class="fixed top-6 right-6 bg-green-500 text-white px-6 py-4 rounded shadow-lg z-50 flex items-center transition-opacity duration-500">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        <script>
            setTimeout(function() {
                const alert = document.getElementById('success-alert');
                if(alert) alert.style.opacity = 0;
            }, 3000);
        </script>
    @endif

    <h1 class="text-2xl font-bold mb-6">Daftar Artikel</h1>
    <a href="{{ route('articles.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Artikel</a>
    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead>
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($articles as $article)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">{{ $article->title }}</td>
                <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($article->uploaded_at)->format('d-m-Y') }}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <a href="{{ route('articles.edit', $article) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                    <form action="{{ route('articles.destroy', $article) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Yakin hapus artikel ini?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection