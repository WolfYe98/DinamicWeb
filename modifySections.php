<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Modificar Secciones</title>
    <link rel="stylesheet" href="./styles/modifySections.css">
    <link rel="stylesheet" href="./styles/sitioweb.css">
    <link rel="stylesheet" href="./styles/styles.css">
    <script type="text/javascript" src="./javascript/modifySections.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </head>
  <body>
    <?php
      require_once('header.inc');
    ?>
    <main>
      <?php
        $form = new TagGenerator('form',array('class'=>'formulario','id'=>'modificar-secciones','onsubmit'=>'return modificar()'));
        $label = new TagGenerator('label',array('value'=>'Secciones:'));

        $form->addChildObject($label);
        foreach ($nameArr as $key => $value) {
          $input = new TagGenerator('input',array('class'=>'secciones','value'=>$value[0]));
          $hidden = new TagGenerator('input',array('class'=>'ids','type'=>'hidden','value'=>$value[0]));
          $delete = new TagGenerator('img',array('class'=>'deleteImage','src'=>'./imagenes/trash.png','onclick'=>'deleteSelectedSection('.$value[1].')'));
          $form->addChildrenObjects(array($input,$hidden,$delete));
        }
        $submit = new TagGenerator('input',array('type'=>'submit','value'=>'Enviar!'));
        $form->addChildObject($submit);
        echo $form->returnHTML();

        $formAdd = new TagGenerator('form',array('class'=>'formulario','id'=>'add-section','onsubmit'=>'return addSection()'));
        $ilabel = new TagGenerator('label');
        $ilabel->innerHTML('Nueva Sección:');
        $inputAdd = new TagGenerator('input',array('class'=>'secciones','id'=>'new-section','placeholder'=>'Introduzca la sección'));
        $newSubmit = new TagGenerator('input',array('type'=>'submit','value'=>'Añadir'));
        $formAdd->addChildrenObjects(array($ilabel,$inputAdd,$newSubmit));
        echo $formAdd->returnHTML();
      ?>
    </main>
  </body>
</html>
