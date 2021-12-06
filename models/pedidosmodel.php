<?php
    require_once 'models/pedido.php';
    require_once 'models/database.php';
    require_once 'libs/IConexion.php';
    require_once 'libs/ConexionFabrica.php';
    class PedidosModel implements IConexion{
        
        public function __construct(){
            $this->fabrica = new ConexionFabrica();               
        }
        public function insert($datos){
            $pedido = $this->fabrica->getConexion("Pedido");
            $pedido->setFecha($datos['fecha']);
            $pedido->setIdCliente( $datos['idCliente']);
            $pedido->setIdEmpleado($datos['idEmpleado']);
            $pedido->setIdLocal($datos['idLocal']);
       

            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();   
            $sql = "INSERT INTO PEDIDOS(fecha_pedido,id_cliente,id_empleado,id_local) VALUES ('".$pedido->getFecha()."',".$pedido->getIdCliente().",".$pedido->getIdEmpleado().",".$pedido->getIdLocal().")";
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
            if(oci_execute( $stmt )){
                  return true;
            }else return false;  
            
        }       
        public function get(){       
            $items  = [];
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();     	
            $sql = "SELECT id_pedido,fecha_pedido,id_cliente,id_empleado,id_local from PEDIDOS";     
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
		    oci_execute( $stmt );				    // Ejecutar la sentencia
            while( $obj = oci_fetch_object($stmt) ){
                $pedido = $this->fabrica->getConexion("Pedido");
                $pedido->setId($obj->ID_PEDIDO);
                $pedido->setFecha($obj->FECHA_PEDIDO);
                $pedido->setIdCliente($obj->ID_CLIENTE);
                $pedido->setIdEmpleado($obj->ID_EMPLEADO);
                $pedido->setIdLocal($obj->ID_LOCAL);
                array_push($items,$pedido);
            }
            return $items;  
        
        }    
        public function getById($id){
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();     	
            $sql = "SELECT id_pedido,fecha_pedido,id_cliente,id_empleado,id_local from PEDIDOS where id_pedido=".$id;     
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
		    oci_execute( $stmt );				    // Ejecutar la sentencia
            while( $obj = oci_fetch_object($stmt) ){
                $pedido = $this->fabrica->getConexion("Pedido");
                $pedido->setId($obj->ID_PEDIDO);
                $pedido->setFecha($obj->FECHA_PEDIDO);
                $pedido->setIdCliente($obj->ID_CLIENTE);
                $pedido->setIdEmpleado($obj->ID_EMPLEADO);
                $pedido->setIdLocal($obj->ID_LOCAL);
            }
            return $pedido;  
        }
        public function update($item){           
        }     
        public function delete($id){
        }
        public function getLast(){
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();
            $sql = "SELECT id_pedido,fecha_pedido,id_cliente,id_empleado,id_local  from pedidos WHERE id_pedido = (SELECT MAX(id_pedido) FROM pedidos)";
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
            oci_execute( $stmt );	//Ejecutar Sentencia
            while( $obj = oci_fetch_object($stmt) ){ 
                $pedido = $this->fabrica->getConexion("Pedido");
                $pedido->setId($obj->ID_PEDIDO);
                $pedido->setFecha($obj->FECHA_PEDIDO);
                $pedido->setIdCliente($obj->ID_CLIENTE);
                $pedido->setIdEmpleado($obj->ID_EMPLEADO);
                $pedido->setIdLocal($obj->ID_LOCAL);
            }
            return $pedido;  
        }        
    }
    
    

?>