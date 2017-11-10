<?php
    session_start();
    if ($_SESSION['deliever_email']==null)
    {
        header('Location: ./deliever_login.php?flag=2');
        exit();
    }
    $deliever_email = $_SESSION['deliever_email'];
    $flag=0;
    $mysqli=new mysqli('localhost', 'root', '510051', 'oto');
    if (mysqli_connect_errno()) {
        $flag=3;
        $mysqli->close();
    }
    else {
        $result = $mysqli->query ("set names utf8");
        
    }
    //$mysqli->close();
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
  <script src="./dist/json2.js"></script>
  <script src="./dist/less.min.js"></script>
  <script src="./dist/jquery.form.js"></script>
  <script>
    var diff;
    function init(){
        var servertime=new Date("<?php echo date('Y-m-d H:i:s')?>");
        var myDate = new Date();
        diff =  myDate.getTime() - servertime.getTime();
    }
    function getDatestr(date)
    {
        var seperator1 = "-";
        var seperator2 = ":";
        var month = date.getMonth() + 1;
        var strDate = date.getDate();
        if (month >= 1 && month <= 9) {
            month = "0" + month;
        }
        if (strDate >= 0 && strDate <= 9) {
            strDate = "0" + strDate;
        }
        var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate
                + " " + date.getHours() + seperator2 + date.getMinutes()
                + seperator2 + date.getSeconds();
        return currentdate;
    }
    function setact(){
        var myDate = new Date();
        myDate.setTime(myDate.getTime() - diff);
        var datestr = getDatestr(myDate);
        var myform = document.createElement("form"); 
        var myinput = document.createElement("input"); 
        myinput.type="text";
        myinput.name = "lastact";
        myinput.value = datestr;
        myform.appendChild(myinput);
        myform.method="post";
        myform.action="./deliever_setact.php";
        myform.id="myform";
        document.body.appendChild(myform);
        $("#myform").ajaxSubmit(function(message) { 
            ;
        }); 
        $('#myform').remove();
        $('#input').remove();
    }

    function take(id)
    {
        var myform = document.createElement("form"); 
        var myinput = document.createElement("input"); 
        myinput.type="text";
        myinput.name = "id";
        myinput.value = id;
        myform.appendChild(myinput);
        myform.method="post";
        myform.action="./deliever_take.php";
        myform.id="myform";
        document.body.appendChild(myform);
        $("#myform").ajaxSubmit(function(message) { 
            if (message=='1')
              alert("success");
            else 
              alert("failed");
        }); 
        $('#myform').remove();
        $('#input').remove();
        $('#'+id).remove();
    }
    function recvmsg1()
    {
        var cards=document.getElementById("cards");
        $.ajax({
          url:'/oto/message1.php',
          type:'post',
          dataType:'json',
          success:function(data){
            for(var i=0;i<data.length;i++){
              // echo '<div class="card" style="width:45.57%">
              //     <img src="'.$imgsrc.'" style="width:100%">
              //   <div class="content">
              //     <a class="header">'.$row["name"].'</a>
              //     <div class="meta">
              //       <span class="date">￥'.$row["price"].'</span>
              //     </div>
              //   </div>
              //   <div class="extra content">
              //     <button class="ui fluid red button" onclick="show(\''.$row["id"].'\',\''.$imgsrc.'\',\''.$row["name"].'\',\''.$row["description"].'\',\''.$row["price"].'\')">Buy</button>
              //   </div>
              // </div>';     
              var card = document.createElement("div");
              card.id=data[i].id;
              card.className="card";
              card.style.width="45.57%";
              card.innerHTML='<img src="'+data[i].imgsrc+'" style="width:100%"><div class="content"><a class="header">'+data[i].product_name+'</a><div class="meta"><span class="date">'+data[i].product_addr+'</span></div><div class="meta"><span class="date">'+data[i].customer_addr+'</span></div></div><div class="extra content"><button class="ui fluid green button" onclick="take(\''+data[i].id+'\')">Take</button></div></div>';
              if(cards.children[0])
　　　　        cards.insertBefore(card,cards.children[0]);
　　          else
　　　　        cards.appendChild(card);　
            }　
          }//,
          // error:function(XMLHttpRequest, textStatus, errorThrown) {
          // //这个error函数调试时非常有用，如果解析不正确，将会弹出错误框
          //   alert(XMLHttpRequest.responseText); 
          //   alert(XMLHttpRequest.status);
          //   alert(XMLHttpRequest.readyState);
          //   alert(textStatus); // parser error;
          // }
      });

    }
    window.onload = function()
    {
        init();
        setTimeout("setact()",1000);
        setInterval("setact()",300000);
        setInterval("recvmsg1()",1000);
    }
  </script>
</head>

<body>
      <div class="ui inverted fixed bottom sticky menu" style="text-align:center" id="menu">
        <a class="item centered active" style="width:25%;padding-bottom:2px;padding-top:2px" href = "./deliever.php">  
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
  <div class="ui raised segment" style="padding:0px">
    <div class="ui link cards" style="margin:0px" id="cards">

    </div>
  </div>
<script>

</script>
<br><br><br>
</body>

</html>
