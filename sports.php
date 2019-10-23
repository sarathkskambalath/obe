<?php
// Include config file
require_once "php/config.php";
$_PHP_SELF   = $_SERVER['PHP_SELF'];
$REQUEST_URI = '';

if(isset($_SERVER['REQUEST_URI']) and !empty($_SERVER['REQUEST_URI'])){
 $REQUEST_URI = explode('?',$_SERVER['REQUEST_URI']);

 if(!empty($REQUEST_URI[1])){
   $_PHP_SELF.= "?".$REQUEST_URI[1];
 }

}

   $content = 'This is about us page content';
   //include('common/header.php');

   $pageno = 0;
   $limit  = 20;
   $category = '';
   $rows = array();

   $page         = 0;
   $rec_limit    = 20;
   $pagenolimit  = 2;
   $nuofpage     = 0;

    /* Get CATEGORY HERE */
    if(isset($_GET['category'])){
      $category = $_GET['category'];
    }
      $category = 'sports';

   /* Get total number of records */
   $sql = "SELECT count(id) FROM projects WHERE `category` = '".$category."' ;";
    $retval = mysqli_query( $link, $sql );

    if(! $retval ) {
       die('Could not get data: ' . mysqli_error());
    }
    $row = mysqli_fetch_array($retval, MYSQLI_NUM );
    $rec_count = $row[0];

    if($rec_count>=1){
      $nuofpage = $rec_count / $rec_limit;

      if( !empty(explode('.',$nuofpage)[1]) ){
        $nuofpage     = explode('.',$nuofpage)[0];
      }else {
        $nuofpage     = (explode('.',$nuofpage)[0])-1;
      }
    }

   if(isset($_GET['page'])){
     $page         = $_GET{'page'};
     $offset       = $rec_limit * $page ;
     $nuofpage     = $rec_count / $rec_limit;

     if( !empty(explode('.',$nuofpage)[1]) ){
       $nuofpage     = explode('.',$nuofpage)[0];
     }else {
       $nuofpage     = (explode('.',$nuofpage)[0])-1;
     }

   }else {
       $page         = 0;
       $offset       = 0;
    }

   $SRN = $offset;



   // Attempt select query execution
  $sql = "SELECT * FROM `projects` WHERE `category` = '".$category."' ORDER BY `id` DESC LIMIT ".$pageno.", ".$limit.";";

   if($result = mysqli_query($link, $sql)){

       if(mysqli_num_rows($result) > 0){

          while($row = mysqli_fetch_array($result)){
            $rows[] = $row;
          }

        }

  }

  // Close connection
  mysqli_close($link);
  ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Salahh Projects Showcase">
    <meta name="author" content="Salahh Projects Showcase">
    <meta name="keywords" content="Salahh Projects Showcase">

    <!-- Title Page-->
    <title>Salahh Projects Showcase</title>

    <!-- Icons font CSS-->
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="vendor/themify-font/themify-icons.css" rel="stylesheet" media="all">
    <!-- Base fonts of theme-->
    <link href="css/poppins-font.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->

    <!-- Bootstrap CSS-->
    <link href="vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="all">
    <link href="vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/main.min.css" rel="stylesheet" media="all">
        <link href="css/ligt-box" rel="stylesheet" media="all">
   <link href="css/lightbox.min.css" rel="stylesheet" media="all">

    <!--Favicons-->
    <link rel="shortcut icon" href="images/icon/favicon.jpg">
    <link rel="apple-touch-icon" href="apple-icon.html">
    <link rel="apple-touch-icon" sizes="72x72" href="apple-icon-72x72.html">
    <link rel="apple-touch-icon" sizes="114x114" href="apple-icon-114x114.html">
</head>

