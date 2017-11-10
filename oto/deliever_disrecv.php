<?php 
  session_start();
    if (empty($_SESSION['deliever_email'])||empty($_POST['id'])||empty($_GET['func'])||$_GET['func']!="dispatch"&&$_GET['func']!="recv")
    {
       echo 0;
       exit();
    }
    $mysqli=new mysqli('localhost','root','510051','oto');
    if (mysqli_connect_errno()){
        echo 3;
        exit();
    }
    else{
        $overtime = date('Y-m-d H:i:s');
        $result = $mysqli->query ("set names utf8");
        if ($_GET['func']=="dispatch")
            $query = 'update orders set status_id ="3" where id ="'.$_POST['id'].'" and status_id = "2"';
        else $query = 'update orders set status_id ="4",overtime ="'.$overtime.'" where id ="'.$_POST['id'].'" and status_id = "3"';
        $result = $mysqli->query($query);
        if (mysqli_affected_rows($mysqli)){
            echo 1;
        }
        else echo 0;
    }
?>