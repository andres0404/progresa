<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/progresa/business/globals.php';
include_once(SERVER . '/business/class.conexion.php');
include_once(SERVER . '/business/DAO/DAO_DocLog.php');
include_once(SERVER . '/business/DAO/DAO_Empresas.php');
include_once(SERVER . '/business/DAO/DAO_LineasPractica.php');
include_once(SERVER . '/business/DAO/DAO_ConfLineasPractica.php');
include_once(SERVER . '/business/DAO/DAO_ConfLineasPracticaArchivos.php');
include_once(SERVER . '/business/DAO/DAO_ConfLineasPracticaSeguimiento.php');
include_once(SERVER . '/business/DAO/DAO_ConfLineasPracticaEntrega.php');
include_once(SERVER . '/business/DAO/DAO_LineasPractica.php');
include_once(SERVER . '/business/DAO/DAO_Perfiles.php');
include_once(SERVER . '/business/DAO/DAO_UsuariosPracticas.php');
include_once(SERVER . '/business/DAO/DAO_RelLineaPerfil.php');
include_once(SERVER . '/business/DAO/DAO_RelArchivosSeguimiento.php');
include_once(SERVER . '/business/DAO/DAO_Roles.php');
include_once(SERVER . '/business/DAO/DAO_Seguimientos.php');
include_once(SERVER . '/business/DAO/DAO_TblArchivos.php');
include_once(SERVER . '/business/DAO/DAO_Usuarios.php');
include_once(SERVER . '/business/controller/class.cabecera.php');
include_once(SERVER . '/business/controller/class.sessions.php');
include_once(SERVER . '/business/controller/class.roles_bit.php');
include_once(SERVER . '/business/controller/class.mtablas.php');

class Controller extends \cprogresa\Cabecera {

    private $_funcion;
    private $_ok;
    private $_mensaje;

    public static function run() {
        \cprogresa\Session::verificarSesion();
        \cprogresa\Session::establecerRolUsuario();
        $_SESSION['id_usu_cent'] = 1;
        $_obj = new self();
        $_obj->_funcion = $_REQUEST['funcion'];
        try {
            $con = \cprogresa\ConexionSQL::getInstance();
            $con->begin();
            $respuesta = null;
            switch ($_obj->_funcion) {
                case 1:// agregar/actualizar línea de practica (empresa/admin linea)
                    $respuesta = $_obj->_agrergarLineaPractica($_POST['ln_titulo'], $_POST['ln_desc'],$_POST['id_facultad'],$_POST['id_programa'],$_POST['id_usu_cp'],$_POST['id_conf_linea'], !empty($_POST['id_linea']) ? $_POST['id_linea'] : NULL, !empty($_POST['id_empre']) ? $_POST['id_empre'] : NULL);
                    break;
                case 2:
                    $respuesta = $_obj->_agregarUsuario_a_Practica($_POST['id_linea'], isset($_POST['id_usu_cp']) ? $_POST['id_usu_cp'] : NULL, isset($_POST['estado_practica']) ? $_POST['estado_practica'] : 1, isset($_POST['id_practica']) ? $_POST['id_practica'] : NULL);
                    break;
                case 3:
                    $respuesta = $_obj->_agregarListaArchivos($_POST['nombre_archivo'], $_POST['desc_archivo'], isset($_POST['id_nombre_archivo']) ? $_POST['id_nombre_archivo'] : NULL, isset($_POST['borrar']) ? $_POST['borrar'] : NULL);
                    break;
                case 4:
                    $respuesta = $_obj->_agregarSeguimiento($_POST['id_practica'], $_POST['titulo'], isset($_POST['id_segui']) ? $_POST['id_segui'] : NULL,isset($_POST['id_lp_seg']) ? $_POST['id_lp_seg'] : NULL);
                    //$respuesta = $_obj->_agregarNombresLineasPractica($_POST['nombre_linea']);
                    break;
                case 5:
                    $respuesta = $_obj->_agregarConfiguracionLineaPractica($_POST['cf_nombre'], $_POST['cf_estado'], $_POST['lista_tipo_archivos'],$_POST['cf_linea_practica'], isset($_POST['id_conf_linea']) ? $_POST['id_conf_linea'] : NULL);
                    break;
                case 6:
                    $respuesta = $_obj->_agregarConfLineaPracticaSeguimiento($_POST['id_linea'], $_POST['id_usu_cp'], $_POST['fecha_seguimiento'], isset($_POST['id_lp_seg']) ? $_POST['id_lp_seg'] : NULL);
                    break;
                case 7:
                    $respuesta = $_obj->_agregarConfLineaPracticaEntrega($_POST['id_linea'], $_POST['id_rol'], isset($_POST['id_entre_lp']) ? $_POST['id_entre_lp'] : null);
                    break;
                case 8:
                    $respuesta = $_obj->_agregarArchivosPostulacionPractica($_FILES['archivo_vincula_practica'], $_POST['id_arch_lp'], $_POST['id_practica'], $_POST['titulo'], isset($_POST['id_seg_arch']) ? $_POST['id_seg_arch'] : NULL);
                    break;
                case 9:
                    $respuesta = $_obj->_cambiarEstadoArchivoSeguimiento($_POST['id_sec_arc'], $_POST['estado']);
                    break;
                case 21:
                    $respuesta = $_obj->_consultarLineasPractica(isset($_POST['id_conf_linea']) ? $_POST['id_conf_linea'] : null, isset($_POST['solo_activos']) ? $_POST['solo_activos']:true);
                    break;
                case 22:
                    $respuesta = $_obj->_consultarUsuariosPractica(isset($_POST['linea']) ? $_POST['linea']: NULL, isset($_POST['id_usu_cp']) ?$_POST['id_usu_cp'] : NULL, isset($_POST['id_sede']) ? $_POST['id_sede']: NULL, isset($_POST['estado']) ?$_POST['estado'] : 1);
                    break;
                case 23:
                    $respuesta = $_obj->_consultarListaArchivos();
                    break;
                case 233:
                    $respuesta = $_obj->_consultarConfListaArchivosPractica($_POST['id_practica']);
                    break;
                case 25:
                    $respuesta = $_obj->_consultarConfiguracionLineaPractica(isset($_POST['id_conf_linea']) ? $_POST['id_conf_linea'] : NULL,isset($_POST['cf_linea_practica']) ? $_POST['cf_linea_practica'] : NULL);
                break;
                case 26:
                    $respuesta = $_obj->_consultaConfLineaPracticaSeguimiento($_POST['id_linea']);
                break;
                case 32:
                    $respuesta = $_obj->_eliminarUsuario_a_Practica($_POST['id_linea'], isset($_POST['id_usu_cp']) ? $_POST['id_usu_cp'] : NULL);
                    break;
            }
            $con->commit();
            $_obj->cabeceras();
            echo json_encode(array("ok" => $_obj->_ok, "mensaje" => $_obj->_mensaje, "datos" => $respuesta));
        } catch (ControllerException $e) {
            $con->rollback();
            $arrRespu = array("ok" => $e->getCode(), "mensaje" => "Ups! " . $e->getMessage(), "datos" => "", "error" => $_obj->_mensaje);
            $_obj->cabeceras();
            echo json_encode($arrRespu);
        }
    }

