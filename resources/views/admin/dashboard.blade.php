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
        <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Card: Total Restaurants -->
            <div class="bg-white shadow-md rounded-lg p-4">
                <h2 class="text-lg font-semibold">Total Restaurants</h2>
                <p class="text-3xl font-bold text-blue-500">{{ $totalRestaurants }}</p>
            </div>

            <!-- Card: Active Discounts -->
            <div class="bg-white shadow-md rounded-lg p-4">
                <h2 class="text-lg font-semibold">Active Discounts</h2>
                <p class="text-3xl font-bold text-green-500">{{ $activeDiscounts }}</p>
            </div>

            <!-- Card: Total Admins -->
            <div class="bg-white shadow-md rounded-lg p-4">
                <h2 class="text-lg font-semibold">Total Admins</h2>
                <p class="text-3xl font-bold text-purple-500">{{ $totalAdmins }}</p>
            </div>
        </div>
    </div>
</body>
</html>