<?php 
include_once 'class.DAO.php';

class DAO_RelLineaPerfil extends \cprogresa\DAOGeneral {
    protected $_id_lin_perfil;
	protected $_id_linea;
	protected $_id_perfil;
	
    protected $_tabla = 'rel_linea_perfil';
    protected $_primario = 'id_lin_perfil';
    protected $_mapa = array(
    'id_lin_perfil' => array('tipodato' => 'integer'),
	'id_linea' => array('tipodato' => 'integer'),
	'id_perfil' => array('tipodato' => 'integer')
    );
    	function get_id_lin_perfil(){return $this->_id_lin_perfil ;}
	function set_id_lin_perfil($dato){$this->_id_lin_perfil = $dato;}
	function get_id_linea(){return $this->_id_linea ;}
	function set_id_linea($dato){$this->_id_linea = $dato;}
	function get_id_perfil(){return $this->_id_perfil ;}
	function set_id_perfil($dato){$this->_id_perfil = $dato;}

}