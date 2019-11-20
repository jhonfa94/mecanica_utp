<?php 
include_once './database.php';
$conexionDB = conexionDB();

//RECIBO DATOS DEL FORMULARIO
$idHerramienta = isset($_REQUEST['idHerramienta']) ? $_REQUEST['idHerramienta'] : 0;
$idRepuesto = isset($_REQUEST['idRepuesto']) ? $_REQUEST['idRepuesto'] : 0;
$mantenimiento = isset($_REQUEST['mantenimiento']) ? $_REQUEST['mantenimiento'] : '';
$idMantenimiento = isset($_REQUEST['idMantenimiento']) ? $_REQUEST['idMantenimiento'] : 0;
$peticion = isset($_REQUEST['peticion']) ? $_REQUEST['peticion'] : '';

switch ($peticion) {
    case 'registrar':
        $sql = "INSERT INTO actividad_mantenimiento VALUES(NULL,
            '$idHerramienta',
            '$idRepuesto',
            '$mantenimiento',
            CURDATE()
        )";

        $resultado = $conexionDB->query($sql);
        if ($resultado) {
            echo "1";//Se guardo correctamente
        } else {
            echo "0"; //No se guardo correctamente
        }
                
        
    break;

    case 'listar':
        $sql = "SELECT m.idMantenimiento, 
            m.idHerramienta,  h.herramienta,
            m.idRepuesto, r.repuesto,
            m.mantenimiento, m.fecha_creacion
            FROM actividad_mantenimiento m
            INNER JOIN herramientas h ON m.idHerramienta = h.idHerramienta
            INNER JOIN repuestos r ON m.idRepuesto = r.idRepuesto
        ";
        $resultado = $conexionDB->query($sql);
        if ($resultado) {
            while ($row =  $resultado->fetch_assoc()) {
                $arreglo [] = $row;              

            }

            header("Content-type: application/json; charset=utf-8");
            echo json_encode($arreglo);
            
        } else {
            echo "0"; //problemas al listar 
        }
        


    break;

    case 'actualizar':
        $sql ="UPDATE actividad_mantenimiento SET idHerramienta='$idHerramienta', idRepuesto='$idRepuesto', mantenimiento= '$mantenimiento'
            WHERE idMantenimiento = $idMantenimiento
        ";
        $resultado=$conexionDB->query($sql);
        if ($resultado) {
            header("Location: ../views/mantenimientos.php");//SE ACTUALIZO CORRECTAMENTE
        } 

    break;

    case 'herramientas':
        $sql ="SELECT * FROM herramientas ";
        $resultado=$conexionDB->query($sql);
        if ($resultado) {
            while ($row =  $resultado->fetch_assoc()) {
                $arreglo [] = $row;   
            }
            header("Content-type: application/json; charset=utf-8");
            echo json_encode($arreglo);
            
        } else {
            echo "0"; //problemas al listar 
        }
    break;

    case 'repuestos':
        $sql ="SELECT * FROM repuestos ";
        $resultado=$conexionDB->query($sql);
        if ($resultado) {
            while ($row =  $resultado->fetch_assoc()) {
                $arreglo [] = $row;   
            }
            header("Content-type: application/json; charset=utf-8");
            echo json_encode($arreglo);
            
        } else {
            echo "0"; //problemas al listar 
        }
    break;

    case 'eliminar':
        $sql ="DELETE FROM  actividad_mantenimiento
            WHERE idMantenimiento = $idMantenimiento
        ";
        $resultado=$conexionDB->query($sql);
        if ($resultado) {
            header("Location: ../views/mantenimientos.php");//SE ACTUALIZO CORRECTAMENTE
        } 

    break;
    
    default:
        echo "No se recibe ninguna petición";
        break;
}









$conexionDB->close();
?>