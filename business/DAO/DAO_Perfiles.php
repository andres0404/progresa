<?php 
include_once 'class.DAO.php';

class DAO_Perfiles extends \cprogresa\DAOGeneral {
    protected $_id_perfil;
	protected $_per_nombre;
	
    protected $_tabla = 'perfiles';
    protected $_primario = 'id_perfil';
    protected $_mapa = array(
    'id_perfil' => array('tipodato' => 'integer'),
	'per_nombre' => array('tipodato' => 'varchar')
    );
    	function get_id_perfil(){return $this->_id_perfil ;}
	function set_id_perfil($dato){$this->_id_perfil = $dato;}
	function get_per_nombre(){return $this->_per_nombre ;}
	function set_per_nombre($dato){$this->_per_nombre = $dato;}

}