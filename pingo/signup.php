<?php
  session_start();
  $email = "";
  $name = "";
  $password = "";
  $confirm = "";
  $flag=0;
  if (empty($_POST['email'])||empty($_POST['name'])||empty($_POST['password'])||empty($_POST['confirm']))
    ;
  else {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    $mysqli=new mysqli('localhost','root','510051','pingo');
    if (mysqli_connect_errno()){
        $flag=3;
    }
    else{
      $result = $mysqli->query ("set names utf8");
      $query = "select * from customer where email =\"".$email."\"";
      $result = $mysqli->query ($query);
    
      if ($result->num_rows) {
        $mysqli->close();
        $flag=2;
      } 
      else {
        $query='insert into customer (email,name,password) values("'.$email.'","'.$name.'","'.sha1($password).'")';
        $result = $mysqli->query ($query);
        $mysqli->close();
        if ($result){
          $_SESSION['customer_email']=$email;
          header('Location: ./index.php');
          exit();
        }
        else {
          $flag=3;
        }
      }
    }
  }
?>


<!DOCTYPE html>
<!--[if lt IE 9 ]> <html lang="en" dir="ltr" class="no-js ie-old"> <![endif]-->
<!--[if IE 9 ]> <html lang="en" dir="ltr" class="no-js ie9"> <![endif]-->
<!--[if IE 10 ]> <html lang="en" dir="ltr" class="no-js ie10"> <![endif]-->
<!--[if (gt IE 10)|!(IE)]><!-->
<html lang="en" dir="ltr" class="no-js">
<!--<![endif]-->

<head>

  <!-- ––––––––––––––––––––––––––––––––––––––––– -->
  <!-- META TAGS                                 -->
  <!-- ––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <!-- Always force latest IE rendering engine -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Mobile specific meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

  <!-- ––––––––––––––––––––––––––––––––––––––––– -->
  <!-- PAGE TITLE                                -->
  <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <title>PINGO | Coupons, Deals, Discounts Popsite</title>

  <!-- ––––––––––––––––––––––––––––––––––––––––– -->
  <!-- SEO METAS                                 -->
  <!-- ––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="description" content="FRIDAY is a responsive multipurpose-ecommerce site template allows you to store coupons and promo codes from different brands and create store for deals, discounts, It can be used as coupon website such as groupon.com and also as online store">
  <meta name="black friday, coupon, coupon codes, coupon theme, coupons, deal news, deals, discounts, ecommerce, friday deals, groupon, promo codes, responsive, shop, store coupons">
  <meta name="robots" content="index, follow">
  <meta name="author" content="CODASTROID">

  <!-- ––––––––––––––––––––––––––––––––––––––––– -->
  <!-- PAGE FAVICON                              -->
  <!-- ––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="apple-touch-icon" href="assets/images/favicon/apple-touch-icon.png">
  <link rel="icon" href="assets/images/favicon/favicon.ico">

  <!-- ––––––––––––––––––––––––––––––––––––––––– -->
  <!-- GOOGLE FONTS                              -->
  <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600" rel="stylesheet">

  <!-- ––––––––––––––––––––––––––––––––––––––––– -->
  <!-- Include CSS Filess                        -->
  <!-- ––––––––––––––––––––––––––––––––––––––––– -->

  <!-- Bootstrap -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link href="assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

  <!-- Linearicons -->
  <link href="assets/vendors/linearicons/css/linearicons.css" rel="stylesheet">

  <!-- Owl Carousel -->
  <link href="assets/vendors/owl-carousel/owl.carousel.min.css" rel="stylesheet">
  <link href="assets/vendors/owl-carousel/owl.theme.min.css" rel="stylesheet">

  <!-- Flex Slider -->
  <link href="assets/vendors/flexslider/flexslider.css" rel="stylesheet">

  <!-- Template Stylesheet -->
  <link href="assets/css/base.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <script>
    function check()
      {
        if (document.getElementById("password").value==document.getElementById("confirm").value){
            document.getElementById("submit").disabled = false;
            document.getElementById("alert").style.display = "none";
        }
        else {
            document.getElementById("submit").disabled = true;
            document.getElementById("alert").style.display = "block";
        }
      }
  </script>
