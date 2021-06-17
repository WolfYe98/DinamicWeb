<?php
  require_once("Users.inc");
  $redirect = "Location: altausuario.php";

  if($_POST['name'] == ""){
    $redirect .= "?name=0";
  }
  if($_POST['user'] == ''){
    $redirect .= "?user=0";
  }
  if($_POST['passwd'] == ''){
    $redirect .= "?passwd=0";
  }
  if($_POST['type'] == ''){
    $redirect .= "?type=0";
  }

  if ($redirect != "Location: altausuario.php"){
    header($redirect);
  }
  else{
    $userTable = new Users();
    $inserted = $userTable->insertUser($_POST["name"],$_POST["user"],$_POST["passwd"],$_POST["type"]);
    echo $inserted." ed";
    if($inserted === false){
      header("Location: altausuario.php?fail=0");
    }
    else{
      echo "Success!";
      header("Location: index.php");
    }
  }
?>
