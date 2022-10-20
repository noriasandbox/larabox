<?php

namespace App\Models;

use App\Models\Traits\HasAuthor;
use App\Models\Traits\HasLaraboxKeys;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory, SoftDeletes, HasAuthor, HasLaraboxKeys;

    const PREFIX = 'TASK';

    protected $guarded = [];

    protected $hidden = [];

    protected $casts = [
        'proposed_start_date' => 'date',
        'actual_start_date' => 'date',
        'project_end_date' => 'date',
        'actual_end_date' => 'date',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
