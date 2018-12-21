<?php

include_once 'class.DAO.php';

class DAO_Seguimientos extends \cprogresa\DAOGeneral {

    protected $_id_segui;
    protected $_id_practica;
    protected $_segui_titulo;
    protected $_segui_tipo;
    protected $_id_usu_cent;
    protected $_segui_fecha_reg;

    protected $_tabla = 'seguimientos';
    protected $_primario = 'id_segui';
    protected $_mapa = array(
        'id_segui' => array('tipodato' => 'integer'),
        'id_practica' => array('tipodato' => 'integer'),
        'segui_titulo' => array('tipodato' => 'varchar'),
        'segui_tipo' => array('tipodato' => 'integer'),
        'id_usu_cent' => array('tipdato' => 'integer'),
        'segui_fecha_reg' => array('tipodato' => 'date')
    );

    function get_id_segui() {
        return $this->_id_segui;
    }

    function set_id_segui($dato) {
        $this->_id_segui = $dato;
    }

    function get_id_practica() {
        return $this->_id_practica;
    }

    function set_id_practica($dato) {
        $this->_id_practica = $dato;
    }

    function get_segui_titulo() {
        return $this->_segui_titulo;
    }

    function set_segui_titulo($dato) {
        $this->_segui_titulo = $dato;
    }

    function get_segui_tipo() {
        return $this->_segui_tipo;
    }

    function set_segui_tipo($dato) {
        $this->_segui_tipo = $dato;
    }

    function get_id_usu_cent() {
        return $this->_id_usu_cent;
    }

    function set_id_usu_cent($_id_usu_cent) {
        $this->_id_usu_cent = $_id_usu_cent;
    }
    function get_segui_fecha_reg() {
        return $this->_segui_fecha_reg;
    }

    function set_segui_fecha_reg($_segui_fecha_reg) {
        $this->_segui_fecha_reg = $_segui_fecha_reg;
    }


}
