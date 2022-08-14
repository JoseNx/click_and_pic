<!DOCTYPE html>
<?php
//Llamamos al archivo funciones.php para que podamos usar las funciones de esta y base de datos.
include '../clases/ValidarDatos.php';
include '../clases/Producto.php';
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
//Variables del formulario de registro
$nombreCortoRegistro = filter_input(INPUT_POST, "nombreCorto");
$nombreCompletoRegistro = filter_input(INPUT_POST, "nombreCompleto");
$codigoEmpresa = filter_input(INPUT_POST, "codigoEmpresa");
$codigoProveedor = filter_input(INPUT_POST, "codigoProveedor");
$precio = filter_input(INPUT_POST, "precio");
$tipoProducto = filter_input(INPUT_POST, "tipoProducto");
$modificar = filter_input(INPUT_POST, "Editar");
//Este boton se encarga de cerrar la sesion
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
if (isset($cerrarSesion)) {
    session_destroy();
    header("Location: ../php/login.php");
}
//Se encarga de modificar solo un apartado del producto(nombre completo).
if (isset($modificar)) {
    if (!empty($nombreCompletoRegistro)) {
        if (Producto::Modificar_Nombre_Completo($nombreCompletoRegistro, $nombreCortoRegistro) == true) {
            $mensaje = "Cambio/s realizados con exito.";
            $tipo = "mensajeExito";
        } else {
            $mensaje = "No se han podido realizar los cambios.";
            $tipo = "mensajeError";
        }
    }
}

//Se encarga de modificar solo un apartado del producto(codigo de empresa).
if (isset($modificar)) {
    if (!empty($codigoEmpresa)) {
        if (Producto::Modificar_Codigo_Empresa($codigoEmpresa, $nombreCortoRegistro) == true) {
            $mensaje = "Cambio/s realizados con exito.";
            $tipo = "mensajeExito";
        } else {
            $mensaje = "No se han podido realizar los cambios.";
            $tipo = "mensajeError";
        }
    }
}

//Se encarga de modificar solo un apartado del producto(codigo de empresa).
if (isset($modificar)) {
    if (!empty($codigoProveedor)) {
        if (Producto::Modificar_Codigo_Proveedor($codigoProveedor, $nombreCortoRegistro) == true) {
            $mensaje = "Cambio/s realizados con exito.";
            $tipo = "mensajeExito";
        } else {
            $mensaje = "No se han podido realizar los cambios.";
            $tipo = "mensajeError";
        }
    }
}


//Se encarga de modificar solo un apartado del producto(codigo de empresa).
if (isset($modificar)) {
    if (!empty($precio)) {
        if (Producto::Modificar_Precio($precio, $nombreCortoRegistro) == true) {
            $mensaje = "Cambio/s realizados con exito.";
            $tipo = "mensajeExito";
        } else {
            $mensaje = "No se han podido realizar los cambios.";
            $tipo = "mensajeError";
        }
    }
}


//Se encarga de modificar solo un apartado del producto(codigo de empresa).
if (isset($modificar)) {
    if (!empty($tipoProducto)) {
        if (Producto::Modificar_Tipo_Producto($tipoProducto, $nombreCortoRegistro) == true) {
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
        <link rel = "stylesheet" type = "text/css" href = "../css/editarProducto.css" />
        <script src = "http://code.jquery.com/jquery-1.11.3.min.js"></script>
        <title>Editar Producto</title>
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
            <p id="tituloMaestro">Opciones de Producto</p>
        </div>

        <a  href="../php/opcionesProducto.php"><img id="atras" src="../assets/atras.svg"></a>

        <div id="formularioRegistro">
            <form class="row g-3" method="post">
                </br>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Nombre corto del producto que quieres editar</label>
                    <input class="form-control" id="exampleFormControlInput1" type="text" name="nombreCorto" placeholder="CAM_REX_ULT">
                </div>
                </br>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Nombre completo</label>
                    <input class="form-control" type="text" name="nombreCompleto" placeholder="camara reflex ultimatum dx" aria-label="default input example">
                </div>
                </br>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Codigo de la empresa de reparto</label>
                    <input class="form-control" type="text" name="codigoEmpresa" placeholder="++++++" aria-label="default input example">
                </div>
                </br>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Codigo de proveedor</label>
                    <input class="form-control" name="codigoProveedor" placeholder="+++++++" aria-label="default input example">
                </div>
                </br>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Precio</label>
                    <input class="form-control" name="precio" placeholder="+++++++" aria-label="default input example">
                </div>
                </br>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Tipo de producto</label>
                    <select class="form-control" name="tipoProducto">
                        <option value="accesorio">Accesorio</option>
                        <option value="camara" selected>Camara</option>
                    </select>
                </div>
                </br>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Foto del producto</label>
                    <input class="form-control" type="file" name="fotoProducto" aria-label="default input example">
                </div>
                </br>
                <div class="col-auto">
                    <button type="submit" name="Editar" id="terminarRegistro" class="btn btn-danger mb-3">EDITAR</button>
            </form>
        </div>
    </div>       
    <div id='<?php echo $tipo; ?>'><span ><?php echo $mensaje; ?></span></div>
    <script src="../scripts/menuUsuario.js"></script>
</body>
</html>

