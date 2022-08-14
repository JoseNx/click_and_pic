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
$camara = "camara";
$accesorio = "accesorio";
$añadirCarrito = (filter_input(INPUT_POST, "añadirCarrito"));
$botonAñadir = (filter_input(INPUT_POST, "botonAñadir"));


if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array();
}

if (!isset($_SESSION['total'])) {
    $_SESSION['total'] = 0;
}



//Con esto sacamos la lista de los productos que sean clasificados como camaras.
$consultaProductoCamara = "SELECT * FROM `producto` WHERE tipo_producto= '$camara' ORDER BY nombre_corto DESC limit 4";
$resultadoProductoCamara = $conexion->prepare($consultaProductoCamara);
$resultadoProductoCamara->execute();
$listaProductoCamara = $resultadoProductoCamara->fetchAll(PDO::FETCH_ASSOC);

//Con esto sacamos la lista de los productos que sean clasificados como accesorios.
$consultaProductoAccesorio = "SELECT * FROM `producto` WHERE tipo_producto='$accesorio' ORDER BY nombre_corto DESC limit 4";
$resultadoProductoAccesorio = $conexion->prepare($consultaProductoAccesorio);
$resultadoProductoAccesorio->execute();
$listaProductoAccesorio = $resultadoProductoAccesorio->fetchAll(PDO::FETCH_ASSOC);
$cerrarSesion = filter_input(INPUT_POST, "cerrarSesion");


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
        <link rel = "stylesheet" type = "text/css" href = "../css/zonaProductos.css" />
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
                    <li><a href="../php/opcionesSoloUsuario.php">Opciones de usuario </a></li>
                    <li><form method="post"><input id="cerraSesion" type="submit" name="cerrarSesion" value="Cerrar Sesión"></form></li>
                <?php } ?>
            </ul>
        </div>
        <p id="tituloProductos">Nuestros Productos</p>

        <div id="botonLista">
            <a id="botonListaInterior" href="../php/listaDeProductos.php">BUSCAR POR LISTA</a>
        </div> 

        <div id="botonFiltroPublicacion">
            <a id="botonFiltroPublicacionInterior" href="../php/filtradoProductos.php">BUSCAR POR FILTRO</a>
        </div> 

        <div id="contenedorProductosCamara">

            <p id="tituloCamaras">Nuestras mejores camaras</p>
            <table  id="tablaListaControl">
                <thead>
                </thead>
                <tbody>
                    <?php foreach ($listaProductoCamara as $productoCamaraDato) {
                        ?>

                        <tr>
                            <td id="publicacionDecoracion">  
                                <p id="nombreProducto"><?php echo $productoCamaraDato['nombre_prod'] ?></p>
                                <img id="fotoProducto" width="100px" src="data:<?php echo $productoCamaraDato['tipo']; ?>;base64,<?php echo base64_encode($productoCamaraDato['foto_producto']); ?>">                           
                                <p id="precioProducto"><?php echo $productoCamaraDato['precio'] . ' €' ?></p>
                                <form method="post">
                                    <input name="añadirCarrito[]" type="hidden"  value="<?php echo $productoCamaraDato['nombre_corto'] ?>">
                                    <input id="botonProducto" name="botonAñadir" type="submit" value="Añadir al carrito">
                                </form>
                            </td>
                        </tr>
                    </tbody>

                <?php }
                ?>
            </table> 
            <?php
            ?>
        </div>

        <div id="contenedorAccesorios">
            <p id="tituloAccesorios">Nuestros mejores Accesorios</p>

            <table  id="tablaAccesoriosControl">
                <thead>
                </thead>
                <tbody>
                    <?php foreach ($listaProductoAccesorio as $productoAccesorioDato) {
                        ?>

                        <tr>
                            <td id="publicacionDecoracion">
                                <p id="nombreAccesorios"><?php echo $productoAccesorioDato['nombre_prod'] ?></p>
                                <img id="fotoProducto" width="100px" src="data:<?php echo $productoAccesorioDato['tipo']; ?>;base64,<?php echo base64_encode($productoAccesorioDato['foto_producto']); ?>">
                                <p id="precioAccesorios"><?php echo $productoAccesorioDato['precio'] . ' €' ?></p>
                                <form>
                                    <input name="añadirCarrito[]" type="hidden"  value="<?php echo $productoAccesorioDato['nombre_corto'] ?>">
                                    <input id="botonProducto" name="botonAñadir" type="submit" value="Añadir al carrito">
                                </form>
                            </td>
                        </tr>
                    </tbody>

                <?php }
                ?>
            </table>

        </div>

    </body>
    <script src="../scripts/menuUsuario.js"></script>
</html>
<?php
//Añado un nuevo articulo al carrito
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