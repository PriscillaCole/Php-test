<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Milestone extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'milestone_name',
        'description',
        'status',
        'start_date',
        'end_date',
    ];

    //relationship between milestones and projects
    public function projects(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
