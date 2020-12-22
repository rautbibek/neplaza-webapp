@extends('layouts.app')

@section('content')
<div class="form__img">
  <a href="/">
    <i class='bx bx-arrow-back' ></i>
  </a>
  <h2>Register</h2>
</div>
<div class="form">
  <form class="auth-form" action="{{ route('register') }}" method="POST">
    @csrf
        <div class="">
          @if ($errors->any())

              @foreach ($errors->all() as $error)
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  {{ $error }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              @endforeach

          @endif
          <div class="input-group mb-3 mr-sm-2">
            <!-- <label for="name">Full Name <span style="color:red">*</span> </label> -->
            <div class="input-group-prepend">
              <div class="input-group-text" style="font-size:20px"><i class='bx bx-user-circle'></i></div>
            </div>
            <input type="text" class="form-control reg-form  @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  placeholder="Enter your first and last name" required>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="input-group mb-3 mr-sm-2">
            <!-- <label for="name">Full Name <span style="color:red">*</span> </label> -->
            <div class="input-group-prepend">
              <div class="input-group-text" style="font-size:20px"><i class='bx bx-phone'></i></div>
            </div>
            <input type="number" class="form-control reg-form  @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}"  placeholder="Please enter your contact number *">
            @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>

          <div class="input-group mb-3 mr-sm-2">
            <!-- <label for="name">Full Name <span style="color:red">*</span> </label> -->
            <div class="input-group-prepend">
              <div class="input-group-text" style="font-size:20px"><i class='bx bx-key'></i></div>
            </div>
            <input type="password" class="form-control reg-form  @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}"  placeholder="Password minimum 8 character *">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
          </div>
          <div class="input-group mb-3 mr-sm-2">
            <!-- <label for="name">Full Name <span style="color:red">*</span> </label> -->
            <div class="input-group-prepend">
              <div class="input-group-text" style="font-size:20px"><i class='bx bx-key'></i></div>
            </div>
            <input type="password" id="password-confirm" name="password_confirmation" class="form-control reg-form"  placeholder="Confirm Password" required autocomplete="new-password" >
          </div>
          <button type="submit" style="color:white" class="btn submit form-control button-control mt-3">SIGN UP</button>
          <p class="text-center mt-2"> Already Member? <a href="/login"> Login </a> Here. </p>
        </div>
  </form>
  <div class="separator">OR</div>
  <div class="auth-buttons-div">
      <a href="/login/facebook" class="btn facebook form-control button-control my-2"><i class='bx bxl-facebook'></i>Facebook</a>
      <a href="/login/google" class="btn google form-control button-control my-2"><i class='bx bxl-google' ></i>Google</a>
      <a href="/login/twitter" class="btn twitter form-control button-control my-2"><i class='bx bxl-twitter' ></i>Twitter</a>
  </div>
</div>
@endsection