    /**
     * Agrega un seguimiento vinculado a un archivo para la vinculacion de un estudiante a una practica
     * @param array $file
     * @param integer $id_arch_lp requisito practica archivos
     * @param integer $id_practica
     * @param string $titulo
     * @param integer $id_seg_arch (opcional)
     * @return type
     * @throws ControllerException
     */
    private function _agregarArchivosPostulacionPractica($file, $id_arch_lp, $id_practica, $titulo, $id_seg_arch = NULL) {
        $_objArchivoSe = new DAO_RelArchivosSeguimiento();
        $id_archivo = NULL;
        if (!empty($id_seg_arch)) {// modificar el archivo subido
            $_objArchivoSe->set_id_seg_arc($id_seg_arch);
            $_objArchivoSe->consultar();
            $id_archivo = $_objArchivoSe->get_id_archivos();
        }
        $_objArchivoSe->set_id_arch_lp($id_arch_lp);
        try {
            $this->_validarArchivo($file);
            $_objArchivo = $this->_guardarArchivo($file, $id_archivo);
        } catch (ControladorArchivosException $e) {
            throw new ControllerException($e->getMessage());
        }
        $arrSeguimiento = $this->_agregarSeguimiento($id_practica, $titulo);
        $_objArchivoSe->set_id_archivos($_objArchivo->get_id_archivo());
        $_objArchivoSe->set_id_segui($arrSeguimiento['id_segui']);
        $_objArchivoSe->set_estado_archivo(1);
        if (!$_objArchivoSe->guardar()) {
            $this->_mensaje = $_objArchivoSe->getMysqlError();
            throw new ControllerException("No se pudo actualizar vinculacion de archivo a practica");
        }
        $this->_guardarLog($_SESSION['id_usu_cent'], ['accion' => 'insertar', 'metodo' => get_class() . ':_agregarArchivosPostulacionPractica', 'parametros' => ['file' => $file['name'], 'id_arch_lp' => $id_arch_lp, 'id_practica' => $id_practica, 'titulo' => $titulo, 'id_seg_arch' => $id_seg_arch]]);
        return $_objArchivoSe->getArray();
    }

    /**
     * 
     * @param type $id_seg_arc
     * @param type $estado
     * @return type
     * @throws ControllerException
     */
    private function _cambiarEstadoArchivoSeguimiento($id_seg_arc, $estado) {
        $_objArchivoSe = new DAO_RelArchivosSeguimiento();
        $_objArchivoSe->set_id_seg_arc($id_seg_arc);
        $_objArchivoSe->set_estado_archivo($estado);
        if (!$_objArchivoSe->guardar()) {
            $this->_mensaje = $_objArchivoSe->getMysqlError();
            throw new ControllerException("No se pudo actualizar estado del archivo");
        }
        $this->_guardarLog($_SESSION['id_usu_cent'], ['accion' => 'actualizar', 'metodo' => get_class() . ':_cambiarEstadoArchivoSeguimiento', 'parametros' => ['id_seg_arc' => $id_seg_arc, 'estado' => $estado]]);
        return $_objArchivoSe->getArray();
    }

