<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta charset="utf-8">
    <meta name="AUTHOR" content="Bate Ye">
    <meta name="DESCRIPTION" content="Blog De Bate Ye">
    <title>Secciones</title>
    <link rel="stylesheet" href="./styles/styles.css">
    <link rel="stylesheet" href="./styles/sections.css">
    <link rel="stylesheet" href="./styles/sectionn.css">
    <link rel="stylesheet" href="./styles/items.css">
    <script type="text/javascript" src="./javascript/sections.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </head>
  <body>
    <?php
      require_once('header.inc');
      require_once('ItemsBD.inc');
    ?>
    <main>
      <?php
        if(!isset($_GET['section'])){
          echo '<h1>NO SE HA SELECCIONADO NINGUNA SECCIÓN</h1>';
        }
        else{
          $db = new Items();
          $rows = $db->getSectionItems($_GET['section']);

          if ($rows == 'SectionNoItem' || $rows == false){
            echo '<h1>No hay ningun elemento en esta sección</h1>';
          }
          else{
            $h1 = new TagGenerator('h1',array('style'=>'align-self:center;','id'=>'section-name'));
            $h1->innerHTML($_GET['section']);
            echo $h1->returnHTML();
            $section1 = new TagGenerator('section');
            foreach ($rows as $key => $value) {
              if ($key == MAXITEMPERSECTION){break;}

              $arti = new TagGenerator('article',array('class'=>'cities'));
              $a = new TagGenerator('a',array('href'=>'item.php?lugar='.$value[0]));

              $img = new TagGenerator('img',array('src'=>$value[4]));
              $h3 = new TagGenerator('h3');
              $h3->innerHTML($value[0]);
              $a->addChildrenObjects(array($img,$h3));
              $hidden = new TagGenerator('input',array('type'=>'hidden','class'=>'ids','value'=>$value[5]));
              $arti->addChildrenObjects(array($a,$hidden));

              $section1->addChildObject($arti);
            }
            echo $section1->returnHTML();
          }
        }
      ?>
      <aside class="">
        <nav>
          <a href="#" onclick='changeSectionItems(-1)'><img id="left-arrow" src="./imagenes/left.png"/></a>
          <a href="#" onclick='changeSectionItems(1)'><img id="right-arrow"src="./imagenes/right.png"></a>
        </nav>
      </aside>
    </main>
    <footer>
      <a href="contacto.html">Bate Ye - Contacto</a>
      <a href="como_se_hizo.pdf">Cómo se hizo</a>
    </footer>
  </body>
</html>
