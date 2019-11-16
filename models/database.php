<?php 

function conexionDB(){
    $server = "127.0.0.1"; //PC DE LEYSNER
    $user = "root";
    $password = "root";
    $db = "mecanica_utp";

    $conexionDB = new mysqli($server, $user, $password, $db);

    if($conexionDB->connect_errno){
        echo "Error de conexion a la Base de Datos ".$conexionDB->connect_error;
		exit();
    }else{
     //echo "ok Conexion SCP<br>";
     $conexionDB ->set_charset("utf8");
        return $conexionDB;
    } 
}

?>