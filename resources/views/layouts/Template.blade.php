@extends('spinner')

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

    <script src="https://cdn.jsdelivr.net/npm/@ericblade/quagga2/dist/quagga.js"></script>

    <!-- Chart js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


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
            <div class="adminside">
                <p>Admin Page</p>
                <li class="{{Request::is('MainPage','MainPage/filterMonth','MainPage/filterYear') ? 'active':''}}">
                    <a href="{{route('viewMain')}}">
                        <i class='bx bx-grid-alt'></i>
                        <span class="link_name">Dashboard</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a class="link_name" href="#">Dashboard</a></li>
                    </ul>
                </li>
                <li class="{{Request::is('Pos') ? 'active':''}}">
                    <a href="{{route('viewPos')}}">
                        <i class='fas fa-cash-register'></i>
                        <span class="link_name">Pos</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link_name" href="#">Pos</a></li>
                    </ul>
                </li>
                <li class="{{Request::is('Product') ? 'active':''}}">
                    <a href="{{route('viewProduct')}}">
                        <i class='bx bxs-cube'></i>
                        <span class="link_name">Product</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link_name" href="#">Product</a></li>
                    </ul>
                </li>
                <li>
                    <div class="iocn-link">
                        <a href="#">
                            <i class='bx bxs-group'></i>
                            <span class="link_name">Customer</span>
                        </a>
                        <i class='bx bxs-chevron-down arrow'></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a class="link_name" href="#">Customer</a></li>
                        <li class="{{Request::is('Customer') ? 'active':''}}"><a href=" {{route('viewCustomer')}}">Customer List</a></li>
                        <li class="{{Request::is('RedeemItem') ? 'active':''}}"><a href=" {{route('viewRedeemItem')}}">Redeem Item</a></li>
                        <li class="{{Request::is('RedeemMessage') ? 'active':''}}"><a href=" {{route('viewRedeemMessage')}}">Redeem Message</a></li>
                    </ul>
                </li>
                <li class="{{Request::is('ListUser') ? 'active':''}}">
                    <a href="{{route('viewUser')}}">
                        <i class='bx bxs-user'></i>
                        <span class="link_name">User List</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link_name" href="#">List User</a></li>
                    </ul>
                </li>
                <li class="{{Request::is('Transaction','filterDate','filterMonth','filterPaymentType') ? 'active':''}}">
                    <a href="{{route('viewTransaction')}}">
                        <i class='bx bx-dollar-circle'></i>
                        <span class="link_name">Transaction</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link_name" href="#">Transaction</a></li>
                    </ul>
                </li>
                <li class="{{Request::is('Invoice','filterInvoiceDate','filterInvoiceMonth') ? 'active':''}}">
                    <a href="{{route('viewInvoice')}}">
                        <i class='bx bx-receipt'></i>
                        <span class="link_name">Invoice</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link_name" href="#">Invoice</a></li>
                    </ul>
                </li>

            </div>
            <div class="customerside">
                <p>Customer Page</p>
                <li class="{{Request::is('Redeem') ? 'active':''}}">
                    <a href="{{route('viewRedeem')}}">
                        <i class='bx bxs-discount'></i>
                        <span class="link_name">Redeem</span>
                    </a>
                    <ul class="sub-menu blank">
                        <li><a class="link_name" href="#">Redeem</a></li>
                    </ul>
                </li>
            </div>
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
                        <a class="dropdown-item" href="{{route('editProfile')}}">
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
            @if(Auth::user()->D_role == 2 || Auth::user()->D_role == 1)
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
                @if (request()->routeIs(['viewTransaction', 'filterMonth','filterPaymentType','filterDate']))
                <a href="{{ route('transactionPDF', ['start_date' => $start_date, 'end_date' => $end_date , 'payment' => $payment]) }}" class="btn-download">
                    <i class='bx bxs-cloud-download'></i>
                    <span class="text">Download PDF</span>
                </a>
                @endif
            </div>
            @endif

            @yield('content')
        </div>
    </section>

    <script src="{{ asset('js/Template.js') }}"></script>

</body>

</html>