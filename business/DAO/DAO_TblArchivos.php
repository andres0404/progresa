<?php

include_once 'class.DAO.php';

class DAO_TblArchivos extends \cprogresa\DAOGeneral {

    protected $_id_archivo;
    protected $_ahv_imagen;
    protected $_ahv_mime;
    protected $_ahv_nombre;
    protected $_id_segui;
    protected $_tabla = 'tbl_archivos';
    protected $_primario = 'id_archivo';
    protected $_mapa = array(
        'id_archivo' => array('tipodato' => 'integer'),
        'ahv_imagen' => array('tipodato' => 'blob'),
        'ahv_mime' => array('tipodato' => 'varchar'),
        'ahv_nombre' => array('tipodato' => 'varchar'),
        'id_segui' => array('tipodato' => 'integer'),
       
    );

    function get_id_archivo() {
        return $this->_id_archivo;
    }

    function set_id_archivo($dato) {
        $this->_id_archivo = $dato;
    }

    function get_ahv_imagen() {
        return $this->_ahv_imagen;
    }

    function set_ahv_imagen($dato) {
        $this->_ahv_imagen = $dato;
    }

    function get_ahv_mime() {
        return $this->_ahv_mime;
    }

    function set_ahv_mime($dato) {
        $this->_ahv_mime = $dato;
    }

    function get_ahv_nombre() {
        return $this->_ahv_nombre;
    }

    function set_ahv_nombre($dato) {
        $this->_ahv_nombre = $dato;
    }

    function get_id_segui() {
        return $this->_id_segui;
    }

    function set_id_segui($dato) {
        $this->_id_segui = $dato;
    }

}
