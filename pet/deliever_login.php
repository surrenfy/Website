<?php 
//flag 0 for nothing, 1 for wrong pass or email, 2 for missinfo ,3 for database crash
//post email password
  session_start();
  $email ="";
  $password ="";
  if (!empty($_GET["flag"]))
    $flag = $_GET["flag"];
  else if (empty($_POST['email'])||empty($_POST['password']))
    $flag = 0;
  else{
    $email = $_POST['email'];
    $password = $_POST['password'];
    $mysqli=new mysqli('localhost','root','510051','oto');
    if (mysqli_connect_errno()){
        $flag=3;
        }
    else{
      $result = $mysqli->query ("set names utf8");
      $query = "select * from deliverer where email =\"" . $email . "\" and password=\"" . sha1($password) ."\"";
      $result = $mysqli->query ($query);
      $mysqli->close();
      if (!$result->num_rows) {
          $flag=1;
      }
      else {
        $row = mysqli_fetch_assoc($result);
          $_SESSION['deliever_email']=$email;
          $_SESSION['deliever_firstname']=$row['firstname'];
          $_SESSION['deliever_lastname']=$row['lastname'];
          $_SESSION['deliever_phone']=$row['phone'];
          header('Location: ./deliever.php');
        exit();
      }
    }
  }
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

  <title>index</title>
  <style type="text/css">
      body {
        background-color: #DADADA;
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
    else echo '.column {max-width: 450px}';
    echo '</style>';
  ?>
  <script src="./dist/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
  <script src="./dist/semantic.min.js"></script>
  <script src="./dist/less.min.js"></script>
  <script>
  </script>
</head>

<body>
    <div class="ui middle aligned center aligned grid">
      <div class="column">
        <h2 class="ui blue header">
          <div class="content">
            Log-in to your account
          </div>
        </h2>
        <form class="ui large fluid form" method="POST">
          <div class="ui stacked segment">
            <div class="field">
              <div class="ui left icon input">
                <i class="user icon"></i>
                <input type="email" name="email" placeholder="E-mail address" maxlength="32" <?php echo 'value="',$email,'"'?> autofocus required/>
              </div>
            </div>
            <div class="field">
              <div class="ui left icon input">
                <i class="unlock alternate icon"></i>
                <input type="password" name="password" placeholder="Password" minlength="6" maxlength="32" <?php echo 'value="', $password,'"'?>required/>               
              </div>
            </div>
            <?php
                if ($flag==1)
                  echo '<div class="ui tiny negative message"><i class="close icon"></i><div class="header"> Wrong password or Unregistered email </div></div>';
                else if ($flag==2)
                  echo '<div class="ui tiny negative message"><i class="close icon"></i><div class="header"> We\'ve lost your info. Please relogin </div></div>';
                else if ($flag==3)
                  echo '<div class="ui tiny negative message"><i class="close icon"></i><div class="header"> Database error. Try again later </div></div>';
            ?>
            <button class="ui fluid large orange animated fade submit button"  formaction="deliever_login.php">
             <div class="visible content">Login</div>
              <div class="hidden content">
                 Log-in as deliever
              </div>
            </button>
            </div>
        </form>
        <?php
      if ($flag==3){
        echo "<div class=\"ui error\">";
        echo "can't get to the server for the moment </div>";
      }
      ?>
        <div class="ui info message">New to us? <a href="./reg_deliever.php" style="text-decoration:underline">signup now</a></div>
      </div>
      
    </div>
    <script>
      $('.message .close')
       .on('click', function() {
        $(this)
      .closest('.message')
      .transition('fade')
          ;
       })
        ;
      $('.ui.radio.checkbox')
        .checkbox();
    </script>
</body>

</html>