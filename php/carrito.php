<!DOCTYPE html>
<?php
//Conectamos con la base de datos.
$conexion = new PDO('mysql:host=localhost;dbname=click_and_pic', 'root', '');
//Llamamos al archivo funciones.php para que podamos usar las funciones de esta y base de datos.
include '../clases/ValidarDatos.php';
include '../clases/Pedido.php';
require_once('../clases/DB.php');
//Iniciamos sesion
session_start();
//variable de formulario
$mensaje = "";
$tipo = "";
$cuentaMaestra = "maestro";
$cuentaAdmin = "admin";
$cuentaNormal = "normal";
$noLogin = "";
$finalizar = (filter_input(INPUT_POST, "finalizar"));
$vaciar = (filter_input(INPUT_POST, "vaciar"));
$carrito = $_SESSION['carrito'];
$cerrarSesion = filter_input(INPUT_POST, "cerrarSesion");

if (!isset($_SESSION['login'])) {
    header("Location: ../php/login.php");
}


if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

if (!isset($_SESSION['total'])) {
    $_SESSION['total'] = 0;
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
        <link rel = "stylesheet" type = "text/css" href = "../css/carrito.css" />
        <title>Página de Compra</title>
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
                    <li><form method="post"><input id="cerraSesion" type="submit" name="cerrarSesion" value="Cerrar Sesión"></form></li>
                <?php } ?>
            </ul>
        </div>

        <p id="tituloProductos">Finalizar Pedido</p>
        <?php if ($_SESSION['total'] == 0) { ?>
            <div id="ningunProducto">
                <p id="interioNinguno">No has añadido ningun producto a la cesta, deberias añadir alguno.</p>

            </div>
        <?php } else { ?>
            <div id="ticket">
                <p id="tituloTicket">Lista de productos</p>
                <?php foreach ($carrito as $productoCarrito) { ?>
                    <p id="info"><?php echo $productoCarrito['nombre'] ?> cuesta <?php echo $productoCarrito['precio'] ?> € </p>
                <?php } ?>
                <p id="total"> El total es <?php echo $_SESSION['total'] ?> €<p>
                <form method="post">
                    <input id="botonFinalizar" name="finalizar" type="submit" value="Finalizar compra">
                    <input id="botonVaciar" name="vaciar" type="submit" value="Vaciar carrito">
                </form>
            </div>
            <div id='<?php echo $tipo; ?>'><span ><?php echo $mensaje; ?></span></div>
        <?php } ?>
    </body>
    <script src="../scripts/menuUsuario.js"></script>
</html>
<?php
//Añado un nuevo articulo al carrito
if (isset($finalizar)) {

    if (Pedido::Pedido_Nuevo($_SESSION['login'], $_SESSION['total']) == true) {
        unset($_SESSION['carrito']);
        unset($_SESSION['total']);
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = array();
        }

        if (!isset($_SESSION['total'])) {
            $_SESSION['total'] = 0;
        }
        header("Location: ../php/pedidoExitoso.php");
    }
}


//Añado un nuevo articulo al carrito
if (isset($vaciar)) {
    unset($_SESSION['carrito']);
    unset($_SESSION['total']);
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = array();
    }

    if (!isset($_SESSION['total'])) {
        $_SESSION['total'] = 0;
    }
    header("Location: ../php/carrito.php");
}

//Este boton se encarga de cerrar la sesion
if (isset($cerrarSesion)) {
    session_destroy();
    header("Location: ../php/login.php");
}
