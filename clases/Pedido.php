<?php

class Pedido {

    public static function Pedido_Nuevo($login, $total) {
        $todo_bien = true;
        $mensaje = false;
        $conexion = new PDO('mysql:host=localhost;dbname=click_and_pic', 'root', '');
        $conexion->beginTransaction();
        $sql = "INSERT INTO `pedido`(`login`, `total_precio`) VALUES ('$login','$total')";
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

}
