@extends('layout.layout')
@section('content')
<style>
  .login-form{
        background-size: cover;
        content: "";
        opacity: 0.75;
        margin: auto;
        position:fixed ;
        top: 0px;
        background-color:teal;
        right: 0px;
        bottom: 0px;
        left: 0px;
        z-index: -2;
  }
  .cotainer{
      padding: 10rem;
      opacity: 19;
      z-index: 0;
  }
</style>
<main class="login-form">
<div class="cotainer">
  <div class="row justify-content-center">
<div class="hold-transition login-page col-md-6">
<div class="login-box ">
  
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <div class="login-logo" style="text-align: right">
        <a href="{{ route('login') }}">USCF</a>
      </div>
      <hr/>
            <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

      <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="input-group mb-3">
            @if(session()->has('success'))    
                <div class="alert alert-success"> {!! session('success') !!} </div>
            @endif
            @if(session()->has('error')) 
                <div class="alert alert-danger"> {!! session('error') !!} </div>  
            @endif 
        </div>
        <div class="form-group">
            <label>Email address<span class="required">*</span></label>
            <div class="form-group-field">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" autofocus>
            </div>
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">{{ __('Email Password Reset Link') }}</button>
          </div>
      </form>
      
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
</div>
  </div>
</div>
</main>

@endsection