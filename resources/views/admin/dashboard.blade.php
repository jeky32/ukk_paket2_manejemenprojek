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

    <style>
        /* Gradient animations */
        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient-shift 15s ease infinite;
        }

        /* Fade in animations */
        @keyframes fade-in-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-in-down {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fade-in-left {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes scale-in {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fade-in-up {
            animation: fade-in-up 0.6s ease-out backwards;
        }

        .animate-fade-in-down {
            animation: fade-in-down 0.6s ease-out backwards;
        }

        .animate-fade-in-left {
            animation: fade-in-left 0.6s ease-out backwards;
        }

        .animate-scale-in {
            animation: scale-in 0.5s ease-out backwards;
        }

        /* Floating animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        /* Pulse glow */
        @keyframes pulse-glow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(59, 130, 246, 0.5);
            }
            50% {
                box-shadow: 0 0 30px rgba(59, 130, 246, 0.8);
            }
        }

        .animate-pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }

        /* Shimmer effect */
        @keyframes shimmer {
            0% { background-position: -1000px 0; }
            100% { background-position: 1000px 0; }
        }

        .shimmer {
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            background-size: 1000px 100%;
            animation: shimmer 2s infinite;
        }

        /* Card hover lift */
        .card-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-lift:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        /* Progress bar animation */
        @keyframes progress-load {
            0% { width: 0%; }
        }

        .progress-bar {
            animation: progress-load 1.5s ease-out;
        }

        /* Bounce subtle */
        @keyframes bounce-subtle {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }

        .animate-bounce-subtle {
            animation: bounce-subtle 2s ease-in-out infinite;
        }

        /* Rotate slow */
        @keyframes rotate-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .animate-rotate-slow {
            animation: rotate-slow 20s linear infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 animate-gradient">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('components.admin-sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Top Header -->
            <header class="bg-white/80 backdrop-blur-xl shadow-lg border-b border-indigo-100 sticky top-0 z-40 animate-fade-in-down">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="animate-fade-in-left">
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                            @yield('page-title', 'Dashboard Admin')
                        </h1>
                        <p class="text-sm text-gray-600 mt-1">
                            @yield('page-subtitle', 'Manajemen Proyek dan Tim')
                        </p>
                    </div>

                    <div class="flex items-center space-x-4 animate-fade-in-left" style="animation-delay: 0.2s;">
                        <!-- Notifications -->
                        <button class="relative p-3 text-gray-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all duration-300 group">
                            <i class="fas fa-bell text-lg group-hover:scale-110 transition-transform duration-300"></i>
                            <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-red-500 rounded-full animate-ping"></span>
                            <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-red-500 rounded-full"></span>
                        </button>

                        <!-- User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                    class="flex items-center space-x-3 p-2 pr-4 rounded-xl hover:bg-indigo-50 transition-all duration-300 group">
                                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <span class="text-white text-sm font-semibold">
                                        {{ strtoupper(substr(Auth::user()->username, 0, 1)) }}
                                    </span>
                                </div>
                                <span class="text-sm font-medium text-gray-700 group-hover:text-indigo-600 transition-colors">
                                    {{ Auth::user()->full_name ?: Auth::user()->username }}
                                </span>
                                <i class="fas fa-chevron-down text-xs text-gray-500 group-hover:rotate-180 transition-transform duration-300"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 @click.away="open = false"
                                 class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-2xl border border-indigo-100 py-2 z-50 overflow-hidden">
                                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-purple-600"></div>
                                <a href="#" class="block px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50 transition-colors">
                                    <i class="fas fa-user mr-3 text-indigo-600"></i>Profil
                                </a>
                                <a href="#" class="block px-4 py-3 text-sm text-gray-700 hover:bg-indigo-50 transition-colors">
                                    <i class="fas fa-cog mr-3 text-indigo-600"></i>Pengaturan
                                </a>
                                <div class="border-t border-gray-200 my-2"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="block w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                        <i class="fas fa-sign-out-alt mr-3"></i>Keluar
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
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-6 py-4 rounded-xl mb-6 shadow-lg animate-fade-in-up backdrop-blur-sm">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-3 text-xl"></i>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-6 py-4 rounded-xl mb-6 shadow-lg animate-fade-in-up backdrop-blur-sm">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-3 text-xl"></i>
                            <span class="font-medium">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Stats Overview -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <!-- Total Projects -->
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-xl p-6 text-white card-lift animate-scale-in overflow-hidden relative">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 animate-pulse"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <p class="text-blue-100 text-sm mb-1 font-medium">Total Projects</p>
                                    <h3 class="text-4xl font-bold">{{ $projects->count() }}</h3>
                                </div>
                                <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center animate-float">
                                    <i class="fas fa-folder text-2xl"></i>
                                </div>
                            </div>
                            <div class="flex items-center text-blue-100 text-sm">
                                <i class="fas fa-arrow-up mr-2"></i>
                                <span>12% from last month</span>
                            </div>
                        </div>
                    </div>

                    <!-- Active Tasks -->
                    <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl shadow-xl p-6 text-white card-lift animate-scale-in overflow-hidden relative" style="animation-delay: 0.1s;">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 animate-pulse" style="animation-delay: 0.5s;"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <p class="text-orange-100 text-sm mb-1 font-medium">Active Tasks</p>
                                    <h3 class="text-4xl font-bold">
                                        {{ $projects->sum(function($project) {
                                            return $project->boards->sum(function($board) {
                                                return $board->cards->whereIn('status', ['todo', 'in_progress', 'review'])->count();
                                            });
                                        }) }}
                                    </h3>
                                </div>
                                <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center animate-float" style="animation-delay: 0.5s;">
                                    <i class="fas fa-tasks text-2xl"></i>
                                </div>
                            </div>
                            <div class="flex items-center text-orange-100 text-sm">
                                <i class="fas fa-fire mr-2 animate-bounce-subtle"></i>
                                <span>8 tasks due today</span>
                            </div>
                        </div>
                    </div>

                    <!-- Team Members -->
                    <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl shadow-xl p-6 text-white card-lift animate-scale-in overflow-hidden relative" style="animation-delay: 0.2s;">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 animate-pulse" style="animation-delay: 1s;"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <p class="text-emerald-100 text-sm mb-1 font-medium">Team Members</p>
                                    <h3 class="text-4xl font-bold">
                                        {{ $projects->pluck('members')->flatten()->unique('id')->count() }}
                                    </h3>
                                </div>
                                <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center animate-float" style="animation-delay: 1s;">
                                    <i class="fas fa-users text-2xl"></i>
                                </div>
                            </div>
                            <div class="flex items-center text-emerald-100 text-sm">
                                <i class="fas fa-user-check mr-2"></i>
                                <span>5 online now</span>
                            </div>
                        </div>
                    </div>

                    <!-- Completed -->
                    <div class="bg-gradient-to-br from-purple-500 to-pink-600 rounded-2xl shadow-xl p-6 text-white card-lift animate-scale-in overflow-hidden relative" style="animation-delay: 0.3s;">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 animate-pulse" style="animation-delay: 1.5s;"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <p class="text-purple-100 text-sm mb-1 font-medium">Completed</p>
                                    @php
                                        $allTasks = $projects->sum(function($project) {
                                            return $project->boards->sum(function($board) {
                                                return $board->cards->count();
                                            });
                                        });
                                        $completedTasksCount = $projects->sum(function($project) {
                                            return $project->boards->sum(function($board) {
                                                return $board->cards->where('status', 'done')->count();
                                            });
                                        });
                                        $rate = $allTasks > 0 ? round(($completedTasksCount / $allTasks) * 100) : 0;
                                    @endphp
                                    <h3 class="text-4xl font-bold">{{ $rate }}%</h3>
                                </div>
                                <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center animate-float" style="animation-delay: 1.5s;">
                                    <i class="fas fa-check-circle text-2xl"></i>
                                </div>
                            </div>
                            <div class="flex items-center text-purple-100 text-sm">
                                <i class="fas fa-chart-line mr-2"></i>
                                <span>Great progress!</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section Header -->
                <div class="flex items-center justify-between mb-6 animate-fade-in-up" style="animation-delay: 0.4s;">
                    <div>
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">My Projects</h1>
                    </div>
                    <div class="flex items-center space-x-3">
                        <!-- Search -->
                        <div class="relative">
                            <input type="text"
                                placeholder="Cari project..."
                                class="pl-11 pr-4 py-3 border-2 border-indigo-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 bg-white/80 backdrop-blur-sm">
                            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-indigo-400"></i>
                        </div>

                        <!-- Add Project Button -->
                        <button class="flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-105 group">
                            <i class="fas fa-plus group-hover:rotate-90 transition-transform duration-300"></i>
                            <span class="font-medium">New Project</span>
                        </button>
                    </div>
                </div>

                <!-- Projects Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Project Card 1 -->
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg overflow-hidden card-lift border border-indigo-100 animate-fade-in-up" style="animation-delay: 0.5s;">
                        <div class="h-2 bg-gradient-to-r from-blue-500 to-purple-600"></div>
                        <div class="p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <i class="fas fa-mobile-alt text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800">Mobile App</h3>
                                        <p class="text-xs text-gray-500">Development</p>
                                    </div>
                                </div>
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="text-gray-400 hover:text-indigo-600 p-2 hover:bg-indigo-50 rounded-lg transition-all duration-300">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                </div>
                            </div>

                            <p class="text-sm text-gray-600 mb-4">
                                Building a modern mobile application with React Native and clean UI design.
                            </p>

                            <!-- Progress Bar -->
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-xs font-medium text-gray-600">Progress</span>
                                    <span class="text-xs font-bold text-blue-600">65%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5 overflow-hidden">
                                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-2.5 rounded-full progress-bar" style="width: 65%"></div>
                                </div>
                            </div>

                            <!-- Stats -->
                            <div class="flex items-center justify-between mb-4 text-sm text-gray-600">
                                <div class="flex items-center space-x-4">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-tasks text-indigo-600"></i>
                                        <span class="font-medium">12/18</span>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-comment text-indigo-600"></i>
                                        <span class="font-medium">45</span>
                                    </div>
                                </div>
                                <span class="text-xs bg-green-100 text-green-700 px-3 py-1.5 rounded-full font-medium">Active</span>
                            </div>

                            <!-- Team Members -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                                <div class="flex -space-x-2">
                                    @for($i = 1; $i <= 4; $i++)
                                    <img src="https://i.pravatar.cc/150?img={{ $i }}"
                                        alt="Team member"
                                        class="w-9 h-9 rounded-full border-2 border-white shadow-md hover:scale-110 transition-transform duration-300">
                                    @endfor
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 border-2 border-white flex items-center justify-center shadow-md">
                                        <span class="text-xs font-semibold text-white">+3</span>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500 font-medium flex items-center">
                                    <i class="far fa-clock mr-1 text-indigo-600"></i>2 days left
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Tambahkan project cards lainnya dengan pattern yang sama tapi delay berbeda -->
                    <!-- Project Card 2 - 6 mengikuti struktur yang sama -->
                </div>

                <!-- Recent Activity Section -->
                <div class="mt-8 animate-fade-in-up" style="animation-delay: 0.8s;">
                    <h2 class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent mb-4">Recent Activity</h2>
                    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg overflow-hidden border border-indigo-100">
                        <div class="divide-y divide-gray-200">
                            @for($i = 22; $i <= 26; $i++)
                            <div class="p-4 hover:bg-indigo-50 transition-all duration-300 group">
                                <div class="flex items-start space-x-4">
                                    <img src="https://i.pravatar.cc/150?img={{ $i }}"
                                        alt="User"
                                        class="w-11 h-11 rounded-full border-2 border-indigo-200 shadow-md group-hover:scale-110 transition-transform duration-300">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm">
                                                <span class="font-semibold text-gray-800">User {{ $i }}</span>
                                                <span class="text-gray-600"> completed task </span>
                                                <span class="font-semibold text-indigo-600">Task Name</span>
                                            </p>
                                            <span class="text-xs text-gray-500 font-medium">2 hours ago</span>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">in Project Name</p>
                                    </div>
                                </div>
                            </div>
                            @endfor
                        </div>

                        <div class="p-4 bg-gradient-to-r from-indigo-50 to-purple-50 text-center">
                            <button class="text-sm text-indigo-600 hover:text-indigo-700 font-semibold transition-colors group">
                                View All Activity
                                <i class="fas fa-arrow-right ml-2 group-hover:translate-x-2 transition-transform duration-300"></i>
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
