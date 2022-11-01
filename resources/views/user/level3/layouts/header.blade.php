<div class="header">
			
	<!-- Logo -->
	<div class="header-left">
		<a href="#" class="logo">
			<img src="https://d2nlyei8v64kfj.cloudfront.net/uploads/c/2019/7/6037-c-1.jpeg" width="40" height="40" alt="">
		</a>
	</div>
	<!-- /Logo -->
	
	<a id="toggle_btn" href="javascript:void(0);">
		<span class="bar-icon">
			<span></span>
			<span></span>
			<span></span>
		</span>
	</a>
	
	<!-- Header Title -->
	<div class="page-title-box">
		<h3>Chahal Academy</h3>
	</div>
	<!-- /Header Title -->
	
	<a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>
	
	<!-- Header Menu -->
	<ul class="nav user-menu">
	
		<!-- Search -->
		

		<li class="nav-item dropdown has-arrow main-drop">
			<a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
				<span class="user-img"><img src="assets/img/profiles/avatar-21.jpg" alt="">
				<span class="status online"></span></span>
				@if(!empty(Auth::user()))
					<span>{{Auth::user()->name}}</span>
				@endif
			</a>
			<div class="dropdown-menu">
				<a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault();
									document.getElementById('logout-form').submit();">
										{{ __('Logout') }}
									</a>
									<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
					@csrf
				</form>

			</div>
		</li>
	</ul>
	<!-- /Header Menu -->
	
	<!-- Mobile Menu -->
	<div class="dropdown mobile-user-menu">
		<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
		<div class="dropdown-menu dropdown-menu-right">
			<a class="dropdown-item" href="{{route('logout')}}">Logout</a>
		</div>
	</div>
	<!-- /Mobile Menu -->
	
</div>