    /**
     * Agrega un seguimiento vinculado a un archivo para la entrega de la practica por parte del estudiante
     * @param array $file
     * @param integer $id_entrega_lp
     * @param integer $id_practica
     * @param string $titulo
     * @param integer $id_seg_arch (opcional)
     * @return type
     * @throws ControllerException
     */
    private function _agregarArchivosEntregaPractica($file, $id_entrega_lp, $id_practica, $titulo, $id_seg_arch = NULL) {
        $_objUsuarioPractica = new DAO_UsuariosPracticas();
        $_objUsuarioPractica->set_id_practica($id_practica);
        $_objUsuarioPractica->consultar();
        $estadoPractica = $_objUsuarioPractica->get_estado_practica();
        if ($estadoPractica != 3) {
            throw new ControllerException("La practica debe estar en estado 'Entrega'");
        }
        $_objArchivoSe = new DAO_RelArchivosSeguimiento();
        $id_archivo = NULL;
        if (!empty($id_seg_arch)) {// modificar el archivo subido
            $_objArchivoSe->set_id_seg_arc($id_seg_arch);
            $_objArchivoSe->consultar();
            $id_archivo = $_objArchivoSe->get_id_archivos();
        }
        $_objArchivoSe->set_id_entre_lp($id_entrega_lp);
        try {
            $this->_validarArchivo($file);
            $_objArchivo = $this->_guardarArchivo($file, $id_archivo);
        } catch (ControladorArchivosException $e) {
            throw new ControllerException($e->getMessage());
        }
        $arrSeguimiento = $this->_agregarSeguimiento($id_practica, $titulo);
        $_objArchivoSe->set_id_archivos($_objArchivo->get_id_archivo());
        $_objArchivoSe->set_id_segui($arrSeguimiento['id_segui']);
        $_objArchivoSe->set_estado_archivo(1);
        if (!$_objArchivoSe->guardar()) {
            $this->_mensaje = $_objArchivoSe->getMysqlError();
            throw new ControllerException("No se pudo actualizar vinculacion de archivo a practica");
        }
        $this->_guardarLog($_SESSION['id_usu_cent'], ['accion' => 'insertar', 'metodo' => get_class() . ':_agregarArchivosEntregaPractica', 'parametros' => ['file' => $file['name'], 'id_arch_lp' => $id_arch_lp, 'id_practica' => $id_practica, 'titulo' => $titulo, 'id_seg_arch' => $id_seg_arch]]);
        return $_objArchivoSe->getArray();
    }

