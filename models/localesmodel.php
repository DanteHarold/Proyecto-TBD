<?php
    require_once 'models/local.php';
    require_once 'models/database.php';
    require_once 'libs/IConexion.php';
    require_once 'libs/ConexionFabrica.php';
    class LocalesModel implements IConexion{
        
        public function __construct(){
            $this->fabrica = new ConexionFabrica();               
        }
        public function insert($datos){
        }    
        public function get(){
            $items  = [];
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();     	
            $sql = "SELECT id_local,direccion_local,nombre_local from LOCALES";     
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
		    oci_execute( $stmt );				    // Ejecutar la sentencia
            while( $obj = oci_fetch_object($stmt) ){
                $local = $this->fabrica->getConexion("Local");
                $local->setId($obj->ID_LOCAL);
                $local->setDireccion($obj->DIRECCION_LOCAL);
                $local->setNombre($obj->NOMBRE_LOCAL);
                array_push($items,$local);
            }
            return $items;
        }    
        public function getById($id){
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();     	
            $sql = "SELECT id_local,direccion_local,nombre_local from LOCALES WHERE id_local=".$id;     
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
		    oci_execute( $stmt );				    // Ejecutar la sentencia
            while( $obj = oci_fetch_object($stmt) ){
                $local = $this->fabrica->getConexion("Local");
                $local->setId($obj->ID_LOCAL);
                $local->setDireccion($obj->DIRECCION_LOCAL);
                $local->setNombre($obj->NOMBRE_LOCAL);
            }
            return $local;
        }
        public function update($item){           
        }     
        public function delete($id){
        }       
    }
    
    

?>