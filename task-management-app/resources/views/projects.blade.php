

@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<div class="container">
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>{{ session('error') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session('success') }}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <div>{{ __('Project List') }}</div>
                        <a href="{{ route('home') }}" class="btn btn-primary btn-sm">{{ __('Create a New Project') }}</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Project Name</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                @php
                                    $statusClasses = [
                                        'In Progress' => 'btn-primary',
                                        'On Hold' => 'btn-warning',
                                        'Completed' => 'btn-success',
                                        'In Editing' => 'btn-secondary',
                                    ];

                                
                                    $statusClass = $statusClasses[$project->status] ?? 'btn-secondary';
                                @endphp

                                    <tr>
                                        <td>{{ $project->project_name }}</td>
                                        <td>{{ $project->description }}</td>
                                        <td>
                                        <div class="dropdown">
                                            
                                        <button class="btn {{ $statusClass }} dropdown-toggle" type="button" id="statusDropdown{{ $project->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            {{ $project->status }}
                                        </button>

                                           
                                        <div class="dropdown-menu" aria-labelledby="statusDropdown{{ $project->id }}">
                                            <a class="dropdown-item" href="#" data-project-id="{{ $project->id }}" data-status="In Progress">In Progress</a>
                                            <a class="dropdown-item" href="#" data-project-id="{{ $project->id }}" data-status="On Hold">On Hold</a>
                                            <!-- check the user role -->
                                            @if (Auth::user()->role_id == 2)
                                            <a class="dropdown-item" href="#" data-project-id="{{ $project->id }}" data-status="Completed">Completed</a>
                                            @endif
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#" data-project-id="{{ $project->id }}" data-status="In Editing">In Editing</a>
                                        </div>
                                    </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('edit', ['id' => $project->id]) }}" class="btn btn-primary btn-sm" title="Edit">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="{{ route('show', ['id' => $project->id]) }}" class="btn btn-info btn-sm" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('delete', ['id' => $project->id]) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this project?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Popper.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Include Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- JavaScript to update status -->
<script>
 
    $('.dropdown-item').click(function () {
         const projectId = $(this).data('project-id');
         const status = $(this).data('status');
    
         $.ajax({
              url: "{{ route('update_status') }}",
              type: 'POST',
              data: {
                _token: '{{ csrf_token() }}',
                project_id: projectId,
                status: status,
              },
              success: function (response) {
                      //reload the page
                      location.reload();
              }
         });
    });
    
</script>
@endsection
