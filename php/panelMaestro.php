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
//variables
$_SESSION['login'];
$mensaje = "";
$tipo = "";
$cerrarSesion = filter_input(INPUT_POST, "cerrarSesion");
$listaProductoBoton = filter_input(INPUT_POST, "listaUsuarios");
$listaProductosBoton = filter_input(INPUT_POST, "listaProductos");
//Con esto sacamos la lista de los productos.
$consultaProducto = "SELECT * FROM producto";
$resultadoProducto = $conexion->prepare($consultaProducto);
$resultadoProducto->execute();
$listaProductos = $resultadoProducto->fetchAll(PDO::FETCH_ASSOC);
//Con esto sacamos la lista de los usuarios.
$rolBuscado = "normal";
$consultaUsuario = "SELECT * FROM `usuario` WHERE rol ='$rolBuscado'";
$resultadoUsuario = $conexion->prepare($consultaUsuario);
$resultadoUsuario->execute();
$listaUsuario = $resultadoUsuario->fetchAll(PDO::FETCH_ASSOC);
$cuentaMaestra = "maestro";
if (!isset($_SESSION['login'])) {
    header("Location: ../php/login.php");
}

if (isset($_SESSION['login'])) {
    if ($_SESSION['login'] != $cuentaMaestra)
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
        <link rel = "stylesheet" type = "text/css" href = "../css/panelMaestro.css" />
        <script src = "http://code.jquery.com/jquery-1.11.3.min.js"></script>
        <title>Panel maestro</title>
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
                <li><a href="../php/panelMaestro.php">Panel general</a></li>
                <li><a href="../php/opcionesAdmin.php">Opciones de administrador </a></li>
                <li><a href="../php/opcionesUsuario.php">Opciones de Usuario </a></li>
                <li><a href="../php/opcionesProducto.php">Opciones de Producto </a></li>
                <li><a href="../php/opcionesProveedor.php">Opciones de Proveedor </a></li>
                <li><a href="../php/opcionesReparto.php">Opciones de Reparto </a></li>
                <li><a href="../php/opcionesPedido.php">Opciones de Pedido </a></li>
                <li><form method="post"><input id="cerraSesion" type="submit" name="cerrarSesion" value="Cerrar Sesión"></form></li>
            </ul>
        </div>

        <div id="tituloSesion">
            <p id="tituloMaestro">PANEL MAESTRO</p>
        </div>

        <div id="botonListaUsuarios">
            <form method="post"><input id="botonListaUsuariosInterior" type="submit" name="listaUsuarios" value="Lista de usuarios"></form>
        </div>

        <div id="botonListaProductos">
            <form method="post"><input id="botonListaProductosInterior" type="submit" name="listaProductos" value="Lista de productos"></form>
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


if (isset($listaProductoBoton)) {
    ?> 
    <table  id="tablaListaControl">
        <thead>
        <th>Login</th>
        <th>Nombre Completo</th>
        <th>Correo electronico</th>
        <th>Contraseña</th>
    </thead>
    <tbody>
        <?php foreach ($listaUsuario as $usuarioDato) {
            ?>

            <tr>
                <td><?php echo $usuarioDato['login'] ?></td>
                <td><?php echo $usuarioDato['nombre'] . " " . $usuarioDato['apellido'] ?></td>
                <td><?php echo $usuarioDato['correo'] ?></td>
                <td><?php echo "*************" ?></td>
            </tr>
        </tbody>

    <?php }
    ?>
    </table> 
    <?php
}


if (isset($listaProductosBoton)) {
    ?> 
    <table id="tablaListaControl">
        <thead>
        <th>Nombre corto</th>
        <th>Nombre Completo</th>
        <th>Empresa de reparto</th>
        <th>Proveedor</th>
    </thead>
    <tbody>
        <?php foreach ($listaProductos as $productoDato) {
            ?>

            <tr>
                <td><?php echo $productoDato['nombre_corto'] ?></td>
                <td><?php echo $productoDato['nombre_prod'] ?></td>
                <td><?php echo $productoDato['codigo_empresa'] ?></td>
                <td><?php echo $productoDato['codigo_proveedor'] ?></td>
            </tr>
        </tbody>

    <?php }
    ?>
    </table> 
    <?php
}
?>