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
$botSesion = filter_input(INPUT_POST, "iniciar");
$usuario = filter_input(INPUT_POST, "loginSesion");
$contraseña = filter_input(INPUT_POST, "contraseñaSesion");
$mensaje = "";
$tipo = "";
$cuentaMaestra = "maestro";
$cuentaAdmin = "admin";
$cuentaNormal = "normal";
//Al ser apretado boton comprueba si el usuario y contraseña se han introducido correctamente se pasa a la gestion de la cuenta.
if (isset($botSesion)) {
    if (empty($usuario) || empty($contraseña)) {
        $mensaje = "Debes introducir un nombre de usuario y una contraseña";
        $tipo = "mensajeError";
    } else {
        // Comprobamos las credenciales con la base de datos
        if (DB::InicioSesion($usuario, $contraseña) == true) {
            $consultaNombre = "SELECT nombre FROM usuario WHERE login='$usuario'";
            $resultadoNombre = $conexion->prepare($consultaNombre);
            $resultadoNombre->execute();
            $resultadoNombre = $resultadoNombre->fetch(PDO::FETCH_ASSOC);
            $nombre = implode("", $resultadoNombre);
            $_SESSION['nombreUsur'] = $nombre;
            $rolConsulta = "SELECT rol FROM `usuario` WHERE login='$usuario'";
            $rolEjecutar = $conexion->prepare($rolConsulta);
            $rolEjecutar->execute();
            $rol = $rolEjecutar->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <?php foreach ($rol as $rolExtraido) {
                ?>
                <?php $rolExtraido['rol']; ?>

                <?php
            }
            $rolComparador = $rolExtraido['rol'];
            $_SESSION['rol'] = $rolComparador;
            $loginConsulta = "SELECT login FROM `usuario` WHERE login='$usuario'";
            $loginEjecutar = $conexion->prepare($loginConsulta);
            $loginEjecutar->execute();
            $login = $loginEjecutar->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <?php foreach ($login as $loginExtraido) {
                ?>
                <?php $loginExtraido['login']; ?>

                <?php
            }
            $loginComparador = $loginExtraido['login'];
            $_SESSION['login'] = $loginComparador;
            if ($cuentaMaestra == $_SESSION['rol']) {
                header("Location: ../php/panelMaestro.php");
            }if ($cuentaAdmin == $_SESSION['rol']) {
                header("Location: ../php/panelAdmin.php");
            }if ($cuentaNormal == $_SESSION['rol']) {
                header("Location: ../php/zonaProductos.php");
            }
        } else {
            // Si las credenciales no son válidas, se vuelven a pedir
            $mensaje = "Usuario y/o contraseña no válidos.";
            $tipo = "mensajeError";
        }
    }
}
?>
<html lang="Es-es">

    <head>
        <meta charset="utf-8">
        <!--link de boostrap-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <!--link al css del index que se encuentra en la carpeta css-->
        <link rel="stylesheet" type="text/css" href="../css/login.css" />
        <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
        <title>Inicio de sesión</title>
    </head>

    <body>
        <!--La barra de navegacion principal, la cual esta hecha usando boostrap-->
        <nav>
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
            <h1>Menú</h1>
            <ul>
                <li><a href="../php/login.php">Iniciar sesión</a></li>
                <li><a href="../html/sobreNosotros.html">Sobre nosotros</a></li>
                <li><a href="../html/politicasPrivacidad.html">Politicas y privacidad</a></li>
                <li><a href="../html/contacto.html">Contacto</a></li>
            </ul>
        </div>

        <div id="tituloSesion">
            <p id="tituloSesion">INICIO DE SESIÓN</p>
        </div>
        </br>
        <div id="formularioSesion">
            <form class="row g-3" method="post">
                </br>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Login</label>
                    <input class="form-control" id="exampleFormControlInput1" type="text" name="loginSesion" placeholder="Jose1231">
                </div>
                </br>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Contraseña</label>
                    <input class="form-control" type="password" name="contraseñaSesion" placeholder="************" aria-label="default input example">
                </div>
                </br>
                <div class="col-auto">
                    <button type="submit" name="iniciar" id="iniciarSesion" class="btn btn-danger mb-3">INICIAR SESIÓN</button>
                </div>      
            </form>
        </div>
        <div id='<?php echo $tipo; ?>'><span ><?php echo $mensaje; ?></span></div>
        <script src="../scripts/menuUsuario.js"></script>
    </body>
</html>
