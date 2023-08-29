<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('css/Login.css') }}" rel="stylesheet">
    <title>POS System</title>
</head>

<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <form action="{{route('login')}}" method="POST" enctype='multipart/form-data' class="sign-in-form">
                    @csrf
                    <h2 class="title">Sign in</h2>

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

                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" class="@error('name') is-invalid @enderror @error('email') is-invalid @enderror input" id="name" name="name" required placeholder="Username" />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" class="input" id="password" name="password" placeholder="Password" required />
                        <span class="toggle-password">
                            <i class="fas fa-eye-slash"></i>
                        </span>
                    </div>
                    <input type="submit" value="Login" class="btn solid" />

                    <div class="forget">
                        @if (Route::has('password.request'))
                        <a class="" href="{{ route('password.request') }}">
                            {{ __('Forgot Password?') }}
                        </a>
                        @endif
                    </div>

                    <p class="social-text">Or Sign in with social platforms</p>
                    <div class="social-media">
                        <a href="{{ route('google.login') }}" class="social-icon">
                            <i class="fab fa-google"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>New here ?</h3>
                    <p>
                        Don't have an account?
                    </p>
                    <a href="{{route('register')}}">
                        <button class="btn transparent" id="sign-up-btn">
                            Sign up
                        </button>
                    </a>
                </div>
                <img src="{{asset('images/log.svg')}}" class="image" alt="" />
            </div>
        </div>
    </div>
</body>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://kit.fontawesome.com/a81368914c.js"></script>
<script src="{{ asset('js/Login.js') }}"></script>

</html>