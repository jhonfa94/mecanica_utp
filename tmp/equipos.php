<?php 

    include './CRUD/database.php';
    $conexionDB = conexionDB();

    $sql = "SELECT * FROM grupos where idGrupo = 15";
    $resultado = $conexionDB->query($sql);
    echo "<pre>";
    var_dump($resultado);
    echo "</pre><hr>";

    $row = $resultado->fetch_assoc();
    $caracteristicas =  $row['idCaracteristica'];
    echo "$caracteristicas <br><hr>";
    $caracteristicas =  explode(',',$caracteristicas);
    foreach ($caracteristicas as $c) {
        echo "$c <br>";
    }
    echo "<hr>";
    echo "<h3>Foreach 2</h3>";
    foreach ($caracteristicas as $key => $c) {
        echo "$key => $c <br>";
    }

?>