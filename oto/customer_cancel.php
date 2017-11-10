<?php 
  session_start();
    if (empty($_SESSION['customer_email'])||empty($_POST['id']))
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
        $result = $mysqli->query ("set names utf8");
        $overtime = date('Y-m-d H:i:s');
        $query = 'update orders set status_id ="11",overtime="'.$overtime.'" where id ="'.$_POST['id'].'" and status_id < 4';
        $result = $mysqli->query($query);
        if (mysqli_affected_rows($mysqli)){
            $query = 'select deliverer_email from orders where id ="'.$_POST['id'].'" and deliverer_email is not null';
            $result = $mysqli->query($query);
            if ($result->num_rows) {
                $row = mysqli_fetch_assoc($result);
                $query = 'insert into message2 values ("'.$row["deliverer_email"].'","'.$_POST['id'].'")';
                $result = $mysqli->query($query);
            }
            echo 1;
        }
        else echo 0;
    }
?>