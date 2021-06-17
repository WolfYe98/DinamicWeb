<?php
  require_once('ItemsBD.inc');
  require_once('TagGenerator.inc.php');
  $db = new Items();
  $res = $db->getNextItemsOfSection($_POST['section'],$_POST['id'],$_POST['direction']);
  if(!empty($res) && is_array($res)){
    $resul = '';
    foreach ($res as $key => $value) {
      if ($key == MAXITEMPERSECTION){break;}

      $arti = new TagGenerator('article',array('class'=>'cities'));
      $a = new TagGenerator('a',array('href'=>'item.php?lugar='.$value[0]));

      $img = new TagGenerator('img',array('src'=>$value[4]));
      $h3 = new TagGenerator('h3');
      $h3->innerHTML($value[0]);
      $a->addChildrenObjects(array($img,$h3));
      $hidden = new TagGenerator('input',array('type'=>'hidden','class'=>'ids','value'=>$value[5]));
      $arti->addChildrenObjects(array($a,$hidden));
      $resul .= $arti->returnHTML();
    }
    echo $resul;
  }
  else{
    echo $res;
  }
?>
