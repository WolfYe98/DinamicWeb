<header>
  <nav id="logo">
    <a href="index.php"><img src="./imagenes/logo.gif" alt="Logo"></a>
  </nav>

  <h1 id="title">Las Ciudades Más Bonitas del Mundo</h1>

  <nav id="form-link">
    <?php
      require_once('TagGenerator.inc.php');
      session_start();
      if(isset($_COOKIE['fail'])){
        echo '<script type="text/javascript">',
            'alert("Usuario no registrado!")',
            '</script>';
      }
      if(! isset($_SESSION['user'])){
        $form = new TagGenerator('form');
        $form->addVariousAtributesToTag(array("class"=>"formulario","onsubmit"=>"return checkAllInputs()","action"=>"validarUsuario.php","method"=>"post"));
        $userLabel = new TagGenerator('label');
        $userLabel->addAtributeToTag("for","user-id");
        $userLabel->innerHTML("Usuario");
        $userId = new TagGenerator('input');
        $userId->addVariousAtributesToTag(array("type"=>"text","id"=>"user-id","class"=>"textos","placeholder"=>"Usuario","name"=>"user"));
        $passLabel = new TagGenerator('label');
        $passLabel->addAtributeToTag("for","user-id");
        $passLabel->innerHTML("Contraseña");
        $passwd = new TagGenerator('input');
        $passwd->addVariousAtributesToTag(array("type"=>"password","id"=>"password","class"=>"textos","placeholder"=>"Password","name"=>"password"));
        $submit = new TagGenerator('input',array("type"=>"submit","id"=>"enviar","value"=>"Enviar"));

        $children = array($userLabel,$userId,$passLabel,$passwd,$submit);

        $form->addChildrenObjects($children);

        echo $form->returnHTML();

        $registro = new TagGenerator('a',array("href"=>"altausuario.php"));
        $registro->innerHTML("Registro de usuarios");
        echo $registro->returnHTML();
      }
      else{

        $usuario = new TagGenerator('h4');
        $usuario->innerHTML($_SESSION['user']);

        $userDataLink = new TagGenerator('a',array('href'=>'ModifyUserData.php'));
        $userDataLink->innerHTML('Datos del Usuario');
        $currentFileName = basename($_SERVER["SCRIPT_FILENAME"], '.php');
        $cerrarSesionLink = new TagGenerator('a',array('href'=>'cerrarSesion.php?from='.$currentFileName));
        $cerrarSesionLink->innerHTML('Cerrar Sesion');

        echo $usuario->returnHTML();
        echo $userDataLink->returnHTML();
        if(isset($_SESSION['admin'])){
          $modifySections = new TagGenerator('a',array('href'=>'modifySections.php'));
          $modifySections->innerHTML('Modificar Secciones');
          echo $modifySections->returnHTML();

          $link = new TagGenerator('a',array('href'=>'altaitem.php'));
          $link->innerHTML('Administración');
          echo $link->returnHTML();
        }

        echo $cerrarSesionLink->returnHTML();
      }
    ?>
    <!--
    <form class="formulario" onsubmit="return checkAllInputs()"action="validarUsuario.php" method="post">
      <label for="user-id">Usuario</label>
      <input type="text" id="user-id" class="textos" placeholder="Usuario">
      <label for="passwd">Contraseña</label>
      <input type="password" id="passwd" class="textos" placeholder="Password">
      <input type="submit" id="enviar" value="Enviar">
    </form>

    <a href="altausuario.html">Registro de usuarios</a>
    -->
  </nav>
  <?php
    require_once('Sections.inc');
    $section = new Sections();
    $nameArr = $section->getAllSections();
    $nav = new TagGenerator('nav',array("id"=>"header-nav"));
    foreach ($nameArr as $key => $value) {
      $atag = new TagGenerator('a',array('class'=>'nav-item','href'=>'secciones.php?section='.$value[0]));
      $h4 = new TagGenerator('h4');
      $h4->innerHTML($value[0]);
      $atag->addChildObject($h4);
      $nav->addChildObject($atag);
    }
    echo $nav->returnHTML();
  ?>

</header>
