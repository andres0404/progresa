<?php

namespace cprogresa;

require_once $_SERVER['DOCUMENT_ROOT'] . '/progresa/business/globals.php';
include_once(SERVER . '/business/DAO/DAO_Usuarios.php');
include_once(SERVER . '/business/DAO/DAO_Empresas.php');
include_once(SERVER . '/business/DAO/DAO_TblArchivos.php');
include_once(SERVER . '/business/DAO/DAO_RelArchivosEmpresa.php');
include_once(SERVER . '/business/controller/class.cabecera.php');
include_once(SERVER . '/business/controller/class.sessions.php');
include_once(SERVER . '/business/controller/class.roles_bit.php');
include_once(SERVER . '/business/controller/class.mtablas.php');
include_once $_SERVER['DOCUMENT_ROOT'] . '/logincentral/business/controller/class.usuarios.php';

class ControllerUsuarios extends \cprogresa\Cabecera {

    private $_funcion;
    private $_ok;
    private $_mensaje;

    public static function run() {
        \cprogresa\Session::verificarSesion();
        \cprogresa\Session::establecerRolUsuario();
        $_obj = new self();
        $_obj->_funcion = $_REQUEST['funcion'];
        try {
            $con = \cprogresa\ConexionSQL::getInstance();
            $con->begin();
            $respuesta = null;
            switch ($_obj->_funcion) {
                case 1:
                    $respuesta = $_obj->_agregarUsuario();
                    break;
                case 2:// agregar/actualizar empresa
                    $respuesta = $_obj->_agregarEmpresa($_POST['emp_nombre'], $_POST['emp_nit'], $_POST['emp_cod_verifica'], $_POST['emp_direccion'], $_POST['emp_telefonos'], isset($_POST['id_emp']) ? $_POST['id_emp'] : NULL, isset($_POST['emp_estado']) ? $_POST['emp_estado'] : NULL);
                    break;
                case 10:
                    $respuesta = $_obj->_consultarUsuarios(isset($_POST['id_rol']) ? $_POST['id_rol'] : NULL);
                    break;
                case 12: // agregar documentacion empresa
                    $respuesta = $_obj->_agregarDocumentoEmpresa($_POST['id_emp'], $_POST['tipo_archivo'], $_FILES['emp_archivo']);
                    break;
                case 121:
                    $respuesta = $_obj->_cambiarEstadoEmpresa($_POST['id_emp'], $_POST['emp_estado']);
                    break;
                case 122:
                    $respuesta = $_obj->_cambiarEstadoArchivoEmpresa($_POST['id_arch_emp'], $_POST['estado_archivo']);
            }
            $con->commit();
            $_obj->cabeceras();
            echo json_encode(array("ok" => $_obj->_ok, "mensaje" => $_obj->_mensaje, "datos" => $respuesta));
        } catch (\cprogresa\UsuariosException $e) {
            $con->rollback();
            $arrRespu = array("ok" => $e->getCode(), "mensaje" => "oing! " . $e->getMessage(), "datos" => "");
            $_obj->cabeceras();
            echo json_encode($arrRespu);
        }
    }
    /**
     * 
     * @return type
     */
    private function _consultarUsuarios($id_rol = NULL) {
        //print_r($id_rol);
        $_objUsu = new \cprogresa\DAO_Usuarios();
        if(!empty($id_rol))
            $_objUsu->set_id_rol($id_rol);
        if(RolesBit::getAcceso(RolesBit::ADMIN_LINEA()+RolesBit::COORDINADOR(), $_SESSION['rol_bit_a_bit'])) {// listar los usuarios que él mismo registra
            $_objUsu->set_id_usu_cp_crea($_SESSION['id_usu_cp']);
        }
        $_objUsu->habilita1ResultadoEnArray();
        $arrUsuarios = $_objUsu->consultar();
        //print_r($_objUsu);
        $R = [];
        if(is_array($arrUsuarios) && count($arrUsuarios)){
            $arrUsuCent = [];
            foreach($arrUsuarios as $obj){
                $_objUseCent = new \logincentral\DAO_Usuarios();
                $_objUseCent->set_id_usu_cent($obj->get_id_usu_cent());
                if($_objUseCent->consultar()){
                    $R[] = array_merge($_objUseCent->getArray(),$obj->getArray());
                }
            }
        }
        $this->_ok = 1;
        $this->_mensaje = "usuarios listados con exito";
        return $R;
    }

    /**
     * Agrega un usuario a usuarios_central y luego a la plataforma
     */
    private function _agregarUsuario() {
        try {
            \logincentral\ControladorUsuarios::set_echo_json(false);
            $_objUsuarios = \logincentral\ControladorUsuarios::run();
            $id_usu_cent = $_objUsuarios->get_id_usu_cent();
            //print_r($_objUsuarios);
            // insertar usuario en plataforma
            $_objUsu = new \cprogresa\DAO_Usuarios();
            $_objUsu->set_id_usu_cent($id_usu_cent);
            $_objUsu->consultar();
            $_objUsu->set_id_rol($_POST['id_rol']);
            $_objUsu->set_cf_linea_practica($_POST['cf_linea_practica']);
            $_objUsu->set_id_usu_cp_crea($_SESSION['id_usu_cp'] );
            if(!$_objUsu->guardar()){
                $this->_mensaje = $_objUsu->getMysqlError();
                throw new \cprogresa\UsuariosException("No se pudo guardar usuario");
            }
            //echo $_objUsu->getMysqlQuery();
        } catch (\logincentral\ControladorUsuariosException $e) {
            throw new \cprogresa\UsuariosException($e->getMessage());
        }
        $this->_ok = 1;
        $this->_mensaje = "Datos ingresados correctamente";
        return array_merge($_objUsuarios->getArray(),$_objUsu->getArray());
    }

