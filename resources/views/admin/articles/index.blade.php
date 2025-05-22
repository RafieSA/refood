<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Artikel - ReFood</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        @if(session('success'))
            <div id="success-alert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                
                <!-- Loading bar -->
                <div class="mt-2 h-1 w-full bg-green-200 rounded-full overflow-hidden">
                    <div id="success-progress" class="h-1 bg-green-600 rounded-full w-0"></div>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const progressBar = document.getElementById('success-progress');
                    const alert = document.getElementById('success-alert');
                    const duration = 5000; // 5 detik
                    const interval = 20;
                    let width = 0;
                    let timePassed = 0;
                    
                    const timer = setInterval(function() {
                        timePassed += interval;
                        width = (timePassed / duration) * 100;
                        progressBar.style.width = width + '%';
                        
                        if (width >= 100) {
                            clearInterval(timer);
                            alert.style.opacity = '0';
                            alert.style.transition = 'opacity 0.5s';
                            setTimeout(function() {
                                alert.style.display = 'none';
                            }, 500);
                        }
                    }, interval);
                });
            </script>
        @endif

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Daftar Artikel</h1>
            <a href="{{ route('super_admin.dashboard') }}?active_tab=artikel" class="text-blue-500 hover:underline">
                ← Kembali ke Dashboard
            </a>
        </div>

        <a href="{{ route('articles.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Artikel</a>
        
        <form action="{{ route('articles.index') }}" method="GET" class="mb-4 flex items-center">
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari judul atau deskripsi artikel..."
                class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            <button type="submit" class="ml-2 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                Cari
            </button>
        </form>
        
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Unggah</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gambar</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($articles as $article)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $article->title }}</td>
                    <td class="px-6 py-4 whitespace-normal">{{ Str::limit($article->description, 100) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ \Carbon\Carbon::parse($article->uploaded_at)->format('d-m-Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($article->image_url)
                            <img src="{{ $article->image_url }}" alt="Gambar Artikel" class="h-16 rounded">
                        @else
                            Tidak ada gambar
                        @endif
                    </td>
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

                @if(count($articles) === 0)
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                        @if($search ?? false)
                            Tidak ada artikel yang sesuai dengan pencarian "{{ $search }}"
                        @else
                            Belum ada artikel.
                        @endif
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</body>
</html>