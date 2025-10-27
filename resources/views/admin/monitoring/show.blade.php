@extends('layouts.admin')

@section('title', 'Project Details - ' . $project->project_name)

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-purple-50 to-indigo-50">
    <!-- Back Button & Header -->
    <div class="mb-6 animate-fade-in-down">
        <a href="{{ route('admin.monitoring.index') }}"
           class="inline-flex items-center space-x-2 px-4 py-2 bg-white/80 backdrop-blur-xl text-gray-700 rounded-xl hover:shadow-lg transform hover:scale-105 transition-all duration-300 border border-indigo-100 mb-4">
            <i class="fas fa-arrow-left"></i>
            <span class="font-medium">Back to Monitoring</span>
        </a>

        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent animate-gradient">
                    {{ $project->project_name }}
                </h1>
                <p class="text-gray-600 mt-2">{{ $project->description ?? 'Tidak ada deskripsi' }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <button class="px-5 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 flex items-center space-x-2">
                    <i class="fas fa-edit"></i>
                    <span>Edit Project</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Project Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total Tasks -->
        <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl p-6 border border-blue-100 transform hover:scale-105 transition-all duration-300 animate-scale-in relative overflow-hidden group">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-400/20 to-indigo-600/20 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg animate-float">
                        <i class="fas fa-tasks text-white text-2xl"></i>
                    </div>
                </div>
                <h3 class="text-sm font-semibold text-gray-600 mb-1">Total Tasks</h3>
                <p class="text-4xl font-bold bg-gradient-to-br from-blue-600 to-indigo-700 bg-clip-text text-transparent">
                    {{ $projectStats['total_tasks'] ?? 0 }}
                </p>
            </div>
        </div>

        <!-- Completed Tasks -->
        <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl p-6 border border-green-100 transform hover:scale-105 transition-all duration-300 animate-scale-in relative overflow-hidden group" style="animation-delay: 0.1s;">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-green-400/20 to-emerald-600/20 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg animate-float" style="animation-delay: 0.5s;">
                        <i class="fas fa-check-circle text-white text-2xl"></i>
                    </div>
                </div>
                <h3 class="text-sm font-semibold text-gray-600 mb-1">Completed</h3>
                <p class="text-4xl font-bold bg-gradient-to-br from-green-600 to-emerald-700 bg-clip-text text-transparent">
                    {{ $projectStats['completed_tasks'] ?? 0 }}
                </p>
            </div>
        </div>

        <!-- Active Members -->
        <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl p-6 border border-purple-100 transform hover:scale-105 transition-all duration-300 animate-scale-in relative overflow-hidden group" style="animation-delay: 0.2s;">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-400/20 to-pink-600/20 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center shadow-lg animate-float" style="animation-delay: 1s;">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                </div>
                <h3 class="text-sm font-semibold text-gray-600 mb-1">Active Members</h3>
                <p class="text-4xl font-bold bg-gradient-to-br from-purple-600 to-pink-700 bg-clip-text text-transparent">
                    {{ $projectStats['active_members'] ?? 0 }}
                </p>
            </div>
        </div>

        <!-- Progress -->
        <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl p-6 border border-amber-100 transform hover:scale-105 transition-all duration-300 animate-scale-in relative overflow-hidden group" style="animation-delay: 0.3s;">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-amber-400/20 to-orange-600/20 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg animate-float" style="animation-delay: 1.5s;">
                        <i class="fas fa-chart-line text-white text-2xl"></i>
                    </div>
                </div>
                <h3 class="text-sm font-semibold text-gray-600 mb-1">Progress</h3>
                <p class="text-4xl font-bold bg-gradient-to-br from-amber-600 to-orange-700 bg-clip-text text-transparent">
                    {{ $projectStats['progress_percentage'] ?? 0 }}%
                </p>
            </div>
        </div>
    </div>

    <!-- Team Members & Project Leader Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Team Members List -->
        <div class="lg:col-span-2 bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-indigo-100 overflow-hidden animate-fade-in-left">
            <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-users mr-3"></i>
                    Team Members
                </h2>
            </div>

            <div class="p-6">
                @if($project->members->count() > 0)
                    <div class="space-y-4">
                        @foreach($project->members as $member)
                            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl border border-indigo-100 hover:shadow-lg transform hover:scale-105 transition-all duration-300 group">
                                <div class="flex items-center space-x-4">
                                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                        <span class="text-white text-lg font-bold">
                                            {{ strtoupper(substr($member->full_name ?? $member->username ?? 'U', 0, 2)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800">{{ $member->full_name ?? $member->username ?? 'Unknown User' }}</h3>
                                        <p class="text-sm text-gray-600">{{ $member->email ?? 'No email' }}</p>
                                    </div>
                                </div>
                                <span class="px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-lg text-xs font-semibold shadow-md">
                                    {{ ucfirst($member->role ?? 'member') }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-12">
                        <div class="w-24 h-24 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-users text-gray-400 text-3xl"></i>
                        </div>
                        <p class="text-gray-500 font-medium">Belum ada anggota tim</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Project Leader Card -->
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-purple-100 overflow-hidden animate-fade-in-right">
                <div class="bg-gradient-to-r from-purple-600 via-pink-600 to-rose-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white flex items-center">
                        <i class="fas fa-crown mr-3"></i>
                        Project Leader
                    </h2>
                </div>

                <div class="p-6">
                    @if($project->leader)
                        <div class="text-center">
                            <div class="w-24 h-24 bg-gradient-to-br from-purple-500 to-pink-600 rounded-full flex items-center justify-center shadow-2xl mx-auto mb-4 animate-pulse-glow">
                                <span class="text-white text-3xl font-bold">
                                    {{ strtoupper(substr($project->leader->full_name ?? $project->leader->username ?? 'L', 0, 2)) }}
                                </span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-1">
                                {{ $project->leader->full_name ?? $project->leader->username ?? 'Unknown Leader' }}
                            </h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $project->leader->email ?? 'No email' }}</p>
                            <span class="inline-block px-4 py-2 bg-gradient-to-r from-purple-100 to-pink-100 text-purple-700 rounded-full text-xs font-semibold border border-purple-200">
                                {{ ucfirst($project->leader->role ?? 'teamlead') }}
                            </span>
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center py-8">
                            <div class="w-20 h-20 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-user-tie text-gray-400 text-2xl"></i>
                            </div>
                            <p class="text-gray-500 font-medium mb-4">Belum ada project leader</p>
                            <button class="px-5 py-2 bg-gradient-to-r from-purple-500 to-pink-600 text-white rounded-xl hover:shadow-xl transform hover:scale-105 transition-all duration-300 text-sm font-medium">
                                <i class="fas fa-plus mr-2"></i>
                                Tambah Project Leader
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Tasks Section -->
    <div class="bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-indigo-100 overflow-hidden animate-fade-in-up" style="animation-delay: 0.4s;">
        <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-clipboard-list mr-3"></i>
                    Project Tasks
                </h2>
                <button class="px-4 py-2 bg-white/20 backdrop-blur-xl text-white rounded-lg hover:bg-white/30 transition-all duration-300 text-sm font-medium">
                    <i class="fas fa-plus mr-2"></i>
                    Add Task
                </button>
            </div>
        </div>

        <div class="p-6">
            @if(isset($tasks) && $tasks->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($tasks as $task)
                        <div class="bg-gradient-to-br from-white to-indigo-50 rounded-xl p-5 border-2 border-indigo-100 hover:border-indigo-300 hover:shadow-2xl transform hover:scale-105 transition-all duration-300 group">
                            <div class="flex items-start justify-between mb-3">
                                <h3 class="font-bold text-gray-800 group-hover:text-indigo-600 transition-colors flex-1">
                                    {{ $task->title ?? 'Untitled Task' }}
                                </h3>
                                <span class="px-3 py-1 bg-gradient-to-r from-green-100 to-emerald-100 text-green-700 rounded-full text-xs font-semibold border border-green-200">
                                    Active
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mb-4 line-clamp-2">
                                {{ $task->description ?? 'No description' }}
                            </p>
                            <div class="flex items-center justify-between">
                                <div class="flex -space-x-2">
                                    @if(isset($task->assignees))
                                        @foreach($task->assignees->take(3) as $assignee)
                                            <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full border-2 border-white flex items-center justify-center shadow-md">
                                                <span class="text-white text-xs font-semibold">
                                                    {{ strtoupper(substr($assignee->full_name ?? 'U', 0, 1)) }}
                                                </span>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <button class="text-indigo-600 hover:text-indigo-700 font-medium text-sm">
                                    View Details →
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-16">
                    <div class="w-32 h-32 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-clipboard-list text-gray-400 text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-700 mb-2">No Tasks Yet</h3>
                    <p class="text-gray-500 mb-6">Start by creating your first task</p>
                    <button class="px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl hover:shadow-2xl transform hover:scale-105 transition-all duration-300 font-medium">
                        <i class="fas fa-plus mr-2"></i>
                        Create First Task
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    @keyframes gradient-shift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }

    .animate-gradient {
        background-size: 200% 200%;
        animation: gradient-shift 3s ease infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .animate-float {
        animation: float 3s ease-in-out infinite;
    }

    @keyframes pulse-glow {
        0%, 100% {
            box-shadow: 0 0 20px rgba(168, 85, 247, 0.5);
        }
        50% {
            box-shadow: 0 0 30px rgba(168, 85, 247, 0.8);
        }
    }

    .animate-pulse-glow {
        animation: pulse-glow 2s ease-in-out infinite;
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

    .animate-fade-in-down {
        animation: fade-in-down 0.6s ease-out;
    }

    @keyframes fade-in-left {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-fade-in-left {
        animation: fade-in-left 0.6s ease-out;
    }

    @keyframes fade-in-right {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-fade-in-right {
        animation: fade-in-right 0.6s ease-out;
    }

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

    .animate-fade-in-up {
        animation: fade-in-up 0.6s ease-out backwards;
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

    .animate-scale-in {
        animation: scale-in 0.5s ease-out backwards;
    }
</style>
@endsection
