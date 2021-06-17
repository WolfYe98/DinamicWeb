<?php
  require_once('Users.inc');

  session_start();
  $update = new Users();
  $actualizado = $update->updateUserInfo($_POST['name'],$_POST['user'],$_POST['password'],$_POST['tipo'],$_POST['email'],$_SESSION['userID']);
  if ($actualizado){
    $_SESSION['user'] = $_POST['user'];
  }
  echo $actualizado;
?>
