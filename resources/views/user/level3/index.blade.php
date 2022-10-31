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
									<li class="breadcrumb-item"><a href="#">Dashboard</a></li>
									<li class="breadcrumb-item active">My tasks</li>
								</ul>
							</div>
							<div class="col-auto float-right ml-auto">
								<a href="#" class="btn add-btn" data-toggle="modal" data-target="#create_task" id="modalTrigger"><i class="fa fa-plus"></i> Create new task</a>
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
											<th style="width: 30px;">Sr.No</th>
											<th>Task</th>
											<!-- <th>Assigned By </th>
											<th>Start Date </th>
											<th>Priority</th>
											<th>Deadline </th> -->
											<th>Priority</th>
											<th class="text-center">Status</th>
											<th>Action</th>
											<!-- <th class="text-right">Action</th> -->
										</tr>
									</thead>
									<tbody>
										{{$i=1;}}
									
										@foreach($data as $task)
										<?php
											$assign_date=$task->assign_date;
                                            $monthNum=substr($assign_date,2,2);
                                            $month_name = date("F", mktime(0, 0, 0, $monthNum, 10));
                                            $assignDate=date('d', strtotime($task->assign_date));
                                            $assignnDatee=$assignDate." ".$month_name;
											$deadline=$task->deadline;
											$monthNumm=substr($deadline,2,2);
                                            $month_namee = date("F", mktime(0, 0, 0, $monthNumm, 10));
											$deadlineDate=date('d',strtotime($task->deadline));
											$deadlineTime=date('h:m a',strtotime($task->deadline));
											$deadline=$deadlineDate." ".$month_namee." ".$deadlineTime;

											

										?>
										<tr>
											<td>{{$i++}}</td>
											<td>{{$task->task}}</td>
											@if($task->priority==1)
											<td style="color:green">Low</td>
											@elseif($task->priority==2)
											<td style="color:blue">Medium</td>
											@else
											<td style="color:red">High</td>
											@endif
											<!-- <td>{{$task->assigned_by}}</td>
											<td>{{ date('d-m', strtotime($task->assign_date)) }}</td>
											<td>{{$task->priority}}</td>
											<td>{{ date('d-m h:m', strtotime($task->deadline)) }}</td> -->
											<td class="text-center">
												<div class="dropdown action-label">
													<a class="" href="#" data-toggle="dropdown" aria-expanded="false">
														
														@if($task->status==0)
                                                        <p>Assigned</p>
                                                        @elseif($task->status==1)
                                                        <p>In-Progress</p>
                                                        @elseif($task->status==2)
                                                        <p>Pending</p>
                                                        @elseif($task->status==3)
                                                        <p>completed</p>
                                                        @else
                                                        <p>Reviewed</p>
                                                        @endif
													</a>
													<div class="dropdown-menu dropdown-menu-right">
														<!-- <a class="dropdown-item" href="{{ route('changeStatus',[$task->id,'status'=>'In-Progress']) }}"><i class="fa fa-dot-circle-o text-secondary"></i> In-Progress </a>
														<a class="dropdown-item" href="{{ route('changeStatus',[$task->id,'status'=>'Pending']) }}"><i class="fa fa-dot-circle-o text-danger"></i> Pending</a>
														<a class="dropdown-item" href="{{ route('changeStatus',[$task->id,'status'=>'Completed']) }}"><i class="fa fa-dot-circle-o text-success"></i> Completed</a> -->
													</div>
												</div>
											</td>
											<td class="text-right">
												<div class="dropdown dropdown-action">
													<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
													<div class="dropdown-menu dropdown-menu-right">
													
														<!-- <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_policy"><i class="fa fa-pencil m-r-5"></i> Edit</a> -->
														<a href="#" class="dropdown-item" data-toggle="modal" data-target="#add_user{{$task->id}}"><i class="fa fa-edit"></i> Update Task</a>
										
													</div>
												</div>
											</td>
										</tr>
										<!-- modal popup start -->
			<div id="add_user{{$task->id}}" class="modal custom-modal fade" role="dialog">
					<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Task Details</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
                                <form action="{{route('updateStatuss')}}" method="post">
									@csrf
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label> Task <span class="text-danger"></span></label>
										<textarea name="" id="" class="form-control" cols="30" value="{{$task->task}}" rows="1" disabled="disabled">{{$task->task}}</textarea>
											
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label> Assigned By <span class="text-danger"></span></label>
												<input type="text" name="name" value="{{$task->assigned_by}}" id="name" class="@error('name') is-invalid @enderror form-control" disabled="disabled">
											
											</div>
										</div>
										<input type="hidden" name="id" value="{{$task->id}}">
										<div class="col-sm-6">
											<div class="form-group">
												<label> Assigned To <span class="text-danger"></span></label>
												<input type="text" name="name" value="{{$task->assigned_to}}" id="name" class="@error('name') is-invalid @enderror form-control" disabled="disabled">
											
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label> Assigned Date <span class="text-danger"></span></label>
												<input type="text" name="name" value="{{$assignnDatee}}" id="name" class="@error('name') is-invalid @enderror form-control" disabled="disabled">
											
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label> Deadline <span class="text-danger"></span></label>
												<input type="text" name="name" value="{{$deadline}}" id="name" class="@error('name') is-invalid @enderror form-control" disabled="disabled">
											
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label> Add Note <span class="text-danger">Optional</span></label>
											<input type="text" name="note" value="{{$task->notes}}"  id="name" class="@error('note') is-invalid @enderror form-control">
											
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label> Status <span class="text-danger"></span></label>
												<select class="form-control" name="status" id="">
													<option value="1" @if($task->status==1) selected @endif>Assigned</option>
													<option value="2" @if($task->status==2) selected @endif>In-Progress</option>
													<option value="3" @if($task->status==3) selected @endif>pending</option>
													<option value="4" @if($task->status==4) selected @endif>Completed</option>
												</select>
											
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
			<!-- modal popup end -->
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
					
                </div>
				<!-- /Page Content -->
				
