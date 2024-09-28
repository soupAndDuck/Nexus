<?php
session_start();
if (is_null($_SESSION["guest"])) {
  header("Location: ../guest-login.php");
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Homepage</title>
    <link rel="stylesheet" href="res/css/aboutStyle.css">
    <link rel="icon" href="assets/img/favicon.png" type="image/x-icon">
    <link href="assets/img/favicon.png" rel="icon">
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
    >
    <link
    href="https://fonts.googleapis.com/css?family=Inter"
    rel="stylesheet"
  />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    >
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.4/html5-qrcode.min.js"
      integrity="sha512-k/KAe4Yff9EUdYI5/IAHlwUswqeipP+Cp5qnrsUjTPCgl51La2/JhyyjNciztD7mWNKLSXci48m7cctATKfLlQ=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
    <!-- Boxicons CDN Link -->
    <link
      href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"
      rel="stylesheet"
    >
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  </head>
  <body>
<div id="app">    
<div id="sidebar_menu_bg"></div>
<div id="sidebar_menu">
    <button class="btn btn-radius btn-sm btn-secondary toggle-sidebar"><i class="fa fa-angle-left mr-2"></i>Close menu
    </button>
    <ul class="nav sidebar_menu-list">
        <li class="nav-item active"><a class="nav-link" href="scanner.php"
                                       title="Home">Home</a></li>
        <li class="nav-item">
            <div class="toggle-submenu" data-toggle="collapse" data-target="#sidebar_subs_genre" aria-expanded="false"
                 aria-controls="sidebar_subs_genre"></div>
            <div class="collapse multi-collapse sidebar_menu-sub" id="sidebar_subs_genre">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ethnic Groups
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Bontoc</a>
                        <a class="dropdown-item" href="#">Ibaloi</a>
                        <a class="dropdown-item" href="#">Ifugao</a>
                        <a class="dropdown-item" href="#">Kalanguya</a>
                        <a class="dropdown-item" href="#">Kankanaey</a>
                        <a class="dropdown-item" href="#">Isinai</a>
                        <a class="dropdown-item" href="#">Isneg</a>
                        <a class="dropdown-item" href="#">Itneg/Tingguian</a>
                        <a class="dropdown-item" href="#">Kalinga</a>
                    </div>
                </li> 
                <li class="nav-item active"><a class="nav-link" href="scanner.php"
                title="Home">About</a></li>  
                <div class="clearfix"></div>
            </div>
        </li>
    </ul>
    <div class="clearfix"></div>
</div>

    <div id="wrapper">
        <div id="header">
    <div class="container">
        <div id="mobile_menu"><i class="fa fa-bars"></i></div>
        <a href="scanner.php" id="logo"><img src="assets\img\logo.png" alt="Logo">
            
        </a>
        <!--Begin: Menu-->
        <div id="header_menu">
            <ul class="nav header_menu-list">
                <li class="nav-item"><a href="scanner.php" title="Home">Home</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Ethnic Groups
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Bontoc</a>
                        <a class="dropdown-item" href="#">Ibaloi</a>
                        <a class="dropdown-item" href="#">Ifugao</a>
                        <a class="dropdown-item" href="#">Kalanguya</a>
                        <a class="dropdown-item" href="#">Kankanaey</a>
                        <a class="dropdown-item" href="#">Isinai</a>
                        <a class="dropdown-item" href="#">Isneg</a>
                        <a class="dropdown-item" href="#">Itneg/Tingguian</a>
                        <a class="dropdown-item" href="#">Kalinga</a>
                    </div>
                </li>   
                </li>
                <li class="nav-item active"><a class="nav-link" href="about.php"
                title="Home">About</a></li> 
            </ul>
            <div class="clearfix"></div>
        </div>
        <!--End: Menu-->

        <div class="clearfix"></div>
    </div>
</div>

        <!--Begin: Main-->
        <div id="main-wrapper">
          <div>
            <h1>About Us</h1>
          </div>
        <!--End: Main-->
    </div>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.15.0/umd/popper.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.1.1/lazysizes.min.js"
        async></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>        
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.1.1/lazysizes.min.js"
        async></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/postscribe/2.0.8/postscribe.min.js"></script>
<script type="text/javascript"
        src="res/js/client/dances.js"></script>
</body>
</html>
