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
        if (!empty($_POST['kind'])&&$_POST['kind']!="all"&&!empty($_POST['keyword']))
          $query = 'select * from product where kind="'.$_POST['kind'].'" and (name like "%'.$_POST['keyword'].'%" or description like "%'.$_POST['keyword'].'%")';
        else if (!empty($_POST['keyword']))
          $query = 'select * from product where name like "%'.$_POST['keyword'].'%" or description like "%'.$_POST['keyword'].'%"';
        else if (!empty($_POST['kind'])&&$_POST['kind']!="all")
          $query = 'select * from product where kind="'.$_POST['kind'].'"';
        else $query = 'select * from product';
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

  function show(id){
    document.getElementById("buy_name").innerHTML         =document.getElementById("name_"+id).innerHTML;
    document.getElementById("buy_price").innerHTML        =document.getElementById("price_"+id).innerHTML;
    document.getElementById("buy_kind").innerHTML         =document.getElementById("kind_"+id).innerHTML;
    document.getElementById("buy_description").innerHTML  =document.getElementById("description_"+id).innerHTML;
    document.getElementById("buy_contact").innerHTML      =document.getElementById("contact_"+id).innerHTML;
    document.getElementById("buy_img").src                =document.getElementById("img_"+id).src;
    document.getElementById("id").value=id;
    $('#buy')
      .modal('show')
    ;
  }
  function pay()
  {
    $("#order").ajaxSubmit(function(message) { 
           
        }); 
    $('#pay')
      .modal('hide')
    ;
  }
  var city=[['Beijing'],['Shanghai'],['Tianjin'],['ChongQing'],
              ['Shijiazhuang','Tangshan','Qinhuangdao','Handan','Xingtai','Baoding','Zhangjiakou','Chengde','Cangzhou','Langfang','Hengshui'],
              ['Taiyuan','Datong','Yangquan','Changzhi','Jincheng','Shuoguang','Xinzhou','Lvliang','Jinzhong','Linfen','Yuncheng'],
              ['Huhehaote','Baotou','Wuhai','Chifeng','Hulunbeier','Tongliao','Wulanchabu','Eerduosi','Bayanzhuoer'],
              ['Shenyang','Dalian','Anshan','Fushun','Benxi','Dandong','Jinzhou','Yingkou','Fuxin','Liaoyang','Panjin','Tieling','Chaoyang','Huludao'],
              ['Changchun','Jilin','Siping','Liaoyuan','Tonghua','Baishan','Baicheng','Songyuan'],
              ['Haerbin','Qiqihaer','Mudanjiang','Jiamusi','Daqing','Yichun','Jixi','Hegang','Shuangyashan','Qitaihe','Suihua','Heihe'],
              ['Jiangsu','Wuxi','Xuzhou','Changzhou','Suzhou','Nantong','Lianyungang','Huaian','Yancheng','Yangzhou','Zhenjiang','Taizhou','Suqian'],
              ['Hangzhou','Ningbo','Wenzhou','Shaoxing','Huzhou','Jiaxing','Jinhua','Hengzhou','Taizhou','Lishui','Zhoushan'],
              ['Hefei','Wuhu','Bengfu','Huainan','Maanshan','Huaibei','Tongling','Anqing','Huangshan','Fuyang','Suzhou','Chuzhou','Liuan','Xuancheng','Chizhou','Haozhou'],
              ['Fuzhou','Xiamen','Quanzhou','Putian','Zhangzhou','Longyan','Sanming','Nanping','Ningde'],
              ['Nanchang','Ganzhou','Yichun','Jian','Shangrao','Fuzhou','Jiujiang','Jingdezhen','Pingxiang','Xinyu','Yingtan'],
              ['Jinan','Qingdao','Zibo','Zaozhuang','Dongying','Yantai','Weifang','Jining','Taian','Weihai','Rizhao','Binzhou','Liaocheng','Linyi','Heze','Laiwu'],
              ['Zhengzhou','Kaifeng','Luoyang','Pingdingshan','Hebi','Xinxiang','Jiaozuo','Puyang','Xuchang','Luohe','Sanmenxia','ShangQiu','Zhoukou','Zhumadian','Nanyang','Xinyang'],
              ['Wuhan','Huangshi','Shiyan','Jingzhou','Yichang','Xiangyang','Ezhou','Jingmen','Huanggang','Xiaogan','Xianning','Suizhou'],
              ['Changzhou','Zhuzhou','Xiangtan','Shaoyang','Yueyang','Zhangjiajie','Yiyang','Changde','Loudi','Binzhou','Yongzhou','Huaihua'],
              ['Guangzhou','Shenzhen','Zhuhai','Shantou','Foshan','Shaoguan','Zhanjiang','Fuqing','Jiangmen','Maoming','Huizhou','Meizhou','Shanwei','Heyuan','Yangjiang','Qingyuan','Dongguan','Zhongshan','Chaozhou','Jieyang','Yunfu'],
              ['Nanning','Liuzhou','Guilin','Wuzhou','Beihai','Chongzuo','Laibin','Hezhou','Yulin','Baise','Hechi','Qinzhou','Fangchenggang','Guigang'],
              ['Haikou','Sanya','Danzhou','Sansha'],
              ['Chengdu','Mianyang','Zigong','Panzhihua','Luzhou','Deyang','Guangyuan','Suishi','Neijiang','Leshan','Ziyang','Yibin','Nanchong','Dazhou','Yaan','Guangan','Bazhong','Meishan'],
              ['Guiyang','Liupanshui','Zunyi','Yongren','Bijie','Anshun'],
              ['Kunming','Zhaotong','Qujing','Yuxi','Puer','Baoshan','Lijiang','Lincang'],
              ['Lasa','Changdu','Shannan','rikaze','Linzhi'],
              ['Shanxi','Tongchuan','Boaji','Xianyang','Winan','Hanzhong','Ankang','Shangluo','Yanan','Yulin'],
              ['Lanzhou','Jiayuguan','Jinchang','Baiyin','Tianshui','Jiuquan','Zhangye','Wuwei','Dingxi','Longnan','Pingliang','Qingyang'],
              ['Xining','Haidong'],
              ['Yinchuan','Shizuishan','Wuzhong','Guyuan','Zhongwei'],
              ['Wulumuqi','Kelamayi','Tulufan','Hami'],
              ['Taiwan'],['Hongkong'],['Macao']
              ];
    var province=['Beijing','Shanghai','Tianjin','Chongqing','Hebei','Shanxi','Nei Monggol','Liaoning','Jilin','Heilongjiang','Jiangsu','Zhejiang','Anhui','Fujian','Jiangxi','Shandong','Henan','Hubei','Hunan','Guangdong','Guangxi','Hainan','Sichuan','Guizhou','Yunnan','Tibet','Shaanxi','Gansu','Qinghai','Ningxia','Xinjiang','Taiwan','Hongkong','Macao'];
   function province_change()
    {
      var prov = document.getElementById("province").value;
      var c = city[province.indexOf(prov)];
      var option='';
      for(var i=0;i<c.length;i++){
        option+='<option value="'+c[i]+'">'+c[i]+'</option>';
      }
      document.getElementById("city").innerHTML=option;
      $('#city')
      .dropdown('clear');
      ;
      $('#city')
      .dropdown('show');
      ;
    }
    window.onload = function()
    {
      $('#province')
      .dropdown('set selected','<?php echo $province ?>');
      ;
      province_change();
      $('#city')
      .dropdown('set selected','<?php echo $city ?>');
      ;
    }
  </script>
