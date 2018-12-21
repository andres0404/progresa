<?php

include_once 'class.DAO.php';

class DAO_ConfLineasPractica extends \cprogresa\DAOGeneral {

    protected $_id_conf_linea;
    protected $_cf_nombre;
    //protected $_cf_roles_entrega;
    protected $_cf_estado;
    protected $_cf_linea_practica;
    
    protected $_tabla = 'conf_lineas_practica';
    protected $_primario = 'id_conf_linea';
    protected $_mapa = array(
        'id_conf_linea' => array('tipodato' => 'integer'),
        'cf_nombre' => array('tipodato' => 'varchar'),
        //'cf_roles_entrega' => array('tipdato' => 'varchar'),
        'cf_estado' => array('tipodato' => 'integer'),
        'cf_linea_practica' => array('tipodato' => 'integer')
    );

    function get_id_conf_linea() {
        return $this->_id_conf_linea;
    }

    function get_cf_nombre() {
        return $this->_cf_nombre;
    }

    function get_cf_estado() {
        return $this->_cf_estado;
    }

    function set_id_conf_linea($_id_conf_linea) {
        $this->_id_conf_linea = $_id_conf_linea;
    }

    function set_cf_nombre($_cf_nombre) {
        $this->_cf_nombre = $_cf_nombre;
    }

    function set_cf_estado($_cf_estado) {
        $this->_cf_estado = $_cf_estado;
    }


    function get_cf_linea_practica() {
        return $this->_cf_linea_practica;
    }

    function set_cf_linea_practica($_cf_linea_practica) {
        $this->_cf_linea_practica = $_cf_linea_practica;
    }

}
