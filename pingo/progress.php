<?php
    session_start();
    if (empty($_SESSION['customer_email']))
    {
        header('Location: ./signin.php?flag=1');
        exit();
    }
    if (empty($_POST['id']))
    {
        header('Location: ./pingo.php');
        exit();
    }
    $email = $_SESSION['customer_email'];
    $ids    = $_POST['id'];
    $mysqli=new mysqli('localhost','root','510051','pingo');
    if (mysqli_connect_errno()){
        header('Location: ./signin.php?flag=1');
        exit();
    }
    else{
        $result = $mysqli->query ("set names utf8");
        $progress = '';
        for ($i= 0;$i< count($ids); $i++){ 
            $progress =  $progress.$ids[$i]; 
        }
        $time = date('Y-m-d H:i:s');
        $progress= sha1($progress.$time);
        $query = 'select product.id as product_id,product.name as product_name,product.ch_name as product_ch_name,product.price as product_price,
            product.description as product_description,product.ch_description as product_ch_description,product.unit as product_unit,
            product.ch_unit as product_ch_unit,product.kind as product_kind,product.ch_kind as product_ch_kind,product.addr as product_addr,
            product.ch_addr as product_ch_addr,quantity,pingo.customer_email as customer_email,customer.name as customer_name,addr.id as addr_id,addr.consignee as addr_consignee,
            addr.province as addr_province,addr.city as addr_city,addr.detail as addr_detail,addr.postcode as addr_postcode,addr.phone as addr_phone,
            lim,off from (customer right join (addr right join (pingo left join (product left join packet on product.id=product_id) on product.id=pingo.product_id)
            on pingo.addr_id = addr.id) on addr.customer_email = customer.email) where  pingo.id ="'.$ids[0].'"';
        $result = $mysqli->query ($query);
        $row = mysqli_fetch_assoc($result);
        $product_id     =           $row["product_id"];
        $product_name   =           $row["product_name"];
        $product_ch_name =          $row["product_ch_name"];
        $product_price   =          $row["product_price"];
        $product_description =      $row["product_description"];
        $product_ch_description =   $row["product_ch_description"];
        $product_unit =             $row["product_unit"];
        $product_ch_unit =          $row["product_ch_unit"];
        $product_kind =             $row["product_kind"];
        $product_ch_kind =          $row["product_ch_kind"];
        $product_addr =             $row["product_addr"];
        $product_ch_addr =          $row["product_ch_addr"];
        $quantity =                 $row["quantity"];
        $customer_email =           $row['customer_email'];
        $customer_name  =           $row["customer_name"];
        $addr_id    =               $row["addr_id"];
        $addr_consignee =           $row["addr_consignee"];
        $addr_province  =           $row["addr_province"];
        $addr_city      =           $row["addr_city"];
        $addr_detail    =           $row["addr_detail"];
        if (!empty($row["addr_postcode"]))
            $addr_postcode  =       $row["addr_postcode"];
        else $addr_postcode='';
        $addr_phone         =       $row["addr_phone"];
        if (!empty($row["lim"]))
            $lim            =       $row["lim"];
        if (!empty($row["off"]))
            $off            =       $row["off"];
        $original = (float)$product_price*(int)$quantity;
        $query = 'insert into progress values("'.$progress.'","'.$product_id.'","'.$product_name.'","'.$product_ch_name.'","'.$product_price.'","'.$product_description.'",
            "'.$product_ch_description.'","'.$product_unit.'","'.$product_ch_unit.'","'.$product_kind.'","'.$product_ch_kind.'","'.$product_addr.'","'.$product_ch_addr.'",
            "'.$quantity.'","'.$customer_email.'","'.$customer_name.'","'.$addr_id.'","'.$addr_consignee.'","'.$addr_province.'","'.$addr_city.'","'.$addr_detail.'","'.$addr_postcode.'",
            "'.$addr_phone.'","'.$lim.'","'.$off.'","'.$original.'","2","0","0","0")';
        $result = $mysqli->query ($query);
        for ($i= 1;$i< count($ids); $i++){ 
                    $query = 'select product.id as product_id,product.name as product_name,product.ch_name as product_ch_name,product.price as product_price,
                product.description as product_description,product.ch_description as product_ch_description,product.unit as product_unit,
                product.ch_unit as product_ch_unit,product.kind as product_kind,product.ch_kind as product_ch_kind,product.addr as product_addr,
                product.ch_addr as product_ch_addr,quantity,pingo.customer_email as customer_email,customer.name as customer_name,addr.id as addr_id,addr.consignee as addr_consignee,
                addr.province as addr_province,addr.city as addr_city,addr.detail as addr_detail,addr.postcode as addr_postcode,addr.phone as addr_phone,
                lim,off from (customer right join (addr right join (pingo left join (product left join packet on product.id=product_id) on product.id=pingo.product_id)
                on pingo.addr_id = addr.id) on addr.customer_email = customer.email) where  pingo.id ="'.$ids[$i].'"';
            $result = $mysqli->query ($query);
            $row = mysqli_fetch_assoc($result);
            $product_id     =           $row["product_id"];
            $product_name   =           $row["product_name"];
            $product_ch_name =          $row["product_ch_name"];
            $product_price   =          $row["product_price"];
            $product_description =      $row["product_description"];
            $product_ch_description =   $row["product_ch_description"];
            $product_unit =             $row["product_unit"];
            $product_ch_unit =          $row["product_ch_unit"];
            $product_kind =             $row["product_kind"];
            $product_ch_kind =          $row["product_ch_kind"];
            $product_addr =             $row["product_addr"];
            $product_ch_addr =          $row["product_ch_addr"];
            $quantity =                 $row["quantity"];
            $customer_email =           $row['customer_email'];
            $customer_name  =           $row["customer_name"];
            $addr_id    =               $row["addr_id"];
            $addr_consignee =           $row["addr_consignee"];
            $addr_province  =           $row["addr_province"];
            $addr_city      =           $row["addr_city"];
            $addr_detail    =           $row["addr_detail"];
            if (!empty($row["addr_postcode"]))
                $addr_postcode  =       $row["addr_postcode"];
            else $addr_postcode='';
            $addr_phone         =       $row["addr_phone"];
            if (!empty($row["lim"]))
                $lim            =       $row["lim"];
            if (!empty($row["off"]))
                $off            =       $row["off"];
            $original = (float)$product_price*(int)$quantity;
            $query = 'insert into progress values("'.$progress.'","'.$product_id.'","'.$product_name.'","'.$product_ch_name.'","'.$product_price.'","'.$product_description.'",
                "'.$product_ch_description.'","'.$product_unit.'","'.$product_ch_unit.'","'.$product_kind.'","'.$product_ch_kind.'","'.$product_addr.'","'.$product_ch_addr.'",
                "'.$quantity.'","'.$customer_email.'","'.$customer_name.'","'.$addr_id.'","'.$addr_consignee.'","'.$addr_province.'","'.$addr_city.'","'.$addr_detail.'","'.$addr_postcode.'",
                "'.$addr_phone.'","'.$lim.'","'.$off.'","'.$original.'","0","0","0","0")';
            $result = $mysqli->query ($query);
        }
        $mysqli->close();
        header('Location: ./message.php');
        exit();
    }
?>