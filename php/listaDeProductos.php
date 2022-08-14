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
$mensaje = "";
$tipo = "";
$cuentaMaestra = "maestro";
$cuentaAdmin = "admin";
$cuentaNormal = "normal";
$noLogin = "";
$camara = "camara";
$accesorio = "accesorio";

//Con esto sacamos la lista de los productos que sean clasificados como camaras.
$consultaProductoCamara = "SELECT * FROM `producto` WHERE tipo_producto= '$camara' ORDER BY nombre_corto DESC";
$resultadoProductoCamara = $conexion->prepare($consultaProductoCamara);
$resultadoProductoCamara->execute();
$listaProductoCamara = $resultadoProductoCamara->fetchAll(PDO::FETCH_ASSOC);

//Con esto sacamos la lista de los productos que sean clasificados como accesorios.
$consultaProductoAccesorio = "SELECT * FROM `producto` WHERE tipo_producto='$accesorio' ORDER BY nombre_corto DESC";
$resultadoProductoAccesorio = $conexion->prepare($consultaProductoAccesorio);
$resultadoProductoAccesorio->execute();
$listaProductoAccesorio = $resultadoProductoAccesorio->fetchAll(PDO::FETCH_ASSOC);

$cerrarSesion = filter_input(INPUT_POST, "cerrarSesion");
$listaCamara = filter_input(INPUT_POST, "listaCamara");
$listaAccesorios = filter_input(INPUT_POST, "listaAccesorios");

$añadirCarrito = (filter_input(INPUT_POST, "añadirCarrito"));
$botonAñadir = (filter_input(INPUT_POST, "botonAñadir"));

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}


if (!isset($_SESSION['rol'])) {
    $_SESSION['rol'] = "";
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
        <link rel = "stylesheet" type = "text/css" href = "../css/listaDeProductos.css" />
        <script src = "http://code.jquery.com/jquery-1.11.3.min.js"></script>
        <title>Lista de productos</title>
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
            <img id="avatar" src="../assets/admin.svg">
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

        <p id="tituloProductos">Nuestros Productos</p>

        <div id="botonLista">
            <a id="botonListaInterior" href="../php/zonaProductos.php">PAGINA PRINCIPAL</a>
        </div> 

        <div id="botonFiltroPublicacion">
            <a id="botonFiltroPublicacionInterior" href="../php/filtradoProductos.php">BUSCAR POR FILTRO</a>
        </div>

        <div id="botonListaCamara">
            <form method="post"><input id="botonListaCamaraInterior" type="submit" name="listaCamara" value="Lista de Camaras"></form>
        </div>

        <div id="botonListaAccesorio">
            <form method="post"><input id="botonListaAccesorioInterior" type="submit" name="listaAccesorios" value="Lista de Accesorios"></form>
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


if (isset($listaCamara)) {
    ?> 
    <div id="margenTabla">
        <table id="tablaListaControl">
            <thead>
            <th>Nombre Completo</th>
            <th>Precio</th>
            <th>Foto</th>
            <th>Comprar</th>

            </thead>
            <tbody>
                <?php foreach ($listaProductoCamara as $CamaraDato) {
                    ?>

                    <tr>
                        <td><?php echo $CamaraDato['nombre_prod'] ?></td>
                        <td><?php echo $CamaraDato['precio'] . " €" ?></td>
                        <td><img id="fotoProducto" width="100px" src="data:<?php echo $CamaraDato['tipo']; ?>;base64,<?php echo base64_encode($CamaraDato['foto_producto']); ?>"></td> 
                        <td>                            
                            <form>
                                <input name="añadirCarrito[]" type="hidden"  value="<?php echo $CamaraDato['nombre_corto'] ?>">
                                <input id="botonProducto" name="botonAñadir" type="submit" value="Añadir al carrito">
                            </form>
                        </td>

                    </tr>
                </tbody>

            <?php }
            ?>
        </table> 
    </div>
    <?php
}


if (isset($listaAccesorios)) {
    ?>
    <table id="tablaListaControl">
        <thead>
        <th>Nombre Completo</th>
        <th>Precio</th>
        <th>Foto</th>
        <th>Comprar</th>

    </thead>
    <tbody>
        <?php foreach ($listaProductoAccesorio as $AccesorioDato) {
            ?>

            <tr>
                <td><?php echo $AccesorioDato['nombre_prod'] ?></td>
                <td><?php echo $AccesorioDato['precio'] . " €" ?></td>
                <td><img id="fotoProducto" width="100px" src="data:<?php echo $AccesorioDato['tipo']; ?>;base64,<?php echo base64_encode($AccesorioDato['foto_producto']); ?>"></td> 
                <td>                            
                    <form>
                        <input name="añadirCarrito[]" type="hidden"  value="<?php echo $AccesorioDato['nombre_corto'] ?>">
                        <input id="botonProducto" name="botonAñadir" type="submit" value="Añadir al carrito">
                    </form>
                </td>

            </tr>
        </tbody>

    <?php }
    ?>
    </table> 
    <?php
}

//añadimos un nuevo articulo al carrito
if (isset($botonAñadir)) {
    foreach ($_POST['añadirCarrito'] as $productoDato) {
        //Con esto sacamos la lista de los productos que sean clasificados como camaras.
        $consultaProductoAñadir = "SELECT * FROM `producto` WHERE nombre_corto= '$productoDato'";
        $resultadoProductoAñadir = $conexion->prepare($consultaProductoAñadir);
        $resultadoProductoAñadir->execute();
        $listaProductoAñadir = $resultadoProductoAñadir->fetchAll(PDO::FETCH_ASSOC);
        foreach ($listaProductoAñadir as $productoAñadirDato) {
            $_SESSION['carrito'][] = array("nombre" => $productoAñadirDato['nombre_prod'], "precio" => $productoAñadirDato['precio']);
            $_SESSION['total'] = $_SESSION['total'] + $productoAñadirDato['precio'];
        }
    }
}
?>
