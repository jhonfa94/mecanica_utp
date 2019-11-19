<?php 
include_once './database.php';
$conexionDB = conexionDB();

//RECIBO DATOS DEL FORMULARIO
$repuesto = isset($_REQUEST['repuesto']) ? $_REQUEST['repuesto'] : '';
$cantidad = isset($_REQUEST['cantidad']) ? $_REQUEST['cantidad'] : 0;

$idRepuesto = isset($_REQUEST['idRepuesto']) ? $_REQUEST['idRepuesto'] : 0;
$peticion = isset($_REQUEST['peticion']) ? $_REQUEST['peticion'] : '';

switch ($peticion) {
    case 'registrar':
        $sql = "INSERT INTO repuestos VALUES(NULL,
            '$repuesto',
            '$cantidad',
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
        $sql = "SELECT * FROM repuestos";
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
        $sql ="UPDATE repuestos SET repuesto='$repuesto', cantidad='$cantidad'
            WHERE idRepuesto = $idRepuesto
        ";
        $resultado=$conexionDB->query($sql);
        if ($resultado) {
            header("Location: ../views/repuestos.php");//SE ACTUALIZO CORRECTAMENTE
        } 

    break;

    case 'eliminar':
        $sql ="DELETE FROM  repuestos
            WHERE idRepuesto = $idRepuesto
        ";
        $resultado=$conexionDB->query($sql);
        if ($resultado) {
            header("Location: ../views/repuestos.php");//SE ACTUALIZO CORRECTAMENTE
        } 

    break;
    
    default:
        echo "No se recibe ninguna petición";
        break;
}









$conexionDB->close();
?>