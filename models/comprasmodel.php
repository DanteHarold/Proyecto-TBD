<?php
    require_once 'models/compra.php';
    require_once 'models/database.php';
    require_once 'libs/IConexion.php';
    require_once 'libs/ConexionFabrica.php';
    class ComprasModel implements IConexion{
        
        public function __construct(){
            $this->fabrica = new ConexionFabrica();               
        }
        public function insert($datos){
            $compra = $this->fabrica->getConexion("Compra");
            $compra->setFecha($datos['fecha']);
            $compra->setIdEmpleado($datos['idEmpleado']);
            $compra->setIdProveedor($datos['idProveedor']);

            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();   
            $sql = "INSERT INTO COMPRAS(fecha_compra,id_empleado,id_proveedor) VALUES ('".$compra->getFecha()."',".$compra->getIdEmpleado().",".$compra->getIdProveedor().")";
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
            if(oci_execute( $stmt )){
                  return true;
            }else return false;  
            
        }       
        public function get(){       
            $items  = [];
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();     	
            $sql = "SELECT id_compra,fecha_compra,id_empleado,id_proveedor from COMPRAS";     
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
		    oci_execute( $stmt );				    // Ejecutar la sentencia
            while( $obj = oci_fetch_object($stmt) ){
                $compra = $this->fabrica->getConexion("Compra");
                $compra->setId($obj->ID_COMPRA);
                $compra->setFecha($obj->FECHA_COMPRA);
                $compra->setIdEmpleado($obj->ID_EMPLEADO);
                $compra->setIdProveedor($obj->ID_PROVEEDOR);
                array_push($items,$compra);
            }
            return $items;  
        }    
        public function getById($id){
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();     	
            $sql = "SELECT id_compra,fecha_compra,id_empleado,id_proveedor from COMPRAS WHERE id_compra=".$id;     
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
		    oci_execute( $stmt );				    // Ejecutar la sentencia
            while( $obj = oci_fetch_object($stmt) ){
                $compra = $this->fabrica->getConexion("Compra");
                $compra->setId($obj->ID_COMPRA);
                $compra->setFecha($obj->FECHA_COMPRA);
                $compra->setIdEmpleado($obj->ID_EMPLEADO);
                $compra->setIdProveedor($obj->ID_PROVEEDOR);
            }
            return $compra; 
        }
        public function update($item){           
        }     
        public function delete($id){
        }
        public function getLast(){
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();
            $sql = "SELECT id_compra,fecha_compra,id_empleado,id_proveedor  from compras WHERE id_compra = (SELECT MAX(id_compra) FROM compras)";
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
            oci_execute( $stmt );	//Ejecutar Sentencia
            while( $obj = oci_fetch_object($stmt) ){ 
                $compra = $this->fabrica->getConexion("Compra");
                $compra->setId($obj->ID_COMPRA);
                $compra->setFecha($obj->FECHA_COMPRA);
                $compra->setIdEmpleado($obj->ID_EMPLEADO);
                $compra->setIdProveedor($obj->ID_PROVEEDOR);
            }
            return $compra;  
        }        
    }
    
    

?>