    /**
     * Agregar un seguimiento a una practica donde un estudiante ya se ha inscrito
     * @param type $id_practica
     * @param type $titulo
     * @param type $id_segui (opcional) id del seguimiento para actualizar
     * @param type $id_lp_seg (opcional) id de programacion de seguimiento
     * @return array
     * @throws ControllerException
     */
    private function _agregarSeguimiento($id_practica, $titulo, $id_segui = NULL, $id_lp_seg = NULL) {
        $_objUsuPractica = new DAO_UsuariosPracticas(); // DAO de practicas del usuario
        $_objUsuPractica->set_id_practica($id_practica);
        $_objUsuPractica->consultar();
        $estado = $_objUsuPractica->get_estado_practica(); // el estado del seguimiento es el estado actual de la practica
        $_objSeguimiento = new DAO_Seguimientos();
        if (!empty($id_segui)) {
            $_objSeguimiento->set_id_segui($id_segui);
            $_objSeguimiento->consultar();
            $estado = $_objSeguimiento->get_segui_tipo(); // no puede actualizar el tipo de seguimiento 
        }
        $_objSeguimiento->set_id_practica($id_practica);
        $_objSeguimiento->set_segui_titulo($titulo);
        $_objSeguimiento->set_segui_tipo($estado);
        $_objSeguimiento->set_id_usu_cent($_SESSION['id_usuario']);
        if (!$_objSeguimiento->guardar()) {
            $this->_mensaje = $_objSeguimiento->getMysqlError();
            throw new ControllerException("No se pudo guardar seguimiento ", 0);
        }
        if (!empty($id_lp_seg)) {
            $_objProgramacionSeg = new DAO_ConfLineasPracticaSeguimiento();
            $_objProgramacionSeg->set_id_lp_seg($id_lp_seg);
            $_id_usu_cp_solicitado = $_objProgramacionSeg->get_id_usu_cp();
            if($_id_usu_cp_solicitado != $_SESSION['id_usu_cp']){
                throw new ControllerException("usted no es el usuario que debe generar éste seguimiento");
            }
            $_objProgramacionSeg->set_id_segui($_objSeguimiento->get_id_segui());
            if (!$_objProgramacionSeg->guardar()) {
                $this->_mensaje = $_objSeguimiento->getMysqlError();
                throw new ControllerException("No se pudo relacionar seguimiento actual con el seguimiento programado", 0);
            }
        }
        $this->_guardarLog($_SESSION['id_usu_cent'], ['accion' => 'insertar', 'metodo' => get_class() . ':_agregarSeguimiento', 'parametros' => ['id_practica' => $id_practica, 'titulo' => $titulo, 'id_segui' => $id_segui, 'id_lp_seg' => $id_lp_seg]]);
        return $_objSeguimiento->getArray();
    }
    /**
     * Consultar la configuracion de lineas de practica
     * @param type $id_conf_linea
     * @return type
     * @throws ControllerException
     */
    private function _consultarConfiguracionLineaPractica($id_conf_linea = NULL,$cf_linea_practica = NULL) {
        $_objConf_LP = new DAO_ConfLineasPractica();
        $_objConf_LP->habilita1ResultadoEnArray();
        if(!empty($id_conf_linea))
            $_objConf_LP->set_id_conf_linea ($id_conf_linea);
        if(!empty($cf_linea_practica))
            $_objConf_LP->set_cf_linea_practica ($cf_linea_practica);
        if(!$arr_obj = $_objConf_LP->consultar()){
            $this->_mensaje = $_objConf_LP->getMysqlQuery();
            throw new ControllerException("No se encontraron elementos");
        }
        $R = [];
        foreach($arr_obj as $obj){
            if($obj instanceof DAO_ConfLineasPractica){
                $_objArchivos = new DAO_ConfLineasPracticaArchivos();
                $_objArchivos->habilita1ResultadoEnArray();
                $_objArchivos->set_id_conf_linea($obj->get_id_conf_linea());
                $arr_objArchivos = $_objArchivos->consultar();
                //echo $_objArchivos->getMysqlQuery();
                $RA = [];
                if(is_array($arr_objArchivos) && count($arr_objArchivos) > 0){
                    foreach($arr_objArchivos as $objA){
                        if($objA instanceof DAO_ConfLineasPracticaArchivos){
                            $RA[] = $objA->getArray();
                        }
                    }
                }
                $R[] = array_merge($obj->getArray(),['archivos' => $RA]);
            }
        }
        $this->_ok = 1;
        $this->_mensaje = "elementos encontrados";
        return $R;
    }

    /**
     * Guardar configuracion de linea de practiva (super admin)
     * @param type $nombreLP
     * @param type $estado
     * @param type $archivos
     * @param type $idConfLinea
     * @return type
     * @throws ControllerException
     */
    private function _agregarConfiguracionLineaPractica($nombreLP, $estado, $archivos,$linea_practica, $idConfLinea = NULL) {
        //print_r($_POST);die();
        $_objConf = new DAO_ConfLineasPractica();
        if (!empty($idConfLinea)) {
            $_objConf->set_id_conf_linea($idConfLinea);
            $_objarchivosConf = new DAO_ConfLineasPracticaArchivos();
            $_objarchivosConf->set_id_conf_linea($idConfLinea);
            $_objarchivosConf->eliminar(); // elminar requisitos de archivos que se agregaran de nuevo abajo
        }
        $_objConf->set_cf_nombre($nombreLP);
        $_objConf->set_cf_estado($estado);
        $_objConf->set_cf_linea_practica($linea_practica);
        $_objConf->guardar();
        //print_r($_objConf);
        // almacenar los requisitos de archivos 
        if (!empty($archivos)) {
            $_arrTipoArchivos = $archivos;//explode(",", $archivos);
            for ($i = 0; $i < count($_arrTipoArchivos); $i++) {
                $_objarchivosConf = new DAO_ConfLineasPracticaArchivos();
                $_objarchivosConf->set_id_conf_linea($_objConf->get_id_conf_linea());
                $_objarchivosConf->set_id_tipo_archivo($_arrTipoArchivos[$i]);
                if (!$_objarchivosConf->guardar()) {
                    $this->_mensaje = $_objarchivosConf->getMysqlError();
                    throw new ControllerException("No se pudo crear una línea de practica", 0);
                }
            }
        }
        $this->_guardarLog($_SESSION['id_usu_cent'], ['accion' => 'insertar', 'metodo' => get_class() . ':_agregarConfiguracionLineaPractica', 'parametros' => ['$nombreLP' => $nombreLP, 'estado' => $estado, 'archivos' => $archivos, 'idConfLinea' => $idConfLinea]]);
        $this->_ok = 1;
        $this->_mensaje = "Guardada configuración de línea correctamente";
        return $_objConf->getArray();
    }
    /**
     * 
     * @param type $id_conf_linea null: listar las lineas del usuarios logueado. -1 listar todo
     * @param type $solo_activos
     * @return type
     */
    private function _consultarLineasPractica($id_conf_linea = null,$solo_activos = true) {
        $_objLineaPractica = new DAO_LineasPractica();
        $_objLineaPractica->habilita1ResultadoEnArray();
        if(!empty($id_conf_linea) && $id_conf_linea != -1) {
            $_objLineaPractica->set_id_conf_linea($id_conf_linea);
        }elseif (empty($id_conf_linea)) {
            if(cprogresa\RolesBit::getAcceso(cprogresa\RolesBit::ADMIN_LINEA(),$_SESSION['rol_bit_a_bit'])){
                $_objConfLinea = new DAO_ConfLineasPractica();
                $_objConfLinea->habilita1ResultadoEnArray();
                $_objConfLinea->set_cf_linea_practica($_SESSION['cf_linea_practica']);
                $arrConfLinea = $_objConfLinea->consultar();
                //print_r($arrConfLinea);
                if(is_array($arrConfLinea) && count($arrConfLinea) > 0){
                    $arridConfLinea = [];
                    foreach($arrConfLinea as $objCL){
                        if($objCL instanceof DAO_ConfLineasPractica){
                            $arridConfLinea[] = $objCL->get_id_conf_linea();
                        }
                    }
                    $_objLineaPractica->set_id_conf_linea($arridConfLinea);
                }
            }elseif(cprogresa\RolesBit::getAcceso(cprogresa\RolesBit::ESTUDIANTE(),$_SESSION['rol_bit_a_bit'])){
                //print_r($_SESSION);
                if(!$_arrLP = $_objLineaPractica->consultarPorProgramaFacultadSede($_SESSION['cm_programa'],$_SESSION['cm_facultad'], $_SESSION['cm_id_sede'])){
                    $this->_mensaje = $_objLineaPractica->getMysqlQuery();
                    throw new ControllerException("No es posible inscribirse a una practica profesional pues no se encontraron elementos", 0);
                }
                $_objLineaPractica->set_id_linea($_arrLP);
            }else{
                $_objLineaPractica->set_id_usu_cp($_SESSION['id_usu_cp']);
            }
        }
        if($solo_activos == true)
            $_objLineaPractica->set_ln_estado (1);
        $arrElem = $_objLineaPractica->consultar();
        //print_r($_objLineaPractica);
        //echo "|".$_objLineaPractica->getMysqlQuery();
        if(is_array($arrElem) && count($arrElem) > 0){
            $R = [];
            foreach($arrElem as $obj){
                $R[] = $obj->getArray();
            }
            $this->_ok = 1;
            $this->_mensaje = "Elementos encontrados";
            return $R;
        }
        $this->_ok = 0;
        $this->_mensaje = "no se encontraron elementos";
        return null;
    }

