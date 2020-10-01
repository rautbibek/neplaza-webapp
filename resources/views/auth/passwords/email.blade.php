@extends('layouts.app')

@section('content')
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <h1 class="form__title">Reset Password</h1>

                        <div class="form-group col-md-10">

                              @if (session('status'))
                              <div class="alert alert-success alert-dismissible fade show" role="alert">
                                  {{ session('status') }}
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                              </div>
                              @endif


                          <label for="exampleInputEmail1">E-mail Address</label>
                          <input type="email" class="form-control custom-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  placeholder="E-mail" required autocomplete="email" autofocus>
                          @error('email')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror

                        </div>

                        <div class="form-group">
                            <div class="col-md-6 ">
                                <button style="color:white" type="submit" class="btn bg-blue form-control button-control">
                                    Send Password Reset Link
                                </button>
                            </div>
                        </div>
                    </form>
@endsection
