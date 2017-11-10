<?php 
  session_start();
    if (empty($_SESSION['customer_email'])||empty($_SESSION['customer_firstname'])||empty($_SESSION['customer_lastname'])||empty($_SESSION['customer_phone'])||empty($_SESSION['customer_province'])||empty($_SESSION['customer_city'])||empty($_SESSION['customer_addr']))
    {
        header('Location: ./index.php?flag=2');
        exit();
    }
    $email = $_SESSION['customer_email'];
    $firstname = $_SESSION['customer_firstname'];
    $lastname = $_SESSION['customer_lastname'];
    $phone = $_SESSION['customer_phone'];
    $province = $_SESSION['customer_province'];
    $city = $_SESSION['customer_city'];
    $addr = $_SESSION['customer_addr'];
    $flag=0;
    $mysqli=new mysqli('localhost', 'root', '510051', 'oto');
    if (mysqli_connect_errno()) {
        $flag=3;
        $mysqli->close();
    }
    else {
        $result = $mysqli->query ("set names utf8");
        $query = 'select * from orders where customer_email = "'.$email.'" and status_id < 4 order by dealtime desc';
        $result = $mysqli->query ($query);
    }
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

  <title>customer</title>
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
  <script src="./dist/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
  <script src="./dist/jquery.form.js"></script>
  <script src="./dist/semantic.min.js"></script>
  <script src="./dist/less.min.js"></script>
  <script>

    window.onload = function()
    {

    }
    function cancel(id)
    {
        var myform = document.createElement("form"); 
        var myinput = document.createElement("input"); 
        myinput.type="text";
        myinput.name = "id";
        myinput.value = id;
        myform.appendChild(myinput);
        myform.method="post";
        myform.action="./customer_cancel.php";
        myform.id="myform";
        document.body.appendChild(myform);
        $("#myform").ajaxSubmit(function(message) {
            if (message=="1"){
                alert("success");
            }
            else alert("fail");
            location.reload();
        }); 
        $('#myform').remove();
        $('#input').remove();
    }
  </script>
</head>
<?php if ($is_android || $is_iphone)
    {?>
<body>
      <div class="ui inverted fixed bottom sticky menu" style="text-align:center" id="menu">
        <a class="item" style="width:25%;padding-bottom:2px;padding-top:2px" href = "./customer.php">  
          <div class="statistic" style="margin:0 auto">
            <div class="value">
              <i class="large home icon"></i>
            </div>
            <div class="label" style="font-size:9px">
              Home
            </div>
          </div>
        </a>
        <a class="item active" style="width:25%;padding-bottom:2px;padding-top:2px" href = "./customer_progress.php">
           <div class="statistic" style="margin:0 auto">
            <div class="value">
              <i class="large shipping icon"></i>
            </div>
            <div class="label" style="font-size:9px">
              progress
            </div>
          </div>
        </a>
        <a class="item" style="width:25%;padding-bottom:2px;padding-top:2px" href = "./customer_review.php">
           <div class="statistic" style="margin:0 auto">
            <div class="value">
              <i class="large history icon"></i>
            </div>
            <div class="label" style="font-size:9px">
              Review
            </div>
          </div>
        </a>
        <a class="item" style="width:25%;padding-bottom:2px;padding-top:2px" href = "./customer_info.php">
           <div class="statistic" style="margin:0 auto">
            <div class="value">
              <i class="large user icon"></i>
            </div>
            <div class="label" style="font-size:9px">
              Me&nbsp;
            </div>
          </div>
        </a>
      </div>
     <div class="ui raised segment">
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
            You have not buy anything
          </div>
          <p>You may try to buy something in home tab</p>
        </div>';
        }
        else {
            while($row = mysqli_fetch_array($result)){
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
              $imgsrc=  './images/square-image.png';
            else $imgsrc='./images/product/'.$row["product_id"].$suffix;
            
            echo '<div class="ui grid">
                    <div class="row">
                      <div class="six wide column">
                        <img src="'.$imgsrc.'" style="width:100%">
                      </div>
                      <div class="ten wide column">
                        <h3>'.$row["product_name"].'</h3>
                        <div class="ui labels">
                          <div class="ui label">
                            <i class="yen icon"></i>'.$row["product_price"].'
                          </div>
                          <div class="ui label">
                            <i class="history icon"></i>'.$row["dealtime"].'
                          </div>
                        </div>
                      </div> 
                    <div class="segment">&nbsp;&nbsp;';
                    if ($row["status_id"]=="0")
                    echo '<label class="ui blue large label"><i class="rocket icon"></i>Waiting for ship</label>';
                    else  if ($row["status_id"]=="1")
                    echo '<label class="ui teal large label"><i class="rocket icon"></i>Waiting for deliverer</label>';
                    else  if ($row["status_id"]=="2")
                    echo '<label class="ui olive large label"><i class="rocket icon"></i>Waiting for dispatch</label>';
                    else  if ($row["status_id"]=="3")
                    echo '<label class="ui green large label"><i class="rocket icon"></i>Dispatching</label>';
                    echo '<button class="ui right floated red tiny button" onclick="cancel(\''.$row["id"].'\')"><i class="left ban icon"></i>Cancel</button>';
                   echo' </div>
                  </div><hr style="height:1px;border:none;border-top:1px solid #cccccc;width:90%">';
          }
        
      }
    }
  ?>
    
  </div>

