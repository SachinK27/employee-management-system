@extends('admin.layouts.master')

	@section('page-title', 'Projects | List')

		@section('topRes')
			<!-- Bootstrap Switch Button -->
            <link href="{{ asset('assets/css/bootstrap4-toggle.min.css') }}" rel="stylesheet">
			<style>
				.add-button { text-align: right; }
				.slow .toggle-group { transition: left 0.7s; -webkit-transition: left 0.7s; }
                .toggle-group label.btn-xs { padding-top: 7px; }
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
								<h3 class="page-title">Projects List</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Dashboard</a></li>
									<li class="breadcrumb-item active">Projects List</li>
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
									@php
										function getCookie($name) {
											$value = Request::cookie($name);
											return $value;
										}
									@endphp
									<div class="add-button">
										<a href="#" data-target="#project_add" data-toggle="modal">
											<button type="button" class="btn btn-outline-primary btn-sm btn-add-surveyer">
												<i class="fa fa-plus"></i> Add New Project
											</button>
										</a>
									</div>
								</div>
								<div class="card-body">

									<div class="table-responsive">
										<table class="datatable table table-stripped mb-0">
											<thead>
												<tr>
													<th>S. No</th>
													<th>Name</th>
													<th>Status</th>
													<th>Actions</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>S. No</th>
													<th>Name</th>
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

					<!-- Project Add Modal -->
					<div id="project_add" class="modal custom-modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
						<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">Project Information</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<form action="{{ route('project.add') }}" method="post">
										@csrf
										<div class="row">
											<div class="col-md-12">
												<div class="row">
													<div class="col-md-12">
														<div class="form-group">
															<label>Name <span class="text-danger">*</span></label>
															<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Project Name">
															@error('name')
																<span class="invalid-feedback" role="alert">
																	<strong>{{ $message }}</strong>
																</span>
															@enderror
														</div>
													</div>
													<div class="col-md-12">
														<div class="form-group">
															<label>Status <span class="text-danger">*</span></label>
															<input type="checkbox" id="chkToggle" name="status" data-toggle="toggle" data-on="Active" data-off="Inactive" 
                                                                    data-onstyle="success" data-offstyle="danger" data-style="slow" data-width="75" data-size="xs"
                                                                    {{ old('status') ? 'checked' : '' }}>
															@error('status')
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
					<!-- /Project Add Modal -->
					
                </div>
				<!-- /Page Content -->
				
            </div>
		@endsection

		@section('btmRes')
			<!-- Bootstrap Switch Button -->
			<script src="{{ asset('assets/js/bootstrap4-toggle.min.js') }}"></script>
			<script>
				$(function () {
					let dataTable = ".datatable";
					let table = $(dataTable).DataTable({
						processing: true,
						serverSide: true,
						order: [
							[0, 'desc'],
						],
						ajax: "{{route('project.list.fetch')}}",
						columns: [
							{ data: 'id', name: 'S. No.' },
							{ data: 'name', name: 'Name' },
							{ class: 'text-center', data: 'status', name: 'Status'},
							{ data: 'action', name: 'Actions' },
						],
						responsive: true, lengthChange: true, autoWidth: false,
					});

					$('body').on('click', '.dropdown.project-status .dropdown-item', function() {
						if(confirm('Are you sure, you want to change the status of this project?')) {
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

					let getCookie = "{{ getCookie('add_pro') }}";
                    if(getCookie) {
                        $('#project_add').modal('show');
                    }

					let addPro = $('.add-button');
					let proAddName = 'add_pro';
                    addPro.click(function(e){
                        e.preventDefault();
                        
                        let proAddVal = true;
                        let proAddTime = '';
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url : "{{ route('set.cookie') }}",
                            data : {'name' : proAddName, 'value': proAddVal, 'time': proAddTime},
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
                            data : {'name' : proAddName},
                            type : 'POST',
                            success : function(result){
                                if(result.errors) {
                                    if(result.errors) {
                                        toastr.error(result.message);
                                    }
                                }
                            }
                        });
                    });
				});
			</script>
		@endsection