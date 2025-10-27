<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'project_name',
        'description',
        'created_by',
        'deadline',
        // 'leader_id',  // ✅ TAMBAHKAN INI
        // 'status'      // ✅ TAMBAHKAN INI
    ];

    // ✅ Tambahkan properti dinamis untuk hilangkan warning Intelephense
    /** @var int|null */
    public $progress;

    /** @var string|null */
    public $status;

    // ✅ Relationship dengan members
    public function members()
    {
        return $this->hasMany(ProjectMember::class, 'project_id', 'id');
    }

    // ✅ Relationship dengan boards
    public function boards()
    {
        return $this->hasMany(Board::class, 'project_id', 'project_id');
    }

    // ✅ Relationship dengan leader (user yang memimpin project)
    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id', 'id');
    }

    // ✅ Relationship dengan creator (user yang membuat project)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    // ✅ Relationship dengan tasks melalui boards (jika ada model Task)
    public function tasks()
    {
        // Jika menggunakan model Task melalui Board -> Card
        return $this->hasManyThrough(
            Card::class,        // Model akhir (tasks/cards)
            Board::class,       // Model perantara
            'project_id',       // Foreign key di boards table
            'board_id',         // Foreign key di cards table
            'project_id',       // Local key di projects table
            'board_id'          // Local key di boards table
        );
    }

    // ✅ Accessor untuk progress otomatis
    public function getProgressAttribute()
    {
        if (!$this->relationLoaded('boards')) {
            $this->load('boards.cards');
        }

        $totalCards = $this->boards->flatMap->cards->count();
        $doneCards = $this->boards->flatMap->cards->where('status', 'done')->count();

        return $totalCards > 0 ? round(($doneCards / $totalCards) * 100) : 0;
    }

    // ✅ Scope untuk project ongoing
    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing');
    }

    // ✅ Scope untuk project completed
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // ✅ Method untuk cek apakah project aktif
    public function isActive()
    {
        return $this->status === 'ongoing';
    }

    // ✅ Method untuk cek apakah project completed
    public function isCompleted()
    {
        return $this->status === 'completed';
    }
}
