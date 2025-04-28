<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskModel extends Model
{
    use SoftDeletes;

    protected $table = 'tasks';

    protected $fillable = [
        'title',
        'description',
        'done',
        'user_id',
    ];

    protected $casts = [
        'done' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
