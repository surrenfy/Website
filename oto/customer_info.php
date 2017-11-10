<?php
    session_start();
    if (empty($_SESSION['customer_email'])||empty($_SESSION['customer_firstname'])||empty($_SESSION['customer_lastname'])||empty($_SESSION['customer_phone'])||empty($_SESSION['customer_province'])||empty($_SESSION['customer_city'])||empty($_SESSION['customer_addr']))
    {
        header('Location: ./login.php?flag=2');
        exit();
    }
    $email = $_SESSION['customer_email'];
    if (!empty($_POST['firstname'])||!empty($_POST['lastname'])||!empty($_POST['phone'])||!empty($_POST['province'])||!empty($_POST['city'])||!empty($_POST['addr']))
    {
      $firstname = $_SESSION['customer_firstname'];
      $lastname = $_SESSION['customer_lastname'];
      $phone = $_SESSION['customer_phone'];
      $province =$_SESSION['customer_province'];
      $city = $_SESSION['customer_city'];
      $addr = $_SESSION['customer_addr'];
      if (!empty($_POST['firstname'])){
        $firstname = $_POST['firstname'];
        $_SESSION['customer_firstname'] = $_POST['firstname'];
      }
      if (!empty($_POST['lastname'])){
        $lastname = $_POST['lastname'];
        $_SESSION['customer_lastname'] =$_POST['lastname'];
      }
      if (!empty($_POST['phone'])){
        $phone = $_POST['phone'];
        $_SESSION['customer_phone'] = $_POST['phone'];
      }
      if (!empty($_POST['province'])){
        $province = $_POST['province'];
        $_SESSION['customer_province'] = $_POST['province'];
      }
      if (!empty($_POST['city'])){
        $city = $_POST['city'];
        $_SESSION['customer_city'] = $_POST['city'];
      }
      if (!empty($_POST['addr'])){
        $addr = $_POST['addr'];
        $_SESSION['customer_addr'] = $_POST['addr'];
      }
      $mysqli=new mysqli('localhost', 'root', '510051', 'oto');
      if (mysqli_connect_errno()) {
          ;
      }
      else {
          $result = $mysqli->query ("set names utf8");
          $query = 'update customer set firstname="'.$firstname.'",lastname="'.$lastname.'",phone="'.$phone.'",province="'.$province.'",city="'.$city.'",addr="'.$addr.'" where email="'.$email.'"';
          $result = $mysqli->query ($query);
      }
      $mysqli->close();
    }
    else {
    $email = $_SESSION['customer_email'];
    $firstname = $_SESSION['customer_firstname'];
    $lastname = $_SESSION['customer_lastname'];
    $phone = $_SESSION['customer_phone'];
    $province =$_SESSION['customer_province'];
    $city = $_SESSION['customer_city'];
    $addr = $_SESSION['customer_addr'];
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
  <script src="./dist/semantic.min.js"></script>
  <script src="./dist/less.min.js"></script>
  <script>
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
        <a class="item active" style="width:25%;padding-bottom:2px;padding-top:2px" href = "./customer_info.php">
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
        
            <div class="ui fluid red button" onclick="window.location.href='logout.php';">Log out</div>
        </div>
      </div>
    </div>

<script>
</script>

</body>
    <?php }
  else {?>
  <body>
          <div class="ui container">
        <div class="ui secondary pointing center aligned menu">
          <a class="item" href = "./customer.php">Products</a>
          <a class="item" href="./customer_progress.php">Progress</a> 
          <a class="item" href = "./customer_review.php">Review</a>
          <a class="item active" href = "./customer_info.php">Me</a>
          <div class="ui right dropdown item">
            <div class="text"><?php echo $email?></div>
            <i class="dropdown icon"></i> 
              <div class="menu">
                <a class="ui item" href="./logout.php">Logout</a>
              </div>
          </div>
        </div>
     <div class="ui raised segments" style="padding:0px">
        <div class="ui segment">
        <form class="ui form" method="POST" id="info" action="./customer_info.php">
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
        <div class="ui fluid red button" onclick='$("#info").submit()'>Update</div>
      </div>
    </div>
        </div>
<script>
  $('#province')
    .dropdown();
  $('#city')
    .dropdown();
  $('.ui.dropdown')
    .dropdown();
</script>

</body>
<?php }?>
</html>