    /**
     * 
     * @param type $idEmp
     * @param type $tipoArchivo
     * @param type $files
     * @param type $idArchEmp
     */
    private function _agregarDocumentoEmpresa($idEmp, $tipoArchivo, $files, $idArchEmp = NULL) {
        $_objArchivoEmpresa = null;
        $id_archivo = null;
        if (!empty($idArchEmp)) { // en caso de que 
            $_objArchivoEmpresa = new DAO_RelArchivosEmpresa();
            $_objArchivoEmpresa->set_id_arch_emp($idArchEmp);
            $_objArchivoEmpresa->consultar();
            $id_archivo = $_objArchivoEmpresa->get_id_archivo();
        }
        try {
            $this->_validarArchivo($files);
            $_objArchivo = $this->_guardarArchivo($files, $id_archivo);
        } catch (ControladorArchivosException $e) {
            throw new \cprogresa\UsuariosException($e->getMessage());
        }
        if (!($_objArchivoEmpresa instanceof DAO_RelArchivosEmpresa))
            $_objArchivoEmpresa = new DAO_RelArchivosEmpresa();
        $_objArchivoEmpresa->set_tipo_archivo($tipoArchivo);
        $_objArchivoEmpresa->set_id_emp($idEmp);
        $_objArchivoEmpresa->set_id_archivo($_objArchivo->get_id_archivo());
        $_objArchivoEmpresa->set_estado_archivo(0); //
        if (!$_objArchivoEmpresa->guardar()) {
            throw new \cprogresa\UsuariosException("No se guardo relación empresa-archivo");
        }
        return $_objArchivoEmpresa->getArray();
    }

    /**
     * 
     * @param type $idArchEmp
     * @param type $estado
     * @return type
     * @throws UsuariosException
     */
    private function _cambiarEstadoArchivoEmpresa($idArchEmp, $estado) {
        $_objArchEmp = new DAO_RelArchivosEmpresa();
        $_objArchEmp->set_id_arch_emp($idArchEmp);
        $_objArchEmp->set_estado_archivo($estado);
        if (!$_objArchEmp->guardar()) {
            throw new \cprogresa\UsuariosException("No se pudo cambiar estado del documento");
        }
        return $_objArchEmp->getArray();
    }

    /**
     * Agregar una empresa
     * @param type $empNombre
     * @param type $empNit
     * @param type $empCodVerifica
     * @param type $empDireccion
     * @param type $empTelefono
     * @param type $idEmp
     */
    private function _agregarEmpresa($empNombre, $empNit, $empCodVerifica, $empDireccion, $empTelefono, $idEmp = NULL, $empEstado = NULL) {
        $_objEmpresa = new DAO_Empresas();
        if (!empty($idEmp)) {
            $_objEmpresa->set_id_emp($idEmp);
            $_objEmpresa->set_emp_estado("0");
        }
        $_objEmpresa->set_emp_nombre($empNombre);
        $_objEmpresa->set_emp_nit($empNit);
        $_objEmpresa->set_emp_cod_verifica($empCodVerifica);
        $_objEmpresa->set_emp_direccion($empDireccion);
        $_objEmpresa->set_emp_telefonos($empTelefono);
        if (!$_objEmpresa->guardar()) {
            throw new \cprogresa\UsuariosException("No se pudo almacenar empresa. " . $_objEmpresa->getMysqlErrno());
        }
        if (!empty($idEmp)) {
            // si se crea una empresa relacionar con usuario que la crea
            $_objUsuario = new DAO_Usuarios();
            $_objUsuario->set_id_usu_cp($_SESSION['id_usu_cp']);
            $_objUsuario->consultar();
            $_objUsuario->set_id_emp($_objEmpresa->get_id_emp());
            if (!$_objUsuario->guardar()) {
                throw new \cprogresa\UsuariosException("No se pudo almacenar empresa. " . $_objUsuario->getMysqlErrno());
            }
        }
        return $_objEmpresa->getArray();
    }

    /**
     * Cambiar estado de la empresa
     * @param type $idEmp
     * @param type $estado
     * @throws UsuariosException
     */
    private function _cambiarEstadoEmpresa($idEmp, $estado) {
        $_objEmpresa = new DAO_Empresas();
        $_objEmpresa->set_id_emp($idEmp);
        $_objEmpresa->set_emp_estado($estado);
        if (!$_objEmpresa->guardar()) {
            throw new \cprogresa\UsuariosException("No se pudo cambiar estado de la empresa. " . $_objEmpresa->getMysqlErrno());
        }
        return $_objEmpresa->getArray();
    }

}

class UsuariosException extends \Exception {
    
}
\cprogresa\ControllerUsuarios::run();
