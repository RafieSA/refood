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

        <!-- Tabs -->
        <div>
            <ul class="flex border-b mb-6" id="tabs">
                <li class="-mb-px mr-1">
                    <a href="#tab-admins" class="bg-white inline-block py-2 px-4 font-semibold border-l border-t border-r rounded-t text-green-700 active" onclick="showTab(event, 'tab-admins')">Admin Restaurants</a>
                </li>
                <li class="mr-1">
                    <a href="#tab-restaurants" class="bg-white inline-block py-2 px-4 font-semibold border-l border-t border-r rounded-t text-green-700" onclick="showTab(event, 'tab-restaurants')">Restaurants</a>
                </li>
                <li class="mr-1">
                    <a href="#tab-artikel" class="bg-white inline-block py-2 px-4 font-semibold border-l border-t border-r rounded-t text-green-700" onclick="showTab(event, 'tab-artikel')">Artikel</a>
                </li>
            </ul>
        </div>

        <!-- Tab Content: Admins -->
        <div id="tab-admins" class="tab-content">
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
                                <a href="{{ route('admins.edit', $admin) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
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

        <!-- Tab Content: Restaurants -->
        <div id="tab-restaurants" class="tab-content hidden">
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
                                <a href="{{ route('restaurants.edit', $restaurant) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
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

        <!-- Tab Content: Artikel -->
        <div id="tab-artikel" class="tab-content hidden">
            <h2 class="text-xl font-semibold mb-4">Artikel</h2>
            <a href="{{ route('articles.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded mb-4 inline-block">Tambah Artikel</a>
            <!-- Search Form -->
            <form action="{{ route('articles.index') }}" method="GET" class="mb-4 flex items-center">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul atau deskripsi artikel..."
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($articles as $article)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $article->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $article->description }}</td>
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
                </tbody>
            </table>
        </div>
    </div>
    <script>
        function showTab(evt, tabId) {
            evt.preventDefault();
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
            // Remove active class from all tabs
            document.querySelectorAll('#tabs a').forEach(tab => tab.classList.remove('border-b-2', 'border-green-600', 'active'));
            // Show selected tab
            document.getElementById(tabId).classList.remove('hidden');
            // Add active class to clicked tab
            evt.currentTarget.classList.add('border-b-2', 'border-green-600', 'active');
        }
        // Show first tab by default
        document.addEventListener('DOMContentLoaded', function() {
            showTab({preventDefault:()=>{}, currentTarget: document.querySelector('#tabs a')}, 'tab-admins');
        });
    </script>
</body>
</html>