</head>
<?php if ($is_android || $is_iphone)
    {?>
<body>
      <div class="ui inverted fixed bottom sticky menu" style="text-align:center" id="menu">
        <a class="item centered active" style="width:25%;padding-bottom:2px;padding-top:2px" href = "./customer.php">  
          <div class="statistic" style="margin:0 auto">
            <div class="value">
              <i class="large home icon"></i>
            </div>
            <div class="label" style="font-size:9px">
              Home
            </div>
          </div>
        </a>
        <a class="item" style="width:25%;padding-bottom:2px;padding-top:2px" href = "./customer_progress.php">
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
     <div class="ui raised segment" style="padding:0px">
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
            Product list is empty
          </div>
          <p>You may contact with developers</p>
        </div>';
        }
        else {
          echo '<div class="ui link cards" style="margin:0px">';
          while($row = mysqli_fetch_array($result)){
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
              $imgsrc=  './images/square-image.png';
            }
            else $imgsrc='./images/product/'.$row["id"].$suffix;

            echo '<div class="card" style="width:45.57%">
                  <img src="'.$imgsrc.'" style="width:100%">
                <div class="content">
                  <a class="header">'.$row["name"].'</a>
                  <div class="meta">
                    <span class="date">￥'.$row["price"].'</span>
                  </div>
                </div>
                <div class="extra content">
                  <button class="ui fluid red button" onclick="show(\''.$row["id"].'\',\''.$imgsrc.'\',\''.$row["name"].'\',\''.$row["description"].'\',\''.$row["price"].'\')">Buy</button>
                </div>
              </div>';     
          }
        }
    }
  ?>
      </div>
    </div>
