<?php
namespace cprogresa;

class ControladorArchivos{
    /**
     * 
     * @param array $file
     * @param integer $id_archivo
     * @return \DAO_TblArchivos
     * @throws ControladorArchivosException
     */
    protected function _guardarArchivo($files,$id_archivo = NULL) {
        $_objArchivo = new \DAO_TblArchivos();
        if(!empty($_objArchivo)) $_objArchivo->set_id_archivo ($id_archivo);
        $_objArchivo->set_ahv_imagen($files['type']);
        $_objArchivo->set_ahv_nombre($files['name']);
        $_objArchivo->set_ahv_imagen($files['tmp_name']);
        if(!$_objArchivo->guardar()){
            throw new ControladorArchivosException("No se guardo archivo",0);
        }
        return $_objArchivo;
    }
    /**
     * Verifica se el archivo tiene un error
     * @param type $files
     * @throws ControladorArchivosException
     */
    protected function _validarArchivo($files) {
        if ($files['error'] != 0) {
            switch ($files['error']) {
                case UPLOAD_ERR_INI_SIZE:
                    $message = "El archivo subido excede la directiva upload_max_filesize en php.ini";
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $message = "El archivo subido excede la directiva MAX_FILE_SIZE especificada en el formulario";
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $message = "El archivo fue subido parcialmente";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $message = "Ningún archivo fue subido";
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    $message = "No se encontro folder temporal";
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $message = "Fallo al pasar archivo al disco";
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $message = "Extención de archivo no permitida";
                    break;
                default:
                    $message = "Error desconocido";
                    break;
            }
            throw new ControladorArchivosException($message);
        }
        return true;
    }
}

class ControladorArchivosException extends \Exception{}