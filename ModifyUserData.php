<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <title>Modificar Usuario</title>

    <meta charset="utf-8">
    <meta name="AUTHOR" content="Bate Ye">
    <meta name="DESCRIPTION" content="Blog De Bate Ye">
    <link rel="stylesheet" href="./styles/modify.css">
    <link rel="stylesheet" href="./styles/styles.css">
    <link rel="stylesheet" href="./styles/sitioweb.css">

    <script type="text/javascript" src="javascript/modifyUser.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </head>
  <body>
    <?php
      require_once('header.inc');
      require_once('Users.inc');
    ?>
    <main id='modify-main'>
      <?php
        if((! isset($_SESSION['user'])) || (! isset($_SESSION['userID']))){
          echo '<h1>Inicie sesión para modificar sus datos</h1>';
        }
        else{
          $user = new Users();
          $userData = $user->getUserInfo($_SESSION['user'],$_SESSION['userID']);

          $section = new TagGenerator('section');

          $form = new TagGenerator('form',array('class'=>'modify-user-form','method'=>'post','id'=>'formulario','onsubmit'=>'return checkModifyUser()'));
          $nameLabel = new TagGenerator('label');
          $nameLabel->addAtributeToTag("for","name");
          $nameLabel->innerHTML("Nombre");
          $name = new TagGenerator('input');
          $name->addVariousAtributesToTag(array("type"=>"text","id"=>"nombre","class"=>"textos","placeholder"=>"Nombre","name"=>"nombre",'value'=>$userData[0][1]));
          $userLabel = new TagGenerator('label',array('for'=>'user-id'));
          $userLabel->innerHTML("Usuario");
          $userId = new TagGenerator('input');
          $userId->addVariousAtributesToTag(array("type"=>"text","id"=>"user-id","class"=>"textos","placeholder"=>"Usuario","name"=>"user",'value'=>$userData[0][2]));
          $passLabel = new TagGenerator('label');
          $passLabel->addAtributeToTag("for","user-id");
          $passLabel->innerHTML("Contraseña");
          $passwd = new TagGenerator('input');
          $passwd->addVariousAtributesToTag(array("type"=>"password","id"=>"passwd","class"=>"textos","placeholder"=>"Password","name"=>"password"));
          $emailLabel = new TagGenerator('label',array('for'=>'email'));
          $emailLabel->innerHTML('Email');
          $email = new TagGenerator('input',array('name'=>'email','id'=>'email','class'=>'textos','placeholder'=>'Email','value'=>$userData[0][6]));

          $selection = new TagGenerator('select',array('class'=>'lista-desplegable','name'=>'type','id'=>'type'));
          $option1 = new TagGenerator('option',array('value'=>'1'));
          $option1->innerHTML('Viajero');
          $option2 = new TagGenerator('option',array('value'=>'2'));
          $option2->innerHTML('Lector');
          $option3 = new TagGenerator('option',array('value'=>'3'));
          $option3->innerHTML('Periodista');

          switch($userData[0][4]){
            case 1:
              $option1->addAtributeToTag('selected','selected');
              break;
            case 2:
              $option2->addAtributeToTag('selected','selected');
              break;
            case 3:
              $option3->addAtributeToTag('selected','selected');
              break;
          }
          $selection->addChildrenObjects(array($option1,$option2,$option3));
          $submit = new TagGenerator('input',array("type"=>"submit","id"=>"enviar","value"=>"Enviar"));

          $children = array($nameLabel,$name,$userLabel,$userId,$passLabel,$passwd,$emailLabel,$email,$selection,$submit);

          $form->addChildrenObjects($children);
          $section->addChildObject($form);
          echo $section->returnHTML();
        }
      ?>
    </main>
    <footer>
      <a href="contacto.html">Bate Ye - Contacto</a>
      <a href="como_se_hizo.pdf">Cómo se hizo</a>
    </footer>
  </body>
</html>
