<?php 
  session_start();
  session_destroy();
  header('Location: ./deliever_login.php');
  ?>