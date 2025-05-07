<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $restaurant->name }} - Detail Menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-green-600 mb-4">{{ $restaurant->name }}</h1>
        <p class="text-gray-700 mb-4">{{ $restaurant->address }}</p>
        <img src="{{ $restaurant->photo_url }}" alt="{{ $restaurant->name }}" class="w-full h-64 object-cover rounded-lg mb-4">
        <p class="text-gray-600 mb-4"><strong>Special Dish:</strong> {{ $restaurant->food_name }}</p>
        <p class="text-gray-600 mb-4"><strong>Cuisine:</strong> {{ $restaurant->food_type }}</p>
        <p class="text-gray-600 mb-4"><strong>Opening Hours:</strong> {{ $restaurant->opening_hours }}</p>
        <p class="text-gray-600 mb-4"><strong>Discount:</strong> {{ $restaurant->discount_percentage }}% ({{ $restaurant->discount_duration_hours }} hours left)</p>
        <p class="text-gray-600"><strong>Description:</strong> {{ $restaurant->description ?? 'No description available.' }}</p>
    </div>
</body>
</html>