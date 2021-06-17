<?php
  require_once("Users.inc");

  session_start();

  if (! isset($_SESSION['user'])){
    $userDB = new Users();
    $login = $userDB->checkUser($_POST['user'],$_POST['password']);
    if(! empty($login)){
      echo count($login);
      foreach ($login as $key => $value) {
        if (! empty($value)){
          $_SESSION['user'] = $value[1];
          $_SESSION['userID'] = $value[0];
          if ($value[2] == 1){
            $_SESSION['admin'] = true;
          }
        }
      }
    }
    if(!isset($_SESSION['user'])){
       setcookie('fail',true,time()+1);
    }
  }
  header("Location: index.php");
?>
