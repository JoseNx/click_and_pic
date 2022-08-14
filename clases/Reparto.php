<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Reparto
 *
 * @author digij
 */
class Reparto {
        //Esta parte se encarga de gestionar lo que tiene que ver con modificar producto.

    public static function Modificar_Nombre($nombreReparto, $codigoReparto) {
        $mensaje = false;
        $conexion = new PDO('mysql:host=localhost;dbname=click_and_pic', 'root', '');
        $consultaComprobarUsuario = "SELECT codigo_empresa FROM empresareparto WHERE codigo_empresa = '$codigoReparto'";
        $comprobarUsuario = $conexion->query($consultaComprobarUsuario);
        if ($comprobarUsuario->rowCount() == 1) {
            $conexion->beginTransaction();
            $resultado = $conexion->query("UPDATE `empresareparto` SET `codigo_empresa`='$nombreReparto' WHERE codigo_empresa='$codigoReparto'");
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

    public static function Modificar_Datos($datosReparto, $codigoReparto) {
        $mensaje = false;
        $conexion = new PDO('mysql:host=localhost;dbname=click_and_pic', 'root', '');
        $consultaComprobarUsuario = "SELECT codigo_empresa FROM empresareparto WHERE codigo_empresa = '$codigoReparto'";
        $comprobarUsuario = $conexion->query($consultaComprobarUsuario);
        if ($comprobarUsuario->rowCount() == 1) {
            $conexion->beginTransaction();
            $resultado = $conexion->query("UPDATE `empresareparto` SET `datos_empresa`='$datosReparto' WHERE codigo_empresa='$codigoReparto'");
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


    //--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    //Esta clase se encarga con lo que tiene que ver a la hora de crear un nuevo ususario

    public static function Reparto_Nuevo($codigoReparto,$nombreReparto,$datosReparto) {
        $todo_bien = true;
        $mensaje = false;
        $conexion = new PDO('mysql:host=localhost;dbname=click_and_pic', 'root', '');
        $consultaComprobarUsuario = "SELECT codigo_empresa FROM empresareparto WHERE codigo_empresa = '$codigoReparto'";
        $comprobarUsuario = $conexion->query($consultaComprobarUsuario);
        if ($comprobarUsuario->rowCount() == 0) {
            $conexion->beginTransaction();
            $sql = "INSERT INTO `empresareparto`(`codigo_empresa`, `nombre_empresa`, `datos_empresa`) VALUES ('$codigoReparto','$nombreReparto','$datosReparto')";
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

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------
}
