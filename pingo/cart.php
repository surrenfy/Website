<?php
    session_start();
    if (empty($_SESSION['customer_email']))
    {
        $_SESSION["header"]='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
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
        $query = 'select * from addr where customer_email ="'.$email.'"';
        $result1 = $mysqli->query ($query);
        $result2 = $mysqli->query ($query);
        $query = 'select * from (cart left join (product left join packet on id=product_id) on id=cart.product_id) where cart.customer_email="'.$email.'" order by lim ,off desc';
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
    var selected = 0;
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
        myform.action="./cart_update.php?func=delete";
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
        myform.action="./cart_update.php?func=update";
        myform.id="myform";
        document.body.appendChild(myform);
        $("#myform").ajaxSubmit(function(message) { 
            if (message=="1"){
            }
        }); 
        $('#myform').remove();
        $('#myinput').remove();
        $('#myinput1').remove();
        document.getElementById(obj.name+"-subtotal").innerHTML=obj.value*parseFloat(document.getElementById(obj.name+"_price").innerHTML);
    }
    function select(id)
    {
        if (document.getElementById(id+"-check").checked)
        {
            $('#select_list_id_'+id).remove();
            $('#select_list_quantity_'+id).remove();
            $('#pingo_list_'+id).remove();
            $('#checkout_list_'+id).remove();
            selected --;
        }
        else {
            var select_list = document.getElementById("select_list");
            var pingo_list = document.getElementById("pingo_list");
            var checkout_list = document.getElementById("checkout_list");
            var myinput = document.createElement("input"); 
            myinput.id  ="select_list_id_"+id;
            myinput.type="text";
            myinput.name = "id[]";
            myinput.value = id;
            myinput.style.display="none";
            var myinput1 = document.createElement("input"); 
            myinput1.id = "select_list_quantity_"+id;
            myinput1.type="text";
            myinput1.name = "quantity[]";
            myinput1.value = document.getElementById(id+"_quantity").value;
            myinput1.style.display="none";
            select_list.appendChild(myinput);
            select_list.appendChild(myinput1);
            selected ++;
            var src = document.getElementById(id+"_img").src;
            var name = document.getElementById(id+"_name").innerHTML;
            var price = document.getElementById(id+"_price").innerHTML;
            var quantity = document.getElementById(id+"_quantity").value;
            var subtotal = parseFloat(price)*parseInt(quantity);
            var tr = document.createElement("tr");
            tr.id = "pingo_list_"+id;
            tr.className="panel alert";
            tr.innerHTML='<td class="col-sm-3 col-md-3"><div class="media-left is-hidden-sm-down"><figure class="product-thumb"><img src="'+src+'" alt="product"></figure></div></td><td class="col-sm-6 col-md-8"><div class="media-body valign-middle"><h5 class="title mb-5 t-uppercase" style="text-align:left"><a href="#" >'+name+'</a></h5><div class="rating mb-10"style="text-align:left"><span class="rating-reviews" ><span class="rating-count">* </span> '+quantity+'</span></div><h4 class="price "style="text-align:right;font-size:1.1em;color:#F07818"><span class="price-sale"></span><b>total :</b> ￥'+subtotal+'</h4></div></td>';
            var tr1 = document.createElement("tr");
            tr1.id = "checkout_list_"+id;
            tr1.className="panel alert";
            tr1.innerHTML='<td class="col-sm-3 col-md-3"><div class="media-left is-hidden-sm-down"><figure class="product-thumb"><img src="'+src+'" alt="product"></figure></div></td><td class="col-sm-6 col-md-8"><div class="media-body valign-middle"><h5 class="title mb-5 t-uppercase" style="text-align:left"><a href="#" >'+name+'</a></h5><div class="rating mb-10"style="text-align:left"><span class="rating-reviews" ><span class="rating-count">* </span> '+quantity+'</span></div><h4 class="price "style="text-align:right;font-size:1.1em;color:#F07818"><span class="price-sale"></span><b>total :</b> ￥'+subtotal+'</h4></div></td>';
            pingo_list.appendChild(tr1);
            checkout_list.appendChild(tr);
        }
        if (selected>0)
        {
            document.getElementById('pingo').disabled=false;
            document.getElementById('checkout').disabled=false;
        }
        else {
            document.getElementById('pingo').disabled=true;
            document.getElementById('checkout').disabled=true;
        }
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
							  <li><a href="chinese-cart.php" style="font-family:'微软雅黑'"><i class="fa fa-paperclip"></i><b>中文</b></a></li>
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
                                <h3 class="h-title mb-30 t-uppercase">My Cart</h3>
                                <table id="cart_list" class="cart-list mb-30"style="word-break:break-all; word-wrap:break-all;">
                                    <thead class="panel t-uppercase" >
                                        <tr>
                                            <th>Product name</th>	
                                            <th>Unit price</th>
                                            <th>Quantity</th>
                                            <th>Sub total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $lim="";
                                        $off="";
                                        while($row = mysqli_fetch_array($result)){
                                            if (empty($row["lim"]) || empty($row["off"])){
                                                if ($lim!="0"||$off!="0"){
                                                    $lim="0";
                                                    $off="0";
                                                    echo '<tr class="panel alert"><td colspan="5" style="padding:5px 20px;">no discount</td> </tr>';
                                                }
                                            }
                                            else if($row["lim"]!=$lim||$row["off"]!=$off)
                                            {
                                                $lim=$row["lim"];
                                                $off=$row["off"];
                                                echo '<tr class="panel alert"><td colspan="5" style="padding:5px 20px;">'.$off.' yuan off if more than '.$lim.' yuan</td> </tr>';
                                            }
                                            echo '<tr class="panel alert" id="product_'.$row["id"].'">
                                                    <td class="col-md-7">
                                                    <div class="media-left is-hidden-sm-down custom-checkbox mb-20">
                                                        <input type="checkbox" id="'.$row["id"].'-check">
                                                        <label class="color-mid" for="'.$row["id"].'-check" onclick="select('.$row["id"].')"><figure class="product-thumb ">
                                                                <img src="assets/images/product/'.$row["id"].'.png" id="'.$row["id"].'_img"alt="product">
                                                        </figure></label>
                                                    </div>
                                                    <div class="media-body valign-middle">
                                                        <h6 class="title mb-15 t-uppercase"><a href="./products.php?id='.$row["id"].'" title="'.$row["description"].'" id="'.$row["id"].'_name">'.$row["name"].'</a></h6>
                                                        <div class="type font-12"><span class="t-uppercase">Type : </span>'.$row["kind"].'</div>
                                                    </div>
                                                    
                                                    </td>
                                                    <td class="col-md-2">￥<span id="'.$row["id"].'_price">'.$row["price"].'</span></td>
                                                    <td class="col-md-2">
                                                        <span onclick="sub('.$row["id"].')" onselectstart="return false;" >
                                                            <i class="fa fa-minus-square font-18" ></i>
                                                        </span>
                                                        <input min="1" type="text" id="'.$row["id"].'_quantity" name="'.$row["id"].'" value="'.$row["quantity"].'" style="width:40px;text-align:center" onblur="update(this)"/>
                                                        <span  onclick="add('.$row["id"].')" onselectstart="return false;" >
                                                            <i class="fa fa-plus-square font-18" ></i>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="sub-total" id="'.$row["id"].'-subtotal">'.$row["price"]*$row["quantity"].'</div>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-warning mr-10" onclick="delete1('.$row["id"].')" style="height:30px;padding:4px">Delete</button>
                                                    </td>
                                                </tr>';
                                            
                                        }
                                    ?>
                                    </tbody>
                                </table>
                                <div class="t-right">
                                    <button class="btn btn-rounded btn-lg" id="pingo" data-toggle="modal" data-target="#confirm_1" disabled="true">PINGO</button>
                                </div>

								<div class="modal fade get-coupon-area" tabindex="-1" role="dialog" id="confirm_1">
                                    <div class="modal-dialog">
                                        <div class="modal-content panel">
                                            <div class="modal-body">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                                                </button>
                                                <div class="row row-v-10">
                                                    <div class="col-md-10 col-md-offset-1">
                                                        <img src="assets/images/brands/store_logo-1.png" alt="">
                                                        <h3 class="mb-20"style="float:left">These commodities will add to pingo list.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>
														 <p class="color-mid" style="font-size:1.1em;text-align:left">Please <b style="font-size:1.2em; color: #F07818">confirm </b>  information now.</p>
														
                                                    </div>
                                                    <!--  Checkout address -->	
                                                    <?php       
                                                    while($row1 = mysqli_fetch_array($result1)){
                                                        echo '<section class="section checkout-area panel prl-30 pt-10"style="float:left">
														        <div class="custom-radio mb-10" style="float:left">
                                                                <input type="radio" name="addr" id="address1_'.$row1["id"].'" form="select_list" value="'.$row1["id"].'">
                                                                    <label class="" for="address1_'.$row1["id"].'">
                                                                        <table class="wishlist" style="word-break:break-all; word-wrap:break-all;padding:0px" >
                                                                            <tbody>
                                                                                <tr class="panel alert">
                                                                                    <td class="col-sm-2 col-md-2" style="padding:0px">
                                                                                        <div class="media-left is-hidden-sm-down">
                                                                                            <div class="type font-12"><span class="t-uppercase" readonly="true">'.$row1["consignee"].'</div>
                                                                                        </div> 
                                                                                    </td>
                                                                                    <td class="col-sm-3 col-md-2"style="padding:0px">
                                                                                        <div class="type font-12"><span class="t-uppercase">'.$row1["phone"].'</div>
                                                                                    </td>
                                                                                    <td class="col-sm-5 col-md-5"style="padding:0px">
                                                                                        <div class="type font-12"><span class="t-uppercase">'.$row1["province"].' '.$row1["city"].' '.$row1["detail"].'</div>
                                                                                    </td>	
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </label>
                                                                </div><div class="clearfix"></div>
                                                            </section>';
                                                        }
                                                    ?>
													<!-- End Checkout address -->

													<table id="message_list" class="wishlist"  border='1' frame="hsides" style="word-break:break-all; word-wrap:break-all;">
														<tbody id="pingo_list"> 
														</tbody>
													</table>
                                                    <div class="col-md-12">
														<form action="./pingo.php" method="post" id="select_list"> 
														    <button class="btn" type="submit" style="height:30px;padding:4px;width:85px;float:right;margin-top:30px">Pingo</button>
														</form>
                                                    </div> 
                                                  
                                                </div>
                                            </div>
                                            <div class="modal-footer footer-info t-center ptb-40 prl-30">
                                                <!-- <h4 class="mb-15">Subscribe to Mail</h4> -->
                                                <p class="color-mid mb-20">You can get more add-on item information on <a href="">discounts guide</a> </p>
                                                <form id="selected" method="post" action="./pingo.php">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade get-coupon-area" tabindex="-1" role="dialog" id="confirm_2">
                                    <div class="modal-dialog">
                                        <div class="modal-content panel">
                                            <div class="modal-body">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                                                </button>
                                                <div class="row row-v-10">
                                                    <div class="col-md-10 col-md-offset-1">
                                                        <img src="assets/images/brands/store_logo-1.png" alt="">
                                                        <h3 class="mb-20"style="float:left">These commodities will pay immediately.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h3>
														 <p class="color-mid" style="font-size:1.1em;text-align:left">Please <b style="font-size:1.2em; color: #F07818">confirm </b>  information now.</p>
														
                                                    </div>
                                                    <!--  Checkout address -->	
                                                    <?php       
                                                    while($row2 = mysqli_fetch_array($result2)){
                                                        echo '<section class="section checkout-area panel prl-30 pt-10"style="float:left">
														        <div class="custom-radio mb-10" style="float:left">
                                                                <input type="radio" name="checkout_method" id="address2_'.$row2["id"].'">
                                                                    <label class="" for="address2_'.$row2["id"].'">
                                                                        <table class="wishlist" style="word-break:break-all; word-wrap:break-all;padding:0px" >
                                                                            <tbody>
                                                                                <tr class="panel alert">
                                                                                    <td class="col-sm-2 col-md-2" style="padding:0px">
                                                                                        <div class="media-left is-hidden-sm-down">
                                                                                            <div class="type font-12"><span class="t-uppercase" readonly="true">'.$row2["consignee"].'</div>
                                                                                        </div> 
                                                                                    </td>
                                                                                    <td class="col-sm-3 col-md-2"style="padding:0px">
                                                                                        <div class="type font-12"><span class="t-uppercase">'.$row2["phone"].'</div>
                                                                                    </td>
                                                                                    <td class="col-sm-5 col-md-5"style="padding:0px">
                                                                                        <div class="type font-12"><span class="t-uppercase">'.$row2["province"].' '.$row2["city"].' '.$row2["detail"].'</div>
                                                                                    </td>	
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </label>
                                                                </div><div class="clearfix"></div>
                                                            </section>';
                                                        }
                                                    ?>
													<!-- End Checkout address -->

													<table id="message_list" class="wishlist"  border='1' frame="hsides" style="word-break:break-all; word-wrap:break-all;">
														<tbody id="checkout_list"> 
															
														</tbody>
													</table>
                                                    <div class="col-md-12">
														<button class="btn" type="submit" style="height:30px;padding:4px;width:85px;float:right;margin-top:30px" id="paynow">Pay Now</button>
                                                    </div> 
                                                  
                                                </div>
                                            </div>
                                            <div class="modal-footer footer-info t-center ptb-40 prl-30">
                                                <!-- <h4 class="mb-15">Subscribe to Mail</h4> -->
                                                <p class="color-mid mb-20">You can get more add-on item information on <a href="">discounts guide</a> </p>
                                                <form id="selected" method="post" action="./pingo.php">
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="cart-price">
                                    <h5 class="t-uppercase mb-20">Cart total</h5>
                                    <ul class="panel mb-20">
                                        <li>
                                            <div class="item-name">
                                                Original
                                            </div>
                                            <div class="price" id="original">
                                                ￥113.00
                                            </div>
                                        </li>
                                        <li>
                                            <div class="item-name">
                                                Discount
                                            </div>
                                            <div class="price" id="discount">
                                                ￥10.00
                                            </div>
                                        </li>
                                        <li>
                                            <div class="item-name">
                                                <strong class="t-uppercase">Order total</strong>
                                            </div>
                                            <div class="price">
                                                <span id="total">￥103.00</span>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="t-right">
                                        <button id="checkout" class="btn btn-rounded btn-lg" data-toggle="modal" data-target="#confirm_2" disabled="true">CHECKOUT</button>
                                    </div>
                                </div>
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
</body>

</html>
