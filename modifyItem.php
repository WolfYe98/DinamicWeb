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
    <script type="text/javascript" src="./javascript/altaitem.js"></script>
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
          else if(!isset($_SESSION['admin'])){
            echo "<h1>Solo los administradores pueden modificar los items</h1>";
          }
          else{
            $title = new TagGenerator('h1',array('id'=>'cab-main-section'));
            $title->innerHTML(ucfirst($item[0][5]));
            echo $title->returnHTML();


            $fatherSection = new TagGenerator('section',array('class'=>'item-father-section','style'=>"justify-content:center;align-items:center;"));
            $imgSection = new TagGenerator('section',array('class'=>'item-child-section','id'=>'item-imagen'));
            $imagen = new TagGenerator('img',array('src'=>'./'.$item[0][4],'id'=>'item-image'));
            $selector = new TagGenerator('input',array('type'=>'file','name'=>'file-selector','id'=>'file-selector','accept'=>'image/*','onchange'=>'previewImage()'));
            $imgSection->addChildrenObjects(array($imagen,$selector));

            $textos = new TagGenerator('section',array('class'=>'item-child-section','id'=>'textos'));
            $itemRow = $item[0];


            $form = new TagGenerator('form',array('class'=>'modify-item-form','method'=>'post','id'=>'formulario','onsubmit'=>'return modifyItem()'));
            $lugarLabel = new TagGenerator('label',array('for'=>'lugar'));
            $lugarLabel->innerHTML("Lugar:");
            $lugar = new TagGenerator('input',array("type"=>"text","id"=>"lugar","class"=>"textos","placeholder"=>"Lugar","name"=>"lugar",'value'=>$itemRow[0]));

            $paisLabel = new TagGenerator('label',array('for'=>'pais'));
            $paisLabel->innerHTML("Pais:");
            $pais = new TagGenerator('input',array("type"=>"text","id"=>"pais","class"=>"textos","placeholder"=>"Pais","name"=>"pais",'value'=>$itemRow[1]));

            $monumentoLabel = new TagGenerator('label',array('for'=>'monumento'));
            $monumentoLabel->innerHTML("Monumento más famoso:");
            $monumento = new TagGenerator('input',array("type"=>"text","id"=>"monumento","class"=>"textos","placeholder"=>"Monumento más famoso","name"=>"monumento",'value'=>$itemRow[2]));

            $descriptionLabel = new TagGenerator('label',array('for'=>'decription'));
            $descriptionLabel->innerHTML("Descripción:");
            $description = new TagGenerator('textarea',array('rows'=>'8','cols'=>'80',"id"=>"description-area","class"=>"form-area","placeholder"=>"Descripción","name"=>"item-description"));
            $description->innerHTML($itemRow[3]);

            $listaLabel = new TagGenerator('label',array('for'=>'lista-desplegable','value'=>'Sección'));
            $selection = [];
            if(isset($nameArr)){
              if(! empty($nameArr)){
                $selection = new TagGenerator('select',array('style'=>'background-color:white;width: 30%;margin-top:10px;height: 30px;font-size: 14px;align-self: flex-start;','id'=>'lista','class'=>'lista-desplegable','name'=>'type','id'=>'type'));
                foreach ($nameArr as $key => $value) {
                  $attributes = array('value'=>$value[0]);
                  if ($value[0] == ucfirst($item[0][5])){
                    $attributes['selected']='selected';
                  }
                  $option = new TagGenerator('option',$attributes);
                  $option->innerHTML(ucfirst($value[0]));
                  $selection->addChildObject($option);
                }
              }
            }
            $hiddenInput = new TagGenerator('input',array('type'=>'hidden','value'=>$itemRow[6],'name'=>'item-id','id'=>'item-id'));
            $submit = new TagGenerator('input',array('type'=>'submit','value'=>'Modificar','class'=>'form-input'));
            $childrenObjects = array($lugarLabel,$lugar,$paisLabel,$pais,$monumentoLabel,$monumento,$descriptionLabel,$description,$hiddenInput,$submit);
            if(! empty($selection)){
              array_push($childrenObjects,$selection);
            }

            $form->addChildrenObjects($childrenObjects);
            $textos->addChildObject($form);
            $fatherSection->addChildrenObjects(array($imgSection,$textos));

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