<div class="ui first modal" id="buy">
  <i class="close icon"></i>
  <div class="header">Confirm Product Info</div>
  <div class="content">

    <div class="ui stacked segment">
        <div class="ui grid">
      <div class="six wide column">
        <img id="buy_img" src="./images/square-image.png" id="motal_img" style="width:100%">
      </div>
      <div class="ten wide column">
        <h3 id="buy_name">Name</h3>
        <p id="buy_price"> price </p>
        <p id="buy_description"> description<p>
      </div> 
    </div> 
      <form class="ui form" method="POST" id="order" action="./create_order.php">
            <input style="display:none" type="text" name="id" id="id"/>
            <div class="field" style="max-height:32px">
              <div class="two fields"> 
                <div class="field" style="max-width:50%">
                  <input type="text" name="firstname" placeholder="Firstname" maxlength="32" value="<?php echo $firstname ?>"/>
                </div>
                  <div class="field" style="max-width:50%">
                  <input type="text" name="lastname" placeholder="Lastname" maxlength="32" value="<?php echo $lastname ?>"/>
                </div>
              </div>
            </div>
            <div class="field" style="max-height:32px">
              <input type="text" name="phone" placeholder="Phone" maxlength="16" value="<?php echo $phone ?>"/>
            </div>
              <div class="field" style="max-height:32px">
                <div class="two fields">
                  <div class="field" style="max-width:50%">
                      <select class="ui fluid dropdown" name="province" id="province" onchange="province_change()" >
                        <option value="">Province</option>
                        <option value="Beijing">Beijing</option>
                        <option value="Shanghai">Shanghai</option>
                        <option value="Tianjin">Tianjin</option>
                        <option value="Chongqing">Chongqing</option>
                        <option value="Hebei">Hebei</option>
                        <option value="Shanxi">Shanxi</option>
                        <option value="Nei Monggol">Nei Monggol</option>
                        <option value="Liaoning">Liaoning</option>
                        <option value="Jilin">Jilin</option>
                        <option value="Heilongjiang">Heilongjiang</option>
                        <option value="Jiangsu">Jiangsu</option>
                        <option value="Zhejiang">Zhejiang</option>
                        <option value="Anhui">Anhui</option>
                        <option value="Fujian">Fujian</option>
                        <option value="Jiangxi">Jiangxi</option>
                        <option value="Shandong">Shandong</option>
                        <option value="Henan">Henan</option>
                        <option value="Hubei">Hubei</option>
                        <option value="Hunan">Hunan</option>
                        <option value="Guangdong">Guangdong</option>
                        <option value="Guangxi">Guangxi</option>
                        <option value="Hainan">Hainan</option>
                        <option value="Sichuan">Sichuan</option>
                        <option value="Guizhou">Guizhou</option>
                        <option value="Yunnan">Yunnan</option>
                        <option value="Tibet">Tibet</option>
                        <option value="Shaanxi">Shaanxi</option>
                        <option value="Gansu">Gansu</option>
                        <option value="Qinghai">Qinghai</option>
                        <option value="Ningxia">Ningxia</option>
                        <option value="Xinjiang">Xinjiang</option>
                        <option value="Taiwan">Taiwan</option>
                        <option value="Hongkong">Hongkong</option>
                        <option value="Macao">Macao</option>
                      </select>
                  </div>
                  <div class="field" style="max-width:50%">
                      <select class="ui fluid dropdown" name="city" id="city">
                        <option value="">City</option>
                      </select>
                  </div>
                </div>
              </div>
            <div class="field">
               <textarea rows="3" style="resize:none" name="addr" placeholder="Address" maxlength="256" ><?php echo $addr?></textarea>
            </div>
         
        </form>
       
        </div>
     <button class="ui fluid red button" id="pay_btn">Confirm</button>
  </div>

