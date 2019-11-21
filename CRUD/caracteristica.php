<?php 
include_once './database.php';
$conexionDB = conexionDB();

//RECIBO DATOS DEL FORMULARIO
$caracteristica = isset($_REQUEST['caracteristica']) ? $_REQUEST['caracteristica'] : '';
$idCaracteristica = isset($_REQUEST['idCaracteristica']) ? $_REQUEST['idCaracteristica'] : 0;
$peticion = isset($_REQUEST['peticion']) ? $_REQUEST['peticion'] : '';

switch ($peticion) {
    case 'registrar':
        $sql = "INSERT INTO caracteristicas VALUES(NULL,
            '$caracteristica',
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
        $sql = "SELECT * FROM caracteristicas";
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
        $sql ="UPDATE caracteristicas SET caracteristica='$caracteristica'
            WHERE idCaracteristica = $idCaracteristica
        ";
        $resultado=$conexionDB->query($sql);
        if ($resultado) {
            header("Location: ../views/caracteristicas.php");//SE ACTUALIZO CORRECTAMENTE
        } 

    break;

    case 'eliminar':
        $sql ="DELETE FROM  caracteristicas
            WHERE idCaracteristica = $idCaracteristica
        ";
        $resultado=$conexionDB->query($sql);
        if ($resultado) {
            header("Location: ../views/caracteristicas.php");//SE ACTUALIZO CORRECTAMENTE
        } 

    break;
    
    default:
        echo "No se recibe ninguna petición";
        break;
}









$conexionDB->close();
?>