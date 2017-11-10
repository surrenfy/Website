﻿<?php
    session_start();
    if (empty($_SESSION['customer_email']))
    {
        $_SESSION["header"]='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        header('Location: ./signin.php?flag=1');
        exit();
    }
    $consignee="";
    $province = "";
    $city = "";
    $detail= "";
    $postcode="";
    $phone = "";
    if (!empty($_SESSION["consignee"]))
    {
      $consignee=$_SESSION["consignee"];
      unset($_SESSION["consignee"]);
    }
    if (!empty($_SESSION["province"]))
    {
      $province=$_SESSION["province"];

      unset($_SESSION["province"]);
    }
    if (!empty($_SESSION["city"]))
    {
      $city=$_SESSION["city"];
      unset($_SESSION["city"]);
    }
    if (!empty($_SESSION["detail"]))
    {
      $detail=$_SESSION["detail"];
      unset($_SESSION["detail"]);
    }
    if (!empty($_SESSION["postcode"]))
    {
      $postcode=$_SESSION["postcode"];
      unset($_SESSION["postcode"]);
    }
    if (!empty($_SESSION["phone"]))
    {
      $phone=$_SESSION["phone"];
      unset($_SESSION["phone"]);
    }
    
    $email=$_SESSION['customer_email'];
    $name="";
    $profile="";
    $mysqli=new mysqli('localhost','root','510051','pingo');
    if (mysqli_connect_errno()){
        header('Location: ./signin.php?flag=1');
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
      $query = 'select * from customer where email ="'.$email.'"';
      $result = $mysqli->query ($query);
      
      if (!$result->num_rows) {
         header('Location: ./signin.php?flag=1');
         exit();
      }
      $row = mysqli_fetch_assoc($result);
      $name = $row['name'];
      $profile = $row['profile'];

      $query = 'select * from addr where customer_email ="'.$email.'"';
      $result = $mysqli->query ($query);
    }

    $mysqli->close();
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
        var _name="<?php echo $name?>";
        var _profile="<?php echo $profile?>";

        function profile(e){
            var keynum = window.event ? e.keyCode : e.which;
            if(keynum == 13 ){
              if (document.getElementById("profile").value!=_profile){
                var myform = document.createElement("form"); 
                var profile = document.getElementById("profile");
                var myinput = document.createElement("input"); 
                myinput.type=profile.type;
                myinput.name = profile.name;
                myinput.value = profile.value;
                myform.appendChild(myinput);
                myform.method="post";
                myform.action="./customer_update.php";
                myform.id="myform";
                document.body.appendChild(myform);
                $("#myform").ajaxSubmit(function(message) { 
                  profile=document.getElementById("profile").value;
                }); 
                $('#myform').remove();
                $('#input').remove();
              }
              return false; 
            }
        }
         function profile_blur(){
           if (document.getElementById("profile").value!=_profile){
              var myform = document.createElement("form"); 
              var profile = document.getElementById("profile");
              var myinput = document.createElement("input"); 
              myinput.type=profile.type;
              myinput.name = profile.name;
              myinput.value = profile.value;
              myform.appendChild(myinput);
              myform.method="post";
              myform.action="./customer_update.php";
              myform.id="myform";
              document.body.appendChild(myform);
              $("#myform").ajaxSubmit(function(message) { 
                profile=document.getElementById("profile").value;
              }); 
              $('#myform').remove();
              $('#input').remove();
           }
        }

          function rename_blur(){
            if (document.getElementById("rename").value=="")
              document.getElementById("rename").value=_name;
            else if (document.getElementById("rename").value!=_name){
              var myform = document.createElement("form"); 
              var rename = document.getElementById("rename");
              var myinput = document.createElement("input"); 
              myinput.type=rename.type;
              myinput.name = rename.name;
              myinput.value = rename.value;
              myform.appendChild(myinput);
              myform.method="post";
              myform.action="./customer_update.php";
              myform.id="myform";
              document.body.appendChild(myform);
              $("#myform").ajaxSubmit(function(message) { 
                  _name=document.getElementById("rename").value;
              }); 
              $('#myform').remove();
              $('#input').remove();
            }
        }
        function rename(e){
            var keynum = window.event ? e.keyCode : e.which;
            if(keynum == 13 ){
              if (document.getElementById("rename").value=="")
                document.getElementById("rename").value=_name;
              else if (document.getElementById("rename").value!=_name){
                var myform = document.createElement("form"); 
                var rename = document.getElementById("rename");
                var myinput = document.createElement("input"); 
                myinput.type=rename.type;
                myinput.name = rename.name;
                myinput.value = rename.value;
                myform.appendChild(myinput);
                myform.method="post";
                myform.action="./customer_update.php";
                myform.id="myform";
                document.body.appendChild(myform);
                $("#myform").ajaxSubmit(function(message) { 
                  _name=document.getElementById("rename").value;
                }); 
                $('#myform').remove();
                $('#input').remove();
              }
              return false; 
          }
        }
        function F_Open_dialog() 
        { 
            document.getElementById("inputfile").click(); 
        } 
        function getPath(obj,fileQuery,transImg) {
              var imgSrc = '', imgArr = [], strSrc = '' ;
              if(window.navigator.userAgent.indexOf("MSIE")>=1){ // IE浏览器判断
                if(obj.select){
                  obj.select();
                  var path=document.selection.createRange().text;
                  alert(path) ;
                  obj.removeAttribute("src");
                  imgSrc = fileQuery.value ;
                  imgArr = imgSrc.split('.') ;
                  strSrc = imgArr[imgArr.length - 1].toLowerCase() ;
                  if(strSrc.localeCompare('jpg') === 0 || strSrc.localeCompare('jpeg') === 0 || strSrc.localeCompare('gif') === 0 || strSrc.localeCompare('png') === 0){
                  obj.setAttribute("src",transImg);
                  obj.style.filter=
                    "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+path+"', sizingMethod='scale');"; // IE通过滤镜的方式实现图片显示
                  }else{
                  //try{
                  throw new Error('File type Error! please image file upload..'); 
                  //}catch(e){
                  // alert('name: ' + e.name + 'message: ' + e.message) ;
                  //}
                  }
                }
                else{
                  // alert(fileQuery.value) ;
                  imgSrc = fileQuery.value ;
                  imgArr = imgSrc.split('.') ;
                  strSrc = imgArr[imgArr.length - 1].toLowerCase() ;
                  if(strSrc.localeCompare('jpg') === 0 || strSrc.localeCompare('jpeg') === 0 || strSrc.localeCompare('gif') === 0 || strSrc.localeCompare('png') === 0){
                  obj.src = fileQuery.value ;
                  }
                  else{
                    //try{
                    throw new Error('File type Error! please image file upload..') ;
                    //}catch(e){
                    // alert('name: ' + e.name + 'message: ' + e.message) ;
                    //}
                  }
                }
              }
              else{
                var file =fileQuery.files[0];
                var reader = new FileReader();
                reader.onload = function(e){
              
                imgSrc = fileQuery.value ;
                imgArr = imgSrc.split('.') ;
                strSrc = imgArr[imgArr.length - 1].toLowerCase() ;
                if(strSrc.localeCompare('jpg') === 0 || strSrc.localeCompare('jpeg') === 0 || strSrc.localeCompare('gif') === 0 || strSrc.localeCompare('png') === 0){
                obj.setAttribute("src", e.target.result) ;
                }else{
                  //try{
                  throw new Error('File type Error! please image file upload..') ;
                  //}catch(e){
                  // alert('name: ' + e.name + 'message: ' + e.message) ;
                  //}
                }
              
                // alert(e.target.result); 
                }
                reader.readAsDataURL(file);
              }
          }
        function show(){
            //以下即为完整客户端路径
            var file_img=document.getElementById("image"),
            inputfile = document.getElementById('inputfile') ;
            getPath(file_img,inputfile,file_img) ;

            $("#sendfile").ajaxSubmit(function(message) { 
              if (message=="1")
                ;
              else document.getElementById("image").src="assets/images/upload.png";
            }); 
        }
        function addr_edit(id)
        {
          var myform = document.createElement("form"); 
          var myinput = document.createElement("input"); 
          myinput.type="text";
          myinput.name = "id";
          myinput.value = id;
          myform.appendChild(myinput);
          myform.method="post";
          myform.action="./address_update.php?func=update";
          myform.id="myform";
          document.body.appendChild(myform);
          myform.submit(); 
        }
        function addr_delete(id)
        {
          var myform = document.createElement("form"); 
          var myinput = document.createElement("input"); 
          myinput.type="text";
          myinput.name = "id";
          myinput.value = id;
          myform.appendChild(myinput);
          myform.method="post";
          myform.action="./address_update.php?func=delete";
          myform.id="myform";
          document.body.appendChild(myform);
          $("#myform").ajaxSubmit(function(message) { 
             document.getElementById(id).style="display:none";

          }); 
          $('#myform').remove();
          $('#input').remove();

        }
      window.onload=function(){
        select_province();
        select_city();
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
							  <li><a href="chinese-address.php" style="font-family:'微软雅黑'"><i class="fa fa-paperclip"></i><b>中文</b></a></li>
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
            <!-- Page Container -->
            <div class="page-container ptb-60">
                <div class="container">
                    <div class="row row-rl-10 row-tb-20">
						<div class="page-sidebar col-xs-12 col-sm-4 col-md-3">

                            <!-- Blog Sidebar -->
                            <aside class="sidebar blog-sidebar">
                                <div class="row row-tb-10">
                                    <div class="col-xs-12">
                                        <!-- Recent Posts -->
                                        <div class="widget checkout-widget panel">
                                            <div class="widget-body" >
                                                <form id="sendfile" method="post" action="customer_update.php" enctype="multipart/form-data">
                                                  <input type="file" name="inputfile" id="inputfile" style="display:none" accept="image/png,image/gif,image/jpg,image/jpeg" onchange="show()"></input>
                                                </form>
                                                <table class="table">
                                                    <tbody>
                                                        <tr>
                                                            <td>
																<a href="#" class="avatar" style="margin-left:80px">
																	<img <?php 
                                                                        if (is_file('assets/images/customer/'.$email.'.png'))
                                                                            echo 'src="assets/images/customer/'.$email.'.png" ';
                                                                        elseif (is_file('assets/images/customer/'.$email.'.jpg'))
                                                                            echo 'src="assets/images/customer/'.$email.'.jpg" ';
                                                                        elseif (is_file('assets/images/customer/'.$email.'.jpeg'))
                                                                            echo 'src="assets/images/customer/'.$email.'.jpeg" ';
                                                                        elseif (is_file('assets/images/customer/'.$email.'.gif'))
                                                                            echo 'src="assets/images/customer/'.$email.'.gif" ';
                                                                        else
                                                                            echo 'src="assets/images/upload.png" ';
                                                                    ?>
                                                                    alt="" width="100" id="image" onclick="F_Open_dialog()" style="cursor:pointer">
																</a>
															</td>
                                                        </tr>
                                                         <tr>
                                                            <td style="padding-top:2px;padding-bottom:2px">
                                                                <input class="form-control text-center font-18" id="rename" name="rename" style="border: 0" rows="3" maxlength="23" value="<?php echo $name?>" onkeydown="return rename(event)" onblur="rename_blur()" required/>
                                                            </td>
                                                        </tr> 
                                                        <tr>
                                                            <td style="padding-top:5px;padding-bottom:0px">
                                                                <textarea class="form-control text-center" id="profile" name="profile" maxlength="81" value="<?php echo $profile?>" style="border: 0" rows="3" placeholder="the guy is too cool to leave sth"  onkeydown="return profile(event)" onblur="profile_blur()"><?php echo $profile?></textarea>
                                                            </td>
                                                        </tr> 
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- End Recent Posts -->
                                    </div>
                                </div>
                            </aside>
                            <!-- End Blog Sidebar -->
							<!-- Blog Sidebar -->
                            <aside class="sidebar blog-sidebar" >
                                <div class="row row-tb-10">
                                    <div class="col-xs-12">
                                        <!-- Recent Posts -->
                                        <div class="widget checkout-widget panel">
                                            <div class="widget-body" >
                                                <table class="table mb-15 ml-30">
                                                    <tbody>
                                                        <tr>
                                                            <td style="font-size:1.1em"><a href="address.php">· Delivery Address</a></td>
                                                        </tr>
														<tr>
                                                            <td style="font-size:1.1em"><a href="website-alert.php">· Website Alert</a></td>
                                                        </tr> 
														<tr>
                                                            <td style="font-size:1.1em"><a href="transaction-record.php">· Transaction Record</a></td>
                                                        </tr>
                                                    </tbody>
                                                </table> 
                                            </div>
                                        </div>
                                        <!-- End Recent Posts -->
                                    </div>
                                </div>
                            </aside>
                            <!-- End Blog Sidebar -->
                        </div>
                        <div class="page-content col-xs-12 col-sm-8 col-md-9">

                            <!-- Checkout Area -->
                            <section class="section checkout-area panel prl-30 pt-20 pb-40">
                                <h2 class="h2 mb-20 h-title">Delivery Address</h2>

                                    <div class="row">
										<div class="col-md-12">
                                            
											<table id="stuRecordTable"  class="wishlist" CellSpacing=2 border='1' frame="hsides" style="word-break:break-all; word-wrap:break-all;margin-bottom:20px" >
												<thead class="panel t-uppercase">
													<tr>
														<th class="text-center">Consignee Name</th>	
														<th class="text-center">Address</th>
														<th class="text-center">Postcode</th>
														<th class="text-center">Phone Number</th>
														<th colspan="2" class="text-center">Operate</th>
													</tr>
												</thead>
												<?php      
							if (mysqli_num_rows($result) < 1)
                             echo '<tbody>
                                <tr class="panel alert">
                                    <td class="col-sm-2 col-md-2">
                                        <div class="type font-12  text-center"><span readonly="true">——</div>
                                    </td>
                                      <td class="col-sm-4 col-md-4">
                                        <div class="type font-12 text-center"><span >——</div>
                                      </td>
                                    <td class="col-sm-2 col-md-2">
                                      <div class="type text-center font-12"><span >——</div>
                                    </td>
                                    <td class="col-sm-2 col-md-2">
                                      <div class="type font-12 text-center"><span >——</div>
                                    </td>
                                    <td class="col-sm-1 col-md-1">
                                      <button style="border:0px;background-color:#ffffff"><span class="fa fa-edit font-18 ml-5" aria-hidden="true"></span></button>
                                      <!--<a><input type="button" value="edit"style="border-style:none;width:40px"> </a> -->
                                    </td>
                                    <td class="col-sm-1 col-md-1">
                                      <button style="border:0px;background-color:#ffffff"><span class="fa fa-trash font-18 ml-5" aria-hidden="true"></span></button>
                                    </td>
                                  </tr>
                                </tbody>';
                          else while($row = mysqli_fetch_array($result)){
                            if (empty($row["postcode"]))
                            echo '<tbody id="'.$row["id"].'" >
                                <tr class="panel alert">
                                    <td class="col-sm-2 col-md-2">
                                       <div class="type font-12  text-center"><span readonly="true">'.$row["consignee"].'</div>
                                    </td>
                                      <td class="col-sm-4 col-md-4">
                                        <div class="type font-12 text-center"><span >'.$row["province"].' '.$row["city"].' '.$row["detail"].'</div>
                                      </td>
                                    <td class="col-sm-2 col-md-2">
                                      <div class="type text-center font-12"><span >——</div>
                                    </td>
                                    <td class="col-sm-2 col-md-2">
                                      <div class="type font-12 text-center"><span >'.$row["phone"].'</div>
                                    </td>
                                    <td class="col-sm-1 col-md-1">
                                      <button style="border:0px;background-color:#ffffff" onclick="addr_edit('.$row["id"].')"><span class="fa fa-edit font-18 ml-5" aria-hidden="true"></span></button>
                                      <!--<a><input type="button" value="edit"style="border-style:none;width:40px"> </a> -->
                                    </td>
                                    <td class="col-sm-1 col-md-1">
                                      <button style="border:0px;background-color:#ffffff" onclick="addr_delete('.$row["id"].')"><span class="fa fa-trash font-18 ml-5" aria-hidden="true"></span></button>
                                    </td>
                                  </tr>
                               </tbody>';
                            else{
                              echo'<tbody id="'.$row["id"].'" >
                              <tr class="panel alert">
                                    <td class="col-sm-2 col-md-2">
                                       <div class="type font-12  text-center"><span readonly="true">'.$row["consignee"].'</div>
                                    </td>
                                      <td class="col-sm-4 col-md-4">
                                        <div class="type font-12 "><span >&nbsp;&nbsp;'.$row["province"].' '.$row["city"].' '.$row["detail"].'</div>
                                      </td>
                                    <td class="col-sm-2 col-md-2">
                                      <div class="type text-center font-12"><span >'.$row["postcode"].'</div>
                                    </td>
                                    <td class="col-sm-2 col-md-2">
                                      <div class="type font-12 text-center"><span >'.$row["phone"].'</div>
                                    </td>
                                    <td class="col-sm-1 col-md-1">
                                      <button style="border:0px;background-color:#ffffff" onclick="addr_edit('.$row["id"].')" ><span class="fa fa-edit font-18 ml-5" aria-hidden="true"></span></button>
                                    </td>
                                    <td class="col-sm-1 col-md-1">
                                      <button style="border:0px;background-color:#ffffff" onclick="addr_delete('.$row["id"].')" ><span class="fa fa-trash font-18 ml-5" aria-hidden="true"></span></button>
                                    </td>
                                  </tr>
                               </tbody>';
                            }
                          }
                            ?>
											</table>
										<div>
                      <blockquote class="block-quote-1">
                          <p>New Address</p>
                      </blockquote>
										</div> 
                  </div>
                   <form class="mb-30" method="post" action="./address_update.php?func=add">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label>Consignee Name*</label>
                              <input type="text" class="form-control" maxlength="20" placeholder="Enter your  Name" name="consignee" style="width:380px" value="<?php echo $consignee?>" required>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label>Phone Number*</label>
                              <input type="text" class="form-control" maxlength="20" placeholder="XXX - XXXX - XXXX" name="phone" value="<?php echo $phone?>" required>
                          </div>
                      </div>

                      <div class="col-md-6">
                          <div class="form-group">
                              <label>Postal Code</label>
                              <input type="text" class="form-control" maxlength="6" name="postcode" placeholder="Enter Postal Code" value="<?php echo $postcode?>">
                          </div>
                      </div>

                                        
                      <div class="col-md-6">
                          <div class="form-group">
                              <label>Province*</label>
                              <select class="form-control" id="province" name="province" required value="<?php echo $province?>">
                                  <option disabled="disabled">Select province</option>
                                  <option>Anhui</option>
                                  <option>Beijing</option>
                                  <option>Shanghai</option>
                                  <option>Sichuan</option>
                              </select>
                          </div>
                      </div>

                      <div class="col-md-6">
                          <div class="form-group">
                              <label>City/District*</label>
                              <select class="form-control" id="city" name="city" value="<?php echo $city?>" required>
                                  <option disabled="disabled">Select city/district</option>
                                  <option>Yangpu</option>
                                  <option>Jiading</option>
                                  <option>Nairobi</option>
                                  <option>Cairo</option>
                              </select>
                          </div>
                      </div>
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Detailed Address*</label>
                          <input type="text" class="form-control" placeholder="Enter your Detailed Address" style="height:60px" name="detail" value="<?php echo $detail?>" required>
                        </div>
                      </div>
                      <div class="col-xs-12">
                      <div class="comment-notes alert alert-info">
                          <span>Your delivery address will not be published.</span> Required fields are marked <span class="required"> *</span>
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                      </div>
                  </div>
									<button type="submit" class="btn btn-lg btn-rounded mr-10">Save</button>
                  <button type="reset"  class="btn btn-lg btn-warning btn-rounded">Reset</button>
                </form>
                
            </section>
                            <!-- End Checkout Area -->
							 </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- End Page Container -->


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
    <script src="assets/js/jquery-3.1.1.min.js"></script>
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
    <script>
    function select_province(){
      var objSelect=document.getElementById("province");
      for(var i=0;i<objSelect.options.length;i++) {  
          if(objSelect.options[i].value == "<?php echo $province?>") {  
              objSelect.options[i].selected = true;  
              break;  
          }
       }
    }
    function select_city(){
      var objSelect=document.getElementById("city");
      for(var i=0;i<objSelect.options.length;i++) {  
          if(objSelect.options[i].value == "<?php echo $city?>") {  
              objSelect.options[i].selected = true;  
              break;  
          }
       }
    }
    </script>
</body>

</html>