    /**
     * Agregar una practica (empresa/admin linea)
     * @param type $ln_titulo
     * @param type $ln_desc
     * @param type $id_facultad
     * @param type $id_programa
     * @param type $id_usu_cp
     * @param type $id_linea
     * @param type $id_empre
     * @return type
     * @throws ControllerException
     */
    private function _agrergarLineaPractica($ln_titulo, $ln_desc,$id_facultad,$id_programa, $id_usu_cp,$id_conf_linea,$id_linea = NULL,$id_empre = null) {
        // consultar la linea de practica del coordiandor
        /*$_objUsuarios = new cprogresa\DAO_Usuarios();
        $_objUsuarios->set_id_usu_cp($id_usu_cp);
        $_objUsuarios->consultar();
        */
       //print_r($_POST);die();
        $_objLP = new DAO_LineasPractica();
        if (!empty($id_linea)) {
            $_objLP->set_id_linea($id_linea);
        }
        if (!empty($id_empre)) {
            $_objLP->set_id_emp($id_empre);
        }
        $_objLP->set_id_usu_cp($id_usu_cp);
        $_objLP->set_ln_titulo($ln_titulo);
        $_objLP->set_ln_desc($ln_desc);
        $_objLP->set_id_conf_linea($id_conf_linea);
        $_objLP->set_id_facultad(is_array($id_facultad) ? implode(",",$id_facultad) : $id_facultad);
        $_objLP->set_id_programa(is_array($id_programa) ? implode(",",$id_programa) : $id_programa );
        if (!$_objLP->guardar()) {
            $this->_mensaje = $_objLP->getMysqlError();
            throw new ControllerException("No se pudo crear una línea de practica. ", 0);
        }

        // almacenar configuracion generada por el admin de linea
        $this->_guardarLog($_SESSION['id_usu_cent'], ['accion' => 'agregar seguimiento', 'metodo' => get_class() . ':_agregarConfiguracionLineaPractica', 'parametros' => ['ln_titulo'=>$ln_titulo,'ln_desc'=>$ln_desc,'id_facultad'=>$id_facultad,'id_programa'=>$id_programa,'id_usu_cp'=>$id_usu_cp,'id_linea'=>$id_linea,'id_empre'=>$id_empre]]);
        $this->_ok = 1;
        $this->_mensaje = "Se ha agregado una linea exitosamente";
        return $_objLP->getArray();
    }
    /**
     * Hacer consulta de calendario de seguimientos
     * @param type $_id_linea
     * @return type
     * @throws ControllerException
     */
    private function _consultaConfLineaPracticaSeguimiento($_id_linea) {
        $_objConSeguimiento = new DAO_ConfLineasPracticaSeguimiento();
        $_objConSeguimiento->habilita1ResultadoEnArray();
        $_objConSeguimiento->set_id_linea($_id_linea);
        if(!$arrElemSegui = $_objConSeguimiento->consultar()){
            $this->_mensaje = $_objConSeguimiento->getMysqlError();
            throw new ControllerException("No se encontraron registros. ", 0);
        }
        $R = [];
        foreach($arrElemSegui as $objCalSegui){
            $R[] = $objCalSegui->getArray();
        }
        $this->_ok = 1;
        $this->_mensaje = "Calendario de seguimientos de practica encontrados";
        return $R;
    }

