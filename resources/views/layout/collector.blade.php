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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.6.9/sweetalert2.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css/css2?family=Poppins:wght@300;400;500;600&display=swap');
:root {
    --main-color: whitesmoke;
    --color-dark: #1D2231;
    --text-grey: #8390A2;
}
*{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    list-style-type: none;
    text-decoration: none;
    font-family: 'Poppins', sans-serif;
}
.dec{
    text-decoration: none;
}
.AL-N1{
    margin-bottom: 1em;
    margin-top: 0.5em;
}
.bta1{
    height: 2em;
    width: 2em;
    border-radius: 2em;
    background-color: red;
    border-color: red;
    color: white;
}
.sidebar{
    width: 345px;
    position: fixed;
    left: 0;
    top: 0;
    height: 100%;
    background: var(--main-color);
    z-index: 100;
    transition: width 300ms;

}
.sidebar-brand{
    height: 68px;
    padding: 1rem 0rem 1rem 2rem;
    color: white;
    background-color: teal;
}
.sidebar-brand span {
    display: inline-block;
    padding-right: 1rem;
}
.sidebar-menu{
    margin-top: 1rem;
}
.sidebar-menu li{
width: 100%;
margin-bottom: 1rem;
}
.sidebar-menu a{
    display: block;
    color:grey;
    font-size: 0.9rem;

}
.sidebar-menu a.active{
    background: #fff;
    padding-top: 1rem;
    padding-bottom: 1rem;
    color: var(--main-color);
    border-radius: 30px 0px 0px 30px;
}
.sidebar-menu a span:first-child{
    font-size: 1.5rem;
    padding-right: 1rem;
}
#nav-toggle:checked + .sidebar{
    width: 70px;
}
#nav-toggle:checked + .sidebar .sidebar-brand,
#nav-toggle:checked + .sidebar li {
    
    text-align: center;
}
#nav-toggle:checked + .sidebar li a{
    padding-left: 0rem;
}
#nav-toggle:checked + .sidebar .sidebar-brand h2 span:last-child,
#nav-toggle:checked + .sidebar li a span:last-child{
    display: none;
}
#nav-toggle:checked ~ .main-content{
    margin-left: 70px;
}
#nav-toggle:checked ~ .main-content header{
    width: calc(100% - 70px);
    left: 70px;
}
.main-content{
    transition: margin-left 200ms;
    margin-left: 345px;
}
.tb-cl{
    background-color: #003399;
    color: #fff;
}
header{
    background: teal;
    display: flex;
    color: #fff;
    justify-content: space-between;
    padding: 1rem 1.5rem;
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
    position: fixed;
    left: 345px;
    width: calc(100% - 345px);
    top: 0;
    z-index: 100;
    transition: left 300ms;
}
#nav-toggle {
    display: none;
    
}
header h2{
    color: #222;

}
header label span{
    font-size: 1.7rem;
    padding-right: 1rem;
}
.search-wrapper{
    border: 1px solid #ccc;
    border-radius: 30px;
    height: 50px;
    display: flex;
    align-items: center;
    overflow-x: hidden;
}
.search-wrapper span{
    display: inline-block;
    padding: 0rem 1rem;
    font-size: 1.5rem;
}

.user-wrapper{
    display: flex;
    align-items: center;

}

.user-wrapper small{
    display: inline-block;
    color: var(--text-grey);
}




@media only screen and (max-width: 1200px){
    .sidebar{
        width: 70px;
    }
    .sidebar-brand,
    .sidebar li {
        padding-left: 1rem;
        text-align: center;
    }
    .sidebar li a{
        padding-left: 0rem;
    }
    .sidebar .sidebar-brand h2 span:last-child,
    .sidebar li a span:last-child{
        display: none;
    }
    .main-content{
        margin-left: 70px;
    }
    .main-content header{
        width: calc(100% - 70px);
        left: 70px;
    }
    
}

@media only screen and (max-width: 768px) {
   
    .search-wrapper{
        display: none;
    }
    .sidebar{
        left: -100% !important;
    }
    header h2{
        display: flex;
        align-items: center;
    }
    header h2 label {
        display: inline-block;
        background: var(--main-color);
        padding-right: 0rem;
        margin-left: 1rem;
        height: 40px;
        width: 40px;
        border-radius: 50%;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center !important;
    }
    header h2 span{
        text-align: center;
        padding-right: 0rem;
    }
    header h2{
        font-size: 1.1rem;
    }
    header{
        width: 100% !important;
        left: 0 !important;
    }
    .main-content{
        width: 100%;
        margin-left: 0rem;
    }
    #nav-toggle:checked + .sidebar {
        left: 0 !important;
        z-index: 100;
        width: 345px;
    }
    
    #nav-toggle:checked + .sidebar .sidebar-brand,
    #nav-toggle:checked + .sidebar li {
        padding-left: 2rem;
        text-align: left;
    }
    #nav-toggle:checked + .sidebar li a{
        padding-left: 1rem;
    }
    #nav-toggle:checked + .sidebar .sidebar-brand h2 span:last-child,
    #nav-toggle:checked + .sidebar li a span:last-child{
        display: inline;
    }
    #nav-toggle:checked ~ .main-content{
        margin-left: 0rem !important;
    }

}
/* Style The Dropdown Button */
.dropbtn {
  /* background-color: #4CAF50; */
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}

/* The container <div> - needed to position the dropdown content */
.dropdown {
  position: relative;
  display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f9f9f9;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

/* Links inside the dropdown */
.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

/* Change color of dropdown links on hover */
.dropdown-content a:hover {background-color: #f1f1f1}

/* Show the dropdown menu on hover */
.dropdown:hover .dropdown-content {
  display: block;
}

/* Change the background color of the dropdown button when the dropdown content is shown */
.dropdown:hover .dropbtn {
  /* background-color: #3e8e41; */
}
    </style>
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
                    <a href="{{ route('Collector') }}" class="dec"><span class="las la-home"></span>
                        <span>Home</span></a>
                </li>
                <li>
                    <a href="{{ route('Collector') }}" class="dec"><span class="las la-clipboard-list"></span>
                        <span>Dashboard</span></a>
                </li>
                <li>
                    <a href="{{ route('Manage-collector.house') }}" class="dec"><span class="las la-clipboard-list"></span>
                        <span>Manage Houses</span></a>
                </li>
                <li>
                    <a href="{{route('showPeople') }}" class="dec"><span class="las la-clipboard-list"></span>
                        <span>Manage peoples</span></a>
                </li>
                <li>
                    <a href="{{ route('overdue') }}" class="dec"><span class="las la-clipboard-list"></span>
                        <span>Overdue Pay</span></a>
                </li>
            </ul>
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
           
            {{-- <span>{{ Auth::user()->name }}  </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
         
            <a href="{{ route('logout') }}" >
            
            <a class="fas fa-power-off" style="color: white; text-decoration: none;" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('') }}
                                    </a>


                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form> --}}
            
            </div>
        </header>
    

        <main class="py-4 d-flex justify-content-center">
            <div class="container">
            @yield('content')
            <div >{{ $notify?? '' }}</div>
            </div>
        </main>
    </div>
</body>
</html>