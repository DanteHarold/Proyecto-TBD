<?php
    require_once 'models/proveedor.php';
    require_once 'models/database.php';
    require_once 'libs/IConexion.php';
    require_once 'libs/ConexionFabrica.php';
    class proveedoresModel implements IConexion{
        
        public function __construct(){
            $this->fabrica = new ConexionFabrica();               
        }
        public function insert($datos){

            $proveedor = $this->fabrica->getConexion("Proveedor");
            $proveedor->setNombre($datos['name']);
            $proveedor->setDireccion($datos['direccion']);
            $proveedor->setFecha($datos['fecha']);
            $proveedor->setEmail($datos['email']);
            $proveedor->setTelefono($datos['telefono']);

            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();   
            $sql = "INSERT INTO PROVEEDORES(nombre_proveedor,direccion_proveedor,fecha_proveedor,email_proveedor,telefono_proveedor) VALUES ('".$proveedor->getNombre()."','".$proveedor->getDireccion()."','".$proveedor->getFecha()."','".$proveedor->getEmail()."',".$proveedor->getTelefono().")";
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
            if(oci_execute( $stmt )){
                  return true;
            }else return false; 
            
        }    
        public function get(){
            $items  = [];
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();     	
            $sql = "SELECT id_proveedor,nombre_proveedor,direccion_proveedor,fecha_proveedor,email_proveedor,telefono_proveedor from PROVEEDORES";     
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
		    oci_execute( $stmt );				    // Ejecutar la sentencia
            while( $obj = oci_fetch_object($stmt) ){
                $proveedor = $this->fabrica->getConexion("Proveedor");
                $proveedor->setId($obj->ID_PROVEEDOR);
                $proveedor->setNombre($obj->NOMBRE_PROVEEDOR);
                $proveedor->setDireccion($obj->DIRECCION_PROVEEDOR);
                $proveedor->setFecha($obj->FECHA_PROVEEDOR);
                $proveedor->setEmail($obj->EMAIL_PROVEEDOR);
                $proveedor->setTelefono($obj->TELEFONO_PROVEEDOR);
                array_push($items,$proveedor);
            }
            return $items; 
        }    
        public function getById($id){
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();     	
            $sql = "SELECT id_proveedor,nombre_proveedor,direccion_proveedor,fecha_proveedor,email_proveedor,telefono_proveedor from PROVEEDORES where id_proveedor=".$id;     
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
		    oci_execute( $stmt );				    // Ejecutar la sentencia
            while( $obj = oci_fetch_object($stmt) ){
                $proveedor = $this->fabrica->getConexion("Proveedor");
                $proveedor->setId($obj->ID_PROVEEDOR);
                $proveedor->setNombre($obj->NOMBRE_PROVEEDOR);
                $proveedor->setDireccion($obj->DIRECCION_PROVEEDOR);
                $proveedor->setFecha($obj->FECHA_PROVEEDOR);
                $proveedor->setEmail($obj->EMAIL_PROVEEDOR);
                $proveedor->setTelefono($obj->TELEFONO_PROVEEDOR);
            }
            return $proveedor; 
        }
        public function update($item){
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();
            $sql = "UPDATE PROVEEDORES SET nombre_proveedor='".$item['name']."',direccion_proveedor='".$item['direccion']."',fecha_proveedor='".$item['fecha']."',email_proveedor='".$item['email']."',telefono_proveedor=".$item['telefono']." WHERE id_proveedor=".$item['id'];
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
            if(oci_execute( $stmt )){ //Ejecutar
                return true;
            }else return false;         
        }     
        public function delete($id){
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();   
            $sql = "DELETE FROM PROVEEDORES WHERE id_proveedor=".$id;
            $stmt = oci_parse($conexion, $sql);	// Preparar la sentencia
            if(oci_execute( $stmt )){ //Ejecutar
                return true;
            }else return false; 
        }
        
        
    }
    
    

?>