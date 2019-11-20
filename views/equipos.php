<!DOCTYPE html>
<html lang="es">

<head>
  <?php include './includes/head.php'; ?>

  <link rel="stylesheet" href="./plugins/datatables/jquery.dataTables.min.css">

  <title>Equipos</title>
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
              <!-- <h1 class="m-0 text-dark">Características</h1> -->
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalMantenimiento">
              Agregar Equipo
              </button>


            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Equipos</li>
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
              <div class="table-responsive">
                <table id="tblEquipos" class="table table-sm table-hover table-bordered" style="width:98%">
                  <thead class="thead-light">
                    <tr>                      
                      <th>ID</th>
                      <th>EQUIPO</th>
                      <th>GRUPO</th>
                      <th>FRECUENCIA</th>
                      <th>FECHA</th>
                      <th></th>
                      
                    </tr>
                  </thead>
                  <tbody id="tablaDatos">
                  
                  </tbody>
                </table>
              </div><!-- table-responsive -->
            </div>


            <!-- MODAL -->
            <!-- Button trigger modal -->
            
            <!-- Modal -->
            <div class="modal fade" id="modalMantenimiento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar nuevo grupo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form id="frmEquipos">
                  <div class="modal-body">

                      <div class="form-group">
                        <label for="equipo">Equipo</label>
                        <input id="equipo" class="form-control inputValue " type="text" name="equipo" placeholder="Nombre del equipo " required>
                      </div>

                      <div class="form-group">
                        <label for="idGrupo">Grupo</label>
                        <select id="idGrupo" class="form-control inputValue grupos" name="idGrupo" required> 
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="frecuencia">Frecuencia</label>
                        <input id="frecuencia" class="form-control inputValue " type="number" name="frecuencia" placeholder="Nombre del frecuencia " required>
                      </div>

                     
                      <input type="hidden" name="peticion" value="registrar">
                    
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger cancelar" data-dismiss="modal" id="btnCancelar">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                  </div>
                  </form>
                </div>
              </div>
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
      //DATATABLE
      function datatable(){        
        $('#tblEquipos').DataTable({
          "order": [[0, "asc"]],
          "language": {
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtro de _MAX_ registros)",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "search": "Buscar:",
            "zeroRecords": "No se encontraron registros coincidentes",
            "paginate": {
              "next": "Siguiente",
              "previous": "Anterior"
            },
          },
          "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todo"]]


        });
      }

      //CODIGO JS
      $(".cancelar").click(function (e) { 
        e.preventDefault();
        $(".inputValue").val('');        
      });

      //formulario
      $("#frmEquipos").submit(function (e) { 
        e.preventDefault();

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
              $('#frmEquipos')[0].reset();

              setTimeout(() => {
                location.reload()
              }, 2500);

            } else {
              
            }
          }
        });


        
      });

      //Listar 
      function listar(){
        $.ajax({
          type: "POST",
          url: "../CRUD/equipo.php",
          data: {peticion: 'listar'},
          success: function (response) {
            //console.log(response);
            var datos = response; 
            let template = '';
            datos.forEach(d => {
                template += //html
                `
                  <tr>                 
                    <td>${d.idEquipo}</td>
                    <td>${d.equipo}</td>
                    <td>${d.grupo}</td>
                    <td>${d.frecuencia}</td>                
                    <td>${d.fecha_creacion}</td>                
                    <td>
                      <!-- ACTUALIZAR-->
                      <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#actualizar${d.idEquipo}">
                        ACTUALIZAR
                      </button>                        
                      <!-- Modal Actualizar -->
                      <div class="modal fade" id="actualizar${d.idEquipo}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Actualizar Equipo ${d.equipo}</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form class="frmActualizar" action="../CRUD/equipo.php">
                              <div class="modal-body">

                              <div class="form-group">
                                <label for="equipo">Equipo</label>
                                <input id="equipo" class="form-control inputValue " type="text" name="equipo" placeholder="Nombre del equipo " value="${d.equipo}" required>
                              </div>

                              <div class="form-group">
                                <label for="idGrupo">Grupo</label>
                                <select id="idGrupo" class="form-control inputValue grupos" name="idGrupo" required> 
                                  <option value="${d.idGrupo}">${d.grupo}</option>
                                </select>
                              </div>

                              <div class="form-group">
                                <label for="frecuencia">Frecuencia</label>
                                <input id="frecuencia" class="form-control inputValue " type="number" name="frecuencia" placeholder="Nombre del frecuencia" value="${d.frecuencia}" required>
                              </div>

                              
                                  
                              

                                <input type="hidden" id="idEquipo" name="idEquipo" value="${d.idEquipo}">
                                <input type="hidden" id="peticion" name="peticion" value="actualizar">


                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary cancelar" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success btnActualizar">Actualizar</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                   
                      <!-- ELIMINAR-->
                      <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#eliminar${d.idEquipo}">
                        ELIMINAR
                      </button>                        
                      <!-- Modal Eliminar -->
                      <div class="modal fade" id="eliminar${d.idEquipo}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Desea eliminar este registro </h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form class="frmEliminar" action="../CRUD/equipo.php">
                            <div class="modal-body">
                            
                              <p>Equipo: ${d.equipo}</p>
                              <p>Grupo: ${d.grupo}</p>
                              <p>Frecuencia: ${d.frecuencia}</p>                              

                            <input type="hidden" id="idEquipo" name="idEquipo" value="${d.idEquipo}">
                                <input type="hidden" id="peticion" name="peticion" value="eliminar">
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                              <button type="submit" class="btn btn-danger">Eliminar</button>
                            </div>
                            </form>
                            
                          </div>
                        </div>
                      </div>

                      
                    </td>                  
                  </tr>

                `;

            });
            //IMPRIMO EL HTML
            $('#tablaDatos').html(template);
            //LLAMO FUNCION PARA LISTAR LOS DATOS EN EL DATATABLE
            datatable(); 
          }
        });

      }//funcion listar
      listar();

      //Traigo los datos de las herramientas
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