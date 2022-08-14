<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Proveedor
 *
 * @author digij
 */
class Proveedor {

    //Esta parte se encarga de gestionar lo que tiene que ver con modificar producto.

    public static function Modificar_Nombre($nombreProveedor, $codigoProveedor) {
        $mensaje = false;
        $conexion = new PDO('mysql:host=localhost;dbname=click_and_pic', 'root', '');
        $consultaComprobarUsuario = "SELECT codigo_proveedor FROM proveedor WHERE codigo_proveedor = '$codigoProveedor'";
        $comprobarUsuario = $conexion->query($consultaComprobarUsuario);
        if ($comprobarUsuario->rowCount() == 1) {
            $conexion->beginTransaction();
            $resultado = $conexion->query("UPDATE `proveedor` SET `nombre_proveedor`='$nombreProveedor' WHERE codigo_proveedor='$codigoProveedor'");
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

    public static function Modificar_Datos($datosProveedor, $codigoProveedor) {
        $mensaje = false;
        $conexion = new PDO('mysql:host=localhost;dbname=click_and_pic', 'root', '');
        $consultaComprobarUsuario = "SELECT codigo_proveedor FROM proveedor WHERE codigo_proveedor = '$codigoProveedor'";
        $comprobarUsuario = $conexion->query($consultaComprobarUsuario);
        if ($comprobarUsuario->rowCount() == 1) {
            $conexion->beginTransaction();
            $resultado = $conexion->query("UPDATE `proveedor` SET `datos_proveedor`='$datosProveedor' WHERE codigo_proveedor='$codigoProveedor'");
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

    public static function Proveedor_Nuevo($codigoProveedor,$nombreProveedor,$datosProveedor) {
        $todo_bien = true;
        $mensaje = false;
        $conexion = new PDO('mysql:host=localhost;dbname=click_and_pic', 'root', '');
        $consultaComprobarUsuario = "SELECT codigo_proveedor FROM proveedor WHERE codigo_proveedor = '$codigoProveedor'";
        $comprobarUsuario = $conexion->query($consultaComprobarUsuario);
        if ($comprobarUsuario->rowCount() == 0) {
            $conexion->beginTransaction();
            $sql = "INSERT INTO `proveedor`(`codigo_proveedor`, `nombre_proveedor`, `datos_proveedor`) VALUES ('$codigoProveedor','$nombreProveedor','$datosProveedor')";
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
}
