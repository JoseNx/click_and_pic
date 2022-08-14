<!DOCTYPE html>
<?php
//Conectamos con la base de datos.
$conexion = new PDO('mysql:host=localhost;dbname=click_and_pic', 'root', '');
//Llamamos al archivo funciones.php para que podamos usar las funciones de esta y base de datos.
include '../clases/ValidarDatos.php';
include '../clases/Usuario.php';
require_once('../clases/DB.php');
//Iniciamos sesion
session_start();
//variable de formulario
$botSesion = filter_input(INPUT_POST, "iniciar");
$mensaje = "";
$tipo = "";
$cuentaMaestra = "maestro";
$cuentaAdmin = "admin";
$cuentaNormal = "normal";
$noLogin = "";
$cerrarSesion = filter_input(INPUT_POST, "cerrarSesion");
//Con esto sacamos la lista de los usuarios.
$consultaPublicacion = "SELECT * FROM `publicacion` ORDER BY cod_publi DESC";
$resultadoPublicacion = $conexion->prepare($consultaPublicacion);
$resultadoPublicacion->execute();
$listaPublicacion = $resultadoPublicacion->fetchAll(PDO::FETCH_ASSOC);
if (!isset($_SESSION['rol'])) {
    $_SESSION['rol'] = "";
}
?>
<!DOCTYPE html>
<html lang="Es-es">

    <head>
        <meta charset="utf-8">
        <!--link al css del index que se encuentra en la carpeta css-->
        <link rel="stylesheet" type="text/css" href="../css/zonaFotos.css" />
        <title>Vuestras Publicaciones</title>
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
            <?php if ($_SESSION['rol'] == $noLogin) { ?>
                <h1>Menú</h1>
            <?php }if ($_SESSION['rol'] == $cuentaNormal) { ?>
                <h1>Menú de <?PHP echo $_SESSION['nombreUsur'] ?></h1>
            <?php } ?>
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
                    <li><a href="../php/opcionesSoloUsuario.php">Opciones de usuario </a></li>
                    <li><form method="post"><input id="cerraSesion" type="submit" name="cerrarSesion" value="Cerrar Sesión"></form></li>
                <?php } ?>
            </ul>
        </div>
        <div id="contenedorPublicaciones">
            <p id="tituloPublicaciones">Vuestras publicaciones</p>
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
        <div id="frasePaginaPrincipal">
        </div>
        <script src="../scripts/menuUsuario.js"></script>
    </body>
</html>
<?php
//Este boton se encarga de cerrar la sesion
if (isset($cerrarSesion)) {
    session_destroy();
}