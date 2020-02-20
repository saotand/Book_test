<?php
 /* Archivo de Constantes y Funciones Nativas en ApiCore */
// Valores de constantes Definidas por el usuario

//Ajuste de configuracion inicial del servidor
ini_set("default_charset", 'utf-8');
ini_set('memory_limit', '256M');
date_default_timezone_set('America/Caracas');

$config = [
    // Contraseñas
    'MKEY'=>'Cpvz13A1otc',    // String SALT Contraseña para JWT
    'KEY_HASH'=>'$1$'.'E2vv_wea'.'$',         // Build completo de Salt Contraseñas Cript [Cambiar en Cont HASH]

    // Estos Valores no se puede cambiar
    //Constantes Basicas
    'APP'=>'Carparts',                   // Nombre de nucleo
    'WEBMASTER'=>'David Salinas',       // Programador
    'DEVELOPER'=>'www.turepuesto.com',  // Sitio de Desarrollador
    'VER'=>'0.1.1b',                // Version de plataforma
    'REV'=>'23.06.2019',                // Ultimas modificaciones
    'MODE'=>'debug',                    // debug or production
    'BASEURL'=>'http://'."{$_SERVER['HTTP_HOST']}/",                // Base URL completa
    'IP'=>"{$_SERVER['REMOTE_ADDR']}",  // IP de Cliente

    // Valores de fechas Usados en Estadisticas

    "AHORA"=>time(),                                // Tiempo Unix Fecha Hoy
    "DIAP"=>((1 * 24 * 60 * 60 )*30),                     // Tiempo Unix 1 dia

    "D"=>date("d"), "M"=>date("m"), "Y"=>date("Y"),                                                 //Dia Mes Año
    "HOY"=>date("Y-m-d"),                                                                           // Fecha Hoy
    "AYER"=>date('Y-m-d',strtotime("-1 day",strtotime(date("Y-m-d")))),                             // Fecha Ayer
    "MES"=>date('Y-m-d',strtotime("0 month",strtotime(date(date("Y").'-'.date("m").'-01')))),       // Fecha primer dia Mes
    "MES_EX"=>date('Y-m-d',strtotime("-1 month",strtotime(date("Y-m-d")))),                         // Fecha Mes Anterior
    "MES_EX2"=>date('Y-m-d',strtotime("-2 month",strtotime(date("Y-m-d")))),                        // Fecha 2 mes Anterior
    "ANO"=>date('Y-m-d',strtotime("0 year",strtotime(date(date("Y").'-01-01')))),                   // Fecha primer dia año
    "ANO_EX"=>date('Y-m-d',strtotime("-1 year",strtotime(date("Y-m-d")))),                          // fecha año anterior
    "ANO_EX2"=>date('Y-m-d',strtotime("-2 year",strtotime(date("Y-m-d")))),                         // fecha año anterior
    "NOW" => date('H:i:s')                                                                          // Hora Actual
];

// Declaración de contantes array Config
foreach($config as $key => $val){ 
    define($key,$val);
}

// Configuracion de base de Datos
// MySQL
$MySQL = [
    // required
    'database_type' => 'mysql',
    'database_name' => 'library',
    'server'        => 'localhost',
    'username'      => 'root',
    'password'      => 'mysql',

    // [optional]
    'charset'       => 'utf8',
    'port'          => 3306,

    // [optional] Table prefix
    'prefix'        => '',

    // [optional] Enable logging (Logging is disabled by default for better performance)
    'logging'       => true,

    // [optional] MySQL socket (shouldn't be used with server and port)
    //'socket' => '/tmp/mysql.sock',

    // [optional] driver_option for connection, read more from http://www.php.net/manual/en/pdo.setattribute.php
    'option'        => [PDO::ATTR_CASE => PDO::CASE_NATURAL],

    // [optional] Medoo will execute those commands after connected to the database for initialization
    'command'       => ['SET SQL_MODE=ANSI_QUOTES']
];

$conexion = $MySQL;

$JWT_DATA = [
    "token_base" => array(
        "iss"       => BASEURL,
        "aud"       => BASEURL,
        "auth_time" => AHORA,
        "iat"       => AHORA,
        "exp"       => AHORA + DIAP
    ),
    "algorithms" => array('HS256')
];

?>