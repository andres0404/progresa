<?php 
require_once '../business/globals.php';
include_once(SERVER . '/business/controller/class.sessions.php');
try{
    \cprogresa\Session::verificarSesion();
    \cprogresa\Session::establecerRolUsuario();
    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";
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

    
</head>
<body>
    <script>
        
        function getAccess(ROL){
            bit_usuario = parseInt(ROL);
            ROL = parseInt(ROL);
            console.log("usuario: " +bit_usuario + " rol: " + ROL );
            return (bit_usuario & ROL) == 0 ? false : true;
        }
        const ru = '<?php echo $_SESSION['rol_bit_a_bit']; ?>';
        const tu = '<?php echo $_SESSION['rol_nombre']; ?>';
        if(getAccess(ru)){
            if(ru == 32){
                window.location = 'super-admin/configuracion-practicas.php';
            }
            if(ru == 8){
                window.location = 'admin-linea/usuarios.php';
            }  
            if(ru == 4){
                window.location = 'coordinador/practicas.php';
            }  
            if(ru == 64){
                window.location = 'estudiante/practicas.php';
            } 
        }
        
        
        
        
        console.log('-----', getAccess(ru));
        
        
        console.log('--_---->', ru);
    </script>

</body>
</html>
