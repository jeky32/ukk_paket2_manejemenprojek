<!-- resources/views/components/admin-sidebar.blade.php -->
<aside class="w-64 bg-gradient-to-b from-indigo-600 via-purple-600 to-indigo-700 shadow-2xl min-h-screen flex flex-col relative overflow-hidden">
    <!-- Animated background elements -->
    <div class="absolute top-0 left-0 w-full h-full opacity-20 pointer-events-none">
        <div class="absolute top-10 -left-10 w-40 h-40 bg-blue-400 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-10 -right-10 w-40 h-40 bg-pink-400 rounded-full blur-3xl animate-float-delayed"></div>
        <div class="absolute top-1/2 left-1/2 w-32 h-32 bg-purple-300 rounded-full blur-3xl animate-float-slow"></div>
    </div>

    <!-- Animated particles -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="particle particle-1"></div>
        <div class="particle particle-2"></div>
        <div class="particle particle-3"></div>
        <div class="particle particle-4"></div>
        <div class="particle particle-5"></div>
    </div>

    <!-- Logo Section with entrance animation -->
    <div class="relative p-6 border-b border-white/20 animate-slide-down">
        <div class="flex items-center space-x-3 group">
            <div class="w-12 h-12 bg-white/20 backdrop-blur-xl rounded-xl flex items-center justify-center shadow-lg transform transition-all duration-500 group-hover:scale-110 group-hover:rotate-12 border border-white/30 animate-bounce-subtle">
                <span class="text-white font-bold text-xl animate-pulse-slow">PM</span>
            </div>
            <div class="flex-1">
                <h1 class="text-lg font-bold text-white tracking-tight drop-shadow-lg animate-fade-in">Project Manager</h1>
                <p class="text-xs text-indigo-100 font-medium animate-fade-in-delayed">Admin Panel</p>
            </div>
        </div>
    </div>

    <!-- User Info Card with pop-in animation -->
    <div class="relative p-4 mx-4 mt-4 bg-white/10 backdrop-blur-xl rounded-xl shadow-lg transform transition-all duration-500 hover:scale-105 hover:rotate-1 border border-white/20 animate-scale-in">
        <div class="flex items-center space-x-3">
            <div class="relative">
                <div class="w-12 h-12 bg-white/30 backdrop-blur-sm rounded-full flex items-center justify-center ring-2 ring-white/40 shadow-lg animate-pulse-ring">
                    <span class="text-white font-semibold text-sm">
                        {{ strtoupper(substr(Auth::user()->username, 0, 2)) }}
                    </span>
                </div>
                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 rounded-full border-2 border-purple-600 animate-ping shadow-lg"></div>
                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 rounded-full border-2 border-purple-600"></div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-white truncate drop-shadow">
                    {{ Auth::user()->full_name ?: Auth::user()->username }}
                </p>
                <p class="text-xs text-indigo-100 capitalize flex items-center">
                    <span class="w-2 h-2 bg-green-400 rounded-full mr-1.5 animate-pulse"></span>
                    {{ Auth::user()->role }}
                </p>
            </div>
        </div>
    </div>

    <!-- Navigation Menu with staggered animations -->
    <nav class="relative flex-1 p-4 overflow-y-auto scrollbar-thin scrollbar-thumb-white/20 scrollbar-track-transparent">
        <ul class="space-y-1.5">
            <!-- Dashboard -->
            <li class="group animate-slide-right" style="animation-delay: 0.1s;">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-500 relative overflow-hidden
                          {{ request()->routeIs('admin.dashboard')
                             ? 'bg-white/20 backdrop-blur-xl text-white shadow-lg border border-white/30 scale-105'
                             : 'text-white/80 hover:bg-white/10 hover:text-white hover:translate-x-2 hover:shadow-lg backdrop-blur-sm' }}">
                    <i class="fas fa-tachometer-alt text-lg w-5 text-center transition-all duration-500 group-hover:scale-125 group-hover:rotate-12"></i>
                    <span class="font-medium">Dashboard</span>
                    @if(request()->routeIs('admin.dashboard'))
                        <span class="absolute right-2 w-2 h-2 bg-white rounded-full animate-ping"></span>
                        <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent animate-shimmer"></span>
                    @endif
                </a>
            </li>

            <!-- Projects -->
            <li class="group animate-slide-right" style="animation-delay: 0.2s;">
                <a href="{{ route('admin.projects.index') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-500 relative overflow-hidden
                          {{ request()->routeIs('admin.projects.*')
                             ? 'bg-white/20 backdrop-blur-xl text-white shadow-lg border border-white/30 scale-105'
                             : 'text-white/80 hover:bg-white/10 hover:text-white hover:translate-x-2 hover:shadow-lg backdrop-blur-sm' }}">
                    <i class="fas fa-folder text-lg w-5 text-center transition-all duration-500 group-hover:scale-125 group-hover:-rotate-12"></i>
                    <span class="font-medium">Projects</span>
                    @if(request()->routeIs('admin.projects.*'))
                        <span class="absolute right-2 w-2 h-2 bg-white rounded-full animate-ping"></span>
                        <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent animate-shimmer"></span>
                    @endif
                </a>
            </li>

            <!-- Manajemen Proyek -->
            <li class="group animate-slide-right" style="animation-delay: 0.3s;">
                <a href="{{ route('admin.projects.index') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-500 relative overflow-hidden
                          text-white/80 hover:bg-white/10 hover:text-white hover:translate-x-2 hover:shadow-lg backdrop-blur-sm">
                    <i class="fas fa-project-diagram text-lg w-5 text-center transition-all duration-500 group-hover:scale-125 group-hover:rotate-180"></i>
                    <span class="font-medium">Manajemen Proyek</span>
                </a>
            </li>

            <!-- Monitoring -->
            <li class="group animate-slide-right" style="animation-delay: 0.4s;">
                <a href="{{ route('admin.monitoring.index') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-500 relative overflow-hidden
                          {{ request()->routeIs('admin.monitoring.*')
                             ? 'bg-white/20 backdrop-blur-xl text-white shadow-lg border border-white/30 scale-105'
                             : 'text-white/80 hover:bg-white/10 hover:text-white hover:translate-x-2 hover:shadow-lg backdrop-blur-sm' }}">
                    <i class="fas fa-chart-bar text-lg w-5 text-center transition-all duration-500 group-hover:scale-125 group-hover:-translate-y-1"></i>
                    <span class="font-medium">Monitoring</span>
                    @if(request()->routeIs('admin.monitoring.*'))
                        <span class="absolute right-2 w-2 h-2 bg-white rounded-full animate-ping"></span>
                        <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent animate-shimmer"></span>
                    @endif
                </a>
            </li>

            <!-- Manajemen User -->
            <li class="group animate-slide-right" style="animation-delay: 0.5s;">
                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-500 relative overflow-hidden
                          {{ request()->routeIs('admin.users.*')
                             ? 'bg-white/20 backdrop-blur-xl text-white shadow-lg border border-white/30 scale-105'
                             : 'text-white/80 hover:bg-white/10 hover:text-white hover:translate-x-2 hover:shadow-lg backdrop-blur-sm' }}">
                    <i class="fas fa-users text-lg w-5 text-center transition-all duration-500 group-hover:scale-125"></i>
                    <span class="font-medium">Manajemen User</span>
                    @if(request()->routeIs('admin.users.*'))
                        <span class="absolute right-2 w-2 h-2 bg-white rounded-full animate-ping"></span>
                        <span class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent animate-shimmer"></span>
                    @endif
                </a>
            </li>

            <!-- Reports -->
            <li class="group animate-slide-right" style="animation-delay: 0.6s;">
                <a href="#"
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-500 relative overflow-hidden
                          text-white/80 hover:bg-white/10 hover:text-white hover:translate-x-2 hover:shadow-lg backdrop-blur-sm">
                    <i class="fas fa-chart-pie text-lg w-5 text-center transition-all duration-500 group-hover:scale-125 group-hover:rotate-90"></i>
                    <span class="font-medium">Laporan</span>
                </a>
            </li>

            <!-- Separator -->
            <li class="py-3 animate-fade-in" style="animation-delay: 0.7s;">
                <div class="border-t border-white/20 animate-expand"></div>
            </li>

            <!-- Settings -->
            <li class="group animate-slide-right" style="animation-delay: 0.8s;">
                <a href="#"
                   class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-500 relative overflow-hidden
                          text-white/80 hover:bg-white/10 hover:text-white hover:translate-x-2 hover:shadow-lg backdrop-blur-sm">
                    <i class="fas fa-cog text-lg w-5 text-center transition-all duration-700 group-hover:rotate-180 group-hover:scale-125"></i>
                    <span class="font-medium">Pengaturan</span>
                </a>
            </li>

            <!-- Logout -->
            <li class="group animate-slide-right" style="animation-delay: 0.9s;">
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit"
                            class="flex items-center space-x-3 px-4 py-3 rounded-xl transition-all duration-500 w-full text-left relative overflow-hidden
                                   text-white/80 hover:bg-red-500/30 hover:text-white hover:translate-x-2 hover:shadow-lg backdrop-blur-sm border border-transparent hover:border-red-400/30">
                        <i class="fas fa-sign-out-alt text-lg w-5 text-center transition-all duration-500 group-hover:translate-x-2 group-hover:scale-125"></i>
                        <span class="font-medium">Keluar</span>
                    </button>
                </form>
            </li>
        </ul>
    </nav>

    <!-- Quick Stats - Sticky Bottom with bounce animation -->
    <div class="relative p-4 border-t border-white/20 bg-white/5 backdrop-blur-xl animate-slide-up">
        <div class="grid grid-cols-2 gap-3">
            <div class="bg-white/10 backdrop-blur-xl rounded-lg p-3 border border-white/20 transform transition-all duration-500 hover:scale-110 hover:shadow-2xl hover:bg-white/15 hover:-translate-y-2 animate-bounce-in" style="animation-delay: 1s;">
                <p class="text-2xl font-bold text-white drop-shadow-lg animate-count-up">{{ \App\Models\Project::count() }}</p>
                <p class="text-xs text-indigo-100 font-medium mt-1">Total Proyek</p>
                <div class="mt-2 flex items-center text-green-300 text-xs animate-fade-in" style="animation-delay: 1.2s;">
                    <i class="fas fa-arrow-up mr-1 animate-bounce-subtle"></i>
                    <span>Active</span>
                </div>
            </div>
            <div class="bg-white/10 backdrop-blur-xl rounded-lg p-3 border border-white/20 transform transition-all duration-500 hover:scale-110 hover:shadow-2xl hover:bg-white/15 hover:-translate-y-2 animate-bounce-in" style="animation-delay: 1.1s;">
                <p class="text-2xl font-bold text-white drop-shadow-lg animate-count-up">{{ \App\Models\User::count() }}</p>
                <p class="text-xs text-indigo-100 font-medium mt-1">Total User</p>
                <div class="mt-2 flex items-center text-green-300 text-xs animate-fade-in" style="animation-delay: 1.3s;">
                    <i class="fas fa-user-check mr-1 animate-bounce-subtle"></i>
                    <span>Online</span>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom scrollbar */
        .scrollbar-thin::-webkit-scrollbar {
            width: 4px;
        }
        .scrollbar-thin::-webkit-scrollbar-track {
            background: transparent;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
        }
        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Floating animations */
        @keyframes float {
            0%, 100% {
                transform: translate(0, 0);
            }
            33% {
                transform: translate(20px, -20px);
            }
            66% {
                transform: translate(-20px, 20px);
            }
        }

        .animate-float {
            animation: float 8s ease-in-out infinite;
        }

        .animate-float-delayed {
            animation: float 10s ease-in-out infinite;
            animation-delay: 2s;
        }

        .animate-float-slow {
            animation: float 12s ease-in-out infinite;
            animation-delay: 4s;
        }

        /* Particles */
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            animation: particle-rise 6s linear infinite;
        }

        .particle-1 { left: 10%; animation-delay: 0s; }
        .particle-2 { left: 30%; animation-delay: 1s; }
        .particle-3 { left: 50%; animation-delay: 2s; }
        .particle-4 { left: 70%; animation-delay: 3s; }
        .particle-5 { left: 90%; animation-delay: 4s; }

        @keyframes particle-rise {
            0% {
                bottom: 0;
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
            100% {
                bottom: 100%;
                opacity: 0;
            }
        }

        /* Slide animations */
        @keyframes slide-down {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-down {
            animation: slide-down 0.6s ease-out;
        }

        @keyframes slide-right {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-slide-right {
            animation: slide-right 0.6s ease-out backwards;
        }

        @keyframes slide-up {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-up {
            animation: slide-up 0.6s ease-out 1.2s backwards;
        }

        /* Scale animation */
        @keyframes scale-in {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-scale-in {
            animation: scale-in 0.5s ease-out 0.3s backwards;
        }

        /* Bounce animations */
        @keyframes bounce-in {
            0% {
                opacity: 0;
                transform: scale(0.3);
            }
            50% {
                transform: scale(1.05);
            }
            70% {
                transform: scale(0.9);
            }
            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-bounce-in {
            animation: bounce-in 0.6s ease-out backwards;
        }

        @keyframes bounce-subtle {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-3px);
            }
        }

        .animate-bounce-subtle {
            animation: bounce-subtle 2s ease-in-out infinite;
        }

        /* Fade animations */
        @keyframes fade-in {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        .animate-fade-in {
            animation: fade-in 0.8s ease-out;
        }

        .animate-fade-in-delayed {
            animation: fade-in 0.8s ease-out 0.2s backwards;
        }

        /* Pulse animations */
        @keyframes pulse-slow {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.7;
            }
        }

        .animate-pulse-slow {
            animation: pulse-slow 3s ease-in-out infinite;
        }

        @keyframes pulse-ring {
            0% {
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.4);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(255, 255, 255, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(255, 255, 255, 0);
            }
        }

        .animate-pulse-ring {
            animation: pulse-ring 2s ease-out infinite;
        }

        /* Shimmer effect */
        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }
            100% {
                transform: translateX(100%);
            }
        }

        .animate-shimmer {
            animation: shimmer 2s ease-in-out infinite;
        }

        /* Expand animation */
        @keyframes expand {
            from {
                transform: scaleX(0);
            }
            to {
                transform: scaleX(1);
            }
        }

        .animate-expand {
            animation: expand 0.8s ease-out;
        }

        /* Count up animation */
        @keyframes count-up {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-count-up {
            animation: count-up 0.8s ease-out;
        }

        /* Smooth transitions */
        * {
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</aside>
