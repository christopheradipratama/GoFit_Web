<!DOCTYPE html>
<html lang="en">

<style>
    #button-container {
        text-align: right;
    }
</style>

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
                <a class="btn btn-light action-button" role="button" href="{{ url('/loginPage') }}">Back</a>
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
                            <strong>Forgot Password</strong>
                        </h3>
                        <form action="{{ url('confirmPasswordProccess/'. Session::get('Email')->ID_PEGAWAI) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-floating mb-3">
                                <label for="floatingInputEmail">Password</label>
                                <input type="text" class="form-control" id="password" placeholder="password" required
                                    autofocus name="changePassword" />
                            </div>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </div>
                            @endif
                            <div id="button-container">
                                <button class="btn btn-primary justify-content-center" type="submit"
                                    name="password">
                                    Change Password
                                </button>
                            </div>
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
