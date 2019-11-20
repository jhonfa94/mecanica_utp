<?php 
include_once './database.php';
$conexionDB = conexionDB();

//RECIBO DATOS DEL FORMULARIO
$equipo = isset($_REQUEST['equipo']) ? $_REQUEST['equipo'] : ''; //nombre del equipo
$idGrupo = isset($_REQUEST['idGrupo']) ? $_REQUEST['idGrupo'] : 0;
$frecuencia = isset($_REQUEST['frecuencia']) ? $_REQUEST['frecuencia'] : 0;
$idEquipo = isset($_REQUEST['idEquipo']) ? $_REQUEST['idEquipo'] : 0;

$peticion = isset($_REQUEST['peticion']) ? $_REQUEST['peticion'] : '';

switch ($peticion) {
    case 'registrar':
        $sql = "INSERT INTO equipos VALUES(NULL,
            '$equipo',
            $idGrupo,
            $frecuencia,
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
        $sql = "SELECT e.idEquipo, e.equipo, 
                e.idGrupo, g.grupo,
                e.frecuencia, e.fecha_creacion
                FROM equipos e
                INNER JOIN grupos g ON g.idGrupo = e.idGrupo
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
        $sql ="UPDATE equipos SET equipo='$equipo', idGrupo='$idGrupo', frecuencia= '$frecuencia'
            WHERE idEquipo = $idEquipo
        ";
        $resultado=$conexionDB->query($sql);
        if ($resultado) {
            header("Location: ../views/equipos.php");//SE ACTUALIZO CORRECTAMENTE
        } 

    break;

    case 'grupos':
        $sql ="SELECT * FROM grupos ";
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
        $sql ="DELETE FROM  equipos
            WHERE idEquipo = $idEquipo
        ";
        $resultado=$conexionDB->query($sql);
        if ($resultado) {
            header("Location: ../views/equipos.php");//SE ACTUALIZO CORRECTAMENTE
        } 

    break;
    
    default:
        echo "No se recibe ninguna petición";
        break;
}









$conexionDB->close();
?>