<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
    <link rel="icon" sizes="192x192" href="https://static.wixstatic.com/ficons/d9129e_749f5c855dba43088f012187e1c9e623%7Emv2.ico">
    <link href="<?php echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/css/style.css" rel="stylesheet" />
 <!--    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .card-style {
            border: 2px solid black;
            margin: 3px;
        }

        .img {
            height: 200px;
            width: 200px;
        }

        .main-heading {
            color: green;
            margin-left: 10%;
            margin-top: 50px;
            color: white;
            font-weight: bold;
            font-size: 35px;
        }

        .main-2-heading {
            color: green;
            margin-left: 10%;
            margin-top: 50px;
            color: white;
            font-size: 30px;
        }

        .first-div {
            height: 70px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .a-style {
            color: black;
            text-decoration: none;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/jquery.webui-popover/1.2.1/jquery.webui-popover.min.js"></script>

</head>

<body>
    <!-- //fixed-top -->
    <header class="header navbar-expand-lg">
        <div class="t-global">
            <div class="container-lg">
                <a href="http://www.token2049.com/">← TOKEN2049 GLOBAL</a>
            </div>

        </div>
        <div class="main">
            <div class="container-lg">

                <div class="header-left">
                    <a href="<?php echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/">
                        <img src="<?php echo $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] ?>/token2049/img/TOKEN_Transparent.webp" />
                    </a>
                </div>
                    <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon">
                             <i class="fa fa-bars" aria-hidden="true"><img src="img/menu-bar.png"></i>
                            <i class="fa fa-close"><img src="img/close-icon.svg"></i>
                        </span>
                    </button>
                <div class="header-right collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="https://www.asia.token2049.com/speakers" class="nav-link">SPEAKERS</a>
                        </li>
                        <li class="nav-item">
                            <a href="https://www.asia.token2049.com/agenda"class="nav-link">AGENDA</a>
                        </li>
                        <li class="nav-item">
                            <a href="https://www.asia.token2049.com/partners"class="nav-link">PARTNERS</a>
                        </li>
                        <li  class="nav-item">
                            <a href="https://www.asia.token2049.com/travel"class="nav-link">TRAVEL</a>
                        </li>
                        <li class="nav-item exhibt">
                            <a href="https://www.asia.token2049.com/partners" class="btn nav-link">EXHIBIT</a>
                            <a href="https://www.asia.token2049.com/tickets" class="btn bttn nav-link">TICKTES</a>
                        </li>
                    </ul>
                </div>
            </div>


        </div>
    </header>
