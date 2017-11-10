<?php
    session_start();
    if (empty($_SESSION['customer_email']) || empty($_POST['id']) || empty($_POST['addr_id']) || empty($_POST['product_id']) || empty($_GET['func']) || $_GET['func']!='agree' && $_GET['func']!='disagree' && $_GET['func']!='pay' && $_GET['func']!='cancel'  && $_GET['func']!='remove')
    {
        header('Location: ./signin.php?flag=1');
        exit();
    }
    $email = $_SESSION['customer_email'];
    $id = $_POST['id'];
    $addr_id = $_POST['addr_id'];
    $product_id = $_POST['product_id'];
    $mysqli=new mysqli('localhost','root','510051','pingo');

    if (mysqli_connect_errno()){
        header('Location: ./signin.php?flag=1');
        exit();
    }
    else{
        $result = $mysqli->query ("set names utf8");
        if ($_GET['func']=='agree'){
            $query = 'update progress set agreed = 2 where id="'.$id.'" and addr_id="'.$addr_id.'" and product_id="'.$product_id.'"';
            $result = $mysqli->query ($query);
            $query = 'select count(*) as total from progress where id="'.$id.'" and agreed <> 2';
            $result = $mysqli->query ($query);
            $row = mysqli_fetch_array($result);
            if ($row["total"]=="0")
            {
                $query = 'update progress set status = 2 where id="'.$id.'"';
                $result = $mysqli->query ($query);
                $query = 'select customer_email from progress where id="'.$id.'"';
                $result = $mysqli->query ($query);
                while ($row=mysqli_fetch_array($result)){
                    $query = 'insert into message values("'.$row["customer_email"].'","1")';
                    $result1= $mysqli->query ($query);
                }
            }
            header('Location: ./message_new.php');
        }
        else if ($_GET['func']=='disagree'){
            $query = 'update progress set agreed="1" , remove="1" where id="'.$id.'" and addr_id="'.$addr_id.'" and product_id="'.$product_id.'"';
            $result = $mysqli->query ($query);
            $query = 'update progress set status = 1 where id="'.$id.'"';
            $result = $mysqli->query ($query);
            $query = 'select customer_email from progress where id="'.$id.'" and agreed = 2';
            $result = $mysqli->query ($query);
            while ($row=mysqli_fetch_array($result)){
                $query = 'insert into message values("'.$row["customer_email"].'","0")';
                $result1= $mysqli->query ($query);
            }
            header('Location: ./message_new.php');
        }
        else if  ($_GET['func']=='cancel'){
            $query = 'update progress set agreed="1" , payed="0" , remove="1" where id="'.$id.'" and addr_id="'.$addr_id.'" and product_id="'.$product_id.'"';
            $result = $mysqli->query ($query);
            $query = 'update progress set status = 1 where id="'.$id.'"';
            $result = $mysqli->query ($query);
            $query = 'select customer_email from progress where id="'.$id.'" and agreed = 2';
            $result = $mysqli->query ($query);
            while ($row=mysqli_fetch_array($result)){
                $query = 'insert into message values("'.$row["customer_email"].'","0")';
                $result1= $mysqli->query ($query);
            }
            header('Location: ./message.php');
        }
        else if  ($_GET['func']=='pay'){
            $query = 'update progress set payed="1" where id="'.$id.'" and addr_id="'.$addr_id.'" and product_id="'.$product_id.'"';
            $result = $mysqli->query ($query);
            $query = 'select count(*) as total from progress where id="'.$id.'" and payed <> 1';
            $result = $mysqli->query ($query);
            $row = mysqli_fetch_array($result);
            if ($row["total"]=="0")
            {
                $query = 'select customer_email from progress where id="'.$id.'"';
                $result = $mysqli->query ($query);
                while ($row=mysqli_fetch_array($result)){
                    $query = 'insert into message values("'.$row["customer_email"].'","2")';
                    $result1= $mysqli->query ($query);
                }
                $query = 'delete from progress where id="'.$id.'"';
                $result = $mysqli->query ($query);
            }
            header('Location: ./message.php');
        }
        else if  ($_GET['func']=='remove'){
            $query = 'update progress set remove="1" where id="'.$id.'" and addr_id="'.$addr_id.'" and product_id="'.$product_id.'"';
            $result = $mysqli->query ($query);
            $query = 'select count(*) as total from progress where id="'.$id.'" and remove <> 1';
            $result = $mysqli->query ($query);
            $row = mysqli_fetch_array($result);
            if ($row["total"]=="0")
            {
                $query = 'delete from progress where id="'.$id.'"';
                $result = $mysqli->query ($query);
            }
            header('Location: ./message.php');
        }
    }

    $mysqli->close();
?>