</head>

<body id="body" class="wide-layout preloader-active">





  <!--[if lt IE 9]>
        <p class="browserupgrade alert-error">
        	You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.
        </p>
    <![endif]-->

  <noscript>
        <div class="noscript alert-error">
            For full functionality of this site it is necessary to enable JavaScript. Here are the <a href="http://www.enable-javascript.com/" target="_blank">
		 instructions how to enable JavaScript in your web browser</a>.
        </div>
    </noscript>

  <!-- ––––––––––––––––––––––––––––––––––––––––– -->
  <!-- PRELOADER                                 -->
  <!-- ––––––––––––––––––––––––––––––––––––––––– -->
  <!-- Preloader -->
  <div id="preloader" class="preloader">
    <div class="loader-cube">
      <div class="loader-cube__item1 loader-cube__item"></div>
      <div class="loader-cube__item2 loader-cube__item"></div>
      <div class="loader-cube__item4 loader-cube__item"></div>
      <div class="loader-cube__item3 loader-cube__item"></div>
    </div>
  </div>
  <!-- End Preloader -->
  <!-- ––––––––––––––––––––––––––––––––––––––––– -->
  <!-- WRAPPER                                   -->
  <!-- ––––––––––––––––––––––––––––––––––––––––– -->
  <div id="pageWrapper" class="page-wrapper">
    <!-- –––––––––––––––[ HEADER ]––––––––––––––– -->
    <header id="mainHeader" class="main-header">

      <!-- Top Bar -->
      <div class="top-bar bg-gray">
        <div class="container">
          <div class="row">
            <div class="col-sm-12 col-md-4 is-hidden-sm-down">
              <ul class="nav-top nav-top-left list-inline t-left">
                <li><a href="terms_conditions.php"><i class="fa fa-question-circle"></i>Discounts Guide</a></li>
                <li><a href="faq.php"><i class="fa fa-support"></i>Customer Assistance</a></li>
              </ul>
            </div>
            <div class="col-sm-12 col-md-8">
              <ul class="nav-top nav-top-right list-inline t-xs-center t-md-right">
                <li><a href="signin.php"><i class="fa fa-lock"></i>Log In</a></li>
                <li><a href="signup.php"><i class="fa fa-user"></i>Sign Up</a></li>
                <li><a href="chinese-signup.php" style="font-family:'微软雅黑'"><i class="fa fa-paperclip"></i><b>中文</b></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <!-- End Top Bar -->

      <!-- Header Header -->
      <div class="header-header bg-white">
        <div class="container">
          <div class="row row-rl-0 row-tb-20 row-md-cell">
            <div class="brand col-md-3 t-xs-center t-md-left valign-middle">
              <a href="index.php" class="logo">
                <img src="assets/images/logo-1.png" alt="" width="250">
              </a>
            </div>
            <div class="header-search col-md-9">
              <div class="row row-tb-10 ">
                <div class="col-sm-8">
                  <form class="search-form">
                    <div class="input-group">
                      <input type="text" class="form-control input-lg search-input" placeholder="Enter Keywork Here ..." required="required">
                      <div class="input-group-btn">
                        <div class="input-group">
                          <div class="input-group-btn">
                            <button type="submit" class="btn btn-lg btn-search btn-block">
                                <i class="fa fa-search font-16"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="col-sm-4 t-xs-center t-md-right">
                    <div class="header-cart">
                        <a href="cart.php">
                            <span class="icon lnr lnr-cart"></span>
                            <div><span class="cart-number" id="cartnumber">0</span>
                            </div>
                            <span class="title">Cart</span>
                        </a>
                    </div>
                    <div class="header-wishlist ml-20">
                        <a href="pingo.php">
                            <span class="icon fa fa-file-text-o fa-1"></span>
                            <div><span class="cart-number" id="pingonumber">0</span>
                            </div>
                            <span class="title">Pingo</span>
                        </a>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End Header Header -->

                              <!-- Header Menu -->
            <div class="header-menu bg-blue">
                <div class="container">
                    <nav class="nav-bar">
                        <div class="nav-header">
                            <span class="nav-toggle" data-toggle="#header-navbar">
		                        <i></i>
		                        <i></i>
		                        <i></i>
		                    </span>
                        </div>
                        <div id="header-navbar" class="nav-collapse">
                            <ul class="nav-menu">
                                <li class="active">
                                    <a href="index.php">Home</a>
                                </li>
                                <li>
                                    <a href="coupons_grid.php">Clothing&Shoes </a>
                                    <ul>
                                        <li><a href="coupons_grid.php">Clothing</a>
											<ul>
											<li><a href="coupons_grid_sidebar.php">Women</a></li>
											<li><a href="coupons_list.php">Men</a> </li>
											<li><a href="coupons_list.php">Sports</a> </li>
											<li><a href="coupons_list.php">Underclothes</a> </li>
											<li><a href="coupons_list.php">Suit</a> </li>
											</ul>
                                        </li>
                                        <li><a href="coupons_grid_sidebar.php">Shoes</a>
                                        </li>
                                        <li><a href="coupons_list.php">Bags & Luggages</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="coupons_grid.php">Household</a>
                                    <ul>
                                        <li><a href="coupons_grid.php">Home Supplies</a></li>
                                        <li><a href="coupons_grid_sidebar.php">Home Improvement</a></li>
                                        <li><a href="coupons_list.php">Kitchen</a></li>
										<li><a href="coupons_list.php">Pet Supplies</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="stores_01.php">Toys & Kids</a>
                                    <ul>
                                        <li><a href="stores_01.php">Toys</a> </li>
                                        <li><a href="stores_02.php">Baby Products</a></li>   
                                    </ul>
                                </li>
                                <li>
                                    <a href="contact_us_01.php">Watches</a>
                                    <ul>
                                        <li><a href="contact_us_01.php">Watches</a></li>
                                        <li><a href="contact_us_02.php">Jewellery</a></li>
										<li><a href="contact_us_02.php">Accessories</a>
											<ul>
												<li><a href="contact_us_02.php">Necklace</a></li>
												<li><a href="contact_us_02.php">Earrings</a></li>
												<li><a href="contact_us_02.php">scarf</a></li>
												<li><a href="contact_us_02.php">Brooch</a></li>
											</ul>
										</li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">Electronics</a>
                                    <ul>
                                        <li><a href="blog_single_standard.php">TV video & Audio</a></li>
										<li><a href="blog_single_standard.php">Large Appliance</a></li>
										<li><a href="blog_single_standard.php">Home Appliances</a></li>
										<li><a href="blog_single_standard.php">Kindles</a></li>
									</ul>
                                                
                                </li>
                                <li>
                                    <a href="#">Books</a>
                                    <ul>
                                        <li><a href="blog_single_standard.php">Chinese-book</a></li>
										<li><a href="blog_single_standard.php">Foregin-book</a></li>
										<li><a href="blog_single_standard.php">Textbooks</a></li>
										<li><a href="blog_single_standard.php">Kindle-tbooks</a></li>
										<li><a href="blog_single_standard.php">imported-books</a></li>
									</ul>
                                           
                        </div>
                        <div class="nav-menu nav-menu-fixed">
                            <a href="products.php">Try Now</a>
                        </div>
                    </nav>
                </div>
            </div>
            <!-- End Header Menu -->

    </header>
    <!-- –––––––––––––––[ HEADER ]––––––––––––––– -->

    <!-- –––––––––––––––[ PAGE CONTENT ]––––––––––––––– -->
    <main id="mainContent" class="main-content">
      <div class="page-container ptb-60">
        <div class="container">
          <div class="container" style="width:450px;text-align:center">
            <section class="panel p-40">
              <h3 class="sign-title" style="text-align:center">Sign Up <small>Or <a href="./signin.php" class="color-green">Log In</a></small></h3>
              <hr style="width:70%">
              <div class="row">
                <form class="" action="./signup.php" method="post">
                  <?php
                    if ($flag==2){
                      echo '<div class="form-group has-error">
                    <label class="sr-only">Email</label>
                      <input type="email" name="email" class="form-control input-lg" placeholder="Email" maxlength="32" aria-describedby="helpBlock" autofocus required>
                      <span class="help-block" id="helpBlock" style="text-align:left">&nbsp;&nbsp;The email has already signed up</span>
                    </div>';
                    }
                    else {
                    echo '<div class="form-group">
                            <label class="sr-only">Email</label>
                            <input type="email" name="email" class="form-control input-lg" placeholder="Email" maxlength="32" value="'.$email.'" autofocus required>
                          </div>';
                    }
                  ?>
                  
                  <div class="form-group">
                    <label class="sr-only">Full Name</label>
                    <input type="text" name="name" class="form-control input-lg" placeholder="Full Name" maxlength="32" <?php echo'value="'.$name.'"'?>  required>
                  </div>
                  <div class="form-group">
                    <label class="sr-only">Password</label>
                    <input type="password" name="password" id="password" class="form-control input-lg" onkeyup="check()" placeholder="Password" maxlength="32" minlength="6" <?php echo'value="'.$password.'"'?> required>
                  </div>
                  <div class="form-group">
                    <label class="sr-only">Confirm Password</label>
                    <input type="password" name="confirm" id="confirm" class="form-control input-lg" onkeyup="check()" placeholder="Confirm Password" maxlength="32" minlength="6" <?php echo'value="'.$confirm.'"'?> required>
                  </div>
                  <div class="alert alert-warning" id="alert" role="alert" style="display:none;height:45px;padding-top:8px">
                    <!--<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>-->
                    The password you typed twice did't match 
                  </div>
                  <div class="custom-checkbox mb-20">
                    <input type="checkbox" id="agree_terms" checked onchange>
                    <label class="color-mid" for="agree_terms">I agree to the <a href="terms_conditions.php" class="color-green">Terms of Use</a> and <a href="terms_conditions.php" class="color-green">Privacy Statement</a>.</label>
                  </div>
                  <button id="submit" type="submit" class="btn btn-block btn-lg">Sign Up</button>
                </form>
              </div>
            </section>
          </div>
        </div>
      </div>


    </main>
