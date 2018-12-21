<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/progresa/business/globals.php';
include_once(SERVER . '/business/controller/class.sessions.php');
try{
    \cprogresa\Session::verificarSesion();
    \cprogresa\Session::establecerRolUsuario();
    
    /*echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";
     * */
     
} catch(\cprogresa\sesionException $e){
    echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $_SESSION['rol_nombre']; ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="../../bower_components/select2/dist/css/select2.min.css">     
        <!-- Theme style -->
        <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">


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
                        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Configuración de prácticas</span></a></li> 
                        <li><a href="usuarios.php"><i class="fa fa-circle-o text-red"></i> <span>Usuarios por sedes</span></a></li>
                        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Estudiantes</span></a></li>        
                        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Empresas</span></a></li>
                        <li><a href="documentos.php"><i class="fa fa-circle-o text-red"></i> <span>Documentos</span></a></li> 

                        <li class="header">ADMIN LÍNEA</li>
                        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Usuarios</span></a></li> <!-- sólamente asigna la práctica al coordinador -->
                        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Adminstración de prácticas</span></a></li> 
                        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Estudiantes en prácticas</span></a></li> 


                        <li class="header">COORDINADOR LÍNEA</li>
                        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Prácticas</span></a></li> <!-- asignación y seguimiento -->


                        <li class="header">ORIENTADOR LÍNEA</li>
                        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Prácticas</span></a></li> <!-- asignación y seguimiento -->

                        <li class="header">DOCENTES LÍNEA</li>
                        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Prácticas</span></a></li> <!-- asignación y seguimiento -->

                        <li class="header">ESTUDIANTES</li>
                        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Prácticas</span></a></li> <!-- Listado por tipo e inscripción -->

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



                    <!-- TABLE: LISTA DE PRÁCTICAS -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">LISTA DE PRÁCTICAS</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                        <tr>
                                            <th>NOMBRE DE LA PRÁCTICA</th>
                                            <th style="width: 80px;"></th>
                                            <th style="width: 80px;"></th>
                                        </tr>
                                    </thead>
                                    <tbody id="list-practicas"></tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">
                            <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right" data-toggle="modal" data-target="#frm-confg-practica">NUEVA PRÁCTICA</a>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <!-- /.box -->

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


            <!-- /.control-sidebar -->
            <!-- Add the sidebar's background. This div must be placed
                 immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->

        <!-- /.modal -->
        <div class="modal fade" id="frm-confg-practica">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">NUEVA PRÁCTICA</h4>
                    </div>
                    <div class="modal-body">
                        
                        <form class="form-horizontal" id="frm-practicas">
                            <div class="box-body">
                                <div class="form-group">
                                    <input type="hidden" class="form-control"  name="id_conf_linea" id="id_conf_linea">
                                    <label for="cf_nombre" class="col-sm-3 control-label">Nombre del documento</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="cf_nombre" id="cf_nombre" placeholder="Nombre" value="">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="cf_linea_practica " class="col-sm-3 control-label">Líneas</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2" id="cf_linea_practica" name="cf_linea_practica" style="width: 100%;"></select>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="lista_tipo_archivos " class="col-sm-3 control-label">Documentos de la práctica</label>
                                    <div class="col-sm-9">
                                        <select class="form-control select2" id="lista_tipo_archivos" name="lista_tipo_archivos" multiple="multiple" data-placeholder="Seleccione los archivos" style="width: 100%;"></select>                            
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="button" class="btn btn-default">Cancelar</button>
                                <button type="button" class="btn btn-info pull-right" onclick="insCSA.saveConfigPracticas();">Guadar</button>
                            </div>
                            <!-- /.box-footer -->
                        </form>
                        
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->


        <!-- /.modal -->
        <div class="modal fade" id="view-practica">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="tit-detail-practica" style="text-transform: uppercase;">VER PRÁCTICA</h4>
                    </div>
                    <div class="modal-body">
                        <div id="data-practica-config"></div>
                        <table class="table no-margin">
                            <thead>
                                <tr>
                                    <th>DOCUMENTOS</th>
                                </tr>
                            </thead>
                            <tbody id="list-practica-documents"></tbody>
                        </table>  
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
        <!-- Select2 -->
        <script src="../../bower_components/select2/dist/js/select2.full.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- Slimscroll -->
        <script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="../../bower_components/fastclick/lib/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="../../dist/js/adminlte.min.js"></script>
        <!-- Core desarrollo -->
        <script src="../../resources/core/model/app.superadmin.js"></script>
        <script>
            insCSA.getDocuments();
            insCSA.viewListPracticas();
            insCSA.viewListLineas();
            $(function () {
                $('.select2').select2();
            });
        </script>      
</html>
