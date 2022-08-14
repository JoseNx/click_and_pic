<?php

class Admin {

    //Esta parte se encarga de gestionar lo que tiene que ver con modificar usuario.

    public static function Modificar_Contraseña($contraseñaModCod, $loginUsur) {
        $mensaje = false;
        $conexion = new PDO('mysql:host=localhost;dbname=click_and_pic', 'root', '');
        $consultaComprobarUsuario = "SELECT login FROM usuario WHERE login = '$loginUsur'";
        $comprobarUsuario = $conexion->query($consultaComprobarUsuario);
        if ($comprobarUsuario->rowCount() == 1) {
            $conexion->beginTransaction();
            $resultado = $conexion->query("UPDATE `usuario` SET `contraseña`='$contraseñaModCod' WHERE login='$loginUsur'");
            if ($resultado == 0) {
                $conexion->rollback();
                return $mensaje = false;
            } else {
                $conexion->commit();
                return $mensaje = true;
            }
        } else {
            // Si las credenciales no son válidas, se vuelven a pedir
            return $mensaje = false;
        }
    }

    public static function Modificar_Nombre($nombreMod, $loginUsur) {
        $mensaje = false;
        $conexion = new PDO('mysql:host=localhost;dbname=click_and_pic', 'root', '');
        $consultaComprobarUsuario = "SELECT login FROM usuario WHERE login = '$loginUsur'";
        $comprobarUsuario = $conexion->query($consultaComprobarUsuario);
        if ($comprobarUsuario->rowCount() == 1) {
            $conexion->beginTransaction();
            $resultado = $conexion->query("UPDATE `usuario` SET `nombre`='$nombreMod' WHERE login='$loginUsur'");
            if ($conexion == 0) {
                $conexion->rollback();
                return $mensaje = false;
            } else {
                $conexion->commit();
                return $mensaje = true;
            }
        } else {
            // Si las credenciales no son válidas, se vuelven a pedir
            return $mensaje = false;
        }
    }

    public static function Modificar_Apellido($apellidoMod, $loginUsur) {
        $mensaje = false;
        $conexion = new PDO('mysql:host=localhost;dbname=click_and_pic', 'root', '');
        $consultaComprobarUsuario = "SELECT login FROM usuario WHERE login = '$loginUsur'";
        $comprobarUsuario = $conexion->query($consultaComprobarUsuario);
        if ($comprobarUsuario->rowCount() == 1) {
            $conexion->beginTransaction();
            $resultado = $conexion->query("UPDATE `usuario` SET `apellido`='$apellidoMod' WHERE login='$loginUsur'");
            if ($conexion == 0) {
                $conexion->rollback();
                return $mensaje = false;
            } else {
                $conexion->commit();
                return $mensaje = true;
            }
        } else {
            // Si las credenciales no son válidas, se vuelven a pedir
            return $mensaje = false;
        }
    }

    public static function Modificar_Correo($correoMod, $loginUsur) {
        $mensaje = false;
        $conexion = new PDO('mysql:host=localhost;dbname=click_and_pic', 'root', '');
        $consultaComprobarUsuario = "SELECT login FROM usuario WHERE login = '$loginUsur'";
        $comprobarUsuario = $conexion->query($consultaComprobarUsuario);
        if ($comprobarUsuario->rowCount() == 1) {
            $conexion->beginTransaction();
            $resultado = $conexion->query("UPDATE `usuario` SET `correo`='$correoMod' WHERE login='$loginUsur'");
            if ($conexion == 0) {
                $conexion->rollback();
                return $mensaje = false;
            } else {
                $conexion->commit();
                return $mensaje = true;
            }
        } else {
            // Si las credenciales no son válidas, se vuelven a pedir
            return $mensaje = false;
        }
    }

    //--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    //Esta clase se encarga con lo que tiene que ver a la hora de crear un nuevo ususario

    public static function Usuario_Nuevo($loginRegistro, $contraseñaRegistroCod, $nombreRegistro, $apellidoRegistro, $correoRegistro) {
        $todo_bien = true;
        $mensaje = false;
        $conexion = new PDO('mysql:host=localhost;dbname=click_and_pic', 'root', '');
        $consultaComprobarUsuario = "SELECT login FROM usuario WHERE login = '$loginRegistro'";
        $comprobarUsuario = $conexion->query($consultaComprobarUsuario);
        if ($comprobarUsuario->rowCount() == 0) {
            $conexion->beginTransaction();
            $sql = "INSERT INTO `usuario`(`login`, `nombre`, `apellido`, `correo`, `contraseña`, `rol`, `foto_perfil`) VALUES ('$loginRegistro','$nombreRegistro', '$apellidoRegistro', '$correoRegistro', '$contraseñaRegistroCod', 'admin', '')";
            if ($conexion->query($sql) == 0) {
                $todo_bien = false;
            }
            if ($todo_bien == true) {
                $conexion->commit();
                return $mensaje = true;
            } if ($todo_bien == false) {
                $conexion->rollback();
                return $mensaje = false;
            }
        } else {
            return $mensaje = false;
        }
    }

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//Esta clase se encarga del borrado de un usuario.

    public static function Usuario_Borrar($loginBorrar) {
        $todo_bien = true;
        $conexion = new PDO('mysql:host=localhost;dbname=click_and_pic', 'root', '');
        $limpiar = "DELETE FROM `movimientos` WHERE loginUsu='$loginBorrar'";
        $conexion->query($limpiar);
        $conexion->beginTransaction();
        $sql = "DELETE FROM `usuarios` WHERE login='$loginBorrar'";
        if ($conexion->query($sql) == 0) {
            $todo_bien = false;
        }
        if ($todo_bien == true) {
            $conexion->commit();
            print "<p>Usuario eliminado.</p>";
        } if ($todo_bien == false) {
            $conexion->rollback();
            print "<p>No se ha podido eliminar.</p>";
        }
    }

}
