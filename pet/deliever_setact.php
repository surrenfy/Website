<?php
    session_start();
    if (empty($_SESSION['deliever_email'])||empty($_POST['lastact']))
    {
        echo 0;
        exit();
    }
    $email = $_SESSION['deliever_email'];
    $lastact= $_POST['lastact'];
   
    $mysqli=new mysqli('localhost','root','510051','oto');
    if (mysqli_connect_errno()){
        echo 0;
        exit();
    }
    else{
        $result = $mysqli->query ("set names utf8");
        $query = 'update deliverer set lastact = "'.$lastact.'" where email ="'.$email.'"';
        $result = $mysqli->query ($query);
        if (mysqli_affected_rows($mysqli))
            echo 1;
        else echo 0;
    }
?>