<!-- add task create task -->
<div id="create_task" class="modal custom-modal fade" role="dialog">
					<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">Create new task</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form action="{{url('create-task')}}" method="POST" id="new-task">
									@csrf
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<label>Task Detail</label>
												<textarea class="form-control" name="desc" id="desc" cols="30" rows="10"></textarea>
												@if ($errors->has('desc'))
                                                <span class="text-danger">{{ $errors->first('desc') }}</span>
                                                @endif
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>Assign To</label>
												<select class="select" name="assignTo" id="assignTo">
													<option value="" selected disabled>Select Option</option>
												</select>
												@if ($errors->has('assignTo'))
                                                <span class="text-danger">{{ $errors->first('assignTo') }}</span>
                                                @endif
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Select Project</label>
												<select class="select" name="company" id="company">
													<option value="" selected disabled>Select Option</option>
												</select>
												@if ($errors->has('company'))
                                                <span class="text-danger">{{ $errors->first('company') }}</span>
                                                @endif
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>Priority</label>
												<select class="select" name="priority" id="priority">
													<option value="" selected disabled>Select</option>
													<option value="1">Low</option>
													<option value="2">Medium</option>
													<option value="3">High</option>
												</select>
												@if ($errors->has('priority'))
                                                <span class="text-danger">{{ $errors->first('priority') }}</span>
                                                @endif
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label>Deadline</label>
												<input class="form-control" name="deadline" id="deadline" type="datetime-local">
												@if ($errors->has('deadline'))
												<span class="text-danger">{{ $errors->first('deadline') }}</span>
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
<!-- add task create task  -->


            </div>
			
			<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
			@if(session()->has('success'))
         <script>
         Swal.fire(
            'Success',
            '{{session("success")}}',
            'success'
         );
         </script>
      @endif
	  <script>
				$(document).ready(function () {
					$.ajaxSetup({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                    });
					$('#modalTrigger').click(function(){
						
						$.ajax({
							url:"{{ url('getUsers') }}",
							type:"POST",

							success:function (data) {
								$('#assignTo').empty();
								$.each(data,function(key,value){
									$('#assignTo').append('<option value="'+value.id+'">'+value.name+'</option>');
								})
							}
						})
						$.ajax({
							url:"{{ url('getCompany') }}",
							type:"POST",

							success:function (data) {
								$('#company').empty();
								$.each(data,function(key,value){
									$('#company').append('<option value="'+value.id+'">'+value.name+'</option>');
								})
							}
						})
					});
				});

	  </script>
		@endsection