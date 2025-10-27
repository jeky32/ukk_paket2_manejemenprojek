<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * ✅ Primary key default Laravel ('id')
     */
    protected $primaryKey = 'id';

    /**
     * ✅ Aktifkan timestamps (karena tabel punya created_at & updated_at)
     */
    public $timestamps = true;

    /**
     * ✅ Kolom yang bisa diisi lewat mass assignment
     */
    protected $fillable = [
        'username',
        'full_name',
        'email',
        'password',
        'role',
        'current_task_status', // ✅ TAMBAHKAN INI
    ];

    /**
     * ✅ Kolom yang disembunyikan saat model dikonversi ke array/json
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * ✅ Casting untuk tipe data
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * ✅ Nilai default untuk atribut
     */
    protected $attributes = [
        'current_task_status' => 'available', // ✅ DEFAULT VALUE
    ];

    /**
     * ✅ Enkripsi password otomatis saat disimpan
     * Pastikan tidak double hash
     */
    public function setPasswordAttribute($value)
    {
        // Jika password belum ter-hash (tidak diawali dengan $2y$)
        if (!empty($value) && !str_starts_with($value, '$2y$')) {
            $this->attributes['password'] = Hash::make($value);
        } else {
            $this->attributes['password'] = $value;
        }
    }

    /**
     * ✅ Relasi ke ProjectMember
     * 1 user → banyak project_members
     */
    public function projectMembers()
    {
        return $this->hasMany(ProjectMember::class, 'user_id', 'id');
    }

    /**
     * ✅ Relasi ke CardAssignment
     * 1 user → banyak assignments
     */
    public function assignments()
    {
        return $this->hasMany(CardAssignment::class, 'user_id', 'id');
    }

    /**
     * ✅ PROYEK YANG DIPIMPIN (sebagai leader)
     * 1 user → banyak projects (sebagai leader)
     */
    public function ledProjects()
    {
        return $this->hasMany(Project::class, 'leader_id', 'id');
    }

    /**
     * ✅ PROYEK YANG DIBUAT (sebagai creator)
     * 1 user → banyak projects (sebagai creator)
     */
    public function createdProjects()
    {
        return $this->hasMany(Project::class, 'created_by', 'id');
    }

    /**
     * ✅ PROYEK YANG DIKERJAKAN (sebagai member)
     * Banyak user → banyak projects (melalui project_members)
     */
    public function memberProjects()
    {
        return $this->belongsToMany(
            Project::class,
            'project_members',
            'user_id',
            'project_id',
            'id',
            'project_id'
        );
    }

    /**
     * ✅ TUGAS YANG SEDANG DIKERJAKAN
     */
    public function currentTask()
    {
        return $this->hasOne(CardAssignment::class, 'user_id')
            ->where('assignment_status', 'in_progress')
            ->latest();
    }

    /**
     * ✅ Getter tambahan
     * Menampilkan full_name jika ada, kalau tidak tampilkan username
     */
    public function getDisplayNameAttribute()
    {
        return $this->full_name ?: $this->username;
    }

    /**
     * ✅ Getter untuk status warna (digunakan di view)
     */
    public function getStatusColorAttribute()
    {
        return match($this->current_task_status) {
            'working' => 'yellow',
            'available' => 'green',
            'blocked' => 'red',
            'offline' => 'gray',
            default => 'gray'
        };
    }

    /**
     * ✅ Getter untuk badge color berdasarkan role
     */
    public function getRoleBadgeColorAttribute()
    {
        return match($this->role) {
            'admin' => 'purple',
            'teamlead' => 'blue',
            'developer' => 'green',
            'designer' => 'pink',
            'member' => 'gray',
            default => 'gray'
        };
    }

    /**
     * ✅ Cek apakah user memiliki role tertentu
     * Contoh: $user->hasRole('admin')
     */
    public function hasRole($role)
    {
        return $this->role === strtolower($role);
    }

    /**
     * ✅ Cek apakah user adalah admin
     */
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    /**
     * ✅ Cek apakah user adalah teamlead
     */
    public function isTeamLead()
    {
        return $this->hasRole('teamlead');
    }

    /**
     * ✅ Cek apakah user adalah developer
     */
    public function isDeveloper()
    {
        return $this->hasRole('developer');
    }

    /**
     * ✅ Cek apakah user adalah designer
     */
    public function isDesigner()
    {
        return $this->hasRole('designer');
    }

    /**
     * ✅ Cek apakah user adalah member biasa
     */
    public function isMember()
    {
        return $this->hasRole('member');
    }

    /**
     * ✅ Cek apakah user bisa assign tugas (admin/teamlead)
     */
    public function canAssignTasks()
    {
        return in_array($this->role, ['admin', 'teamlead']);
    }

    /**
     * ✅ Cek apakah user sedang available untuk tugas baru
     */
    public function isAvailable()
    {
        return $this->current_task_status === 'available';
    }

    /**
     * ✅ Cek apakah user sedang bekerja
     */
    public function isWorking()
    {
        return $this->current_task_status === 'working';
    }

    /**
     * ✅ Update status tugas user
     */
    public function updateTaskStatus($status)
    {
        $allowedStatuses = ['available', 'working', 'blocked', 'offline'];
        
        if (in_array($status, $allowedStatuses)) {
            $this->update(['current_task_status' => $status]);
            return true;
        }
        
        return false;
    }

    /**
     * ✅ Scope untuk filter by role
     */
    public function scopeByRole($query, $role)
    {
        return $query->where('role', $role);
    }

    /**
     * ✅ Scope untuk admin users
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * ✅ Scope untuk teamlead users
     */
    public function scopeTeamLeads($query)
    {
        return $query->where('role', 'teamlead');
    }

    /**
     * ✅ Scope untuk developer users
     */
    public function scopeDevelopers($query)
    {
        return $query->where('role', 'developer');
    }

    /**
     * ✅ Scope untuk designer users
     */
    public function scopeDesigners($query)
    {
        return $query->where('role', 'designer');
    }

    /**
     * ✅ Scope untuk available users
     */
    public function scopeAvailable($query)
    {
        return $query->where('current_task_status', 'available');
    }

    /**
     * ✅ Scope untuk working users
     */
    public function scopeWorking($query)
    {
        return $query->where('current_task_status', 'working');
    }

    /**
     * ✅ Boot method untuk event listener
     */
    protected static function boot()
    {
        parent::boot();

        // Set default status saat user dibuat
        static::creating(function ($user) {
            if (empty($user->current_task_status)) {
                $user->current_task_status = 'available';
            }
        });
    }
}