<?php session_start()?>
<?php
  $email =     "";
  $password =  "";
  $confirm  =  "";
  $shopname =  "";
  $flag=0;
  if (empty($_POST['email'])||empty($_POST['password']))
    $flag=0;
  else{
  $email =     $_POST['email'];
  $password =  $_POST['password'];
  if (!empty($_POST['shopname']))
    $shopname = $_POST['shopname'];
  if (!empty($_POST['confirm']))
    $confirm=     $_POST['confirm'];
  
  $mysqli=new mysqli('localhost','root','510051','oto');
  if (mysqli_connect_errno()){
      $flag=3;
  }
  else{
    $result = $mysqli->query ("set names utf8");
    $query = "select * from seller where email =\"".$email."\"";
    $result = $mysqli->query ($query);
    
    if ($result->num_rows) {
        $mysqli->close();
        $flag=1;
      }
    else {
      $query='insert into seller values("'.$email.'","'.sha1($password).'","'.$shopname.'")';
      $result = $mysqli->query ($query);
      $mysqli->close();
      if ($result){
        $_SESSION['seller_email']=$email;
        $_SESSION['shopname'] = $shopname;
        header('Location: ./seller.php');
      }
      else {
        $flag=3;
      }
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

  <title>Sign up</title>

  <style type="text/css">
    body {
      background-color: Snow;
    }

    .image {
      margin-top: -100px;
    }
    
  </style>
  <?php
    echo '<style type="text/css">';
    if ($is_android || $is_iphone){
      echo '.column {max-width: 87.5%}';
    }
      
    else {
      echo '.column {max-width: 450px}';
      echo 'body>.grid {height : 100%}';
    }
      
    echo '</style>';
  ?>
  <script src="./dist/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
  <script src="./dist/semantic.min.js"></script>
  <script src="./dist/less.min.js"></script>
  <script>
    function check()
      {
        if (document.getElementById("password").value==document.getElementById("confirm").value){
            document.getElementById("submit").disabled = false;
            document.getElementById("show_pass_diff").style.display = "none";
        }
        else {
            document.getElementById("submit").disabled = true;
            document.getElementById("show_pass_diff").style.display = "block";
        }
      }
  </script>
</head>

<body>

    <div class="ui center aligned grid">
      <div class="column">
        <h2 class="ui black header">
          <div class="content">
            <br>Sign-up as seller
          </div>
        </h2>
        <form class="ui form" method="POST">
          <div class="ui tall stacked segment">
            <div class="field">
                <label class="ui red ribbon label" style="float:left">Email</label>
                <input type="email" name="email" placeholder="E-mail address" maxlength="32" <?php echo 'value="',$email, '"'?> autofocus required/>
                <?php
                if ($flag==1)
                  echo '<div class="ui pointing red basic label" style="float:left"> The email has existed </div>';
              ?>
            </div>
            <div class="field">
                <label class="ui red ribbon label" style="float:left">Password</label>
                <div class="field">
                  <input type="password" name="password" id="password" placeholder="Password" maxlength="32" minlength="6" onkeyup="check()" <?php echo 'value="',$password, '"'?>required/>
                </div>
                <div class="field">
                  <input type="password" name="confirm" id="confirm" placeholder="Confirm" maxlength="32" minlength="6" onkeyup="check()" <?php echo 'value="',$confirm, '"'?>required/>
                  <div id="show_pass_diff" class="ui pointing red basic label" style="float:left;display:none">
                    The passwords are different
                   </div>
                </div>
            </div>
            <div class="field">
              <label class="ui red ribbon label" style="float:left">Shopname</label>
              <div class="field">
                 <input type="text" name="shopname" placeholder="Shopname" maxlength="32"<?php echo 'value="',$shopname, '"'?>required/>
              </div>
            </div>
            <div class="field">
              <div class="two ui buttons">
                <button class="ui fluid button" type="reset">reset</button>
                <div class="or" data-text="or"></div>
                <button class="ui fluid red button" id="submit" type="submit" formaction="./reg_seller.php">Sign-up</button>
              </div>
            </div>
         </div>
        </form>

       <div class="ui info message ">
           Sign-up as <a href="./reg_customer.php" style="text-decoration:underline">customer </a>or <a href="./index.php" style="text-decoration:underline">log-in</a> now
       </div>
      </div>
    </div>
    <script>
    </script>

</body>

</html>