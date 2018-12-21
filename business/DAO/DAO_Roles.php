<?php 
include_once 'class.DAO.php';

class DAO_Roles extends \cprogresa\DAOGeneral {
    protected $_id_rol;
	protected $_nom_rol;
	protected $_rol_bit_a_bit;
	
    protected $_tabla = 'roles';
    protected $_primario = 'id_rol';
    protected $_mapa = array(
    'id_rol' => array('tipodato' => 'integer'),
	'nom_rol' => array('tipodato' => 'varchar'),
	'rol_bit_a_bit' => array('tipodato' => 'integer')
    );
    	function get_id_rol(){return $this->_id_rol ;}
	function set_id_rol($dato){$this->_id_rol = $dato;}
	function get_nom_rol(){return $this->_nom_rol ;}
	function set_nom_rol($dato){$this->_nom_rol = $dato;}
	function get_rol_bit_a_bit(){return $this->_rol_bit_a_bit ;}
	function set_rol_bit_a_bit($dato){$this->_rol_bit_a_bit = $dato;}

}