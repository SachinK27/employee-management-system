@extends('admin.layouts.master')

	@section('page-title', 'Project | View | Edit')
	
        @section('topRes')
            <!-- Bootstrap Switch Button -->
            <link href="{{ asset('assets/css/bootstrap4-toggle.min.css') }}" rel="stylesheet">

            <style>
                .slow .toggle-group { transition: left 0.7s; -webkit-transition: left 0.7s; }
                .toggle-group label.btn-xs { padding-top: 7px; }
                .display-none { display: none; }
                .display-block { display: block; }
                .view-edit-project .profile-basic { margin-left: 0; }
            </style>
        @endsection

        @section('content')
            <div class="page-wrapper view-edit-project">
                
                <!-- Page Content -->
                <div class="content container-fluid">
                
                    <!-- Page Header -->
                    <div class="page-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="page-title">Profile</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('project.list') }}">Project List</a></li>
                                    <li class="breadcrumb-item active">View & Edit Project</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /Page Header -->
                    
                    <div class="card mb-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="profile-view">
                                        @php
                                            function getCookie($name) {
                                                $value = Request::cookie($name);
                                                return $value;
                                            }
                                        @endphp
                                        <div class="profile-basic">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="personal-info">
                                                        <h3 class="user-name m-t-0 mb-0">{{ $project->name }}</h3>
                                                        <div class="staff-msg">
                                                            <input type="checkbox" id="chkToggle" data-toggle="toggle" data-on="Active" data-off="Inactive" 
                                                                    data-onstyle="success" data-offstyle="danger" data-style="slow" data-width="75" data-size="xs"
                                                                    {{ $project->status == 'active' ? 'checked' : '' }}>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pro-edit {{ getCookie('pro_edit_'.$p_id) ? 'display-none' : 'display-block' }}"><a href="#" data-target="#project_info" data-toggle="modal" class="edit-icon"><i class="fa fa-pencil"></i></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Page Content -->
                
                <!-- Project Modal -->
                <div id="project_info" class="modal custom-modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Project Information</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('project.update', ['id' => $p_id ]) }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Name <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ? old('name') : $project->name }}" placeholder="Project Name">
                                                        @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="submit-section">
                                        <button type="submit" class="btn btn-primary submit-btn">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Project Modal -->
            </div>
        @endsection

        @section('btmRes')
            <!-- Bootstrap Switch Button -->
            <script src="{{ asset('assets/js/bootstrap4-toggle.min.js') }}"></script>
            <script>
                $(function() {
                    $('#chkToggle').change(function() {
                        if(confirm('Are you sure, you want to change the status of this project?')) {
                            let status
                            if($(this).prop('checked')){
                                status = 1;
                            } else {
                                status = 0;
                            }
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                url : "{{ route('project.update.status', ['id' => $p_id ]) }}",
                                data : {'status' : status},
                                type : 'POST',
                                success : function(result){
                                    if(result.errors) {
                                        toastr.error(result.message);
                                    } else if(result.success) {
                                        toastr.success(result.message, {timeOut: 6000});
                                    }
                                }
                            });
                        }
                    });

                    let getCookie = "{{ getCookie('pro_edit_'.$p_id) }}";
                    if(getCookie) {
                        $('#project_info').modal('show');
                    }

                    let editProBtn = $('.pro-edit .edit-icon');
                    let proEditName = 'pro_edit_{{ $p_id }}';
                    editProBtn.click(function(e){
                        e.preventDefault();
                        
                        let proEditValue = true;
                        let proEditTime = '';
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url : "{{ route('set.cookie') }}",
                            data : {'name' : proEditName, 'value': proEditValue, 'time': proEditTime},
                            type : 'POST',
                            success : function(result){
                                if(result.errors) {
                                    toastr.error(result.message);
                                } else {
                                    $('.pro-edit').css('display', 'none');
                                }
                            }
                        });
                    });
                    
                    let cancelBtn = $('.modal .close');
                    cancelBtn.click(function(e){
                        e.preventDefault();
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url : "{{ route('remove.cookie') }}",
                            data : {'name' : proEditName},
                            type : 'POST',
                            success : function(result){
                                if(result.errors) {
                                    if(result.errors) {
                                        toastr.error(result.message);
                                    }
                                } else {
                                    $('.pro-edit').addClass('display-block');
                                }
                            }
                        });
                    });
                })
			</script>
        @endsection