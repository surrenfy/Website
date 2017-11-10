<?php session_start()?>
<!DOCTYPE html>
  <?php
  if (empty($_SESSION['seller_email'])||empty($_SESSION['shopname']))
    {
        header('Location: ./index.php?role=missinfo');
        exit();
    }
    $flag = 0;
    $seller_email     = $_SESSION['seller_email'];
    $shopname = $_SESSION['shopname'];
    $mysqli=new mysqli('localhost','root','510051','oto');
    if (mysqli_connect_errno()){
        $flag==3;
    }
    else{
        $result = $mysqli->query ("set names utf8");
        $query = 'select * from orders where seller_email ="'.$seller_email.'" and status_id < 4 order by status_id ,dealtime desc';
        $result = $mysqli->query($query);
    }
?>

<html>

<head>
  <meta charset="utf-8" />
  <?php
    //获取USER AGENT
    $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
  
    //分析数据
    $is_pc = (strpos($agent, 'windows nt')) ? true : false;   
    $is_iphone = (strpos($agent, 'iphone')) ? true : false;   
    $is_ipad = (strpos($agent, 'ipad')) ? true : false;   
    $is_android = (strpos($agent, 'android')) ? true : false;   
    if ($is_android || $is_iphone)
    {
      echo '<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />';
    }
  ?>
  <link rel="stylesheet" type="text/css" href="./dist/semantic.min.css">

  <title>Seller</title>
  <style type="text/css">
      body {
        background-color: #FFFFFF;
      }
      
      body>.grid {
        height: 100%;
      }
      
      .image {
        margin-top: -100px;
      }

    </style>
  <?php
    echo '<style type="text/css">';
    if ($is_android || $is_iphone)
      echo '.column {max-width: 92.5%}';
    else echo '.colmn {max-width: 92.5%}';
    echo '</style>';
  ?>
  <script src="./dist/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
  <script src="./dist/jquery.form.js"></script>
  <script src="./dist/semantic.min.js"></script>
  <script src="./dist/less.min.js"></script>
  <script>
  function dispatch(id)
  {
      var formid = "#"+id;
      $(formid).ajaxSubmit(function(message) { 
          if (message == 0){
            alert("The order has been canceled by customer!")
            $('#item_'+id).remove();
          }
          else if (message == 1){
            document.getElementById("status_"+id).outerHTML='<label class="ui teal large label"><i class="rocket icon"></i>Waiting for deliverer</label>';
            $('#btn_'+id).remove();
          }
      }); 
  }
  </script>
</head>

<body>
    <div class = "ui container">
      <div class="ui secondary pointing center aligned menu">
        <a class="item" href = "./seller.php">Products</a>
        <a class="item" href="./seller_addnew.php">Addnew</a> 
        <a class="item active" href = "./seller_orders.php">Orders</a>
        <a class="item" href = "./seller_review.php">Review</a>
        <div class="ui right dropdown item">
          <div class="text"><?php echo $shopname?> </div>
          <i class="dropdown icon"></i> 
            <div class="menu">
              <a class="ui item"> 
                <?php echo $seller_email;?> 
              </a>
              <div class="divider"></div>
              <a class="ui item" href="./logout.php">Logout</a>
            </div>
          <div>
        </div>
      </div>
    </div>

    <div class="ui raised container segment">
      <div class="ui divided items">
  <?php
    if ($flag==3) {
        echo '<div class="ui error message">
          <div class="header">
            We have some problems with database.
          </div>
          <p>You may retry later</p>
        </div>';
    } else {
        if (mysqli_num_rows($result) < 1){
          echo '<div class="ui warning message">
          <div class="header">
            Your list is empty
          </div>
          <p>You have no order at present,retry later</p>
        </div>';
        }
        while($row = mysqli_fetch_array($result)){
          echo '<div class="item" id="item_'.$row["id"].'">';
          echo ' <div class="ui small image">';
          $suffix = "";
          if (is_file("./images/product/".$row["product_id"].".jpg"))
            $suffix = ".jpg";
          elseif (is_file("./images/product/".$row["product_id"].".jpeg"))
            $suffix = ".jpeg";
          elseif (is_file("./images/product/".$row["product_id"].".png"))
            $suffix = ".png";
          else if (is_file("./images/product/".$row["product_id"].".gif"))
            $suffix = ".gif";
          if ($suffix=="")
          {
             echo '<img src="./images/square-image.png">';
          }
          else echo '<img src="./images/product/'.$row["product_id"].$suffix.'">';
          echo '</div>';
          echo '<div class="content">';
          echo '<a class="header">'.$row["product_name"].'</a>';
          echo '<div class="description">';
          echo $row["customer_firstname"].' '.$row["customer_lastname"].','.$row["customer_phone"];
          echo '</div>';
          echo '<div class="meta">';
          echo '<span class="cinema">'.$row["customer_province"].' '.$row["customer_city"].' '.$row["customer_addr"].'</span>';
          echo '</div>';
          echo '<div class="description">';
          echo '<p>'.$row["dealtime"].'</p>';
          echo '</div>';
          echo '<div class="extra">';
          if ($row["status_id"]=="0")
            echo '<label id="status_'.$row["id"].'" class="ui blue large label"><i class="rocket icon"></i>Waiting for ship</label>';
          else  if ($row["status_id"]=="1")
            echo '<label class="ui teal large label"><i class="rocket icon"></i>Waiting for deliverer</label>';
          else  if ($row["status_id"]=="2")
            echo '<label class="ui olive large label"><i class="rocket icon"></i>Waiting for dispatch</label>';
          else  if ($row["status_id"]=="3")
            echo '<label class="ui green large label"><i class="rocket icon"></i>Dispatching</label>';
          echo '<form id="'.$row["id"].'" action="./dispatch.php" method="post" style="display:none"><input type="text" name="id" value="'.$row["id"].'"></form>';
          if ($row["status_id"]=="0"){
            echo '<button class="ui right floated orange small button" id="btn_'.$row["id"].'" onclick="dispatch(\''.$row["id"].'\')">';
            echo '<i class="left shipping icon"></i>';
            echo 'Ship Now';
            echo '</button>';
          }
          echo '</div>';
          echo '</div>';
          echo '</div>';
        }
    }
         ?>
      </div>
    </div>
<script>
  $('.ui.dropdown')
  .dropdown({action: 'hide'});
   $('.message .close')
       .on('click', function() {
        $(this)
      .closest('.message')
      .transition('fade')
          ;
       });
  </script>
<br><br><br>
</body>

</html>