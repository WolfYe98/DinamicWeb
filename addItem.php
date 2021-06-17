<?php
  require_once('ItemsBD.inc');
  $item = new Items();
  $added = $item->createItem($_POST['lugar'],$_POST['pais'],$_POST['monumento'],$_POST['description'],'imagenes/'.$_POST['imgPath'],$_POST['section']);
  echo $added;
?>
