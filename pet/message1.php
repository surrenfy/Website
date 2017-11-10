<?php 
    session_start();
    $arr = array();
    if ($_SESSION['deliever_email']==null)
    {
        $arr[] = "0";
        $php_json = json_encode($arr); 
        echo $php_json; 
        exit();
    }
    $deliever_email = $_SESSION['deliever_email'];
    $mysqli=new mysqli('localhost', 'root', '510051', 'oto');
    if (mysqli_connect_errno()) {
        $mysqli->close();
        $arr[] = "0";
        $php_json = json_encode($arr); 
        echo $php_json; 
        exit();
    }
    else {
        $result = $mysqli->query ("set names utf8");
        $query = "select * from message1 where deliverer_email ='".$deliever_email."'";
        $result = $mysqli->query ($query);
         while($row1 = mysqli_fetch_array($result)){
            $query1 = "select * from orders where id ='".$row1["orders_id"]."'";
            $result1 = $mysqli->query ($query1);
            if (!$result1->num_rows) 
                continue;
            else {
                $row = mysqli_fetch_assoc($result1);
                if ($row["status_id"]!="1")
                    continue;
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
                {
                $imgsrc=  './images/square-image.png';
                }
                else $imgsrc='./images/product/'.$row["product_id"].$suffix;
                $arr1 = array("id"=>$row["id"],"imgsrc"=>$imgsrc,"product_name"=>$row["product_name"],"product_addr"=>$row["product_province"].' '.$row["product_city"].' '.$row["product_addr"],"customer_addr"=>$row["customer_province"].' '.$row["customer_city"].' '.$row["customer_addr"]);
                $arr[] = $arr1;
            }
         }
        $query = "delete from message1 where deliverer_email ='".$deliever_email."'";
        $result = $mysqli->query ($query);
        $php_json = json_encode($arr); 
        echo $php_json; 
    }
    $mysqli->close();
?>