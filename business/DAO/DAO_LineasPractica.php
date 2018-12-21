<?php

include_once 'class.DAO.php';

class DAO_LineasPractica extends \cprogresa\DAOGeneral {

    protected $_id_linea;
    protected $_ln_titulo;
    protected $_ln_desc;
    protected $_id_conf_linea;
    protected $_strConfLineaNombre; // nombre plantilla linea practica
    protected $_strLineaPractica;//nombre linea de practica
    protected $_id_emp;
    protected $_ln_fec_crea;
    protected $_id_usu_cp;// id_del coordinador
    protected $_strUsuNombre;// nombre del coordinador
    protected $_ln_estado;
    protected $_id_facultad;
    protected $_id_programa;
    protected $_strFacultad;
    protected $_strPrograma;
    protected $_strEstadoAplicado;
    protected $_estadoAplicado;
    protected $_id_practica;


    protected $_tabla = 'lineas_practica';
    protected $_primario = 'id_linea';
    protected $_mapa = array(
        'id_linea' => array('tipodato' => 'integer'),
        'ln_titulo' => array('tipodato' => 'varchar'),
        'ln_desc' => array('tipodato' => 'varchar'),
        'id_conf_linea' => array('tipodato' => 'integer'),
        'strConfLineaNombre' => array('tipdato' => 'varchar','sql' => '(SELECT cf_nombre FROM conf_lineas_practica a WHERE a.id_conf_linea = lineas_practica.id_conf_linea )'),// nombre plantilla linea practica
        'strLineaPractica' => array('tipodato' => 'varchar','sql' => '(SELECT valor_nombre FROM conf_lineas_practica a, maestro_contenido m WHERE m.id_maestro = 7 AND a.id_conf_linea = lineas_practica.id_conf_linea AND cf_linea_practica = valor_valor)'),
        'id_emp' => array('tipodato' => 'integer'),
        'ln_fec_crea' => array('tipodato' => 'date'),
        'ln_estado' => array('tipodato' => 'integer'),
        'id_usu_cp' => array('tipodato' => 'integer'),// usuario coordiandor de la practica
        'strUsuNombre' => array('tipodato' => 'varchar','sql' => '(SELECT CONCAT(u_nombres," ",u_apellidos) FROM uvd_cprogresa.roles aa,uvd_cprogresa.usuarios a,uvd_usuarios.usuarios_central b WHERE a.id_usu_cent = b.id_usu_cent AND aa.id_rol = a.id_rol AND a.id_usu_cp = lineas_practica.id_usu_cp)'),
        'id_facultad' => array('tipodato' => 'varchar'),
        'id_programa' => array('tipodato' => 'varchar'),
        'strFacultad' => array('tipdato' => 'varchar','sql' => '(SELECT CONCAT("[",GROUP_CONCAT(CONCAT("{\"",valor_valor,"\":\"",valor_nombre,"\"}") ),"]") FROM uvd_usuarios.maestro_contenido WHERE id_maestro = 9 AND valor_estado = 1 AND valor_valor REGEXP (CONCAT("^(",REPLACE(id_facultad,",","|"),")$") ) )'),
        'strPrograma' => array('tipodato' => 'varchar','sql' => '(SELECT CONCAT("[",GROUP_CONCAT(CONCAT("{\"",valor_valor,"\":\"",valor_nombre,"\"}") ),"]")  FROM uvd_usuarios.maestro_contenido WHERE id_maestro = 1 AND valor_estado = 1 AND valor_valor REGEXP (  CONCAT("^(",REPLACE(id_programa,",","|"),")$"  ) ) )'),
        'estadoAplicado' => array('tipodato' => 'integer'),
        'strEstadoAplicado' => array('tipodato' => 'integer'),
        'id_practica' => array('tipodato' => 'integer')
    );
    
    public function __construct() {
        $this->_mapa['estadoAplicado']['sql'] = "(SELECT estado_practica FROM rel_usuarios_practicas a WHERE a.id_linea = lineas_practica.id_linea AND id_usu_cp = {$_SESSION['id_usu_cp']})";
        $this->_mapa['strEstadoAplicado']['sql'] = "(SELECT valor_nombre FROM rel_usuarios_practicas a,maestro_contenido b WHERE a.id_linea = lineas_practica.id_linea AND b.id_maestro = 4 AND valor_valor = estado_practica AND id_usu_cp = {$_SESSION['id_usu_cp']})";
        $this->_mapa['id_practica']['sql'] = "(SELECT id_practica FROM rel_usuarios_practicas a WHERE a.id_linea = lineas_practica.id_linea AND id_usu_cp = {$_SESSION['id_usu_cp']})";
        parent::__construct();
    }

    function get_id_linea() {
        return $this->_id_linea;
    }

    function get_ln_titulo() {
        return $this->_ln_titulo;
    }

