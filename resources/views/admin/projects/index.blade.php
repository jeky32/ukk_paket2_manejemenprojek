<!-- resources/views/admin/projects/index.blade.php -->
@extends('layouts.admin')

@section('title', 'Projects - Admin Dashboard')

@section('page-title', 'Projects')
@section('page-subtitle', 'Kelola semua proyek Anda')

@section('content')
    <div class="px-4 py-6 sm:px-0">
        <!-- Header with Action Button -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">All Projects</h2>
                <p class="text-sm text-gray-600 mt-1">Manage and monitor your projects</p>
            </div>
            <a href="{{ route('admin.projects.create') }}"
               class="flex items-center space-x-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-sm">
                <i class="fas fa-plus"></i>
                <span>Create New Project</span>
            </a>
        </div>

        <!-- Projects Table -->
        <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Project Name
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Created By
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Deadline
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($projects as $project)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-folder text-white"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $project->project_name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ Str::limit($project->description, 50) }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                    <span class="text-white text-xs font-semibold">
                                        {{ strtoupper(substr($project->creator->full_name, 0, 1)) }}
                                    </span>
                                </div>
                                <span class="text-sm text-gray-700">
                                    {{ $project->creator->full_name }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'active' => 'bg-green-100 text-green-700',
                                    'planning' => 'bg-blue-100 text-blue-700',
                                    'completed' => 'bg-purple-100 text-purple-700',
                                    'on_hold' => 'bg-yellow-100 text-yellow-700',
                                ];
                                $status = $project->status ?? 'active';
                            @endphp
                            <span class="px-3 py-1 text-xs font-medium rounded-full {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst(str_replace('_', ' ', $status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($project->deadline)
                                <div class="flex items-center space-x-1">
                                    <i class="far fa-clock text-gray-400"></i>
                                    <span>{{ date('M d, Y', strtotime($project->deadline)) }}</span>
                                </div>
                            @else
                                <span class="text-gray-400">No deadline</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('admin.projects.show', $project->id) }}"
                                   class="text-blue-600 hover:text-blue-900 transition"
                                   title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.projects.edit', $project->id) }}"
                                   class="text-indigo-600 hover:text-indigo-900 transition"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.projects.destroy', $project->id) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Are you sure you want to delete this project?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-900 transition"
                                            title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-folder-open text-gray-300 text-5xl mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No projects found</h3>
                                <p class="text-sm text-gray-500 mb-4">Get started by creating a new project</p>
                                <a href="{{ route('admin.projects.create') }}"
                                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                    Create Your First Project
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination (if needed) -->
        @if($projects->hasPages())
        <div class="mt-6">
            {{ $projects->links() }}
        </div>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    // Optional: Add any page-specific JavaScript here
    console.log('Projects page loaded');
</script>
@endpush
