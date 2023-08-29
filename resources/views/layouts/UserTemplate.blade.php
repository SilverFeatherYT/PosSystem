<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>POS system</title>

    <link rel="stylesheet" href="{{ asset('css/Template.css') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,700,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

    <script type="module" src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.esm.js"></script>
    <script nomodule src="https://cdn.jsdelivr.net/npm/@ionic/core/dist/ionic/ionic.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ionic/core/css/ionic.bundle.css" />

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/3.0.0/jquery.payment.min.js"></script>


    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div class="sidebar close">
        <a href="{{route('viewMain')}}" class="logo-details">
            <img src="{{asset('images/logo.png')}}" alt="">
            <span class="logo_name">Pos System</span>
        </a>
        <ul class="nav-links">
            @guest
            @else
            @if(!Auth::user()->email_verified_at)
            <li class="{{Request::is('email/verify') ? 'active':''}}">
                <a href="#">
                    <i class='bx bxs-discount'></i>
                    <span class="link_name">Verify</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Verify</a></li>
                </ul>
            </li>
            @elseif (Auth::user()->D_role == 0)
            <li class="{{Request::is('Redeem') ? 'active':''}}">
                <a href="{{route('viewRedeem')}}">
                    <i class='bx bxs-discount'></i>
                    <span class="link_name">Redeem</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Redeem</a></li>
                </ul>
            </li>
            @elseif(Auth::user()->D_role == 1)
            <li class="{{Request::is('Pos') ? 'active':''}}">
                <a href="{{route('viewPos')}}">
                    <i class='fas fa-cash-register'></i>
                    <span class="link_name">Pos</span>
                </a>
                <ul class="sub-menu blank">
                    <li><a class="link_name" href="#">Pos</a></li>
                </ul>
            </li>
            @endif
            @endguest

            @guest

            @else
            <li>
                <div class="profile-details">
                    <div class="profile-content">
                        <img src="{{asset('images/logo.png')}}" alt="profileImg">
                    </div>
                    <div class="name-job">
                        <div class="profile_name">{{ Auth::user()->name }}</div>
                        @php
                        $roles = ['customer', 'cashier', 'admin'];
                        @endphp
                        <div class="job">{{ $roles[Auth::user()->D_role] }}</div>
                    </div>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        <i class='bx bx-log-out'></i>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>

                    </a>
                </div>
            </li>
            @endguest
        </ul>
    </div>


    <section class="home-section">
        <div class="home-content">
            <i class='bx bx-menu'></i>
            <span class="text"></span>

            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <a href="#" class="profile">
                @guest

                @if (Route::has('login'))
                <li class="nav-item">
                    <button><a class="nav-link" href="{{route('viewLogin')}}">{{ __('Login') }}</a></button>
                </li>
                @endif
                @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        @if(Auth::user()->D_role == 0)
                        <a class="dropdown-item" href="{{route('viewProfile')}}">
                            Profile
                        </a>
                        @endif
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </a>
        </div>


        <div class="content">
            @guest

            @else
            @if(Auth::user()->D_role == 2 && Auth::user()->email_verified_at || Auth::user()->D_role == 1 && Auth::user()->email_verified_at)
            <div class="head-title">
                <div class="left">
                    <h1>Dashboard</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Dashboard</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="#">{{ config('app.name') }}</a>
                        </li>
                    </ul>
                </div>
                @if (request()->routeIs(['viewTransaction', 'filterTransactions', 'filterMonth','filterPaymentType']))
                <a href="{{ route('transactionPDF', ['start_date' => $start_date, 'end_date' => $end_date , 'payment' => $payment]) }}" class="btn-download">
                    <i class='bx bxs-cloud-download'></i>
                    <span class="text">Download PDF</span>
                </a>
                @endif
            </div>
            @endif
            @endguest

            @yield('content')
        </div>
    </section>

    <script src="{{ asset('js/Template.js') }}"></script>

</body>

</html>