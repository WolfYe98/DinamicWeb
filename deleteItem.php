<?php
  require_once('ItemsBD.inc');

  $db = new Items();
  $res = $db->deleteItemByID($_POST['id']);
  echo $res;
?>
