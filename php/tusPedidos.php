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
$mensaje = "";
$tipo = "";
$cuentaMaestra = "maestro";
$cuentaAdmin = "admin";
$cuentaNormal = "normal";
$noLogin = "";
$login = $_SESSION['login'];
if (!isset($_SESSION['login'])) {
    header("Location: ../php/login.php");
}

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

if (!isset($_SESSION['total'])) {
    $_SESSION['total'] = 0;
}


//Con esto sacamos la lista de los productos que sean clasificados como camaras.
$consultaPedido = "SELECT * FROM `pedido` WHERE login= '$login' ORDER BY codigo_pedido DESC";
$resultadoPedido = $conexion->prepare($consultaPedido);
$resultadoPedido->execute();
$listaPedido = $resultadoPedido->fetchAll(PDO::FETCH_ASSOC);



if (!isset($_SESSION['rol'])) {
    $_SESSION['rol'] = "";
}

//Este boton se encarga de cerrar la sesion
if (isset($cerrarSesion)) {
    session_destroy();
    header("Location: ../php/login.php");
}
?>
<!DOCTYPE html>
<html lang="Es-es">

    <head>
        <meta charset="utf-8">
        <!--link al css del index que se encuentra en la carpeta css-->
        <link rel = "stylesheet" type = "text/css" href = "../css/tusPedidos.css" />
        <title>Tus pedidos</title>
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
                <a id="carritoExterno" href="../php/carrito.php"><img id="carritoCompra" src="../assets/carrito.svg"></a>
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
        <p id="tituloProductos">Tus Pedidos</p>

        <div id="margenTabla">
            <table id="tablaListaControl">
                <thead>
                <th>Codigo de pedido</th>
                <th>Total pedido</th>
                </thead>
                <tbody>
                    <?php foreach ($listaPedido as $PedidoDato) {
                        ?>

                        <tr>
                            <td><?php echo $PedidoDato['codigo_pedido'] ?></td>
                            <td><?php echo $PedidoDato['total_precio'] . " €" ?></td>
                        </tr>
                    </tbody>

                <?php }
                ?>
            </table> 
        </div>
        <script src="../scripts/menuUsuario.js"></script>
    </body>
</html>
