@extends('layouts.app')

@section('content')

        <form action="{{ route('register') }}" method="POST">
          @csrf

              <div class="col-md-10">
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


                <button type="submit" style="color:white" class="btn bg-blue form-control button-control mt-3">SIGN UP</button>
                <p class="text-center mt-2"> Already Member <a href="/login"> Login </a> Here. </p>
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
