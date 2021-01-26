@extends('layouts.app')

@section('content')
<div class="form__img">
  <a href="/login">
    <i class='bx bx-arrow-back' ></i>
  </a>
  <h2>Reset Password</h2>
</div>
<div  class="form">
<form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        

                        <div class="col-md-10">
                          <input type="hidden" name="token" value="{{ $token }}">
                          <label for="exampleInputEmail1">E-mail Address</label>
                          <input type="email" class="form-control custom-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  placeholder="E-mail" required autocomplete="email" autofocus>
                          @error('email')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>

                        <div class="col-md-10">
                          <label for="exampleInputPassword1">Password</label>
                          <input type="password" name="password" class="form-control custom-control @error('password') is-invalid @enderror"  placeholder="Password" required autocomplete="new-password">
                          @error('password')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>

                        <div class="col-md-10">
                          <label for="password-confirm">Confirm Password</label>
                          <input type="password" id="password-confirm" name="password_confirmation" class="form-control custom-control"  placeholder="Confirm Password" required >
                          @error('password')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                        </div>


                        <div class="form-group">
                            <div class="col-md-6">
                                <button type="submit" style="color:white" class="btn bg-blue button-control">
                                    Reset Password
                                </button>
                            </div>
                        </div>
                    </form>
</div>
                    


@endsection
