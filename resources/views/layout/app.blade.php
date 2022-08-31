<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script src="https://kit.fontawesome.com/19faefb6e6.js" crossorigin="anonymous"></script>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    
</head>
<body>
      
 <input type="checkbox" id="nav-toggle">
    <div class="sidebar ">
        <div class="sidebar-brand">
            <h2><span><img src="/img/flag.png"  style="height: 1.5em;width:1.5em;border-radius:1.5em;"></span><span>{{ config('app.name') }}</span></h2>
        </div>
        <div class="sidebar-menu">
           
            <ul>
                <li>
                    <a href="{{ route('dashboard') }}" class="dec"><span class="las la-home"></span>
                        <span>Home</span></a>
                </li>
                <li>
                    <a href="{{ Auth::user()->role_id==1?route('dashboard'): route('Collector') }}" class="dec"><span class="las la-clipboard-list"></span>
                        <span>Dashboard</span></a>
                </li>
                <li>
                    <a href="{{ route('manage-user.index') }}" class="dec"><span class="las la-users"></span>
                        <span>Manage Users</span></a>
                </li>
                <li>
                    <a href="{{ route('manage-house.index') }}" class="dec"><span class="las la-clipboard-list"></span>
                        <span>Manage Houses</span></a>
                </li>
                <li>
                    <a href="{{route('manage-people.index') }}" class="dec"><span class="las la-clipboard-list"></span>
                        <span>Manage peoples</span></a>
                </li>
                <li>
                    <a href="{{ route('overduePay') }}" class="dec"><span class="las la-clipboard-list"></span>
                        <span>Overdue Pay</span></a>
                </li>
                <li>
                    <a href="{{ route('report') }}" class="dec"><span class="las la-clipboard-list"></span>
                        <span>Generate Report</span></a>
                </li>
            </ul>
            <a href="{{ route('reset') }}" class=" button" style="text-decoration: none; color:white"><span class="fa fa-reset" ></span>
                <span>Reset for new month</span></a>
                <hr>
            <a href="{{ route('send') }}"  id="click" class="button" style="text-decoration: none; color:white;" >
                <span>Notify Unpaid people</span></a>
        </div>
    </div>
    <div class="main-content">
        <header>
            <h2>
                <label for="nav-toggle" style="color: white;">
                    <span class="las la-bars"> </span>

                </label>
                

            </h2>
            <div class="user-wrapper" >
            <span>Welcome</span> &nbsp;&nbsp;&nbsp;
            <div class="dropdown">
                <button class="dropbtn"><span>{{ Auth::user()->name }}  </span></button>
                <div class="dropdown-content">
                  <a href="{{ route('change-password') }}">Change password</a>
                  <a href="{{ route('logout') }}" >Log out</a>
                  
                </div>
              </div>
         
       
            {{-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         
            <a href="{{ route('logout') }}" >
            
            <a class="fas fa-power-off" style="color: white; text-decoration: none;" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('') }}
                                    </a> --}}


                                    {{-- <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form> --}}
            
            </div>
        </header>
    

        <main class="py-4  d-flex justify-content-center">
            <div class="container">
            @yield('content')
            <div class=" d-flex justify-content-center">{{ $notify?? '' }}</div>
            
            </div>
           
        </main>
        
    </div>
    <script>
    $(document).ready(function(){
        $('#click').click(function(){
            //    alert('button clicked');
            $.ajax: "{{ route('send') }}",
           });
         // set time out 5 sec
            setTimeout(function(){
               $('#click').trigger('click');
           }, 4000);
       });
    </script>
</body>
</html>