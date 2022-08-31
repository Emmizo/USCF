@extends('layout.layout')
@section('content')
<link rel="stylesheet" href="{{ URL::asset('css/style.css') }}" />
<head>
    <style>
       .bg{
        /* background-image:url('/img/wp.jpeg') ;  */
        background-size: cover;
        content: "";
        opacity: 0.75;
        margin: auto;
        /* position:fixed ; */
        top: 0px;
        background: teal;
        right: 0px;
        bottom: 0px;
        left: 0px;
        z-index: -2;
  }
       .topic{
           color:white;
           margin-top: -1em;
           font-size: 3rem;
           text-align: center;
           font-family: poppins;
       }
       .basic-explain{
        margin-top: 15rem;
        font-size:1rem;
        text-align: center;
        color:#000; 
        font-family: poppins;
       }
    </style>
</head>
<main class="bg center">
    <div class="grass">
        <div class="topic">Umurenge security fees collection and notifier <br>system management</div>
        <div class="basic-explain"><i>This system created for to support sector of Kicukiro in their management of security fees and nofify their peoples living in this sector <br>via on their phone in order to avoid lating of payment</i></div>
    </div>
</main>
@endsection