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
        $query = "select * from message2 where deliverer_email ='".$deliever_email."'";
        $result = $mysqli->query ($query);
         while($row = mysqli_fetch_array($result)){
            $arr1 = array("id"=>$row["orders_id"]);
            $arr[] = $arr1;
        }
        $query = "delete from message2 where deliverer_email ='".$deliever_email."'";
        $result = $mysqli->query ($query);
        $php_json = json_encode($arr); 
        echo $php_json;
    }
    $mysqli->close();
?>