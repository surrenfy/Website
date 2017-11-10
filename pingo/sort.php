<?php
    session_start();
    if (empty($_SESSION['customer_email']))
    {
        $_SESSION["header"]='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        header('Location: ./signin.php?flag=1');
        exit();
    }
    if (empty($_POST['id']))
    {
        header('Location: ./pingo.php');
        exit();
    }
    $email = $_SESSION['customer_email'];
    $id    = $_POST['id'];
    $mysqli=new mysqli('localhost','root','510051','pingo');
    if (mysqli_connect_errno()){
        header('Location: ./signin.php?flag=1');
        exit();
    }
    else{
        $result = $mysqli->query ("set names utf8");
        $query = 'select count(*) as total from cart where customer_email="'.$email.'"';
        $result = $mysqli->query ($query);
        $row = mysqli_fetch_array($result);
        $cartnumber = $row["total"];
        $query = 'select count(*) as total from pingo where customer_email="'.$email.'"';
        $result = $mysqli->query ($query);
        $row = mysqli_fetch_array($result);
        $pingonumber = $row["total"];
        $query = 'select lim,off,price,quantity from (pingo left join (product left join packet on product.id=product_id) on product.id=pingo.product_id) where pingo.id="'.$id.'"';
        $result = $mysqli->query ($query);
        $row = mysqli_fetch_array($result);
        $lim = $row["lim"];
        $off = $row["off"];
        $price = $row["price"];
        $quantity = $row["quantity"];
        $original = $quantity*$price;
        $left = $lim - $original;
        if ($left <0)
            $left = 0;
        $query = 'select pingo.id as pingo_id,customer.email as email,customer.name as customer_name,province,price,quantity from (customer right join (addr right join (pingo left join (product left join packet on product.id=product_id) on product.id=pingo.product_id) on pingo.addr_id = addr.id) on addr.customer_email = customer.email) where lim='.$lim.' and off='.$off.' and pingo.id <>"'.$id.'" order by quantity*price asc';
        $result = $mysqli->query ($query);
        $mysqli->close();
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

</head>
<script type="text/javascript">
    var left = <?php echo $left?>;
    var original = <?php echo $original?>;
    var lim = <?php echo $lim?>;
    var off = <?php echo $off?>;
    
    function select(id)
    {
        var ribbon = document.getElementById('ribbon_'+id);
        if (ribbon.style.display=="none"){
            ribbon.style.display="block";
            left -= parseFloat(document.getElementById('order_total_'+id).innerHTML);
            var progress = document.getElementById("progress");
            var myinput = document.createElement("input"); 
            myinput.id  ="pingo_"+id;
            myinput.type="text";
            myinput.name = "id[]";
            myinput.value = id;
            myinput.style.display="none";
            progress.appendChild(myinput);
            if (left<=0){
                document.getElementById('save').innerHTML= (original/(lim-left)*off).toFixed(2);
                document.getElementById('left').innerHTML= "0";
                document.getElementById('subscribe').disabled= false;
            }
            else{
                document.getElementById('save').innerHTML= (original/(lim-left)*off).toFixed(2);
                document.getElementById('left').innerHTML= left;
                document.getElementById('subscribe').disabled= true;
            }
        }
        else
        {
            ribbon.style.display="none";
            left += parseFloat(document.getElementById('order_total_'+id).innerHTML);
            $("#pingo_"+id).remove();
             if (left<=0){

                document.getElementById('left').innerHTML= "0";
                document.getElementById('subscribe').disabled= false;
             }
                 
             else{
                document.getElementById('left').innerHTML= left;
                document.getElementById('subscribe').disabled= true;
             }
        }
    }
    window.onload=function(){
        if (left<=0)
            document.getElementById('subscribe').disabled= false;
        else
            document.getElementById('subscribe').disabled= true;
        var progress = document.getElementById("progress");
        var myinput = document.createElement("input"); 
        myinput.type="text";
        myinput.name = "id[]";
        myinput.value = <?php echo $id?>;
        myinput.style.display="none";
        progress.appendChild(myinput);
    }
  </script>
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
                                    echo'<li>
                                            <a href="message.php"><i class="fa fa-envelope-o"></i>Messgae <i class="fa fa-caret-down"></i></a>	
                                            <ul>
                                                <li><a href="message.php">Agreed Order<span class="successful-number">2</span></a></li>
                                                <li><a href="message_new.php">New Order<span class="handling-number">1</span></a></li>
                                            </ul>
                                        </li>
                                        <li><a href="./address.php"><i class="fa fa-user"></i>'.$email.' <i class="fa fa-caret-down"></i></a>
                                            <ul>
                                                <li style="border-bottom:1px solid #E9EBEE"><a href="./address.php">Account Settings</a></li>
                                                <li><a href="logout.php">Log out</a></li>
                                            </ul>
                                        </li>'
                                ?>
							  <li><a href="chinese-add-on item.php" style="font-family:'微软雅黑'"><i class="fa fa-paperclip"></i><b>中文</b></a></li>
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
                                            <input type="text" class="form-control input-lg search-input" placeholder="Enter Keywork Here ..." required="required">
                                            <div class="input-group-btn">
                                                <div class="input-group">
                                                   <!--  <select class="form-control input-lg search-select">
                                                        <option>Select Your Category</option>
                                                        <option>Deals</option>
                                                        <option>Coupons</option>
                                                        <option>Discounts</option>
                                                    </select> -->
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
				<div>
                    <div class="section faq-area mb-10">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title">
                                    <a><?php echo $off?> off for every <?php echo $lim?> payment,now <span id="left"><?php echo $left?></span> yuan left</a>
                                </h5>
                            </div>
                        </div>
					</div>
					
					<!-- Coupons Area -->
                    <div  id="199-100" class="section coupons-area coupons-area-grid">

                        <!-- Page Control -->
                        <header class="page-control panel ptb-15 prl-20 pos-r mb-10">

                            <!-- List Control View -->
                            <ul class="list-control-view list-inline">
                               <!--  <li><a href="coupons_list.php"><i class="fa fa-bars"></i></a>
                                </li>
                                <li><a href="coupons_grid.php"><i class="fa fa-th"></i></a>
                                </li> -->
								<li><a href="coupons_list.php">You can get discount with following customers</i></a>
                                </li>
                            </ul>
                            <!-- End List Control View -->

                            <div class="right-10 pos-tb-center">
                                <select class="form-control input-sm">
                                    <option>SELECT AREA</option>
                                    <option>shanghai</option>
                                    <option>beijing</option>
                                    <option>Best rated</option>
                                    <option>Price: low to high</option>
                                    <option>Price: high to low</option>
                                </select>
                            </div>
							<div class="right-10 pos-tb-center" style="margin-right:150px">
                                <select class="form-control input-sm">
                                    <option>NUMBER of CUSTOMERS</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                </select>
                            </div>
                        </header>
                        <!-- End Page Control -->
                        <div  class="row row-masnory row-tb-20">
                            <?php 
                                while($row = mysqli_fetch_array($result))
                                {
                                    if (is_file('assets/images/customer/'.$row["email"].'.png'))
                                        $src='assets/images/customer/'.$row["email"].'.png';
                                    elseif (is_file('assets/images/customer/'.$row["email"].'.jpg'))
                                        $src='assets/images/customer/'.$row["email"].'.jpg';
                                    elseif (is_file('assets/images/customer/'.$row["email"].'.jpeg'))
                                        $src='assets/images/customer/'.$row["email"].'.jpeg';
                                    elseif (is_file('assets/images/customer/'.$row["email"].'.gif'))
                                        $src='assets/images/customer/'.$row["email"].'.gif';
                                    else
                                        $src='assets/images/upload.png';
                        echo '<div class="col-sm-6 col-md-4 col-lg-3" style="cursor:pointer" onclick="select('.$row["pingo_id"].')">
                                <div class="coupon-single panel t-center">
									<div class="ribbon-wrapper is-hidden-xs-down" style="display:none" id="ribbon_'.$row["pingo_id"].'">
                                        <div class="ribbon">selected</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="text-center p-20">
                                                <img class="store-logo" src="'.$src.'" alt="">
                                            </div>
                                            <!-- end media -->
                                        </div>
                                        <!-- end col -->

                                        <div class="col-xs-12">
                                            <div class="panel-body">
                                                <ul class="deal-meta list-inline mb-10">
                                                    <li class="color-muted"><i class="ico fa fa-map-marker mr-5"></i>'.$row["province"].'</li>
                                                    <li class=""><i class="fa fa-user mr-10"></i>'.$row["customer_name"].'</li>
                                                </ul>
												<h4 class="color-green mb-10 t-uppercase" style="font-size:1em;float:right"><b>order total:</b>￥<span id="order_total_'.$row["pingo_id"].'">'.$row["price"]*$row["quantity"].'</h4>
                                            </div>
                                        </div>
                                        <!-- end col -->
                                    </div>
                                    <!-- end row -->
                                </div>
                            </div>';
                                }
                            ?>
							 

                        </div>
						
						
						<div class="row row-masnory row-tb-20">
							<div class="col-sm-6 col-md-4 col-lg-9"> </div>
						    <div class="col-sm-6 col-md-4 col-lg-3" >
								<!-- <p class="color-mid mb-20" style="font-size:1.1em;text-align:right">You'll save <b style="font-size:1.2em; color: #F07818">10 </b> yuan </p>							 -->
								<div class="showcode">
                                    <button class="show-code btn btn-sm btn-block" data-toggle="modal" data-target="#coupon_12" id="subscribe">Subscribe the order</button>
                                    <div class="coupon-hide"></div>
                                </div> 
							</div>
						</div>
						<!--模态框-->
						<div class="modal fade get-coupon-area" tabindex="-1" role="dialog" id="coupon_12">
                                    <div class="modal-dialog">
                                        <div class="modal-content panel">
                                            <div class="modal-body">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                                                </button>
                                                <div class="row row-v-10">
                                                    <div class="col-md-10 col-md-offset-1">
                                                        <img src="assets/images/brands/store_logo-1.png" alt="">
                                                        <h3 class="mb-20">Your request is going to be sent.</h3>
                                                        <!-- <p class="color-mid">Not applicable to ICANN fees, taxes, transfers,or gift cards. Cannot be used in conjunction with any other offer, sale, discount or promotion. After the initial purchase term.</p> -->
                                                    </div>
                                                    <!--  <div class="col-md-10 col-md-offset-1">
                                                        <a href="#" class="btn btn-link">Visit Our Store</a>
                                                    </div> -->
                                                    <div class="col-md-10 col-md-offset-1">
                                                        <!-- <h6 class="color-mid t-uppercase">You can go to payment or wait other customers agree the add-on item order</h6> -->
														<p class="color-mid mb-20" style="font-size:1.1em">Please wait for other customers' acceptance.If the order cannot be agreed by all customers within <b style="font-size:1em; color: #2ed87b">24 hours </b> ,the order will be canceled</p>
                                                        <!-- <a href="#" target="_blank" class="coupon-code">payment</a> -->
														 <!-- <span><a class="btn btn-o btn-xs pos-a right-10 pos-tb-center" style="margin-top:40px;margin-right:80px">wait</a> -->
														<p class="color-mid" style="font-size:1.1em;text-align:right">You'll save <b style="font-size:1.2em; color: #F07818" id="save"><?php echo $off ?> </b> yuan </p>
                                                        <form id="progress" action="progress.php" method="post">
														    <button class="btn" type="submit" style="height:30px;padding:4px;width:60px;float:right;margin-top:30px">Ok</button>
														</form>
                                                    </div> 
                                                  
                                                </div>
                                            </div>
                                            <div class="modal-footer footer-info t-center ptb-40 prl-30">
                                                <!-- <h4 class="mb-15">Subscribe to Mail</h4> -->
                                                <p class="color-mid mb-20">You can get more add-on item information on discounts guide </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    <!-- End Coupons Area -->

                </div>
            </div>
		<div>


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
