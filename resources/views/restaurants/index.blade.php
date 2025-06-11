<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReFood - All Discounts is Here!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
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

    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-green-600 to-green-800 text-white pt-24 pb-16 px-4">
        <div class="container mx-auto text-center">
            <h2 class="text-4xl font-bold mb-4">Find Your Next Meal Deal</h2>
            <p class="text-xl text-green-100">Discover restaurants offering amazing discounts near you</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 -mt-10">
        @if(session('success'))
            <div id="success-alert" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6 mx-4" role="alert">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                
                <!-- Loading bar -->
                <div class="mt-2 h-1 w-full bg-green-200 rounded-full overflow-hidden">
                    <div id="success-progress" class="h-1 bg-green-600 rounded-full w-0"></div>
                </div>
            </div>

            <!-- Script untuk loading dan menghilangkan pesan -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const progressBar = document.getElementById('success-progress');
                    const alert = document.getElementById('success-alert');
                    const duration = 5000; // 5 detik
                    const interval = 20;
                    let width = 0;
                    let timePassed = 0;
                    
                    // Fungsi untuk menggerakan progress bar dan menghilangkan pesan
                    const timer = setInterval(function() {
                        timePassed += interval;
                        width = (timePassed / duration) * 100;
                        progressBar.style.width = width + '%';
                        
                        if (width >= 100) {
                            clearInterval(timer);
                            alert.style.opacity = '0';
                            alert.style.transition = 'opacity 0.5s ease-out';
                            setTimeout(function() {
                                alert.style.display = 'none';
                            }, 500);
                        }
                    }, interval);
                });
            </script>
        @endif

        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-8">
            <div class="flex flex-wrap gap-4 justify-between items-center">
                <div class="flex space-x-4">
                    <select class="border border-gray-300 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">All Cuisines</option>
                        <option value="indonesian">Indonesian</option>
                        <option value="western">Western</option>
                        <option value="asian">Asian</option>
                    </select>
                    <select class="border border-gray-300 rounded-lg px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="">All Discounts</option>
                        <option value="10">10% and above</option>
                        <option value="20">20% and above</option>
                        <option value="30">30% and above</option>
                    </select>
                </div>
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
            $categoryList = [
                [
                    'key' => 'indonesian',
                    'label' => 'Indonesian',
                    'icon' => '<span class="text-2xl mr-3">🍚</span>',
                ],
                [
                    'key' => 'western',
                    'label' => 'Western',
                    'icon' => '<span class="text-2xl mr-3">🍔</span>',
                ],
                [
                    'key' => 'asian',
                    'label' => 'Asian',
                    'icon' => '<span class="text-2xl mr-3">🍣</span>',
                ],
            ];
            $selectedCategory = strtolower(request('category', ''));
        @endphp

        <div class="container mx-auto px-4 mb-8">
            <div class="flex overflow-x-auto space-x-4 hide-scrollbar py-2">
                @foreach($categoryList as $cat)
                    <a href="?category={{ $cat['key'] }}"
                       class="flex items-center px-6 py-3 rounded-full shadow-md bg-white border transition
                           {{ $selectedCategory === $cat['key'] ? 'border-green-600 bg-green-50 text-green-700 font-semibold' : 'border-gray-200 text-gray-700 hover:bg-green-50' }}">
                        {!! $cat['icon'] !!}
                        <span class="whitespace-nowrap">{{ $cat['label'] }}</span>
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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                @foreach($restaurants as $restaurant)
                    <a href="{{ route('frontend.restaurants.show', $restaurant->id) }}" class="block bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300 group">
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
</body>
</html>