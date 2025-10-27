<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\Board;
use App\Models\Card;
use App\Models\User;

class ProjectController extends Controller
{
    /**
     * Dashboard utama (redirect sesuai role user)
     */
    public function index()
    {
        $role = auth()->user()->role;

        switch ($role) {
            case 'admin':
                return $this->adminDashboard();
            case 'teamlead':
                return $this->teamLeadDashboard();
            case 'developer':
                return $this->developerDashboard();
            case 'designer':
                return $this->designerDashboard();
            default:
                abort(403, 'Role tidak dikenal');
        }
    }

    public function manajemen_projects()
	{
		$projects = Project::with(['boards.cards', 'members.user'])->latest()->paginate(10);
		return view('admin.projects.index', compact('projects'));
	}

    /**
     * ================= ADMIN DASHBOARD =================
     */
    public function adminDashboard()
    {
        // Ambil semua proyek beserta board dan member-nya
        $projects = Project::with(['boards.cards', 'members.user'])->get();

        // ✅ PERBAIKI: Hitung progress dengan approach yang lebih aman
        $projects->each(function ($project) {
            $totalCards = $project->boards->flatMap->cards->count();
            $doneCards = $project->boards->flatMap->cards->where('status', 'done')->count();

            // ✅ GUNAKAN computed_data array untuk hindari undefined property warning
            $project->computed_data = [
                'progress' => $totalCards > 0 ? round(($doneCards / $totalCards) * 100) : 0,
                'status' => $this->determineProjectStatus($totalCards, $doneCards),
                'total_cards' => $totalCards,
                'done_cards' => $doneCards
            ];
        });

        return view('admin.dashboard', compact('projects'));


    }

    /**
     * ================= ADMIN CRUD PROJECT =================
     */
    public function create()
    {
        $this->authorizeRole('admin');
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $this->authorizeRole('admin');

        $request->validate([
            'project_name' => 'required|string|max:255',
            'description'  => 'nullable|string',
        ]);

        try {
            // Simpan proyek baru
            $project = Project::create([
                'project_name' => $request->project_name,
                'description'  => $request->description,
                'created_by'   => auth()->id(),
                'deadline'  => $request->deadline,
            ]);

            // ✅ PERBAIKI: Masukkan Admin ke project_members
            ProjectMember::create([
                'project_id' => $project->id,
                'user_id'    => auth()->id(),
                'role'       => 'admin',
                'joined_at'  => now(),
            ]);

            // ✅ PERBAIKI: Buat board default
            // $boards = ['To Do', 'In Progress', 'Review', 'Done'];
            // foreach ($boards as $i => $board) {
            //     Board::create([
            //         'project_id' => $project->project_id,
            //         'board_name' => $board,
            //         'position'   => $i + 1,
            //     ]);
            // }

            return redirect()->route('manajemen_projects')->with('success', 'Project berhasil dibuat!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal membuat project: ' . $e->getMessage());
        }
    }

    public function show($project_id)
    {
        $this->authorizeRole('admin');

        $project = Project::with(relations: ['boards.cards', 'members.user'])->findOrFail($project_id);
        //return view('admin.projects.show', compact('project'));

        // Load relationships
        $project->load(['creator', 'members.user']);

        // Get users who are not already members of this project
        $existingMemberIds = $project->members->pluck('user_id')->toArray();
        $availableUsers = User::whereNotIn('id', $existingMemberIds)->get();

        return view('admin.projects.show', compact('project', 'availableUsers'));

    }

    public function edit($project_id)
    {
        $this->authorizeRole('admin');
        $project = Project::findOrFail($project_id);
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, $project_id)
    {
        $this->authorizeRole('admin');

        $request->validate([
            'project_name' => 'required|string|max:255',
            'description'  => 'nullable|string',
        ]);

        try {
            $project = Project::findOrFail($project_id);

            $project->update([
                'project_name' => $request->project_name,
                'description'  => $request->description,
            ]);

            return redirect()->route('manajemen_projects')->with('success', 'Project berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Gagal memperbarui project: ' . $e->getMessage());
        }
    }

    public function destroy($project_id)
    {
        $this->authorizeRole('admin');

        try {
            $project = Project::findOrFail($project_id);
            $project->delete();

            return redirect()->route('manajemen_projects')->with('success', 'Project berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Gagal menghapus project: ' . $e->getMessage());
        }
    }

    /**
     * ================= TEAM LEAD DASHBOARD =================
     */
    public function teamLeadDashboard()
    {
        $userId = auth()->id();

        $projects = Project::whereHas('members', function ($q) use ($userId) {
            $q->where('user_id', $userId)
              ->whereIn('role', ['admin', 'teamlead']);
        })->with(['boards.cards', 'members.user'])->get();

        return view('teamlead.dashboard', compact('projects'));
    }

    public function teamLeadShow($project_id)
    {
        $userId = auth()->id();

        $project = Project::whereHas('members', function ($q) use ($userId) {
            $q->where('user_id', $userId)
              ->whereIn('role', ['admin', 'teamlead']);
        })->with(['boards.cards', 'members.user'])->findOrFail($project_id);

        return view('teamlead.projects.show', compact('project'));
    }

    /**
     * ================= DEVELOPER DASHBOARD =================
     */
    public function developerDashboard()
    {
        $userId = auth()->id();

        $cards = Card::whereHas('assignments', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->with(['board.project'])->get();

        return view('developer.dashboard', compact('cards'));
    }

    /**
     * ================= DESIGNER DASHBOARD =================
     */
    public function designerDashboard()
    {
        $userId = auth()->id();

        $cards = Card::whereHas('assignments', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->with(['board.project'])->get();

        return view('designer.dashboard', compact('cards'));
    }

    /**
     * ================= HELPER FUNCTION =================
     */
    private function authorizeRole($role)
    {
        if (auth()->user()->role !== $role) {
            abort(403, 'Akses ditolak untuk role ini');
        }
    }

    /**
     * ✅ PERBAIKI: Helper method untuk menentukan status project
     */
    private function determineProjectStatus($totalCards, $doneCards)
    {
        if ($totalCards === 0) {
            return 'Not Started';
        }

        $progress = $totalCards > 0 ? round(($doneCards / $totalCards) * 100) : 0;

        if ($progress == 100) {
            return 'Completed';
        } elseif ($progress > 0) {
            return 'In Progress';
        } else {
            return 'Low Progress';
        }
    }
}
