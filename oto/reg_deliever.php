<?php 
session_start();
  $email =     "";
  $password =  "";
  $confirm  =  "";
  $firstname = "";
  $lastname = "";
  $phone = "";
  $flag=0;
  if (empty($_POST['email'])||empty($_POST['password'])||empty($_POST['confirm'])||empty($_POST['firstname'])||empty($_POST['lastname'])||empty($_POST['phone']))
    $flag=0;
  else{
  $email =     $_POST['email'];
  $password =  $_POST['password'];
  $firstname = $_POST['firstname'];
  $lastname =  $_POST['lastname'];
  $phone    =  $_POST['phone'];

  $mysqli=new mysqli('localhost','root','510051','oto');
  if (mysqli_connect_errno()){
      $flag=3;
  }
  else{
    $result = $mysqli->query ("set names utf8");
    $query = "select * from delivever where email =\"".$email."\"";
    $result = $mysqli->query ($query);

    if (!empty($result)) {
        $mysqli->close();
        $flag=1;
      }
    else {
      $puttime = date("Y-m-d H:i:s");
      $query='insert into deliverer values("'.$email.'","'.sha1($password).'","'.$firstname.'","'.$lastname.'","'.$phone.'","'.$puttime.'")';
      $result = $mysqli->query ($query);
      $mysqli->close();
      if ($result){
        $_SESSION['deliever_email']=$email;
        $_SESSION['deliverer_firstname'] = $firstname;
        $_SESSION['deliverer_lastname'] = $lastname;
        $_SESSION['deliverer_phone'] = $phone;
        header('Location: ./deliever.php');
      }
      else {
        $flag=3;
      }
    }
   }
 }
 echo $flag;
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
            <br>Sign-up as deliever
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
              <label class="ui red ribbon label" style="float:left">Name</label>
              <div class="field">
                <div class="two fields"> 
                  <div class="field">
                   <input type="text" name="firstname" placeholder="Firstname" maxlength="32"<?php echo 'value="',$firstname, '"'?>/>
                  </div>
                   <div class="field">
                    <input type="text" name="lastname" placeholder="Lastname" maxlength="32"<?php echo 'value="',$lastname, '"'?>/>
                  </div>
                </div>
              </div>
            </div>
            <div class="field">
              <label class="ui red ribbon label" style="float:left">Phone</label>
              <div class="field">
                <input type="text" name="phone" placeholder="Phone" maxlength="16" <?php echo 'value="',$phone, '"'?>/>
              </div>
            </div>
            <div class="field">
              <div class="two ui buttons">
                <button class="ui fluid button" type="reset">reset</button>
                <div class="or" data-text="or"></div>
                <button class="ui fluid red button" id="submit" type="submit" formaction="./reg_deliever.php">Sign-up</button>
              </div>
            </div>
         </div>
        </form>
       <div class="ui info message ">
           <a href="./deliever_login.php" style="text-decoration:underline">Already have an account ? Log-in now</a>
       </div>
      </div>
    </div>
    <script>
    </script>

</body>

</html>