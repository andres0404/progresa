<?php 
include_once 'class.DAO.php';

class DAO_DocLog extends \cprogresa\DAOGeneral {
    protected $_id_log;
	protected $_id_usu;
	protected $_log_accion;
	protected $_browser_bits;
	protected $_browser;
	protected $_majorver;
	protected $_browser_type;
	protected $_browser_maker;
	protected $_platform;
	protected $_platform_version;
	protected $_platform_bits;
	protected $_platform_maker;
	protected $_device_type;
	protected $_device_pointing_method;
	protected $_device_brand_name;
	protected $_cssversion;
	protected $_javascript;
	protected $_cookies;
	protected $_log_useragent;
	protected $_log_ip_client;
	protected $_log_fecha;
	protected $_log_hora;
	
    protected $_tabla = 'doc_log';
    protected $_primario = 'id_log';
    protected $_mapa = array(
    'id_log' => array('tipodato' => 'integer'),
	'id_usu' => array('tipodato' => 'integer'),
	'log_accion' => array('tipodato' => 'varchar'),
	'browser_bits' => array('tipodato' => 'integer'),
	'browser' => array('tipodato' => 'varchar'),
	'majorver' => array('tipodato' => 'integer'),
	'browser_type' => array('tipodato' => 'varchar'),
	'browser_maker' => array('tipodato' => 'varchar'),
	'platform' => array('tipodato' => 'varchar'),
	'platform_version' => array('tipodato' => 'varchar'),
	'platform_bits' => array('tipodato' => 'integer'),
	'platform_maker' => array('tipodato' => 'varchar'),
	'device_type' => array('tipodato' => 'varchar'),
	'device_pointing_method' => array('tipodato' => 'varchar'),
	'device_brand_name' => array('tipodato' => 'varchar'),
	'cssversion' => array('tipodato' => 'varchar'),
	'javascript' => array('tipodato' => 'integer'),
	'cookies' => array('tipodato' => 'integer'),
	'log_useragent' => array('tipodato' => 'varchar'),
	'log_ip_client' => array('tipodato' => 'varchar'),
	'log_fecha' => array('tipodato' => 'date'),
	'log_hora' => array('tipodato' => 'integer')
    );
    	function get_id_log(){return $this->_id_log ;}
	function set_id_log($dato){$this->_id_log = $dato;}
	function get_id_usu(){return $this->_id_usu ;}
	function set_id_usu($dato){$this->_id_usu = $dato;}
	function get_log_accion(){return $this->_log_accion ;}
	function set_log_accion($dato){$this->_log_accion = $dato;}
	function get_browser_bits(){return $this->_browser_bits ;}
	function set_browser_bits($dato){$this->_browser_bits = $dato;}
	function get_browser(){return $this->_browser ;}
	function set_browser($dato){$this->_browser = $dato;}
	function get_majorver(){return $this->_majorver ;}
	function set_majorver($dato){$this->_majorver = $dato;}
	function get_browser_type(){return $this->_browser_type ;}
	function set_browser_type($dato){$this->_browser_type = $dato;}
	function get_browser_maker(){return $this->_browser_maker ;}
	function set_browser_maker($dato){$this->_browser_maker = $dato;}
	function get_platform(){return $this->_platform ;}
	function set_platform($dato){$this->_platform = $dato;}
	function get_platform_version(){return $this->_platform_version ;}
	function set_platform_version($dato){$this->_platform_version = $dato;}
	function get_platform_bits(){return $this->_platform_bits ;}
	function set_platform_bits($dato){$this->_platform_bits = $dato;}
	function get_platform_maker(){return $this->_platform_maker ;}
	function set_platform_maker($dato){$this->_platform_maker = $dato;}
	function get_device_type(){return $this->_device_type ;}
	function set_device_type($dato){$this->_device_type = $dato;}
	function get_device_pointing_method(){return $this->_device_pointing_method ;}
	function set_device_pointing_method($dato){$this->_device_pointing_method = $dato;}
	function get_device_brand_name(){return $this->_device_brand_name ;}
	function set_device_brand_name($dato){$this->_device_brand_name = $dato;}
	function get_cssversion(){return $this->_cssversion ;}
	function set_cssversion($dato){$this->_cssversion = $dato;}
	function get_javascript(){return $this->_javascript ;}
	function set_javascript($dato){$this->_javascript = $dato;}
	function get_cookies(){return $this->_cookies ;}
	function set_cookies($dato){$this->_cookies = $dato;}
	function get_log_useragent(){return $this->_log_useragent ;}
	function set_log_useragent($dato){$this->_log_useragent = $dato;}
	function get_log_ip_client(){return $this->_log_ip_client ;}
	function set_log_ip_client($dato){$this->_log_ip_client = $dato;}
	function get_log_fecha(){return $this->_log_fecha ;}
	function set_log_fecha($dato){$this->_log_fecha = $dato;}
	function get_log_hora(){return $this->_log_hora ;}
	function set_log_hora($dato){$this->_log_hora = $dato;}

}