</div>

<div class="ui second modal" id="pay">
  <i class="close icon"></i>
  <div class="header">Pay for it</div>
  <div class="content">
    <div class="ui stacked segment">
      <form class="ui form">
        <div class="field">
          <label>Password</label>
          <input type="password" name="password" placeholder="Password">
        </div>
      </form>
      
    </div>
    <button class="ui fluid red button" type="submit" onclick="pay()">Buy</button>
  </div>

</div>

<script>

  $('#buy')
  .modal({
        transition:'fly up'
      });
  $('#pay')
  .modal({
        transition:'fly up'
      });
  $('#pay')
    .modal('attach events', '#pay_btn', 'show');
  $('#province')
    .dropdown();
  $('#city')
    .dropdown();

</script>

</body>
    <?php }
  else {?>
<body>
    <div class="ui container">
        <div class="ui secondary pointing center aligned menu">
          <a class="item active" href = "./customer.php">Products</a>
          <a class="item" href="./customer_progress.php">Progress</a> 
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
        <div class="ui right action left icon input">
        <i class="search link icon"></i>
        
        <input type="text" placeholder="Search" name="keyword" form="search">
        <select class="ui fluid dropdown" name="kind" form="search">
          <option value="all" selected>All&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
          <option value="pet">Pets&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
          <option value="product">Products</option>
        </select>
        
        <div type="submit" class="ui blue button" onclick='$("#search").submit()'>Search</div>
        <form id="search" action="customer.php" method="post">

        </form>
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
            Product list is empty
          </div>
          <p>You may contact with developers</p>
        </div>';
        }
        else {
          echo '<div class="ui link cards">';
          while($row = mysqli_fetch_array($result)){
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
              $imgsrc=  './images/square-image.png';
            }
            else $imgsrc='./images/product/'.$row["id"].$suffix;

            echo '<div class="card" style="max-width:263px">
                  <img src="'.$imgsrc.'" id="img_'.$row["id"].'"  style="width:100%">
                <div class="content">
                  <a class="header" id="name_'.$row["id"].'">'.$row["name"].'</a>
                  <div class="meta">
                    <span class="date" id="kind_'.$row["id"].'">'.$row["kind"].'</span> ￥<span class="date" id="price_'.$row["id"].'">'.$row["price"].'</span>
                  </div>
                  <div class="description" id="description_'.$row["id"].'">
                    '.$row["description"].'
                  </div>
                  <div class="description" id="contact_'.$row["id"].'">
                    '.$row["province"].' , '.$row["phone"].'
                  </div>
                </div>
                <div class="extra content">
                  <button class="ui fluid red button" onclick="show(\''.$row["id"].'\')">Buy</button>
                </div>
              </div>';     
          }
        }
    }
  ?>
      </div>
    </div>
  </div>
