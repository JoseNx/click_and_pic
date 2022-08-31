<!DOCTYPE html>
<?php
//Conectamos con la base de datos.
$conexion = new PDO('mysql:host=localhost;dbname=click_and_pic', 'root', '');
//Llamamos al archivo funciones.php para que podamos usar las funciones de esta y base de datos.
include '../clases/ValidarDatos.php';
include '../clases/Publicacion.php';
require_once('../clases/DB.php');
//Iniciamos sesion
session_start();
//variable de formulario
$botSesion = filter_input(INPUT_POST, "iniciar");
$login = $_SESSION['login'];
$mensaje = "";
$tipo = "";
$cuentaMaestra = "maestro";
$cuentaAdmin = "admin";
$cuentaNormal = "normal";
$noLogin = "";
$cerrarSesion = filter_input(INPUT_POST, "cerrarSesion");
$subirFoto = filter_input(INPUT_POST, "subirPublicacion");
$borrarFoto = filter_input(INPUT_POST, "borrarPublicacion");
if (!isset($_SESSION['login'])) {
    header("Location: ../php/login.php");
}

//Con esto sacamos la lista de los usuarios.
$consultaPublicacion = "SELECT * FROM `publicacion` WHERE login='$login'";
$resultadoPublicacion = $conexion->prepare($consultaPublicacion);
$resultadoPublicacion->execute();
$listaPublicacion = $resultadoPublicacion->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="Es-es">

    <head>
        <meta charset="utf-8">
        <!--link al css del index que se encuentra en la carpeta css-->
        <link rel="stylesheet" type="text/css" href="../css/tusFotos.css" />
        <title>Tus publicaciones</title>
        <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    </head>
    <body>

        <!--La barra de navegacion principal, la cual esta hecha usando boostrap-->
        <nav id="menuHorizontal">
            <div id="interioNav">
                <a id="botonDerecho" href="../php/zonaProductos.php">NUESTROS PRODUCTOS</a>

                <a id="Logo" href="../html/pagina_principal.html">Click And Pic</a>

                <a id="botonIzquierdo" href="../php/zonaFotos.php">VUESTRAS FOTOS</a>

                <img id="usuarioPaginaPrincipal" src="../assets/cara_login.png">
            </div>


        </nav>

        <div id="menuVertical">
            <img id="cerrar_menu" src="../assets/x.png">
            <img id="avatar" src="../assets/cara.svg">
            <h1>Menú de <?PHP echo $_SESSION['nombreUsur'] ?></h1>
            <ul>
                <?php if ($_SESSION['rol'] == $noLogin) { ?>
                    <li><a href="../php/login.php">Iniciar sesión</a></li>
                    <li><a href="../html/sobreNosotros.html">Sobre nosotros</a></li>
                    <li><a href="../html/politicasPrivacidad.html">Politicas y privacidad</a></li>
                    <li><a href="../html/contacto.html">Contacto</a></li>
                <?php }if ($_SESSION['rol'] == $cuentaNormal) { ?>
                    <li><a href="../php/panelGeneralUsuario.php">Panel general</a></li>
                    <li><a href="../php/tusPedidos.php">Tus pedidos</a></li>
                    <li><a href="../php/tusFotos.php">Tus fotos </a></li>
                    <li><form method="post"><input id="cerraSesion" type="submit" name="cerrarSesion" value="Cerrar Sesión"></form></li>
                <?php } ?>
            </ul>
        </div>
        <div id="contenedorBotones">
            <p id="tituloGestion">Gestión de fotos</p>
            <div id="botonSubir">
                <a id="botonSubirInterior" href="../php/subirFoto.php">SUBIR FOTOS</a>
            </div> 

            <div id="botonBorrarPublicacion">
                <a id="botonBorrarPublicacionInterior" href="../php/borrarFoto.php">BORRAR FOTOS</a>
            </div> 
        </div>

        <div id="contenedorPublicaciones">
            <p id="tituloPublicaciones">Tus Publicaciones</p>
            <table  id="tablaListaControl">
                <thead>
                <th></th>
                <th></th>
                </thead>
                <tbody>
                    <?php foreach ($listaPublicacion as $publicacionDato) {
                        ?>
                        <tr>
                            <td id="publicacionDecoracion">
                                <p id="tituloFoto"><?php echo $publicacionDato['titulo'] ?></p>
                                <img id="fotoPublicacion" src="data:<?php echo $publicacionDato['tipo']; ?>;base64,<?php echo base64_encode($publicacionDato['foto_publicacion']); ?>">
                            </td>
                        </tr>
                    </tbody>

                <?php }
                ?>
            </table> 
        </div>

        <script src="../scripts/menuUsuario.js"></script>
    </body>
</html>
<?php
//Este boton se encarga de cerrar la sesion
if (isset($cerrarSesion)) {
    session_destroy();
    header("Location: ../php/login.php");
}
