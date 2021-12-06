<?php
class Database{
    private $host;
    private $user;
    private $password;

    public function __construct(){
        $this->host = constant('HOST');
        $this->user = constant('USER');
        $this->password = constant('PASSWORD');
    }

    public function connect(){
        $conexion = oci_connect($this->user, $this->password, $this->host) or die ( "Error al conectar : ".oci_error() );		
		return $conexion;	
    }

}

?>