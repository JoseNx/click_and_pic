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
$listaAdminBoton = filter_input(INPUT_POST, "listaAdmin");
$editarAdminBoton = filter_input(INPUT_POST, "editarAdmin");
$borrarAdminBoton = filter_input(INPUT_POST, "borrarAdmin");
$registrarAdminBoton = filter_input(INPUT_POST, "registrarAdmin");
$cuentaMaestra = "maestro";
if (!isset($_SESSION['login'])) {
    header("Location: ../php/login.php");
}

if (isset($_SESSION['login'])) {
    if ($_SESSION['login'] != $cuentaMaestra)
        header("Location: ../php/login.php");
}
//Con esto sacamos la lista de los usuarios.
$rolBuscado = "admin";
$consultaAdmin = "SELECT * FROM `usuario` WHERE rol ='$rolBuscado'";
$resultadoAdmin = $conexion->prepare($consultaAdmin);
$resultadoAdmin->execute();
$listaAdmin = $resultadoAdmin->fetchAll(PDO::FETCH_ASSOC);

?>
<html lang = "Es-es">

    <head>
        <meta charset = "utf-8">
        <!--link de boostrap-->
        <link href = "https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel = "stylesheet"
              integrity = "sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin = "anonymous">
        <!--link al css del index que se encuentra en la carpeta css-->
        <link rel = "stylesheet" type = "text/css" href = "../css/opcionesAdmin.css" />
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
            <p id="tituloMaestro">Opciones de Administrador</p>
        </div>

        <div id="botonListaAdministrador">
            <form method="post"><input id="botonListaAdministradorInterior" type="submit" name="listaAdmin" value="Lista de usuarios"></form>
        </div>

        <div id="botonRegistrarAdministrador">
            <form method="post"><input id="botonRegistrarAdministradorInterior" type="submit" name="registrarAdmin" value="Registrar Administrador"></form>
        </div>

        <div id="botonEditarAdministrador">
            <form method="post"><input id="botonEditarAdministradorInterior" type="submit" name="editarAdmin" value="Editar Administrador"></form>
        </div> 

        <div id="botonBorrarAdministrador">
            <form method="post"><input id="botonBorrarAdministradorInterior" type="submit" name="borrarAdmin" value="Borrar Administrador"></form>
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


if (isset($listaAdminBoton)) {
    ?> 
    <table  id="tablaListaControl">
        <thead>
        <th>Login</th>
        <th>Nombre Completo</th>
        <th>Correo electronico</th>
        <th>Contraseña</th>
    </thead>
    <tbody>
        <?php foreach ($listaAdmin as $adminDato) {
            ?>

            <tr>
                <td><?php echo $adminDato['login'] ?></td>
                <td><?php echo $adminDato['nombre'] . " " . $adminDato['apellido'] ?></td>
                <td><?php echo $adminDato['correo'] ?></td>
                <td><?php echo "*************" ?></td>
            </tr>
        </tbody>

    <?php }
    ?>
    </table> 
    <?php
}


if (isset($editarAdminBoton)) {
    header("Location: ../php/editarAdministrador.php");
}

if (isset($borrarAdminBoton)) {
    header("Location: ../php/borrarAdmin.php");
}

if (isset($registrarAdminBoton)) {
    header("Location: ../php/registrarAdmin.php");
}
?>