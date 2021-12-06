<?php
    require_once 'models/material.php';
    require_once 'models/database.php';
    require_once 'libs/IConexion.php';
    require_once 'libs/ConexionFabrica.php';
    class materialesModel implements IConexion{
        
        public function __construct(){
            $this->fabrica = new ConexionFabrica();               
        }
        public function insert($datos){

            $material = $this->fabrica->getConexion("Material");
            $material->setDescripcion($datos['name']);
            $material->setFecha($datos['fecha']);
            $material->setPrecio($datos['precio']);
            $material->setStock($datos['stock']);

            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();   
            $sql = "INSERT INTO MATERIALES(descripcion_material,fecha_material,precio_material,stock_material) VALUES ('".$material->getDescripcion()."','".$material->getFecha()."',".$material->getPrecio().",".$material->getStock().")";
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
            if(oci_execute( $stmt )){
                  return true;
            }else return false;  
            
        }    
        public function get(){
            $items  = [];
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();     	
            $sql = "SELECT id_material,descripcion_material,fecha_material,precio_material,stock_material from MATERIALES";     
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
		    oci_execute( $stmt );				    // Ejecutar la sentencia
            while( $obj = oci_fetch_object($stmt) ){
                $material = $this->fabrica->getConexion("Material");
                $material->setId($obj->ID_MATERIAL);
                $material->setDescripcion($obj->DESCRIPCION_MATERIAL);
                $material->setFecha($obj->FECHA_MATERIAL);
                $num=str_replace(',','.',$obj->PRECIO_MATERIAL);
                $material->setPrecio($num);
                $material->setStock($obj->STOCK_MATERIAL);
                array_push($items,$material);
            }
            return $items;      
        }    
        public function getById($id){
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();     	
            $sql = "SELECT id_material,descripcion_material,fecha_material,precio_material,stock_material from MATERIALES WHERE id_material=".$id;     
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
		    oci_execute( $stmt );				    // Ejecutar la sentencia
            while( $obj = oci_fetch_object($stmt) ){
                $material = $this->fabrica->getConexion("Material");
                $material->setId($obj->ID_MATERIAL);
                $material->setDescripcion($obj->DESCRIPCION_MATERIAL);
                $material->setFecha($obj->FECHA_MATERIAL);
                $num=str_replace(',','.',$obj->PRECIO_MATERIAL);
                $material->setPrecio($num);
                $material->setStock($obj->STOCK_MATERIAL);
            }
            return $material;  
        }
        public function update($item){
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();
            $sql = "UPDATE MATERIALES SET descripcion_material='".$item['name']."',fecha_material='".$item['fecha']."',precio_material=".$item['precio'].",stock_material=".$item['stock']." WHERE id_material=".$item['id'];
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
            if(oci_execute( $stmt )){ //Ejecutar
                return true;
            }else return false; 
        }     
        public function delete($id){
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();   
            $sql = "DELETE FROM MATERIALES WHERE id_material=".$id;
            $stmt = oci_parse($conexion, $sql);	// Preparar la sentencia
            if(oci_execute( $stmt )){ //Ejecutar
                return true;
            }else return false; 
        }
        
        
    }
    
    

?>