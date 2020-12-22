@extends('layouts.app')

@section('content')
<div class="form__img">
  <a href="/">
    <i class='bx bx-arrow-back' ></i>
  </a>
  <h2>Reset Password</h2>
</div>
<div class="form">
    <form class="auth-form" method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form-group">

                @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
            <input type="email" class="form-control textfield custom-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  placeholder="E-mail Address" required autocomplete="email" autofocus>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <button style="color:white" type="submit" class="btn submit form-control button-control">
            Send Password Reset Link
        </button>
    </form>
</div>
@endsection
@push('css')
<style>
@media screen and (max-width: 768px) {
    .form__img {
        height: 200px !important;
    }
    .form{
        margin-top: -100px !important;
    }
}
</style>
@endpush