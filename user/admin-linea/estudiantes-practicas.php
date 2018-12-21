<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/progresa/business/globals.php';
include_once(SERVER . '/business/controller/class.sessions.php');
try{
    \cprogresa\Session::verificarSesion();
    \cprogresa\Session::establecerRolUsuario();
} catch(\cprogresa\sesionException $e){
    echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Centro Progresa</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
  
  <!-- -->
  <link rel='stylesheet' href='../../dist/css/jquery.dataTables.min.css'>
  <link rel='stylesheet' href='../../dist/css/rowReorder.dataTables.min.css'>
  <link rel='stylesheet' href='../../dist/css/responsive.dataTables.min.css'>
  <link rel="stylesheet" href="../../dist/css/style.css">


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>C</b>P</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Centro </b>Progresa</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="../../dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs">Usuario Demo</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  Usuario Demo
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="#" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>

        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

      <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">SUPER ADMIN</li>
            <li><a href="../../super-admin/configuracion-practicas.php"><i class="fa fa-circle-o text-red"></i> <span>Configuración de prácticas</span></a></li> 
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Sedes</span></a></li>
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Estudiantes</span></a></li>        
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Empresas</span></a></li>

            <li class="header">ADMIN LÍNEA</li>
            <li><a href="../../user/admin-linea/usuarios.php"><i class="fa fa-circle-o text-red"></i> <span>Usuarios</span></a></li> <!-- sólamente asigna la práctica al coordinador -->
            <li><a href="../../user/admin-linea/administracion-practicas.php"><i class="fa fa-circle-o text-red"></i> <span>Administración de prácticas</span></a></li> 
            <li><a href="../../user/admin-linea/estudiantes-practicas.php"><i class="fa fa-circle-o text-red"></i> <span>Estudiantes en prácticas</span></a></li> 
            
            
            <li class="header">COORDINADOR LÍNEA</li>
            <li><a href="../../coord-linea/practicas.php"><i class="fa fa-circle-o text-red"></i> <span>Prácticas</span></a></li> <!-- asignación y seguimiento -->
            
            
            <li class="header">ORIENTADOR LÍNEA</li>
            <li><a href="../../orient-linea/practicas.php"><i class="fa fa-circle-o text-red"></i> <span>Prácticas</span></a></li> <!-- asignación y seguimiento -->
            
            <li class="header">DOCENTE LÍNEA</li>
            <li><a href="../../doc-linea/practicas.php"><i class="fa fa-circle-o text-red"></i> <span>Prácticas</span></a></li> <!-- asignación y seguimiento -->
            
            <li class="header">ESTUDIANTES</li>
            <li><a href="../../estudiantes/practicas.php"><i class="fa fa-circle-o text-red"></i> <span>Prácticas</span></a></li> <!-- Listado por tipo e inscripción -->
            
            <li class="header">ADMIN EMPRESAS</li>
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Admin Empresa</span></a></li> <!-- Registro y actualización de datos -->
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Prácticas vacantes</span></a></li> <!-- Liastado por tipo e inscripción -->
            <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Proponer problemas</span></a></li> <!-- Liastado por tipo e inscripción -->
            
            
        </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">


        <!-- Main content -->
        <section class="content">
            <!-- Main row -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">ESTUDIANTES EN PRÁCTICAS</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example" class="display nowrap" style="width:100%"> 
                        <thead> 
                            <tr> 
                                <th width="10%">ID</th> 
                                <th>Nombre(s)</th> 
                                <th>Apellido(s)</th> 
                                <th>Facultad</th>
                                <th>Programa</th> 
                                <th>Sede</th>
                                <th>Modalidad</th> 
                                <th>Duración</th>
                                <th>Seguimiento</th>
                                <th></th>
                            </tr> 
                        </thead> 
                        <tbody> 
                            <tr> 
                                <td>123456</td> 
                                <td>Lorem ipsum </td> 
                                <td>Lorem ipsum</td> 
                                <td>Ingeniería</td> 
                                <td>Ingeniería de Sistemas</td> 
                                <td>Bogotá Clle. 80 Virtual y Distancia </td> 
                                <td>Contrato Aprendizaje</td> 
                                <td>6 meses </td>
                                <td><a class="btn btn-primary margin" data-toggle="modal" data-target="#informe">Informe</a></td>
                                <td><a class="btn btn-info margin"><i class="fa fa-fw fa-edit"></i></a>
                                <a class="btn btn-danger margin"><i class="fa fa-fw fa-trash"></i></a>
                                </td>
                            </tr> 
                            <tr> 
                                <td>123456</td> 
                                <td>Lorem ipsum </td> 
                                <td>Lorem ipsum</td> 
                                <td>Ingeniería</td> 
                                <td>Ingeniería de Sistemas</td> 
                                <td>Bogotá Clle. 80 Virtual y Distancia </td> 
                                <td>Contrato Aprendizaje</td> 
                                <td>6 meses </td>
                                <td><a class="btn btn-primary margin" data-toggle="modal" data-target="#informe">Informe</a></td>
                                <td><a class="btn btn-info margin"><i class="fa fa-fw fa-edit"></i></a>
                                <a class="btn btn-danger margin"><i class="fa fa-fw fa-trash"></i></a>
                                </td>
                            </tr> 
                            <tr> 
                                <td>123456</td> 
                                <td>Lorem ipsum </td> 
                                <td>Lorem ipsum</td> 
                                <td>Ingeniería</td> 
                                <td>Ingeniería de Sistemas</td> 
                                <td>Bogotá Clle. 80 Virtual y Distancia </td> 
                                <td>Contrato Aprendizaje</td> 
                                <td>6 meses </td>
                                <td><a class="btn btn-primary margin" data-toggle="modal" data-target="#informe">Informe</a></td>
                                <td><a class="btn btn-info margin"><i class="fa fa-fw fa-edit"></i></a>
                                <a class="btn btn-danger margin"><i class="fa fa-fw fa-trash"></i></a>
                                </td>
                            </tr>  
                            <tr> 
                                <td>123456</td> 
                                <td>Lorem ipsum </td> 
                                <td>Lorem ipsum</td> 
                                <td>Ingeniería</td> 
                                <td>Ingeniería de Sistemas</td> 
                                <td>Bogotá Clle. 80 Virtual y Distancia </td> 
                                <td>Contrato Aprendizaje</td> 
                                <td>6 meses </td>
                                <td><a class="btn btn-primary margin" data-toggle="modal" data-target="#informe">Informe</a></td>
                                <td><a class="btn btn-info margin"><i class="fa fa-fw fa-edit"></i></a>
                                <a class="btn btn-danger margin"><i class="fa fa-fw fa-trash"></i></a>
                                </td>
                            </tr>  
                            <tr> 
                                <td>123456</td> 
                                <td>Lorem ipsum </td> 
                                <td>Lorem ipsum</td> 
                                <td>Ingeniería</td> 
                                <td>Ingeniería de Sistemas</td> 
                                <td>Bogotá Clle. 80 Virtual y Distancia </td> 
                                <td>Contrato Aprendizaje</td> 
                                <td>6 meses </td>
                                <td><a class="btn btn-primary margin" data-toggle="modal" data-target="#informe">Informe</a></td>
                                <td><a class="btn btn-info margin"><i class="fa fa-fw fa-edit"></i></a>
                                <a class="btn btn-danger margin"><i class="fa fa-fw fa-trash"></i></a>
                                </td>
                            </tr>  
                            <tr> 
                                <td>123456</td> 
                                <td>Lorem ipsum </td> 
                                <td>Lorem ipsum</td> 
                                <td>Ingeniería</td> 
                                <td>Ingeniería de Sistemas</td> 
                                <td>Bogotá Clle. 80 Virtual y Distancia </td> 
                                <td>Contrato Aprendizaje</td> 
                                <td>6 meses </td>
                                <td><a class="btn btn-primary margin" data-toggle="modal" data-target="#informe">Informe</a></td>
                                <td><a class="btn btn-info margin"><i class="fa fa-fw fa-edit"></i></a>
                                <a class="btn btn-danger margin"><i class="fa fa-fw fa-trash"></i></a>
                                </td>
                            </tr> 
                            <tr> 
                                <td>123456</td> 
                                <td>Lorem ipsum </td> 
                                <td>Lorem ipsum</td> 
                                <td>Ingeniería</td> 
                                <td>Ingeniería de Sistemas</td> 
                                <td>Bogotá Clle. 80 Virtual y Distancia </td> 
                                <td>Contrato Aprendizaje</td> 
                                <td>6 meses </td>
                                <td><a class="btn btn-primary margin" data-toggle="modal" data-target="#informe">Informe</a></td>
                                <td><a class="btn btn-info margin"><i class="fa fa-fw fa-edit"></i></a>
                                <a class="btn btn-danger margin"><i class="fa fa-fw fa-trash"></i></a>
                                </td>
                            </tr> 
                            <tr> 
                                <td>123456</td> 
                                <td>Lorem ipsum </td> 
                                <td>Lorem ipsum</td> 
                                <td>Ingeniería</td> 
                                <td>Ingeniería de Sistemas</td> 
                                <td>Bogotá Clle. 80 Virtual y Distancia </td> 
                                <td>Contrato Aprendizaje</td> 
                                <td>6 meses </td>
                                <td><a class="btn btn-primary margin" data-toggle="modal" data-target="#informe">Informe</a></td>
                                <td><a class="btn btn-info margin"><i class="fa fa-fw fa-edit"></i></a>
                                <a class="btn btn-danger margin"><i class="fa fa-fw fa-trash"></i></a>
                                </td>
                            </tr> 
                            <tr> 
                                <td>123456</td> 
                                <td>Lorem ipsum </td> 
                                <td>Lorem ipsum</td> 
                                <td>Ingeniería</td> 
                                <td>Ingeniería de Sistemas</td> 
                                <td>Bogotá Clle. 80 Virtual y Distancia </td> 
                                <td>Contrato Aprendizaje</td> 
                                <td>6 meses </td>
                                <td><a class="btn btn-primary margin" data-toggle="modal" data-target="#informe">Informe</a></td>
                                <td><a class="btn btn-info margin"><i class="fa fa-fw fa-edit"></i></a>
                                <a class="btn btn-danger margin"><i class="fa fa-fw fa-trash"></i></a>
                                </td>
                            </tr> 
                            <tr> 
                                <td>123456</td> 
                                <td>Lorem ipsum </td> 
                                <td>Lorem ipsum</td> 
                                <td>Ingeniería</td> 
                                <td>Ingeniería de Sistemas</td> 
                                <td>Bogotá Clle. 80 Virtual y Distancia </td> 
                                <td>Contrato Aprendizaje</td> 
                                <td>6 meses </td>
                                <td><a class="btn btn-primary margin" data-toggle="modal" data-target="#informe">Informe</a></td>
                                <td><a class="btn btn-info margin"><i class="fa fa-fw fa-edit"></i></a>
                                <a class="btn btn-danger margin"><i class="fa fa-fw fa-trash"></i></a>
                                </td>
                            </tr> 
                        </tbody> 
                        
                    </table>
                </div>
            </div>
            <!-- /.row (main row) -->
        </section>
        <!-- /.content -->
    </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2018-2022 <a href="https://uniminuto.edu">Campus Uniminuto</a>.</strong> All rights
    reserved.
  </footer>
</div>
<!-- ./wrapper -->


<div class="modal fade" id="informe">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">INFORME</h4>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<!-- jQuery 3 -->
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../../bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Slimscroll -->
<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>

<!-- -->
<script src='../../dist/js/jquery-3.3.1.js'></script>
<script src='../../dist/js/jquery.dataTables.min.js'></script>
<script src='../../dist/js/dataTables.rowReorder.min.js'></script>
<script src='../../dist/js/dataTables.responsive.min.js'></script>
<script  src="../../dist/js/index.js"></script>

</body>
</html>
