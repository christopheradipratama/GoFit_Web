<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
    <title>Tugas Besar Web - Kelompok I</title>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/gd4_x_xxxx">Tugas Besar Web - Kelompok I</a>
            <div class="d-flex justify-content-end">
            <button class="btn btn-primary me-2" type="button">
                    <a class="text-light" style="text-decoration: none" href="./page/registerPage.php">Sign Up</a>
                </button>
                <button class="btn btn-warning ms-2" type="button" href="./loginPage.php">
                    <a class="text-light" style="text-decoration: none" href="./page/loginPage.php">Login</a>
                </button>
            </div>
        </div>
    </nav>
    <div class="bg">
        <div class="container min-vh-100 d-flex align-items-center">
            <div class="pt-5 mt-4">
                <h2 class="text-center align-middle text-white"><b class="bg-dark">
                        Selamat datang di perpustakaan</b></h2>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
</body>

</html> -->


<!DOCTYPE html>
<html lang="en">
  <head>
    <title>GoFit_200710780</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link rel="stylesheet" href="..\css\cover.css" />
    <link rel="shortcut icon" type="x-icon" href="/css/logo.png">
    <script
      src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
      integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
      integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
      integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
      crossorigin="anonymous"
    ></script>
    <script type="text/javascript" src="scripts\script.js"></script>
  </head>

  <body>
    <!-- navbar -->
    <div class="header-blue fixed-top">
      <nav class="navbar navbar-dark navbar-expand-md navigation-clean-search">
        <a class="navbar-brand" href="index.php">GoFit</a
        ><button
          class="navbar-toggler"
          data-toggle="collapse"
          data-target="#navcol-1"
        >
          <span class="sr-only">Toggle navigation</span
          ><span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navcol-1">
          <ul class="nav navbar-nav">
            <li class="nav-item" role="presentation">
              <a class="nav-link active" href="index.php">GoFit</a>
            </li>
          </ul>

          <form class="form-inline mr-auto" target="_self"></form>
          <ul class="nav navbar-nav">
            <!-- <li class="nav-item dropdown">
              <a
                class="dropdown-toggle nav-link"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
                href="#"
                >Admin
              </a>
              <div class="dropdown-menu" role="menu">
                <a class="dropdown-item" role="presentation" href="#"
                  >Robertus Christopher - 200710780</a
                >
              </div>
            </li> -->
          </ul>

          <span class="navbar-text mr-2">
            <a href="page/loginPage.php" class="login"></a></span
          >
          <a
            class="btn btn-light action-button"
            role="button"
            href="{{url('/loginPage')}}"
            >Login</a
          >
        </div>
      </nav>
    </div>

    <div class="cover-container d-flex w-100 h-100 pt-5 mx-auto flex-column text-center bg">

      <main role="main" class="inner cover pt-5 mt-5">
        <h1 class="cover-heading pt-5 mt-5">GoFit</h1>
        <p class="lead">P3L 2023</p>
        <!-- <p class="lead">
          <a href="#" class="btn btn-lg btn-secondary">Learn more</a>
        </p> -->
      </main>

      <footer class="mastfoot mt-auto">
        <div class="inner">
          <p>P3L <b>@2023</b></p>
        </div>
      </footer>
    </div>
  </body>
</html>




