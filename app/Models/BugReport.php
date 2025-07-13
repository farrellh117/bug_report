<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class BugReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'reporter_id',  // foreign key ke user pelapor
        'reporter',     // tambahkan ini supaya mass assignment bisa diterima
    ];

    /**
     * Relasi ke User yang melaporkan bug (bug tester)
     */
    public function reporterUser()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    /**
     * Optional: Relasi ke User yang mengerjakan/menangani bug (developer)
     */
    public function assignedDeveloper()
    {
        return $this->belongsTo(User::class, 'developer_id');
    }
}
