<?php
namespace cprogresa;
require_once $_SERVER['DOCUMENT_ROOT'] .'/progresa/business/globals.php';
include_once SERVER.'/business/DAO/DAO_Usuarios.php';
require_once SERVER.'/business/controller/class.cabecera.php';

require_once 'class.sessions.php';

class Login extends \cprogresa\Cabecera{
    
    //protected $_pw_concat = "1596*.";
    private $_url = "/agencia/admin/index.php";

    private $_usuario;
    private $_clave;
    private $_tipo_usuario;

    public static function run(){
        $_obj = new self();
        $_obj->_establecerDatos();
        $_obj->_verificarDatosUsuario();
    }
    
    private function _establecerDatos(){
        $this->_usuario = $_POST['usuario'];
        $this->_clave = $_POST['password'];
    }
    /**
     * Verificacion y logueo de usuario
     */
    private function _verificarDatosUsuario(){
        $_objUsu = new DAO_Usuarios();
	
        if(!$_objUsu->consultar()){
            $con = \cprogresa\ConexionSQL::getInstance();
            $this->_respuesta(false,"Error SQL: ".$con->obtenerError().$con->obtenerUltimaConsulta());
            return FALSE;
        }
        $id = $_objUsu->get_id_usu_cp();
	
        if(empty($id)){
            $this->_respuesta(false,'Error en las credenciales');
        }/*else{
            Session::initSession($_objUsu);
            $this->_guardarLog($_SESSION['cm_id_usuario'], array('accion' => 'login'));
            $this->_respuesta(true);
        }*/
    }
    /**
     * 
     * @param type $respuesta
     */
    private function _respuesta($respuesta,$mensaje = ''){
        $arrRespu = array();
        if($respuesta){
            $arrRespu = array("ok" => 1, "url" => $this->_url, "mensaje" => "", "tipo_usuario" => $this->_tipo_usuario);
        }else{
            $arrRespu = array("ok" => "0", "url" => "", "mensaje" => $mensaje, "tipo_usuario" => "");
        }
        header('Content-type: application/json');
        echo json_encode($arrRespu);
    }
    
    
}

if(isset($_POST['usuario']) && isset($_POST['password'])){
    \cprogresa\Login::run();
}