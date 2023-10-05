@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div>{{ __('Edit Project') }}</div>
                <a href="{{ route('projects_table') }}" class="btn btn-primary btn-sm">{{ __('Project List') }}</a>
            </div>

                <div class="card-body">
                    <form id="projectForm" action="{{ route('update', ['id' => $project->id]) }}" method="POST">
                        @csrf
                        @method('PUT') <!-- Use the PUT method for updating -->

                        <div class="form-group">
                            <label for="projectName">Project Name:</label>
                            <input type="text" class="form-control" id="projectName" name="project_name" value="{{ $project->project_name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea class="form-control" id="description" name="description" required>{{ $project->description }}</textarea>
                        </div>
                        
                        <!-- Milestones -->
                        <div class="form-group">
                            <label for="milestones">Milestones:</label>
                            <ul id="milestonesList">
                                @foreach ($project->milestones as $index => $milestone)
                                <li class="mb-2">
                                    <input type="text" class="form-control" name="milestones[{{ $index }}][milestone_name]" value="{{ $milestone->milestone_name }}" placeholder="Milestone Name" required>
                                    <input type="text" class="form-control" name="milestones[{{ $index }}][description]" value="{{ $milestone->description }}" placeholder="Description" required>
                                    <select class="form-control" name="milestones[{{ $index }}][status]" required>
                                        <option value="awaiting-start" {{ $milestone->status === 'awaiting-start' ? 'selected' : '' }}>Awaiting Start</option>
                                        <option value="in-progress" {{ $milestone->status === 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="on-hold" {{ $milestone->status === 'on-hold' ? 'selected' : '' }}>On Hold</option>
                                        <option value="completed" {{ $milestone->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                    <input type="date" class="form-control" name="milestones[{{ $index }}][start_date]" value="{{ $milestone->start_date }}" required>
                                    <input type="date" class="form-control" name="milestones[{{ $index }}][end_date]" value="{{ $milestone->end_date }}" required>
                                </li>
                                @endforeach
                            </ul>
                            <button type="button" id="addMilestone" class="btn btn-secondary">Add Milestone</button>
                        </div>

                       <!-- Developers -->
                        @php
                        $developers = App\Models\User::where('role_id', 1)->get();
                        $selectedDevelopers = $project->users->pluck('id')->toArray();
                        @endphp
                        <div class="form-group">
                            <label for="developers">Developers:</label>
                            <select class="form-control" id="developers" name="developers[]" multiple required>
                                @foreach ($developers as $developer)
                                    <option value="{{ $developer->id }}" {{ in_array($developer->id, $selectedDevelopers) ? 'selected' : '' }}>{{ $developer->name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Project</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to dynamically add milestones -->
<script>
     var project = <?php echo json_encode($project); ?>;
     let milestoneIndex = project.milestones.length;// Initialize the milestone index based on existing milestones

    document.getElementById('addMilestone').addEventListener('click', function () {
        const milestonesList = document.getElementById('milestonesList');
        const milestoneItem = document.createElement('li');
        milestoneItem.className = 'mb-2';
        milestoneItem.innerHTML = `
            <input type="text" class="form-control" name="milestones[${milestoneIndex}][milestone_name]" placeholder="Milestone Name" required>
            <input type="text" class="form-control" name="milestones[${milestoneIndex}][description]" placeholder="Description" required>
            <select class="form-control" name="milestones[${milestoneIndex}][status]" required>
                <option value="awaiting-start">Awaiting Start</option>
                <option value="in-progress">In Progress</option>
                <option value="on-hold">On Hold</option>
                <option value="completed">Completed</option>
            </select>
            <input type="date" class="form-control" name="milestones[${milestoneIndex}][start_date]" required>
            <input type="date" class="form-control" name="milestones[${milestoneIndex}][end_date]" required>
        `;
        milestonesList.appendChild(milestoneItem);

        milestoneIndex++; // Increment the milestone index for the next milestone
    });
</script>

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include select2 CSS and JavaScript -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<!-- Initialize select2 for multi-select elements -->
<script>
    $(document).ready(function() {
        $('#developers, #projectManagers').select2();
    });
</script>
@endsection
