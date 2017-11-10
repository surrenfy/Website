<?php
    session_start();
    if ($_SESSION['customer_email']==null)
    {
        header('Location: ./signin.php?flag=1');
        exit();
    }
    $email=$_SESSION['customer_email'];
    $mysqli=new mysqli('localhost','root','510051','pingo');
    if (mysqli_connect_errno()){
        header('Location: ./signin.php?flag=1');
        exit();
    }
    else{
        $result = $mysqli->query ("set names utf8");
        if ($_GET["func"]=="add"&&!empty($_POST["consignee"])&&!empty($_POST["province"])&&!empty($_POST["city"])&&!empty($_POST["phone"])&&!empty($_POST["detail"]))
        {
            if (empty($_POST["postcode"]))
                $query = 'insert into addr (customer_email,consignee,province,city,detail,phone) values ("'.$email.'","'.$_POST["consignee"].'","'.$_POST["province"].'","'.$_POST["city"].'","'.$_POST["detail"].'","'.$_POST["phone"].'") ';
            else 
                $query = 'insert into addr (customer_email,consignee,province,city,detail,postcode,phone) values ("'.$email.'","'.$_POST["consignee"].'","'.$_POST["province"].'","'.$_POST["city"].'","'.$_POST["detail"].'","'.$_POST["postcode"].'","'.$_POST["phone"].'") ';
            $result = $mysqli->query ($query);
                header('Location: ./address.php');
            $mysqli->close();
            exit();
        }
        else if ($_GET["func"]=="delete" &&!empty($_POST["id"]))
        {
            
            $query = 'delete from addr where id="'.$_POST["id"].'"';
            $result = $mysqli->query ($query);
            if (mysqli_affected_rows($mysqli))
                echo 1;
            else echo 0;
            $mysqli->close();
            exit();
        }
        else if ($_GET["func"]=="update" &&!empty($_POST["id"]))
        {
            $query = 'select * from addr where id="'.$_POST["id"].'"';
            $result = $mysqli->query ($query);
            $postcode ="";
            if (!$result->num_rows) {
                echo 1;
                exit();
            }
            $row = mysqli_fetch_assoc($result);
            $query = 'delete from addr where id="'.$_POST["id"].'"';
            $result = $mysqli->query ($query);
            if (mysqli_affected_rows($mysqli))
            {
                $_SESSION["consignee"] = $row['consignee'];
                $_SESSION["province"]=  $row['province'];
                $_SESSION["city"] =  $row["city"];
                $_SESSION["detail"] = $row["detail"];
                $_SESSION["phone"] = $row["phone"];
                if (!empty( $row["postcode"]))
                    $_SESSION["postcode"] =$row["postcode"];
            }
            else {
                ;
            }
            $mysqli->close();
            header('Location: ./address.php');
            exit();
        }   
    }
?>