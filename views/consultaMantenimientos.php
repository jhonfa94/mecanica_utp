<?php

include '../CRUD/database.php';
$conexionDB = conexionDB();

$hoy = date('Y-m-d');

$fecha1 = isset($_REQUEST['fecha1']) ? $_REQUEST['fecha1'] : $hoy;
$fecha2 = isset($_REQUEST['fecha2']) ? $_REQUEST['fecha2'] : $hoy;


$equipos  = "SELECT  DISTINCT equipo, frecuencia,fecha_creacion FROM equipos";
$resuladoEquipos = $conexionDB->query($equipos);



$sql = "SELECT e.equipo, e.fecha_creacion, e.frecuencia, 
        DATE_ADD(e.fecha_creacion,INTERVAL 1 WEEK) AS fechaMantenimiento 
        FROM equipos e
        WHERE DATE_ADD(e.fecha_creacion,INTERVAL 1 WEEK) 
          BETWEEN '$fecha1' AND '$fecha2'
";
$resultado = $conexionDB->query($sql);


if ($resultado->num_rows > 0) {
    $tr = "";
    while ($row = $resultado->fetch_assoc()) {
        $equipo = $row['equipo'];
        $fecha_creacion = $row['fecha_creacion'];
        $frecuencia = $row['frecuencia'];
        $fechaMantenimiento = $row['fechaMantenimiento'];

        //$arreglo [] = $row;     
        $tr .= "
            <tr>
                <td>$equipo </td>
                <td>$fecha_creacion </td>
                <td>$frecuencia </td>
                <td>$fechaMantenimiento </td>
            </tr>
        ";
    }
    echo "$tr";
    /* header("Content-type: application/json; charset=utf-8");
    echo json_encode($arreglo); */
} else {
    echo "
        <tr>
            <td colspan='4'>No se tiene mantenimientos programados para el rango de fechas seleccionadas </td>            
        </tr>
    ";
}


$conexionDB->close();
