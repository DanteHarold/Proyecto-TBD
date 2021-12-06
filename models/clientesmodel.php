<?php
    require_once 'models/cliente.php';
    require_once 'models/database.php';
    require_once 'libs/IConexion.php';
    require_once 'libs/ConexionFabrica.php';
    class clientesModel implements IConexion{
        
        public function __construct(){
            $this->fabrica = new ConexionFabrica();               
        }
        public function insert($datos){

            $cliente = $this->fabrica->getConexion("Cliente");
            $cliente->setNombre($datos['name']);
            $cliente->setApellido($datos['surname']);
            $cliente->setDni($datos['dni']);
            $cliente->setFecha($datos['fecha']);
            $cliente->setCiudad($datos['ciudad']);
            $cliente->setProvincia($datos['provincia']);
            $cliente->setDireccion($datos['direccion']);
            $cliente->setEmail($datos['email']);
            $cliente->setTelefono($datos['telefono']);

            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();   
            $sql = "INSERT INTO CLIENTES(apellidos_cliente,nombres_cliente,dni_cliente,fecha_cliente,ciudad_cliente,provincia_cliente,direccion_cliente,email_cliente,telefono_cliente) VALUES ('".$cliente->getApellido()."','".$cliente->getNombre()."',".$cliente->getDni().",'".$cliente->getFecha()."','".$cliente->getCiudad()."','".$cliente->getProvincia()."','".$cliente->getDireccion()."','".$cliente->getEmail()."',".$cliente->getTelefono().")";
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
            if(oci_execute( $stmt )){
                  return true;
            }else return false;  
            
        }    
        public function get(){
            $items  = [];
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();     	
            $sql = "SELECT id_cliente,apellidos_cliente,nombres_cliente,dni_cliente,fecha_cliente,ciudad_cliente,provincia_cliente,direccion_cliente,email_cliente,telefono_cliente from CLIENTES";     
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
		    oci_execute( $stmt );				    // Ejecutar la sentencia
            while( $obj = oci_fetch_object($stmt) ){
                $cliente = $this->fabrica->getConexion("Cliente");
                $cliente->setId($obj->ID_CLIENTE);
                $cliente->setApellido($obj->APELLIDOS_CLIENTE);
                $cliente->setNombre($obj->NOMBRES_CLIENTE);
                $cliente->setDni($obj->DNI_CLIENTE);
                $cliente->setFecha($obj->FECHA_CLIENTE);
                $cliente->setCiudad($obj->CIUDAD_CLIENTE);
                $cliente->setProvincia($obj->PROVINCIA_CLIENTE);
                $cliente->setDireccion($obj->DIRECCION_CLIENTE);
                $cliente->setEmail($obj->EMAIL_CLIENTE);
                $cliente->setTelefono($obj->TELEFONO_CLIENTE);
                array_push($items,$cliente);
            }
            return $items;
        }    
        public function getById($id){
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();     	
            $sql = "SELECT id_cliente,apellidos_cliente,nombres_cliente,dni_cliente,fecha_cliente,ciudad_cliente,provincia_cliente,direccion_cliente,email_cliente,telefono_cliente from CLIENTES WHERE id_cliente=".$id;     
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
		    oci_execute( $stmt );				    // Ejecutar la sentencia
            while( $obj = oci_fetch_object($stmt) ){
                $cliente = $this->fabrica->getConexion("Cliente");
                $cliente->setId($obj->ID_CLIENTE);
                $cliente->setApellido($obj->APELLIDOS_CLIENTE);
                $cliente->setNombre($obj->NOMBRES_CLIENTE);
                $cliente->setDni($obj->DNI_CLIENTE);
                $cliente->setFecha($obj->FECHA_CLIENTE);
                $cliente->setCiudad($obj->CIUDAD_CLIENTE);
                $cliente->setProvincia($obj->PROVINCIA_CLIENTE);
                $cliente->setDireccion($obj->DIRECCION_CLIENTE);
                $cliente->setEmail($obj->EMAIL_CLIENTE);
                $cliente->setTelefono($obj->TELEFONO_CLIENTE);
            }
            return $cliente;
        }
        public function update($item){
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();
            $sql = "UPDATE CLIENTES SET apellidos_cliente='".$item['surname']."',nombres_cliente='".$item['name']."',dni_cliente=".$item['dni'].",fecha_cliente='".$item['fecha']."',ciudad_cliente='".$item['ciudad']."',provincia_cliente='".$item['provincia']."',direccion_cliente='".$item['direccion']."',email_cliente='".$item['email']."',telefono_cliente=".$item['telefono']." WHERE id_cliente=".$item['id'];
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
            if(oci_execute( $stmt )){ //Ejecutar
                return true;
            }else return false;      
        }     
        public function delete($id){
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();   
            $sql = "DELETE FROM CLIENTES WHERE id_cliente=".$id;
            $stmt = oci_parse($conexion, $sql);	// Preparar la sentencia
            if(oci_execute( $stmt )){ //Ejecutar
                return true;
            }else return false; 
        }
        
        
    }
    
    

?>