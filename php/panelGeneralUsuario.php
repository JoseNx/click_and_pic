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
$nombreMod = filter_input(INPUT_POST, "nombreRegistro");
$apellidoMod = filter_input(INPUT_POST, "apellidoRegistro");
$contraseñaRegistro = filter_input(INPUT_POST, "contraseñaRegistro");
$correoMod = filter_input(INPUT_POST, "correoRegistro");
$contraseñaModCod = password_hash($contraseñaRegistro, PASSWORD_DEFAULT);
$modificar = filter_input(INPUT_POST, "modificar");
if (!isset($_SESSION['login'])) {
    header("Location: ../php/login.php");
}

if (isset($_SESSION['login'])) {
    if ($_SESSION['login'] != $cuentaNormal)
        header("Location: ../php/login.php");
}

if (!isset($_SESSION['rol'])) {
    $_SESSION['rol'] = "";
}
?>
<!DOCTYPE html>
<html lang="Es-es">

    <head>
        <meta charset="utf-8">
        <!--link al css del index que se encuentra en la carpeta css-->
        <link rel="stylesheet" type="text/css" href="../css/panelGeneralUsuario.css" />
        <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel = "stylesheet"
              integrity = "sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin = "anonymous">
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

        <div id="tituloSesion">
            <p id="tituloMaestro">Editar tu usuario</p>
        </div>

        <div id="formularioRegistro">
            <form class="row g-3" method="post">
                </br>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Editar Nombre</label>
                    <input class="form-control" type="text" name="nombreRegistro" placeholder="Jose" aria-label="default input example">
                </div>
                </br>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Editar Apellidos</label>
                    <input class="form-control" type="text" name="apellidoRegistro" placeholder="valentin" aria-label="default input example">
                </div>
                </br>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Editar Correo electronico</label>
                    <input class="form-control" name="correoRegistro" placeholder="josevalentin@freemail.com" aria-label="default input example">
                </div>
                </br>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Editar Contraseña</label>
                    <input class="form-control" type="text" name="contraseñaRegistro" placeholder="************" aria-label="default input example">
                </div>
                </br>
                <div class="col-auto">
                    <button type="submit" name="modificar" id="terminarRegistro" class="btn btn-danger mb-3">MODIFICAR</button>
            </form>
        </div>
    </div>
    <div id='<?php echo $tipo; ?>'><span ><?php echo $mensaje; ?></span></div> 

    <script src="../scripts/menuUsuario.js"></script>
</body>
</html>
<?php
//Este boton se encarga de cerrar la sesion
if (isset($cerrarSesion)) {
    session_destroy();
    header("Location: ../php/login.php");
}

//Se encarga de modificar solo un apartado del usuario(contraseña).
if (isset($modificar)) {
    if (!empty($contraseñaMod)) {
        if (Usuario::Modificar_Contraseña($contraseñaModCod, $_SESSION['login']) == true) {
            $mensaje = "Cambio/s realizados con exito.";
            $tipo = "mensajeExito";
        } else {
            $mensaje = "No se han podido realizar los cambios.";
            $tipo = "mensajeError";
        }
    }
}

//Se encarga de modificar solo un apartado del usuario(nombre).
if (isset($modificar)) {
    if (!empty($nombreMod)) {
        if (Usuario::Modificar_Nombre($nombreMod, $_SESSION['login']) == true) {
            $mensaje = "Cambio/s realizados con exito.";
            $tipo = "mensajeExito";
        } else {
            $mensaje = "No se han podido realizar los cambios.";
            $tipo = "mensajeError";
        }
    }
}

//Se encarga de modificar solo un apartado del usuario(apellido).
if (isset($modificar)) {
    if (!empty($apellidoMod)) {

        if (Usuario::Modificar_Apellido($apellidoMod, $_SESSION['login']) == true) {
            $mensaje = "Cambio/s realizados con exito.";
            $tipo = "mensajeExito";
        } else {
            $mensaje = "No se han podido realizar los cambios.";
            $tipo = "mensajeError";
        }
    }
}

//Se encarga de modificar solo un apartado del usuario(nombre).
if (isset($modificar)) {
    if (!empty($correoMod)) {
        if (Usuario::Modificar_Correo($correoMod, $_SESSION['login']) == true) {
            $mensaje = "Cambio/s realizados con exito.";
            $tipo = "mensajeExito";
        } else {
            $mensaje = "No se han podido realizar los cambios.";
            $tipo = "mensajeError";
        }
    }
}
