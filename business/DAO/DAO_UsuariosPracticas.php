<?php

include_once 'class.DAO.php';

class DAO_UsuariosPracticas extends \cprogresa\DAOGeneral {

    protected $_id_practica;
    protected $_id_linea;
    protected $_id_usu_cp;
    protected $_id_sede;
    protected $_estado_practica;
    protected $_id_conf_linea;
    protected $_fecha_reg;
    protected $_tabla = 'rel_usuarios_practicas';
    protected $_primario = 'id_practica';
    protected $_mapa = array(
        'id_practica' => array('tipodato' => 'integer'),
        'id_linea' => array('tipodato' => 'integer'),
        'id_usu_cp' => array('tipodato' => 'integer'),
        'id_sede' => array('tipodato' => 'integer'),
        'fecha_reg' => array('tipodato' => 'date'),
        'estado_practica' => array('tipodato' => 'integer'),
        'id_conf_linea' => array('tipodato' => 'integer','sql' => '(select id_conf_linea from lineas_practica a where a.id_linea = rel_usuarios_practicas.id_linea)')
    );

    function get_id_practica() {
        return $this->_id_practica;
    }

    function set_id_practica($dato) {
        $this->_id_practica = $dato;
    }

    function get_id_linea() {
        return $this->_id_linea;
    }

    function set_id_linea($dato) {
        $this->_id_linea = $dato;
    }

    function get_id_usu_cp() {
        return $this->_id_usu_cp;
    }

    function set_id_usu_cp($dato) {
        $this->_id_usu_cp = $dato;
    }

    function get_id_sede() {
        return $this->_id_sede;
    }

    function set_id_sede($dato) {
        $this->_id_sede = $dato;
    }

    function get_estado_practica() {
        return $this->_estado_practica;
    }

    function set_estado_practica($dato) {
        $this->_estado_practica = $dato;
    }
    function get_fecha_reg() {
        return $this->_fecha_reg;
    }

    function set_fecha_reg($_fecha_reg) {
        $this->_fecha_reg = $_fecha_reg;
    }

    function get_id_conf_linea() {
        return $this->_id_conf_linea;
    }

    function set_id_conf_linea($_id_conf_linea) {
        $this->_id_conf_linea = $_id_conf_linea;
    }


}
