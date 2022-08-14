<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Publicacion
 *
 * @author digij
 */
class Publicacion {

    //Esta clase se encarga con lo que tiene que ver a la hora de crear un nuevo ususario

    public static function Publicacion_Nueva($titulo, $binariosImagen, $usuario, $tipoArchivo) {
        $todo_bien = true;
        $mensaje = false;
        $conexion = new PDO('mysql:host=localhost;dbname=click_and_pic', 'root', '');
        $conexion->beginTransaction();
        $sql = "INSERT INTO `publicacion`(`titulo`, `foto_publicacion`, `login`, `tipo`) VALUES ('$titulo','$binariosImagen','$usuario','$tipoArchivo')";
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

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------
}
