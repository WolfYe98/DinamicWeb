<?php
  require_once('Sections.inc');
  $db = new Sections();

  echo $db->createSection($_POST['section']);
?>
