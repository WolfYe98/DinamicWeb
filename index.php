<!DOCTYPE html>
<html lang="es" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="AUTHOR" content="Bate Ye">
    <meta name="DESCRIPTION" content="Blog De Bate Ye">
    <title>Index</title>
    <link rel="stylesheet" href="./styles/styles.css">
    <link rel="stylesheet" href="./styles/sitioweb.css">
    <script type="text/javascript" src="javascript/checks.js"></script>
  </head>
  <body>
    <?php
      require_once('header.inc');
    ?>
    <main>
      <section id="representativo">
        <img src="./imagenes/imgRepresentativa.jpg" alt="Imagen Principal">
      </section>
      <section id="articulos">
        <h1>Ciudades destacadas</h1>
        <article class="articulo">
          <a href="item.php?lugar=Granada"><img src="./imagenes/granada.jpg" alt="Imagen"/> <h2>Granada</h2></a>
        </article>
        <article class="articulo">
          <a href="item.php?lugar=Granada" id="ciudad-cabo">
            <img src="./imagenes/ciudadcabo.jpg" alt="Imagen" >
            <h2>Ciudad del Cabo</h2>
          </a>
        </article>
        <article class="articulo">
          <a href="item.php?lugar=Granada"><img src="./imagenes/singapur.jpg" alt="Imagen"> <h2>Singapur</h2></a>
        </article>
      </section>
    </main>

    <footer>
      <a href="contacto.html">Bate Ye - Contacto</a>
      <a href="como_se_hizo.pdf">Cómo se hizo</a>
    </footer>
  </body>
</html>
