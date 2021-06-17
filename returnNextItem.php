<?php
  require_once('ItemsBD.inc');
  require_once('TagGenerator.inc.php');
  $db = new Items();
  $res = $db->nextItem($_POST['index'],$_POST['id'],$_POST['section']);
  if(! is_array($res)){
    echo $res;
  }
  else if(empty($res)){
    echo 'NoMoreItems';
  }
  else{
    session_start();
    $resultado = '';
    if(isset($_SESSION['admin'])){
      if ($_SESSION['admin'] == true){
        $navLink = new TagGenerator('nav',array('id'=>'edit-item'));
        $delete = new TagGenerator('img',array('src'=>'./imagenes/trash.png','onclick'=>'deleteItem('.$res[6].')'));
        $alink = new TagGenerator('a',array('href'=>"modifyItem.php?lugar=".$res[0]));
        $edit = new TagGenerator('img',array('src'=>'./imagenes/icon.png'));
        $alink->addChildObject($edit);
        $navLink->addChildrenObjects(array($delete,$alink));
        echo $navLink->returnHTML();
      }
    }
    $title = new TagGenerator('h1',array('id'=>'cab-main-section'));
    $title->innerHTML(ucfirst($res[5]));
    $resultado .= $title->returnHTML();


    $fatherSection = new TagGenerator('section',array('class'=>'item-father-section'));
    $detail = new TagGenerator('article',array('class'=>'detalles','style'=>'display:none;'));
    $namep = new TagGenerator('p');
    $namep->innerHTML($res[0]);
    $names = new TagGenerator('p');
    $names->innerHTML($res[5]);
    $detail->addChildrenObjects(array($namep,$names));
    $imgSection = new TagGenerator('section',array('class'=>'item-child-section','id'=>'item-imagen'));
    $index = 0;
    $imagen = new TagGenerator('img',array('src'=>'./'.$res[4],'id'=>'item-image','onmouseenter'=>'appearDetail('.$index.')','onmouseleave'=>'disappearDetail('.$index.')'));

    $imgSection->addChildrenObjects(array($detail,$imagen));

    $textos = new TagGenerator('section',array('class'=>'item-child-section','id'=>'textos'));
    $descripcion = new TagGenerator('section',array('class'=>'item-child-section','id'=>'description'));
    $itemRow = $res;
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

    $resultado .= $fatherSection->returnHTML();

    $aside = new TagGenerator('aside');

    $nave = new TagGenerator('nav');

    $a1 = new TagGenerator('a',array('onclick'=>'changeItem(1)'));
    $img1 = new TagGenerator('img',array('id'=>'left-arrow','src'=>'./imagenes/left.png'));
    $a1->addChildObject($img1);

    $a2 = new TagGenerator('a',array('onclick'=>'changeItem(-1)'));
    $img2 = new TagGenerator('img',array('id'=>'right-arrow','src'=>'./imagenes/right.png'));
    $a2->addChildObject($img2);

    $nave->addChildrenObjects(array($a1,$a2));
    $aside->addChildObject($nave);

    $resultado .= $aside->returnHTML();

    echo $resultado;
  }
?>
