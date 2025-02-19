<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskModel extends Model
{
    use HasFactory;

    protected $table = 'daftar_task';
    protected $fillable = [
        'name',
        'priority',
        'is_done',
        'tanggal'
    ];
}
