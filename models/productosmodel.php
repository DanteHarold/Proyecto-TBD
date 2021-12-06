<?php
    //include_once 'models/producto.php';
    require_once 'models/producto.php';
    require_once 'models/database.php';
    require_once 'libs/IConexion.php';
    require_once 'libs/ConexionFabrica.php';
    require_once 'libs/descuentoDecorador.php';
    class ProductosModel implements IConexion{
        public function __construct(){
            $this->fabrica = new ConexionFabrica();               
        }
        public function insert($datos){
            $producto = $this->fabrica->getConexion("Producto");
            $producto->setDescripcion($datos['descripcion']);
            $producto->setCategoria($datos['categoria']);
            $producto->setFecha($datos['fecha']);
            $producto->setPrecio($datos['precio']);
            $producto->setStock($datos['stock']);
            /*
            $productoDesc = new DescuentoDecorador($producto);
            $productoDesc->AgregarDescuento($producto);
            */
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();   
            $sql = "INSERT INTO PRODUCTOS(descripcion_producto,categoria_producto,fecha_producto,precio_producto,stock_producto) VALUES ('".$producto->getDescripcion()."','".$producto->getCategoria()."','".$producto->getFecha()."',".$producto->getPrecio().",".$producto->getStock().")";
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
            if(oci_execute( $stmt )){
                return true;
            }else return false;           
        }    
        public function get(){
            $items  = [];
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();     	
            $sql = "SELECT id_producto,descripcion_producto,categoria_producto,fecha_producto,precio_producto,stock_producto from productos";     
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
		    oci_execute( $stmt );				    // Ejecutar la sentencia
            while( $obj = oci_fetch_object($stmt) ){
                $producto = $this->fabrica->getConexion("Producto");
                $producto->setId($obj->ID_PRODUCTO);
                $producto->setDescripcion($obj->DESCRIPCION_PRODUCTO);
                $producto->setCategoria($obj->CATEGORIA_PRODUCTO);
                $producto->setFecha($obj->FECHA_PRODUCTO);
                $num=str_replace(',','.',$obj->PRECIO_PRODUCTO);
                $producto->setPrecio($num);
                $producto->setStock($obj->STOCK_PRODUCTO);
                array_push($items,$producto);
            }
            return $items;
        }    
        public function getById($id){
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();     	
            $sql = "SELECT id_producto,descripcion_producto,categoria_producto,fecha_producto,precio_producto,stock_producto from productos WHERE id_producto=".$id;     
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
		    oci_execute( $stmt );				    // Ejecutar la sentencia
            while( $obj = oci_fetch_object($stmt) ){
                $producto = $this->fabrica->getConexion("Producto");
                $producto->setId($obj->ID_PRODUCTO);
                $producto->setDescripcion($obj->DESCRIPCION_PRODUCTO);
                $producto->setCategoria($obj->CATEGORIA_PRODUCTO);
                $producto->setFecha($obj->FECHA_PRODUCTO);
                $num=str_replace(',','.',$obj->PRECIO_PRODUCTO);
                $producto->setPrecio($num);
                $producto->setStock($obj->STOCK_PRODUCTO);
            }
            return $producto;
        }
        public function update($item){
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();
            $sql = "UPDATE PRODUCTOS SET descripcion_producto='".$item['descripcion']."',categoria_producto='".$item['categoria']."',fecha_producto='".$item['fecha']."',precio_producto=".$item['precio'].",stock_producto=".$item['stock']." WHERE id_producto=".$item['id'];
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
            if(oci_execute( $stmt )){ //Ejecutar
                return true;
            }else return false; 
        }     
        public function delete($id){
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();   
            $sql = "DELETE FROM PRODUCTOS WHERE id_producto=".$id;
            $stmt = oci_parse($conexion, $sql);	// Preparar la sentencia
            if(oci_execute( $stmt )){ //Ejecutar
                return true;
            }else return false; 
        }
            
    }
    
    

?>