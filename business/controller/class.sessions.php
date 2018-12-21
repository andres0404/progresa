<?php
namespace cprogresa;
require_once $_SERVER['DOCUMENT_ROOT'] . '/progresa/business/globals.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/progresa/business/controller/class.cabecera.php';
//include_once $_SERVER['DOCUMENT_ROOT'].'/progresa/business/DAO/DAO_TarLog.php';


class Session extends \cprogresa\Cabecera{
    
    private static $_periodos = array(
        40 => array('12-20', '04-20', '-1'), // -1: el sistema restara -1 al año del sistema para la fecha inicial
        45 => array('04-21', '08-21', '0'),
        50 => array('09-22', '12-20', '0'),
        60 => array('07-01', '12-20', '0'),
    );

    public static function initSession(\DAO_Usuarios $_objUsuario, $periodoForzado = NULL) {
        //ini_set('session.save_path', realpath(dirname('') . '../../../sesiones'));
        //die(dirname('') . '../../sesiones');
        //ini_set('session.save_path',realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../sesiones'));
        session_start();
        if (!empty($periodoForzado) && strlen($periodoForzado) == 6 && is_numeric($periodoForzado)) {
            $_SESSION['periodo'] = $periodoForzado;
        } else {
            foreach (self::$_periodos as $periodo => $rango) {
                $year = date("Y");
                $ini = ($year - $rango[2]) . "-" . $rango[0];
                $fin = ($year) . "-" . $rango[1];
                $fechaHoy = date("Y-m-d");
                if ($fechaHoy >= $ini && $fechaHoy <= $fin) {
                    $_SESSION['periodo'] = date("Y") . $periodo;
                    break;
                }
            }
        }
        //ini_set('session.save_path','/home/www/uvd.uniminuto.edu/boletin/sesiones');
		
    }
    /**
     * Consulta el rol del usuario para que pueda verificarse los privilegios a lo 
     * largo de la aplicacion
     */
    public static function establecerRolUsuario() {
        if(isset($_SESSION['rol_bit_a_bit'])){
            return true;
        }
        $con = \cprogresa\ConexionSQL::getInstance();
        $query = "SELECT *,(SELECT valor_nombre FROM maestro_contenido WHERE id_maestro = 7 AND valor_valor = cf_linea_practica LIMIT 1) nombre_linea FROM usuarios a, roles b WHERE a.id_usu_cent = {$_SESSION['id_usuario']} AND a.id_rol = b.id_rol ";
        $id = $con->consultar($query);
        if(!$res = $con->obenerFila($id)){
            throw new \cprogresa\sesionException("El usuario no tiene acceso a esta plataforma");
        }
        $_SESSION['rol_bit_a_bit'] = $res['rol_bit_a_bit'];
        $_SESSION['rol'] = $res['id_rol'];
        $_SESSION['rol_nombre'] = $res['nom_rol'];
        $_SESSION['cf_linea_practica'] = $res['cf_linea_practica'];
        $_SESSION['cf_linea_practica_nombre'] = $res['nombre_linea'];
        
        $_SESSION['id_usu_cp'] =  $res['id_usu_cp'];
        $_SESSION['id_usu_cent'] =  $res['id_usu_cent'];
        //$_SESSION['validar_sede'] = $res['validar_sede'];
        //$_SESSION['validar_facultad'] = $res['validar_facultad'];
        //$_SESSION['validar_programa'] = $res['validar_programa'];
    }
    /**
     * verifica si esta creada una sesion
     */
    public static function verificarSesion() {
        //ini_set('session.save_path', realpath(dirname('') . '../../../sesiones'));
        session_start();
        if (!isset($_SESSION['id_usuario']) || empty($_SESSION['id_usuario'])) {
            session_destroy();
            header("Location: ../index.html");
        }
    }
    public static function destroySession() {
        session_start();
        //ini_set('session.save_path', realpath(dirname('') . '../../../sesiones'));
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]
            );
        }
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]
            );
        }
        $_obj = new self();
        $_obj->_guardarLog($_SESSION['id_usu_cent'], array('accion' => 'logout'));
        // Finalmente, destruir la sesión.
        $_SESSION = array();
        session_destroy();
        header("Location: ".NOM_PROYECTO);
        //echo "No se pudo cerrar La sesion " . print_r($_SESSION);
    }
}
class sesionException extends \Exception{}
if (isset($_GET['kill'])) {
    \cprogresa\Session::destroySession();
}