<?php session_start()?>

<?php
  if (empty($_SESSION['seller_email'])||empty($_SESSION['shopname']))
  {
      header('Location: ./index.php?flag=2');
      exit();
  }
  $seller_email     = $_SESSION['seller_email'];
  $shopname  = $_SESSION['shopname'];
  $name=          "";
  $kind  =        "";
  $price =        "";
  $description =  "";
  $phone =        "";
  $province =     "";
  $city =         "";
  $addr =         "";
  $remarks =      "";
  $flag=0;//0 for nothing 1 for success ,2 for duplicate ,3 for sql error ,4 for inputfile invalid
if (empty($_POST['name'])||empty($_POST['kind'])||empty($_POST['price'])||empty($_POST['description'])||empty($_POST['province'])||empty($_POST['city'])||empty($_POST['phone'])||empty($_POST['addr'])) {
    $flag=0;
} elseif (!empty($_FILES["inputfile"]["name"])&&!((($_FILES["inputfile"]["type"] == "image/gif")
                ||   ($_FILES["inputfile"]["type"] == "image/jpeg")
                ||   ($_FILES["inputfile"]["type"] == "image/jpg")
                ||   ($_FILES["inputfile"]["type"] == "image/png"))
                &&   ($_FILES["inputfile"]["size"] < 2*1024*1024)
                &&   ($_FILES["inputfile"]["error"] <= 0))) {
    $flag=4;              
    $name= $_POST['name'];
    $kind  =        $_POST['kind'];
    $price =        $_POST['price'];
    $description =  $_POST['description'];
    $province =     $_POST['province'];
    $city =         $_POST['city'];
    $phone    =     $_POST['phone'];
    $addr =         $_POST['addr'];
    if (!empty($_POST['remarks'])) {
        $remarks =  $_POST['remarks'];
    }
} else {
    $name= $_POST['name'];
    $kind  =        $_POST['kind'];
    $price =        $_POST['price'];
    $description =  $_POST['description'];
    $province =     $_POST['province'];
    $city =         $_POST['city'];
    $phone    =     $_POST['phone'];
    $addr =         $_POST['addr'];
    if (!empty($_POST['remarks'])) {
        $remarks =  $_POST['remarks'];
    }
    $mysqli=new mysqli('localhost', 'root', '510051', 'oto');
    if (mysqli_connect_errno()) {
        $flag=3;
    } else {
        $result = $mysqli->query ("set names utf8");
        $query = 'select * from product where seller_email ="'.$seller_email.'" and name = "'.$name.'"';
        $result = $mysqli->query ($query);
        if ($result->num_rows) {
            $flag=2;
        } else {
            $puttime = date("Y-m-d H:i:s");
            $query='insert into product (name,kind,description,phone,province,city,addr,remarks,price,seller_email,puttime) values("'.$name.'","'.$kind.'","'.$description.'","'.$phone.'","'.$province.'","'.$city.'","'.$addr.'","'.$remarks.'","'.$price.'","'.$seller_email.'","'.$puttime.'")';
            $result = $mysqli->query ($query);
            if ($result) {
                $flag=1;
                if (!empty($_FILES["inputfile"])) {
                    $query = 'select id from product where seller_email ="'.$seller_email.'" and name = "'.$name.'"';
                    $result = $mysqli->query ($query);
                    $row = mysqli_fetch_assoc($result);
                    move_uploaded_file($_FILES["inputfile"]["tmp_name"],
                    'images/product/'.$row['id'].'.'.substr(strrchr($_FILES["inputfile"]["name"], '.'), 1));
                }
            } else {
                $flag=3;
            }
        }
    }
    $mysqli->close();
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
    if ($is_android || $is_iphone) {
        echo '<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />';
    }
    ?>
  <link rel="stylesheet" type="text/css" href="./dist/semantic.min.css">

  <title>Seller</title>
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
    function F_Open_dialog() 
    { 
        document.getElementById("inputfile").click(); 
    } 
    function getPath(obj,fileQuery,transImg) {
      var imgSrc = '', imgArr = [], strSrc = '' ;
      if(window.navigator.userAgent.indexOf("MSIE")>=1){ // IE浏览器判断
        if(obj.select){
          obj.select();
          var path=document.selection.createRange().text;
          alert(path) ;
          obj.removeAttribute("src");
          imgSrc = fileQuery.value ;
          imgArr = imgSrc.split('.') ;
          strSrc = imgArr[imgArr.length - 1].toLowerCase() ;
          if(strSrc.localeCompare('jpg') === 0 || strSrc.localeCompare('jpeg') === 0 || strSrc.localeCompare('gif') === 0 || strSrc.localeCompare('png') === 0){
          obj.setAttribute("src",transImg);
          obj.style.filter=
            "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='"+path+"', sizingMethod='scale');"; // IE通过滤镜的方式实现图片显示
          }else{
          //try{
          throw new Error('File type Error! please image file upload..'); 
          //}catch(e){
          // alert('name: ' + e.name + 'message: ' + e.message) ;
          //}
          }
        }
        else{
          // alert(fileQuery.value) ;
          imgSrc = fileQuery.value ;
          imgArr = imgSrc.split('.') ;
          strSrc = imgArr[imgArr.length - 1].toLowerCase() ;
          if(strSrc.localeCompare('jpg') === 0 || strSrc.localeCompare('jpeg') === 0 || strSrc.localeCompare('gif') === 0 || strSrc.localeCompare('png') === 0){
          obj.src = fileQuery.value ;
          }
          else{
            //try{
            throw new Error('File type Error! please image file upload..') ;
            //}catch(e){
            // alert('name: ' + e.name + 'message: ' + e.message) ;
            //}
          }
        }
      }
      else{
        var file =fileQuery.files[0];
        var reader = new FileReader();
        reader.onload = function(e){
      
        imgSrc = fileQuery.value ;
        imgArr = imgSrc.split('.') ;
        strSrc = imgArr[imgArr.length - 1].toLowerCase() ;
        if(strSrc.localeCompare('jpg') === 0 || strSrc.localeCompare('jpeg') === 0 || strSrc.localeCompare('gif') === 0 || strSrc.localeCompare('png') === 0){
        obj.setAttribute("src", e.target.result) ;
        }else{
          //try{
          throw new Error('File type Error! please image file upload..') ;
          //}catch(e){
          // alert('name: ' + e.name + 'message: ' + e.message) ;
          //}
        }
      
        // alert(e.target.result); 
        }
        reader.readAsDataURL(file);
      }
    }
    
    function show(){
      //以下即为完整客户端路径
      var file_img=document.getElementById("image"),
      inputfile = document.getElementById('inputfile') ;
      getPath(file_img,inputfile,file_img) ;
    }
    function resetimg(){
      document.getElementById("image").src="./images/square-image.png";
      $('#province')
      .dropdown('clear');
      ;
     document.getElementById("city").innerHTML='<option value="">City</option>';
     $('#city')
      .dropdown('clear');
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
   function city_change(){
      if (document.getElementById("city").value!='')
        document.getElementById("no_city").style="display:none";
   }
   function province_change()
    {
      var prov = document.getElementById("province").value;
      if (prov!='')
        document.getElementById("no_province").style="display:none";
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
       $('#province')
        .dropdown('set selected', '<?php echo $province?>')
      ;
      province_change();
      $('#city')
        .dropdown('set selected', '<?php echo $city?>')
      ;
     }
     function check_form()
     {
        var x= true;
       if (document.getElementById("province").value==''){
          document.getElementById("no_province").style="float:left;display:block";
          x = false;
       }
       else 
          document.getElementById("no_province").style="display:none";
       if (document.getElementById("city").value==''){
          document.getElementById("no_city").style="float:left;display:block";
          x = false;
       } 
       else
          document.getElementById("no_city").style="display:none";
      return x;
     }
  </script>
</head>

<body>

    <div class = "ui container">
      <div class="ui secondary pointing center aligned menu">
        <a class="item" href = "./seller.php">Products</a>
        <a class="item active" href="./seller_addnew.php">Addnew</a> 
        <a class="item" href = "./seller_orders.php">Orders</a>
        <a class="item" href = "./seller_review.php">Review</a>

        <div class="ui right dropdown item" id="usermenu">
          <div class="text"><?php echo $shopname?> </div>
          <i class="dropdown icon"></i> 
            <div class="menu">
              <a class="ui item"> 
                <?php echo $seller_email;?> 
              </a>
              <div class="divider"></div>
              <a class="ui item" href="./logout.php">Logout</a>
            </div>
          <div>
        </div>
      </div>
    </div>
<?php
if ($flag==1){
echo '<div class="ui success message">
  <i class="close icon"></i>
  <div class="header">
    Your product <'.$name.'> was put away successfully.
  </div>
  <p>You may now see it in the product tab</p>
</div>';
}
if ($flag==2){
echo '<div class="ui error message">
  <i class="close icon"></i>
  <div class="header">
    Your product <'.$name.'> has been put away already.
  </div>
  <p>You may delete it first in the product tab</p>
</div>';
}
if ($flag==3){
echo '<div class="ui error message">
  <i class="close icon"></i>
  <div class="header">
    We have some problems with database.
  </div>
  <p>You may retry later</p>
</div>';
}
if ($flag==4){
echo '<div class="ui error message">
  <i class="close icon"></i>
  <div class="header">
    Your upload image was invalid.
  </div>
  <p>'.$query.'</p>
</div>';
}

?>
<form class="ui form" enctype="multipart/form-data" method="POST"  onsubmit="return check_form()">
  <h4 class="ui dividing header">Required Information</h4>
  <div class="field">
    <label>Name &amp; Kind</label>
    <div class="fields">
      <div class="six wide field">
        <input type="text" name="name" placeholder="Name" maxlength="32" <?php if ($flag>1) echo 'value="'.$name.'"'?> required>
      </div>
      <div class="ten wide field">
        <input type="text" name="kind" placeholder="Kind" maxlength="32" <?php if ($flag>1) echo 'value="'.$kind.'"'?> required>
      </div>
    </div>
  </div>

  <div class="field">
    <label>Description &amp; Price</label>
    <div class="fields">
      <div class="three wide field">    
          <div class="ui left icon input">
            <i class="yen icon"></i>
            <input type="text" name="price" maxlength="9" pattern=(^[1-9]\d*(\.\d{1,2})?$)|(^[0]{1}(\.\d{1,2})?$) <?php if ($flag>1) echo 'value="'.$price.'"'?> required>
          </div>
      </div>
      <div class="thirteen wide field">
        <input type="text" name="description" placeholder="Description" maxlength="64" <?php if ($flag>1) echo 'value="'.$description.'"'?> required>
      </div>
    </div>
  </div>
  <div class="field">
    <label>Contact</label>
    <div class="three fields">
      <div class="field">
          <select class="ui fluid dropdown" name="province" id="province" onchange="province_change()">
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
          <div id="no_province" class="ui pointing red basic label" style="float:left;display:none">
              Please select a province
          </div>
      </div>
      <div class="field">
          <select class="ui fluid dropdown" name="city" id="city" onchange="city_change()">
            <option value="">City</option>
          </select>
          <div id="no_city" class="ui pointing red basic label" style="float:left;display:none">
              Please select a city
          </div>
      </div>
      <div class="field">
          <input type="text" name="phone" placeholder="Phone" maxlength="16" <?php if ($flag>1) echo 'value="'.$phone.'"'?> required>
      </div>
    </div>
    <div class="ui fluid input">
      <textarea rows="3" name="addr" placeholder="Detail Address" maxlength="256" <?php if ($flag>1) echo 'value="'.$addr.'"'?> required></textarea>
    </div>
  </div>
  <h4 class="ui dividing header">Optional Information</h4>
  <div class="field">
    <label>Image</label>
      <input type="file" name="inputfile" id="inputfile" style="display:none" accept="image/png,image/gif,image/jpg,image/jpeg" onchange="show()"></input>
  </div>
  <img src="./images/square-image.png" width="200px" id="image" onclick="F_Open_dialog()" style="cursor:pointer">

  <div class="field">
    <label>Remarks</label>
    <div class="ui fluid input">
      <textarea rows="2" type="text" name="remarks" placeholder="Remarks" maxlength="64" <?php if ($flag>1) echo 'value="'.$remarks.'"'?>></textarea>
    </div>
  </div>
  <button class="ui button" id="reset" type="reset" onclick="resetimg()">Reset</button>
  <button class="ui red button" id="submit" type="submit" formaction="./seller_addnew.php">Addnew</button>
</form>
<script>
  $('#usermenu')
  .dropdown({action: 'hide'});
   $('.message .close')
       .on('click', function() {
        $(this)
      .closest('.message')
      .transition('fade')
          ;
       });

  $('#province')
    .dropdown();
  $('#city')
    .dropdown();
;
  </script>
</body>

</html>
