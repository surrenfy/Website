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
    $flag=0;
    $mysqli=new mysqli('localhost', 'root', '510051', 'oto');
    if (mysqli_connect_errno()) {
        $flag=3;
        $mysqli->close();
    }
    else {
        $result = $mysqli->query ("set names utf8");
        $query = 'select * from orders where deliverer_email = "'.$email.'" and status_id < 4 order by status_id desc,dealtime desc';
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
<script src="./dist/jquery.form.js"></script>
  <script src="./dist/semantic.min.js"></script>
  <script src="./dist/less.min.js"></script>
  <script>
    function dispatch(id){
        var myform = document.createElement("form"); 
        var myinput = document.createElement("input"); 
        myinput.type="text";
        myinput.name = "id";
        myinput.value = id;
        myform.appendChild(myinput);
        myform.method="post";
        myform.action="./deliever_disrecv.php?func=dispatch";
        myform.id="myform";
        document.body.appendChild(myform);
        $("#myform").ajaxSubmit(function(message) { 
            if (message == "1")
                document.getElementById(id).innerHTML='&nbsp;&nbsp;<label class="ui green large label"><i class="rocket icon"></i>Dispatching</label><button class="ui right floated blue tiny button" onclick="recv(\''+id+'\')"><i class="left shipping icon"></i>Received</button>';
        }); 
        $('#myform').remove();
        $('#input').remove();
    }
    function recv(id){
        var myform = document.createElement("form"); 
        var myinput = document.createElement("input"); 
        myinput.type="text";
        myinput.name = "id";
        myinput.value = id;
        myform.appendChild(myinput);
        myform.method="post";
        myform.action="./deliever_disrecv.php?func=recv";
        myform.id="myform";
        document.body.appendChild(myform);
        $("#myform").ajaxSubmit(function(message) {
            if (message=="1"){
                $('#'+id).remove();
                $('#gird_'+id).remove();
            }
        }); 
        $('#myform').remove();
        $('#input').remove();
    }
    function recvmsg2()
    {
        $.ajax({
          url:'/oto/message2.php',
          type:'post',
          dataType:'json',
          success:function(data){
            for(var i=0;i<data.length;i++){
                alert('order:'+data[i].id+' canceled');
            }
            if (data.length)
                location.reload();
          }//,
        //   error:function(XMLHttpRequest, textStatus, errorThrown) {
        //   //这个error函数调试时非常有用，如果解析不正确，将会弹出错误框
        //     alert(XMLHttpRequest.responseText); 
        //     alert(XMLHttpRequest.status);
        //     alert(XMLHttpRequest.readyState);
        //     alert(textStatus); // parser error;
        //   }
      });
    }
    window.onload = function()
    {
        setInterval("recvmsg2()",1000);
    }
  </script>
</head>

<body>
      <div class="ui inverted fixed bottom sticky menu" style="text-align:center" id="menu">
        <a class="item" style="width:25%;padding-bottom:2px;padding-top:2px" href = "./deliever.php">  
          <div class="statistic" style="margin:0 auto">
            <div class="value">
              <i class="large home icon"></i>
            </div>
            <div class="label" style="font-size:9px">
              Orders
            </div>
          </div>
        </a>
        <a class="item active" style="width:25%;padding-bottom:2px;padding-top:2px" href = "./deliever_handling.php">
           <div class="statistic" style="margin:0 auto">
            <div class="value">
              <i class="large shipping icon"></i>
            </div>
            <div class="label" style="font-size:9px">
                Handling
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
        <a class="item" style="width:25%;padding-bottom:2px;padding-top:2px" href = "./deliever_info.php">
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
            You havn\'t accepted any orders
          </div>
          <p>You may try to accept in order tab</p>
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
            
            echo '<div class="ui grid" >
                    <div class="row" id="gird_'.$row["id"].'">
                      <div class="six wide column">
                        <img src="'.$imgsrc.'" style="width:100%">
                      </div>
                      <div class="ten wide column">
                        <h3>'.$row["product_name"].'</h3>
                        <div class="ui labels">
                          <div class="ui label">
                            <i class="marker icon"></i>'.$row["product_province"].' '.$row["product_city"].' '.$row["product_addr"].'
                          </div>
                          <div class="ui label">
                            <i class="location arrow icon"></i>'.$row["customer_province"].' '.$row["customer_city"].' '.$row["customer_addr"].'
                          </div>
                        </div>
                      </div> 
                    <div class="segment" id="'.$row["id"].'">&nbsp;&nbsp;';
                    if ($row["status_id"]=="2"){
                        echo '<label class="ui olive large label"><i class="rocket icon"></i>Waiting for dispatch</label>';
                        echo '<button class="ui right floated orange tiny button" onclick="dispatch(\''.$row["id"].'\')"><i class="left shipping icon"></i>Dispatch</button>';
                    }
                    
                    else  if ($row["status_id"]=="3"){
                        echo '<label class="ui green large label"><i class="rocket icon"></i>Dispatching</label>';
                        echo '<button class="ui right floated blue tiny button" onclick="recv(\''.$row["id"].'\')"><i class="left shipping icon"></i>Received</button>';
                    }
                    
                   
                   echo' </div>
                  </div><hr style="height:1px;border:none;border-top:1px solid #cccccc;width:90%">';
          }
        
      }
    }
  ?>
    
  </div>
<script>
</script>
<br><br>
</body>

</html>
