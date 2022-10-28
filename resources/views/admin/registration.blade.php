@extends('admin.layouts.master')

	@section('page-title', 'Blank Page')
	
		@section('content')


            <div class="page-wrapper">
			
				<!-- Page Content -->
                <div class="content container-fluid">
					
					<!-- Page Header -->
					<div class="page-header">
						<div class="row">
							<div class="col-sm-12">
								<h3 class="page-title">Blank Page</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
									<li class="breadcrumb-item active">Blank Page</li>
								</ul>
							</div>
                            <div class="col-auto float-right ml-auto">
								<a href="#"  class="btn add-btn" data-toggle="modal" data-target="#add_user"><i class="fa fa-plus"></i> Add User</a>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					
					<!-- Content Starts -->
						<!-- Search Filter -->
					<div class="row filter-row">
						<div class="col-sm-6 col-md-3">  
							<div class="form-group form-focus">
								<input type="text" class="form-control floating">
								<label class="focus-label">Name</label>
							</div>
						</div>
						<div class="col-sm-6 col-md-3"> 
							<div class="form-group form-focus select-focus">
								<select class="select floating"> 
									<option>Select Company</option>
									<option>Global Technologies</option>
									<option>Delta Infotech</option>
								</select>
								<label class="focus-label">Company</label>
							</div>
						</div>
						<div class="col-sm-6 col-md-3"> 
							<div class="form-group form-focus select-focus">
								<select class="select floating"> 
									<option>Select Roll</option>
									<option>Web Developer</option>
									<option>Web Designer</option>
									<option>Android Developer</option>
									<option>Ios Developer</option>
								</select>
								<label class="focus-label">Role</label>
							</div>
						</div>
						<div class="col-sm-6 col-md-3">  
							<a href="#" class="btn btn-success btn-block"> Search </a>  
						</div>     
                    </div>
<!-- search filter ends -->
<!-- table section starts -->
<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-striped custom-table datatable">
									<thead>
										<tr>
											<th>Name</th>
											<th>Email</th>
											<th>Company</th>
											<th>Created Date</th>
											<th>Role</th>
											<th class="text-right">Action</th>
										</tr>
									</thead>
									<tbody>
										@foreach($user as $users)
										<tr>
											<td>
												<h2 class="table-avatar">
													<a href="profile.html" class="avatar"><img src="assets/img/profiles/avatar-19.jpg" alt=""></a>
													<a href="profile.html">{{$users->name}}</a>
												</h2>
											</td>
											<td>{{$users->email}}</td>
											<td>Global Technologies</td>
											<td>{{$users->created_at}}</td>
											<td>
												<span class="badge bg-inverse-info">Client</span>
											</td>
											<td class="text-right">
												<div class="dropdown dropdown-action">
													<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
													<div class="dropdown-menu dropdown-menu-right">
														<a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_user"><i class="fa fa-pencil m-r-5"></i> Edit</a>
														<a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_user"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
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
<!-- table section ends -->

					<!-- /Content End -->
					
                </div>
				<!-- /Page Content -->
                	
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
				
            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
  <script>
if ($("#regForm").length > 0) {
$("#regForm").validate({
rules: {
name: {
required: true,

},
email: {
required: true,

},
dob: {
required: true,

},
department: {
required: true,

},
phone: {
required: true,

},
level: {
required: true,

},
gender: {
	required: true,
}

},
messages: {
name: {
required: "Please enter name",
},
gender: {
required: "Please select gender",
},
email: {
required: "Please enter valid email",
},
phone: {
required: "Please enter valid mobile no",
},
dob: {
required: "Please enter date of birth",
},
department: {
required: "Please enter department",
},
level: {
required: "Please enter hierarchy",
},
},
})
} 
</script>
  <script type="text/javascript">

$(document).ready(function () {
    $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
    $('#level').on('change',function(e) {
var level = $("#level").val();
$.ajax({
url:"{{ url('getPlead') }}",
type:"POST",
data: {
"level": level
},
success:function (data) {
$('#subordinate').empty();
$.each(data,function(key,value){
$('#subordinate').append('<option value="'+value.id+'">'+value.name+'</option>');
})
}
})
});
});
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
      @if (count($errors) > 0)
    <script type="text/javascript">
        $( document ).ready(function() {
             $('#add_user').modal('show');
        });
    </script>
  @endif


	  
		@endsection
 