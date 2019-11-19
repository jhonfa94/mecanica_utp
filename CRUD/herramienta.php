<?php 
include_once './database.php';
$conexionDB = conexionDB();

//RECIBO DATOS DEL FORMULARIO
$herramienta = isset($_REQUEST['herramienta']) ? $_REQUEST['herramienta'] : '';
$idHerramienta = isset($_REQUEST['idHerramienta']) ? $_REQUEST['idHerramienta'] : 0;
$peticion = isset($_REQUEST['peticion']) ? $_REQUEST['peticion'] : '';

switch ($peticion) {
    case 'registrar':
        $sql = "INSERT INTO herramientas VALUES(NULL,
            '$herramienta',
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
        $sql = "SELECT * FROM herramientas";
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
        $sql ="UPDATE herramientas SET herramienta='$herramienta', fecha_creacion=CURDATE()
            WHERE idHerramienta = $idHerramienta
        ";
        $resultado=$conexionDB->query($sql);
        if ($resultado) {
            header("Location: ../views/herramientas.php");//SE ACTUALIZO CORRECTAMENTE
        } 

    break;

    case 'eliminar':
        $sql ="DELETE FROM  herramientas
            WHERE idHerramienta = $idHerramienta
        ";
        $resultado=$conexionDB->query($sql);
        if ($resultado) {
            header("Location: ../views/herramientas.php");//SE ACTUALIZO CORRECTAMENTE
        } 

    break;
    
    default:
        echo "No se recibe ninguna petición";
        break;
}









$conexionDB->close();
?>