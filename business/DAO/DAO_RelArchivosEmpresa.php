<?php

include_once 'class.DAO.php';

class DAO_RelArchivosEmpresa extends \cprogresa\DAOGeneral {

    protected $_id_arch_emp;
    protected $_tipo_archivo;
    protected $_id_emp;
    protected $_id_archivo;
    protected $_estado_archivo;
    
    protected $_tabla = 'rel_archivos_empresa';
    protected $_primario = 'id_arch_emp';
    protected $_mapa = array(
        'id_arch_emp' => array('tipodato' => 'integer'),
        'tipo_archivo' => array('tipodato' => 'blob'),
        'id_emp' => array('tipodato' => 'varchar'),
        'id_archivo' => array('tipodato' => 'varchar'),
        'estado_archivo' => array('tipodato' => 'integer'),
    );
    function get_id_arch_emp() {
        return $this->_id_arch_emp;
    }

    function get_tipo_archivo() {
        return $this->_tipo_archivo;
    }

    function get_id_emp() {
        return $this->_id_emp;
    }

    function get_id_archivo() {
        return $this->_id_archivo;
    }

    function get_estado_archivo() {
        return $this->_estado_archivo;
    }

    function set_id_arch_emp($_id_arch_emp) {
        $this->_id_arch_emp = $_id_arch_emp;
    }

    function set_tipo_archivo($_tipo_archivo) {
        $this->_tipo_archivo = $_tipo_archivo;
    }

    function set_id_emp($_id_emp) {
        $this->_id_emp = $_id_emp;
    }

    function set_id_archivo($_id_archivo) {
        $this->_id_archivo = $_id_archivo;
    }

    function set_estado_archivo($_estado_archivo) {
        $this->_estado_archivo = $_estado_archivo;
    }


    
}
