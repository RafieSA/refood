<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ is_array($restaurant) ? $restaurant['food_name'] : $restaurant->food_name }} - ReFood</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
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
    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <!-- Image Gallery -->
            <div class="relative h-72 md:h-96 w-full overflow-hidden image-gallery">
                <img src="{{ is_array($restaurant) ? $restaurant['photo_url'] : $restaurant->photo_url }}" 
                     alt="{{ is_array($restaurant) ? $restaurant['food_name'] : $restaurant->food_name }}" 
                     class="w-full h-full object-cover">
                
                @php
                    $discount_percentage = is_array($restaurant) ? ($restaurant['discount_percentage'] ?? 0) : ($restaurant->discount_percentage ?? 0);
                @endphp
                
                @if($discount_percentage > 0)
                <div class="absolute top-4 right-4 bg-green-600 text-white px-4 py-2 rounded-full font-bold shadow-lg discount-badge">
                    {{ $discount_percentage }}% OFF
                </div>
                @endif
            </div>
            
            <!-- Content -->
            <div class="p-6 md:p-8">
                <div class="flex flex-wrap items-start justify-between gap-4 mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">
                            {{ is_array($restaurant) ? $restaurant['food_name'] : $restaurant->food_name }}
                        </h1>
                        <div class="flex items-center space-x-2 mb-2">
                            <div class="flex">
                                @for($i = 0; $i < 5; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $i < 4 ? 'text-yellow-400' : 'text-gray-300' }}" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                @endfor
                                <span class="ml-2 text-sm text-gray-600">4.0 (125 reviews)</span>
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
                            <img src="{{ $admin->Restaurant_Photo ?? asset('default-restaurant.png') }}" alt="Foto Restoran" class="w-24 h-24 rounded-full object-cover border-2 border-green-500">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800 mb-1">{{ $admin->Restaurant_Name }}</h2>
                                <div class="flex items-center text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span>{{ is_array($restaurant) ? $restaurant['address'] : $restaurant->address }}</span>
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
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-sm p-6 md:p-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">Customer Reviews</h2>
                <button class="bg-green-50 text-green-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-100 transition">
                    Write a Review
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-start mb-3">
                        <div class="bg-green-100 h-10 w-10 rounded-full flex items-center justify-center text-green-700 font-semibold mr-3">
                            JD
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-800">John Doe</h4>
                            <div class="flex text-yellow-400 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                        </div>
                        <span class="ml-auto text-xs text-gray-500">2 days ago</span>
                    </div>
                    <p class="text-gray-700 text-sm">Great food and amazing discount! The ordering process was smooth and pickup was quick. Will definitely use ReFood again for more deals.</p>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <div class="flex items-start mb-3">
                        <div class="bg-green-100 h-10 w-10 rounded-full flex items-center justify-center text-green-700 font-semibold mr-3">
                            MS
                        </div>
                        <div>
                            <h4 class="font-medium text-gray-800">Maria Smith</h4>
                            <div class="flex text-yellow-400 text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </div>
                        </div>
                        <span class="ml-auto text-xs text-gray-500">1 week ago</span>
                    </div>
                    <p class="text-gray-700 text-sm">The food was still delicious even near closing time. Love that I'm helping reduce food waste while saving money. App is very user-friendly too!</p>
                </div>
            </div>
            
            <div class="text-center">
                <button class="text-green-600 hover:text-green-800 font-medium text-sm flex items-center mx-auto">
                    See all reviews
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-sm p-6 md:p-8">
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
    <footer class="bg-gray-800 text-white mt-12">
        <div class="container mx-auto px-4 py-12">
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
</html>