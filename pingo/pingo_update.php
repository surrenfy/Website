<?php
    session_start();
    if (empty($_SESSION['customer_email']))
    {
        exit();
    }
    $email = $_SESSION['customer_email'];
    $mysqli=new mysqli('localhost','root','510051','pingo');

    if (mysqli_connect_errno()){
        echo 0;
        exit();
    }
    else{
        $result = $mysqli->query ("set names utf8");
        if (empty($_GET["func"])||empty($_POST["id"]))
        {
            echo 0;
            $mysqli->close();
            exit();
        }
        $id = $_POST["id"];
        if ($_GET["func"]=="delete")
        {
            $query = 'delete from pingo where id ="'.$id.'"';
            $result = $mysqli->query ($query);
            if (mysqli_affected_rows($mysqli))
                echo 1;
            else echo 0;
        }
        else if ($_GET["func"]=="update")
        {
            if (empty($_POST["quantity"]))
            {
                echo 0;
            }
            else{
                $query = 'update pingo set quantity ="'.$_POST["quantity"].'" where id ="'.$id.'"';
                $result = $mysqli->query ($query);
                if (mysqli_affected_rows($mysqli))
                    echo 1;
                else echo 0;
            }
        }
    }
    $mysqli->close();
?>