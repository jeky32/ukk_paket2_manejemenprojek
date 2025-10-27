<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Proyek - {{ $project->project_name ?? 'Unknown Project' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Include Chart.js for progress charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <h1 class="text-3xl font-bold text-gray-800">{{ $project->project_name ?? 'N/A' }}</h1>
                        @if($project->status ?? false)
                            <span class="px-3 py-1 text-sm font-medium rounded-full
                                @if($project->status == 'completed') bg-green-100 text-green-800
                                @elseif($project->status == 'ongoing') bg-yellow-100 text-yellow-800
                                @elseif($project->status == 'pending') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($project->status) }}
                            </span>
                        @endif
                    </div>
                    <p class="text-gray-600 text-lg">{{ $project->description ?? 'Tidak ada deskripsi' }}</p>

                    <!-- Project Meta -->
                    <div class="flex flex-wrap gap-4 mt-4 text-sm text-gray-500">
                        @if($project->deadline ?? false)
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>Deadline: {{ date('d M Y', strtotime($project->deadline)) }}</span>
                            </div>
                        @endif

                        @if($project->created_at ?? false)
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Dibuat: {{ $project->created_at->format('d M Y') }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('admin.monitoring.index') }}"
                       class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                    <a href="{{ route('admin.projects.edit', $project->project_id ?? $project->id) }}"
                       class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Proyek
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white shadow rounded-lg p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Total Tasks</h3>
                        <p class="text-3xl font-bold text-blue-600 mt-2">{{ $projectStats['total_tasks'] ?? 0 }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Completed Tasks</h3>
                        <p class="text-3xl font-bold text-green-600 mt-2">{{ $projectStats['completed_tasks'] ?? 0 }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Active Members</h3>
                        <p class="text-3xl font-bold text-purple-600 mt-2">{{ $projectStats['active_members'] ?? 0 }}</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow rounded-lg p-6 border-l-4 border-orange-500">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Progress</h3>
                        <p class="text-3xl font-bold text-orange-600 mt-2">{{ $projectStats['progress_percentage'] ?? 0 }}%</p>
                    </div>
                    <div class="bg-orange-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
                <!-- Progress Bar -->
                <div class="mt-4">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-orange-500 h-2 rounded-full" style="width: {{ $projectStats['progress_percentage'] ?? 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Team Members Section -->
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-gray-800">Team Members</h3>
                    <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                        {{ $project->members->count() ?? 0 }} Anggota
                    </span>
                </div>

                <div class="space-y-4">
                    @forelse($project->members ?? [] as $member)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition duration-200">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                    {{ substr($member->full_name ?? $member->username ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">{{ $member->full_name ?? $member->username ?? 'Unknown User' }}</p>
                                    <p class="text-sm text-gray-500">{{ $member->email ?? 'No email' }}</p>
                                    <p class="text-xs text-gray-400 capitalize">{{ $member->role ?? 'member' }}</p>
                                </div>
                            </div>
                            <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                {{ $member->status ?? 'active' }}
                            </span>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            <p class="text-gray-500">Belum ada anggota tim</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Project Leader & Info Section -->
            <div class="space-y-6">
                <!-- Project Leader -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Project Leader</h3>
                    @if($project->leader ?? false)
                        <div class="flex items-center space-x-4 p-4 bg-blue-50 rounded-lg">
                            <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-xl">
                                {{ substr($project->leader->full_name ?? $project->leader->username ?? 'L', 0, 1) }}
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800 text-lg">{{ $project->leader->full_name ?? $project->leader->username ?? 'Unknown Leader' }}</p>
                                <p class="text-gray-600">{{ $project->leader->email ?? 'No email' }}</p>
                                <p class="text-blue-600 font-medium capitalize">{{ $project->leader->role ?? 'teamlead' }}</p>
                            </div>
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                                Leader
                            </span>
                        </div>
                    @else
                        <div class="text-center py-6">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <p class="text-gray-500">Belum ada project leader</p>
                            <a href="{{ route('admin.projects.edit', $project->project_id ?? $project->id) }}" class="text-blue-600 hover:text-blue-800 text-sm mt-2 inline-block">
                                Tambah Project Leader
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Quick Actions -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <a href="{{ route('admin.projects.edit', $project->project_id ?? $project->id) }}" class="bg-blue-50 text-blue-700 p-4 rounded-lg text-center hover:bg-blue-100 transition duration-200">
                            <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span class="text-sm font-medium">Edit Project</span>
                        </a>
                        <a href="#" class="bg-green-50 text-green-700 p-4 rounded-lg text-center hover:bg-green-100 transition duration-200">
                            <svg class="w-6 h-6 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span class="text-sm font-medium">Add Member</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks Section (if available) -->
        @if(($projectStats['total_tasks'] ?? 0) > 0)
        <div class="bg-white shadow rounded-lg p-6 mt-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-semibold text-gray-800">Project Tasks</h3>
                <span class="bg-gray-100 text-gray-800 text-sm font-medium px-3 py-1 rounded-full">
                    {{ $projectStats['total_tasks'] ?? 0 }} Tasks
                </span>
            </div>

            <div class="space-y-3">
                @foreach($project->tasks ?? [] as $task)
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition duration-200">
                        <div class="flex-1">
                            <p class="font-medium text-gray-800">{{ $task->title ?? 'Untitled Task' }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ $task->description ?? 'No description' }}</p>
                        </div>
                        <span class="px-3 py-1 text-xs font-medium rounded-full
                            @if($task->status == 'completed') bg-green-100 text-green-800
                            @elseif($task->status == 'in_progress') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ $task->status ?? 'pending' }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <script>
        // Simple progress animation
        document.addEventListener('DOMContentLoaded', function() {
            const progressBars = document.querySelectorAll('.bg-orange-500');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0';
                setTimeout(() => {
                    bar.style.transition = 'width 1s ease-in-out';
                    bar.style.width = width;
                }, 300);
            });
        });
    </script>
</body>
</html>
