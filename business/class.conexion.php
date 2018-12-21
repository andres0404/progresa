<?php
namespace cprogresa;
class ConexionSQL{
    private static $_conData;
    private static $_obj = null;
    private $_ultima_consulta;
    private $_link;
    /**
     *
     * @var Conexiones
     */
    private $_conexiones ;
    /**
     * Antes de generar una conexion ejecutar este metodo para establecer a que base de datos se conectara
     * @param Conexiones $_obj
     */
    public static function setConData(Conexiones $_obj){
        self::$_conData = $_obj;
    }
    /**
     * Obtener instancia de conexion (previamente debio ejecutarse el metodo setConData en caso que la conexion haya fallado)
     * @return ConexionSQL
     */
    public static function getInstance(){
        if(self::$_obj === null){
            self::$_obj = new self();
        }
        return self::$_obj;
    }
    
    public function begin() {
        $this->consultar("begin");
    }
    public function commit() {
        $this->consultar("commit");
    }
    public function rollback() {
        $this->consultar("rollback");
    }
    
    public function __construct() {
        // generar conexion
        if(!(self::$_conData instanceof \cprogresa\Conexiones)){
            self::setConData(\cprogresa\Conexiones::getConLocal());
        }
        $this->_conectar();
    }
    /**
     * genera la conexion con la base de datos
     * @throws ConexionSQLException
     */
    private function _conectar(){
        //print_r(self::$_conData);
        if(!$this->_link = mysqli_connect(self::$_conData->getServer(), self::$_conData->getUsername(), self::$_conData->getPassword())){
            throw new ConexionSQLException("No se pudo conectar. ".  mysqli_error($this->_link));
        }
        if(!mysqli_select_db($this->_link,self::$_conData->getDatabase())){
            throw new ConexionSQLException("No se pudo seleccionar base de datos ".  mysqli_error());
        }
        mysqli_set_charset($this->_link,'utf8');
    }
    /**
     * 
     * @param type $query
     * @return type
     */
    public function consultar($query){
        $this->_ultima_consulta = $query;
        $result = mysqli_query($this->_link,$query);
        return $result;
    }
    /**
     * Obtener numero de filas de una consulta
     * @param type $id
     * @return type
     */
    public function getNumeroFilasConsultadas($res){
        return mysqli_num_rows($res);
    }
    /**
     * 
     * @param type $id
     * @return type
     */
    public function obenerFila($id) {
        
        if(!empty($id)){
            return mysqli_fetch_array($id, MYSQL_ASSOC);
        }
        return false;
    }
    /**
     * Obtener ultimo elemento autoincrementable en campo id_primario
     * @return type
     */
    public function obtenerIdInsertado(){
        return mysqli_insert_id($this->_link);
    }
    /**
     * Obtener error 
     * @return type
     */
    public function obtenerError(){
        return mysqli_error($this->_link);
    }
    /**
     * Obtener número del error
     * @return type
     */
    public function obtenerErrno() {
        return mysqli_errno($this->_link);
    }
    /**
     * Obtener ultima consulta realizada
     * @return type
     */
    public function obtenerUltimaConsulta() {
        return $this->_ultima_consulta;
    }
}

class Conexiones{
    private $_server;
    private $_username;
    private $_password;
    private $_database;
    private static $_conexiones = array(
        'servidor' => array(
            'server' => 'localhost',
            'username' => 'root',
            'password' => '',
            'database' => 'uvd_cprogresa'   
        )
    );
    public function getServer(){
        return $this->_server;
    }
    public function getUsername(){
        return $this->_username;
    }
    public function getPassword(){
        return $this->_password;
    }
    public function getDatabase(){
        return $this->_database;
    }
    /**
     * 
     * @return Conexiones
     */
    public static function getConLocal(){
         return self::_getConexion('servidor');
    }
    /**
     * 
     * @param type $nomConexion
     * @return \self
     */
    private static function _getConexion($nomConexion){
        $_obj = new self();
        $_obj->_server = self::$_conexiones[$nomConexion]['server'];
        $_obj->_username = self::$_conexiones[$nomConexion]['username'];
        $_obj->_password = self::$_conexiones[$nomConexion]['password'];
        $_obj->_database = self::$_conexiones[$nomConexion]['database'];
        return $_obj;
    }
}
class ConexionSQLException extends \Exception{}
