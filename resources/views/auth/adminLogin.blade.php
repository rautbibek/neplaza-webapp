@extends('layouts.admin')

@section('content')
<main class="form-signin " style=" min-width:350px;border-radius:10px; background:#2f3b5940">
  <form method="POST">
  @csrf
    <div  class="text-center text-white">
       <a href="/">
       <img class="mb-4" src="{{asset('image/mob_logo.png')}}" alt="" width="72" height="70">
       </a>
      </div>
      <h4 class="text-center">ADMIN LOGIN</h4>
      @if ($errors->any())
      @foreach ($errors->all() as $error)
            <li style="list-style:none; color: red ">** {{ $error }} **</li>
       @endforeach
      @endif
      
    <label for="inputEmail" class="visually-hidden text-left">Email address</label>
    <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
    <label for="inputPassword" class="visually-hidden">Password</label>
    <input type="password" name="password" id="inputPassword" class="form-control text-left" placeholder="Password" required>
    <div class="checkbox mb-3">
      <label>
        <input {{ old('remember') ? 'checked' : '' }} type="checkbox" name="remember" value="remember" > Remember me
      </label>
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit">LOGIN</button>
    
  </form>
</main>
@endsection
