@extends('admin.layouts.master')

	@section('page-title', 'Notifications')
	
		@section('content')
            <div class="page-wrapper">
			
				<!-- Page Content -->
                <div class="content container-fluid">
					
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">Notifications</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
									<li class="breadcrumb-item active">Notifications</li>
								</ul>
							</div>
							<div class="col-auto float-right ml-auto">
								<a href="#" class="btn add-btn" data-toggle="modal" data-target="#create_notification" id="modalTrigger"><i class="fa fa-plus"></i> Create Notification</a>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<!-- Content Starts -->
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-striped custom-table mb-0 datatable">
									<thead>
										<tr>
											<th style="width: 30px;">#</th>
											<th>Notification</th>
											<th>Added On</th>
											<th class="text-right">Action</th>
										</tr>
									</thead>
									<tbody>
										@foreach($list as $notification)
										<tr>
											<td>{{$notification->id}}</td>
											<td>{{$notification->notification}}</td>
											<td>{{$notification->created_at->format('d M Y - h:i a')}}</td>
											<td class="text-right">
												<div class="dropdown dropdown-action">
													<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_policy"><i class="fa fa-pencil m-r-5"></i> Edit</a>
														<a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_policy"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
													</div>
												</div>
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<!-- /Content End -->
					
                </div>
				<!-- /Page Content -->

				<!-- Add Ticket Modal -->
				<div id="create_notification" class="modal custom-modal fade" role="dialog">
					<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Create new task</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form action="{{url('create-notification')}}" method="POST" id="new-notification">
									@csrf
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<label>Notification</label>
												<textarea class="form-control" name="notification" id="notification" cols="30" rows="10"></textarea>
												@if ($errors->has('notification'))
                                                <span class="text-danger">{{ $errors->first('notification') }}</span>
                                                @endif
											</div>
										</div>
									</div>
									<div class="submit-section">
										<button class="btn btn-primary submit-btn">Create</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- /Add Ticket Modal -->
				
            </div>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
			
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
			
			<script type="text/javascript">
				if ($("#new-notification").length > 0) {
					$("#new-notification").validate({
						rules: {
							notification: {
							required: true,
							}
						},
						messages: {
							notification: {
							required: "Please enter notification to share",
							},
						},
					})
				}

			</script>
			@if(session()->has('success'))
				<script>
				Swal.fire(
					'Success',
					'{{session("success")}}',
					'success'
				);
				</script>
			@endif
			@if(session()->has('fail'))
				<script>
				Swal.fire(
					'Fail',
					'{{session("fail")}}',
					'success'
				);
				</script>
			@endif
		@endsection