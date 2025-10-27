<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use App\Models\Card;
use App\Models\Board;
use Illuminate\Support\Carbon;

class MonitoringController extends Controller
{
    public function index()
    {
        try {
            // Load projects dengan relationships yang diperlukan
            $projects = Project::with(['members.user', 'creator', 'boards.cards'])->get();

            // ✅ SESUAIKAN DENGAN VIEW - GUNAKAN $projectStats BUKAN $statistics
            $projectStats = [
                'total' => $projects->count(),
                'with_deadline' => $projects->where('deadline', '!=', null)->count(),
                'deadline_approaching' => $projects->filter(function($project) {
                    return $project->deadline &&
                           Carbon::parse($project->deadline)->isFuture() &&
                           now()->diffInDays(Carbon::parse($project->deadline), false) <= 7;
                })->count(),
                'overdue' => $projects->filter(function($project) {
                    return $project->deadline &&
                           Carbon::parse($project->deadline)->isPast();
                })->count()
            ];

            // ✅ HITUNG USER STATISTICS UNTUK VIEW - SESUAIKAN DENGAN FIELD YANG ADA
            $totalUsers = User::whereIn('role', ['developer', 'designer', 'teamlead'])->count();
            $workingUsers = User::whereIn('role', ['developer', 'designer', 'teamlead'])
                               ->where('current_task_status', 'working')
                               ->count();
            $idleUsers = $totalUsers - $workingUsers;

            // ✅ HITUNG MEMBER DISTRIBUTION
            $memberDistribution = [];
            foreach ($projects as $project) {
                $memberDistribution[$project->project_name] = $project->members->count();
            }

            return view('admin.monitoring.index', compact(
                'projects',
                'projectStats',  // ✅ GUNAKAN projectStats
                'workingUsers',
                'idleUsers',
                'memberDistribution'
            ));

        } catch (\Exception $e) {
            // Fallback jika ada error
            $projects = Project::all();

            $projectStats = [
                'total' => $projects->count(),
                'with_deadline' => 0,
                'deadline_approaching' => 0,
                'overdue' => 0
            ];

            $workingUsers = 0;
            $idleUsers = 0;
            $memberDistribution = [];

            return view('admin.monitoring.index', compact(
                'projects',
                'projectStats',
                'workingUsers',
                'idleUsers',
                'memberDistribution'
            ));
        }
    }

    public function show(Project $project)
    {
        // ✅ INISIALISASI DEFAULT DULU
        $projectStats = [
            'total_tasks' => 0,
            'completed_tasks' => 0,
            'in_progress_tasks' => 0,
            'active_members' => 0,
            'progress_percentage' => 0
        ];

        try {
            // Load relationships yang diperlukan
            $project->load(['members.user', 'creator', 'boards.cards']);

            // Hitung total anggota aktif
            $projectStats['active_members'] = $project->members->count();

            // Hitung tasks dari boards dan cards
            $totalCards = $project->boards->flatMap->cards->count();
            $completedCards = $project->boards->flatMap->cards->where('status', 'done')->count();
            $inProgressCards = $project->boards->flatMap->cards->where('status', 'in_progress')->count();

            $projectStats['total_tasks'] = $totalCards;
            $projectStats['completed_tasks'] = $completedCards;
            $projectStats['in_progress_tasks'] = $inProgressCards;
            
            // Hitung progress percentage
            $projectStats['progress_percentage'] = $totalCards > 0 
                ? round(($completedCards / $totalCards) * 100) 
                : 0;

            // Coba load leader jika ada relationship
            if (method_exists($project, 'leader') && $project->leader_id) {
                $project->load('leader');
            }

            // Jika tidak ada boards, buat default boards untuk project ini
            if ($project->boards->count() === 0) {
                $defaultBoards = [
                    ['board_name' => 'To Do', 'position' => 1],
                    ['board_name' => 'In Progress', 'position' => 2],
                    ['board_name' => 'Review', 'position' => 3],
                    ['board_name' => 'Done', 'position' => 4],
                ];

                foreach ($defaultBoards as $boardData) {
                    Board::create([
                        'project_id' => $project->id,
                        'board_name' => $boardData['board_name'],
                        'position' => $boardData['position'],
                        'created_by' => auth()->id() ?? 1
                    ]);
                }

                // Reload project dengan boards yang baru dibuat
                $project->load('boards');
            }

        } catch (\Exception $e) {
            // Tetap lanjut dengan default values
            // Bisa log error jika perlu
            \Log::error('Error in MonitoringController show method: ' . $e->getMessage());
        }

        return view('admin.monitoring.show', compact('project', 'projectStats'));
    }
}