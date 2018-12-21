<?php
/**
 * Enviar un correo
 */
class MailYa{
    public function __construct() {}
    private $_para = 'su_mail@su_host.com';
    private $_de;
    private $_responderA;
    private $_titulo = '';
    private $_mensaje;
    private $_cabeceras;
    function get_de() {
        return $this->_de;
    }
    function set_de($_de) {
        $this->_de = $_de;
        return $this;
    }
    function get_responderA() {
        return $this->_responderA;
    }
    function set_responderA($_responderA) {
        $this->_responderA = $_responderA;
        return $this;
    } 
    function get_para() {
        return $this->_para;
    }
    function get_asunto() {
        return $this->_titulo;
    }
    function get_mensaje() {
        return $this->_mensaje;
    }
    function get_cabeceras() {
        return $this->_cabeceras;
    }
    /**
     * En el caso de ser varios, debes estar separados por comas (,) ej. ella@ejemplar.com,el@ejemplar.com
     * @param type $_para
     * @return \MailYa
     */
    function set_para($_para) {
        $this->_para = $_para;
        return $this;
    }
    function set_asunto($_titulo) {
        $this->_titulo = $_titulo;
        return $this;
    }
    function set_mensaje($_mensaje) {
        $this->_mensaje = $_mensaje;
        return $this;
    }
    function set_cabeceras($_cabeceras) {
        $this->_cabeceras = $_cabeceras;
        return $this;
    }
    /**
     * Antes de este metodo establecer "de", "para", "responder a", "asunto" y "mensaje", 
     * @return type
     */
    public function enviar(){
        $this->_cabeceras = 'From: '.$this->_de . "<$this->_responderA>\r\n" .
    'Reply-To: '.$this->_responderA . "\r\n" .
    'X-Mailer: PHP/' . phpversion()."\r\n".
    "Content-Type: text/html; charset=ISO-8859-1";
        return mail($this->_para, $this->_titulo, $this->_mensaje, $this->_cabeceras);
    }         
}