<?php 
  session_start();
    if (empty($_SESSION['seller_email'])||empty($_POST['id']))
    {
       echo 2;
       exit();
    }
    $mysqli=new mysqli('localhost','root','510051','oto');
    if (mysqli_connect_errno()){
        echo 3;
        exit();
    }
    else{
        $result = $mysqli->query ("set names utf8");
        $query = 'update orders set status_id ="1" where id ="'.$_POST['id'].'" and status_id = "0"';
        $result = $mysqli->query($query);
        if (mysqli_affected_rows($mysqli)){
            $query = 'select * from deliverer order by lastact desc limit 2';
            $result = $mysqli->query($query);
            while($row = mysqli_fetch_array($result)){
                $query1 = 'insert into message1 values("'.$row['email'].'","'.$_POST['id'].'")';
                $result1 = $mysqli->query($query1);
                if (mysqli_affected_rows($mysqli)<=0 )
                    echo 4;
            }
            echo 1;
        }
        else echo 0;
    }
?>