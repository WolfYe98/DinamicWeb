<?php
  session_start();
  if(isset($_SESSION['user'])){
    session_destroy();
    unset($_SESSION['user']);
    unset($_SESSION['admin']);
    unset($_SESSION['userID']);
    session_destroy();
    if(isset($_GET['from'])){
      header("Location: ".$_GET['from'].".php");
    }
  }

?>
