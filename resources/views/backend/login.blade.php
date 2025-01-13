@extends('backend.templates.authentications')
@section('title', 'Login')
@section('content')
<div class="container container-tight py-4">
  <div class="text-center mb-4">
    <a href="{{ route('index') }}" class="navbar-brand navbar-brand-autodark">
      <img src="{{ asset('images/logo.png') }}" width="100" height="" alt="" class="">
    </a>
  </div>
  <div class="card">
    <div class="card-body">
      <h2 class="h2 text-center mb-4">Login</h2>
      
      <form action="{{ route('post-login') }}" method="post">
        @csrf
        @if(Session::get('error'))
          <div class="alert alert-important alert-danger" role="alert">
            {{ Session::get('error') }}
          </div>
        @endif
        <div class="mb-3">
          <label class="form-label required">Email</label>
          <input type="email" class="form-control" name="email" placeholder="Email">
        </div>
        <div class="mb-3">
          <label class="form-label required">Password</label>
          <input type="password" class="form-control" name="password" placeholder="Password">
        </div>
        <div class="form-footer">
          <button type="submit" class="btn btn-primary w-100">Login</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection