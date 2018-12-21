<?php
namespace cprogresa;
require_once $_SERVER['DOCUMENT_ROOT'] .'/progresa/business/globals.php';
include_once SERVER.'/business/class.conexion.php';

class DAOGeneral {
    /**
     * si la consulta arroja un resultado devuelve resultado, true: en array (como si hubiera mas de un resultado), false[default]: misma clase que consulta
     * @var type 
     */
    private $_1resultadoEnArray = false;
    protected $_compuerta = " AND ";
    protected $_compuerta_having = " AND ";
    /**
     *
     * @var type 
     */
    protected $_operador = array('=','<>','<','>');
    protected $_indexOperador;
    protected $_having;
    /**
     * Establecer (por el usuario) los campos a agrupar
     * @var type 
     */
    protected $_groupBy;
    /**
     * Establece (por la consulta) el número de registros agrupados
     * @var type 
     */
    protected $_total_group;
    /**
     * Limit de la consulta (int 1, int 2)
     * @var array
     */
    private $_limit = false; 
    private $_numFilasConsultadas;
    protected $_mysqlError;
    protected $_mysqlErrno;
    protected $_mysqlQuery;
    protected $_ordenar = array();
    public function __construct() {}
    /**
     * Establecer limiites para la consulta
     * @param type $val1
     * @param type $val2
     */
    public function setLimit($val1, $val2 = null){
        $this->_limit[0] = $val1;
        if(!empty($val2)){
            $this->_limit[1] = $val2;
        }
    }
    public function getNumFilasConsultadas(){
            return $this->_numFilasConsultadas;	
    }
    public function getMysqlError(){
            return $this->_mysqlError;
    }
    public function getMysqlErrno() {
        return $this->_mysqlErrno;
    }
    public function getMysqlQuery() {
        return $this->_mysqlQuery;
    }
    
    function getGroupBy() {
        return $this->_groupBy;
    }

    function setGroupBy(array $_groupBy) {
        $this->_groupBy = $_groupBy;
    }

        /**
     * 
     * @param type $array
     */
    public function setOrdenar(array $array) {
        $this->_operador = $array;
    }
    /**
     * Cambiar la compuerta de funcionamiento en el WHERE (AND por defecto)
     * @param type $compuerta
     */
    public function setCompuerta($compuerta){
        $this->_compuerta = $compuerta;
    }
    /**
     * Cambiar la compuerta de funcionamiento en HAVING (AND por defecto)
     * @param type $compuerta
     */
    public function setCompuertaHaving($compuerta_having){
        $this->_compuerta_having = $compuerta_having;
    }

