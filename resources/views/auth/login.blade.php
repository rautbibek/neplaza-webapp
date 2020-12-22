@extends('layouts.app')

@section('content')
<div class="form__img">
  <a href="/">
    <i class='bx bx-arrow-back' ></i>
  </a>
  <h2>Login</h2>
</div>
<div class="form">
  <form class="auth-form" action="{{ route('login') }}" method="POST">
    @csrf

        <div class="">
          @if (session('message'))
              <div class="alert alert-danger">{{ session('message') }}</div>
          @endif
          @if ($errors->any())
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
              @foreach ($errors->all() as $error)
                  {{ $error }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
              @endforeach
          </div>
          @endif

          <div class="input-group mb-4">

            <div class="input-group-prepend">
              <div class="input-group-text" style="font-size:20px"><i class='bx bx-user-circle'></i></div>
            </div>
            <input type="text" class="form-control reg-form @error('phone') is-invalid @enderror" name="email" required value="{{ old('email') }}"  placeholder="Contact number or email address">
          </div>
          <div class="input-group mb-4">
            <div class="input-group-prepend">
              <div class="input-group-text" style="font-size:20px"><i class='bx bx-key'></i></div>
            </div>
            <input type="password" name="password" class="form-control reg-form @error('password') is-invalid @enderror" required  placeholder="Password">

          </div>
          <div class="form-check">
            <input id="chk1" {{ old('remember') ? 'checked' : '' }} type="checkbox" name="remember" class="form-check-input ">
            <label class="form-check-label" >Remember Me</label>
            <p class="text-right"><a href="password/reset" >Forgot Password?</a></p>
          </div>
          <button type="submit" class="btn submit form-control button-control my-2">LOGIN</button>
          <p class="text-center mt-2"> New Member ? <a href="/register"> Register </a> Here. </p>
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
@push('css')
<style>
.form-check {
    display: flex !important;
    justify-content: space-between;
}

</style>
@endpush
