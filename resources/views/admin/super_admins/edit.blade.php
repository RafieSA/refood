<!-- filepath: c:\Users\ADDIN\Documents\SI4605-KEL411\resources\views\admin\super_admins\edit.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin - Super Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">Edit Admin</h1>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg p-6">
            <form action="{{ route('admins.update', $admin) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Admin Name -->
                <div class="mb-4">
                    <label for="Restaurant_Name" class="block text-sm font-medium text-gray-700">Restaurant Name</label>
                    <input type="text" name="Restaurant_Name" id="Restaurant_Name" value="{{ old('Restaurant_Name', $admin->Restaurant_Name) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                    @error('Restaurant_Name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Admin Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $admin->email) }}" required
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Admin Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password (Leave blank to keep current password)</label>
                    <input type="password" name="password" id="password"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-500 focus:ring-opacity-50">
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="mt-6 flex items-center justify-end">
                    <a href="{{ route('admins.index') }}" class="text-gray-500 hover:text-gray-700 mr-4">Cancel</a>
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                        Update Admin
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>