<script>
</script>
<br><br><br>
</body>
    <?php }
  else {?>
  <body>
    <div class="ui container">
        <div class="ui secondary pointing center aligned menu">
          <a class="item" href = "./customer.php">Products</a>
          <a class="item active" href="./customer_progress.php">Progress</a> 
          <a class="item" href = "./customer_review.php">Review</a>
          <a class="item" href = "./customer_info.php">Me</a>
          <div class="ui right dropdown item">
            <div class="text"><?php echo $email?></div>
            <i class="dropdown icon"></i> 
              <div class="menu">
                <a class="ui item" href="./logout.php">Logout</a>
              </div>
          </div>
        </div>
     <div class="ui raised segment">
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
            You have not buy anything
          </div>
          <p>You may try to buy something in home tab</p>
        </div>';
        }
        else {
          echo '<div class="ui divided items">';
            while($row = mysqli_fetch_array($result)){
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
              $imgsrc=  './images/square-image.png';
            else $imgsrc='./images/product/'.$row["product_id"].$suffix;
            echo '
  <div class="item">
    <div class="image">
      <img src="'.$imgsrc.'">
    </div>
    <div class="content">
      <a class="header">
       <div class="ui horizontal small statistic">
    <div class="value">
      '.$row["product_name"].'
    </div>
    <div class="label">
      | '.$row["product_kind"].'
    </div>
    </div>
      </a>
      <div class="meta">
        <span class="cinema">￥'.$row["product_price"].'</span>
      </div>
      <div class="description">
        <p>'.$row["product_description"].'</p>
      </div>
      <div class="extra">
        <label class="ui label"><i class="user icon"></i>'.$row['customer_firstname'].' '.$row['customer_lastname'].'</label>
        <label class="ui label"><i class="phone icon"></i>'.$row['customer_phone'].'</label>
        <label class="ui label"><i class="point icon"></i>'.$row['customer_province'].' '.$row['customer_city'].' '.$row['customer_addr'].'</label>
      </div>
      <div class="extra">';
        if ($row["status_id"]=="0"){
          echo '<label class="ui blue large label"><i class="rocket icon"></i>Waiting for ship</label>
                <button class="ui mini red button" onclick="cancel(\''.$row["id"].'\')"> <i class="ban icon"></i>Cancel</button>';
        }
          
        else  if ($row["status_id"]=="1")
          echo '<label class="ui teal large label"><i class="rocket icon"></i>Waiting for deliverer</label>';
        else  if ($row["status_id"]=="2")
          echo '<label class="ui olive large label"><i class="rocket icon"></i>Waiting for dispatch</label>';
        else  if ($row["status_id"]=="3")
        echo '<label class="ui green large label"><i class="rocket icon"></i>Dispatching</label>';
       echo '</div>
      </div>
    </div>'; 
      }
      echo '</div>';
    }
    }
  ?>
    
  </div>
        </div>
<script>
</script>
<br><br><br>
</body>
<?php }?>
</html>
