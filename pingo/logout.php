<?php 
  session_start();
  session_destroy();
  setcookie("customer_email", "", time()-3600);
  header('Location: ./index.php');
?>