<!-- filepath: c:\Users\ADDIN\Documents\SI4605-KEL411\resources\views\admin\super_admin\dashboard.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">Super Admin Dashboard</h1>

        <!-- Section: Admin Restaurant -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-4">Admin Restaurants</h2>
            <a href="{{ route('admins.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded mb-4 inline-block">Add Admin</a>
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admins as $admin)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $admin->Restaurant_Name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $admin->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <!-- Edit Admin -->
                                <a href="{{ route('admins.edit', $admin) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                
                                <!-- Delete Admin -->
                                <form action="{{ route('admins.destroy', $admin) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this admin?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Section: Restaurants -->
        <div>
            <h2 class="text-xl font-semibold mb-4">Restaurants</h2>
            <a href="{{ route('restaurants.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded mb-4 inline-block">Add Restaurant</a>
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admin</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($restaurants as $restaurant)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $restaurant->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $restaurant->address }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $restaurant->admin->Restaurant_Name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <!-- Edit Restaurant -->
                                <a href="{{ route('restaurants.edit', $restaurant) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                
                                <!-- Delete Restaurant -->
                                <form action="{{ route('restaurants.destroy', $restaurant) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this restaurant?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>