    function get_ln_desc() {
        return $this->_ln_desc;
    }

    function get_id_conf_linea() {
        return $this->_id_conf_linea;
    }

    function get_id_emp() {
        return $this->_id_emp;
    }

    function set_id_linea($_id_linea) {
        $this->_id_linea = $_id_linea;
    }

    function set_ln_titulo($_ln_titulo) {
        $this->_ln_titulo = $_ln_titulo;
    }

    function set_ln_desc($_ln_desc) {
        $this->_ln_desc = $_ln_desc;
    }

    function set_id_conf_linea($_id_conf_linea) {
        $this->_id_conf_linea = $_id_conf_linea;
    }

    function set_id_emp($_id_emp) {
        $this->_id_emp = $_id_emp;
    }
    function get_ln_fec_crea() {
        return $this->_ln_fec_crea;
    }

    function get_ln_estado() {
        return $this->_ln_estado;
    }

    function set_ln_fec_crea($_ln_fec_crea) {
        $this->_ln_fec_crea = $_ln_fec_crea;
    }

    function set_ln_estado($_ln_estado) {
        $this->_ln_estado = $_ln_estado;
    }
    function get_id_usu_cp() {
        return $this->_id_usu_cp;
    }

    function set_id_usu_cp($_id_usu_cp) {
        $this->_id_usu_cp = $_id_usu_cp;
    }

    function get_id_facultad() {
        return $this->_id_facultad;
    }

    function get_id_programa() {
        return $this->_id_programa;
    }

    function set_id_facultad($_id_facultad) {
        $this->_id_facultad = $_id_facultad;
    }

    function set_id_programa($_id_programa) {
        $this->_id_programa = $_id_programa;
    }
    function get_strFacultad() {
        return $this->_strFacultad;
    }

    function get_strPrograma() {
        return $this->_strPrograma;
    }

    function set_strFacultad($_strFacultad) {
        $this->_strFacultad = $_strFacultad;
    }

    function set_strPrograma($_strPrograma) {
        $this->_strPrograma = $_strPrograma;
    }
    function get_strConfLineaNombre() {
        return $this->_strConfLineaNombre;
    }

    function set_strConfLineaNombre($_strConfLineaNombre) {
        $this->_strConfLineaNombre = $_strConfLineaNombre;
    }

    function get_strLineaPractica() {
        return $this->_strLineaPractica;
    }

    function set_strLineaPractica($_strLineaPractica) {
        $this->_strLineaPractica = $_strLineaPractica;
    }

    function get_strUsuNombre() {
        return $this->_strUsuNombre;
    }

    function set_strUsuNombre($_strUsuNombre) {
        $this->_strUsuNombre = $_strUsuNombre;
    }
    function get_strEstadoAplicado() {
        return $this->_strEstadoAplicado;
    }

    function get_estadoAplicado() {
        return $this->_estadoAplicado;
    }

    function set_strEstadoAplicado($_strEstadoAplicado) {
        $this->_strEstadoAplicado = $_strEstadoAplicado;
    }

    function set_estadoAplicado($_estadoAplicado) {
        $this->_estadoAplicado = $_estadoAplicado;
    }

        /**
     * Consultar las lineas de practica por los filtros
     * @param type $id_programa
     * @param type $id_facultad
     * @param type $u_sede
     * @return boolean
     */
    function consultarPorProgramaFacultadSede($id_programa,$id_facultad,$u_sede){
        $query = "SELECT id_linea FROM (SELECT p.id_linea,c.u_sede,json_search(CONCAT('[\"',REPLACE(id_programa,',','\",\"') ,'\"]'),'all','$id_programa' ) programa,json_search(CONCAT('[\"',REPLACE(id_facultad,',','\",\"') ,'\"]'),'all','$id_facultad' ) facultad FROM lineas_practica p, usuarios u,uvd_usuarios.usuarios_central c WHERE p.id_usu_cp = u.id_usu_cp AND u.id_usu_cent = c.id_usu_cent) tbl WHERE programa IS NOT NULL AND facultad IS NOT NULL AND u_sede = $u_sede";
        $con = \cprogresa\ConexionSQL::getInstance();
        $this->_mysqlQuery = $query;
        if(!$id = $con->consultar($query)){
            $this->_mysqlErrno = $con->obtenerErrno();
            return false;
        }
        $arrIdLinea = [];
        $res = $con->obenerFila($id);
        do{
           $arrIdLinea[] = $res['id_linea'];
        }while($res = $con->obenerFila($id));
        return $arrIdLinea;
        /*$obj = new self();
        $obj->set_id_linea($arrIdLinea);
        $obj->habilita1ResultadoEnArray();
        return $obj->consultar();*/
    }
    
    function get_id_practica() {
        return $this->_id_practica;
    }

    function set_id_practica($_id_practica) {
        $this->_id_practica = $_id_practica;
    }





}
