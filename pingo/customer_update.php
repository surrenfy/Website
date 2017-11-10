<?php
    session_start();
    if ($_SESSION['customer_email']==null)
        exit();
    $email = $_SESSION['customer_email'];
    $mysqli=new mysqli('localhost','root','510051','pingo');
    if (mysqli_connect_errno())
        exit();
    if (!empty($_FILES["inputfile"]["name"])) 
    {
        if (((($_FILES["inputfile"]["type"] == "image/gif")
            ||   ($_FILES["inputfile"]["type"] == "image/jpeg")
            ||   ($_FILES["inputfile"]["type"] == "image/jpg")
            ||   ($_FILES["inputfile"]["type"] == "image/png"))
            &&   ($_FILES["inputfile"]["size"] < 2*1024*1024)
            &&   ($_FILES["inputfile"]["error"] <= 0))){
            if(move_uploaded_file($_FILES["inputfile"]["tmp_name"],
                'assets/images/customer/'.$email.'.'.substr(strrchr($_FILES["inputfile"]["name"], '.'), 1)))
                echo 1;
            else echo 'assets/images/customer/'.$email.'.'.substr(strrchr($_FILES["inputfile"]["name"], '.'), 1);
        }
    }
    elseif (!empty($_POST["rename"]))
    {
        $query = 'update customer set name="'.$_POST["rename"].'" where email ="'.$email.'"';
        $result = $mysqli->query ($query);
        if (mysqli_affected_rows($mysqli))
            echo 1;
        else echo 0;
    }

    elseif (!empty($_POST["profile"]))
    {
        $query = 'update customer set profile="'.$_POST["profile"].'" where email ="'.$email.'"';
        $result = $mysqli->query ($query);
        if (mysqli_affected_rows($mysqli))
            echo 1;
        else echo 0;
    }

    $mysqli->close();
?>