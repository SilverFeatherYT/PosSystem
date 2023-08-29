@extends('layouts.Template')
@section('content')

<link href="{{ asset('css/AddProduct.css') }}" rel="stylesheet">

<div class="body">

    @include('toastr.toastr')

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>User List</h3>
                <div class="search">
                    <span class="material-symbols-outlined">
                        search
                    </span>
                    <input type="text" id="searchInput" class="searchInput" placeholder="Search something...">
                </div>
                <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="fa fa-plus"></i>&nbsp;Add</a>
                <form action="{{ route('deleteAllUser') }}" method="POST" id="deleteAllUser">
                    @csrf
                    @method('DELETE')
                    <!-- Add a hidden input field to hold the selected product IDs -->
                    <input type="hidden" id="selectedusers" name="selectedusers">
                    <input type="hidden" id="selectedcus" name="selectedcus">
                    <button type="submit" class="btn btn-danger" id="deleteAllButton" style="display: none;">
                        <i class="fa fa-trash"></i>&nbsp;Delete All
                    </button>
                </form>
            </div>
            <table>
                <thead>
                    @csrf
                    <tr>
                        <th><input type="checkbox" id="checkboxth"></th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Phone</th>
                        <th>Logout time</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="table">
                    @foreach ($users as $user)
                    <tr>
                        <td><input type="checkbox" id="checkboxtd" class="checkboxtd" data-user-id="{{ $user->id }}" data-cus-id="{{ $user->customer ? $user->customer->D_CusID : null }}"></td>
                        <td href="#editModal{{$user->id}}" data-bs-toggle="modal">{{$user->name}}</td>
                        <td href="#editModal{{$user->id}}" data-bs-toggle="modal">{{$user->email}}</td>
                        <td href="#editModal{{$user->id}}" data-bs-toggle="modal">
                            @php
                            $roles = ['customer', 'cashier', 'admin'];
                            @endphp
                            {{ $roles[$user->D_role] }}
                        </td>

                        <td href="#editModal{{$user->id}}" data-bs-toggle="modal">{{$user->phone}}</td>
                        <td href="#editModal{{$user->id}}" data-bs-toggle="modal">{{Carbon\Carbon::parse($user->last_seen)->diffForHumans()}}</td>
                        <td href="#editModal{{$user->id}}" data-bs-toggle="modal">
                            <span class="bg-{{$user->last_seen >= now()-> subMinutes(1) ? 'green' : 'red' }}-500 text-white py-1 px-3 rounded-full">
                                {{$user->last_seen >= now()-> subMinutes(1) ? 'Online' : 'Offline'}}
                            </span>
                        </td>
                        <td>
                            <div class="optionBtn" style="float: right;">
                                <a href="#editModal{{$user->id}}" data-bs-toggle="modal" class="btn btn-warning btn-xs"><i class='fa fa-edit'></i></a>
                                <a href="#deleteModal{{$user->id}}" data-bs-toggle="modal" class="btn btn-danger btn-xs"><i class='fa fa-trash'></i>&nbsp;</a>
                            </div>
                        </td>
                    </tr>

                    <!-- EditProduct Modal -->
                    <div class="modal fade" id="editModal{{$user->id}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="editModalLabel">Edit user</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{route('updateUser')}}" method="post" enctype="multipart/form-data" id="updateForm">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label >Name</label>
                                            <input type="hidden" name="id" value="{{$user->id}}">
                                            <input id="name" type="text" class="form-control" name="name" value="{{$user->name}}" autocomplete="name" autofocus>
                                            <span class="text-danger error-text name_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label >Email</label>
                                            <input type="email" id="email" name="email" value="{{$user->email}}" class="form-control">
                                            <span class="text-danger error-text email_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label >Password</label>
                                            <input type="password" id="cusPassword" name="cusPassword" value="{{$user->password}}" class="form-control">
                                            <span class="text-danger error-text cusPassword_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label >Phone Number</label>
                                            <input id="phone" type="tel" name="phone" value="{{$user->phone}}" class="form-control" autocomplete="phone" autofocus>
                                            <span class="text-danger error-text phone_error"></span>
                                        </div>
                                        <div class="form-group">
                                            <label >Role</label>
                                            <div class="selectManusia">
                                                <input type="radio" id="customer" name="role" value="0" {{ $user->D_role === '0' ? 'checked' : '' }}>
                                                <label for="customer">Customer</label><br>
                                                <input type="radio" id="cashier" name="role" value="1" {{ $user->D_role === '1' ? 'checked' : '' }}>
                                                <label for="cashier">Cashier</label><br>
                                                <input type="radio" id="admin" name="role" value="2" {{ $user->D_role === '2' ? 'checked' : '' }}>
                                                <label for="admin">Admin</label>
                                            </div>
                                            <span class="text-danger error-text role_error"></span>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Deleteuser Modal -->
                    <div class="modal fade" id="deleteModal{{$user->id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header ">
                                    <h1 class="modal-title fs-5" id="deleteModalLabel">Delete user</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('deleteUser',[$user->id])}}" method="get" enctype="multipart/form-data" id="deleteForm">
                                    <input type="hidden" name="user_id" value="{{$user->id}}">

                                    <div class="modal-body">
                                        <h2>Confirm delete user?</h2>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
            <div class="paginate">
                {{$users->links()}}
            </div>
        </div>
    </div>
</div>


<!-- Adduser Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('addUser')}}" method="post" enctype="multipart/form-data" id="addForm">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <label >Name</label>
                        <input id="name" type="text" class="form-control " name="name" value="{{ old('name') }}" required autofocus placeholder="Alex">
                        <span class="text-danger error-text name_error"></span>
                    </div>
                    <div class="form-group">
                        <label >Email</label>
                        <input type="email" id="email" name="email" class="form-control" required placeholder="alex@gmail.com">
                        <span class="text-danger error-text email_error"></span>
                    </div>
                    <div class="form-group">
                        <label >Phone Number</label>
                        <input id="phone" type="tel" name="phone" class="form-control" required placeholder="0127503957">
                        <span class="text-danger error-text phone_error"></span>
                    </div>
                    <div class="form-group">
                        <label >Password</label>
                        <input type="password" id="password" name="password" required class="form-control">
                        <span class="text-danger error-text password_error"></span>
                    </div>
                    <div class="form-group">
                        <label >Role</label>
                        <div class="selectManusia" >
                            <input type="radio" id="customer" name="role" value="0" required>
                            <label for="customer">Customer</label><br>
                            <input type="radio" id="cashier" name="role" value="1" required>
                            <label for="cashier">Cashier</label><br>
                            <input type="radio" id="admin" name="role" value="2" required>
                            <label for="admin">Admin</label>
                        </div>
                        <span class="text-danger error-text role_error"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add user</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('js/ListUser.js') }}"></script>
@endsection