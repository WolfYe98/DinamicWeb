<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta charset="utf-8">
    <meta name="AUTHOR" content="Bate Ye">
    <meta name="DESCRIPTION" content="Blog De Bate Ye">
    <title>Item 1</title>
    <link rel="stylesheet" href="./styles/items.css">
    <link rel="stylesheet" href="./styles/styles.css">
    <link rel="stylesheet" href="./styles/sitioweb.css">
    <link rel="stylesheet" href="./styles/sections.css">

    <script type="text/javascript" src="./javascript/item.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </head>
  <body>
    <?php
      require_once('header.inc');
      require_once('ItemsBD.inc');
    ?>
    <main id="no-edit-main">
      <?php
        if(!isset($_GET['lugar'])){
          $h1 = new TagGenerator('h1',array('style'=>'font-weight:30px;'));
          $h1->innerHTML('NO HAS SELECCIONADO NINGUN ITEM');
          echo $h1->returnHTML();
        }
        else{
          $db = new Items();
          $item = $db->getItemByPlace($_GET['lugar']);

          if ($item == 'ItemNotExist'){
            echo "NO EXISTE EL ITEM: ".$_GET['lugar'];
          }
          else{
            if(isset($_SESSION['admin'])){
              if ($_SESSION['admin'] == true){
                $navLink = new TagGenerator('nav',array('id'=>'edit-item'));
                $delete = new TagGenerator('img',array('src'=>'./imagenes/trash.png','onclick'=>'deleteItem('.$item[0][6].')'));
                $alink = new TagGenerator('a',array('href'=>"modifyItem.php?lugar=".$item[0][0]));
                $edit = new TagGenerator('img',array('src'=>'./imagenes/icon.png'));
                $alink->addChildObject($edit);
                $navLink->addChildrenObjects(array($delete,$alink));
                echo $navLink->returnHTML();
              }
            }
            $title = new TagGenerator('h1',array('id'=>'cab-main-section'));
            $title->innerHTML(ucfirst($item[0][5]));
            echo $title->returnHTML();


            $fatherSection = new TagGenerator('section',array('class'=>'item-father-section'));
            $imgSection = new TagGenerator('section',array('class'=>'item-child-section','id'=>'item-imagen'));

            $detail = new TagGenerator('article',array('class'=>'detalles','style'=>'display:none;'));
            $namep = new TagGenerator('p');
            $namep->innerHTML($item[0][0]);
            $names = new TagGenerator('p');
            $names->innerHTML($item[0][5]);
            $detail->addChildrenObjects(array($namep,$names));
            $index = 0;

            $imagen = new TagGenerator('img',array('src'=>'./'.$item[0][4],'id'=>'item-image','onmouseenter'=>'appearDetail('.$index.')','onmouseleave'=>'disappearDetail('.$index.')'));

            $imgSection->addChildrenObjects(array($detail,$imagen));

            $textos = new TagGenerator('section',array('class'=>'item-child-section','id'=>'textos'));
            $descripcion = new TagGenerator('section',array('class'=>'item-child-section','id'=>'description'));
            $itemRow = $item[0];
            $h2 = new TagGenerator('h2');
            $h2->innerHTML('Lugar: '.$itemRow[0]);
            $textos->addChildObject($h2);
            $h2 = new TagGenerator('h2');
            $h2->innerHTML('País: '.$itemRow[1]);
            $textos->addChildObject($h2);
            $h2 = new TagGenerator('h2');
            $h2->innerHTML('Monumento más famoso: '.$itemRow[2]);
            $textos->addChildObject($h2);

            $h2 = new TagGenerator('h2');
            $h2->innerHTML('Descripción:');
            $p = new TagGenerator('p');
            $p->innerHTML($itemRow[3]);

            $hiddenInput = new TagGenerator('input',array('type'=>'hidden','value'=>$itemRow[6],'id'=>'item-id'));

            $descripcion->addChildrenObjects(array($h2,$p,$hiddenInput));

            $fatherSection->addChildrenObjects(array($imgSection,$textos,$descripcion));

            echo $fatherSection->returnHTML();
          }

        }
      ?>
      <aside class="">
        <nav>
          <a href="#" onclick='changeItem(-1)'><img id="left-arrow" src="./imagenes/left.png"/></a>
          <a href="#" onclick='changeItem(1)'><img id="right-arrow"src="./imagenes/right.png"></a>
        </nav>
      </aside>
    </main>
    <footer>
      <a href="contacto.html">Bate Ye - Contacto</a>
      <a href="como_se_hizo.pdf">Cómo se hizo</a>
    </footer>
  </body>
</html>
