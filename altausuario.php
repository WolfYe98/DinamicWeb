<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Alta Usuario</title>
    <link rel="stylesheet" href="./styles/altausuario.css">
    <script type="text/javascript" src="./javascript/checks.js">
    </script>
  </head>
  <body>
    <header>
      <h1>Registrate y encuentra tu ciudad favorita!</h1>
    </header>
    <main>
      <section>
        <form class="alta-usuario" id="formulario" onsubmit="return checkAllInputs()" action="insertarUsuario.php" method="post">
          <label for="name" class="form-label">Nombre:</label>
          <input type="text" name="name" class="form-input"/>
          <label for="user" class="form-label">Usuario:</label>
          <input type="text" name="user" class="form-input"/>
          <label for="email" class="form-label">E-mail:</label>
          <input type="email" onkeypress="checkEmail()" id="email" name="email" class="form-input"/>
          <label for="passwd" class="form-label">Contraseña:</label>
          <input type="password" name="passwd" id="passwd" class="form-input"/>

          <label for="lista" class="form-label">Tipo de usuario:</label>
          <select class="lista-desplegable" name="type">
            <option value="1">Viajero</option>
            <option value="2">Lector</option>
            <option value="3">Periodista</option>
          </select>
          <input type="submit" class="form-input" id="submitBtn" value="Enviar!"/>
        </form>

      </section>
    </main>
  </body>
</html>
