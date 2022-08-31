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
<div class="content-wrapper ">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="text-warning">Access Denied</h1>
          </div>
        </div>
      </div>
    </section>   
  </div>
    </div>
  </div>
</main>
@endsection