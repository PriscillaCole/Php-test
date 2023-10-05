@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div>{{ __('Project Details') }}</div>
                        <a href="{{ route('projects_table') }}" class="btn btn-primary btn-sm">{{ __('Project List') }}</a>
                    </div>
                </div>

                <div class="card-body">
                    <h4>{{ $project->project_name }}</h4>
                    <p><strong>Description:</strong> {{ $project->description }}</p>

                    <h5>Milestones:</h5>
                    <ul>
                        @foreach ($project->milestones as $milestone)
                            <li>
                                <strong>Milestone Name:</strong> {{ $milestone->milestone_name }}<br>
                                <strong>Description:</strong> {{ $milestone->description }}<br>
                                <strong>Status:</strong> {{ $milestone->status }}<br>
                                <strong>Start Date:</strong> {{ $milestone->start_date }}<br>
                                <strong>End Date:</strong> {{ $milestone->end_date }}<br>
                            </li>
                        @endforeach
                    </ul>

                        <h5>Developers:</h5>
                    <ul>
                        @foreach ($project->users as $user)
                            @if ($user->role_id == 1)
                                <li>{{ $user->name }}</li>
                            @endif
                        @endforeach
                    </ul>

                    <h5>Project Managers:</h5>
                    <ul>
                        @foreach ($project->users as $user)
                            @if ($user->role_id == 2)
                                <li>{{ $user->name }}</li>
                            @endif
                        @endforeach
                    </ul>
                                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
