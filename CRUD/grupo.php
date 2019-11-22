<?php 
include_once './database.php';
$conexionDB = conexionDB();

//RECIBO DATOS DEL FORMULARIO
$grupo = isset($_REQUEST['grupo']) ? $_REQUEST['grupo'] : ''; //nombre del grupo
$idCaracteristica = isset($_REQUEST['idCaracteristica']) ? $_REQUEST['idCaracteristica'] : 0;
$idMantenimiento = isset($_REQUEST['idMantenimiento']) ? $_REQUEST['idMantenimiento'] : 0;
$idGrupo = isset($_REQUEST['idGrupo']) ? $_REQUEST['idGrupo'] : 0;

$peticion = isset($_REQUEST['peticion']) ? $_REQUEST['peticion'] : '';

switch ($peticion) {
    case 'registrar':
        $caracteristicas = '';
        foreach ($_REQUEST['idCaracteristica'] as $c) {
            $caracteristicas .= $c .",";
        }
        $caracteristicas = substr($caracteristicas,0,-1);
        
        $mantenimientos = '';
        foreach ($_REQUEST['idMantenimiento'] as $m) {
            $mantenimientos .= $m .",";
        }
        $mantenimientos = substr($mantenimientos,0,-1);

        
        $sql = "INSERT INTO grupos VALUES(NULL,
            '$grupo',
            '$caracteristicas',
            '$mantenimientos',
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
        /* $sql = "SELECT g.idGrupo, g.grupo,
            g.idCaracteristica, c.caracteristica,
            g.idMantenimiento, m.mantenimiento,
            g.fecha_creacion
            FROM grupos g
            INNER JOIN caracteristicas c ON g.idCaracteristica = c.idCaracteristica
            INNER JOIN actividad_mantenimiento m ON g.idMantenimiento = m.idMantenimiento
        "; */
        $sql = "SELECT *
            FROM grupos g            
            
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
        $sql ="UPDATE grupos SET grupo='$grupo', idCaracteristica='$idCaracteristica', idMantenimiento= '$idMantenimiento'
            WHERE idGrupo = $idGrupo
        ";
        $resultado=$conexionDB->query($sql);
        if ($resultado) {
            header("Location: ../views/grupos.php");//SE ACTUALIZO CORRECTAMENTE
        } 

    break;

    case 'caracteristicas':
        $sql ="SELECT * FROM caracteristicas ";
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

    case 'mantenimientos':
        $sql ="SELECT * FROM actividad_mantenimiento ";
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
        $sql ="DELETE FROM  grupos
            WHERE idGrupo = $idGrupo
        ";
        $resultado=$conexionDB->query($sql);
        if ($resultado) {
            header("Location: ../views/grupos.php");//SE ACTUALIZO CORRECTAMENTE
        } 

    break;
    
    default:
        echo "No se recibe ninguna petición";
        break;
}









$conexionDB->close();
?>