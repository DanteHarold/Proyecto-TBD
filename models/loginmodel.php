<?php
    require_once 'models/usuario.php';
    require_once 'models/database.php';
    require_once 'libs/IConexion.php';
    require_once 'libs/ConexionFabrica.php';
    class loginModel implements IConexion{
        
        public function __construct(){
            $this->fabrica = new ConexionFabrica();               
        }
        public function insert($datos){

            $usuario = $this->fabrica->getConexion("Usuario");
            $usuario->setNombre($datos['name']);
            $usuario->setApellido($datos['surname']);
            $usuario->setEmail($datos['email']);
            $usuario->setUsername($datos['username']);
            $usuario->setPassword($datos['password']);

            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();   
            $sql = "INSERT INTO USUARIOS(nombre_usuario,apellido_usuario,email_usuario,username_usuario,password_usuario) VALUES('".$usuario->getNombre()."','".$usuario->getApellido()."','".$usuario->getEmail()."','".$usuario->getUsername()."','".$usuario->getPassword()."')";
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
            if(oci_execute( $stmt )){
                  return true;
            }else return false; 
            
        }    
        public function get(){
            $items  = [];
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();     	
            $sql = "SELECT id_usuario,nombre_usuario,apellido_usuario,email_usuario,username_usuario,password_usuario from USUARIOS";     
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
		    oci_execute( $stmt );				    // Ejecutar la sentencia
            while( $obj = oci_fetch_object($stmt) ){
                $usuario = $this->fabrica->getConexion("Usuario");
                $usuario->setId($obj->ID_USUARIO);
                $usuario->setNombre($obj->NOMBRE_USUARIO);
                $usuario->setApellido($obj->APELLIDO_USUARIO);
                $usuario->setEmail($obj->EMAIL_USUARIO);
                $usuario->setUsername($obj->USERNAME_USUARIO);
                $usuario->setPassword($obj->PASSWORD_USUARIO);
                array_push($items,$usuario);
            }
            return $items; 
        
        }    
        public function getById($id){
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();     	
            $sql = "SELECT id_usuario,nombre_usuario,apellido_usuario,email_usuario,username_usuario,password_usuario from USUARIOS WHERE id_usuario=".$id;     
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
		    oci_execute( $stmt );				    // Ejecutar la sentencia
            while( $obj = oci_fetch_object($stmt) ){
                $usuario = $this->fabrica->getConexion("Usuario");
                $usuario->setId($obj->ID_USUARIO);
                $usuario->setNombre($obj->NOMBRE_USUARIO);
                $usuario->setApellido($obj->APELLIDO_USUARIO);
                $usuario->setEmail($obj->EMAIL_USUARIO);
                $usuario->setUsername($obj->USERNAME_USUARIO);
                $usuario->setPassword($obj->PASSWORD_USUARIO);
            }
            return $usuario; 
        }
        public function update($item){        
        }     
        public function delete($id){       
        }    
        public function getValidacion($datos){
            $usuario = $this->fabrica->getConexion("Usuario");
            $usuario->setUsername($datos['username']);
            $usuario->setPassword($datos['password']);
            
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();   
            $sql = "SELECT nombre_usuario,apellido_usuario,email_usuario from usuarios where username_usuario ='".$usuario->getUsername()."' AND password_usuario='".$usuario->getPassword()."'";
            $stmt = oci_parse($conexion, $sql);	// Preparar la sentencia
            oci_execute( $stmt );//Ejecutas Sentencia
            if(oci_fetch_row($stmt)>0) return true;
            else return false; 

        }  
    }
    
    

?>