<!DOCTYPE html>
<?php
//Llamamos al archivo funciones.php para que podamos usar las funciones de esta y base de datos.
include '../clases/ValidarDatos.php';
include '../clases/Usuario.php';
require_once('../clases/DB.php');
//Iniciamos sesion
session_start();
//Conectamos con la base de datos.
$conexion = new PDO('mysql:host=localhost;dbname=click_and_pic', 'root', '');
//variables de rol        
$cuentaMaestra = "maestro";
$cuentaAdmin = "admin";
//variables
$_SESSION['login'];
$mensaje = "";
$tipo = "";
$cerrarSesion = filter_input(INPUT_POST, "cerrarSesion");
$loginCuenta = filter_input(INPUT_POST, "loginRegistro");
$nombreMod = filter_input(INPUT_POST, "nombreRegistro");
$apellidoMod = filter_input(INPUT_POST, "apellidoRegistro");
$contraseñaRegistro = filter_input(INPUT_POST, "contraseñaRegistro");
$correoMod = filter_input(INPUT_POST, "correoRegistro");
$contraseñaModCod = password_hash($contraseñaRegistro, PASSWORD_DEFAULT);
$modificar = filter_input(INPUT_POST, "modificar");
$cuentaNormal = "normal";
if (!isset($_SESSION['login'])) {
    header("Location: ../php/login.php");
}

if (isset($_SESSION['login'])) {
    if ($_SESSION['login'] == $cuentaNormal)
        header("Location: ../php/login.php");
}
//Este boton se encarga de cerrar la sesion
if (isset($cerrarSesion)) {
    session_destroy();
    header("Location: ../php/login.php");
}
//Se encarga de modificar solo un apartado del usuario(contraseña).
if (isset($modificar)) {
    if (!empty($contraseñaMod)) {
        if (Usuario::Modificar_Contraseña($contraseñaModCod, $loginCuenta) == true) {
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
        if (Usuario::Modificar_Nombre($nombreMod, $loginCuenta) == true) {
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

        if (Usuario::Modificar_Apellido($apellidoMod, $loginCuenta) == true) {
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
        if (Usuario::Modificar_Correo($correoMod, $loginCuenta) == true) {
            $mensaje = "Cambio/s realizados con exito.";
            $tipo = "mensajeExito";
        } else {
            $mensaje = "No se han podido realizar los cambios.";
            $tipo = "mensajeError";
        }
    }
}
?>
<html lang = "Es-es">

    <head>
        <meta charset = "utf-8">
        <!--link de boostrap-->
        <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel = "stylesheet"
              integrity = "sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin = "anonymous">
        <!--link al css del index que se encuentra en la carpeta css-->
        <link rel = "stylesheet" type = "text/css" href = "../css/editarUsuario.css" />
        <script src = "http://code.jquery.com/jquery-1.11.3.min.js"></script>
        <title>Editar Administrador</title>
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
            <h1>Menú de <?php echo $_SESSION['nombreUsur'] ?></h1>
            <ul>
                <?php if ($_SESSION['rol'] == $cuentaMaestra) { ?>
                    <li><a href="../php/panelMaestro.php">Panel general</a></li>
                    <li><a href="../php/opcionesAdmin.php">Opciones de administrador </a></li>
                    <li><a href="../php/opcionesUsuario.php">Opciones de Usuario </a></li>
                    <li><a href="../php/opcionesProducto.php">Opciones de Producto </a></li>
                    <li><a href="../php/opcionesProveedor.php">Opciones de Proveedor </a></li>
                    <li><a href="../php/opcionesReparto.php">Opciones de Reparto </a></li>
                    <li><a href="../php/opcionesPedido.php">Opciones de Pedido </a></li>
                    <li><form method="post"><input id="cerraSesion" type="submit" name="cerrarSesion" value="Cerrar Sesión"></form></li>
                <?php }if ($_SESSION['rol'] == $cuentaAdmin) { ?>
                    <li><a href="../php/panelAdmin.php">Panel general</a></li>
                    <li><a href="../php/opcionesUsuario.php">Opciones de Usuario </a></li>
                    <li><a href="../php/opcionesProducto.php">Opciones de Producto </a></li>
                    <li><a href="../php/opcionesProveedor.php">Opciones de Proveedor </a></li>
                    <li><a href="../php/opcionesReparto.php">Opciones de Reparto </a></li>
                    <li><a href="../php/opcionesPedido.php">Opciones de Pedido </a></li>
                    <li><form method="post"><input id="cerraSesion" type="submit" name="cerrarSesion" value="Cerrar Sesión"></form></li>
                <?php } ?>
            </ul>
        </div>

        <div id="tituloSesion">
            <p id="tituloMaestro">PANEL MAESTRO</p>
            <p id="tituloMaestro">Opciones de Usuario</p>
        </div>

        <a  href="../php/opcionesUsuario.php"><img id="atras" src="../assets/atras.svg"></a>

        <div id="formularioRegistro">
            <form class="row g-3" method="post">
                </br>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Login del usuario al que quieres editar</label>
                    <input class="form-control" id="exampleFormControlInput1" type="text" name="loginRegistro" placeholder="Jose1231">
                </div>
                </br>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Nombre</label>
                    <input class="form-control" type="text" name="nombreRegistro" placeholder="Jose" aria-label="default input example">
                </div>
                </br>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Apellidos</label>
                    <input class="form-control" type="text" name="apellidoRegistro" placeholder="valentin" aria-label="default input example">
                </div>
                </br>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Correo electronico</label>
                    <input class="form-control" name="correoRegistro" placeholder="josevalentin@freemail.com" aria-label="default input example">
                </div>
                </br>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Contraseña</label>
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