    /**
     * 
     * @param type $idLinea
     * @param type $fechaSeg
     * @param type $idLpSeg
     * @return type
     * @throws ControllerException
     */
    private function _agregarConfLineaPracticaSeguimiento($idLinea, $idUsuCp, $fechaSeg, $idLpSeg = NULL) {
        $_objConSeguimiento = new DAO_ConfLineasPracticaSeguimiento();
        $_objConSeguimiento->set_id_linea($idLinea);
        $_objConSeguimiento->set_id_usu_cp($idUsuCp);
        $_objConSeguimiento->set_fecha_seguimienti($fechaSeg);
        if (!empty($idLpSeg)) {
            $_objConSeguimiento->set_id_lp_seg($idLpSeg);
        }
        if (!$_objConSeguimiento->guardar()) {
            $this->_mensaje = $_objConSeguimiento->getMysqlError();
            throw new ControllerException("No se pudo agregar configuracion de seguimiento", 0);
        }
        $this->_guardarLog($_SESSION['id_usu_cent'], ['accion' => 'insertar', 'metodo' => get_class() . ':_agregarConfLineaPracticaSeguimiento', 'parametros' => ['$idLinea' => $idLinea, 'idUsuCp' => $idUsuCp, 'fechaSeg' => $fechaSeg, 'idLpSeg' => $idLpSeg]]);
        $this->_ok = 0;
        $this->_mensaje = "";
        return $_objConSeguimiento->getArray();
    }

    /**
     * 
     * @param type $idConfLinea
     * @param type $jsonEntrega
     * @return type
     * @throws ControllerException
     */
    private function _agregarConfLineaPracticaEntrega($idLinea, $idRol, $idconfLEntrega = NULL) {
        $_objConfLinea = new DAO_ConfLineasPracticaEntrega();
        $_objConfLinea->set_id_linea($idLinea);
        $_objConfLinea->set_id_rol($idRol);
        if (!empty($idconfLEntrega)) {
            $_objConfLinea->set_id_entre_lp($idconfLEntrega);
        }
        if (!$_objConfLinea->guardar()) {
            $this->_mensaje = $_objConfLinea->getMysqlError();
            throw new ControllerException("No se pudo actualizar configuracion de entraga para la linea de practica seleccionada", 0);
        }
        $this->_guardarLog($_SESSION['id_usu_cent'], ['accion' => 'insertar', 'metodo' => get_class() . ':_agregarConfLineaPracticaEntrega', 'parametros' => ['idLinea' => $idLinea, 'idRol' => $idRol, 'idconfLEntrega' => $idconfLEntrega]]);
        $this->_ok = 1;
        $this->_mensaje = "El elemento de configuracion de entrega ha sido agregado con exito";
        return $_objConfLinea->getArray();
    }
    /**
     * 
     * @param type $linea
     * @param type $id_usu_cp
     * @param type $id_sede
     * @param type $estado
     * @return type
     * @throws ControllerException
     */
    private function _consultarUsuariosPractica($linea = null,$id_usu_cp = null,$id_sede = null,$estado = 1) {
        $_objPracticas = new DAO_UsuariosPracticas();
        $_objPracticas->habilita1ResultadoEnArray();
        if(!empty($linea))
            $_objPracticas->set_id_linea ($linea);
        if(!empty($id_usu_cp))
            $_objPracticas->set_id_usu_cp ($id_usu_cp);
        if(!empty($id_sede))
            $_objPracticas->set_id_sede ($id_sede);
        if(!empty($estado))
            $_objPracticas->set_estado_practica ($estado);
        $arrElem = $_objPracticas->consultar();
        if(is_array($arrElem) && count($arrElem) > 0){
            $R = [];
            foreach($arrElem as $obj){
                $R[] = $obj->getArray();
            }
            $this->_ok = 1;
            $this->_mensaje = "Elementos encontrados";
            return $R;
        }
        $this->_mensaje = $_objPracticas->getMysqlError();
        throw new ControllerException("No se encontro",0);
    }
    /**
     * Eliminar registros de estudiantes vinculados a practicas
     * @param type $id_linea
     * @param type $id_usu_cp
     * @return boolean
     * @throws ControllerException
     */
    private function _eliminarUsuario_a_Practica($id_linea,$id_usu_cp = NULL) {
        $_objPracticas = new DAO_UsuariosPracticas();
        $_objPracticas->set_id_linea($id_linea);
        if(empty($id_usu_cp)){
            $id_usu_cp = $_SESSION['id_usu_cp'];
        }
        $_objPracticas->set_id_usu_cp($id_usu_cp);
        $_objPracticas->consultar();
        $estado = $_objPracticas->get_estado_practica();
        if($estado != 1) {
            throw new ControllerException("La practica no se encuentra en estado postulado. No puede desligarse.",0);
        }
        if(!$_objPracticas->eliminar()){
            $this->_mensaje = $_objPracticas->getMysqlError();
            throw new ControllerException("No se pudo eliminar registro",0);
        }
        $this->_ok = 1;
        $this->_mensaje = "Te has desvinculado de la practica";
        return true;
    }

