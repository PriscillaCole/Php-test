<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use App\Models\Role;

class ProjectController extends Controller
{
 //function to display the project list
    public function index()
    {
        $projects = Project::all();
        return view('projects', compact('projects'));
    }
    
    public function store(Request $request)
    {
        //dd($request->all());
        // Validate the incoming data
        $validatedData = $request->validate([
            'project_name' => 'required|string|max:255',
            'description' => 'required|string',
            'milestones' => 'required|array|min:1',
            'milestones.*.milestone_name' => 'required|string|max:255',
            'milestones.*.description' => 'required|string',
            'milestones.*.status' => 'required|string',
            'milestones.*.start_date' => 'required|date',
            'milestones.*.end_date' => 'required|date',
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

        return redirect()->route('projects_table')->with('success', 'Project created successfully');
    }

    //function to display the project details with the milestones and users
    public function show($id)
    {
        $project = Project::with('milestones', 'users')->findOrFail($id);
        return view('project_details', compact('project'));
    }

    //function to display the project edit form
    public function edit($id)
    {
        $project = Project::with('milestones', 'users')->findOrFail($id);
        return view('edit_project', compact('project'));
    }

    //function to update the project details and milestones
    public function update(Request $request, $id)
    {
        //dd($request->all());
       
        // Validate the incoming data
        $validatedData = $request->validate([
            'project_name' => 'required|string|max:255',
            'description' => 'required|string',
            'milestones' => 'required|array|min:1',
            'milestones.*.milestone_name' => 'required|string|max:255',
            'milestones.*.description' => 'required|string',
            'milestones.*.status' => 'required|string',
            'milestones.*.start_date' => 'required|date',
            'milestones.*.end_date' => 'required|date',
            'developers' => 'required|array|min:1',
           
        ]);
        

        // Update the project
        $project = Project::findOrFail($id);
        $project->update([
            'project_name' => $validatedData['project_name'],
            'description' => $validatedData['description'],
        ]);

        // Delete existing developers for the project;
        $developerRole = Role::where('role_name', 'Developer')->first();

        if ($developerRole) {
            $project->users()->wherePivot('role_id', $developerRole->id)->detach();
        }
         // Attach developers to the project
         $developers = User::whereIn('id', $validatedData['developers'])->get();
         $project->users()->attach($developers, ['role_id' => Role::where('role_name', 'Developer')->first()->id]);

       

        // Delete existing milestones for the project
        $project->milestones()->delete();

        // Create new milestones for the project
        foreach ($validatedData['milestones'] as $milestoneData) {
            $project->milestones()->create([
                'milestone_name' => $milestoneData['milestone_name'],
                'description' => $milestoneData['description'],
                'status' => $milestoneData['status'],
                'start_date' => $milestoneData['start_date'],
                'end_date' => $milestoneData['end_date'],
            ]);
        }

       
        return redirect()->route('projects_table')->with('success', 'Project updated successfully');
    }

    //function to delete the project
    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return response()->json(['message' => 'Project deleted successfully'], 200);
    }

}