<div class="ui first scrolling modal" id="buy">
  <i class="close icon"></i>
  <div class="header">Confirm Product Info</div>
  <div class="content">

    <div class="ui stacked segment">
    <!--<div class="ui grid">
      <div class="six wide column">
        <img id="buy_img" src="./images/square-image.png" style="width:100%">
      </div>
      <div class="ten wide column">
        <h3 id="buy_name">Name</h3>
        <p id="buy_price"> price </p>
        <p id="buy_description"> description<p>
      </div> 
    </div> -->
    <div class="ui items">
    <div class="small item">
    <div class="image">
      <img id="buy_img" src="./images/square-image.png">
    </div>
    <div class="content">
      <a class="header" id="buy_name">name</a>
      <div class="meta">
        <span class="cinema" id="buy_kind">kind</span>
      </div>
      <div class="description">
        <p id="buy_description">description</p>
        <p id="buy_contact">addr</p>
      </div>
      <div class="extra">
        <div class="ui label"><i class="yen icon" id="buy_price"></i></div>
      </div>
    </div>
  </div>
  </div>
      <form class="ui form" method="POST" id="order" action="./create_order.php">
            <input style="display:none" type="text" name="id" id="id"/>
            <div class="field" style="max-height:32px">
              <div class="two fields"> 
                <div class="field" style="max-width:50%">
                  <input type="text" name="firstname" placeholder="Firstname" maxlength="32" value="<?php echo $firstname ?>"/>
                </div>
                  <div class="field" style="max-width:50%">
                  <input type="text" name="lastname" placeholder="Lastname" maxlength="32" value="<?php echo $lastname ?>"/>
                </div>
              </div>
            </div>
            <div class="field" style="max-height:32px">
              <input type="text" name="phone" placeholder="Phone" maxlength="16" value="<?php echo $phone ?>"/>
            </div>
              <div class="field" style="max-height:32px">
                <div class="two fields">
                  <div class="field" style="max-width:50%">
                      <select class="ui fluid dropdown" name="province" id="province" onchange="province_change()" >
                        <option value="">Province</option>
                        <option value="Beijing">Beijing</option>
                        <option value="Shanghai">Shanghai</option>
                        <option value="Tianjin">Tianjin</option>
                        <option value="Chongqing">Chongqing</option>
                        <option value="Hebei">Hebei</option>
                        <option value="Shanxi">Shanxi</option>
                        <option value="Nei Monggol">Nei Monggol</option>
                        <option value="Liaoning">Liaoning</option>
                        <option value="Jilin">Jilin</option>
                        <option value="Heilongjiang">Heilongjiang</option>
                        <option value="Jiangsu">Jiangsu</option>
                        <option value="Zhejiang">Zhejiang</option>
                        <option value="Anhui">Anhui</option>
                        <option value="Fujian">Fujian</option>
                        <option value="Jiangxi">Jiangxi</option>
                        <option value="Shandong">Shandong</option>
                        <option value="Henan">Henan</option>
                        <option value="Hubei">Hubei</option>
                        <option value="Hunan">Hunan</option>
                        <option value="Guangdong">Guangdong</option>
                        <option value="Guangxi">Guangxi</option>
                        <option value="Hainan">Hainan</option>
                        <option value="Sichuan">Sichuan</option>
                        <option value="Guizhou">Guizhou</option>
                        <option value="Yunnan">Yunnan</option>
                        <option value="Tibet">Tibet</option>
                        <option value="Shaanxi">Shaanxi</option>
                        <option value="Gansu">Gansu</option>
                        <option value="Qinghai">Qinghai</option>
                        <option value="Ningxia">Ningxia</option>
                        <option value="Xinjiang">Xinjiang</option>
                        <option value="Taiwan">Taiwan</option>
                        <option value="Hongkong">Hongkong</option>
                        <option value="Macao">Macao</option>
                      </select>
                  </div>
                  <div class="field" style="max-width:50%">
                      <select class="ui fluid dropdown" name="city" id="city">
                        <option value="">City</option>
                      </select>
                  </div>
                </div>
              </div>
            <div class="field">
               <textarea rows="3" style="resize:none" name="addr" placeholder="Address" maxlength="256" ><?php echo $addr?></textarea>
            </div>
         
        </form>
       
        </div>
     <button class="ui fluid red button" id="pay_btn">Confirm</button>
  </div>

</div>

<div class="ui second long modal" id="pay">
  <i class="close icon"></i>
  <div class="header">Pay for it</div>
  <div class="content">
    <div class="ui stacked segment">
      <form class="ui form">
        <div class="field">
          <label>Password</label>
          <input type="password" name="password" placeholder="Password">
        </div>
      </form>
      
    </div>
    <button class="ui fluid red button" type="submit" onclick="pay()">Buy</button>
  </div>

</div>

<script>

  $('#buy')
  .modal({
        transition:'fly up'
      });
  $('#pay')
  .modal({
        transition:'fly up'
      });
  $('#pay')
    .modal('attach events', '#pay_btn', 'show');
  $('#province')
    .dropdown();
  $('#city')
    .dropdown();
  $('#kind')
    .dropdown();
  $('.ui.dropdown')
  .dropdown();
   $('.message .close')
       .on('click', function() {
        $(this)
      .closest('.message')
      .transition('fade')
          ;
       });
</script>
</body>
<?php }?>
</html>
