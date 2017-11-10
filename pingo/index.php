<?php
  session_start();
  if (empty($_SESSION['customer_email']) && !empty($_COOKIE["customer_email"]))
  {
    $_SESSION['customer_email']=$_COOKIE["customer_email"];
  }
  if (!empty($_SESSION["customer_email"])){
    $email = $_SESSION["customer_email"];
    $mysqli=new mysqli('localhost','root','510051','pingo');
    if (mysqli_connect_errno()){
        echo "database failure";
        exit();
    }
    else{
        $result = $mysqli->query ("set names utf8");
        $pingonumber=0;
        $cartnumber=0;
        $query = 'select count(*) as total from cart where customer_email="'.$email.'"';
        $result = $mysqli->query ($query);
        $row = mysqli_fetch_array($result);
        $cartnumber = $row["total"];
        $query = 'select count(*) as total from pingo where customer_email="'.$email.'"';
        $result = $mysqli->query ($query);
        $row = mysqli_fetch_array($result);
        $pingonumber = $row["total"];
    }
    $mysqli->close();
  }
  else {
      $cartnumber=0;
      $pingonumber=0;
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
    <meta name="	black friday, coupon, coupon codes, coupon theme, coupons, deal news, deals, discounts, ecommerce, friday deals, groupon, promo codes, responsive, shop, store coupons">
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
    function recvmsg()
    {
        $.ajax({
          url:'/pingo/get_message.php',
          type:'post',
          dataType:'json',
          success:function(data){
              var message= "";

            for(var i=0;i<data.length;i++){   
               if (data[i].type=="0"){
                   alert("you have pingo failed");
               }
               else if (data[i].type=="1"){
                   alert("you have pingo all agreed,you can pay now");
               }
               else if (data[i].type=="2"){
                   alert("your pingo succeed ,see it in orders");
               }
            }
          }//,
        //   error:function(XMLHttpRequest, textStatus, errorThrown) {
        //   //这个error函数调试时非常有用，如果解析不正确，将会弹出错误框
        //     alert(XMLHttpRequest.responseText); 
        //     alert(XMLHttpRequest.status);
        //     alert(XMLHttpRequest.readyState);
        //     alert(textStatus); // parser error;
        //   }
      });

    }
    window.onload = function()
    {
        setInterval("recvmsg()",2000);
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
                                <?php
                                    if (empty($_SESSION["customer_email"]))
                                        echo'<li><a href="signin.php"><i class="fa fa-lock"></i>Log In</a></li>
                                            <li><a href="signup.php"><i class="fa fa-user"></i>Sign Up</a></li>';
                                    else 
                                        echo'<li>
                                                <a href="message.php"><i class="fa fa-envelope-o"></i>Messgae <i class="fa fa-caret-down"></i></a>	
                                                <ul>
                                                    <li><a href="message.php">Agreed Order<span class="successful-number">2</span></a></li>
                                                    <li><a href="message_new.php">New Order<span class="handling-number">1</span></a></li>
                                                </ul>
                                            </li>
                                            <li><a href="./address.php"><i class="fa fa-user"></i>'.$_SESSION["customer_email"].' <i class="fa fa-caret-down"></i></a>
                                                <ul>
                                                    <li style="border-bottom:1px solid #E9EBEE"><a href="./address.php">Account Settings</a></li>
                                                    <li><a href="logout.php">Log out</a></li>
                                                </ul>
                                            </li>'
                                ?>
								<li><a href="chinese-index.php" style="font-family:'微软雅黑'"><i class="fa fa-paperclip"></i><b>中文</b></a></li>
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
                                    <form class="search-form" method="get" action="products.php">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control input-lg search-input" placeholder="Enter Keywork Here ..." required="required">
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
                                            <div><span class="cart-number" id="cartnumber"><?php echo $cartnumber?></span>
                                            </div>
                                            <span class="title">Cart</span>
                                        </a>
                                    </div>
                                    <div class="header-wishlist ml-20">
                                        <a href="pingo.php">
                                            <span class="icon fa fa-file-text-o fa-1"></span>
                                            <div><span class="cart-number" id="pingonumber"><?php echo $pingonumber?></span>
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

        </header>
        <!-- –––––––––––––––[ HEADER ]––––––––––––––– -->

        <!-- –––––––––––––––[ PAGE CONTENT ]––––––––––––––– -->
        <main id="mainContent" class="main-content">
            <div class="page-container ptb-10">
                <div class="container">
                    <div class="section deals-header-area ptb-30">
                        <div class="row row-tb-20">
                            <div class="col-xs-12 col-md-4 col-lg-3">
                                <aside>
                                    <ul class="nav-coupon-category panel">
                                        <li><a href="./products.php?kind=food"><i class="fa fa-cutlery"></i>Food &amp; Drink<span>40</span></a>
                                        </li>
                                        <li><a href="./products.php?kind=electronic"><i class="fa fa-calendar"></i>Electronics<span>42</span></a>
                                        </li>
                                        <li><a href="./products.php?kind=clothes"><i class="fa fa-female"></i>Clothing<span>48</span></a>
                                        </li>
                                        <li><a href="./products.php?kind=fitness"><i class="fa fa-bolt"></i>Fitness<span>33</span></a>
                                        </li>
                                        <li><a href="./products.php?kind=furniture"><i class="fa fa-home"></i>Furniture<span>50</span></a>
                                        </li>
                                        <li><a href="./products.php?kind=fashion"><i class="fa fa-umbrella"></i>Fashion<span>33</span></a>
                                        </li>
                                        <li><a href="./products.php?kind=books"><i class="fa fa-book"></i>Books<span>37</span></a>
                                        </li>
                                        <li><a href="./products.php?kind=home"><i class="fa fa-building"></i>Home &amp; Graden<span>30</span></a>
                                        </li>
                                        <li><a href="./products.php?kind=travel"><i class="fa fa-plane"></i>Travel<span>48</span></a>
                                        </li>
                                        <li class="all-cat">
                                            <a class="font-14" href="./products.php">All Commodities</a>
                                        </li>
                                    </ul>
                                </aside>
                            </div>
                            <div class="col-xs-12 col-md-8 col-lg-9">
                                <div class="header-deals-slider owl-slider" data-loop="true" data-autoplay="true" data-autoplay-timeout="10000" data-smart-speed="1000" data-nav-speed="false" data-nav="true" data-xxs-items="1" data-xxs-nav="true" data-xs-items="1" data-xs-nav="true" data-sm-items="1" data-sm-nav="true" data-md-items="1" data-md-nav="true" data-lg-items="1" data-lg-nav="true">

                                    <div class="deal-single panel item">
                                        <figure class="deal-thumbnail embed-responsive embed-responsive-16by9" data-bg-img="assets/images/deals/deal_01.jpg">
                                             <div class="label-discount top-10 right-10">-￥50</div>
                                            <ul class="deal-actions top-10 left-10">
                                                <li class="like-deal">
                                                    <span><i class="fa fa-heart"></i></span>
                                                </li>
                                                <li class="share-btn">
                                                    <div class="share-tooltip fade">
                                                        <a target="_blank" href="#"><i class="fa fa-facebook"></i></a>
                                                        <a target="_blank" href="#"><i class="fa fa-twitter"></i></a>
                                                        <a target="_blank" href="#"><i class="fa fa-google-plus"></i></a>
                                                        <a target="_blank" href="#"><i class="fa fa-pinterest"></i></a>
                                                    </div>
                                                    <span><i class="fa fa-share-alt"></i></span>
                                                </li>
                                                <li>
                                                    <span><i class="fa fa-camera"></i> </span>
                                                </li>
                                            </ul>
                                            <div class="deal-about p-20 pos-a bottom-0 left-0"> 
												<div class="rating mb-10">
                                                    <span class="rating-stars" data-rating="5">
														<i class="fa fa-star-o star-active"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
													</span>
                                                    <span class="rating-reviews color-light">( <span class="rating-count"> ￥132</span>)</span>
                                                </div>
                                                <h3 class="deal-title mb-10 "><a href="products.php" class="color-light color-h-lighter">The Crash Bad Instant Folding Twin Bed</a></h3>
                                            </div>
                                        </figure>
                                    </div>
                                    <div class="deal-single panel item">
                                        <figure class="deal-thumbnail embed-responsive embed-responsive-16by9" data-bg-img="assets/images/deals/deal_02.jpg">
                                            <div class="label-discount top-10 right-10">-￥30</div>
                                            <ul class="deal-actions top-10 left-10">
                                                <li class="like-deal">
                                                    <span><i class="fa fa-heart"></i></span>
                                                </li>
                                                <li class="share-btn">
                                                    <div class="share-tooltip fade">
                                                        <a target="_blank" href="#"><i class="fa fa-facebook"></i></a>
                                                        <a target="_blank" href="#"><i class="fa fa-twitter"></i></a>
                                                        <a target="_blank" href="#"><i class="fa fa-google-plus"></i></a>
                                                        <a target="_blank" href="#"><i class="fa fa-pinterest"></i></a>
                                                    </div>
                                                    <span><i class="fa fa-share-alt"></i></span>
                                                </li>
                                                <li><span><i class="fa fa-camera"></i></span>
                                                </li>
                                            </ul>
                                            <div class="deal-about p-20 pos-a bottom-0 left-0">
                                                <div class="rating mb-10">
                                                    <span class="rating-stars" data-rating="5">
														<i class="fa fa-star-o star-active"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
													</span>
                                                    <span class="rating-reviews color-light">( <span class="rating-count">￥132</span>)</span>
                                                </div>
                                                <h3 class="deal-title mb-10 "><a href="products.php" class="color-light color-h-lighter">Western Digital USB 3.0 Hard Drives</a></h3>
                                            </div>
                                        </figure>
                                    </div>
                                    <div class="deal-single panel item">
                                        <figure class="deal-thumbnail embed-responsive embed-responsive-16by9" data-bg-img="assets/images/deals/deal_03.jpg">
                                            <div class="label-discount top-10 right-10">-￥30</div>
                                            <ul class="deal-actions top-10 left-10">
                                                <li class="like-deal">
                                                    <span><i class="fa fa-heart"></i></span>
                                                </li>
                                                <li class="share-btn">
                                                    <div class="share-tooltip fade">
                                                        <a target="_blank" href="#"><i class="fa fa-facebook"></i></a>
                                                        <a target="_blank" href="#"><i class="fa fa-twitter"></i></a>
                                                        <a target="_blank" href="#"><i class="fa fa-google-plus"></i></a>
                                                        <a target="_blank" href="#"><i class="fa fa-pinterest"></i></a>
                                                    </div>
                                                    <span><i class="fa fa-share-alt"></i></span>
                                                </li>
                                                <li>
                                                    <span><i class="fa fa-camera"></i></span>
                                                </li>
                                            </ul>
                                            <div class="deal-about p-20 pos-a bottom-0 left-0">
                                                <div class="rating mb-10">
                                                    <span class="rating-stars" data-rating="5">
														<i class="fa fa-star-o star-active"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
														<i class="fa fa-star-o"></i>
													</span>
                                                    <span class="rating-reviews color-light">( <span class="rating-count">￥160</span>)</span>
                                                </div>
                                                <h3 class="deal-title mb-10 "><a href="products.php" class="color-light color-h-lighter">Hampton Bay LED Light Ceiling Exhaust Fan</a></h3>
                                            </div>
                                        </figure>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="section explain-process-area ptb-30">
                        <div class="row row-rl-10">
                            <div class="col-md-4">
                                <div class="item panel prl-15 ptb-20">
                                    <div class="row row-rl-5 row-xs-cell">
                                        <div class="col-xs-4 valign-middle">
                                            <img class="pr-10" src="assets/images/icons/tablet.png" alt="">
                                        </div>
                                        <div class="col-xs-8">
                                            <h5 class="mb-10 pt-5">Deals & Coupons</h5>
                                            <p class="color-mid">Some products have coupon The coupons are limited off like 20 off for every 199 payment.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="item panel prl-15 ptb-20">
                                    <div class="row row-rl-5 row-xs-cell">
                                        <div class="col-xs-4 valign-middle">
                                            <img class="pr-10" src="assets/images/icons/online-shop-6.png" alt="">
                                        </div>
                                        <div class="col-xs-8">
                                            <h5 class="mb-10 pt-5">Find Best Offers</h5>
                                            <p class="color-mid">We can help you find the eligible customers to share the coupons with you.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="item panel prl-15 ptb-20">
                                    <div class="row row-rl-5 row-xs-cell">
                                        <div class="col-xs-4 valign-middle">
                                            <img class="pr-10" src="assets/images/icons/money.png" alt="">
                                        </div>
                                        <div class="col-xs-8">
                                            <h5 class="mb-10 pt-5">Save Money</h5>
                                            <p class="color-mid">If the add-on item is completed, you can save money.It depends on how much you pay.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--主页商品展示-->
                    <section class="section latest-deals-area ptb-30">
                        <header class="panel ptb-15 prl-20 pos-r mb-30">
                            <h3 class="section-title font-18">Latest Deals</h3>
                            <a href="#" class="more-link btn btn-link right-10 pos-tb-center">more <i class="icon fa fa-long-arrow-right right"></i></a>
                        </header>

                        <div class="row row-masnory row-tb-20">
                           <div class="col-sm-3 col-lg-3 col-ml-3">
									<div class="deal-single panel">
										<figure class="entry panel entry-media post-thumbnail embed-responsive embed-responsive-4by3">
                                        <div class="entry-date">
                                            <h4>-10</h4>
                                            <h6>100</h6>
                                        </div>
										<img src="assets/images/product/food/1-chips.png" alt="product"> 
                                    </figure>
										<div class="bg-white pt-20 pl-20 pr-15">
											<div class="pr-md-10">
												<h5 class="deal-title mb-10">
													<a class="product-display" href="#" style="white-space:nowrap;text-overflow:ellipsis" title="Anjou Organic Coconut Oil, Cold Pressed Unrefined, Extra Virgin for Beauty, Cooking, Health">Anjou Organic Coconut Oil, Cold Pressed Unrefined, Extra Virgin for Beauty, Cooking, Health</a>
												</h5>
												<div class="deal-price pos-r ">
													<h5 class="price text-right color-orange">￥39</h5>
												</div>
											</div>
										</div>
										<div class="showcode mt-10">
											<button class="show-code btn btn-sm btn-block" data-toggle="modal" data-target="#coupon_12">Add in Cart</button>
											<div class="coupon-hide"></div>
										</div>
									</div>
                            </div>
							<div class="col-sm-3 col-lg-3 col-ml-3">
									<div class="deal-single panel">
										<figure class="entry panel entry-media post-thumbnail embed-responsive embed-responsive-4by3">
                                        <div class="entry-date">
                                            <h4>-20</h4>
                                            <h6>199</h6>
                                        </div>
										<img src="assets/images/product/clothes/18-skirt.png" alt="product"> 
                                    </figure>
										<div class="bg-white pt-20 pl-20 pr-15">
											<div class="pr-md-10">
												<h5 class="deal-title mb-10">
													<a class="product-display" href="#" title="GRACE KARIN Women Pleated Vintage Skirts Floral Print CL6294">GRACE KARIN Women Pleated Vintage Skirts Floral Print CL6294</a>
												</h5>
												<div class="deal-price pos-r ">
													<h5 class="price text-right color-orange">￥169</h5>
												</div>
											</div>
										</div>
										<div class="showcode mt-10">
											<button class="show-code btn btn-sm btn-block" data-toggle="modal" data-target="#coupon_12">Add in Cart</button>
											<div class="coupon-hide"></div>
										</div>
									</div>
                            </div>
							<div class="col-sm-3 col-lg-3 col-ml-3">
									<div class="deal-single panel">
										<figure class="entry panel entry-media post-thumbnail embed-responsive embed-responsive-4by3">
                                        <div class="entry-date">
                                            <h4>-20</h4>
                                            <h6>199</h6>
                                        </div>
										<img src="assets/images/product/electronic/10-usb.png" alt="product"> 
                                    </figure>
										<div class="bg-white pt-20 pl-20 pr-15">
											<div class="pr-md-10">
												<h5 class="deal-title mb-10">
													<a class="product-display" href="#" title="Apple Certified Lightning to USB Cable - 6 Feet (1.8 Meters) - White"> Apple Certified Lightning to USB Cable - 6 Feet (1.8 Meters) - White</a>
												</h5>
												<div class="deal-price pos-r ">
													<h5 class="price text-right color-orange">￥13</h5>
												</div>
											</div>
										</div>
										<div class="showcode mt-10">
											<button class="show-code btn btn-sm btn-block" data-toggle="modal" data-target="#coupon_12">Add in Cart</button>
											<div class="coupon-hide"></div>
										</div>
									</div>
                            </div>
							<div class="col-sm-3 col-lg-3 col-ml-3">
									<div class="deal-single panel">
										<figure class="entry panel entry-media post-thumbnail embed-responsive embed-responsive-4by3">
                                        <div class="entry-date">
                                            <h4>-30</h4>
                                            <h6>299</h6>
                                        </div>
										<img src="assets/images/product/clothes/17-tee.png" alt="product"> 
                                    </figure>
										<div class="bg-white pt-20 pl-20 pr-15">
											<div class="pr-md-10">
												<h5 class="deal-title mb-10">
													<a class="product-display" href="#"title="Lucky Brand Women's Floral Triangle Tee">Lucky Brand Women's Floral Triangle Tee</a>
												</h5>
												<div class="deal-price pos-r ">
													<h5 class="price text-right color-orange">￥169</h5>
												</div>
											</div>
										</div>
										<div class="showcode mt-10">
											<button class="show-code btn btn-sm btn-block" data-toggle="modal" data-target="#coupon_12">Add in Cart</button>
											<div class="coupon-hide"></div>
										</div>
									</div>
                            </div>
							
                        </div>
                    </section>

                    <section class="section subscribe-area ptb-40 t-center">
                        <div class="newsletter-form">
                            <h4 class="mb-20"><i class="fa fa-envelope-o color-green mr-10"></i>Sign up for our weekly email newsletter</h4>
                            <!-- <p class="mb-20 color-mid">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi animi magni accusantium architecto possimus.</p> -->
                            <form method="post" action="#">
                                <div class="input-group mb-10">
                                    <input type="email" class="form-control bg-white" placeholder="Email Address" required="required">
                                    <span class="input-group-btn">
                                        <button class="btn" type="submit">Subscribe</button>
                                    </span>
                                </div>
                            </form>
                            <p class="color-muted"><small>We’ll never share your email address with a third-party.</small> </p>
                        </div>
                    </section>
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
    <script src="assets/js/jquery.form.js"></script>
    <script src="assets/js/json2.js"></script>
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
