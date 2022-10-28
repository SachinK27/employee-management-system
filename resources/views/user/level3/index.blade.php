@extends('user.level3.layouts.master')

	@section('page-title', 'My Tasks')
	
		@section('content')
            <div class="page-wrapper">
			
				<!-- Page Content -->
                <div class="content container-fluid">
					
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">My Tasks</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="/">Dashboard</a></li>
									<li class="breadcrumb-item active">My tasks</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-striped custom-table mb-0 datatable">
									<thead>
										<tr>
											<th style="width: 30px;">#</th>
											<th>Title</th>
											<th>Assigned By </th>
											<th>Start Date </th>
											<th>Deadline </th>
											<th class="text-center">Status</th>
											<th class="text-right">Action</th>
										</tr>
									</thead>
									<tbody>
									@foreach($data as $task)
										<tr>
											<td>1</td>
											<td>{{$task->task}}</td>
											<td>{{$task->assigned_by}}</td>
											<td>{{$task->assign_date}}</td>
											<td>{{$task->deadline}}</td>
											<td class="text-center">
												<div class="dropdown action-label">
													<a class="btn btn-white btn-sm btn-rounded dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
														<i class="fa fa-dot-circle-o text-danger"></i> New 
													</a>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-info"></i> Open</a>
														<a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-info"></i> Reopened</a>
														<a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-danger"></i> On Hold</a>
														<a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-success"></i> Closed</a>
														<a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-success"></i> In Progress</a>
														<a class="dropdown-item" href="#"><i class="fa fa-dot-circle-o text-danger"></i> Cancelled</a>
													</div>
												</div>
											</td>
											<td class="text-right">
												<div class="dropdown dropdown-action">
													<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item" href="#"><i class="fa fa-download m-r-5"></i> Download</a>
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
					
                </div>
				<!-- /Page Content -->
				
            </div>
		@endsection