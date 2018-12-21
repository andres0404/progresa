<?php
namespace cprogresa;
class MTablas {
    private $_idTabla;
    private $_idDato;
    public function __construct() {}
    /**
     * Devuelve un array del tipo array(id_dato => valor)
     * @param type $idTabla
     * @param type $idDato
     * @param type $tipReturn modifica tipo de array devuelto 1: array(id_dato => valor) 2: array(valor => valor) 3: array(id_dato => id_dato) 4: array('valor_valor' => 1,'valor_nombre' => 'ejemplo')
     */
    public static function getTablaCheckBox($idTabla, $idDato = null, $tipReturn = 1) {
        $obj = new self();
        $obj->_idTabla = $idTabla;
        $obj->_idDato = $idDato;
        if(!$R = $obj->_consultar()){
            return array();
        }
        $checkArray = array();
        for($i = 0; $i < count($R) ; $i++){
            if($tipReturn == 1){
                $checkArray[$R[$i]['valor_valor']] = $R[$i]['valor_nombre'];
            }else if($tipReturn == 2){
                $checkArray[$R[$i]['valor_nombre']] = $R[$i]['valor_nombre'];
            }else if($tipReturn == 3){
                $checkArray[$R[$i]['valor_valor']] = $R[$i]['valor_valor'];
            }else{
                $checkArray[] = ['valor_valor' => $R[$i]['valor_valor'] ,'valor_nombre' => $R[$i]['valor_nombre']];
            }
        }
        return $checkArray;
    }
    /**
     * Cosultar maestro de tablas
     * @return boolean
     */
    private function _consultar(){
        $query = "SELECT  b.nom_tabla,a.* FROM 
maestro_contenido a,
maestro_tablas b
WHERE b.id_maestro = {$this->_idTabla}
AND a.valor_estado = 1
AND a.id_maestro  = b.id_maestro 
AND b.estado = 1";
        $con = \cprogresa\ConexionSQL::getInstance();
        $id = $con->consultar($query);
        if($res = $con->obenerFila($id)){
            $R = array();
            do{
                $aux = array();
                foreach($res as $key => $valor){
                    if(!is_numeric($key)){
                        $aux[$key] = $valor;
                    }
                }
                $R[] = $aux;
            }while($res = $con->obenerFila($id));
            return $R;
        }
        return false;
    }
    /**
     * 
     * @param type $idMaestro
     * @param type $valorValor
     * @param type $valorNombre
     * @return boolean
     */
    public function insertarRegistro($idMaestro,$valorNombre,$valorValor = NULL){
        $con = \cprogresa\ConexionSQL::getInstance();
        $id = NULL;
        if(empty($valorValor)){
            $query_buscar = "SELECT IFNULL(MAX(valor_valor),0)+1 valor FROM maestro_contenido WHERE id_maestro = $idMaestro";
            $id = $con->consultar($query_buscar);
            if(!$res = $con->obenerFila($id)){
                throw new MTablasException("No se pudo encontrar el siguiente id para la tabla que esta trabajando. ".$con->obtenerError() );
            }
            $query = "INSERT INTO maestro_contenido (id_maestro,valor_valor,valor_nombre,valor_estado) VALUES ($idMaestro,'{$res['valor']}','$valorNombre',1)";
            $id = $res['valor'];
        }else{
            $query = "UPDATE maestro_contenido SET valor_nombre = '$valorNombre' WHERE id_maestro = $idMaestro AND valor_valor = $valorValor";
            $id = $valorValor;
        }
        if(!$con->consultar($query)){
            throw new MTablasException("Error MT.: ".$con->obtenerError() );
        }
        return $id;
    }
    /**
     * Eliminar elemento del maestro de tablas
     * @param type $idMaestro
     * @param type $valorValor
     * @return boolean
     * @throws MTablasException
     */
    public function eliminarRegistro($idMaestro,$valorValor) {
        $query = "DELETE FROM maestro_contenido WHERE id_maestro = $idMaestro AND valor_valor = $valorValor";
        $con = \cprogresa\ConexionSQL::getInstance();
        if(!$con->consultar($query)){
            throw new MTablasException("Error MT.: ".$con->obtenerError() );
        }
        return true;
    }
}
class MTablasException extends \Exception{}