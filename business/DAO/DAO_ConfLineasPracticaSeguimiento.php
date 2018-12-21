<?php

include_once 'class.DAO.php';
/**
 * DAO para la tabla de calendario de seguimientos para una linea de practica
 */
class DAO_ConfLineasPracticaSeguimiento extends \cprogresa\DAOGeneral {

    protected $_id_lp_seg;
    protected $_id_linea;
    protected $_id_rol;
    protected $_id_usu_cp;
    protected $_strNombres;
    protected $_nomRol;
    protected $_fecha_seguimienti;
    protected $_id_segui;
    protected $_strSeguiTitulo;

    protected $_tabla = 'conf_lineas_practica_seguimiento';
    protected $_primario = 'id_lp_seg';
    
    protected $_mapa = array(
        'id_lp_seg' => array('tipodato' => 'integer'),
        'id_linea' => array('tipodato' => 'integer'),
        'id_usu_cp' => array('tipodato' => 'integer'),
        'strNombres' => array('tipodato' => 'varchar','sql' => '(SELECT CONCAT(u_nombres," ",u_apellidos) FROM uvd_usuarios.usuarios_central a,uvd_cprogresa.usuarios b WHERE a.id_usu_cent = b.id_usu_cent AND b.id_usu_cp = conf_lineas_practica_seguimiento.id_usu_cp)'),
        'id_rol' => array('tipodato' => 'integer','sql' => '(SELECT id_rol FROM usuarios u WHERE u.id_usu_cp = conf_lineas_practica_seguimiento.id_usu_cp)'),
        'nomRol' => array('tipodato' => 'varchar','sql' => '(SELECT nom_rol FROM usuarios a,roles r WHERE a.id_usu_cp = conf_lineas_practica_seguimiento.id_usu_cp AND a.id_rol = r.id_rol)'),
        'fecha_seguimienti' => array('tipodato' => 'date'),
        'id_segui' => array('tipodato' => 'integer'),
        'strSeguiTitulo' => array('tipodato' => 'varchar','sql' => '(SELECT segui_titulo FROM seguimientos seg WHERE seg.id_segui = conf_lineas_practica_seguimiento.id_segui)')
    );
    
    function get_id_lp_seg() {
        return $this->_id_lp_seg;
    }

    function get_id_linea() {
        return $this->_id_linea;
    }

    function get_id_rol() {
        return $this->_id_rol;
    }

    function get_fecha_seguimienti() {
        return $this->_fecha_seguimienti;
    }

    function get_id_segui() {
        return $this->_id_segui;
    }

    function set_id_lp_seg($_id_lp_seg) {
        $this->_id_lp_seg = $_id_lp_seg;
    }

    function set_id_linea($_id_linea) {
        $this->_id_linea = $_id_linea;
    }

    function set_id_rol($_id_rol) {
        $this->_id_rol = $_id_rol;
    }

    function set_fecha_seguimienti($_fecha_seguimienti) {
        $this->_fecha_seguimienti = $_fecha_seguimienti;
    }

    function set_id_segui($_id_segui) {
        $this->_id_segui = $_id_segui;
    }
    function get_id_usu_cp() {
        return $this->_id_usu_cp;
    }

    function set_id_usu_cp($_id_usu_cp) {
        $this->_id_usu_cp = $_id_usu_cp;
    }
    function get_nomRol() {
        return $this->_nomRol;
    }

    function set_nomRol($_nomRol) {
        $this->_nomRol = $_nomRol;
    }
    function get_strSeguiTitulo() {
        return $this->_strSeguiTitulo;
    }

    function set_strSeguiTitulo($_strSeguiTitulo) {
        $this->_strSeguiTitulo = $_strSeguiTitulo;
    }
    function get_strNombres() {
        return $this->_strNombres;
    }

    function set_strNombres($_strNombres) {
        $this->_strNombres = $_strNombres;
    }





}
