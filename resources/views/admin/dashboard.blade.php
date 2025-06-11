{{-- filepath: d:\Kuliah\Semester 6\ppl-refood\SI4605-KEL411\resources\views\admin\dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard ReFood</h1>
            @if(auth()->guard('admins')->check() && auth()->guard('admins')->user()->Restaurant_Name)
                <p class="text-xl text-green-600 font-medium mt-1">{{ auth()->guard('admins')->user()->Restaurant_Name }}</p>
            @else
                <p class="text-lg text-gray-500 mt-1">Restaurant Name Not Set</p>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Card: Total Menus -->
            <div class="bg-white shadow-md rounded-lg p-4">
                <h2 class="text-lg font-semibold">Total Menus</h2>
                <p class="text-3xl font-bold text-blue-500">{{ $totalRestaurants }}</p>
            </div>

            <!-- Card: Active Discounts -->
            <div class="bg-white shadow-md rounded-lg p-4">
                <h2 class="text-lg font-semibold">Active Discounts</h2>
                <p class="text-3xl font-bold text-green-500">{{ $activeDiscounts }}</p>
            </div>
        </div>
        
        <!-- Add Quick Action Links -->
        <div class="mt-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold">Quick Actions</h2>
            </div>
            <div class="bg-white shadow-md rounded-lg p-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('admin.profile.edit') }}" class="block p-4 border border-gray-200 rounded-md hover:bg-yellow-50">
                        <h3 class="font-semibold text-yellow-600">Edit Profile</h3>
                        <p class="text-sm text-gray-600 mt-1">Update your restaurant name and photo</p>
                    </a>
                    <a href="{{ route('admin.restaurants.create') }}" class="block p-4 border border-gray-200 rounded-md hover:bg-green-50">
                        <h3 class="font-semibold text-green-600">Add New Menu</h3>
                        <p class="text-sm text-gray-600 mt-1">Create a new Menu with discount offer</p>
                    </a>
                    <a href="{{ route('admin.restaurants.index') }}" class="block p-4 border border-gray-200 rounded-md hover:bg-blue-50">
                        <h3 class="font-semibold text-blue-600">View All Menu</h3>
                        <p class="text-sm text-gray-600 mt-1">Manage existing Menu listings</p>
                    </a>
                    <a href="{{ route('admin.voucher.claims.index') }}" class="block p-4 border border-gray-200 rounded-md hover:bg-blue-50">
                        <h3 class="font-semibold text-red-600">View Claimed Vouchers</h3>
                        <p class="text-sm text-gray-600 mt-1">View and manage voucher claims submitted by users</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>