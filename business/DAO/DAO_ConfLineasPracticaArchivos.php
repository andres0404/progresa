<?php

include_once 'class.DAO.php';

class DAO_ConfLineasPracticaArchivos extends \cprogresa\DAOGeneral {

    protected $_id_arch_lp;
    protected $_id_conf_linea;
    protected $_id_tipo_archivo;// maestro de tablas MT 2
    protected $_archivo_nombre;
    protected $_archivo_id;
    protected $_archivo_desc;

    protected $_tabla = 'conf_lineas_practica_archivos';
    protected $_primario = 'id_arch_lp';
    protected $_mapa = array(
        'id_arch_lp' => array('tipodato' => 'integer'),
        'id_conf_linea' => array('tipodato' => 'integer'),
        'id_tipo_archivo' => array('tipodato' => 'integer'),
        'archivo_nombre' => array('tipodato' => 'varchar','sql' => '(SELECT valor_nombre FROM maestro_contenido WHERE id_maestro = 2 AND valor_valor = conf_lineas_practica_archivos.id_tipo_archivo)'),
        'archivo_id' => array('tipodato' => 'integer','sql' => '(SELECT valor_valor FROM maestro_contenido WHERE id_maestro = 2 AND valor_valor = conf_lineas_practica_archivos.id_tipo_archivo)'),
        'archivo_desc' => array('tipodato' => 'integer','sql' => '(SELECT valor_nombre FROM maestro_contenido WHERE id_maestro = 6 AND valor_valor = conf_lineas_practica_archivos.id_tipo_archivo)'),
    );

    function get_id_arch_lp() {
        return $this->_id_arch_lp;
    }

    function get_id_conf_linea() {
        return $this->_id_conf_linea;
    }

    function get_id_tipo_archivo() {
        return $this->_id_tipo_archivo;
    }

    function set_id_arch_lp($_id_arch_lp) {
        $this->_id_arch_lp = $_id_arch_lp;
    }

    function set_id_conf_linea($_id_conf_linea) {
        $this->_id_conf_linea = $_id_conf_linea;
    }

    function set_id_tipo_archivo($_id_tipo_archivo) {
        $this->_id_tipo_archivo = $_id_tipo_archivo;
    }
    function get_archivo_nombre() {
        return $this->_archivo_nombre;
    }

    function get_archivo_id() {
        return $this->_archivo_id;
    }

    function set_archivo_nombre($_archivo_nombre) {
        $this->_archivo_nombre = $_archivo_nombre;
    }

    function set_archivo_id($_archivo_id) {
        $this->_archivo_id = $_archivo_id;
    }
    function get_archivo_desc() {
        return $this->_archivo_desc;
    }

    function set_archivo_desc($_archivo_desc) {
        $this->_archivo_desc = $_archivo_desc;
    }

        
    function existenRegistrosRelacionados(){
        $query = "SELECT COUNT(*) total FROM conf_lineas_practica_archivos WHERE id_tipo_archivo = $this->_id_tipo_archivo";
        $con = \cprogresa\ConexionSQL::getInstance();
        $id = $con->consultar($query);
        $res = $con->obenerFila($id);
        return $res['total'];
    }
    

}
