<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ is_array($restaurant) ? $restaurant['food_name'] : $restaurant->food_name }} - ReFood</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            overflow-x: hidden;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
        }
        .discount-badge {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .image-gallery {
            transition: all 0.3s ease;
        }
        .image-gallery:hover {
            transform: scale(1.02);
        }
    </style>
</head>
<body class="bg-gray-50 m-0 p-0">
    <!-- Navbar -->
    <nav class="bg-white shadow-md fixed w-full top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="{{ route('frontend.home') }}" class="flex items-center hover:opacity-80 transition-opacity">
                        <h1 class="text-2xl font-bold text-green-600">ReFood</h1>
                        <span class="ml-2 text-gray-600 text-sm hidden sm:inline">All Discounts is Here!</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Search Form in Navbar -->
                    <form action="{{ route('frontend.restaurants.index') }}" method="GET" class="flex items-center">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari restoran/menu..."
                            class="border border-gray-300 rounded-lg px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                        <button type="submit" class="ml-2 text-green-600 hover:text-green-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                    <!-- Customer Service Link -->
                    <a href="{{ route('customer.service') }}" target="_blank" class="ml-4 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition">
                        Customer Service
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="w-full pt-16">
        <div class="bg-white shadow-sm overflow-hidden">
            <!-- Image Gallery -->
            <div class="relative h-72 md:h-96 w-full overflow-hidden image-gallery cursor-pointer" onclick="openGallery()">
                <img src="{{ is_array($restaurant) ? $restaurant['photo_url'] : $restaurant->photo_url }}" 
                     alt="{{ is_array($restaurant) ? $restaurant['food_name'] : $restaurant->food_name }}" 
                     class="w-full h-full object-cover">
                
                <!-- View Full Image Badge -->
                <div class="absolute bottom-4 right-4 bg-black bg-opacity-50 text-white px-3 py-1 rounded-lg text-sm flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                    </svg>
                    View Full Image
                </div>
                
                @php
                    $discount_percentage = is_array($restaurant) ? ($restaurant['discount_percentage'] ?? 0) : ($restaurant->discount_percentage ?? 0);
                @endphp
                
                @if($discount_percentage > 0)
                <div class="absolute top-4 right-4 bg-green-600 text-white px-4 py-2 rounded-full font-bold shadow-lg discount-badge">
                    {{ $discount_percentage }}% OFF
                </div>
                @endif
            </div>
            
            <!-- Content dengan padding internal -->
            <div class="px-4 md:px-8 py-6 md:py-8">
                <div class="flex flex-wrap items-start justify-between gap-4 mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">
                            {{ is_array($restaurant) ? $restaurant['food_name'] : $restaurant->food_name }}
                        </h1>
                        <div class="flex items-center space-x-2 mb-2">
                            <div class="flex">
                                @php
                                    $displayRating = $averageRating > 0 ? $averageRating : 0;
                                    $fullStars = floor($displayRating);
                                    $hasHalfStar = ($displayRating - $fullStars) >= 0.5;
                                @endphp
                                @for($i = 0; $i < 5; $i++)
                                    @if($i < $fullStars)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @elseif($i == $fullStars && $hasHalfStar)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endif
                                @endfor
                                <span class="ml-2 text-sm text-gray-600">
                                    @if($totalReviews > 0)
                                        {{ number_format($averageRating, 1) }} ({{ $totalReviews }} {{ $totalReviews == 1 ? 'review' : 'reviews' }})
                                    @else
                                        No reviews yet
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center text-gray-600 mb-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ is_array($restaurant) ? $restaurant['address'] : $restaurant->address }}</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ is_array($restaurant) ? $restaurant['opening_hours'] : $restaurant->opening_hours }}</span>
                        </div>
                    </div>
                    
                    <div class="flex space-x-2">
                        <button id="shareBtn" class="flex items-center justify-center h-10 w-10 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 transition" title="Share">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                            </svg>
                        </button>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="md:col-span-2">
                        <div class="bg-gray-50 p-6 rounded-xl">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Menu Details</h2>
                            
                            <!-- Food Type -->
                            <div class="mb-4">
                                <div class="flex items-center">
                                    <div class="bg-green-100 p-2 rounded-lg mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500">Cuisine Type</h3>
                                        <p class="text-gray-800 font-medium">{{ is_array($restaurant) ? $restaurant['food_type'] : $restaurant->food_type }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Location Info -->
                            <div class="mb-4">
                                <div class="flex items-center">
                                    <div class="bg-green-100 p-2 rounded-lg mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500">Distance</h3>
                                        <p class="text-gray-800 font-medium">1.2 km away</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Hours Info -->
                            <div>
                                <div class="flex items-center">
                                    <div class="bg-green-100 p-2 rounded-lg mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-500">Opening Hours</h3>
                                        <p class="text-gray-800 font-medium">{{ is_array($restaurant) ? $restaurant['opening_hours'] : $restaurant->opening_hours }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Description Section -->
                        <div class="mt-6 bg-gray-50 p-6 rounded-xl">
                            <h2 class="text-xl font-semibold text-gray-800 mb-4">Description</h2>
                            <p class="text-gray-700 leading-relaxed">
                                Discover delicious, high-quality food at a discounted price from {{ is_array($restaurant) ? $restaurant['food_name'] : $restaurant->food_name }}. 
                                By purchasing this deal, you're not only saving money but also helping reduce food waste.
                                Our restaurant partners prepare fresh meals daily and offer discounts on surplus items 
                                that would otherwise go to waste by the end of the day.
                            </p>
                        </div>
                        <div class="mt-8 mb-8 bg-white rounded-xl shadow-sm p-6 flex items-center space-x-6">
                            <!-- Foto Restoran yang bisa diklik -->
                            <a href="{{ route('frontend.restaurants.about', ['id' => is_array($restaurant) ? $restaurant['id'] : $restaurant->id]) }}" 
                            class="block cursor-pointer hover:opacity-90 transition-opacity">
                                <img src="{{ $admin->Restaurant_Photo ? asset('storage/' . $admin->Restaurant_Photo) : asset('default-restaurant.png') }}"
                                    alt="Foto Restoran"
                                    class="w-24 h-24 rounded-full object-cover border-2 border-green-500">
                            </a>
                            <div>
                                <!-- Nama Restoran yang bisa diklik -->
                                <a href="{{ route('frontend.restaurants.about', ['id' => is_array($restaurant) ? $restaurant['id'] : $restaurant->id]) }}"
                                class="block hover:text-green-600 transition-colors">
                                    <h2 class="text-2xl font-bold text-gray-800 mb-1">{{ $admin->Restaurant_Name }}</h2>
                                </a>
                                <div class="flex items-center text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <!-- Alamat Restoran yang bisa diklik -->
                                    <a href="{{ route('frontend.restaurants.map', ['id' => is_array($restaurant) ? $restaurant['id'] : $restaurant->id]) }}"
                                    class="hover:text-green-600 transition-colors">
                                        <span>{{ is_array($restaurant) ? $restaurant['address'] : $restaurant->address }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @php
                        $discount_percentage = is_array($restaurant) ? ($restaurant['discount_percentage'] ?? 0) : ($restaurant->discount_percentage ?? 0);
                        $discount_duration_hours = is_array($restaurant) ? ($restaurant['discount_duration_hours'] ?? 0) : ($restaurant->discount_duration_hours ?? 0);
                    @endphp
                    
                    <div>
                        <div class="bg-white border border-green-100 rounded-xl shadow-sm overflow-hidden">
                            <div class="bg-green-50 p-4">
                                <h2 class="text-xl font-bold text-green-700">Special Offer</h2>
                                <p class="text-green-600 text-sm">Limited time discount</p>
                            </div>
                            
                            <div class="p-6">
                                @if($discount_percentage > 0)
                                <div class="mb-6">
                                    <div class="text-center mb-4">
                                        <span class="text-4xl font-bold text-green-600">{{ $discount_percentage }}%</span>
                                        <span class="text-2xl font-bold text-green-600 ml-1">OFF</span>
                                    </div>
                                    
                                    <div class="bg-gray-100 rounded-full h-3 mb-2">
                                        @php
                                            $percentLeft = min(100, max(0, ($discount_duration_hours / 12) * 100));
                                        @endphp
                                        <div class="bg-green-500 h-3 rounded-full" style="width: {{ $percentLeft }}%"></div>
                                    </div>
                                    
                                    <div class="flex justify-between text-sm text-gray-600">
                                        <span>Time remaining:</span>
                                        <span class="font-semibold">{{ $discount_duration_hours }} hours</span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center">
                                        <div class="bg-green-100 p-2 rounded-full mr-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <span class="text-gray-700">Available now</span>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="bg-green-100 p-2 rounded-full mr-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <span class="text-gray-700">15 claimed</span>
                                    </div>
                                </div>
                                
                                <a href="{{ route('frontend.restaurants.claim', is_array($restaurant) ? $restaurant['id'] : $restaurant->id) }}" 
                                   class="block w-full bg-green-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-green-700 transition duration-300 text-center">
                                    Claim Discount
                                </a>
                                @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Reviews Section -->
    <div class="w-full py-8">
        <div class="bg-white shadow-sm px-4 md:px-8 py-6 md:py-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800">Ulasan Pelanggan</h2>
                    <p class="text-gray-500 text-sm mt-1">{{ $totalReviews }} {{ $totalReviews == 1 ? 'Ulasan' : 'Ulasan' }}</p>
                </div>
                <div class="flex gap-2 w-full sm:w-auto">
                    <select onchange="window.location.href='?sort=' + this.value" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="newest" {{ $sort == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ $sort == 'oldest' ? 'selected' : '' }}>Terlama</option>
                        <option value="highest" {{ $sort == 'highest' ? 'selected' : '' }}>Rating Tertinggi</option>
                        <option value="lowest" {{ $sort == 'lowest' ? 'selected' : '' }}>Rating Terendah</option>
                    </select>
                    <button
                        class="bg-green-50 text-green-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-100 transition whitespace-nowrap"
                        onclick="document.getElementById('review-modal').classList.remove('hidden')"
                        type="button"
                    >
                        Tulis Ulasan
                    </button>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                @forelse($coments as $coment)
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-start mb-3">
                        <div class="bg-green-100 h-10 w-10 rounded-full flex items-center justify-center text-green-700 font-semibold mr-3">
                            {{ strtoupper(substr($coment->name,0,2)) }}
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-800">{{ $coment->name }}</h4>
                            <div class="flex text-yellow-400 text-sm">
                                @for($i=1; $i<=$coment->rating; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-700 text-sm">{{ $coment->coments }}</p>
                </div>
                @empty
                <div class="col-span-2 text-center text-gray-400 py-8">Belum ada review. Jadilah yang pertama memberikan review!</div>
                @endforelse
            </div>
            
            <!-- Pagination Links -->
            @if($coments->hasPages())
            <div class="mt-6">
                {{ $coments->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Modal Popup Review -->
<div id="review-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-8 relative">
        <button class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-2xl"
            onclick="document.getElementById('review-modal').classList.add('hidden')">&times;</button>
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Tulis Ulasan</h2>
        <form action="{{ route('coments.store') }}" method="POST" id="review-form">
            @csrf
            <input type="hidden" name="restaurant_id" value="{{ is_array($restaurant) ? $restaurant['id'] : $restaurant->id }}">
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full border-gray-300 rounded-md" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Rating</label>
                <div class="flex flex-row-reverse justify-end" id="star-rating">
                    @for($i = 5; $i >= 1; $i--)
                        <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="hidden" required>
                        <label for="star{{ $i }}" class="cursor-pointer star-label" data-value="{{ $i }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 star-svg text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </label>
                    @endfor
                </div>
            </div>
            <div class="mb-4">
                <label for="coments" class="block text-sm font-medium text-gray-700">Komentar</label>
                <textarea name="coments" id="coments" rows="3" class="mt-1 block w-full border-gray-300 rounded-md" required></textarea>
            </div>
            <button type="submit" id="submit-review-btn" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 flex items-center justify-center w-full">
                <span id="submit-text">Kirim Ulasan</span>
                <svg id="loading-spinner" class="hidden animate-spin h-5 w-5 ml-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </button>
        </form>
    </div>
</div>

<!-- Loading Overlay (Full Screen) -->
<div id="loading-overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 flex flex-col items-center">
        <svg class="animate-spin h-12 w-12 text-green-600 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <p class="text-gray-700 font-medium">Mengirim ulasan Anda...</p>
    </div>
</div>

<!-- Success Toast Notification -->
@if(session('success'))
<div id="success-toast" class="fixed top-4 right-4 z-50 bg-white rounded-lg shadow-2xl overflow-hidden transform transition-all duration-300 max-w-md">
    <div class="flex items-start p-4">
        <div class="flex-shrink-0">
            <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div class="ml-3 flex-1">
            <p class="text-sm font-medium text-gray-900">Berhasil!</p>
            <p class="mt-1 text-sm text-gray-500">{{ session('success') }}</p>
        </div>
        <button onclick="document.getElementById('success-toast').remove()" class="ml-4 text-gray-400 hover:text-gray-500">
            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </button>
    </div>
    <div class="bg-green-500 h-1">
        <div id="toast-progress" class="bg-green-600 h-1 transition-all duration-[5000ms] ease-linear" style="width: 0%"></div>
    </div>
</div>
<script>
    // Auto hide toast after 5 seconds
    setTimeout(function() {
        document.getElementById('toast-progress').style.width = '100%';
    }, 10);
    setTimeout(function() {
        const toast = document.getElementById('success-toast');
        if (toast) {
            toast.style.transform = 'translateX(500px)';
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
        }
    }, 5000);
</script>
@endif

<script>
    // Interaktif bintang rating
    document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('#star-rating .star-label');
        const radios = document.querySelectorAll('#star-rating input[type="radio"]');
        stars.forEach(star => {
            star.addEventListener('mouseenter', function () {
                const val = parseInt(this.getAttribute('data-value'));
                highlightStars(val);
            });
            star.addEventListener('mouseleave', function () {
                const checked = document.querySelector('#star-rating input[type="radio"]:checked');
                highlightStars(checked ? parseInt(checked.value) : 0);
            });
            star.addEventListener('click', function () {
                const val = parseInt(this.getAttribute('data-value'));
                radios.forEach(radio => {
                    if (parseInt(radio.value) === val) radio.checked = true;
                });
                highlightStars(val);
            });
        });
        function highlightStars(val) {
            stars.forEach(star => {
                const starVal = parseInt(star.getAttribute('data-value'));
                star.querySelector('svg').classList.toggle('text-yellow-400', starVal <= val);
                star.querySelector('svg').classList.toggle('text-gray-300', starVal > val);
            });
        }
        highlightStars(0);
        
        // Loading spinner on form submit
        const reviewForm = document.getElementById('review-form');
        const submitBtn = document.getElementById('submit-review-btn');
        const submitText = document.getElementById('submit-text');
        const loadingSpinner = document.getElementById('loading-spinner');
        const loadingOverlay = document.getElementById('loading-overlay');
        
        if (reviewForm) {
            reviewForm.addEventListener('submit', function(e) {
                // Show loading spinner on button
                submitText.textContent = 'Mengirim...';
                loadingSpinner.classList.remove('hidden');
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                
                // Show full screen loading overlay
                loadingOverlay.classList.remove('hidden');
            });
        }
        
        // Back to Top Button functionality
        const backToTopBtn = document.getElementById('backToTop');
        
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopBtn.classList.remove('hidden');
                backToTopBtn.classList.add('flex');
            } else {
                backToTopBtn.classList.add('hidden');
                backToTopBtn.classList.remove('flex');
            }
        });
        
        backToTopBtn.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });
</script>

<!-- Back to Top Button -->
<button id="backToTop" class="hidden fixed bottom-8 right-8 z-40 items-center justify-center w-12 h-12 bg-green-600 text-white rounded-full shadow-lg hover:bg-green-700 transition-all duration-300 hover:scale-110">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
    </svg>
</button>

<!-- Image Gallery Lightbox Modal -->
<div id="galleryModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-90 flex items-center justify-center p-4">
    <button onclick="closeGallery()" class="absolute top-4 right-4 text-white hover:text-gray-300 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
    <div class="max-w-6xl w-full">
        <img id="galleryImage" src="{{ is_array($restaurant) ? $restaurant['photo_url'] : $restaurant->photo_url }}" 
             alt="{{ is_array($restaurant) ? $restaurant['food_name'] : $restaurant->food_name }}" 
             class="w-full h-auto rounded-lg shadow-2xl">
        <p class="text-white text-center mt-4 text-lg">{{ is_array($restaurant) ? $restaurant['food_name'] : $restaurant->food_name }}</p>
    </div>
</div>

<script>
    function openGallery() {
        document.getElementById('galleryModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeGallery() {
        document.getElementById('galleryModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    
    // Close on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeGallery();
    });
    
    // Close on click outside image
    document.getElementById('galleryModal').addEventListener('click', function(e) {
        if (e.target === this) closeGallery();
    });
</script>

    <!-- FAQ Section -->
    <div class="w-full py-8">
        <div class="bg-white shadow-sm px-4 md:px-8 py-6 md:py-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Frequently Asked Questions</h2>
            
            <div class="space-y-4">
                <div class="border-b border-gray-100 pb-4">
                    <button class="flex justify-between items-center w-full text-left">
                        <h3 class="font-medium text-gray-800">How does the discount claiming process work?</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="mt-2 text-gray-600 text-sm">
                        Click the "Claim Discount" button, select pickup time, and confirm your order. You'll receive a confirmation code that you'll show when picking up your food. Payment is made directly at the restaurant.
                    </div>
                </div>
                
                <div class="border-b border-gray-100 pb-4">
                    <button class="flex justify-between items-center w-full text-left">
                        <h3 class="font-medium text-gray-800">Can I cancel my claimed discount?</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
                
                <div class="border-b border-gray-100 pb-4">
                    <button class="flex justify-between items-center w-full text-left">
                        <h3 class="font-medium text-gray-800">What if I'm late for pickup?</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
                
                <div class="border-b border-gray-100 pb-4">
                    <button class="flex justify-between items-center w-full text-left">
                        <h3 class="font-medium text-gray-800">How is the food quality at discount times?</h3>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white w-full m-0">
        <div class="py-12 px-4 md:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Kolom 1: Logo dan Social Media -->
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        <h1 class="text-2xl font-bold text-white">ReFood</h1>
                    </div>
                    <p class="text-gray-400 mb-4">Save food, save money, and reduce waste with discounted restaurant meals.</p> 
                </div>
                
                <!-- Kolom 2: Quick Links -->
                <div>
                    <h3 class="text-lg font-medium mb-4">Tautan Cepat</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('frontend.restaurants.index') }}" class="text-gray-400 hover:text-white transition">Beranda</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Cara Kerja</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Partner Restaurant</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Blog</a></li>
                    </ul>
                </div>
                
                <!-- Kolom 3: Bantuan -->
                <div>
                    <h3 class="text-lg font-medium mb-4">Bantuan</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Kontak Kami</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Kebijakan Privasi</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                
                <!-- Kolom 4: Contact -->
                <div>
                    <h3 class="text-lg font-medium mb-4">Kontak</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400 mt-1 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-gray-400">Jl. Telekomunikasi No. 1, Bandung, Indonesia</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400 mt-1 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="text-gray-400">info@refood.id</span>
                        </li>
                        <li class="flex items-start">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400 mt-1 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span class="text-gray-400">+62 812-3456-7890</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Modal Share -->
    <div id="shareModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm text-center relative">
            <button id="closeShareModal" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <h2 class="text-lg font-semibold mb-4">Share Restaurant</h2>
            <div class="flex items-center border rounded px-2 py-1 mb-4">
                <input id="shareLink" type="text" readonly class="w-full outline-none bg-transparent text-gray-700" value="{{ url()->current() }}">
                <button id="copyShareLink" class="ml-2 bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">Copy</button>
            </div>
            <span id="copySuccess" class="text-green-600 text-sm hidden">Link copied!</span>
        </div>
    </div>

    <!-- Script Modal Share -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const shareBtn = document.getElementById('shareBtn');
            const shareModal = document.getElementById('shareModal');
            const closeShareModal = document.getElementById('closeShareModal');
            const copyBtn = document.getElementById('copyShareLink');
            const shareLink = document.getElementById('shareLink');
            const copySuccess = document.getElementById('copySuccess');

            shareBtn.addEventListener('click', () => {
                shareModal.classList.remove('hidden');
            });

            closeShareModal.addEventListener('click', () => {
                shareModal.classList.add('hidden');
                copySuccess.classList.add('hidden');
            });

            copyBtn.addEventListener('click', () => {
                shareLink.select();
                shareLink.setSelectionRange(0, 99999);
                document.execCommand('copy');
                copySuccess.classList.remove('hidden');
                setTimeout(() => copySuccess.classList.add('hidden'), 1500);
            });

            // Optional: close modal when clicking outside
            shareModal.addEventListener('click', function(e) {
                if (e.target === shareModal) {
                    shareModal.classList.add('hidden');
                    copySuccess.classList.add('hidden');
                }
            });
        });
    </script>
</body>
</html>