<?php 
/* CONSULTA SQL PARA EL DETALLE */
    $sqlDetalle="SELECT  
    e.equipo,
    e.idGrupo, g.grupo,
    e.frecuencia,
    e.caracteristica,e.valor, e.fecha_creacion
    FROM equipos e
    INNER JOIN grupos g ON e.idGrupo = g.idGrupo
    WHERE e.equipo = 'Equipo Dos'
";

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
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">
              <?=isset($_REQUEST['equipo']) ? $_REQUEST['equipo'] : ''   ?>
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
        <div class="row">
         <!-- AGREGAR COLUMNAS -->


        </div> <!-- /.row -->
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
    <strong>Copyright &copy; <?=date('Y')?> <a href="https://www.utp.edu.co" target="_blank">UTP
          </a></strong> Todos los derechos reservados.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<?php include './includes/scripts.php';?>


</body>
</html>