<!-- –––––––––––––––[ END PAGE CONTENT ]––––––––––––––– -->
        <section class="footer-top-area pt-40 pb-10 pos-r bg-blue">
            <div class="container">
                <div class="row row-tb-20">
                    <div class="col-sm-12 col-md-7">
                        <div class="row row-tb-20">
                            <div class="footer-col col-sm-6">
                                <div class="footer-about">
                                    <img class="mb-30" src="assets/images/brand.png" width="250" alt="">
                                    <p class="color-light">Have deals and coupons:The Products have coupons;Find best offers:We can help you find the best add-on item;Save your money:Enjoy the offer  </p>
									<!-- <p class="color-light">Ⅱ.Find best offers:We can help you find the best add-on item.  </p>
									<p class="color-light">Ⅲ.Save your money:Enjoy the offer  </p> -->
                                </div>
                            </div>
                            <div class="footer-col col-sm-6">
                                <div class="footer-top-twitter">
                                    <h2 class="color-lighter">Weibo Feed</h2>
                                    <ul class="twitter-list">
                                        <li class="single-twitter">
                                            <p class="color-light"><i class="ico fa fa-weibo"></i><a href="#">@masum_rana :</a> The Offical Sina Weibo accounts.</p>
                                        </li>
										<li class="single-twitter">
                                            <p class="color-light"><i class="ico fa fa-weibo"></i><a href="#">@masum_rana :</a> The Offical Sina Weibo accounts.</p>
                                        </li>
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-5">
                        <div class="row row-tb-20">
                            <div class="footer-col col-sm-6">
                                <div class="footer-links">
                                    <h2 class="color-lighter">Quick Links</h2>
                                    <ul>
                                        <li><a href="products.php">Newest Coupons</a>
                                        </li>
                                        <li><a href="terms_conditions.php">Terms of Use</a>
                                        </li>
                                        <li><a href="faq.php">FAQs</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="footer-col col-sm-6">
                                <div class="footer-top-instagram instagram-widget">
                                    <h2> Widget</h2>
                                    <div class="row row-tb-5 row-rl-5">


                                        <div class="instagram-widget__item col-xs-4">
                                            <img src="assets/images/instagram/instagram_01.jpg" alt="">
                                        </div>


                                        <div class="instagram-widget__item col-xs-4">
                                            <img src="assets/images/instagram/instagram_02.jpg" alt="">
                                        </div>


                                        <div class="instagram-widget__item col-xs-4">
                                            <img src="assets/images/instagram/instagram_03.jpg" alt="">
                                        </div>


                                        <div class="instagram-widget__item col-xs-4">
                                            <img src="assets/images/instagram/instagram_04.jpg" alt="">
                                        </div>


                                        <div class="instagram-widget__item col-xs-4">
                                            <img src="assets/images/instagram/instagram_05.jpg" alt="">
                                        </div>


                                        <div class="instagram-widget__item col-xs-4">
                                            <img src="assets/images/instagram/instagram_06.jpg" alt="">
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>
        <!-- –––––––––––––––[ FOOTER ]––––––––––––––– -->
        <footer id="mainFooter" class="main-footer">
            <div class="container">
                <div class="row">
                    <p>Copyright &copy; 2017 . All rights reserved.</p>
                </div>
            </div>
        </footer>
        <!-- –––––––––––––––[ END FOOTER ]––––––––––––––– -->


  </div>
  <!-- ––––––––––––––––––––––––––––––––––––––––– -->
  <!-- END WRAPPER                               -->
  <!-- ––––––––––––––––––––––––––––––––––––––––– -->


  <!-- ––––––––––––––––––––––––––––––––––––––––– -->
  <!-- BACK TO TOP                               -->
  <!-- ––––––––––––––––––––––––––––––––––––––––– -->
  <div id="backTop" class="back-top is-hidden-sm-down">
    <i class="fa fa-angle-up" aria-hidden="true"></i>
  </div>

  <!-- ––––––––––––––––––––––––––––––––––––––––– -->
  <!-- SCRIPTS                                   -->
  <!-- ––––––––––––––––––––––––––––––––––––––––– -->

  <!-- (!) Placed at the end of the document so the pages load faster -->

  <!-- ––––––––––––––––––––––––––––––––––––––––– -->
  <!-- Initialize jQuery library                 -->
  <!-- ––––––––––––––––––––––––––––––––––––––––– -->
  <script src="assets/js/jquery-1.12.3.min.js"></script>

  <!-- ––––––––––––––––––––––––––––––––––––––––– -->
  <!-- Latest compiled and minified Bootstrap    -->
  <!-- ––––––––––––––––––––––––––––––––––––––––– -->
  <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>

  <!-- ––––––––––––––––––––––––––––––––––––––––– -->
  <!-- JavaScript Plugins                        -->
  <!-- ––––––––––––––––––––––––––––––––––––––––– -->
  <!-- (!) Include all compiled plugins (below), or include individual files as needed -->

  <!-- Modernizer JS -->
  <script src="assets/vendors/modernizr/modernizr-2.6.2.min.js"></script>

  <!-- Owl Carousel -->
  <script type="text/javascript" src="assets/vendors/owl-carousel/owl.carousel.min.js"></script>

  <!-- FlexSlider -->
  <script type="text/javascript" src="assets/vendors/flexslider/jquery.flexslider-min.js"></script>

  <!-- Coutdown -->
  <script type="text/javascript" src="assets/vendors/countdown/jquery.countdown.js"></script>

  <!-- ––––––––––––––––––––––––––––––––––––––––– -->
  <!-- Custom Template JavaScript                   -->
  <!-- ––––––––––––––––––––––––––––––––––––––––– -->
  <script type="text/javascript" src="assets/js/main.js"></script>
</body>

</html>