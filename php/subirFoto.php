<!DOCTYPE html>
<?php
//Llamamos al archivo funciones.php para que podamos usar las funciones de esta y base de datos.
include '../clases/ValidarDatos.php';
include '../clases/Publicacion.php';
require_once('../clases/DB.php');
include_once '../clases/ConexionImagenes.php';
//Iniciamos sesion
session_start();
//Conectamos con la base de datos.
$conexion = new PDO('mysql:host=localhost;dbname=click_and_pic', 'root', '');
//variables
$_SESSION['login'];
$mensaje = "";
$tipo = "";
$cerrarSesion = filter_input(INPUT_POST, "cerrarSesion");
//Variables del formulario de registro
$titulo = filter_input(INPUT_POST, "titulo");
$publicacion = filter_input(INPUT_POST, "publicacion");
$subir = filter_input(INPUT_POST, "subir");
$cuentaMaestra = "maestro";
$cuentaAdmin = "admin";
$cuentaNormal = "normal";
$noLogin = "";
if (!isset($_SESSION['login'])) {
    header("Location: ../php/login.php");
}


//Registro de admin
if (isset($subir)) {
    if (ValidarDatos::Validar_Nueva_Publicacion($titulo, $_FILES['publicacion']) == true) {
        $tipoArchivo = $_FILES['publicacion']['type'];
        $tipoPermitido = array("image/png", "image/jpeg");
        if (in_array($tipoArchivo, $tipoPermitido) == true) {
            $tamañoArchivo = $_FILES['publicacion']['size'];
            $imagenSubida = fopen($_FILES['publicacion']['tmp_name'], 'r');
            $binariosImagen = fread($imagenSubida, $tamañoArchivo);
            $conexionImagen = mysqli_connect($db_host, $db_user, $db_pass, $db_database);
            $binariosImagen = mysqli_escape_string($conexionImagen, $binariosImagen);

            if (Publicacion::Publicacion_Nueva($titulo, $binariosImagen, $_SESSION['login'], $tipoArchivo) == true) {
                $mensaje = "La publicacion nueva se subio con exito.";
                $tipo = "mensajeExito";
            } else {
                $mensaje = "Error al subir.";
                $tipo = "mensajeError";
            }
        } else {
            $mensaje = "Tipo de archivo denegado.";
            $tipo = "mensajeError";
        }
    } else {
        $mensaje = "Datos del formulario mal introducidos.";
        $tipo = "mensajeError";
    }
}

//Este boton se encarga de cerrar la sesion
if (isset($cerrarSesion)) {
    session_destroy();
    header("Location: ../php/login.php");
}
?>
<html lang = "Es-es">

    <head>
        <meta charset = "utf-8">
        <!--link de boostrap-->
        <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel = "stylesheet"
              integrity = "sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin = "anonymous">
        <!--link al css del index que se encuentra en la carpeta css-->
        <link rel = "stylesheet" type = "text/css" href = "../css/subirFoto.css" />
        <script src = "http://code.jquery.com/jquery-1.11.3.min.js"></script>
        <title>Registro Proveedor</title>
    </head>

    <body>
        <!--La barra de navegacion principal, la cual esta hecha usando boostrap-->
        <nav>
            <div id="interioNav">

                <a id="Logo">Click And Pic</a>

                <img id="usuarioPaginaPrincipal" src="../assets/admin.svg">
            </div>
        </nav>

        <div id="menuVertical">
            <img id="cerrar_menu" src="../assets/x.png">
            <img id="avatar" src="../assets/admin.svg">
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
                    <li><a href="../php/opcionesSoloUsuario.php">Opciones de usuario </a></li>
                    <li><form method="post"><input id="cerraSesion" type="submit" name="cerrarSesion" value="Cerrar Sesión"></form></li>
                <?php } ?>
            </ul>
        </div>
        <div id="tituloSesion">
            <p id="tituloMaestro">SUBIR TU PUBLICACIÓN</p>
        </div>

        <a  href="../php/tusFotos.php"><img id="atras" src="../assets/atras.svg"></a>

        <div id="formularioRegistro">
            <form class="row g-3" method="post" enctype="multipart/form-data">
                </br>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Titulo</label>
                    <input class="form-control" type="text" name="titulo" placeholder="Amanecer negro" aria-label="default input example">
                </div>
                </br>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Foto</label>
                    <input class="form-control" type="file" name="publicacion" placeholder="++++++" aria-label="default input example">
                </div>
                </br>
                <div class="col-auto">
                    <button type="submit" name="subir" id="terminarRegistro" class="btn btn-danger mb-3">Subir Publicación</button>
                </div>
            </form>

        </div>      
        <div id='<?php echo $tipo; ?>'><span ><?php echo $mensaje; ?></span></div>
        <script src="../scripts/menuUsuario.js"></script>
    </body>
</html>

