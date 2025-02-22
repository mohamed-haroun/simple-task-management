<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'user_id',
    ];

    protected $table = 'task_users';

    public $timestamps = false;
}
