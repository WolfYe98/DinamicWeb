<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Alta Item</title>
    <link rel="stylesheet" href="./styles/styles.css">
    <link rel="stylesheet" href="./styles/altaitemstyle.css">
    <link rel="stylesheet" href="./styles/sitioweb.css">
    <script type="text/javascript" src='./javascript/altaitem.js'></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </head>
  <body>
    <?php
      require_once('header.inc');
      if (! isset($_SESSION['user'])){
        header('Location: index.php');
      }
    ?>
    <main>
      <section id="upload-photo" class='upload'>
        <h1>Selecciona una imagen</h1>
        <img id='item-image' src="#" alt="" style="width:50%;height:auto;"/>
        <input type="file" name="file-selector" id='file-selector' accept="image/*" onchange="previewImage()"/>
      </section>

      <section id="new-item-data">
        <form class="formulario" onsubmit="return checkInputsAndModifyEndl()" method="post">
          <label for="item-title" class="form-label">Ciudad:</label>
          <input type="text" name="item-title" id="lugar" class="form-input"/>

          <label for="item-prov" class="form-label">País:</label>
          <input type="text" name="item-prov" id='pais' class="form-input"/>

          <label for="item-country" class="form-label">Monumento más famoso:</label>
          <input type="text" name="item-country" id='monumento' class="form-input"/>

          <label for="item-description" class="form-label">Descripción:</label>
          <textarea name="item-description" id='description' rows="8" cols="80" class="form-area"></textarea>

          <?php
            if(isset($nameArr)){
              if(! empty($nameArr)){
                $selection = new TagGenerator('select',array('style'=>'background-color:white;width: 30%;margin-left:10px;margin-top:10px;height: 30px;font-size: 14px;align-self: flex-start;','id'=>'lista','class'=>'lista-desplegable','name'=>'type','id'=>'type'));
                foreach ($nameArr as $key => $value) {
                  $option = new TagGenerator('option',array('value'=>$value[0]));
                  $option->innerHTML(ucfirst($value[0]));
                  $selection->addChildObject($option);
                }
                echo $selection->returnHTML();
              }
            }
          ?>
          <input type="submit" id="form-submit" value="Enviar">
        </form>
      </section>
    </main>

    <footer> <a href="contacto.html">Bate Ye - Contacto</a> </footer>
  </body>
</html>
