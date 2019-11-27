<!DOCTYPE html>
<html lang="es">

<head>
  <?php include './includes/head.php'; ?>
  <title>Programación de Mantenimiento</title>
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
              <h1 class="m-0 text-dark">Programación de Mantenimiento</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Programación de Mantenimiento</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <div class="content">
        <div class="container-fluid">
          <div class="row justify-content-center text-center">
            <!-- FECHAS -->
            <div class="col-sm-3">
              <div class="form-group">
                <label for="fecha1">Fecha 1</label>
                <input id="fecha1" class="form-control" type="date" name="fecha1">
              </div>
            </div>

            <div class="col-sm-3">

              <div class="form-group">
                <label for="fecha2">Fecha 2</label>
                <input id="fecha2" class="form-control" type="date" name="fecha2">
              </div>

            </div>
          </div> <!-- /.row -->

          <div class="row justify-content-center text-center">
            <button id="btnConsultar" class="btn btn-primary">
              Consultar
            </button>
          </div>


          <!-- RESULTADO -->
          <div class="row justify-content-center mt-3">

            <div class="col-sm-8">
                <div class="table-responsive">
                  <table class="table table-sm table-bordered table-hover">
                    <thead class="thead-light">
                      <tr>
                        <th>Equipo</th>
                        <th>Fecha creación</th>
                        <th>Frecuencia</th>
                        <th>Fecha Mantenimiento</th>
                      </tr>
                    </thead>
                    <tbody id="tblMantenimientos">
                      
                    </tbody>
                  </table>
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
  <?php include './includes/scripts.php'; ?>

  <script>
    //
    $('#btnConsultar').click(function (e) { 
      e.preventDefault();

      var fecha1 = $('#fecha1').val();
      var fecha2 = $('#fecha2').val();

      var datos = {
        'fecha1' : fecha1,
        'fecha2' : fecha2,
      }

      $.ajax({
        type: "POST",
        url: "./consultaMantenimientos.php",
        data: datos,
        success: function (response) {          
          $('#tblMantenimientos').html(response);
        }
      });

      
    });



  </script>


</body>

</html>