<!DOCTYPE html>
<html lang="en">

<head>
    <title>Log In Page</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="..\css\style.css" />
    <link rel="shortcut icon" type="x-icon" href="/css/logo.png">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
     <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0- 
      alpha/css/bootstrap.css" rel="stylesheet">
     
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 
     <link rel="stylesheet" type="text/css" 
      href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
     
     <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
</head>

<body>
    <!-- navbar -->
    <div class="header-blue">
        <nav class="navbar navbar-dark navbar-expand-md navigation-clean-search">
            <a class="navbar-brand" href="../index.php">GoFit</a><button class="navbar-toggler" data-toggle="collapse"
                data-target="#navcol-1">
                <span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" href="../index.php">GoFit</a>
                    </li>
                </ul>

                <form class="form-inline mr-auto" target="_self"></form>

                <span class="navbar-text mr-2">
                    <a href="loginPage.php" class="login"><a></span>
                <a class="btn btn-light action-button" role="button" href="{{ url('/') }}">Back</a>
            </div>
        </nav>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-10 col-xl-9 mx-auto">
                <div class="card flex-row my-5 border-0 shadow rounded-3 overflow-hidden">
                    <div class="card-img-left-login d-none d-md-flex "></div>
                    <div class="card-body p-4 p-sm-5">
                        <h3 class="card-title text-center fw-light fs-5">
                            <strong>Login</strong>
                        </h3>
                        <form action="{{ url('/login') }}" method="post">
                            @csrf
                            <div class="form-floating mb-3">
                                <label for="floatingInputEmail">Email</label>
                                <input type="text" class="form-control" id="email" placeholder="Email" required
                                    autofocus name="EMAIL_PEGAWAI" />
                            </div>

                            <div class="form-floating mb-3">
                                <label for="floatingPassword">Password</label>
                                <input type="password" class="form-control" id="password" placeholder="Password"
                                    name="password" />
                            </div>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </div>
                            @endif
                            @if (Session::get('success'))
                                <div class="alert alert-success alert-dismissible animate_animated animate_fadeInDown no-print"
                                    role="alert">
                                    {{ Session::get('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                                {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js"></script> --}}
                            @endif
                            @if (Session::get('error'))
                                <div class="alert alert-danger alert-dismissible animate_animated animate_fadeInDown no-print"
                                    role="alert">
                                    {{ Session::get('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                                {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
                                {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js"></script> --}}
                            @endif
                            <ul class="form-floating mb-3" style="font-size: 12px" align="right">
                                <a for="floatingForgot" onclick="location.href='confirmEmail';">Forgot Password?</a>
                            </ul>
                            <button
                                class="
                    btn btn-primary
                    fw-bold
                    text-uppercase
                    form-control
                  "
                                type="submit" name="login">
                                Log In
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <footer class="mastfoot mt-auto d-flex justify-content-center">
        <div class="inner">
            <p>GoFit <b>@2023</b></p>
        </div>
    </footer>
</body>

</html>
