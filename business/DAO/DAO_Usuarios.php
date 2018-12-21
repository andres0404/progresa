<?php
namespace cprogresa;
include_once 'class.DAO.php';

class DAO_Usuarios extends \cprogresa\DAOGeneral {

    protected $_id_usu_cp;
    protected $_id_usu_cp_crea;
    protected $_id_usu_cent;
    protected $_id_rol;
    protected $_id_emp;
    protected $_cf_linea_practica;
    protected $_strLineaPractica;
    protected $_strRol;
    protected $_strNombres;
    protected $_strApellidos;
    protected $_strIdGenesis;
    protected $_u_sede;
    protected $_strSede;

    protected $_tabla = 'usuarios';
    protected $_primario = 'id_usu_cp';
    
    protected $_mapa = array(
        'id_usu_cp' => array('tipodato' => 'integer'),
        'id_usu_cent' => array('tipodato' => 'integer'),
        'id_rol' => array('tipodato' => 'integer'),
        'id_emp' => array('tipodato' => 'integer'),
        'cf_linea_practica' => array('tipodato' => 'integer'),
        'id_usu_cp_crea' => array('tipodato' => 'integer'),
        'strLineaPractica' => array('tipodato' => 'varchar','sql' => '(SELECT valor_nombre FROM maestro_contenido WHERE id_maestro = 7 AND valor_valor = cf_linea_practica )'),
        'strRol' => array('tipodato' => 'varchar','sql' => '(SELECT nom_rol FROM roles WHERE roles.id_rol = usuarios.id_rol)'),
        'strNombres' => array('tipodato' => 'varchar','sql' => '(SELECT u_nombres FROM uvd_usuarios.usuarios_central us WHERE us.id_usu_cent = usuarios.id_usu_cent)'),
        'strApellidos' => array('tipodato' => 'varchar','sql' => '(SELECT u_apellidos FROM uvd_usuarios.usuarios_central us WHERE us.id_usu_cent = usuarios.id_usu_cent)'),
        'strIdGenesis' => array('tipodato' => 'varchar','sql' => '(SELECT u_id_genesis FROM uvd_usuarios.usuarios_central us WHERE us.id_usu_cent = usuarios.id_usu_cent)'),
        'u_sede' => array('tipodato' => '','sql' => '(SELECT u_sede FROM uvd_usuarios.usuarios_central us WHERE us.id_usu_cent = usuarios.id_usu_cent )'),
        'strSede' => array('tipodato' => '','sql' => '(SELECT valor_nombre FROM uvd_usuarios.usuarios_central us,(SELECT * FROM uvd_usuarios.maestro_contenido WHERE id_maestro = 2) mt WHERE us.id_usu_cent = usuarios.id_usu_cent AND us.u_sede = mt.valor_valor)')
    );

    function get_id_usu_cp() {
        return $this->_id_usu_cp;
    }

    function set_id_usu_cp($dato) {
        $this->_id_usu_cp = $dato;
    }

    function get_id_usu_cent() {
        return $this->_id_usu_cent;
    }

    function set_id_usu_cent($dato) {
        $this->_id_usu_cent = $dato;
    }

    function get_id_rol() {
        return $this->_id_rol;
    }

    function set_id_rol($dato) {
        $this->_id_rol = $dato;
    }

    function get_id_emp() {
        return $this->_id_emp;
    }

    function set_id_emp($_id_emp) {
        $this->_id_emp = $_id_emp;
    }
    
    function get_cf_linea_practica() {
        return $this->_cf_linea_practica;
    }

    function set_cf_linea_practica($_cf_linea_practica) {
        $this->_cf_linea_practica = $_cf_linea_practica;
    }

    function get_strLineaPractica() {
        return $this->_strLineaPractica;
    }

    function get_strRol() {
        return $this->_strRol;
    }

    function get_strNombres() {
        return $this->_strNombres;
    }

    function get_strIdGenesis() {
        return $this->_strIdGenesis;
    }

    function set_strLineaPractica($_strLineaPractica) {
        $this->_strLineaPractica = $_strLineaPractica;
    }

    function set_strRol($_strRol) {
        $this->_strRol = $_strRol;
    }

    function set_strNombres($_strNombres) {
        $this->_strNombres = $_strNombres;
    }

    function set_strIdGenesis($_strIdGenesis) {
        $this->_strIdGenesis = $_strIdGenesis;
    }

    function get_u_sede() {
        return $this->_u_sede;
    }

    function get_strSede() {
        return $this->_strSede;
    }

    function set_u_sede($_u_sede) {
        $this->_u_sede = $_u_sede;
    }

    function set_strSede($_strSede) {
        $this->_strSede = $_strSede;
    }
    function get_strApellidos() {
        return $this->_strApellidos;
    }

    function set_strApellidos($_strApellidos) {
        $this->_strApellidos = $_strApellidos;
    }
    function get_id_usu_cp_crea() {
        return $this->_id_usu_cp_crea;
    }

    function set_id_usu_cp_crea($_id_usu_cp_crea) {
        $this->_id_usu_cp_crea = $_id_usu_cp_crea;
    }





}
