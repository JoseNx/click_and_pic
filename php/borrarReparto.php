<!DOCTYPE html>
<?php
//Llamamos al archivo funciones.php para que podamos usar las funciones de esta y base de datos.
include '../clases/ValidarDatos.php';
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
$borrar = (filter_input(INPUT_POST, "borrar"));
//Con esto sacamos la lista de los productos.
$consultaReparto = "SELECT * FROM `empresareparto`";
$resultadoReparto = $conexion->prepare($consultaReparto);
$resultadoReparto->execute();
$listaReparto = $resultadoReparto->fetchAll(PDO::FETCH_ASSOC);
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
//Ejecucion
if (isset($borrar)) {
    foreach ($_POST['repartoEliminar'] as $productooDato) {
        $consultaDevolver = "DELETE FROM `empresareparto` WHERE codigo_empresa='$productoDato'";
        $conexion->query($consultaDevolver);
    }
    header("Location: borrarProducto.php");
    //$mensaje = "Borrado realizado con exito.";
    //$tipo = "mensajeExito";
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
        <link rel = "stylesheet" type = "text/css" href = "../css/borrarReparto.css" />
        <script src = "http://code.jquery.com/jquery-1.11.3.min.js"></script>
        <title>Borrar Reparto</title>
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
            <p id="tituloMaestro">Opciones de Reparto</p>
        </div>

        <a  href="../php/opcionesReparto.php"><img id="atras" src="../assets/atras.svg"></a>

        <div id="formularioBorrado">
            <form method="post">
                <table id="tablaListaControl">
                    <thead>
                    <th>Codigo de la empresa de reparto</th>
                    <th>Nombre de la empresa de reparto</th>
                    <th>Datos de la empresa de reparto</th>
                    <th>Seleccionar</th>
                    </thead>
                    <tbody>
                        <?php foreach ($listaReparto as $repartoDato) {
                            ?>

                            <tr>
                                <td><?php echo $repartoDato['codigo_empresa'] ?></td>
                                <td><?php echo $repartoDato['nombre_empresa'] ?></td>
                                <td><?php echo $repartoDato['datos_empresa'] ?></td>
                                <td><input type="checkbox" name="repartoEliminar[]" value="<?php echo $proveedorDato['codigo_proveedor'] ?>"/></td>
                            </tr>
                        </tbody>

                    <?php }
                    ?>
                </table> 
                <?php
                ?>
                </br> 
                <input id="botonFormularioBorrado" type="submit" name="borrar" value="Confirmar Borrado">
            </form>
        </div>       
        <div id='<?php echo $tipo; ?>'><span ><?php echo $mensaje; ?></span></div>
        <script src="../scripts/menuUsuario.js"></script>
    </body>
</html>
