<?php

include_once 'class.DAO.php';
/**
 * 
 */
class DAO_ConfLineasPracticaEntrega extends \cprogresa\DAOGeneral {

    protected $_id_entre_lp;
    protected $_id_linea;
    protected $_id_rol;
    
    protected $_tabla = 'conf_lineas_practica_entrega';
    protected $_primario = 'id_entre_lp';
    
    protected $_mapa = array(
        'id_entre_lp' => array('tipodato' => 'integer'),
        'id_linea' => array('tipodato' => 'integer'),
        'id_rol' => array('tipodato' => 'integer'),
    );
    function get_id_entre_lp() {
        return $this->_id_entre_lp;
    }

    function get_id_linea() {
        return $this->_id_linea;
    }

    function get_id_rol() {
        return $this->_id_rol;
    }

    function set_id_entre_lp($_id_entre_lp) {
        $this->_id_entre_lp = $_id_entre_lp;
    }

    function set_id_linea($_id_linea) {
        $this->_id_linea = $_id_linea;
    }

    function set_id_rol($_id_rol) {
        $this->_id_rol = $_id_rol;
    }
}