    /**
     * Uso array('nom_campo' => {0,1,2,3})
     * @param array $operador 0 -> '=','<>','<','>'
     */
    public function setIndexOperador(array $operador){
        $this->_indexOperador = $operador;
    }
    /**
     * 
     */
    public function habilita1ResultadoEnArray(){
        $this->_1resultadoEnArray = true;
    }
    /**
     * 
     */
    public function deshabilita1ResultadoEnArray(){
        $this->_1resultadoEnArray = false;
    }
    /**
    * Implementar clausula having array("campo = valor", "campo = valor")
    */
    public function setHaving(array $having){
            $this->_having = $having;
    }
    /**
     * Obtner el mapa de las clases DAO
     * @return array
     */
    public function getMapa(){
        return $this->_mapa;
    }
    /**
     * Nombre de la tabla en base de datos
     * @return string
     */
    public function getTabla(){
        return $this->_tabla;
    }
    /**
     * Obtener valor primario
     * @return string
     */
    public function getPrimario(){
        return $this->{'_'.$this->_primario};
    }
    /**
     * Establecer el dato primario
     * @param type $dato
     */
    public function setPrimario($dato){
        $this->{'_'.$this->_primario} = $dato;
    }
    /**
     * 
     * @return boolean
     */
    public function guardar() {
        $con = \cprogresa\ConexionSQL::getInstance();
        $set = array();
        foreach($this->_mapa as $nom_campo => $arrAtributos){
            if ($this->{'_' . $nom_campo} !== null AND $nom_campo != $this->_primario && !isset($arrAtributos['sql'])) {
                switch($arrAtributos['tipodato']){
                case 'blob': // convierte a binario los elementos (archivos) contenidos en una variable blob
                    $binario_contenido = addslashes(fread(fopen($this->{'_' . $nom_campo},"rb"),filesize($this->{'_' . $nom_campo}))) ;
                    $set[] = $nom_campo . " = '" . $binario_contenido . "'";
                break;
                case 'clave':
                        if(!empty($this->{'_' . $nom_campo}))
                            $set[] = $nom_campo . " = SHA1('" . $this->{'_' . $nom_campo} . "')";
                break;
                default : // tratamiento a cuaquier otro elemento
                    $set[] = $nom_campo . " = '" . $this->{'_' . $nom_campo} . "'";
                }
            }
        }
        $where = "";
        if(!empty($this->{'_'.$this->_primario})){
            $where = " WHERE $this->_primario = ". $this->{'_'.$this->_primario} ;
            $query = "update ".$this->_tabla." set ".implode(",", $set) . $where;
        }else{
            $query = "insert into ".$this->_tabla." set ".  implode(",", $set) ;
        }
        //"**$query";
        $this->_mysqlQuery = $query;
        if($id = $con->consultar($query)){
            if(empty($this->{'_'.$this->_primario})){
                $this->{'_'.$this->_primario} = $con->obtenerIdInsertado();
            }
            return true;
        }else{
            $this->_mysqlError = $con->obtenerError();
            $this->_mysqlErrno = $con->obtenerErrno();
        }
        return false;
    }
    /**
     * 
     * @return boolean|\clases_llamada
     */
    public function consultar() {
        $where = array();
        $select = array();
        foreach($this->_mapa as $nom_campo => $arrAtributos){
			if(is_array($this->_groupBy)){
                if(!in_array($nom_campo, $this->_groupBy)){
                    continue;
                }
            }
            if ($this->{'_' . $nom_campo} !== null) {
                switch($arrAtributos['tipodato']){
                    case 'varchar-like':
                        $where[] = $nom_campo . " LIKE '%" . $this->{'_' . $nom_campo} . "%' ";
                    break;
                    case 'clave':
                            if(!empty($this->{'_' . $nom_campo}))
                                $where[] = ($nom_campo . " = SHA1('" . $this->{'_' . $nom_campo} . "')");
                    break;
                    default :
                        if(is_array($this->{'_' . $nom_campo} )){
                            $aux = array();
                            for ($i = 0; $i < count($this->{'_' . $nom_campo}); $i++ ) {
                                $aux[] = "'".$this->{'_' . $nom_campo}[$i]."'";
                            }
                            $where[] = $nom_campo . " in (" . implode(",", $aux ) . ")";
                        } else {
                            $where[] = ($nom_campo . " ".$this->_operador[isset($this->_indexOperador[$nom_campo]) ? $this->_indexOperador[$nom_campo] : 0 ]." '" . $this->{'_' . $nom_campo} . "'");
                        }
                }
            }
            if(isset($arrAtributos['sql']) && !empty($arrAtributos['sql'])){
                $select[] = $arrAtributos['sql'] . " as " . $nom_campo;
            }else{
                $select[] = $nom_campo;
            }
        }
        
        if(is_array($this->_groupBy)){
            $select[] = "COUNT(*) total_group";
        }
        if (count($where) == 0) {
            $query = "select ".implode(",",$select)." from " . $this->_tabla . " where 1 ";
        } else {
            $query = "select ".implode(",",$select)." from " . $this->_tabla . " where " . implode($this->_compuerta, $where)." ";
        }
        // group
        if(is_array($this->_groupBy)){
            $query .= (" GROUP BY ". implode(",", $this->_groupBy));
        }
        // having
        if(is_array($this->_having) && count($this->_having) > 0){
                $query .= (" HAVING (" . implode($this->_compuerta_having, $this->_having). ")");
        }
        // orden 
        if(isset($this->_ordenar) && is_array($this->_ordenar) && count($this->_ordenar) > 0){
            $query .= ( " ORDER BY ".implode(",",  $this->_ordenar));
        }
        // limites
        if(!empty($this->_limit)){
            $query .= (" LIMIT " . implode(",", $this->_limit));
        }
        //echo "|$query";
        $this->_mysqlQuery = $query;
        $con = \cprogresa\ConexionSQL::getInstance();
        if(!$id = $con->consultar($query)){
            return false;
        }
        $this->_numFilasConsultadas = $con->getNumeroFilasConsultadas($id);
        if($res = $con->obenerFila($id)){
            if ($con->getNumeroFilasConsultadas($id) == 1 && !$this->_1resultadoEnArray) {// si viene mas de un resultado debe clonarse la clase y retornar en un arreglo de clases
                if(is_array($this->_groupBy)){
                    $this->_mapa['total_group'] = array('tipodato' => 'integer');
                }
                //$res = $con->obenerFila($id);
                foreach($this->_mapa as $nom_campo => $arrAtributos){
					if(isset($res[$nom_campo]))
                    	$this->{'_' . $nom_campo} = $res[$nom_campo];
                }
                return true;
            } else {
                if(is_array($this->_groupBy)){
                    $this->_mapa['total_group'] = array('tipodato' => 'integer');
                }
                $R = array();
                do{
                    $clases_llamada = get_called_class();
                    $obj = new $clases_llamada()  ;
                    //print_r($this->_mapa);
                    foreach($this->_mapa as $nom_campo => $arrAtributos){
                        $obj->{'set_'.$nom_campo}($res[$nom_campo]);
                    }
                    //print_r($obj);
                    $R[] = $obj;
                }while($res = $con->obenerFila($id));
                return $R;
            }
        }
        return false;
    }
    /**
     * eliminar
     * @return boolean
     */
    public function eliminar(){
        $where = array();
        foreach($this->_mapa as $nom_campo => $arrAtributos){
            if ($this->{'_' . $nom_campo} !== null) {
                $where[] = $nom_campo . " = '" . $this->{'_' . $nom_campo} . "'";
            }
        }
        if (count($where) != 0) {
            $query = "DELETE FROM " . $this->_tabla ." WHERE " . implode($this->_compuerta, $where);
        }
        $this->_mysqlQuery = $query;
        $con = \cprogresa\ConexionSQL::getInstance();
        if(!$id = $con->consultar($query)){
            $this->_mysqlError = $con->obtenerError();
            $this->_mysqlErrno = $con->obtenerErrno();
            return false;
        }
        //$this->_numFilasConsultadas = $con->getNumeroFilasConsultadas($id);
        return true;
    }
    /**
     * Obtener los valores de la clase en formato array
     * @return array
     */
    public function getArray() {
        $arrDatos = array();
        foreach ($this->_mapa as $nom_campo => $arrAtributos) {
            $arrDatos[$nom_campo] = $this->{'get_' . $nom_campo}();
        }
        return $arrDatos;
    }
    public function get_total_group() {
        return $this->_total_group;
    }

    public function set_total_group( $_total_group) {
        $this->_total_group = $_total_group;
    }
}
