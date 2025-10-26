<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReFood - All Discounts is Here!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/accessibility.css') }}">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 font-medium" id="main-content">
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
                    <!-- Search Form in Navbar with Autocomplete -->
                    <form action="{{ route('frontend.restaurants.index') }}" method="GET" class="flex items-center relative" data-tour="search">
                        <div class="relative">
                            <input type="text" id="searchInput" name="search" value="{{ request('search') }}" 
                                   placeholder="Cari restoran/menu..." autocomplete="off"
                                   aria-label="Search restaurants, menus, or cuisine types"
                                   class="border border-gray-300 rounded-lg px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 w-64">
                            <div id="autocompleteResults" class="hidden absolute z-50 w-full bg-white border border-gray-200 rounded-lg shadow-lg mt-1 max-h-60 overflow-y-auto">
                                <!-- Autocomplete results will appear here -->
                            </div>
                        </div>
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

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-green-600 to-green-800 text-white pt-24 pb-16 px-4">
        <div class="container mx-auto text-center">
            <h2 class="text-4xl font-bold mb-4">Find Your Next Meal Deal</h2>
            <p class="text-xl text-green-100">Discover restaurants offering amazing discounts near you</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 -mt-10">
        <!-- Success Toast Notification -->
        @if(session('success'))
        <div id="success-toast" class="fixed top-4 right-4 z-50 bg-white rounded-lg shadow-2xl overflow-hidden transform transition-all duration-300 max-w-md animate-slide-in">
            <div class="flex items-start p-4">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <p class="text-sm font-medium text-gray-900">Success!</p>
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

        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-8" data-tour="filters">
            <div class="flex flex-wrap gap-4 justify-between items-center">
                <form action="{{ route('frontend.restaurants.index') }}" method="GET" class="flex space-x-4">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <select name="category" onchange="this.form.submit()" class="border border-gray-300 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500" aria-label="Filter by cuisine type">
                        <option value="">All Cuisines</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>
                                {{ ucfirst($cat) }}
                            </option>
                        @endforeach
                    </select>
                    <select name="discount" onchange="this.form.submit()" class="border border-gray-300 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500" aria-label="Filter by discount percentage">
                        <option value="">All Discounts</option>
                        <option value="10" {{ request('discount') == '10' ? 'selected' : '' }}>10% and above</option>
                        <option value="20" {{ request('discount') == '20' ? 'selected' : '' }}>20% and above</option>
                        <option value="30" {{ request('discount') == '30' ? 'selected' : '' }}>30% and above</option>
                    </select>
                </form>
                <div class="text-gray-600">
                    @if($restaurants->isEmpty())
                        <span>No restaurants available</span>
                    @else
                        <span>{{ $restaurants->count() }} restaurants found</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Kategori Carousel -->
        @php
            $categoryIcons = [
                'indonesian' => '🍚',
                'western' => '🍔',
                'asian' => '🍣',
                'japanese' => '🍱',
                'chinese' => '🥟',
                'italian' => '🍕',
                'mexican' => '🌮',
                'indian' => '🍛',
            ];
            $selectedCategory = strtolower(request('category', ''));
        @endphp

        <div class="container mx-auto px-4 mb-8">
            <div class="flex overflow-x-auto space-x-4 hide-scrollbar py-2">
                @foreach($categories as $cat)
                    @php
                        $catLower = strtolower($cat);
                        $icon = $categoryIcons[$catLower] ?? '🍽️';
                    @endphp
                    <a href="?category={{ $cat }}{{ request('search') ? '&search=' . request('search') : '' }}{{ request('discount') ? '&discount=' . request('discount') : '' }}"
                       class="flex items-center px-6 py-3 rounded-full shadow-md bg-white border transition
                           {{ $selectedCategory === $catLower ? 'border-green-600 bg-green-50 text-green-700 font-semibold' : 'border-gray-200 text-gray-700 hover:bg-green-50' }}">
                        <span class="text-2xl mr-3">{{ $icon }}</span>
                        <span class="whitespace-nowrap">{{ ucfirst($cat) }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        <style>
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        </style>

        <!-- Restaurants Grid -->
        @if($restaurants->isEmpty())
            <div class="text-center py-20 bg-white rounded-lg shadow-md">
                <div class="text-gray-400 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No restaurants available</h3>
                <p class="text-gray-500">Check back later for new deals!</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12" id="restaurant-list">
                @foreach($restaurants as $restaurant)
                    <a href="{{ route('frontend.restaurants.show', $restaurant->id) }}" class="restaurant-card block bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 group" data-tour="restaurant-card" role="article" aria-label="Restaurant: {{ $restaurant->admin->Restaurant_Name ?? 'N/A' }}, {{ $restaurant->discount_percentage }}% discount">
                        <!-- Image Container -->
                        <div class="relative h-48 overflow-hidden">
                            <img src="{{ $restaurant->photo_url }}" alt="{{ $restaurant->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @if($restaurant->discount_percentage)
                                <div class="absolute top-4 right-4 bg-red-600 text-white px-3 py-1 rounded-full text-sm font-bold">
                                    {{ $restaurant->discount_percentage }}% OFF
                                </div>
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-4">
                                    <p class="text-white font-medium">{{ $restaurant->discount_duration_hours }} hours left</p>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Content Container -->
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2 group-hover:text-green-600 transition duration-300">
                                {{ $restaurant->admin->Restaurant_Name ?? 'N/A' }}
                            </h3>
                            <div class="flex items-center text-gray-600 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="text-sm">{{ $restaurant->address }}</span>
                            </div>
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a4 4 0 00-4-4H6 4M12 8h8.465a2 2 0 011.989 2.5L20 18.5M4 11h4" />
                                    </svg>
                                    <span class="text-sm text-gray-700"><span class="font-medium">Special Dish:</span> {{ $restaurant->food_name }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                                    </svg>
                                    <span class="text-sm text-gray-700"><span class="font-medium">Cuisine:</span> {{ $restaurant->food_type }}</span>
                                </div>
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-sm text-gray-700"><span class="font-medium">Open:</span> {{ $restaurant->opening_hours }}</span>
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                                <p class="text-xs text-gray-400">Added {{ \Carbon\Carbon::parse($restaurant->created_at)->diffForHumans() }}</p>
                                @if($restaurant->discount_percentage)
                                    <button class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition duration-300">
                                        Claim Discount
                                    </button>
                                @else
                                    <button class="border border-green-600 text-green-600 px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-50 transition duration-300">
                                        View Details
                                    </button>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div> <!-- Penutup .container mx-auto utama -->

    <!-- Artikel Section -->
    <div class="container mx-auto px-4 mb-12">
        <h2 class="text-2xl font-bold mb-6 text-green-700">Artikel Terbaru</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($articles as $article)
                <a href="{{ route('frontend.articles.show', $article->id) }}" target="_blank"
                   class="bg-white rounded-lg shadow-md overflow-hidden cursor-pointer hover:shadow-lg transition block">
                    @if($article->image_url)
                        <img src="{{ $article->image_url }}" alt="{{ $article->title }}" class="w-full h-48 object-cover">
                    @endif
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-2">{{ $article->title }}</h3>
                        <p class="text-gray-600 mb-4">{{ Str::limit($article->description, 100) }}</p>
                        <div class="text-xs text-gray-400 mb-2">Diunggah {{ \Carbon\Carbon::parse($article->uploaded_at)->diffForHumans() }}</div>
                    </div>
                </a>
            @empty
                <div class="col-span-3 text-center text-gray-500">Belum ada artikel.</div>
            @endforelse
        </div>
    </div>

    <!-- Modal Popup -->
    <div id="article-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6 relative">
            <button onclick="closeArticleModal()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
            <img id="modal-article-image" src="" alt="" class="w-full h-56 object-cover rounded mb-4" style="display:none;">
            <h3 id="modal-article-title" class="text-xl font-bold mb-2"></h3>
            <div id="modal-article-date" class="text-xs text-gray-400 mb-2"></div>
            <p id="modal-article-description" class="text-gray-700"></p>
        </div>
    </div>

    <script>
        // Function to open the article modal and populate it with data
        function openArticleModal(title, description, image, date) {
            document.getElementById('modal-article-title').innerText = title;
            document.getElementById('modal-article-date').innerText = date;
            document.getElementById('modal-article-description').innerText = description;

            const imgElement = document.getElementById('modal-article-image');
            imgElement.src = image;
            imgElement.style.display = image ? 'block' : 'none';

            document.getElementById('article-modal').classList.remove('hidden');
        }

        // Function to close the article modal
        function closeArticleModal() {
            document.getElementById('article-modal').classList.add('hidden');
        }

        function showArticleModal(title, description, imageUrl, date) {
            document.getElementById('modal-article-title').textContent = title;
            document.getElementById('modal-article-description').textContent = description;
            document.getElementById('modal-article-date').textContent = date;
            const img = document.getElementById('modal-article-image');
            if(imageUrl) {
                img.src = imageUrl;
                img.style.display = 'block';
            } else {
                img.style.display = 'none';
            }
            document.getElementById('article-modal').classList.remove('hidden');
        }
    </script>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-12">
        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h4 class="text-2xl font-bold text-green-400 mb-4">ReFood</h4>
                    <p class="text-gray-400">Your gateway to amazing restaurant deals and discounts.</p>
                </div>
                <div>
                    <h5 class="text-lg font-semibold mb-4">Quick Links</h5>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">How It Works</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">For Restaurants</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-lg font-semibold mb-4">Support</h5>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Contact Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition duration-300">Privacy Policy</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-lg font-semibold mb-4">Connect With Us</h5>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition duration-300">
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} ReFood. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Autocomplete JavaScript -->
    <script>
        const searchInput = document.getElementById('searchInput');
        const autocompleteResults = document.getElementById('autocompleteResults');
        
        // All restaurants data for autocomplete
        const restaurants = {!! json_encode($restaurants->map(function($r) {
            return [
                'food_name' => is_array($r) ? $r['food_name'] : $r->food_name,
                'restaurant_name' => is_array($r) ? ($r['restaurant_name'] ?? '') : ($r->restaurant_name ?? ''),
                'food_type' => is_array($r) ? ($r['food_type'] ?? '') : ($r->food_type ?? ''),
            ];
        })->toArray()) !!};
        
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            
            if (query.length < 2) {
                autocompleteResults.classList.add('hidden');
                return;
            }
            
            const filtered = restaurants.filter(r => 
                r.food_name.toLowerCase().includes(query) ||
                r.restaurant_name.toLowerCase().includes(query) ||
                r.food_type.toLowerCase().includes(query)
            ).slice(0, 5); // Limit to 5 results
            
            if (filtered.length > 0) {
                autocompleteResults.innerHTML = filtered.map(r => `
                    <div class="px-4 py-2 hover:bg-green-50 cursor-pointer autocomplete-item" data-value="${r.food_name}">
                        <div class="font-medium text-gray-800">${r.food_name}</div>
                        <div class="text-xs text-gray-500">${r.restaurant_name} • ${r.food_type}</div>
                    </div>
                `).join('');
                autocompleteResults.classList.remove('hidden');
                
                // Add click event to autocomplete items
                document.querySelectorAll('.autocomplete-item').forEach(item => {
                    item.addEventListener('click', function() {
                        searchInput.value = this.dataset.value;
                        autocompleteResults.classList.add('hidden');
                        searchInput.form.submit();
                    });
                });
            } else {
                autocompleteResults.innerHTML = '<div class="px-4 py-2 text-gray-500 text-sm">No results found</div>';
                autocompleteResults.classList.remove('hidden');
            }
        });
        
        // Close autocomplete on click outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !autocompleteResults.contains(e.target)) {
                autocompleteResults.classList.add('hidden');
            }
        });
        
        // Close autocomplete on ESC key
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                autocompleteResults.classList.add('hidden');
            }
        });
    </script>

    <!-- Welcome Modal -->
    <div id="welcome-modal" class="hidden fixed inset-0 bg-black bg-opacity-60 z-[9999] flex items-center justify-center p-4 modal" role="dialog" aria-labelledby="welcome-title" aria-modal="true">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full p-8 transform transition-all">
            <div class="text-center mb-6">
                <div class="inline-block p-4 bg-green-100 rounded-full mb-4">
                    <svg class="w-16 h-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h2 id="welcome-title" class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang di ReFood!</h2>
                <p class="text-gray-600 text-lg">Platform Anda untuk mengurangi limbah makanan dan hemat biaya</p>
            </div>
            
            <div class="space-y-4 mb-8">
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center font-bold mr-4">1</div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Jelajahi Restoran</h3>
                        <p class="text-gray-600 text-sm">Temukan restoran dengan diskon terbatas untuk makanan lezat</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center font-bold mr-4">2</div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Klaim Diskon</h3>
                        <p class="text-gray-600 text-sm">Klik "Claim Discount" untuk mendapatkan kode promo dan tunjukkan di restoran</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-10 h-10 bg-green-600 text-white rounded-full flex items-center justify-center font-bold mr-4">3</div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Berikan Ulasan</h3>
                        <p class="text-gray-600 text-sm">Bagikan pengalaman Anda dan bantu orang lain membuat pilihan terbaik</p>
                    </div>
                </div>
            </div>
            
            <div class="flex gap-4">
                <button data-start-tour class="flex-1 bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition" aria-label="Mulai tur interaktif">
                    Ikuti Tur
                </button>
                <button data-close-welcome class="flex-1 bg-gray-200 text-gray-800 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition" aria-label="Tutup modal selamat datang">
                    Mulai Sekarang
                </button>
            </div>
        </div>
    </div>

    <!-- Accessibility Panel -->
    <div id="accessibility-panel" class="accessibility-panel" role="region" aria-label="Accessibility settings">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Pengaturan Aksesibilitas</h3>
        
        <!-- High Contrast -->
        <div class="mb-6">
            <label class="flex items-center justify-between cursor-pointer">
                <span class="font-medium text-gray-700">Mode Kontras Tinggi</span>
                <button id="contrast-toggle" class="w-14 h-8 bg-gray-300 rounded-full relative transition" aria-pressed="false" aria-label="Aktifkan mode kontras tinggi">
                    <span class="absolute left-1 top-1 w-6 h-6 bg-white rounded-full transition-transform"></span>
                </button>
            </label>
            <p class="text-sm text-gray-500 mt-1">Meningkatkan visibilitas dengan kontras warna lebih tinggi</p>
        </div>
        
        <!-- Font Size -->
        <div class="mb-6">
            <label class="font-medium text-gray-700 block mb-2">Ukuran Font</label>
            <div class="flex gap-2">
                <button data-font-size="small" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm" aria-label="Ukuran font kecil">A</button>
                <button data-font-size="medium" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 active bg-green-600 text-white" aria-label="Ukuran font sedang (default)">A</button>
                <button data-font-size="large" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-lg" aria-label="Ukuran font besar">A</button>
                <button data-font-size="xlarge" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-xl" aria-label="Ukuran font sangat besar">A</button>
            </div>
        </div>
        
        <!-- Keyboard Shortcuts -->
        <div class="mb-6">
            <h4 class="font-medium text-gray-700 mb-2">Pintasan Keyboard</h4>
            <div class="text-sm text-gray-600 space-y-1">
                <div><kbd class="px-2 py-1 bg-gray-100 rounded">Alt</kbd> + <kbd class="px-2 py-1 bg-gray-100 rounded">A</kbd> - Buka aksesibilitas</div>
                <div><kbd class="px-2 py-1 bg-gray-100 rounded">Alt</kbd> + <kbd class="px-2 py-1 bg-gray-100 rounded">H</kbd> - Bantuan/Tur</div>
                <div><kbd class="px-2 py-1 bg-gray-100 rounded">ESC</kbd> - Tutup jendela</div>
                <div><kbd class="px-2 py-1 bg-gray-100 rounded">Tab</kbd> - Navigasi elemen</div>
            </div>
        </div>
        
        <button onclick="accessibility.closeAllModals()" class="w-full bg-gray-200 text-gray-800 px-4 py-2 rounded-lg font-medium hover:bg-gray-300" aria-label="Tutup panel pengaturan">
            Tutup
        </button>
    </div>

    <!-- Accessibility Toggle Button -->
    <button class="accessibility-toggle" onclick="accessibility.toggleAccessibilityPanel()" aria-label="Buka pengaturan aksesibilitas" aria-expanded="false">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
        </svg>
        <span class="sr-only">Accessibility Settings</span>
    </button>

    <!-- Load Accessibility Script -->
    <script src="{{ asset('js/accessibility.js') }}"></script>
</body>
</html>