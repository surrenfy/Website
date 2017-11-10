<?php 
  session_start();
    if (empty($_SESSION['customer_email'])||empty($_POST['firstname'])||empty($_POST['lastname'])||empty($_POST['province'])||empty($_POST['city'])||empty($_POST['addr'])||empty($_POST['phone'])||empty($_POST['id']))
    {
       echo 2;
       exit();
    }
    $customer_email    =  $_SESSION['customer_email'];
    $customer_firstname = $_POST['firstname'];
    $customer_lastname  = $_POST['lastname'];
    $customer_phone     = $_POST['phone'];
    $customer_province  = $_POST['province'];
    $customer_city      = $_POST['city'];
    $customer_addr      = $_POST['addr'];
    $product_id         = $_POST['id'];
    $mysqli=new mysqli('localhost','root','510051','oto');
    if (mysqli_connect_errno()){
        echo 3;
        exit();
    }
    else{
        $result = $mysqli->query ("set names utf8");
        $query = "select * from product where id =\"".$product_id."\"";
        $result = $mysqli->query($query);
        if (!$result->num_rows) {
            echo 4;
            exit();
        }
        else {
            $row = mysqli_fetch_assoc($result);
            $product_name= $row['name'];
            $product_kind=$row['kind'];
            $product_description=$row['description'];
            $product_price=$row['price'];
            $product_province=$row['province'];
            $product_city=$row['city'];
            $product_phone=$row['phone'];
            $product_addr=$row['addr'];
            $seller_email = $row['seller_email'];
            $query = "select * from seller where email =\"".$seller_email."\"";
            $result = $mysqli->query($query);
            if (!$result->num_rows) {
                echo 5;
                exit();
            }
            else {
                $row = mysqli_fetch_assoc($result);
                $seller_shopname = $row ['shopname'];
                $status_id='0';
                $status = "";
                $dealtime = date('Y-m-d H:i:s');
                $overtime = $dealtime;
                $id = $product_id.substr(sha1($customer_email),0,20).substr(sha1($dealtime),0,20);
                $query='insert into orders (id,status_id,status,dealtime,overtime,customer_email,customer_firstname,customer_lastname,customer_phone,customer_province,customer_city,customer_addr,seller_email,seller_shopname,product_id,product_name,product_kind,product_description,product_price,product_phone,product_province,product_city,product_addr) values("'.$id.'","'.$status_id.'","'.$status.'","'.$dealtime.'","'.$overtime.'","'.$customer_email.'","'.$customer_firstname.'","'.$customer_lastname.'","'.$customer_phone.'","'.$customer_province.'","'.$customer_city.'","'.$customer_addr.'","'.$seller_email.'","'.$seller_shopname.'","'.$product_id.'","'.$product_name.'","'.$product_kind.'","'.$product_description.'","'.$product_price.'","'.$product_phone.'","'.$product_province.'","'.$product_city.'","'.$product_addr.'")';
    
                $result = $mysqli->query($query);
                if (mysqli_affected_rows($mysqli))
                    echo 1;
                else echo 6;
            }

        }
    }
?>