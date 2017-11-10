<?php 
//flag 0 for nothing,1 for duplicated email, 3 for database crash 
  session_start();
  $email =     "";
  $password =  "";
  $confirm  =  "";
  $firstname = "";
  $lastname =  "";
  $gender =    "";
  $phone =     "";
  $province =  "";
  $city     =  "";
  $addr  =     "";
  $flag=0;
  if (empty($_POST['email'])||empty($_POST['password']))
    $flag=0;
  else{
  $email =     $_POST['email'];
  $password =  $_POST['password'];
  if (!empty($_POST['firstname']))
    $firstname = $_POST['firstname'];
  if (!empty($_POST['lastname']))
    $lastname =  $_POST['lastname'];
  if (!empty($_POST['gender']))
    $gender =    $_POST['gender'];
  if (!empty($_POST['phone']))
    $phone =     $_POST['phone'];
  if (!empty($_POST['province'])&&$_POST['province']!="Province")
    $province  =     $_POST['province'];
  if (!empty($_POST['city'])&&$_POST['city']!="City")
    $city  =     $_POST['city'];
  if (!empty($_POST['addr']))
    $addr  =     $_POST['addr'];
  if (!empty($_POST['confirm']))
    $confirm=     $_POST['confirm'];
  $mysqli=new mysqli('localhost','root','510051','oto');
  if (mysqli_connect_errno()){
      $flag=3;
  }
  else{
    $result = $mysqli->query ("set names utf8");
    $query = "select * from customer where email =\"".$email."\"";
    $result = $mysqli->query ($query);
    
    if ($result->num_rows) {
        $mysqli->close();
        $flag=1;
      }
    else {
      $query='insert into customer values("'.$email.'","'.sha1($password).'","'.$firstname.'","'.$lastname.'","'.$gender.'","'.$phone.'","'.$province.'","'.$city.'","'.$addr.'")';
      $result = $mysqli->query ($query);
      $mysqli->close();
      if ($result){
        $_SESSION['customer_email']    =$email;
        $_SESSION['customer_firstname']=$firstname;
        $_SESSION['customer_lastname'] =$lastname;
        $_SESSION['customer_phone']    =$phone;
        $_SESSION['customer_province'] =$province;
        $_SESSION['customer_city']     =$city;
        $_SESSION['customer_addr']     =$addr;
        header('Location: ./customer.php');
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
    function reset_select(){
     $('#province')
      .dropdown('clear');
      ;
     document.getElementById("city").innerHTML='<option value="">City</option>';
     $('#city')
      .dropdown('clear');
      ;
    
    }
     window.onload =function()
     {
       province_change();
     }
  </script>
</head>

<body>

    <div class="ui center aligned grid">
      <div class="column">
        <h2 class="ui black header">
          <div class="content">
            <br>Sign-up as customer
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
              <label class="ui green ribbon label" style="float:left">Name</label>
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
              <label class="ui green ribbon label" style="float:left">Phone & Gender</label>
              <div class="field">
                <div class="two fields"> 
                  <div class="field">
                    <input type="text" name="phone" placeholder="Phone" maxlength="16"<?php echo 'value="',$phone, '"'?>/>
                  </div>
                  <div class="field">
                    <select name="gender" id="gender" class="ui dropdown">
                      <option value="">Gender</option>
                      <option value="male">Male</option>
                      <option value="female">Female</option>
                    </select>
                  </div>
                </div>
              <div>
            </div>
            <div class="field">
              <label class="ui green ribbon label" style="float:left">Address</label>
              <div class="field">
                <div class="two fields">
                  <div class="field">
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
                  <div class="field">
                      <select class="ui fluid dropdown" name="city" id="city">
                        <option value="">City</option>
                      </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="field">
               <textarea rows="3" style="resize:none" name="addr" placeholder="Address" maxlength="256" <?php echo 'value="',$address, '"'?>></textarea>
            </div>
            <div class="field">
              <div class="two ui buttons">
                <button class="ui fluid button" type="reset" onclick="reset_select()">reset</button>
                <div class="or" data-text="or"></div>
                <button class="ui fluid red button" id="submit" type="submit" formaction="./reg_customer.php">Sign-up</button>
              </div>
            </div>
         </div>
        </form>

       <div class="ui info message ">
           Sign-up as <a href="./reg_seller.php" style="text-decoration:underline">seller </a>or <a href="./index.php" style="text-decoration:underline">log-in</a> now
       </div>
      </div>
    </div>
    <script>
      $('.ui.radio.checkbox')
        .checkbox();
      $('#gender')
        .dropdown();
      $('#province')
        .dropdown();
      $('#city')
        .dropdown();
;

    </script>

</body>

</html>