    /**
     * 
     * @param type $id_linea
     * @param type $id_usu
     * @param type $estado_practica (opcional)
     * @param type $id_practica (opcional)
     * @return array
     * @throws ControllerException
     */
    private function _agregarUsuario_a_Practica($id_linea, $id_usu = NULL,  $estado_practica = null, $id_practica = NULL) {
        //print_r($_SESSION);
        //die();
        $_objPracticas = new DAO_UsuariosPracticas();
        if (!empty($id_practica)) {
            $_objPracticas->set_id_practica($id_practica);
            $_objPracticas->consultar();
        }
        $_objPracticas->set_id_linea($id_linea);
        $_objPracticas->set_id_usu_cp($id_usu);
        if(empty($id_usu))
            $_objPracticas->set_id_usu_cp($_SESSION['id_usu_cp']);
        $_objPracticas->set_id_sede($_SESSION['cm_id_sede']);
        
        // validar el estado
        switch ($estado_practica) {
            case 2:// seleccionado: validar que ha cumplido con los documentos y estos estan validados      
                $_objLineaPractica = new DAO_LineasPractica();
                $_objLineaPractica->set_id_linea($id_linea);
                $_objLineaPractica->consultar();
                $objSeguimiento = new DAO_RelArchivosSeguimiento();
                $estadoDocumentosVinculados = $objSeguimiento->estadoElementosArchivosVinculacion($_objLineaPractica->get_id_conf_linea());
                if ($estadoDocumentosVinculados != 2) {
                    throw new ControllerException("Los archivos de requisito no estan completos o no estan todos aprobados. No se puede cambiar el estado de la practica", 0);
                }
                break;
            case 3:// entrega
                if (empty($id_practica)) {
                    throw new ControllerException("No ha definido la practica a cambiar", 0);
                }
                $estado = $_objPracticas->get_estado_practica();
                if ($estadoPractica == 1 || $estadoPractica == 4) {
                    // para cambiar el estado de la practica a 3 (entrega) debe estar en estado 2 (seguimiento)
                    throw new ControllerException("Para cambiar el estado de la practica debe estar en Seguimiento", 0);
                }
                break;
            case 4:
                if (empty($id_practica)) {
                    throw new ControllerException("No ha definido la practica a cambiar", 0);
                }
                $estado = $_objPracticas->get_estado_practica();
                if ($estadoPractica == 1 || $estadoPractica == 2) {
                    // para cambiar el estado de la practica a 4 (Terminado) debe estar en estado 3 (entrega)
                    throw new ControllerException("Para cambiar el estado de la practica debe estar en Seguimiento", 0);
                }
                break;
        }
        $_objPracticas->set_estado_practica($estado_practica);
        if (!$_objPracticas->guardar()) {
            throw new ControllerException("No se pudo registrar en la practica", 0);
        }
        $this->_guardarLog($_SESSION['id_usu_cent'], ['accion' => 'insertar', 'metodo' => get_class() . ':_agregarUsuario_a_Practica', 'parametros' => ['id_linea' => $id_linea, 'id_usu' => $id_usu, 'id_sede' => $_SESSION['cm_id_sede'], 'estado_practica' => $estado_practica, 'id_practica' => $id_practica]]);
        $this->_ok = 1;
        $this->_mensaje = "";
        return $_objPracticas->getArray();
    }

