<?php

class DB {

    protected static function ejecutaConsulta($sql) {
        $opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
        $dsn = "mysql:host=localhost;dbname=click_and_pic";
        $usuario = 'root';
        $contrasena = '';

        $dwes = new PDO($dsn, $usuario, $contrasena);
        $resultado = null;
        if (isset($dwes))
            $resultado = $dwes->query($sql);
        return $resultado;
    }

    public static function InicioSesion($nombre, $contrasena) {
        $sql = "SELECT login, contraseña FROM usuario WHERE login='$nombre'";
        //$permisos = "SELECT permisos FROM usuarios WHERE login='$nombre'";
        if ($resultado = self::ejecutaConsulta($sql)) {
            $verificado = false;
            $fila = $resultado->fetch();
            if ($fila != null) {
                //Codificamos la contraseña para comprobarla con la que hay en la base de datos y si está bien, hacemos que comience la sesión.
                if (password_verify($contrasena, $fila["contraseña"])) {
                    $verificado = true;
                } else {
                    //Si la constraseña codificada no coincide con la que hay en la base de datos mostramos el siguiente mensaje de error:
                    $error = "Contraseña incorrecta.";
                }
            } else {
                // Si las credenciales no son válidas, se vuelven a pedir y se muestra el siguiente mensaje por pantalla:
                $error = "Usuario o contraseña no válidos!";
            }
            unset($resultado);
        }
        return $verificado;
    }

}

class Conexion {

    public static function Conectar() {
        define('servidor', 'localhost');
        define('nombre_bd', 'click_and_pic');
        define('usuario', 'root');
        define('password', '');
        $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
        try {
            $conexion = new PDO("mysql:host=" . servidor . "; dbname=" . nombre_bd, usuario, password, $opciones);
            return $conexion;
        } catch (Exception $e) {
            die("El error de Conexión es: " . $e->getMessage());
        }
    }

}
?>

