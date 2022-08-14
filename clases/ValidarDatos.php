<?php

//En este archivo crearemos nuestas clases para que nuestro programa funcione correctamente.
//Creamos nuestra clase validar datos, la cual se encargara de todas las comprobaciones de nuestro programa
class ValidarDatos {

//Creamos la funcion Validar_Datos para ir validando nuestros datos de entrada. 
    public static function Validar_Datos($fecha, $concepto, $cantidad) {
        //Con la variable $patron_numero nos encargamos de que todos los numeros sean positivos y asi no surja 
        //el error de introducir un numero negativo que rompa las formulas de la funcion Calcular_Saldo_Contable.
        $patron_numero = '/^[^0|\D]\d{0,9}(\.\d{1,2})?/';
        //Esta variable se encarga de verificar si es correcto o no correcto los valores de entrada introducidos.
        $valido = false;
        //Primero validamos nuestros datos de entrada, en caso de que alguno este vacio nos devuelve un return false.
        if (!empty($fecha) && !empty($concepto) && !empty($cantidad)) {
            //Ahora comprobaremos si nuestra cantidad es valida, asique haremos lo mismo que lo anterior.
            //Comprobaremos si nuestro numero esta bien formado, si lo esta hara un return que valide nuestra entrada de datos.
            //Si no sale bien manda un return false.
            if (preg_match($patron_numero, $cantidad)) {
                $valido = true;
                return $valido;
            } else {

                $valido = false;
                return $valido;
            }
        } else {
            $valido = false;
            return $valido;
        }
    }

//Se encarga de validar un nuevo usuario.
    public static function Validar_Nuevo_Usuario($loginRegistro, $nombreRegistro, $apellidoRegistro, $contraseñaRegistro, $repiteContraseñaRegistro, $correoRegistro) {
        //Con la variable $patron_numero nos encargamos de que todos los numeros sean positivos y asi no surja 
        //el error de introducir un numero negativo que rompa las formulas de la funcion Calcular_Saldo_Contable.
        $patron_correo = '/^([a-z0-9]+(?:[._-][a-z0-9]+)*)@([a-z0-9]+(?:[.-][a-z0-9]+)*\.[a-z]{2,})$/';
        //Esta variable se encarga de verificar si es correcto o no correcto los valores de entrada introducidos.
        $valido = false;
        //Primero validamos nuestros datos de entrada, en caso de que alguno este vacio nos devuelve un return false.
        if (!empty($loginRegistro) && !empty($nombreRegistro) && !empty($apellidoRegistro) && !empty($contraseñaRegistro) && !empty($repiteContraseñaRegistro) && !empty($correoRegistro)) {
            //Validamos que nuestras contraseñas sean correctas al momento de crear un usuario nuevo.
            if ($contraseñaRegistro == $repiteContraseñaRegistro) {
                if (preg_match($patron_correo, $correoRegistro)) {
                    $valido = true;
                    return $valido;
                } else {

                    $valido = false;
                    return $valido;
                }
            } else {
                $valido = false;
                return $valido;
            }
        } else {
            $valido = false;
            return $valido;
        }
    }

    //Se encarga de validar un nuevo producto.
    public static function Validar_Nuevo_Producto($nombreCortoRegistro, $nombreCompletoRegistro, $codigoEmpresa, $codigoProveedor, $fotoProducto, $precio, $tipoProducto) {
        //Esta variable se encarga de verificar si es correcto o no correcto los valores de entrada introducidos.
        $valido = false;
        //Primero validamos nuestros datos de entrada, en caso de que alguno este vacio nos devuelve un return false.
        if (!empty($nombreCortoRegistro) && !empty($nombreCompletoRegistro) && !empty($codigoEmpresa) && !empty($codigoProveedor) && !empty($fotoProducto) && !empty($precio) && !empty($tipoProducto)) {
            //Validamos que nuestras contraseñas sean correctas al momento de crear un usuario nuevo.
            $valido = true;
            return $valido;
        } else {
            $valido = false;
            return $valido;
        }
    }

    //Se encarga de validar una nueva publicacion.
    public static function Validar_Nueva_Publicacion($titulo, $publicacion) {
        //Esta variable se encarga de verificar si es correcto o no correcto los valores de entrada introducidos.
        $valido = false;
        //Primero validamos nuestros datos de entrada, en caso de que alguno este vacio nos devuelve un return false.
        if (!empty($titulo) && !empty($publicacion)) {
            //Validamos que nuestras contraseñas sean correctas al momento de crear un usuario nuevo.
            $valido = true;
            return $valido;
        } else {
            $valido = false;
            return $valido;
        }
    }

    //Se encarga de validar un nuevo proveedor.
    public static function Validar_Nuevo_Proveedor($codigoProveedor, $nombreProveedor, $datosProveedor) {
        //Esta variable se encarga de verificar si es correcto o no correcto los valores de entrada introducidos.
        $valido = false;
        //Primero validamos nuestros datos de entrada, en caso de que alguno este vacio nos devuelve un return false.
        if (!empty($codigoProveedor) && !empty($nombreProveedor) && !empty($datosProveedor)) {
            //Validamos que nuestras contraseñas sean correctas al momento de crear un usuario nuevo.
            $valido = true;
            return $valido;
        } else {
            $valido = false;
            return $valido;
        }
    }

    //Se encarga de validar un nuevo repartidor.
    public static function Validar_Nuevo_Reparto($codigoReparto, $nombreReparto, $datosReparto) {
        //Esta variable se encarga de verificar si es correcto o no correcto los valores de entrada introducidos.
        $valido = false;
        //Primero validamos nuestros datos de entrada, en caso de que alguno este vacio nos devuelve un return false.
        if (!empty($codigoReparto) && !empty($nombreReparto) && !empty($datosReparto)) {
            //Validamos que nuestras contraseñas sean correctas al momento de crear un usuario nuevo.
            $valido = true;
            return $valido;
        } else {
            $valido = false;
            return $valido;
        }
    }

//Se encarga de validar un usuario.
    public static function Validar_Usuario($login, $nombre, $fecha, $contraseña) {
        //Esta variable se encarga de verificar si es correcto o no correcto los valores de entrada introducidos.
        $valido = false;
        //Primero validamos nuestros datos de entrada, en caso de que alguno este vacio nos devuelve un return false.
        if (!empty($login) && !empty($nombre) && !empty($fecha) && !empty($contraseña)) {
            $valido = true;
            return $valido;
        } else {
            $valido = false;
            return $valido;
        }
    }

//Se encarga de validar los datos del cambio.
    public static function Validar_Cambio($login, $dato) {
        //Esta variable se encarga de verificar si es correcto o no correcto los valores de entrada introducidos.
        $valido = false;
        //Primero validamos nuestros datos de entrada, en caso de que alguno este vacio nos devuelve un return false.
        if (!empty($login) && !empty($dato)) {
            $valido = true;
            return $valido;
        } else {
            $valido = false;
            return $valido;
        }
    }

}
