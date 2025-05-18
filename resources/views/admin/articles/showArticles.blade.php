<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $article->title }} - Artikel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-12">
        <a href="{{ url()->previous() }}" class="text-green-600 hover:underline mb-6 inline-block">&larr; Kembali</a>
        <div class="bg-white rounded-lg shadow-md p-8 max-w-2xl mx-auto">
            @if($article->image_url)
                <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="w-full h-64 object-cover rounded mb-6">
            @endif
            <h1 class="text-3xl font-bold mb-4">{{ $article->title }}</h1>
            <div class="text-sm text-gray-500 mb-4">Diunggah {{ \Carbon\Carbon::parse($article->uploaded_at)->translatedFormat('d F Y H:i') }}</div>
            <div class="text-gray-700 leading-relaxed">{{ $article->description }}</div>
        </div>
    </div>
</body>
</html>