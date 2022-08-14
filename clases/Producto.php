<?php

class Producto {

    //Esta parte se encarga de gestionar lo que tiene que ver con modificar producto.

    public static function Modificar_Nombre_Completo($nombreCompletoRegistro, $nombreCortoRegistro) {
        $mensaje = false;
        $conexion = new PDO('mysql:host=localhost;dbname=click_and_pic', 'root', '');
        $consultaComprobarUsuario = "SELECT login FROM producto WHERE nombre_corto = '$nombreCortoRegistro'";
        $comprobarUsuario = $conexion->query($consultaComprobarUsuario);
        if ($comprobarUsuario->rowCount() == 1) {
            $conexion->beginTransaction();
            $resultado = $conexion->query("UPDATE `producto` SET `nombre_prod`='$nombreCompletoRegistro' WHERE nombre_corto='$nombreCortoRegistro'");
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

    public static function Modificar_Codigo_Empresa($codigoEmpresa, $nombreCortoRegistro) {
        $mensaje = false;
        $conexion = new PDO('mysql:host=localhost;dbname=click_and_pic', 'root', '');
        $consultaComprobarUsuario = "SELECT login FROM producto WHERE nombre_corto = '$nombreCortoRegistro'";
        $comprobarUsuario = $conexion->query($consultaComprobarUsuario);
        if ($comprobarUsuario->rowCount() == 1) {
            $conexion->beginTransaction();
            $resultado = $conexion->query("UPDATE `producto` SET `codigo_empresa`='$codigoEmpresa' WHERE nombre_corto='$nombreCortoRegistro'");
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

    public static function Modificar_Codigo_Proveedor($codigoProveedor, $nombreCortoRegistro) {
        $mensaje = false;
        $conexion = new PDO('mysql:host=localhost;dbname=click_and_pic', 'root', '');
        $consultaComprobarUsuario = "SELECT login FROM producto WHERE nombre_corto = '$nombreCortoRegistro'";
        $comprobarUsuario = $conexion->query($consultaComprobarUsuario);
        if ($comprobarUsuario->rowCount() == 1) {
            $conexion->beginTransaction();
            $resultado = $conexion->query("UPDATE `producto` SET `codigo_proveedor`='$codigoProveedor' WHERE nombre_corto='$nombreCortoRegistro'");
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
    
        public static function Modificar_Precio($precio, $nombreCortoRegistro) {
        $mensaje = false;
        $conexion = new PDO('mysql:host=localhost;dbname=click_and_pic', 'root', '');
        $consultaComprobarUsuario = "SELECT login FROM producto WHERE nombre_corto = '$nombreCortoRegistro'";
        $comprobarUsuario = $conexion->query($consultaComprobarUsuario);
        if ($comprobarUsuario->rowCount() == 1) {
            $conexion->beginTransaction();
            $resultado = $conexion->query("UPDATE `producto` SET `precio`='$precio' WHERE nombre_corto='$nombreCortoRegistro'");
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
    
    
        public static function Modificar_Tipo_Producto($tipoProducto, $nombreCortoRegistro) {
        $mensaje = false;
        $conexion = new PDO('mysql:host=localhost;dbname=click_and_pic', 'root', '');
        $consultaComprobarUsuario = "SELECT login FROM producto WHERE nombre_corto = '$nombreCortoRegistro'";
        $comprobarUsuario = $conexion->query($consultaComprobarUsuario);
        if ($comprobarUsuario->rowCount() == 1) {
            $conexion->beginTransaction();
            $resultado = $conexion->query("UPDATE `producto` SET `tipo_producto`='$tipoProducto' WHERE nombre_corto='$nombreCortoRegistro'");
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

    public static function Producto_Nuevo($nombreCortoRegistro, $nombreCompletoRegistro, $codigoEmpresa, $codigoProveedor, $binariosImagen, $tipoArchivo, $precio, $tipoProducto) {
        $todo_bien = true;
        $mensaje = false;
        $conexion = new PDO('mysql:host=localhost;dbname=click_and_pic', 'root', '');
        $conexion->beginTransaction();
        $sql = "INSERT INTO `producto`(`nombre_corto`, `nombre_prod`, `codigo_empresa`, `codigo_proveedor`, `foto_producto`, `tipo`, `precio`, `tipo_producto`) VALUES ('$nombreCortoRegistro','$nombreCompletoRegistro','$codigoEmpresa','$codigoProveedor','$binariosImagen','$tipoArchivo','$precio','$tipoProducto')";
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
    }

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
}
