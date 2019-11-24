<?php
include '../CRUD/database.php';
$conexionDB = conexionDB();
/* CONSULTA SQL PARA EL DETALLE */

if (!isset($_REQUEST['equipo'])) {
  header("Location: equipos.php");
} else {
  $equipo = $_REQUEST['equipo'];

  //CONSULTA PARA EXTRAER LOS DETALLES
  $detalles = "SELECT e.idEquipo, e.equipo, 
    e.idGrupo, g.grupo,
    g.idMantenimiento,
    e.frecuencia, e.caracteristica, e.valor, e.fecha_creacion
    FROM  equipos e
    INNER JOIN grupos g ON g.idGrupo = e.idGrupo
    WHERE e.equipo = '$equipo'
  ";
  $resultadoDetalles = $conexionDB->query($detalles);
  $resultadoCaracteristicas = $conexionDB->query($detalles);

  $rowDetalle = $resultadoDetalles->fetch_assoc();
  $grupo = $rowDetalle['grupo'];
  $mantenimientos = $rowDetalle['idMantenimiento'];
  $frecuencia = $rowDetalle['frecuencia'];

  //Convierto los mantenimentos en un array para hacer consultas en un ciclo
  $arrayMantenimento = explode(",", $mantenimientos);


  //ALMACENO EN UN ARRAY LOS RESULTADOS OBTENIDOS PARA LOS DETALLES
  $arrayDetalles = array();
  $tr = "";
  foreach ($arrayMantenimento as $m) {
    $sqlDetalle = "SELECT m.mantenimiento, m.idHerramienta, m.idRepuesto  FROM actividad_mantenimiento m
      WHERE m.mantenimiento = '$m'
    ";
    $resultDetalle = $conexionDB->query($sqlDetalle);
    $dt = $resultDetalle->fetch_assoc();
    $herramienta = $dt['idHerramienta'];
    $repuesto = $dt['idRepuesto'];

    $tr .= "
      <tr>
        <td>$m</td>
        <td>$herramienta</td>
        <td>$repuesto</td>
      </td>
    ";

    $array_dt = array(
      'Mantenimiento' => $m,
      'Herramientas' => $dt['idHerramienta'],
      'Repuestos' => $dt['idRepuesto'],
    );

    array_push($arrayDetalles, $array_dt);
  }
  /*  echo "<pre>";
  var_dump($arrayDetalles);
  echo "</pre>"; */



  /* PROGRAMACION DE MANTENIMIENTOS  */
  $mesesAnio = 12;
  $mesesProgramados = array();
  for ($i = 1; $i < $mesesAnio; $i++) {

    $f = $frecuencia * $i;    
    
    $programacionM = "SELECT e.fecha_creacion, 
      DATE_ADD(e.fecha_creacion,INTERVAL $f WEEK) AS fechaMantenimiento 
      FROM equipos e
      WHERE e.equipo = '$equipo'  
    ";

    $resultadoProgramacionM = $conexionDB->query($programacionM);
    $rowP = $resultadoProgramacionM->fetch_assoc();
    $fechaMantenimiento = $rowP['fechaMantenimiento'];
    array_push($mesesProgramados, $fechaMantenimiento);

    

  }
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
  <?php include './includes/head.php'; ?>
  <title>Equipo Detalle</title>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- Navbar -->
    <?php include './includes/navbar.php'; ?>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <?php include './includes/sidebar.php'; ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header d-none">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">

              </h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Detalle Equipo</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <!-- ENCABEZADO -->
          <div class="row  align-items-center border border-dark">
            <!-- AGREGAR COLUMNAS -->

            <!-- LOGO -->
            <div class="col-md-4">
              <img src="./dist/img/utp/logoutp.jpg" alt="UTP" class="img-fluid" width="150">
            </div>
            <div class="col-md-4 text-center">
              <h5> FICHA TÉCNICA
                <br>
                <?= $equipo ?>
              </h5>
            </div>
            <div class="col-md-4 text-center">
              <h5>
                FECHA REPORTE <br>
                <?= date('Y-m-d') ?>
              </h5>
            </div>


          </div> <!-- /.row -->

          <!-- INFORMACION GENERAL -->
          <div class="row mt-3 ">

            <div class="col-md-3 ">
              <div class="card">
                <div class="card-body">
                  <h5 class="text-center font-weight-bold">Características</h5>
                  <table class="table table-sm table-hover table-bordered">
                    <thead class="thead-light">
                      <tr>
                        <th>Nombre</th>
                        <th>Valor</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      if ($resultadoCaracteristicas->num_rows > 0) {
                        while ($row = $resultadoCaracteristicas->fetch_assoc()) {
                          $caracteristica = $row['caracteristica'];
                          $valor = $row['valor'];
                          ?>
                          <tr>
                            <td><?= $caracteristica ?></td>
                            <td><?= $valor ?></td>
                          </tr>
                      <?php
                        } //END WHILE
                      } //END IF


                      ?>

                    </tbody>
                  </table>

                </div>
              </div>
            </div><!-- col-md-4 -->

            <!-- MANTENIMIENTOS -->
            <div class="col-md-3 ">
              <div class="card">
                <div class="card-body">
                  <h5 class="text-center font-weight-bold">Manteminientos</h5>
                  <table class="table table-sm table-bordered ">
                    <thead class="thead-light">
                      <tr>
                        <th>Grupo</th>
                        <th>Mantenimiento</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($arrayMantenimento as $m) {
                        ?>
                        <tr>
                          <td><?= $grupo ?></td>
                          <td><?= $m ?></td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>

            </div><!-- col-md-4 -->

            <!-- DETALLES -->
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <h5 class="text-center font-weight-bold">Detalles</h5>
                  <table class="table table-sm table-bordered ">
                    <thead class="thead-light">
                      <tr>
                        <th>Mantenimiento</th>
                        <th>Repuestos</th>
                        <th>Herramientas</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      echo $tr;
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>

            </div><!-- col-md-4 -->


          </div>
          <hr>

          <!-- MANTENIMIENTOS PROGRAMADOS -->
          <div class="row ">
            <div class="col-md-12">
              <h4>Programación de mantenimientos</h4>
              <table class="table table-sm table-bordered table-light">
                <tbody>
                  <tr>
                  <?php
                    foreach ($mesesProgramados as $mes) {
                      echo "                      
                        <td class='border border-dark'>$mes</td>                      
                      ";
                    }
                  ?>  
                  </tr>                
                </tbody>
              </table>


            </div>
          </div>


        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->



    <!-- Main Footer -->
    <footer class="main-footer">
      <!-- To the right -->
      <div class="float-right d-none d-sm-inline">

      </div>
      <!-- Default to the left -->
      <strong>Copyright &copy; <?= date('Y') ?> <a href="https://www.utp.edu.co" target="_blank">UTP
        </a></strong> Todos los derechos reservados.
    </footer>
  </div>
  <!-- ./wrapper -->

  <!-- REQUIRED SCRIPTS -->
  <?php include './includes/scripts.php';
  $conexionDB->close();
  ?>


</body>

</html>