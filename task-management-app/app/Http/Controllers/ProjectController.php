<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use App\Models\Role;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
        
        // Validate the incoming data
        $validatedData = $request->validate([
            'project_name' => 'required|string|max:255',
            'description' => 'required|string',
            'milestones' => 'required|array|min:1',   
            'developers' => 'required|array|min:1',
            'project_managers' => 'required|array|min:1',
        ]);
     

        // Create the project
        $project = Project::create([
            'project_name' => $validatedData['project_name'],
            'description' => $validatedData['description'],
        ]);

        // Attach developers to the project
        $developers = User::whereIn('id', $validatedData['developers'])->get();
        $project->users()->attach($developers, ['role_id' => Role::where('role_name', 'Developer')->first()->id]);

        // Attach project managers to the project
        $projectManagers = User::whereIn('id', $validatedData['project_managers'])->get();
        $project->users()->attach($projectManagers, ['role_id' => Role::where('role_name', 'Project Manager')->first()->id]);

        // Create milestones for the project
        foreach ($validatedData['milestones'] as $milestoneData) {
            $project->milestones()->create([
                'milestone_name' => $milestoneData['milestone_name'],
                'description' => $milestoneData['description'],
                'status' => $milestoneData['status'],
                'start_date' => $milestoneData['start_date'],
                'end_date' => $milestoneData['end_date'],
            ]);
        }

        return response()->json(['message' => 'Project created successfully'], 201);
    }
}

