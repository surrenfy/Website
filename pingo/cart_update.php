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
        if ($_GET["func"]=="add")
        {
            $query = 'select * from cart where customer_email ="'.$email.'" and product_id ="'.$id.'"';
            $result = $mysqli->query ($query);
            if ($result->num_rows) {
                $query = 'update cart set quantity = quantity + 1 where customer_email ="'.$email.'" and product_id ="'.$id.'"';
                $result = $mysqli->query ($query);
                if (mysqli_affected_rows($mysqli))
                    echo 2;
                else echo 0;
            }
            else{
                $query = 'insert into cart values ("'.$email.'","'.$id.'",1)';
                $result = $mysqli->query ($query);
                if (mysqli_affected_rows($mysqli))
                    echo 1;
                else echo 0;
            }
        }
        else if ($_GET["func"]=="delete")
        {
            $query = 'delete from cart where  customer_email ="'.$email.'" and product_id ="'.$id.'"';
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
                $query = 'update cart set quantity ="'.$_POST["quantity"].'" where customer_email ="'.$email.'" and product_id ="'.$id.'"';
                $result = $mysqli->query ($query);
                if (mysqli_affected_rows($mysqli))
                    echo 1;
                else echo 0;
            }
        }
    }
    $mysqli->close();
?>