@extends('layout.collector')
@section('content')
<div class="container mg-10" style="margin-top: 5em;">

<div class="games">
        <div class="status">
          <h3>Welcome in <b>{{ $cells }}</b> Cell</h3>
          {{-- <input type="text"/> --}}
        </div>
        
        <div class="cards">
          <div class="card">
            <a href="{{ route('paidHouse') }}" style="text-decoration: none">
            <h3>House paid Security fees </h3>
            <div class="card-info">
            <p>{{ $paid ?? '' }}</p>
            </a>
            {{-- <div class="progress"></div> --}}
          </div>
        </div>
            <div class="card">
              <a href="{{ route('paidHouse') }}" style="text-decoration: none">
              <h3>House taken </h3>
              <div class="card-info">
              <p>{{ $houseTaken ?? '' }}</p>
              </a>
              {{-- <div class="progress"></div> --}}
            </div>
            {{-- <h3 class="percentage">60%</h3> --}}
          </div>
          <div class="card">
            <a href="{{ route('Manage-collector.house') }}" style="text-decoration: none">
            <h3>House In {{ $cells }} </h3>
            <div class="card-info">
            <p>{{ $house ?? '' }}</p>
            {{-- <div class="progress"></div> --}}
          </div>
        </a>
          {{-- <h3 class="percentage">60%</h3> --}}
        </div>
        <div class="card">
          <a href="{{ route('overdue') }}" style="text-decoration: none">
          <h3>House overdue to pay</h3>
          <div class="card-info ">
          <p>{{ $overdue }}</p>
          {{-- <div class="progress "></div> --}}
        </div>
        {{-- <h3 class="percentage">60%</h3> --}}
      </a>
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