@extends('admin.layouts.master')

	@section('page-title', 'Users | View | Edit')
	
        @section('topRes')
            <!-- Bootstrap Switch Button -->
            <link href="{{ asset('assets/css/bootstrap4-toggle.min.css') }}" rel="stylesheet">

            <style>
                .slow  .toggle-group { transition: left 0.7s; -webkit-transition: left 0.7s; }
                .toggle-group label.btn-xs { padding-top: 7px; }
                .display-none { display: none; }
                .display-block { display: block; }
            </style>
        @endsection

        @section('content')
            <div class="page-wrapper">
                
                <!-- Page Content -->
                <div class="content container-fluid">
                
                    <!-- Page Header -->
                    <div class="page-header">
                        <div class="row">
                            <div class="col-sm-12">
                                <h3 class="page-title">Profile</h3>
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('user.list') }}">User List</a></li>
                                    <li class="breadcrumb-item active">View & Edit User</li>
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
                                        <div class="profile-img-wrap">
                                            <div class="profile-img">
                                                <a href="{{ route('user.view.edit', ['id' => $user_id]) }}">
                                                    <img alt="User Image" src="{{ $user->avatar == '' ? asset('assets/img/user.jpg') : asset($user->avatar) }}">
                                                </a>
                                            </div>
                                        </div>
                                        @php
                                            function getCookie($name) {
                                                $value = Request::cookie($name);
                                                return $value;
                                            }
                                        @endphp
                                        <div class="profile-basic">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="profile-info-left">
                                                        <h3 class="user-name m-t-0 mb-0">{{ $user->name }}</h3>
                                                        <h6 class="text-muted">{{ $user->department }}</h6>
                                                        <!-- <small class="text-muted">{!! $user->isAdmin == 0 ? $user->level : '<span class="badge bg-inverse-info">Admin</span>' !!}</small> -->
                                                        <div class="staff-id">
                                                            Role : {!! Str::lower($user->role) == 'admin' ? '<span class="badge bg-inverse-info">'.$user->role.'</span>' 
                                                                    : '<span class="badge bg-inverse-warning">'.$user->role.'</span>' !!}</div>
                                                        <div class="small doj text-muted">Date of Join : {{ date('jS \of M, Y', strtotime($user->hire_date)) }}</div>
                                                        <!-- <div class="staff-msg"><a class="btn btn-custom" href="chat.html">Send Message</a></div> -->
                                                        <div class="staff-msg">
                                                            <input type="checkbox" id="chkToggle" data-toggle="toggle" data-on="Active" data-off="Inactive" 
                                                                    data-onstyle="success" data-offstyle="danger" data-style="slow" data-width="75" data-size="xs"
                                                                    {{ $user->status == 'active' ? 'checked' : '' }}>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <ul class="personal-info">
                                                        <li>
                                                            <div class="title">Phone:</div>
                                                            <div class="text"><a href="tel:{{ $user->phone }}">{{ $user->phone }}</a></div>
                                                        </li>
                                                        <li>
                                                            <div class="title">Email:</div>
                                                            <div class="text"><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></div>
                                                        </li>
                                                        <li>
                                                            <div class="title">Birthday:</div>
                                                            <div class="text">{{ date('jS M, Y', strtotime($user->dob)) }}</div>
                                                        </li>
                                                        <li>
                                                            <div class="title">Gender:</div>
                                                            <div class="text">{{ Str::ucfirst($user->gender) }}</div>
                                                        </li>
                                                        <li>
                                                            <div class="title">Reports to:</div>
                                                            <div class="text">
                                                                <div class="avatar-box">
                                                                    <div class="avatar avatar-xs">
                                                                        <img src="{{ asset('assets/img/user.jpg') }}" alt="Reporting Person Image">
                                                                    </div>
                                                                </div>
                                                                <a href="#">{{ $user->subordinate_to }}</a>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pro-edit {{ getCookie('pro_edit_'.$user_id) ? 'display-none' : 'display-block' }}"><a data-target="#profile_info" data-toggle="modal" class="edit-icon" href="#"><i class="fa fa-pencil"></i></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- <div class="card tab-box">
                        <div class="row user-tabs">
                            <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                                <ul class="nav nav-tabs nav-tabs-bottom">
                                    <li class="nav-item"><a href="#emp_profile" data-toggle="tab" class="nav-link active">Profile</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-content">
                    
                        <!-- Profile Info Tab -->
                        <!-- <div id="emp_profile" class="pro-overview tab-pane fade show active">
                            <div class="row">
                                <div class="col-md-6 d-flex">
                                    <div class="card profile-box flex-fill">
                                        <div class="card-body">
                                            <h3 class="card-title">Personal Informations <a href="#" class="edit-icon" data-toggle="modal" data-target="#personal_info_modal"><i class="fa fa-pencil"></i></a></h3>
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">Passport No.</div>
                                                    <div class="text">9876543210</div>
                                                </li>
                                                <li>
                                                    <div class="title">Passport Exp Date.</div>
                                                    <div class="text">9876543210</div>
                                                </li>
                                                <li>
                                                    <div class="title">Tel</div>
                                                    <div class="text"><a href="">9876543210</a></div>
                                                </li>
                                                <li>
                                                    <div class="title">Nationality</div>
                                                    <div class="text">Indian</div>
                                                </li>
                                                <li>
                                                    <div class="title">Religion</div>
                                                    <div class="text">Christian</div>
                                                </li>
                                                <li>
                                                    <div class="title">Marital status</div>
                                                    <div class="text">Married</div>
                                                </li>
                                                <li>
                                                    <div class="title">Employment of spouse</div>
                                                    <div class="text">No</div>
                                                </li>
                                                <li>
                                                    <div class="title">No. of children</div>
                                                    <div class="text">2</div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Profile Info Tab -->
                    <!-- </div> -->
                </div>
                <!-- /Page Content -->
                
                <!-- Profile Modal -->
                <div id="profile_info" class="modal custom-modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Profile Information</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('user.update', ['id' => $user_id ]) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="profile-img-wrap edit-img @error('image') is-invalid @enderror">
                                                <img class="inline-block" src="{{ $user->avatar == '' ? asset('assets/img/user.jpg') : asset($user->avatar) }}" alt="user">
                                                <div class="fileupload btn">
                                                    <span class="btn-text">Update</span>
                                                    <input class="upload" type="file" name="image">
                                                </div>
                                                @error('image')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Name <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ? old('name') : $user->name }}" placeholder="Full Name">
                                                        @error('name')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Contact No. <span class="text-danger">*</span></label>
                                                        <input type="number" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') ? old('phone') : $user->phone }}">
                                                        @error('phone')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Email <span class="text-danger">*</span></label>
                                                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ? old('email') : $user->email }}">
                                                        @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Birth Date <span class="text-danger">*</span></label>
                                                        <div class="cal-icon">
                                                            <input class="form-control datetimepicker @error('dob') is-invalid @enderror" type="text" name="dob" value="{{ old('dob') ? old('dob') : date('d-m-Y', strtotime($user->dob)) }}">
                                                            @error('dob')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Gender <span class="text-danger">*</span></label>
                                                        <select class="select form-control @error('gender') is-invalid @enderror" name="gender">
                                                            <option value="male" {{ old('gender') == 'male' ? 'selected' : ($user->gender == 'male' ? 'selected' : '') }}>Male</option>
                                                            <option value="female" {{ old('gender') == 'female' ? 'selected' : ($user->gender == 'female' ? 'selected' : '') }}>Female</option>
                                                            <option value="other" {{ old('gender') == 'female' ? 'selected' : ($user->gender == 'female' ? 'selected' : '') }}>Other</option>
                                                        </select>
                                                        @error('gender')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Hired On <span class="text-danger">*</span></label>
                                                <div class="cal-icon">
                                                    <input class="form-control datetimepicker @error('hire_date') is-invalid @enderror" type="text" name="hire_date" value="{{ old('hire_date') ? old('hire_date') : date('d-m-Y', strtotime($user->hire_date)) }}">
                                                    @error('hire_date')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Role <span class="text-danger">*</span></label>
                                                <select class="select form-control @error('role') is-invalid @enderror" name="role">
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->role }}" {{ old('role') == $role->role ? 'selected' : ($user->role == $role->role ? 'selected' : '') }}>
                                                            {{ $role->role }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('role')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Department <span class="text-danger">*</span></label>
                                                <select class="select form-control @error('department') is-invalid @enderror" name="department">
                                                    <option value="">Select Department</option>
                                                    @foreach($departments as $department)
                                                        <option value="{{ $department->department }}" 
                                                            {{ old('department') == $department->department ? 'selected' : ($user->department == $department->department ? 'selected' : '') }}>
                                                            {{ $department->department }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('department')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Reports To <span class="text-danger">*</span></label>
                                                <select class="select form-control @error('subordinate') is-invalid @enderror" name="subordinate">
                                                    <option value="">-</option>
                                                    @foreach($subordinates as $subordinate)
                                                        <option value="{{ $subordinate->subordinate_to }}" 
                                                            {{ old('subordinate') == $subordinate->subordinate_to ? 'selected' : ($user->subordinate_to == $subordinate->subordinate_to ? 'selected' : '') }}>
                                                            {{ $subordinate->subordinate_to }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('subordinate')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
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
                <!-- /Profile Modal -->
                
                <!-- Personal Info Modal -->
                <!-- <div id="personal_info_modal" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Personal Information</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Passport No</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Passport Expiry Date</label>
                                                <div class="cal-icon">
                                                    <input class="form-control datetimepicker" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tel</label>
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nationality <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Religion</label>
                                                <div class="cal-icon">
                                                    <input class="form-control" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Marital status <span class="text-danger">*</span></label>
                                                <select class="select form-control">
                                                    <option>-</option>
                                                    <option>Single</option>
                                                    <option>Married</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Employment of spouse</label>
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No. of children </label>
                                                <input class="form-control" type="text">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="submit-section">
                                        <button class="btn btn-primary submit-btn">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!-- /Personal Info Modal -->
            </div>
        @endsection

        @section('btmRes')
            <!-- Bootstrap Switch Button -->
            <script src="{{ asset('assets/js/bootstrap4-toggle.min.js') }}"></script>
            <script>
                $(function() {
                    $('#chkToggle').change(function() {
                        if(confirm('Are you sure, you want to change the status of this user?')) {
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
                                url : "{{ route('user.update.status', ['id' => $user_id ]) }}",
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
                        // else {
                        //     if($(this).prop('checked')) {
                        //         $(this).prop('checked', true).change();
                        //     } else {
                        //         $(this).prop('checked', false).change();
                        //     }
                        // }
                    });

                    let getCookie = "{{ getCookie('pro_edit_'.$user_id) }}";
                    if(getCookie) {
                        $('#profile_info').modal('show');
                    }

                    let editProBtn = $('.pro-edit .edit-icon');
                    let proEditName = 'pro_edit_{{ $user_id }}';
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
                        // let delProEdit = 'pro_edit_{{ $user_id }}';
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