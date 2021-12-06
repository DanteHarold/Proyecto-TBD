<?php
    require_once 'models/detallepedido.php';
    require_once 'models/database.php';
    require_once 'libs/IConexion.php';
    require_once 'libs/ConexionFabrica.php';
    class detallePedidosModel implements IConexion{
        
        public function __construct(){
            $this->fabrica = new ConexionFabrica();               
        }
        public function insert($datos){
            $detallePedido = $this->fabrica->getConexion("DetallePedido");
            $detallePedido->setCantidad($datos['cantidad']);
            $detallePedido->setTotal( $datos['total']);
            $detallePedido->setIdProducto($datos['idProducto']);
            $detallePedido->setIdPedido($datos['idPedido']);

            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();   
            $sql = "INSERT INTO DETALLE_PEDIDO(cantidad_detalle_pedido,total_detalle_pedido,id_producto,id_pedido) VALUES (".$detallePedido->getCantidad().",".$detallePedido->getTotal().",".$detallePedido->getIdProducto().",".$detallePedido->getIdPedido().")";
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
            if(oci_execute( $stmt )){
                  return true;
            }else return false; 
            
        }       
        public function get(){       
            $items  = [];
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();     	
            $sql = "SELECT id_detalle_pedido,cantidad_detalle_pedido,total_detalle_pedido,id_producto,id_pedido from DETALLE_PEDIDO";     
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
		    oci_execute( $stmt );				    // Ejecutar la sentencia
            while( $obj = oci_fetch_object($stmt) ){
                $detallePedido = $this->fabrica->getConexion("DetallePedido");
                $detallePedido->setId($obj->ID_DETALLE_PEDIDO);
                $detallePedido->setCantidad($obj->CANTIDAD_DETALLE_PEDIDO);
                $num=str_replace(',','.',$obj->TOTAL_DETALLE_PEDIDO);
                $detallePedido->setTotal($num);
                $detallePedido->setIdProducto($obj->ID_PRODUCTO);
                $detallePedido->setIdPedido($obj->ID_PEDIDO);
                array_push($items,$detallePedido);
            }
            return $items;    
        }    
        public function getById($id){
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();     	
            $sql = "SELECT id_detalle_pedido,cantidad_detalle_pedido,total_detalle_pedido,id_producto,id_pedido from DETALLE_PEDIDO WHERE id_detalle_pedido=".$id;     
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
		    oci_execute( $stmt );				    // Ejecutar la sentencia
            while( $obj = oci_fetch_object($stmt) ){
                $detallePedido = $this->fabrica->getConexion("DetallePedido");
                $detallePedido->setId($obj->ID_DETALLE_PEDIDO);
                $detallePedido->setCantidad($obj->CANTIDAD_DETALLE_PEDIDO);
                $num=str_replace(',','.',$obj->TOTAL_DETALLE_PEDIDO);
                $detallePedido->setTotal($num);
                $detallePedido->setIdProducto($obj->ID_PRODUCTO);
                $detallePedido->setIdPedido($obj->ID_PEDIDO);
            }
            return $detallePedido; 
        }
        public function update($item){           
        }     
        public function delete($id){
        }       
        public function getByIdPedido($id){
            $detallePedido = $this->fabrica->getConexion("DetallePedido");
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();     	
            $sql = "SELECT id_detalle_pedido,cantidad_detalle_pedido,total_detalle_pedido,id_producto,id_pedido from DETALLE_PEDIDO WHERE id_pedido=".$id;     
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
		    oci_execute( $stmt );				    // Ejecutar la sentencia
            while( $obj = oci_fetch_object($stmt) ){              
                $detallePedido->setId($obj->ID_DETALLE_PEDIDO);
                $detallePedido->setCantidad($obj->CANTIDAD_DETALLE_PEDIDO);
                $num=str_replace(',','.',$obj->TOTAL_DETALLE_PEDIDO);
                $detallePedido->setTotal($num);
                $detallePedido->setIdProducto($obj->ID_PRODUCTO);
                $detallePedido->setIdPedido($obj->ID_PEDIDO);
            }
            return $detallePedido; 
        }
    }
    
    

?>