<body class="animsition js-preloader">
    <div class="page-wrapper bg-c2">
        <!-- HEADER-->
        <header id="header">
            <div class="header header-2 header-2--static d-none d-lg-block">
                <div class="header__bar">
                    <div class="container">
                        <div class="header__content">
                            <div class="logo">
                                <a href="#">
                                    <img src="images/icon/logo-white.png" alt="Tatee" />
                                </a>
                            </div>
                            <div class="header__content-right">
                                <button class="hamburger hamburger--slider float-right hamburger--sm js-menusb-btn" type="button">
                                    <span class="hamburger-box">
                                        <span class="hamburger-inner"></span>
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <aside class="menu-sidebar js-menusb" id="sidebar">
                <a class="btn-close" href="#" id="js-close-btn">
                    <span class="ti-close"></span>
                </a>
                <div class="menu-sidebar__content">
                    <nav class="menu-sidebar-nav-menu">
                        <ul class="menu nav-menu" id="nav-menu-sidebar">
                            <li class="menu-item menu-item-has-children">
                                <a href="#" data-toggle="collapse" data-target="#sub1" aria-expanded="true" aria-controls="sub1">Home</a>

                            </li>
                            <li class="menu-item">
                                <a href="#">About Me</a>
                            </li>
                            <li class="menu-item menu-item-has-children">
                                <a href="#" data-toggle="collapse" data-target="#sub2" aria-expanded="true" aria-controls="sub2">Project</a>

                            </li>

                            <li class="menu-item">
                                <a href="#">contact</a>
                            </li>
                        </ul>
                    </nav>
                    <ul class="list-social list-social--big">
                        <li class="list-social__item">
                            <a class="ic-fb" href="#">
                                <i class="zmdi zmdi-facebook"></i>
                            </a>
                        </li>
                        <li class="list-social__item">
                            <a class="ic-insta" href="#">
                                <i class="zmdi zmdi-instagram"></i>
                            </a>
                        </li>
                        <li class="list-social__item">
                            <a class="ic-twi" href="#">
                                <i class="zmdi zmdi-twitter"></i>
                            </a>
                        </li>
                        <li class="list-social__item">
                            <a class="ic-pinterest" href="#">
                                <i class="zmdi zmdi-pinterest"></i>
                            </a>
                        </li>
                        <li class="list-social__item">
                            <a class="ic-google" href="#">
                                <i class="zmdi zmdi-google"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="menu-sidebar__footer">
                    <div class="copyright">
                        <p>© 2018 Salahh . Designed by beagooduser.com</p>
                    </div>
                </div>
            </aside>
            <div id="menu-sidebar-overlay"></div>
            <div class="header-mobile header-mobile--light d-block d-lg-none">
                <div class="header-mobile__bar">
                    <div class="container-fluid">
                        <div class="header-mobile__bar-inner">
                            <a class="logo" href="index.html">
                                <img src="images/icon/logo-white.png" alt="Tatee" />
                            </a>
                            <button class="hamburger hamburger--slider float-right" type="button">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <nav class="header-nav-menu-mobile">
                    <div class="container-fluid">
                        <ul class="menu nav-menu menu-mobile">
                            <li class="menu-item menu-item-has-children">
                                <a href="#">Home</a>

                            </li>
                            <li class="menu-item">
                                <a href="about-us.html">about</a>
                            </li>
                            <li class="menu-item menu-item-has-children">
                                <a href="#">Project</a>

                            </li>
                            <li class="menu-item menu-item-has-children">
                                <a href="#">pages</a>

                            </li>
                            <li class="menu-item menu-item-has-children">
                                <a href="#">blog</a>

                            </li>
                            <li class="menu-item">
                                <a href="#">contact</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
        <!-- END HEADER-->

        <!-- MAIN-->
        <main id="main">
            <section class="p-t-40 p-b-45">
                <div class="container-fluid">
                    <div class="masonry-row ">
                        <div class="row ">

                           <?php

                            if(!empty($rows)){

                              foreach ($rows as $key => $row) {

                                $imagesArr = json_decode($row["images"]);
                                $imagesArr = array_reverse($imagesArr);

                                echo '<div class="col-md-6 col-lg-3 no-padding">
                                          <article class="media media-project-4 m-b-30">
                                              <figure class="media__img">
                                                  <a class="example-image-link" href="//' . $_SERVER['SERVER_NAME'] . '/jithin01/images/upload/' . @$imagesArr[0].'" data-lightbox="example-'.$row['id'].'">   <img class="example-image"  src="//' . $_SERVER['SERVER_NAME'] . '/jithin01/images/upload/' . @$imagesArr[0].'" alt="'.$row['title'].'" style="object-fit: cover;max-width: 335px; width: 335px;max-height: 188px;"/> </a>
                                              </figure>
                                              <div class="media__body">
                                                  <h3 class="media__title title--sm">
                                                      <a href="#">'.mb_strtoupper($row['title']).'</a>
                                                  </h3>
                                              </div>
                                          </article>
                                      </div>';
                                    }
                            }

                            ?>
                          </div>

                        </div>
                    </div>
                </div>
            </section>
        </main>
        <!-- END MAIN-->

        <!-- FOOTER-->
        <footer class="footer-3 p-b-5 p-t-20">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="footer-col">
                            <div class="widget">
                                <a href="#">
                                    <img src="images/icon/logo-white.png" alt="Tatee" />
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="footer-col">
                            <div class="widget">
                                <p class="text-center">Designed by beagooduser.com</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="footer-col">
                            <div class="widget">
                                <p class="text-center text-md-right">© 2019 Salahh . All rights reserved</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- END FOOTER-->
    </div>

    <!-- Jquery JS-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Vendor JS-->
    <script src="vendor/animsition/animsition.min.js"></script>
    <script src="vendor/slick/slick.min.js"></script>
    <script src="vendor/waypoints/jquery.waypoints.min.js"></script>
    <script src="vendor/wow/wow.min.js"></script>
    <script src="vendor/jquery.counterup/jquery.counterup.min.js"></script>
    <script src="vendor/isotope/isotope.pkgd.min.js"></script>
    <script src="vendor/isotope/imagesloaded.pkgd.min.js"></script>
    <script src="vendor/matchHeight/jquery.matchHeight-min.js"></script>
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/sweetalert/sweetalert.min.js"></script>
    <script src="vendor/noUiSlider/nouislider.min.js"></script>
     <script src="js/lightbox.js"></script>

    <!-- Main JS-->
    <script src="js/global.js"></script>

</body>

</html>
<!-- end document-->
