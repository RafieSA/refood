<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Restaurant - ReFood Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">Edit Restaurant</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('restaurants.update', $restaurant) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Restaurant Details -->
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Restaurant Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $restaurant->name) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <textarea name="address" id="address" rows="3" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">{{ old('address', $restaurant->address) }}</textarea>
                            @error('address')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="opening_hours" class="block text-sm font-medium text-gray-700">Opening Hours</label>
                            <input type="text" name="opening_hours" id="opening_hours" value="{{ old('opening_hours', $restaurant->opening_hours) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50"
                                placeholder="e.g. Mon-Fri: 9am-5pm, Sat-Sun: 10am-3pm">
                            @error('opening_hours')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="photo" class="block text-sm font-medium text-gray-700">Photo</label>
                            @if($restaurant->photo_url)
                                <div class="mt-2 mb-2">
                                    <img src="{{ $restaurant->photo_url }}" alt="Current photo" class="h-24 w-24 object-cover rounded">
                                    <p class="text-xs text-gray-500 mt-1">Current photo</p>
                                </div>
                            @endif
                            <input type="file" name="photo" id="photo" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                            @error('photo')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Food & Discount Details -->
                    <div class="space-y-4">
                        <div>
                            <label for="food_name" class="block text-sm font-medium text-gray-700">Food Name</label>
                            <input type="text" name="food_name" id="food_name" value="{{ old('food_name', $restaurant->food_name) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                            @error('food_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="food_type" class="block text-sm font-medium text-gray-700">Food Type</label>
                            <input type="text" name="food_type" id="food_type" value="{{ old('food_type', $restaurant->food_type) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50"
                                placeholder="e.g. Italian, Fast Food, Dessert">
                            @error('food_type')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="discount_percentage" class="block text-sm font-medium text-gray-700">Discount Percentage (%)</label>
                            <input type="number" name="discount_percentage" id="discount_percentage" value="{{ old('discount_percentage', $restaurant->discount_percentage) }}" required
                                min="0" max="100"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                            @error('discount_percentage')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="discount" class="block text-sm font-medium text-gray-700">Discount Amount</label>
                            <input type="number" name="discount" id="discount" value="{{ old('discount', $restaurant->discount) }}" required
                                min="0" step="0.01"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                            @error('discount')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="discount_duration_hours" class="block text-sm font-medium text-gray-700">Discount Duration (hours)</label>
                            <input type="number" name="discount_duration_hours" id="discount_duration_hours" value="{{ old('discount_duration_hours', $restaurant->discount_duration_hours) }}" required
                                min="1"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                            @error('discount_duration_hours')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end">
                    <a href="{{ route('restaurants.index') }}" class="text-gray-500 hover:text-gray-700 mr-4">Cancel</a>
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                        Update Restaurant
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>