@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Create a New Project') }}</div>

                <div class="card-body">
                 <form id="projectForm" action="{{ route('store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="projectName">Project Name:</label>
                            <input type="text" class="form-control" id="projectName" name="project_name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="milestones">Milestones:</label>
                            <ul id="milestonesList" class="list-unstyled">
                                <li class="mb-2">
                                    <input type="text" class="form-control" name="milestones[0][milestone_name]" placeholder="Milestone Name" required>
                                    <input type="text" class="form-control" name="milestones[0][description]" placeholder="Description" required>
                                    <select class="form-control" name="milestones[0][status]" required>
                                        <option value="awaiting-start">Awaiting Start</option>
                                        <option value="in-progress">In Progress</option>
                                        <option value="on-hold">On Hold</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                    <input type="date" class="form-control" name="milestones[0][start_date]" required>
                                    <input type="date" class="form-control" name="milestones[0][end_date]" required>
                                </li>
                            </ul>
                            <button type="button" id="addMilestone" class="btn btn-secondary">Add Milestone</button>
                        </div>

                        <div class="form-group">
                            <label for="developers">Developers:</label>
                            <select class="form-control" id="developers" name="developers[]" multiple required>
                                @foreach (App\Models\User::where('role_id', 1)->get() as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="projectManagers">Project Managers:</label>
                            <select class="form-control" id="projectManagers" name="project_managers[]" multiple required>
                                @foreach (App\Models\User::where('role_id', 2)->get() as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Create Project</button>
                        </div>
                    </form>

                 <!-- JavaScript to dynamically add milestones -->
            <script>
                let milestoneIndex = 1; // Initialize the milestone index

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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
