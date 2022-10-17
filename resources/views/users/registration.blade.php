<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Level1 Registration</title>
    <link rel="stylesheet" href="{{asset('assets/css/registration.css')}}">
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
<section class="vh-100 bg-image"
  style="background-image: url('https://mdbcdn.b-cdn.net/img/Photos/new-templates/search-box/img4.webp');">
  <div class="mask d-flex align-items-center h-100 gradient-custom-3">
    <div class="container h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
          <div class="card" style="border-radius: 15px;">
            <div class="card-body p-5">
              <h2 class="text-uppercase text-center mb-5">Create an Level1 User</h2>

              <form action="{{ route('level1registration') }}" method="POST">
               @csrf
                <div class="form-outline mb-4">
                <label class="form-label" for="form3Example1cg">Name</label>  
                <input type="text" name="name" id="form3Example1cg" class="form-control form-control-lg" />
                @if ($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                </div>

                <div class="form-outline mb-4">
                <label class="form-label" for="form3Example3cg">Email</label> 
                <input type="email" name="email" id="form3Example3cg" class="form-control form-control-lg" />
                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
                </div>
                <div class="form-outline mb-4">
                <label class="form-label" for="form3Example4cg">Mobile Number</label>
                <input type="text" name="mobNo" id="form3Example4cg" class="form-control form-control-lg" />
                @if ($errors->has('mobNo'))
                    <span class="text-danger">{{ $errors->first('mobNo') }}</span>
                @endif
                 </div>
                <div class="form-outline mb-4">
               <h6>please select gender</h6>
                <input type="radio" name="gender" value="male"/> <label for="male">Male</label><br>
                <input type="radio" name="gender" value="female" /> <label for="female">Female</label><br>
                @if ($errors->has('gender'))
                    <span class="text-danger">{{ $errors->first('gender') }}</span>
                @endif
              
                </div>

                <div class="form-outline mb-4">
                <label class="form-label" for="form3Example4cdg">Select Date Of Birth</label>
                <input type="date" name="dob" id="form3Example4cdg" class="form-control form-control-lg" />
                @if ($errors->has('gender'))
                    <span class="text-danger">{{ $errors->first('gender') }}</span>
                @endif
               </div>
                <div class="form-outline mb-4">
                <label class="form-label" for="form3Example4cdg">Department</label>
                <input type="text" name="department" id="form3Example4cdg" class="form-control form-control-lg" />
                @if ($errors->has('department'))
                    <span class="text-danger">{{ $errors->first('department') }}</span>
                @endif
               </div>
               <div class="form-outline mb-4">
               <h6>please select subordinate</h6>
               <select class="form-select" aria-label="Default select example">
  <option selected>Please Select</option>
  <option value="0">None</option>
</select>
                @if ($errors->has('department'))
                    <span class="text-danger">{{ $errors->first('department') }}</span>
                @endif
               </div>

                <div class="form-check d-flex justify-content-center mb-5">
                  <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3cg" />
                  <label class="form-check-label" for="form2Example3g">
                    I agree all statements in <a href="#!" class="text-body"><u>Terms of service</u></a>
                  </label>
                </div>

                <div class="d-flex justify-content-center">
                  <button type="submit"
                    class="btn btn-success btn-block btn-lg gradient-custom-4 text-body">Register</button>
                </div>
                </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>