@extends('layouts.app')

@section('content')

        <form action="{{ route('login') }}" method="POST">
          @csrf

              <div class="col-md-10">
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

                <div class="input-group mb-3 mr-sm-2">

                  <div class="input-group-prepend">
                    <div class="input-group-text" style="font-size:20px"><i class='bx bx-user-circle'></i></div>
                  </div>
                  <input type="text" class="form-control reg-form @error('phone') is-invalid @enderror" name="email" required value="{{ old('email') }}"  placeholder="Contact number or email address">


                </div>
                <div class="input-group mb-3 mr-sm-2">
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
                <button type="submit" style="color:white" class="btn bg-blue form-control button-control my-2">LOGIN</button>
                <p class="text-center mt-2"> New Member ? <a href="/register"> Register </a> Here. </p>
              </div>

            <div class="form__social col-md-10">
                <span class="form__social-text" style="margin-right:20px">-- OR --</span>

                <a href="/login/facebook" class="form__social-icon"><i class='bx bxl-facebook' ></i></a>
                <a href="/login/google" class="form__social-icon"><i class='bx bxl-google' ></i></a>
                <a href="/login/twitter" class="form__social-icon"><i class='bx bxl-twitter' ></i></a>
            </div>
        </form>

@endsection
@push('css')
<style>
.input-group{
  height: 50px !important;
  border:1px solid #2F3B59 !important;
  border-radius:0px !important;

}
.reg-form{
  height: 50px !important;
  border-left:1px solid #2F3B59 !important;
  border-radius:0px !important;
}
</style>
@endpush
