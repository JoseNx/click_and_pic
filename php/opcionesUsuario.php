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
$listaUsuarioBoton = filter_input(INPUT_POST, "listaUsuario");
$editarUsuarioBoton = filter_input(INPUT_POST, "editarUsuario");
$borrarUsuarioBoton = filter_input(INPUT_POST, "borrarUsuario");
$registrarUsuarioBoton = filter_input(INPUT_POST, "registrarUsuario");
//Con esto sacamos la lista de los usuarios.
$rolBuscado = "normal";
$consultaUsuario = "SELECT * FROM `usuario` WHERE rol ='$rolBuscado'";
$resultadoUsuario = $conexion->prepare($consultaUsuario);
$resultadoUsuario->execute();
$listaUsuario = $resultadoUsuario->fetchAll(PDO::FETCH_ASSOC);
//variables de rol        
$cuentaMaestra = "maestro";
$cuentaAdmin = "admin";
$cuentaNormal = "normal";
if (!isset($_SESSION['login'])) {
    header("Location: ../php/login.php");
}

if (isset($_SESSION['login'])) {
    if ($_SESSION['login'] == $cuentaNormal)
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
        <link rel = "stylesheet" type = "text/css" href = "../css/opcionesUsuario.css" />
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

        <div id="botonListaAdministrador">
            <form method="post"><input id="botonListaAdministradorInterior" type="submit" name="listaUsuario" value="Lista de usuarios"></form>
        </div>

        <div id="botonRegistrarAdministrador">
            <form method="post"><input id="botonRegistrarAdministradorInterior" type="submit" name="registrarUsuario" value="Registrar usuario"></form>
        </div>

        <div id="botonEditarAdministrador">
            <form method="post"><input id="botonEditarAdministradorInterior" type="submit" name="editarUsuario" value="Editar usuario"></form>
        </div> 

        <div id="botonBorrarAdministrador">
            <form method="post"><input id="botonBorrarAdministradorInterior" type="submit" name="borrarUsuario" value="Borrar usuario"></form>
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


if (isset($listaUsuarioBoton)) {
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


if (isset($editarUsuarioBoton)) {
    header("Location: ../php/editarUsuario.php");
}

if (isset($borrarUsuarioBoton)) {
    header("Location: ../php/borrarUsuario.php");
}

if (isset($registrarUsuarioBoton)) {
    header("Location: ../php/registrarUsuario.php");
}
?>