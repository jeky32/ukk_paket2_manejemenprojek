<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Project Management')</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    @stack('styles')
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('components.admin-sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">
                            @yield('page-title', 'Dashboard Admin')
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            @yield('page-subtitle', 'Manajemen Proyek dan Tim')
                        </p>
                    </div>

                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <button class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg">
                            <i class="fas fa-bell"></i>
                            <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>

                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                    class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-100">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-semibold">
                                        {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                                    </span>
                                </div>
                                <span class="text-sm font-medium text-gray-700">
                                    {{ Auth::user()->full_name ?: Auth::user()->username }}
                                </span>
                                <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open"
                                 @click.away="open = false"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-user mr-2"></i>Profil
                                </a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-cog mr-2"></i>Pengaturan
                                </a>
                                <div class="border-t border-gray-200 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6 overflow-auto">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <span>Terjadi kesalahan:</span>
                        </div>
                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Main Content -->
                <!-- Stats Overview -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <!-- Total Projects -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Total Projects</p>
                                <h3 class="text-2xl font-bold text-gray-800">12</h3>
                            </div>
                            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-folder text-blue-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Active Tasks -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-yellow-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Active Tasks</p>
                                <h3 class="text-2xl font-bold text-gray-800">47</h3>
                            </div>
                            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-tasks text-yellow-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Team Members -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-green-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Team Members</p>
                                <h3 class="text-2xl font-bold text-gray-800">24</h3>
                            </div>
                            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-users text-green-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Completed -->
                    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-purple-500">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600 mb-1">Completed</p>
                                <h3 class="text-2xl font-bold text-gray-800">89%</h3>
                            </div>
                            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check-circle text-purple-600 text-xl"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section Header -->
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">My Projects</h2>
                        <p class="text-sm text-gray-600 mt-1">Kelola dan pantau semua proyek Anda</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <!-- Search -->
                        <div class="relative">
                            <input type="text"
                                placeholder="Cari project..."
                                class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>

                        <!-- Add Project Button -->
                        <button class="flex items-center space-x-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-plus"></i>
                            <span>New Project</span>
                        </button>
                    </div>
                </div>

                <!-- Projects Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Project Card 1 - Mobile App -->
                    <div class="project-card bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="p-6">
                            <!-- Project Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-mobile-alt text-white"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800">Mobile App</h3>
                                        <p class="text-xs text-gray-500">Development</p>
                                    </div>
                                </div>
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div x-show="open"
                                        @click.away="open = false"
                                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-10">
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-eye mr-2"></i>View Details
                                        </a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-edit mr-2"></i>Edit
                                        </a>
                                        <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                            <i class="fas fa-trash mr-2"></i>Delete
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <p class="text-sm text-gray-600 mb-4">
                                Building a modern mobile application with React Native and clean UI design.
                            </p>

                            <!-- Progress Bar -->
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-medium text-gray-600">Progress</span>
                                    <span class="text-xs font-bold text-blue-600">65%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-600 h-2 rounded-full" style="width: 65%"></div>
                                </div>
                            </div>

                            <!-- Stats -->
                            <div class="flex items-center justify-between mb-4 text-sm text-gray-600">
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-tasks"></i>
                                        <span>12/18</span>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-comment"></i>
                                        <span>45</span>
                                    </div>
                                </div>
                                <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full font-medium">Active</span>
                            </div>

                            <!-- Team Members -->
                            <div class="flex items-center justify-between">
                                <div class="flex -space-x-2">
                                    @for($i = 1; $i <= 4; $i++)
                                    <img src="https://i.pravatar.cc/150?img={{ $i }}"
                                        alt="Team member"
                                        class="w-8 h-8 rounded-full border-2 border-white">
                                    @endfor
                                    <div class="w-8 h-8 rounded-full bg-gray-200 border-2 border-white flex items-center justify-center">
                                        <span class="text-xs font-semibold text-gray-600">+3</span>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500">
                                    <i class="far fa-clock mr-1"></i>2 days left
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Project Card 2 - Website Redesign -->
                    <div class="project-card bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="p-6">
                            <!-- Project Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-600 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-desktop text-white"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800">Website Redesign</h3>
                                        <p class="text-xs text-gray-500">Design</p>
                                    </div>
                                </div>
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div x-show="open"
                                        @click.away="open = false"
                                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-10">
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-eye mr-2"></i>View Details
                                        </a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-edit mr-2"></i>Edit
                                        </a>
                                        <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                            <i class="fas fa-trash mr-2"></i>Delete
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <p class="text-sm text-gray-600 mb-4">
                                Complete redesign of company website with modern UI/UX principles.
                            </p>

                            <!-- Progress Bar -->
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-medium text-gray-600">Progress</span>
                                    <span class="text-xs font-bold text-orange-600">45%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-orange-600 h-2 rounded-full" style="width: 45%"></div>
                                </div>
                            </div>

                            <!-- Stats -->
                            <div class="flex items-center justify-between mb-4 text-sm text-gray-600">
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-tasks"></i>
                                        <span>8/20</span>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-comment"></i>
                                        <span>32</span>
                                    </div>
                                </div>
                                <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full font-medium">In Progress</span>
                            </div>

                            <!-- Team Members -->
                            <div class="flex items-center justify-between">
                                <div class="flex -space-x-2">
                                    @for($i = 5; $i <= 7; $i++)
                                    <img src="https://i.pravatar.cc/150?img={{ $i }}"
                                        alt="Team member"
                                        class="w-8 h-8 rounded-full border-2 border-white">
                                    @endfor
                                </div>
                                <span class="text-xs text-gray-500">
                                    <i class="far fa-clock mr-1"></i>5 days left
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Project Card 3 - Design System -->
                    <div class="project-card bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="p-6">
                            <!-- Project Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-palette text-white"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800">Design System</h3>
                                        <p class="text-xs text-gray-500">UI/UX</p>
                                    </div>
                                </div>
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div x-show="open"
                                        @click.away="open = false"
                                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-10">
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-eye mr-2"></i>View Details
                                        </a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-edit mr-2"></i>Edit
                                        </a>
                                        <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                            <i class="fas fa-trash mr-2"></i>Delete
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <p class="text-sm text-gray-600 mb-4">
                                Creating comprehensive design system for all digital products.
                            </p>

                            <!-- Progress Bar -->
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-medium text-gray-600">Progress</span>
                                    <span class="text-xs font-bold text-green-600">100%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: 100%"></div>
                                </div>
                            </div>

                            <!-- Stats -->
                            <div class="flex items-center justify-between mb-4 text-sm text-gray-600">
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-tasks"></i>
                                        <span>15/15</span>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-comment"></i>
                                        <span>28</span>
                                    </div>
                                </div>
                                <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full font-medium">Completed</span>
                            </div>

                            <!-- Team Members -->
                            <div class="flex items-center justify-between">
                                <div class="flex -space-x-2">
                                    @for($i = 8; $i <= 11; $i++)
                                    <img src="https://i.pravatar.cc/150?img={{ $i }}"
                                        alt="Team member"
                                        class="w-8 h-8 rounded-full border-2 border-white">
                                    @endfor
                                </div>
                                <span class="text-xs text-green-600 font-medium">
                                    <i class="fas fa-check-circle mr-1"></i>Completed
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Project Card 4 - Wireframes -->
                    <div class="project-card bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="p-6">
                            <!-- Project Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-cyan-500 to-blue-600 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-drafting-compass text-white"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800">Wireframes</h3>
                                        <p class="text-xs text-gray-500">Planning</p>
                                    </div>
                                </div>
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div x-show="open"
                                        @click.away="open = false"
                                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-10">
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-eye mr-2"></i>View Details
                                        </a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-edit mr-2"></i>Edit
                                        </a>
                                        <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                            <i class="fas fa-trash mr-2"></i>Delete
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <p class="text-sm text-gray-600 mb-4">
                                Low fidelity wireframes for new mobile app features.
                            </p>

                            <!-- Progress Bar -->
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-medium text-gray-600">Progress</span>
                                    <span class="text-xs font-bold text-cyan-600">30%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-cyan-600 h-2 rounded-full" style="width: 30%"></div>
                                </div>
                            </div>

                            <!-- Stats -->
                            <div class="flex items-center justify-between mb-4 text-sm text-gray-600">
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-tasks"></i>
                                        <span>5/16</span>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-comment"></i>
                                        <span>18</span>
                                    </div>
                                </div>
                                <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full font-medium">Planning</span>
                            </div>

                            <!-- Team Members -->
                            <div class="flex items-center justify-between">
                                <div class="flex -space-x-2">
                                    @for($i = 12; $i <= 14; $i++)
                                    <img src="https://i.pravatar.cc/150?img={{ $i }}"
                                        alt="Team member"
                                        class="w-8 h-8 rounded-full border-2 border-white">
                                    @endfor
                                    <div class="w-8 h-8 rounded-full bg-gray-200 border-2 border-white flex items-center justify-center">
                                        <span class="text-xs font-semibold text-gray-600">+2</span>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500">
                                    <i class="far fa-clock mr-1"></i>10 days left
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Project Card 5 - API Development -->
                    <div class="project-card bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="p-6">
                            <!-- Project Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-code text-white"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800">API Development</h3>
                                        <p class="text-xs text-gray-500">Backend</p>
                                    </div>
                                </div>
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div x-show="open"
                                        @click.away="open = false"
                                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-10">
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-eye mr-2"></i>View Details
                                        </a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-edit mr-2"></i>Edit
                                        </a>
                                        <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                            <i class="fas fa-trash mr-2"></i>Delete
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <p class="text-sm text-gray-600 mb-4">
                                Building RESTful API with Laravel and comprehensive documentation.
                            </p>

                            <!-- Progress Bar -->
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-medium text-gray-600">Progress</span>
                                    <span class="text-xs font-bold text-green-600">80%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: 80%"></div>
                                </div>
                            </div>

                            <!-- Stats -->
                            <div class="flex items-center justify-between mb-4 text-sm text-gray-600">
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-tasks"></i>
                                        <span>20/25</span>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-comment"></i>
                                        <span>56</span>
                                    </div>
                                </div>
                                <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full font-medium">Active</span>
                            </div>

                            <!-- Team Members -->
                            <div class="flex items-center justify-between">
                                <div class="flex -space-x-2">
                                    @for($i = 15; $i <= 17; $i++)
                                    <img src="https://i.pravatar.cc/150?img={{ $i }}"
                                        alt="Team member"
                                        class="w-8 h-8 rounded-full border-2 border-white">
                                    @endfor
                                </div>
                                <span class="text-xs text-gray-500">
                                    <i class="far fa-clock mr-1"></i>3 days left
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Project Card 6 - Marketing Campaign -->
                    <div class="project-card bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="p-6">
                            <!-- Project Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-pink-500 to-rose-600 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-bullhorn text-white"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800">Marketing Campaign</h3>
                                        <p class="text-xs text-gray-500">Marketing</p>
                                    </div>
                                </div>
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div x-show="open"
                                        @click.away="open = false"
                                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-10">
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-eye mr-2"></i>View Details
                                        </a>
                                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-edit mr-2"></i>Edit
                                        </a>
                                        <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                            <i class="fas fa-trash mr-2"></i>Delete
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Description -->
                            <p class="text-sm text-gray-600 mb-4">
                                Q4 marketing campaign planning and execution across all channels.
                            </p>

                            <!-- Progress Bar -->
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-medium text-gray-600">Progress</span>
                                    <span class="text-xs font-bold text-pink-600">55%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-pink-600 h-2 rounded-full" style="width: 55%"></div>
                                </div>
                            </div>

                            <!-- Stats -->
                            <div class="flex items-center justify-between mb-4 text-sm text-gray-600">
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-tasks"></i>
                                        <span>11/20</span>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-comment"></i>
                                        <span>41</span>
                                    </div>
                                </div>
                                <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full font-medium">In Progress</span>
                            </div>

                            <!-- Team Members -->
                            <div class="flex items-center justify-between">
                                <div class="flex -space-x-2">
                                    @for($i = 18; $i <= 21; $i++)
                                    <img src="https://i.pravatar.cc/150?img={{ $i }}"
                                        alt="Team member"
                                        class="w-8 h-8 rounded-full border-2 border-white">
                                    @endfor
                                    <div class="w-8 h-8 rounded-full bg-gray-200 border-2 border-white flex items-center justify-center">
                                        <span class="text-xs font-semibold text-gray-600">+1</span>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500">
                                    <i class="far fa-clock mr-1"></i>7 days left
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity Section -->
                <div class="mt-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Recent Activity</h2>
                    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                        <div class="divide-y divide-gray-200">
                            <!-- Activity Item 1 -->
                            <div class="p-4 hover:bg-gray-50 transition">
                                <div class="flex items-start space-x-4">
                                    <img src="https://i.pravatar.cc/150?img=22"
                                        alt="User"
                                        class="w-10 h-10 rounded-full">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm">
                                                <span class="font-semibold text-gray-800">John Doe</span>
                                                <span class="text-gray-600"> completed task </span>
                                                <span class="font-semibold text-gray-800">Mobile App Design</span>
                                            </p>
                                            <span class="text-xs text-gray-500">2 hours ago</span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">in Mobile App project</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Activity Item 2 -->
                            <div class="p-4 hover:bg-gray-50 transition">
                                <div class="flex items-start space-x-4">
                                    <img src="https://i.pravatar.cc/150?img=23"
                                        alt="User"
                                        class="w-10 h-10 rounded-full">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm">
                                                <span class="font-semibold text-gray-800">Jane Smith</span>
                                                <span class="text-gray-600"> added a comment on </span>
                                                <span class="font-semibold text-gray-800">Wireframes</span>
                                            </p>
                                            <span class="text-xs text-gray-500">5 hours ago</span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">in Wireframes project</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Activity Item 3 -->
                            <div class="p-4 hover:bg-gray-50 transition">
                                <div class="flex items-start space-x-4">
                                    <img src="https://i.pravatar.cc/150?img=24"
                                        alt="User"
                                        class="w-10 h-10 rounded-full">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm">
                                                <span class="font-semibold text-gray-800">Mike Johnson</span>
                                                <span class="text-gray-600"> created new task </span>
                                                <span class="font-semibold text-gray-800">API Documentation</span>
                                            </p>
                                            <span class="text-xs text-gray-500">1 day ago</span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">in API Development project</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Activity Item 4 -->
                            <div class="p-4 hover:bg-gray-50 transition">
                                <div class="flex items-start space-x-4">
                                    <img src="https://i.pravatar.cc/150?img=25"
                                        alt="User"
                                        class="w-10 h-10 rounded-full">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm">
                                                <span class="font-semibold text-gray-800">Sarah Wilson</span>
                                                <span class="text-gray-600"> uploaded files to </span>
                                                <span class="font-semibold text-gray-800">Design System</span>
                                            </p>
                                            <span class="text-xs text-gray-500">2 days ago</span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">in Design System project</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Activity Item 5 -->
                            <div class="p-4 hover:bg-gray-50 transition">
                                <div class="flex items-start space-x-4">
                                    <img src="https://i.pravatar.cc/150?img=26"
                                        alt="User"
                                        class="w-10 h-10 rounded-full">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm">
                                                <span class="font-semibold text-gray-800">Alex Brown</span>
                                                <span class="text-gray-600"> moved task to </span>
                                                <span class="font-semibold text-gray-800">Done</span>
                                            </p>
                                            <span class="text-xs text-gray-500">3 days ago</span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">in Website Redesign project</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- View All Activity Button -->
                        <div class="p-4 bg-gray-50 text-center">
                            <button class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                                View All Activity <i class="fas fa-arrow-right ml-1"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
