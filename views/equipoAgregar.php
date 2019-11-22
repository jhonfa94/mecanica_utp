<?php 
  include '../CRUD/database.php';
  $conexionDB = conexionDB();

  $grupos = "SELECT * FROM grupos";
  $rGrupos = $conexionDB->query($grupos);
 


?>

<!DOCTYPE html>
<html lang="es">

<head>
  <?php include './includes/head.php'; ?>

  <link rel="stylesheet" href="./plugins/datatables/jquery.dataTables.min.css">

  <title>Agregar Equipo</title>
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
              <p class="h4">Agregar un nuevo equipo</p>

            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Agregar Equipo</li>
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
            <div class="col-sm-12">              

              <form id="frmEquipo">
                <div class="form-row">

                  <div class="form-group col-md-4">
                    <label for="equipo">Equipo</label>
                    <input id="equipo" class="form-control" type="text" name="equipo" placeholder="Nombre del equipo, este debe ser unico" required autofocus>
                  </div>

                  

                  <div class="form-group col-md-4">
                    <label for="grupo">Grupo</label>
                    <select id="grupo" class="form-control" name="grupo" required> 
                      <option disabled selected="selected">Seleccionar Grupo</option>
                      <?php 
                        if ($rGrupos->num_rows >0) {
                         
                          while ($row = $rGrupos->fetch_assoc()) {
                              $idGrupo = $row['idGrupo'];
                              $grupo = $row['grupo'];
                              $opcion ="<option value='$idGrupo'>$grupo</option>";
                              echo $opcion;
                          }
                        } else {
                          echo "<option disabled>Sin grupos</option>";
                        }
                        
                      ?>
                    </select>
                  </div>

                  <div class="form-group col-md-4">
                    <label for="frecuencia">Frecuencia</label>
                    <input id="frecuencia" class="form-control" type="number" min="0" name="frecuencia" placeholder="Número de semanas " required>
                  </div>


                </div><!-- form-row -->

                <div class="form-row" id="descripciones">

                  <!-- <div class="form-group col-3">
                    <label>Text</label>
                    <input class="form-control" type="text" name="" required>
                  </div> -->

                </div><!-- from-row -->

                <div class="form-row">
                  <div class="form-group">
                    <input type="hidden" name="peticion" value="agregar">
                    <input id="enviar" class="btn btn-primary" type="submit" value="Guardar">
                  </div>
                </div><!-- from-row -->


                
              </form>

            
            </div>


          
            



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
  <script src="./plugins/sweetalert2/sweetalert2@8.js"></script>
  <script src="./plugins/datatables/dataTables.min.js"></script>


  <script>
    $(document).ready(function () {
      

      //CODIGO JS
      $(".cancelar").click(function (e) { 
        e.preventDefault();
        $(".inputValue").val('');        
      });

      //formulario
      $("#frmEquipo").submit(function (e) { 
        e.preventDefault();

        //console.log("FrmEquipo => "+ $(this).serialize())

        $.ajax({
          type: "POST",
          url: "../CRUD/equipo.php",
          data: $(this).serialize(),
          success: function (response) {
            console.log("Respuesta=> "+response)

            if (response == "1") {
              //Mensaje
              Swal.fire({
                position: 'top-cener',
                icon: 'success',
                title: 'Datos guardados correctamente',
                showConfirmButton: false,
                timer: 3000
              })
            
              //LIMIPIO EL FORMULARIO
              $('#frmEquipo')[0].reset();

              setTimeout(() => {
                location.reload()
              }, 2500);

            } else {
              
            }
          }
        });


        
      });

      //grupos
      $('#grupo').change(function (e) { 
        e.preventDefault();
        console.log($(this).val())
        $.ajax({
          type: "POST",
          url: "../CRUD/equipo.php",
          data: {peticion: 'grupo', idGrupo : $(this).val() },
          success: function (response) {
              console.log(response);

              let datos = response[0].idCaracteristica;
              console.log("Caracteristica seleccionada: "+datos);
              var arrayDatos = datos.split(',');
              console.log(arrayDatos);

              let template; 
              
              for (let i  in arrayDatos) {
                template +=//html
                `
                <div class="form-group col-3">
                  <label>${arrayDatos[i]}</label>
                  <input class="form-control" type="hidden" name="caracteristica[]" value="${arrayDatos[i]}" required>
                  <input class="form-control" type="text" name="valor[]" required>
                </div>
                `;
              }              
              //RESCRIBIMOS EL HTML DEL DIV
              $('#descripciones').html(template);

          }
        });
        
      });
      




      //Traigo los datos de los grupos
      $.ajax({
        type: "POST",
        url: "../CRUD/equipo.php",
        data: {peticion: 'grupos'},
        success: function (response) {
          //console.log(response);
          if(response != '0'){
            let datos = response;
            let template = ` <option disabled >Seleccionar</option>`;
            datos.forEach(d => {
              template += //html 
              `
              <option value="${d.idGrupo}">${d.grupo}</option>
              `
            });//foreach
            $('.grupos').append(template);
          }
        }
      });
      
      
      


    });
  </script>

  


</body>

</html>