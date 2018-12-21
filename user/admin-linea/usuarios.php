<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/progresa/business/globals.php';
include_once(SERVER . '/business/controller/class.sessions.php');
try {
    \cprogresa\Session::verificarSesion();
    \cprogresa\Session::establecerRolUsuario();
} catch (\cprogresa\sesionException $e) {
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
        <script>
            var userData = new Array();
                userData[0] = '<?php echo $_SESSION['cm_id_sede']; ?>';
                userData[1] = '<?php echo $_SESSION['cf_linea_practica']; ?>';
        </script>
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
                                    <img src="../../dist/img/user.svg" class="user-image" alt="User Image">
                                    <span class="hidden-xs" style="text-transform: uppercase;"><?php echo $_SESSION['cm_nombres']. ' ' .$_SESSION['cm_apellidos']; ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="../../dist/img/user.svg" class="img-circle" alt="User Image">
                                        <p  style="text-transform: uppercase;"><?php echo $_SESSION['cm_nombres']. ' ' .$_SESSION['cm_apellidos']; ?></p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-right">
                                            <a href="../../business/controller/class.sessions.php?kill=1" class="btn btn-default btn-flat">Sign out</a>
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
                            <h3 class="box-title">USUARIOS</h3>
                            <a class="btn btn-default pull-right" data-toggle="modal" data-target="#form-usuario"> Crear usuario <i class="fa fa-fw fa-user-plus"></i> </a>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="example" class="display nowrap" style="width:100%"> 
                                <thead> 
                                    <tr> 
                                        <th width="10%">ID</th> 
                                        <th width="10%">Nombre(s)</th> 
                                        <th width="10%">Apellido(s)</th> 
                                        <th width="10%">Tipo de Documento</th>
                                        <th width="10%">Número de Documento</th> 
                                        <th width="15%">Correo Institucional</th> 
                                        <th width="15%">Correo Personal</th>
                                        <th width="10%">Sede</th>
                                        <th width="10%"></th>
                                    </tr> 
                                </thead> 
                                <tbody id="list-coordinadores">
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


        <div class="modal fade" id="form-usuario">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">CREAR USUARIO</h4>
                    </div>
                    <div class="modal-body">
                        
                        <form class="form-horizontal" id="frm-users">

                            
                            <div class="box-body">
                                <input type="hidden" class="form-control" name="id_usu_cent" id="id_usu_cent" placeholder="ID" value="">
                                <div class="form-group">
                                    <label for="u_id_genesis" class="col-sm-3 control-label">ID Génesis</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="u_id_genesis" id="u_id_genesis" placeholder="ID Génesis" value="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="u_nombres" class="col-sm-3 control-label">Nombre(s)</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="u_nombres" id="u_nombres" placeholder="Nombre(s)">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="u_apellidos" class="col-sm-3 control-label">Apellido(s)</label>
                                    <div class="col-sm-9" data-validate = "Este campo es obligatorio">
                                        <input type="text" class="form-control" name="u_apellidos" id="u_apellidos" placeholder="Apellido(s)">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="u_numero_docu" class="col-sm-3 control-label">Número de documento</label>
                                    <div class="col-sm-9" data-validate = "Este campo es obligatorio">
                                        <input type="text" class="form-control" name="u_numero_docu" id="u_numero_docu" placeholder="Número de documento">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="u_tipo_docu " class="col-sm-3 control-label">Tipo de documento</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2" id="u_tipo_docu" name="u_tipo_docu" style="width: 100%;">
                                            <option value="1">Tarjeta de identidad</option>
                                            <option value="2">Cédula de ciudadanía</option>
                                            <option value="3">Cédula de extranjería</option> 
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="u_correo_inst" class="col-sm-3 control-label">Correo institucional</label>
                                    <div class="col-sm-9" data-validate = "Este campo es obligatorio">
                                        <input type="email" class="form-control" name="u_correo_inst" id="u_correo_inst" placeholder="Correo institucional">
                                    </div>
                                </div>                        
                                
                                <div class="form-group">
                                    <label for="u_correo_pers" class="col-sm-3 control-label">Correo personal</label>
                                    <div class="col-sm-9" data-validate = "Este campo es obligatorio">
                                        <input type="email" class="form-control" name="u_correo_pers" id="u_correo_pers" placeholder="Correo personal">
                                    </div>
                                </div>                                     
                                
                                <div class="form-group">
                                    <label for="u_tel_movil" class="col-sm-3 control-label">Número móvil</label>
                                    <div class="col-sm-9" data-validate = "Este campo es obligatorio">
                                        <input type="number" class="form-control" name="u_tel_movil" id="u_tel_movil" placeholder="Número móvil">
                                    </div>
                                </div>                                
                                
                                <div class="form-group">
                                    <label for="u_tel_fijo" class="col-sm-3 control-label">Número fijo</label>
                                    <div class="col-sm-9" data-validate = "Este campo es obligatorio">
                                        <input type="number" class="form-control" name="u_tel_fijo" id="u_tel_fijo" placeholder="Número fijo">
                                    </div>
                                </div>    
                                 

                            </div>

                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="button" class="btn btn-info pull-right" onclick="insCSA.createUser();">Guadar</button>
                            </div>
                            <!-- /.box-footer -->
                        </form> 
                        
                        
                        
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <script src="../../resources/core/model/app.adminlinea.js"></script>

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
        <script>
            insCSA.viewListUsers();
        </script>
    </body>
</html>
