<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Project extends Model
{
    use HasFactory;


    protected $fillable = [
        'project_name',
        'description',
        'status',
        
    ];

    //relationship between projects and milestones
    public function milestones(): HasMany
    {
        return $this->hasMany(Milestone::class, 'project_id');
    }

    //relationship between projects and users
    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user')
            ->withPivot('role_id')
            ->withTimestamps();
    }
}
