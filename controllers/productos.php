<?php
    class Productos extends Controller{

        function __construct(){
            parent::__construct();
            $this->view->mensaje = "";
            $this->view->datos = [];

            require_once 'models/user_session.php';
            require_once 'models/usuario.php';
            $userSession = new userSession();
            $this->view->username = $userSession->getCurrentUser();
        }
        function render(){
            //$productos = $this->view->datos = $this->model->get();
            $productos = $this->model->get();
            $this->view->datos = $productos;
            $this->view->mensaje = "Productos Actualmente";
            $this->view->render('productos/index');
        }
        function agregarProducto(){
            $productos = $this->model->get();
            $this->view->datos = $productos;
            $this->view->render('productos/registro');
        }
        function registrarProducto(){
            if(isset($_POST['descripcion'])){
                $descripcion =     $_POST['descripcion'];
            }
            if(isset($_POST['categoria'])){
                $categoria =  $_POST['categoria'];
            }
            if(isset($_POST['fecha'])){
                $fecha =    $_POST['fecha'];
            }
            if(isset($_POST['precio'])){
                $precio =  $_POST['precio'];
            }
            if(isset($_POST['stock'])){
                $stock =    $_POST['stock'];
            }
            $mensaje = "";
            if($stock < 0){
                $mensaje = "Cantidad Incorrecta";
            }else{
                if($this->model->insert(['descripcion'=> $descripcion , 'categoria' => $categoria , 'fecha'=> $fecha,'precio' => $precio , 'stock'=> $stock])){

                    $mensaje = "Producto Agregado";
                }else{
                    $mensaje = "Producto No Agregado!";
                }
            }
                
            

            

            $this->view->mensaje = $mensaje;
            $this->render();
        }
        function verProducto($param = null){
            $idProducto = $param[0];
            $producto = $this->model->getById($idProducto);
            $this->view->producto = $producto;

            //CARGA LOS DATOS DE FONDO
            $productos = $this->model->get();
            $this->view->datos = $productos;
            
            $_SESSION['id_producto'] =  $idProducto;
            $this->view->mensaje = "Detalle del Producto : ".$_SESSION['id_producto'] ;
            
            $this->view->render('productos/consulta');
        }
        function actualizarProducto($param = null){
            
            $idProducto = $param[0];
            $producto = $this->model->getById($idProducto);
            $this->view->producto = $producto;

            //CARGA LOS DATOS DE FONDO
            $productos = $this->model->get();
            $this->view->datos = $productos;

            $_SESSION['id_producto'] =  $idProducto;
            $this->view->mensaje = "Actualizando Producto : ".$_SESSION['id_producto'] ;

            $this->view->render('productos/editar');
        }
        function editarProducto(){
            $idProducto =  $_SESSION['id_producto'];
            $descripcion =     $_POST['descripcion'];
            $categoria =  $_POST['categoria'];
            $fecha =    $_POST['fecha'];
            $precio =    $_POST['precio'];
            $stock =    $_POST['stock'];

            if($this->model->update([ 'id' => $idProducto,'descripcion'=> $descripcion , 'categoria' => $categoria , 'fecha'=> $fecha,'precio' => $precio , 'stock'=> $stock])){
                
                $producto = new Producto();
                $producto->setId($idProducto);
                $producto->setDescripcion($descripcion);
                $producto->setCategoria($categoria);
                $producto->setFecha($fecha);
                $producto->setPrecio($precio);
                $producto->setStock($stock);

                $this->view->producto = $producto;
                $this->view->mensaje = "Producto Actualizado Correctamente";
            }else{
                $this->view->mensaje = "No actualizado";
            }

            $productos = $this->model->get();
            $this->view->datos = $productos;

            $this->view->render('productos/editar');

        }
        function eliminarProducto($param = null){
            $idProducto = $param[0];
            
            if($this->model->delete($idProducto)){
                $this->view->mensaje = "Actualizado";
            }else{
                $this->view->mensaje = "No actualizado";
            }
            $productos = $this->model->get();
            $this->view->datos = $productos;
            $this->render();

        }
    }
?>