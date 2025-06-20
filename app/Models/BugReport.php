<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BugReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'reporter', // Bisa tetap dipakai jika tidak menggunakan foreign key
        'user_id',  // Tambahkan jika ingin relasi dengan user
    ];
}