    /**
     * 
     * @param type $nombreLineas
     * @param type $idNombreLinea
     * @param type $borrar
     * @return type
     * /
      private function _agregarNombresLineasPractica($nombreLineas, $idNombreLinea = NULL, $borrar = NULL) {
      return $this->_agregarModificarListas(3,$nombreLineas,$idNombreLinea,$borrar);
      }

      /**
     * ingresar informacion en maestro de tablas 2
     * @param type $nombreArchivo
     * @param type $idnombreArchivo
     * @param type $borrar
     */
    private function _agregarListaArchivos($nombreArchivo, $descArchivo, $idNombreArchivo = NULL, $borrar = false) {
        if ($borrar != FALSE) {
            $_objConfPA = new DAO_ConfLineasPracticaArchivos();
            $_objConfPA->set_id_tipo_archivo($idNombreArchivo);
            if ($_objConfPA->existenRegistrosRelacionados() > 0) {
                throw new ControllerException("No se puede eliminar elemento porque esta siendo utilizado en la configuración de una o más lineas de práctica");
            }
        }
        $this->_ok = 1;
        $this->_mensaje = $borrar == 1 ? "Elemento borrado con exito" : "Elemento agregado con exito";
        $id = $this->_agregarModificarListas(2, $nombreArchivo, $idNombreArchivo, $borrar);
        $this->_agregarModificarListas(6, $descArchivo, $idNombreArchivo, $borrar);
        return $id;
    }
    /**
     * 
     * @param type $id_practica
     * @return type
     * @throws ControllerException
     */
    private function _consultarConfListaArchivosPractica($id_practica ) {
        $_objLP = new DAO_UsuariosPracticas();
        $_objLP->set_id_practica($id_practica);
        //$_objLP->set_id_linea($id_linea);
        //$_objLP->set_id_usu_cp($_SESSION['id_usu_cp']);
        if(!$_objLP->consultar()){
            throw new ControllerException("El estudiante no esta inscrito en esta practica o no se encontró practica");
        }
        // lista de seguimientos
        $_objSeguim = new DAO_Seguimientos();
        $_objSeguim->habilita1ResultadoEnArray();
        $arrSeguimientos = null;
        if( $arrObjSegui = $_objSeguim->set_id_practica($id_practica) ){
            foreach($arrObjSegui as $objSeg){
                if($objSeg instanceof DAO_Seguimientos){
                    $arrSeguimientos[] = $objSeg->get_id_segui();
                }
            }
        }
        // lista de los archivos
        $_objConfLinea = new DAO_ConfLineasPracticaArchivos();
        $_objConfLinea->habilita1ResultadoEnArray();
        $_objConfLinea->set_id_conf_linea( $_objLP->get_id_conf_linea() );
        if(!$arrConfLinPArchivos = $_objConfLinea->consultar()){
            $this->_mensaje = $_objConfLinea->getMysqlError();
            throw new ControllerException("No se encontró una plantilla de línea de practica para esta practica",0);
        }
        $R = [];
        foreach($arrConfLinPArchivos as $_objCnfLP){
            if($_objCnfLP instanceof DAO_ConfLineasPracticaArchivos){
                // consultar si el archivo esta subido
                $_objArchivosSegui = new DAO_RelArchivosSeguimiento();
                $_objArchivosSegui->set_id_arch_lp($_objCnfLP->get_id_arch_lp());
                $_objArchivosSegui->set_id_segui($arrSeguimientos);
                $_objArchivosSegui->consultar();
                $R[] = array_merge($_objCnfLP->getArray(),$_objArchivosSegui->getArray());
            }
        }
        $this->_ok = 1;
        $this->_mensaje = "Lista de archivos encontrados";
        return $R;
    }

    /**
     * Consulta de lista de archivos y su descripcion
     * @return type
     */
    private function _consultarListaArchivos() {
        $_objMTablas = new \cprogresa\MTablas();
        $tabla2 = $_objMTablas->getTablaCheckBox(2);
        $tabla6 = $_objMTablas->getTablaCheckBox(6);
        //print_r($tabla2);
        //print_r($tabla6);
        $R = [];
        foreach ($tabla2 as $id => $valor) {
            $R[] = ['id' => $id, 'archivo' => $valor, 'descripcion' => $tabla6[$id]];
        }
        $this->_ok = 1;
        $this->_mensaje = "Lista de archivos";
        $this->_guardarLog($_SESSION['id_usu_cent'], ['accion' => 'consulta', 'metodo' => get_class() . ':_consultarListaArchivos', 'parametros' => '']);
        return $R;
    }

    /**
     * 
     * @param type $id_tbl
     * @param type $valor_nombre
     * @param type $valor_valor
     * @param type $borrar
     * @return boolean
     * @throws ControllerException
     */
    private function _agregarModificarListas($id_tbl, $valor_nombre, $valor_valor = NULL, $borrar = NULL) {
        $_objMT = new \cprogresa\MTablas();
        $id = NULL;
        try {
            if ($borrar && $valor_valor != NULL) {
                $_objMT->eliminarRegistro($id_tbl, $valor_valor);
            } else {
                $id = $_objMT->insertarRegistro($id_tbl, $valor_nombre, $valor_valor);
            }
        } catch (\cprogresa\MTablasException $e) {
            throw new ControllerException($e->getMessage());
        }
        $this->_guardarLog($_SESSION['id_usu_cent'], ['accion' => 'insertar', 'metodo' => get_class() . ':_agregarModificarListas', 'parametros' => ['id_tbl' => $id_tbl, 'valor_nombre' => $valor_nombre, 'valor_valor' => $valor_valor, 'borrar' => $borrar, 'valor_valor' => $id]]);
        return $id;
    }

}

class ControllerException extends Exception {
    
}

Controller::run();
