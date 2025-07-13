<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\BugReport;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Relasi user sebagai pelapor bug (bug tester)
     */
    public function bugReports()
    {
        return $this->hasMany(BugReport::class, 'reporter_id');
    }

    /**
     * Relasi user sebagai developer yang ditugaskan bug (opsional)
     */
    public function assignedBugReports()
    {
        return $this->hasMany(BugReport::class, 'developer_id');
    }

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // menambah kolom role untuk peran user
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Cek apakah user ini developer
     */
    public function isDeveloper(): bool
    {
        return $this->role === 'developer';
    }

    /**
     * Cek apakah user ini bug tester
     */
    public function isBugTester(): bool
    {
        return $this->role === 'bug_tester';
    }
}
