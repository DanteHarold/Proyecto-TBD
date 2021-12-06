<?php
    require_once 'models/detallecompra.php';
    require_once 'models/database.php';
    require_once 'libs/IConexion.php';
    require_once 'libs/ConexionFabrica.php';
    class detalleComprasModel implements IConexion{
        
        public function __construct(){
            $this->fabrica = new ConexionFabrica();               
        }
        public function insert($datos){
            $detalleCompra = $this->fabrica->getConexion("DetalleCompra");
            $detalleCompra->setCantidad($datos['cantidad']);
            $detalleCompra->setTotal( $datos['total']);
            $detalleCompra->setIdMaterial($datos['idMaterial']);
            $detalleCompra->setIdCompra($datos['idCompra']);

            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();   
            $sql = "INSERT INTO DETALLE_COMPRA(cantidad_material,total_compra,id_compra,id_material) VALUES (".$detalleCompra->getCantidad().",".$detalleCompra->getTotal().",".$detalleCompra->getIdCompra().",".$detalleCompra->getIdMaterial().")";
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
            if(oci_execute( $stmt )){
                  return true;
            }else return false; 
            
        }       
        public function get(){       
            $items  = [];
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();     	
            $sql = "SELECT id_compra,cantidad_material,total_compra,id_compra,id_material from DETALLE_COMPRA";     
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
		    oci_execute( $stmt );				    // Ejecutar la sentencia
            while( $obj = oci_fetch_object($stmt) ){
                $detalleCompra = $this->fabrica->getConexion("DetalleCompra");
                $detalleCompra->setId($obj->ID_DETALLE_COMPRA);
                $detalleCompra->setCantidad($obj->CANTIDAD_MATERIAL);
                $num=str_replace(',','.',$obj->TOTAL_COMPRA);
                $detalleCompra->setTotal($num);
                $detalleCompra->setIdCompra($obj->ID_COMPRA);
                $detalleCompra->setIdMaterial($obj->ID_MATERIAL);
                array_push($items,$detalleCompra);
            }
            return $items;   
        }    
        public function getById($id){
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();     	
            $sql = "SELECT id_compra,cantidad_material,total_compra,id_compra,id_material from DETALLE_COMPRA WHERE id_compra=".$id;     
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
		    oci_execute( $stmt );				    // Ejecutar la sentencia
            while( $obj = oci_fetch_object($stmt) ){
                $detalleCompra = $this->fabrica->getConexion("DetalleCompra");
                $detalleCompra->setId($obj->ID_DETALLE_COMPRA);
                $detalleCompra->setCantidad($obj->CANTIDAD_MATERIAL);
                $num=str_replace(',','.',$obj->TOTAL_COMPRA);
                $detalleCompra->setTotal($num);
                $detalleCompra->setIdCompra($obj->ID_COMPRA);
                $detalleCompra->setIdMaterial($obj->ID_MATERIAL);
            }
            return $detalleCompra;  
        }
        public function update($item){           
        }     
        public function delete($id){
        }       
        public function getByIdCompra($id){
            $detalleCompra = $this->fabrica->getConexion("DetalleCompra");
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();     	
            $sql = "SELECT id_detalle_compra,cantidad_material,total_compra,id_compra,id_material from DETALLE_COMPRA WHERE id_compra=".$id;     
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
		    oci_execute( $stmt );				    // Ejecutar la sentencia
            while( $obj = oci_fetch_object($stmt) ){              
                $detalleCompra->setId($obj->ID_DETALLE_COMPRA);
                $detalleCompra->setCantidad($obj->CANTIDAD_MATERIAL);
                $num=str_replace(',','.',$obj->TOTAL_COMPRA);
                $detalleCompra->setTotal($num);
                $detalleCompra->setIdCompra($obj->ID_COMPRA);
                $detalleCompra->setIdMaterial($obj->ID_MATERIAL);
            }
            return $detalleCompra; 
        }
    }
    
    

?>