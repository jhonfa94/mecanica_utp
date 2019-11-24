<!DOCTYPE html>
<html lang="es">

<head>
  <?php include './includes/head.php'; ?>

  <link rel="stylesheet" href="./plugins/datatables/jquery.dataTables.min.css">

  <title>Repuestos</title>
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
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalRepuesto">
              Agregar Repuesto
              </button>


            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Repuestos</li>
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
                <table id="tblCaracteristicas" class="table table-sm table-hover table-bordered" style="width:98%">
                  <thead class="thead-light">
                    <tr>                      
                      <th>ID</th>
                      <th>REPUESTO</th>
                      <th>CANTIDAD</th>
                      <th>FECHA CREACIÓN</th>
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
            <div class="modal fade" id="modalRepuesto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
              aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar un nuevo repuesto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form id="frmRepuestos">
                  <div class="modal-body">
                      <div class="form-group">
                        <label for="repuesto">Repuesto</label>
                        <input id="repuesto" class="form-control inputValue" type="text" name="repuesto" required>
                      </div>
                      <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <input id="cantidad" class="form-control inputValue" type="number" name="cantidad" required>
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
        $('#tblCaracteristicas').DataTable({
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
      $("#frmRepuestos").submit(function (e) { 
        e.preventDefault();

        $.ajax({
          type: "POST",
          url: "../CRUD/repuesto.php",
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
              $('#frmRepuestos')[0].reset();

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
          url: "../CRUD/repuesto.php",
          data: {peticion: 'listar'},
          success: function (response) {
            //console.log(response);
            var datos = response; 
            let template = '';
            datos.forEach(d => {
                template += //html
                `
                  <tr>                 
                    <td>${d.idRepuesto}</td>
                    <td>${d.repuesto}</td>
                    <td>${d.cantidad}</td>
                    <td>${d.fecha_creacion}</td>                  
                    <td>
                      <!-- ACTUALIZAR-->
                      <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#actualizar${d.idRepuesto}">
                        ACTUALIZAR
                      </button>                        
                      <!-- Modal Actualizar -->
                      <div class="modal fade" id="actualizar${d.idRepuesto}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Actualizar</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form class="frmActualizar" action="../CRUD/repuesto.php">
                              <div class="modal-body">
                                  
                                <div class="form-group">
                                  <label for="repuesto">Marca</label>
                                  <input id="repuesto" class="form-control inputValue" type="text" name="repuesto" value="${d.repuesto}" required>
                                </div>
                                <div class="form-group">
                                  <label for="cantidad">Cantidad</label>
                                  <input id="cantidad" class="form-control inputValue" type="number" name="cantidad" value="${d.cantidad}" required>
                                </div>
                               

                                <input type="hidden" id="idRepuesto" name="idRepuesto" value="${d.idRepuesto}">
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
                      <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#eliminar${d.idRepuesto}">
                        ELIMINAR
                      </button>                        
                      <!-- Modal Eliminar -->
                      <div class="modal fade" id="eliminar${d.idRepuesto}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Desea eliminar este registro </h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form class="frmEliminar" action="../CRUD/repuesto.php">
                            <div class="modal-body">
                            
                              <p>Repuesto: ${d.repuesto}</p>
                              <p>Cantidad: ${d.cantidad}</p>
                              

                            <input type="hidden" id="idRepuesto" name="idRepuesto" value="${d.idRepuesto}">
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
      


    });
  </script>

  


</body>

</html>