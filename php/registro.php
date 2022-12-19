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
$loginRegistro = filter_input(INPUT_POST, "loginRegistro");
$nombreRegistro = filter_input(INPUT_POST, "nombreRegistro");
$apellidoRegistro = filter_input(INPUT_POST, "apellidoRegistro");
$contraseñaRegistro = filter_input(INPUT_POST, "contraseñaRegistro");
$correoRegistro = filter_input(INPUT_POST, "correoRegistro");
$contraseñaRegistroCod = password_hash($contraseñaRegistro, PASSWORD_DEFAULT);
$repiteContraseñaRegistro = filter_input(INPUT_POST, "repiteContraseñaRegistro");
$registro = filter_input(INPUT_POST, "Registro");
$mensaje = "";
$tipo = "";
//Desde aqui controlamos como insertamos un usuario nuevo a la base de datos.
if (isset($registro)) {
    if (ValidarDatos::Validar_Nuevo_Usuario($loginRegistro, $nombreRegistro, $apellidoRegistro, $contraseñaRegistro, $repiteContraseñaRegistro, $correoRegistro) == true) {
        if (Usuario::Usuario_Nuevo($loginRegistro, $contraseñaRegistroCod, $nombreRegistro, $apellidoRegistro, $correoRegistro) == true) {
            $mensaje = "Cuenta creada con exito.";
            $tipo = "mensajeExito";
        } else {
            $mensaje = "El usuario introducido ya existe.";
            $tipo = "mensajeError";
        }
    } else {
        $mensaje = "Datos del formulario mal introducidos.";
        $tipo = "mensajeError";
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
        <link rel="stylesheet" type="text/css" href="../css/registro.css" />
        <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
        <title>Registrate</title>
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

        <div id="tituloFormulario">
            <p id="tituloRegistro">FORMULARIO DE REGISTRO</p>
        </div>
        </br>
        <div id="formularioRegistro">
            <form class="row g-3" method="post">
                </br>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Login</label>
                    <input class="form-control" id="exampleFormControlInput1" type="text" name="loginRegistro" placeholder="Jose1231">
                </div>
                </br>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Nombre</label>
                    <input class="form-control" type="text" name="nombreRegistro" placeholder="Jose" aria-label="default input example">
                </div>
                </br>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Apellidos</label>
                    <input class="form-control" type="text" name="apellidoRegistro" placeholder="valentin" aria-label="default input example">
                </div>
                </br>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Correo electronico</label>
                    <input class="form-control" name="correoRegistro" placeholder="josevalentin@freemail.com" aria-label="default input example">
                </div>
                </br>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Contraseña</label>
                    <input class="form-control" type="text" name="contraseñaRegistro" placeholder="************" aria-label="default input example">
                </div>
                </br>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Repite la contraseña</label>
                    <input class="form-control" type="text" name="repiteContraseñaRegistro" placeholder="************" aria-label="default input example">
                </div>
                </br>
                <div class="col-auto">
                    <button type="submit" name="Registro" id="terminarRegistro" class="btn btn-danger mb-3">COMPLETAR REGISTRO</button>
            </form>
        </div>
    </div>       
    <div id='<?php echo $tipo; ?>'><span ><?php echo $mensaje; ?></span></div>
    <script src="../scripts/menuUsuario.js"></script>
</body>
</html>
