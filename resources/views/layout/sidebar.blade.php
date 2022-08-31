<!DOCTYPE html>
<html>
<head>
    <title>USCF</title>
   
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}" />
    
</head>
@extends('layout.layout')
  
@section('content')

  
    <div class="dashboard">
      <div class="user">
        <img src="./images/avatar.png" alt="">
        <h3>{{ Auth::user()->name }} </h3>
        <p>Admin</p>
      </div>
      <div class="links">
        <div class="link">
          <img src="./images/switch.png" alt="">
          <h3>Houses</h3>
        </div>
        <div class="link">
          <img src="./images/switch.png" alt="">
          <h3>Peoples</h3>
        </div>
        <div class="link">
          <img src="./images/switch.png" alt="">
          <h3>Fees collector</h3>
        </div>
      </div>
    
      <div class="pro">
        <h3><a class="nav-link" href="{{ route('register') }}">Add new user</a></h3>
      </div>
    </div>
  
@endsection