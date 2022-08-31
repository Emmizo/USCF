@extends('layout.layout')
  
@section('content')
<head>
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
</head>
<main class="login-form">
  <div class="cotainer">
      <div class="row justify-content-center">
          <div class="col-md-6">
              <div class="card">
                  <div class="card-header">Login</div>
                  <div class="card-body">
  
                      <form action="{{ route('login.post') }}" method="POST">
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
                              <label for="email_address" class="col-md-4 col-form-label">Email</label>
                              <div class="col-md-12">
                                  <input type="text" id="email_address" class="form-control" name="email" required autofocus>
                                  @if ($errors->has('email'))
                                      <span class="text-danger">{{ $errors->first('email') }}</span>
                                  @endif
                              </div>
                          </div>
  
                          <div class="form-group">
                              <label for="password" class="col-md-4 col-form-label">Password</label>
                              <div class="col-md-12">
                                  <input type="password" id="password" class="form-control" name="password" required>
                                  @if ($errors->has('password'))
                                      <span class="text-danger">{{ $errors->first('password') }}</span>
                                  @endif
                              </div>
                          </div>
  
                          <div class="form-group row">
                              <div class="col-md-6">
                                  <div class="checkbox">
                                      <label>
                                          <input type="checkbox" name="remember"> Remember Me
                                      </label>
                                  </div>
                              </div>
                          </div>
  
                          <div class="col-md-12 ">
                              <button type="submit" class="btn btn-primary btn-block">
                                  Login
                              </button>
                          </div>
                          <div class="col-12" style="text-align: right">
                            <p class="mb-0" style="margin-top:10px;"> <a href="{{ route('forget') }}"><h5>Forgot Password?</h5></a></p>
                        </div>
                      </form>
                        
                  </div>
              </div>
          </div>
      </div>
  </div>
</main>
@endsection