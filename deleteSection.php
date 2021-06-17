<?php
  require_once('Sections.inc');
  $db = new Sections();

  echo $db->deleteSection('',$_POST['id']);
?>
