<?php

include_once 'class.DAO.php';

class DAO_Empresas extends \cprogresa\DAOGeneral {

    protected $_id_emp;
    protected $_emp_nombre;
    protected $_emp_nit;
    protected $_emp_cod_verifica;
    protected $_emp_direccion;
    protected $_emp_telefonos;
    protected $_emp_estado;
    
    protected $_tabla = 'empresas';
    protected $_primario = 'id_emp';
    protected $_mapa = array(
        'id_emp' => array('tipodato' => 'integer'),
        'emp_nombre' => array('tipodato' => 'varchar'),
        'emp_nit' => array('tipodato' => 'integer'),
        'emp_cod_verifica' => array('tipodato' => 'integer'),
        'emp_direccion' => array('tipodato' => 'varchar'),
        'emp_telefonos' => array('tipodato' => 'varchar'),
        'emp_estado' => array('tipodato' => 'integer')
    );

    function get_id_emp() {
        return $this->_id_emp;
    }

    function set_id_emp($dato) {
        $this->_id_emp = $dato;
    }

    function get_emp_nombre() {
        return $this->_emp_nombre;
    }

    function set_emp_nombre($dato) {
        $this->_emp_nombre = $dato;
    }

    function get_emp_nit() {
        return $this->_emp_nit;
    }

    function set_emp_nit($dato) {
        $this->_emp_nit = $dato;
    }

    function get_emp_cod_verifica() {
        return $this->_emp_cod_verifica;
    }

    function set_emp_cod_verifica($dato) {
        $this->_emp_cod_verifica = $dato;
    }

    function get_emp_direccion() {
        return $this->_emp_direccion;
    }

    function set_emp_direccion($dato) {
        $this->_emp_direccion = $dato;
    }

    function get_emp_telefonos() {
        return $this->_emp_telefonos;
    }

    function set_emp_telefonos($dato) {
        $this->_emp_telefonos = $dato;
    }

    function get_emp_estado() {
        return $this->_emp_estado;
    }

    function set_emp_estado($_emp_estado) {
        $this->_emp_estado = $_emp_estado;
    }
}
