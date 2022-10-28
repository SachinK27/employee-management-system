@extends('admin.layouts.master')

	@section('page-title', 'Users | List')
	
		@section('content')
            <div class="page-wrapper">
			
				<!-- Page Content -->
                <div class="content container-fluid">
					
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">Users List</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Dashboard</a></li>
									<li class="breadcrumb-item active">User List</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<!-- Content Starts -->
					<div class="row">
						<div class="col-sm-12">
							<div class="card mb-0">
								<div class="card-header">
									<h4 class="card-title mb-0">Users List</h4>
									<!-- <p class="card-text">
										This is the most basic example of the datatables with zero configuration. Use the <code>.datatable</code> class to initialize datatables.
									</p> -->
									<div class="col-auto float-right ml-auto">
								<a href="#"  class="btn add-btn" data-toggle="modal" data-target="#add_user"><i class="fa fa-plus"></i> Add User</a>
							</div>
								</div>
								<div class="card-body">

									<div class="table-responsive">
										<table class="datatable table table-stripped mb-0">
											<thead>
												<tr>
													<th>S. No</th>
													<th>Image</th>
													<th>Name</th>
													<th>Email</th>
													<th>Contact No.</th>
													<th>Gender</th>
													<th>DOB</th>
													<th>Role</th>
													<th>Department</th>
													<th>Subordinate to</th>
													<th>Hired On</th>
													<th>Status</th>
													<th>Actions</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>S. No</th>
													<th>Image</th>
													<th>Name</th>
													<th>Email</th>
													<th>Contact No.</th>
													<th>Gender</th>
													<th>DOB</th>
													<th>Role</th>
													<th>Department</th>
													<th>Subordinate to</th>
													<th>Hired On</th>
													<th>Status</th>
													<th>Actions</th>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /Content End -->
					
                </div>
				<!-- /Page Content -->

				<!-- Approve Leave Modal -->
				<!-- <div class="modal custom-modal fade" id="change_status" role="dialog">
					<div class="modal-dialog modal-dialog-centered">
						<div class="modal-content">
							<div class="modal-body">
								<div class="form-header">
									<h3>Change User Status</h3>
									<p>Are you sure, you want to change status of this user?</p>
								</div>
								<div class="modal-btn delete-action">
									<div class="row">
										<div class="col-6">
											<a href="javascript:void(0);" id="confirm" class="btn btn-primary continue-btn">Yes, Change</a>
										</div>
										<div class="col-6">
											<a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">Cancel</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div> -->
				<!-- /Approve Leave Modal -->
				
            </div>
		@endsection

		@section('btmRes')
			<script>
				$(function () {
					let dataTable = ".datatable";
					let table = $(dataTable).DataTable({
						processing: true,
						serverSide: true,
						order: [
							[0, 'desc'],
						],
						ajax: "{{route('user.list.fetch')}}",
						columns: [
							{ data: 'id', name: 'S. No.' },
							{ data: 'avatar', name: 'Image', 
								render: function(data, type, row) {
									return '<img src="'+data+'" class="avatar" alt="User Image">'
								}
							},
							{ data: 'name', name: 'Name' },
							{ data: 'email', name: 'Email' },
							{ data: 'phone', name: 'Contact No.' },
							{ data: 'gender', name: 'Gender' },
							{ data: 'dob', name: 'DOB' },
							{ data: 'role', name: 'Role', 
								render: function(data, type, row) {
									if(data == 'Admin') {
										return '<span class="badge bg-inverse-info">'+data+'</span>'
									} else {
										return '<span class="badge bg-inverse-warning">'+data+'</span>'
									}
								}
							},
							{ data: 'department', name: 'Department' },
							{ data: 'subordinate_to', name: 'Subordinate To' },
							{ data: 'hire_date', name: 'Hired On' },
							{ class: 'text-center', data: 'status', name: 'Status'},
							{ data: 'action', name: 'Actions' },
						],
						responsive: true, lengthChange: true, autoWidth: false,
					});

					$('body').on('click', '.dropdown.user-status .dropdown-item', function() {
						if(confirm('Are you sure, you want to change the status of this user?')) {
							$.ajax({
								headers: {
									'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
								},
								url : $(this).data('url'),
								data : {'status' : $(this).data('value')},
								type : 'POST',
								success : function(result){
									if(result.errors) {
									    toastr.error(result.message);
									} else if(result.success) {
										table.ajax.reload();
										toastr.success(result.message, {timeOut: 6000});
									}
								}
							});
						}
					});
				});
			</script>
				
				<!-- Add User Modal -->
				<div id="add_user" class="modal custom-modal fade" role="dialog">
					<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Add User</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form action="{{route('registration')}}" id="regForm" method="POST">
									@csrf
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label> Name <span class="text-danger">*</span></label>
												<input type="text" name="name" id="name" class="@error('name') is-invalid @enderror form-control" required>
												@if ($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                                @endif
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Email</label>
												<input type="email" name="email" id="email"   class="form-control" required>
												@if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                                 @endif
											</div>
										</div>
										
										<div class="col-sm-6">
											<div class="form-group">
												<label>Mobile No <span class="text-danger">*</span></label>
												<input type="number" name="phone" id="phone"  class="form-control" required>
												@if ($errors->has('phone'))
                                               <span class="text-danger">{{ $errors->first('phone') }}</span>
                                               @endif
											</div>
										</div>
                                        <div class="col-sm-6">
											<div class="form-group">
												<label>Employee Hierarchy</label>
												<select class="form-control" name="level" id="level">
												<option value="" disabled selected>Select employee hierarchy</option>
												<option value="1">Project Head</option>
												<option value="2">Project Lead</option>
												<option value="3">User</option>
											
												</select>
												@if ($errors->has('level'))
                                                 <span class="text-danger">{{ $errors->first('level') }}</span>
                                                 @endif
											</div>
										</div>
										
                                        <div class="col-sm-6">
											<div class="form-group">
												<label>Select Gender</label>
												<select name="gender" class="form-control">
												<option value="" disabled selected>Select gender</option>
													<option value="male">Male</option>
													<option value="female">Female</option>
													<option value="other">Other</option>
												</select>
												@if ($errors->has('gender'))
                                                 <span class="text-danger">{{ $errors->first('gender') }}</span>
                                                 @endif
											</div>
										</div>




										<div class="col-sm-6">
											<div class="form-group">
												<label>Date Of Birth</label>
												<input  class="form-control" name="dob" id="dob" type="date" required>
												@if ($errors->has('dob'))
                                                <span class="text-danger">{{ $errors->first('dob') }}</span>
                                                @endif
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Department<span class="text-danger">*</span></label>
												<!-- <input type="text" name="department" id="department" class="form-control"> -->
												<select name="department" id="department" class="form-control">
												<option value="" disabled selected>Select option</option>
													@foreach($data as $departments)
													<option value="{{$departments->department}}">{{$departments->department}}</option>
													@endforeach
												</select>
												@if ($errors->has('department'))
                                                 <span class="text-danger">{{ $errors->first('department') }}</span>
                                                 @endif
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Subordiante To</label>
												<select name="subordinateTo" class="form-control" id="subordinate">
												<option value="" disabled selected>Select Subordinate To</option>
												</select>
												@if ($errors->has('subordinateTo'))
                                                <span class="text-danger">{{ $errors->first('subordinateTo') }}</span>
                                                 @endif
											</div>
										</div>

										
									<div class="submit-section">
										<button type="submit" class="btn btn-primary">Submit</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- /Add User Modal -->
		@endsection