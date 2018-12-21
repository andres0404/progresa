<?php
namespace cprogresa;
class RolesBit{
    
    private static $_ESTUDIANTE = 64;
    private static $_SUPER_ADMIN = 32;
    private static $_EMPRESA = 16;
    private static $_ADMIN_LINEA = 8;
    private static $_COORDINADOR = 4;
    private static $_ORIENTADOR = 2;
    private static $_DOCENTE = 1;
	
    /**
     * Evaluar permisos del usuario
     * @param type $bit_rol Rol a evaluar
     * @param type $bit_usuario Rol del usuario
     * @return boolean
     */
    static function getAcceso($bit_rol,$bit_usuario = NULL){
        $bit_usuario = empty($bit_usuario) ? $_SESSION['id_usu_cp'] : $bit_usuario;
        //echo "usuario $bit_usuario rol $bit_rol ";
        return (((int)$bit_usuario & (int)$bit_rol) == 0) ? false : true;
    }
    static function SUPER_ADMIN() {
		return self::$_SUPER_ADMIN;
	}
	static function EMPRESA() {
		return self::$_EMPRESA;
	}
	static function ADMIN_LINEA() {
		return self::$_ADMIN_LINEA;
	}
	static function COORDINADOR() {
		return self::$_COORDINADOR;
	}
	static function ORIENTADOR() {
		return self::$_ORIENTADOR;
	}
	static function DOCENTE() {
		return self::$_DOCENTE;
	}
        static function ESTUDIANTE(){
            return self::$_ESTUDIANTE;
        }
	   
}