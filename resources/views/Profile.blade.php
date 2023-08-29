@extends('layouts.UserTemplate')
@section('content')

<title>EditCustomer</title>
<link href="{{ asset('css/EditProfile.css') }}" rel="stylesheet">

@include('toastr.toastr')

<body>
    <div class="wrapper">
        <div class="boxtwo">
            <div class="leftbox">
                <a onclick="tabs(0)" class="tab active"><ion-icon name="person"></ion-icon></a>

                <a onclick="tabs(1)" class="tab"><i class='bx bx-history'></i></a>

                <a onclick="tabs(2)" class="tab"> <i class='bx bx-calendar-star'></i></a>

            </div>
        </div>

        <div class="rightbox">
            <div class="profile tabShow">
                <h1>Personal Info</h1>
                <form action="{{route('updateProfile')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <h2>Name</h2>
                    <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" required>

                    <h2>Phone Number</h2>
                    <input type="number" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">

                    <h2>Email</h2>
                    <input type="email" class="form-control" id="email" name="email" value="{{$user->email}}">
                    <span class="text-danger error-text email_error"></span>

                    <h2>Old Password</h2>
                    <input type="password" id="password" name="oldpassword" class="form-control" required>

                    <h2>New Password</h2>
                    <input type="password" id="password" name="newpassword" class="form-control" required>

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>

            <div class="redeem tabShow" id="redeem">
                @include('Paginate.message')
            </div>

            <div class="point tabShow" id="point">
                @include('Paginate.point')
            </div>
        </div>
    </div>

    <script src="{{ asset('js/EditProfile.js') }}"></script>
</body>

@endsection