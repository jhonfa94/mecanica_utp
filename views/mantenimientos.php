<!DOCTYPE html>
<html lang="es">

<head>
  <?php include './includes/head.php'; ?>

  <link rel="stylesheet" href="./plugins/datatables/jquery.dataTables.min.css">

  <link rel="stylesheet" href="./plugins/select2/select2.min.css">

  <title>Mantenimientos</title>
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
              Agregar Mantenimiento
              </button>


            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Características</li>
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
                <table id="tblMantenimientos" class="table table-sm table-hover table-bordered" style="width:98%">
                  <thead class="thead-light">
                    <tr>                      
                      <th>ID</th>
                      <th>HERRAMIENTA</th>
                      <th>REPUESTO</th>
                      <th>MANTENIMIENTO</th>
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
                    <h5 class="modal-title" id="exampleModalLabel">Agregar nuevo mantenimiento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form id="frmMantenimientos">
                  <div class="modal-body">
                      <div class="form-group">
                        <label for="idHerramienta">Herramienta</label>
                        <select id="idHerramienta" class="form-control inputValue herramientas selectMultiple" name="idHerramienta[]" multiple="multiple"" required> 
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="idRepuesto">Repuesto</label>
                        <select id="idRepuesto" class="form-control inputValue repuestos selectMultiple" name="idRepuesto[]" multiple="multiple"" required> 
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="mantenimiento">Mantenimiento</label>
                        <input id="mantenimiento" class="form-control inputValue" type="text" name="mantenimiento" placeholder="Nombre del mantenimiento para asignar" required>
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
  <script src="./plugins/select2/select2.min.js"></script>


  <script>
    $(document).ready(function () {
      //DATATABLE
      function datatable(){        
        $('#tblMantenimientos').DataTable({
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

      //select2
      $('.selectMultiple').select2();

      //formulario
      $("#frmMantenimientos").submit(function (e) { 
        e.preventDefault();

        $.ajax({
          type: "POST",
          url: "../CRUD/mantenimiento.php",
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
              $('#frmMantenimientos')[0].reset();

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
          url: "../CRUD/mantenimiento.php",
          data: {peticion: 'listar'},
          success: function (response) {
            //console.log(response);
            var datos = response; 
            let template = '';
            datos.forEach(d => {
                template += //html
                `
                  <tr>                 
                    <td>${d.idMantenimiento}</td>
                    <td>${d.idHerramienta}</td>
                    <td>${d.idRepuesto}</td>
                    <td>${d.mantenimiento}</td>                  
                    <td>
                      
                   
                      <!-- ELIMINAR-->
                      <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#eliminar${d.idMantenimiento}">
                        ELIMINAR
                      </button>                        
                      <!-- Modal Eliminar -->
                      <div class="modal fade" id="eliminar${d.idMantenimiento}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Desea eliminar este registro </h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form class="frmEliminar" action="../CRUD/mantenimiento.php">
                            <div class="modal-body">
                            
                              <p>Herramienta: ${d.idHerramienta}</p>
                              <p>Repuesto: ${d.idRepuesto}</p>
                              <p>Mantemiento: ${d.mantenimiento}</p>
                              

                            <input type="hidden" id="idMantenimiento" name="idMantenimiento" value="${d.idMantenimiento}">
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

                /* 
                <!-- ACTUALIZAR-->
                      <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#actualizar${d.idMantenimiento}">
                        ACTUALIZAR
                      </button>                        
                      <!-- Modal Actualizar -->
                      <div class="modal fade" id="actualizar${d.idMantenimiento}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Actualizar</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <form class="frmActualizar" action="../CRUD/mantenimiento.php">
                              <div class="modal-body">
                                  
                              <div class="form-group">
                                <label for="idHerramienta">Herramienta</label>
                                <select id="idHerramienta" class="form-control inputValue herramientas selectMultiple" name="idHerramienta[]" multiple="multiple" required> 
                                  <option value="${d.idHerramienta}" selected>${d.idHerramienta}</option>

                                </select>
                              </div>

                              <div class="form-group">
                                <label for="idRepuesto">Repuesto</label>
                                <select id="idRepuesto" class="form-control inputValue repuestos selectMultiple" name="idRepuesto[]" multiple="multiple" required> 
                                  <option value="${d.idRepuesto}" selected>${d.idRepuesto}</option>
                                </select>
                              </div>

                              <div class="form-group">
                                <label for="mantenimiento">Mantenimiento</label>
                                <input id="mantenimiento" class="form-control inputValue" type="text" name="mantenimiento" placeholder="Nombre del mantenimiento para asignar" value="${d.mantenimiento}" required>
                              </div>  

                                <input type="hidden" id="idMantenimiento" name="idMantenimiento" value="${d.idMantenimiento}">
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
                
                
                */

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
        url: "../CRUD/mantenimiento.php",
        data: {peticion: 'herramientas'},
        success: function (response) {
          //console.log(response);
          if(response != '0'){
            let datos = response;
            let template = ` <option disabled  >Seleccionar</option>`;
            /* <option value="${d.idHerramienta}">${d.herramienta}</option> */
            datos.forEach(d => {
              template += //html 
              `
              <option value="${d.herramienta}">${d.herramienta}</option>
              `
            });//foreach
            $('.herramientas').append(template);
          }
        }
      });
      
      //Traigo los datos de los repuestos idRepuesto
      $.ajax({
        type: "POST",
        url: "../CRUD/mantenimiento.php",
        data: {peticion: 'repuestos'},
        success: function (response) {
          //console.log(response);
          if(response != '0'){
            let datos = response;
            let template = ` <option disabled  >Seleccionar</option>`;
            /* <option value="${d.idRepuesto}">${d.repuesto}</option> */
            datos.forEach(d => {
              template += //html 
              `
              <option value="${d.repuesto}">${d.repuesto}</option>
              `
            });//foreach
            $('.repuestos').append(template);
          }
        }
      });
      


    });
  </script>

  


</body>

</html>