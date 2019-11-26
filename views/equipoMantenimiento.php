<?php
include '../CRUD/database.php';
$conexionDB = conexionDB();
/* CONSULTA SQL PARA EL DETALLE */

if (!isset($_REQUEST['equipo'])) {
  header("Location: equipos.php");
} else {
  $equipo = $_REQUEST['equipo'];
  $fecha = $_REQUEST['fecha'];

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
  $mesesAnio = 24;
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
              <h5> ORDEN DE TRABAJO
                <br>
                <?= $equipo ?>
              </h5>
            </div>
            <div class="col-md-4 text-center">
              <h5>
                FECHA <br>
                <?= date('Y-m-d') ?>
              </h5>
            </div>


          </div> <!-- /.row -->


          <div class="row mt-2">
            <div class="col-md-4">
              Fecha de programación: <b> <?= $fecha ?> </b>
              <br>
              Fecha de elaboración: <input type="date" name="fechaElaboracion" id="fechaElaboracion">
            </div>

            <div class="col-md-4">
              <div class="form-group">
                <label for="nombreAutoriza">Nombre de quien autoriza: </label>
                <input id="nombreAutoriza" class="form-control" type="text" name="nombreAutoriza">
              </div>

              <div class="form-group">
                <label for="nombreSupervisa">Nombre de quien supervisa: </label>
                <input id="nombreSupervisa" class="form-control" type="text" name="nombreSupervisa">
              </div>



            </div>

            <div class="col-md-4">

              <div class="form-group">
                <label for="Codigo">Código: </label>
                <input id="codigo" class="form-control" type="text" name="codigo">
              </div>

              <div class="form-group">
                <label for="nombreSupervisa">Ordenado a: </label>
                <input id="ordenadoA" class="form-control" type="text" name="ordenadoA">
              </div>


              
            </div>

          </div><!-- row -->


          <div class="row mt-2">

            <!-- MANTENIMIENTOS -->
            <div class="col-md-4 ">
              <div class="card">
                <div class="card-body">
                  <h5 class="text-center font-weight-bold">Actividad de manteminiento
                    :
                  </h5>
                  <ul>
                    <?php
                    foreach ($arrayMantenimento as $m) {
                      echo "<li>$m </li>";
                    }
                    ?>

                  </ul>

                </div>
              </div>

            </div><!-- col-md-4 -->


            <div class="col-md-4">
              <div class="card">
                <div class="card-body">
                  <div class="form-group">
                    <label for="tiempoEstimado">Tiempo estimado para la ejecución: </label>
                    <input id="tiempoEstimado" class="form-control" type="text" name="tiempoEstimado">
                  </div>

                  <div class="form-group">
                    <label for="duracion">Duración: </label>
                    <input id="duracion" class="form-control" type="text" name="duracion">
                  </div>



                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="card">
                <div class="card-body">
                  <div class="form-group">
                    <label for="listaRepuetos">Lista de repuestos: </label>
                    <textarea id="listaRepuetos" class="form-control" name="listaRepuestos" rows="3"></textarea>
                  </div>


                </div>
              </div>
            </div>


          </div>

          <div class="row mt-2">

            <div class="col-md-4">
              <div class="form-group">
                <label for="revisadoPor">Revisado por: </label>
                <input id="revisadoPor" class="form-control" type="text" name="revisadoPor">
              </div>
            </div>

            <div class="col-md-8">
              <div class="form-group">
                <label for="observaciones">Observaciones: </label>
                <textarea id="observaciones" class="form-control" name="observaciones" rows="3"></textarea>
              </div>
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