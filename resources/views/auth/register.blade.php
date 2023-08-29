<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('css/Login.css') }}" rel="stylesheet">
    <title>POS System</title>
</head>

<body>
    <div class="container sign-up-mode">
        <div class="forms-container">
            <div class="signin-signup signup">
                <form action="{{route('register')}}" method="POST" id="registerForm" class="sign-up-form" enctype='multipart/form-data'>
                    @csrf
                    <h2 class="title">Sign up</h2>

                    <div class="div">
                        @error('name')
                        <div class="alert alert-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>
                    <div class="div">
                        @error('email')
                        <div class="alert alert-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </div>
                        @enderror
                    </div>

                    <!-- <div id="error_message"></div>
                    <div id="success_message"></div> -->

                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" class="@error('name') is-invalid @enderror input" id="name" name="name" required autocomplete="name" placeholder="Username" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" class="@error('email') is-invalid @enderror input" id="email" name="email" required autocomplete="email" placeholder="Email" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" class="@error('passsword') is-invalid @enderror input" id="password" name="password" placeholder="Password" required />
                        <span class="toggle-password">
                            <i class="fas fa-eye-slash"></i>
                        </span>
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" class="@error('password-confirm') is-invalid @enderror input" id="password-confirm" name="password_confirmation" required autocomplete="new-password" placeholder="Comfirm Password">
                        <span class="toggle-password">
                            <i class="fas fa-eye-slash"></i>
                        </span>
                    </div>
                    <input type="submit" class="btn" value="Sign up" />
                    <p class="social-text">Or Sign up with social platforms</p>
                    <div class="social-media">
                        <a href="{{ route('google.login') }}" class="social-icon">
                            <i class="fab fa-google"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel"></div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>One of us ?</h3>
                    <p>
                        Already have an account?
                    </p>
                    <a href="{{route('login')}}">
                        <button class="btn transparent" id="sign-up-btn">
                            Sign In
                        </button>
                    </a>
                </div>
                <img src="{{asset('images/register.svg')}}" class="image" alt="" />
            </div>
        </div>
    </div>
</body>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://kit.fontawesome.com/a81368914c.js"></script>
<script src="{{ asset('js/Login.js') }}"></script>
<script src="{{ asset('js/All.js') }}"></script>

</html>