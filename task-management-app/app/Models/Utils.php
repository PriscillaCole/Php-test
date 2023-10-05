<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utils extends Model
{
    //function to get the status of the project and design the badge
    public static function getStatus($status)
    {
        switch ($status) {
            case 'awaiting-start':
                return '<span class="badge badge-secondary">Awaiting Start</span>';
            case 'in-progress':
                return '<span class="badge badge-primary">In Progress</span>';
            case 'on-hold':
                return '<span class="badge badge-warning">On Hold</span>';
            case 'completed':
                return '<span class="badge badge-success">Completed</span>';
            default:
                return '<span class="badge badge-secondary">Awaiting Start</span>';
        }
    }

}
