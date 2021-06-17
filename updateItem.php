<?php
  require_once('ItemsBD.inc');
  $db = new Items();
  $res = $db->updateItem($_POST['lugar'],$_POST['pais'],$_POST['monumento'],$_POST['description'],$_POST['imgPath'],$_POST['section'],$_POST['id']);
  echo $res;
?>
