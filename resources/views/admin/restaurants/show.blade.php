blade.php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $restaurant->name }} - ReFood Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">Restaurant Details</h1>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <!-- Restaurant Image Header -->
            @if($restaurant->photo_url)
                <div class="w-full h-64 bg-cover bg-center" style="background-image: url('{{ $restaurant->photo_url }}')"></div>
            @else
                <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-400">No image available</span>
                </div>
            @endif

            <!-- Restaurant Details -->
            <div class="p-6">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">{{ $restaurant->name }}</h2>
                        <p class="text-gray-600 mt-1">{{ $restaurant->address }}</p>
                        <p class="text-sm text-gray-500 mt-1">Opening Hours: {{ $restaurant->opening_hours }}</p>
                    </div>
                    <div>
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                            {{ $restaurant->discount_percentage }}% OFF
                        </span>
                    </div>
                </div>

                <div class="mt-6 border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-800">Food Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                        <div>
                            <p class="text-sm text-gray-600">Food Name:</p>
                            <p class="font-medium">{{ $restaurant->food_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Food Type:</p>
                            <p class="font-medium">{{ $restaurant->food_type }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-800">Discount Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-3">
                        <div>
                            <p class="text-sm text-gray-600">Discount Percentage:</p>
                            <p class="font-medium">{{ $restaurant->discount_percentage }}%</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Discount Amount:</p>
                            <p class="font-medium">{{ $restaurant->discount }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Duration:</p>
                            <p class="font-medium">{{ $restaurant->discount_duration_hours }} hours</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-800">Additional Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                        <div>
                            <p class="text-sm text-gray-600">Created At:</p>
                            <p class="font-medium">{{ $restaurant->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Last Updated:</p>
                            <p class="font-medium">{{ $restaurant->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('restaurants.edit', $restaurant) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        Edit Restaurant
                    </a>
                    <form action="{{ route('restaurants.destroy', $restaurant) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded" onclick="return confirm('Are you sure you want to delete this restaurant?')">
                            Delete Restaurant
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('restaurants.index') }}" class="text-blue-500 hover:underline">
                ← Back to Restaurants
            </a>
        </div>
    </div>
</body>
</html>