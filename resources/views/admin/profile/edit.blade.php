<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
    <script>
        tailwind.config = {
        theme: {
            extend: {
            fontFamily: {
                inter: ['Inter', 'sans-serif'],
            },
            colors: {
                greenbrand: '#16a34a',
                greenbrandhover: '#15803d',
            }
            }
        }
        }
    </script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
    <!-- back ke dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center mb-4 text-green-700 hover:text-green-900 font-semibold">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
           Kembali ke Dashboard
        </a>    
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
                    <label for="Restaurant_Name" class="block text-base font-bold text-black">Restaurant Name</label>
                    <input type="text" name="Restaurant_Name" id="Restaurant_Name" value="{{ old('Restaurant_Name', $admin->Restaurant_Name) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                    @error('Restaurant_Name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Restaurant Photo -->
                <div class="mb-4">
                    <label for="Restaurant_Photo" class="block text-base font-bold text-black">Restaurant Photo</label>
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
                    <button type="submit" class="bg-greenbrand hover:bg-greenbrandhover text-white px-4 py-2 rounded-lg">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>