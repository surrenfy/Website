<?php
    session_start();
    if (empty($_SESSION['deliever_email'])||empty($_SESSION['deliever_firstname'])||empty($_SESSION['deliever_lastname'])||empty($_SESSION['deliever_phone']))
    {
        header('Location: ./deliever_login.php?flag=2');
        exit();
    }
    $email = $_SESSION['deliever_email'];
    $firstname = $_SESSION['deliever_firstname'];
    $lastname = $_SESSION['deliever_lastname'];
    $phone = $_SESSION['deliever_phone'];
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

  <title>deliever</title>
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
  <script src="./dist/semantic.min.js"></script>
  <script src="./dist/less.min.js"></script>
  <script>

  </script>
</head>

<body>
      <div class="ui inverted fixed bottom sticky menu" style="text-align:center" id="menu">
        <a class="item centered" style="width:25%;padding-bottom:2px;padding-top:2px" href = "./deliever.php">  
          <div class="statistic" style="margin:0 auto">
            <div class="value">
              <i class="large home icon"></i>
            </div>
            <div class="label" style="font-size:9px">
              Orders
            </div>
          </div>
        </a>
        <a class="item" style="width:25%;padding-bottom:2px;padding-top:2px" href = "./deliever_handling.php">
           <div class="statistic" style="margin:0 auto">
            <div class="value">
              <i class="large shipping icon"></i>
            </div>
            <div class="label" style="font-size:9px">
                Progress
            </div>
          </div>
        </a>
        <a class="item" style="width:25%;padding-bottom:2px;padding-top:2px" href = "./deliever_review.php">
           <div class="statistic" style="margin:0 auto">
            <div class="value">
              <i class="large history icon"></i>
            </div>
            <div class="label" style="font-size:9px">
              Review
            </div>
          </div>
        </a>
        <a class="item active" style="width:25%;padding-bottom:2px;padding-top:2px" href = "./deliever_info.php">
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
     <div class="ui raised segments" style="padding:0px">
        <div class="ui segment">
            <p><i class="mail icon"></i><?php echo $email?></p>
        </div>
        <div class="ui segment">
            <p><i class="user icon"></i><?php echo $firstname,' ',$lastname?></p>
        </div>
        <div class="ui segment">
            <p><i class="phone icon"></i><?php echo $phone?></p>
        </div>
        <div class="ui segment">
            <div class="ui fluid red button" onclick="window.location.href='deliever_logout.php';">Log out</div>
        </div>
      </div>
    </div>

<script>
</script>

</body>

</html>
