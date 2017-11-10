<?php 
  session_start();
  if (empty($_SESSION['seller_email'])||empty($_SESSION['shopname']))
  {
      header('Location: ./index.php?flag=2');
      exit();
  }
  $seller_email     = $_SESSION['seller_email'];
  $shopname =    $_SESSION['shopname'];
  $flag=0;
  $mysqli=new mysqli('localhost', 'root', '510051', 'oto');
  if (mysqli_connect_errno()) {
      $flag=3;
      $mysqli->close();
  }
  elseif (!empty($_POST['delete']))
  {
      $delete = $_POST['delete'];
      $result = $mysqli->query ("set names utf8");
      $query = 'delete from product where id ="'.$delete.'"';
      $result = $mysqli->query ($query);
      $png="./images/product/".$delete.".png";
      $jpg="./images/product/".$delete.".jpg";
      $jpeg="./images/product/".$delete.".jpeg";
      $gif="./images/product/".$delete.".gif";   
      if (is_file($png))
        unlink($png);
      if (is_file($jpeg))
        unlink($jpeg);
      if (is_file($jpg))
        unlink($jpg);
      if (is_file($gif))
        unlink($gif);
  }
  $result = $mysqli->query ("set names utf8");
  $query = 'select * from product where seller_email ="'.$seller_email.'" order by puttime desc';
  $result = $mysqli->query ($query);
  $mysqli->close();
?>
<!DOCTYPE html>
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
  <script src="./dist/semantic.min.js"></script>
  <script src="./dist/less.min.js"></script>
  <script>
  </script>
</head>

<body>

    <div class = "ui container">
      <div class="ui secondary pointing center aligned menu">
        <a class="item active" href = "./seller.php">Products</a>
        <a class="item" href="./seller_addnew.php">Addnew</a> 
        <a class="item" href = "./seller_orders.php">Orders</a>
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
          <p>You may add new products in Addnew tab</p>
        </div>';
        }
        while($row = mysqli_fetch_array($result)){
          echo '<div class="item">';
          echo ' <div class="ui small image">';
          $suffix = "";
          if (is_file("./images/product/".$row["id"].".jpg"))
            $suffix = ".jpg";
          elseif (is_file("./images/product/".$row["id"].".jpeg"))
            $suffix = ".jpeg";
          elseif (is_file("./images/product/".$row["id"].".png"))
            $suffix = ".png";
          else if (is_file("./images/product/".$row["id"].".gif"))
            $suffix = ".gif";
          if ($suffix=="")
          {
             echo '<img src="./images/square-image.png">';
          }
          else echo '<img src="./images/product/'.$row["id"].$suffix.'">';
          echo '</div>';
          echo '<div class="content">';
          echo '<a class="header">'.$row["name"].'</a>';
          echo '<div class="meta">';
          echo '<span class="cinema">'.$row["kind"].'</span>';
          echo '</div>';
          echo '<div class="description">';
          echo '<p>'.$row["description"].'</p>';
          if ($row["remarks"]!="")
            echo '<p>'.$row["remarks"].'</p>';
          
          echo '</div><br>';
          echo '<a class="ui label"><i class="yen icon"></i>'.$row["price"].'</a>';
          echo '<a class="ui label"><i class="history icon"></i> '.$row["puttime"].'</a>';
          echo '<div class="extra">';
          echo '<div class="ui label"><i class="marker icon"></i>'.$row["province"].' '.$row["city"].' '.$row["addr"].'</div>';
          echo '<a class="ui label"><i class="phone icon"></i> '.$row["phone"].'</a>';
          echo '<form id="'.$row["id"].'" method="post" style="display:none"><input type="text" name="delete" value="'.$row["id"].'"></form>';
          echo '<button class="ui right floated orange small button" type="submit" form="'.$row["id"].'" formaction="./seller.php">';
          echo '<i class="left remove icon"></i>';
          echo 'Delete';
          echo '</button>';
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
</body>

</html>
