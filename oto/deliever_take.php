<?php 
    session_start();
    $arr = array();
    if (empty($_SESSION['deliever_email'])||empty($_SESSION['deliever_firstname'])||empty($_SESSION['deliever_lastname'])||empty($_SESSION['deliever_phone'])||empty($_POST['id']))
    {
        echo "0";
        exit();
    }
    $deliever_email = $_SESSION['deliever_email'];
    $mysqli=new mysqli('localhost', 'root', '510051', 'oto');
    if (mysqli_connect_errno()) {
        echo "0";
        exit();
    }
    else {
        $result = $mysqli->query ("set names utf8");
        $query = "update orders set status_id ='2' ,deliverer_email='".$_SESSION['deliever_email']."',deliverer_firstname='".$_SESSION['deliever_firstname']."',deliverer_lastname='".$_SESSION['deliever_lastname']."',deliverer_phone='".$_SESSION['deliever_phone']."' where id ='".$_POST['id']."' and status_id = '1'";
        $result = $mysqli->query ($query);
        if (mysqli_affected_rows($mysqli))
            echo "1";
        else echo "2";
    }
    $mysqli->close();
?>