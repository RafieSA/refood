<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">Edit Profile</h1>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Restaurant Name -->
                <div class="mb-4">
                    <label for="Restaurant_Name" class="block text-sm font-medium text-gray-700">Restaurant Name</label>
                    <input type="text" name="Restaurant_Name" id="Restaurant_Name" value="{{ old('Restaurant_Name', $admin->Restaurant_Name) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                    @error('Restaurant_Name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Restaurant Photo -->
                <div class="mb-4">
                    <label for="Restaurant_Photo" class="block text-sm font-medium text-gray-700">Restaurant Photo</label>
                    @if ($admin->Restaurant_Photo)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $admin->Restaurant_Photo) }}" alt="Restaurant Photo" class="h-24 w-24 object-cover rounded">
                        </div>
                    @endif
                    <input type="file" name="Restaurant_Photo" id="Restaurant_Photo" accept="image/*"
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                    @error('Restaurant_Photo')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="mt-6 flex items-center justify-end">
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>