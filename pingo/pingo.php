﻿<?php
    session_start();
    if (empty($_SESSION['customer_email']))
    {
        header('Location: ./signin.php?flag=1');
        exit();
    }
    $email = $_SESSION['customer_email'];
    $mysqli=new mysqli('localhost','root','510051','pingo');

    if (mysqli_connect_errno()){
        header('Location: ./signin.php?flag=1');
        exit();
    }
    else{
        $result = $mysqli->query ("set names utf8");
        if (!empty($_POST["addr"]) && !empty($_POST["id"]) && !empty($_POST["quantity"]))
        {
            $addr = $_POST["addr"];
            $ids = $_POST["id"];
            $quantitys = $_POST["quantity"];
            $createtime = date('Y-m-d H:i:s');
            if (count($ids)==count($quantitys))
            {
                echo count($ids);
                for ($i= 0;$i< count($ids); $i++){ 
                    $id = $ids[$i]; 
                    $quantity = $quantitys[$i];
                    $query = 'insert into pingo(customer_email,product_id,addr_id,quantity,createtime) values("'.$email.'","'.$id.'","'.$addr.'","'.$quantity.'","'.$createtime.'")';
                    $result = $mysqli->query ($query);
                } 
            }
        }

        $query = 'select count(*) as total from cart where customer_email="'.$email.'"';
        $result = $mysqli->query ($query);
        $row = mysqli_fetch_array($result);
        $cartnumber = $row["total"];
        $query = 'select count(*) as total from pingo where customer_email="'.$email.'"';
        $result = $mysqli->query ($query);
        $row = mysqli_fetch_array($result);
        $pingonumber = $row["total"];
        $query = 'select pingo.id as pingo_id,pingo.quantity,product.id as product_id,product.name,product.kind,product.price,lim,off from (addr left join (pingo left join (product left join packet on product.id=product_id) on product.id=pingo.product_id) on pingo.addr_id = addr.id) where pingo.customer_email="'.$email.'" and addr.id=addr_id order by lim ,off desc';
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
<script>
    function add(obj){
        var txt=document.getElementById(obj+"_quantity");
        var a=txt.value;
        a++;
        txt.value=a;
        update(txt);
    }
    function sub(obj){
        var txt=document.getElementById(obj+"_quantity");
        var a=txt.value;
        if(a>1){
            a--;
            txt.value=a;
            update(txt);
        }else{
            txt.value=1;
        }
    }
    function delete1(id)
    {
        var myform = document.createElement("form"); 
        var myinput = document.createElement("input"); 
        myinput.type="text";
        myinput.name = "id";
        myinput.value = id;
        myform.appendChild(myinput);
        myform.method="post";
        myform.action="./pingo_update.php?func=delete";
        myform.id="myform";
        document.body.appendChild(myform);
        $("#myform").ajaxSubmit(function(message) { 
            if (message=="1"){
                $('#product_'+id).remove();
            }
        }); 
        $('#myform').remove();
        $('#myinput').remove();
    }
    function update(obj)
    {
        if (parseInt(obj.value)<1||isNaN(parseInt(obj.value)))
            obj.value=1;
        else obj.value=parseInt(obj.value);
        var myform = document.createElement("form"); 
        var myinput = document.createElement("input"); 
        myinput.type="text";
        myinput.name = "id";
        myinput.value = obj.name;
        var myinput1 = document.createElement("input"); 
        myinput1.type="text";
        myinput1.name = "quantity";
        myinput1.value = obj.value;
        myform.appendChild(myinput);
        myform.appendChild(myinput1);
        myform.method="post";
        myform.action="./pingo_update.php?func=update";
        myform.id="myform";
        document.body.appendChild(myform);
        $("#myform").ajaxSubmit(function(message) { 
            if (message=="1"){
            }
        }); 
        $('#myform').remove();
        $('#myinput').remove();
        $('#myinput1').remove();
        document.getElementById(obj.name+"-subtotal").innerHTML=obj.value*parseFloat(document.getElementById(obj.name+"-price").innerHTML);
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
							  <li><a href="chinese-add-on-list.php" style="font-family:'微软雅黑'"><i class="fa fa-paperclip"></i><b>中文</b></a></li>
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
                            <a href="#" class="logo">
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
        <!-- –––––––––––––––[ HEADER ]––––––––––––––– -->

        <!-- –––––––––––––––[ PAGE CONTENT ]––––––––––––––– -->
        <main id="mainContent" class="main-content">
            <div class="page-container">
                <div class="container">
                    <div class="cart-area ptb-60">
                        <div class="container">
                            <div class="cart-wrapper">
                                <h3 class="h-title mb-30 t-uppercase">Add-On Item</h3>
                                <?php
                                    $lim="";
                                    $off="";
                                    $first = true;
                                    $i = 0;
                                    while($row = mysqli_fetch_array($result)){
                                        if (empty($row["lim"]) || empty($row["off"])){
                                            if ($lim!="0"||$off!="0"){
                                                $lim="0";
                                                $off="0";
                                                if (!$first)
                                                     echo'</tr></tbody></table></div>';
                                                echo '<div class="section faq-area mb-10"><div class="panel-group"><div class="panel panel-default"><div class="panel-heading"><h5 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#commodity_'.$i.'">no discount</a></h5></div></div></div></div>';
                                            }
                                            $first = false;
                                            $i++;
                                        }
                                        else if($row["lim"]!=$lim||$row["off"]!=$off)
                                        {
                                            $lim=$row["lim"];
                                            $off=$row["off"];
                                            if (!$first)
                                                echo'</tr></tbody></table></div>';
                                            echo '<div class="section faq-area mb-10"><div class="panel-group"><div class="panel panel-default"><div class="panel-heading"><h5 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#commodity_'.$i.'">'.$off.' off for every '.$lim.' payment</a></h5></div></div></div></div>';
                                            echo '<div id="commodity_'.$i.'"><table  class="cart-list "style="word-break:break-all;word-wrap:break-all;"><tbody>';
                                            $first = false;
                                            $i++;
                                        }
                                        echo '
                                            <tr class="panel alert" id="product_'.$row["pingo_id"].'">
                                                <td class="col-md-2">
                                                    <div class="media-left is-hidden-sm-down custom-checkbox mb-20">
                                                        <img src="assets/images/product/'.$row["product_id"].'.png" alt="product">
                                                    </div>
                                                </td>
                                                <td class="col-md-4">
                                                <div class="media-body valign-middle">
                                                    <h6 class="title mb-15 t-uppercase"><a href="./products.php?id='.$row["product_id"].'">'.$row["name"].'</a></h6>
                                                    <div class="type font-12"><span class="t-uppercase">Type : </span>'.$row["kind"].'</div>
                                                </div>
                                                
                                                </td>
                                                <td class="col-md-2">￥<span id="'.$row["pingo_id"].'-price">'.$row["price"].'</span></td>
                                                <td class="col-md-2">
                                                    <span onclick="sub('.$row["pingo_id"].')" onselectstart="return false;" >
                                                        <i class="fa fa-minus-square font-18" ></i>
                                                    </span>
                                                    <input min="1" id="'.$row["pingo_id"].'_quantity" type="number" id="txt" name="'.$row["pingo_id"].'" value="'.$row["quantity"].'" style="width:40px;text-align:center"/>
                                                    <span  onclick="add('.$row["pingo_id"].')" onselectstart="return false;" >
                                                        <i class="fa fa-plus-square font-18" ></i>
                                                    </span>
                                                </td>
                                                <td class="col-md-2">
                                                    <div class="sub-total" id="'.$row["pingo_id"].'-subtotal">'.(int)$row["price"]*(int)$row["quantity"].'</div>
                                                </td>
                                                <td class="col-md-1">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true" onclick="delete1('.$row["pingo_id"].')" style="float:right;margin-bottom:25px">
                                                        <i class="fa fa-trash-o"></i>
                                                    </button>
                                                    <form action="sort.php" method="post">
                                                        <input type="text" style="display:none" name="id" value="'.$row["pingo_id"].'">
                                                        <button class="btn" type="submit" style="height:30px;padding:4px;float:left">sort</button>
                                                    </form>
                                                </td>';
                                        }
                                        echo'</tr></tbody></table></div>';
                                    ?>
                            </div>
                        </div>
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
    <script src="assets/js/jquery.form.js"></script>
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
