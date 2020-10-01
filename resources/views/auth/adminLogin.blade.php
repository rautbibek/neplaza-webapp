@extends('layouts.admin')

@section('content')
<div class="overlay">
<!-- LOGN IN FORM by Omar Dsoky -->
<form action="" method="POST">
@csrf
   <!--   con = Container  for items in the form-->
   <div class="con">
   <!--     Start  header Content  -->
   <header class="head-form">
      <h4>Admin Login</h4>
   </header>
   <!--     End  header Content  -->
   <br>
   <div style="width:100%; text-align:center">
   @if ($errors->any())
            <div class="text-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="list-style:none">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
   </div>
   <div class="field-set">
     
      <!--   user name -->
         <span class="input-item">
           <i class="fa fa-user-circle"></i>
         </span>
        <!--   user name Input-->
         <input class="form-input" id="txt-input" name="email" type="email" value="{{ old('email') }}" placeholder="UserName or Email" required>
         
      <br>
     
           <!--   Password -->
     
      <span class="input-item">
        <i class="fa fa-key"></i>
       </span>
      <!--   Password Input-->
      <input class="form-input" type="password" name="password" placeholder="Password" id="pwd"  name="password" required>
      
<!--      Show/hide password  -->
     <span>
        <i class="fa fa-eye" aria-hidden="true"  type="button" id="eye"></i>
     </span>

      <br><br>
<!--        buttons -->
<!--      button LogIn -->
      <button class="log-in"> Log In </button>
   </div>
  
   <a href="{{route('welcome')}}" class="btn submits sign-up mt-5">GOTO HOMEPAGE &nbsp;
<!--         Sign Up font icon -->
      <i class="fa fa-home" aria-hidden="true"></i>
      </a>
     
<!--   End Conrainer  -->
  </div>
  
  <!-- End Form -->
</form>
</div>

@endsection
