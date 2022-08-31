@extends('layout.app')
@section('content')
<div class="container mg-10" style="margin-top: 5em;">

<div class="games">
        <div class="status">
          <h1> Sector of KICUKIRO</h1>
        </div>
        <div class="cards">
          
          <div class="card">
            <a href="{{ route('report') }}" class=" button" style="text-decoration: none; color:white; background:green;">
            <h3>Generate report </h3>
            <div class="card-info">
           
          </a>
          </div>
          {{-- <h3 class="percentage">60%</h3> --}}
        </div>
        <div class="cards">
          
            <div class="card">
              <a href="{{ route('paidAllHouse') }}" style="text-decoration: none">
              <h3>House paid Security fees </h3>
              <div class="card-info">
              <p>{{ $paid }}</p>
            </a>
            </div>
            {{-- <h3 class="percentage">60%</h3> --}}
          </div>
          <div class="card">
            <a href="{{ route('manage-house.index') }}" style="text-decoration: none">
            <h3>House in Taken </h3>
            <div class="card-info">
            <p>{{ $houseTaken }}</p>
            </a>
          </div>
          {{-- <h3 class="percentage">60%</h3> --}}
        </div>
          <div class="card">
            <a href="{{ route('manage-house.index') }}" style="text-decoration: none">
            <h3>House in Sector </h3>
            <div class="card-info">
            <p>{{ $house }}</p>
            </a>
          </div>
          {{-- <h3 class="percentage">60%</h3> --}}
        </div>
        <div class="card">
          <a href="{{ route('overduePay') }}" style="text-decoration: none">
          <h3>House overdue to pay</h3>
          <div class="card-info">
          <p>{{ $overduePay }}</p>
          {{-- <div class="progress"></div> --}}
        </div>
      </a>
        {{-- <h3 class="percentage">60%</h3> --}}
      </div>
      
        </div>
        
    </div>
  
  </section>
  <div class="circle1">
    
  </div>
  <div class="circle2">
      
  </div>
  <div class="circle3">
     
  </div>
</div>
@endsection