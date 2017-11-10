<?php 
    session_start();
    $arr = array();
    if ($_SESSION['customer_email']==null)
    {
        $arr[] = "0";
        $php_json = json_encode($arr); 
        echo $php_json; 
        exit();
    }
    $email = $_SESSION['customer_email'];
    $mysqli=new mysqli('localhost', 'root', '510051', 'pingo');
    if (mysqli_connect_errno()) {
        $mysqli->close();
        $arr[] = "0";
        $php_json = json_encode($arr); 
        echo $php_json; 
        exit();
    }
    else {
        $result = $mysqli->query ("set names utf8");
        $query = "select * from message where customer_email ='".$email."'";
        $result = $mysqli->query ($query);
        while($row = mysqli_fetch_array($result)){
            $arr[] = array("type"=>$row["type"]);
        }
        $query = "delete from message where customer_email ='".$email."'";
        $result = $mysqli->query ($query);
        $php_json = json_encode($arr); 
        echo $php_json; 
    }
    $mysqli->close();
?>