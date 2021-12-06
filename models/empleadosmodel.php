<?php
    require_once 'models/empleado.php';
    require_once 'models/database.php';
    require_once 'libs/IConexion.php';
    require_once 'libs/ConexionFabrica.php';
    class empleadosModel implements IConexion{
        
        public function __construct(){
            $this->fabrica = new ConexionFabrica();               
        }
        public function insert($datos){

            $empleado = $this->fabrica->getConexion("Empleado");
            $empleado->setNombre($datos['name']);
            $empleado->setApellido($datos['surname']);
            $empleado->setDni($datos['dni']);
            $empleado->setFecha($datos['fecha']);
            $empleado->setFechaNacimiento($datos['fecha_nacimiento']);
            $empleado->setEmail($datos['email']);
            $empleado->setTelefono($datos['telefono']);

            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();   
            $sql = "INSERT INTO EMPLEADOS(apellidos_empleado,nombres_empleado,dni_empleado,telefono_empleado,fecha_nacimiento_empleado,fecha_ingreso_empleado,email_empleado) VALUES('".$empleado->getApellido()."','".$empleado->getNombre()."',".$empleado->getDni().",".$empleado->getTelefono().",'".$empleado->getFechaNacimiento()."','".$empleado->getFecha()."','".$empleado->getEmail()."')";
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
            if(oci_execute( $stmt )){
                  return true;
            }else return false;  
            
        }    
        public function get(){
            $items  = [];
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();     	
            $sql = "SELECT id_empleado,apellidos_empleado,nombres_empleado,dni_empleado,telefono_empleado,fecha_nacimiento_empleado,fecha_ingreso_empleado,email_empleado from EMPLEADOS";     
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
		    oci_execute( $stmt );				    // Ejecutar la sentencia
            while( $obj = oci_fetch_object($stmt) ){
                $empleado = $this->fabrica->getConexion("Empleado");
                $empleado->setId($obj->ID_EMPLEADO);
                $empleado->setApellido($obj->APELLIDOS_EMPLEADO);
                $empleado->setNombre($obj->NOMBRES_EMPLEADO);
                $empleado->setDni($obj->DNI_EMPLEADO);
                $empleado->setTelefono($obj->TELEFONO_EMPLEADO);
                $empleado->setFechaNacimiento($obj->FECHA_NACIMIENTO_EMPLEADO);
                $empleado->setFecha($obj->FECHA_INGRESO_EMPLEADO);
                $empleado->setEmail($obj->EMAIL_EMPLEADO);
                array_push($items,$empleado);
            }
            return $items;   
        }    
        public function getById($id){
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();     	
            $sql = "SELECT id_empleado,apellidos_empleado,nombres_empleado,dni_empleado,telefono_empleado,fecha_nacimiento_empleado,fecha_ingreso_empleado,email_empleado from EMPLEADOS WHERE id_empleado=".$id;     
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
		    oci_execute( $stmt );				    // Ejecutar la sentencia
            while( $obj = oci_fetch_object($stmt) ){
                $empleado = $this->fabrica->getConexion("Empleado");
                $empleado->setId($obj->ID_EMPLEADO);
                $empleado->setApellido($obj->APELLIDOS_EMPLEADO);
                $empleado->setNombre($obj->NOMBRES_EMPLEADO);
                $empleado->setDni($obj->DNI_EMPLEADO);
                $empleado->setTelefono($obj->TELEFONO_EMPLEADO);
                $empleado->setFechaNacimiento($obj->FECHA_NACIMIENTO_EMPLEADO);
                $empleado->setFecha($obj->FECHA_INGRESO_EMPLEADO);
                $empleado->setEmail($obj->EMAIL_EMPLEADO);
            }
            return $empleado;
        }
        public function update($item){
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();
            $sql = "UPDATE EMPLEADOS SET apellidos_empleado='".$item['surname']."',nombres_empleado='".$item['name']."',dni_empleado=".$item['dni'].",telefono_empleado=".$item['telefono'].",fecha_nacimiento_empleado='".$item['fecha_nacimiento']."',fecha_ingreso_empleado='".$item['fecha']."',email_empleado='".$item['email']."' WHERE id_empleado=".$item['id'];
            $stmt = oci_parse($conexion, $sql);		// Preparar la sentencia
            if(oci_execute( $stmt )){ //Ejecutar
                return true;
            }else return false;          
        }     
        public function delete($id){
            $db = $this->fabrica->getConexion("Conexion");  
            $conexion = $db->connect();   
            $sql = "DELETE FROM EMPLEADOS WHERE id_empleado=".$id;
            $stmt = oci_parse($conexion, $sql);	// Preparar la sentencia
            if(oci_execute( $stmt )){ //Ejecutar
                return true;
            }else return false; 
        }   
    }
    
    

?>