<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $admin->Restaurant_Name }} - Tentang Restoran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
        }
    </style>
</head>
<body>
    <div class="container mx-auto px-4 py-8">
        <!-- Header dengan tombol kembali -->
        <div class="mb-6">
            <a href="{{ route('frontend.restaurants.show', ['id' => is_array($restaurant) ? $restaurant['id'] : $restaurant->id]) }}" 
               class="inline-flex items-center text-green-600 hover:text-green-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke detail menu
            </a>
        </div>
        
        <!-- Konten utama -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="p-8">
                <div class="flex flex-col md:flex-row items-start gap-8">
                    <!-- Foto restoran -->
                    <div class="md:w-1/3">
                        <img src="{{ $admin->Restaurant_Photo ? asset('storage/' . $admin->Restaurant_Photo) : asset('default-restaurant.png') }}"
                             alt="Foto Restoran"
                             class="w-full h-auto rounded-lg object-cover">
                    </div>
                    
                    <!-- Info restoran -->
                    <div class="md:w-2/3">
                        <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $admin->Restaurant_Name }}</h1>
                        
                        <div class="mb-4 flex items-center text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ is_array($restaurant) ? $restaurant['address'] : $restaurant->address }}</span>
                        </div>
                        
                        <div class="mb-4 flex items-center text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ is_array($restaurant) ? $restaurant['opening_hours'] : $restaurant->opening_hours }}</span>
                        </div>
                        
                        <div class="mb-6 flex items-center text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <span>{{ is_array($restaurant) ? $restaurant['food_type'] : $restaurant->food_type }}</span>
                        </div>
                        
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">Tentang {{ $admin->Restaurant_Name }}</h2>
                        <p class="text-gray-700 mb-6 leading-relaxed">
                            {{ $admin->Restaurant_Name }} adalah salah satu restoran terbaik yang menyajikan makanan {{ is_array($restaurant) ? $restaurant['food_type'] : $restaurant->food_type }} 
                            dengan kualitas terbaik. Kami berkomitmen untuk menyediakan pengalaman kuliner yang tidak terlupakan
                            dengan bahan-bahan segar dan pelayanan yang ramah.
                        </p>
                        
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">Menu Unggulan</h2>
                        <p class="text-gray-700 mb-4 leading-relaxed">
                            Nikmati menu unggulan kami: {{ is_array($restaurant) ? $restaurant['food_name'] : $restaurant->food_name }} dengan
                            diskon hingga {{ is_array($restaurant) ? $restaurant['discount_percentage'] : $restaurant->discount_percentage }}%.
                        </p>
                        
                        <a href="{{ route('frontend.restaurants.claim', ['id' => is_array($restaurant) ? $restaurant['id'] : $restaurant->id]) }}" 
                           class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-green-700 transition duration-300">
                            Klaim Diskon Sekarang
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>