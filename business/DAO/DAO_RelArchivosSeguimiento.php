<?php

include_once 'class.DAO.php';
/**
 * 
 */
class DAO_RelArchivosSeguimiento extends \cprogresa\DAOGeneral {

    protected $_id_seg_arc;
    protected $_id_archivos;
    protected $_id_segui;
    protected $_id_arch_lp;
    protected $_id_entre_lp;
    protected $_estado_archivo;

    protected $_tabla = 'rel_archivos_seguimiento';
    protected $_primario = 'id_seg_arc';
    
    protected $_mapa = array(
        'id_seg_arc' => array('tipodato' => 'integer'),
        'id_archivos' => array('tipodato' => 'integer'),
        'id_segui' => array('tipodato' => 'integer'),
        'id_arch_lp' => array('tipodato' => 'integer'),
        'id_entre_lp' => array('tipdato' => 'integer'),
        'estado_archivo' => array('tipodato' => 'integer')
    );
    function get_id_seg_arc() {
        return $this->_id_seg_arc;
    }

    function get_id_archivos() {
        return $this->_id_archivos;
    }

    function get_id_segui() {
        return $this->_id_segui;
    }

    function get_id_arch_lp() {
        return $this->_id_arch_lp;
    }

    function get_id_entre_lp() {
        return $this->_id_entre_lp;
    }

    function get_estado_archivo() {
        return $this->_estado_archivo;
    }

    function set_id_seg_arc($_id_seg_arc) {
        $this->_id_seg_arc = $_id_seg_arc;
    }

    function set_id_archivos($_id_archivos) {
        $this->_id_archivos = $_id_archivos;
    }

    function set_id_segui($_id_segui) {
        $this->_id_segui = $_id_segui;
    }

    function set_id_arch_lp($_id_arch_lp) {
        $this->_id_arch_lp = $_id_arch_lp;
    }

    function set_id_entre_lp($_id_entre_lp) {
        $this->_id_entre_lp = $_id_entre_lp;
    }

    function set_estado_archivo($_estado_archivo) {
        $this->_estado_archivo = $_estado_archivo;
    }
    /**
     * Verifica el estado global de los archivos de vinculacion
     * @param type $id_conf_archivo
     */
    public function estadoElementosArchivosVinculacion($id_conf_linea) {
        $query = "SELECT estado_archivo FROM conf_lineas_practica_archivos a LEFT JOIN rel_archivos_seguimiento b ON a.id_arch_lp = b.id_arch_lp WHERE id_conf_linea = $id_conf_linea GROUP BY estado_archivo ORDER BY estado_archivo LIMIT 1";
        $con = \cprogresa\ConexionSQL::getInstance();
        $id = $con->consultar($query);
        if(!$res = $con->obenerFila($id)){
            return false;
        }
        return $res['estado_archivo'];
    }


}
