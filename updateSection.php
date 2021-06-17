<?php
  require_once('Sections.inc');

  $db = new Sections();
  $secciones = $db->getAllSections();
  $values = array();
  foreach ($secciones as $key => $value) {
    $val = $db->updateSection($value[1],$_POST[$value[0]]);
    array_push($values,$val);
  }
  $allOk = true;
  foreach ($values as $value) {
    if ($value == false){
      $allOk = false;
    }
  }
  echo $allOk;
?>
