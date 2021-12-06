<?php
    class Pedidos extends Controller{

        function __construct(){
            parent::__construct();
            $this->view->mensaje = "";
            $this->view->datos = [];
            
            $this->view->datosClientes = [];
            $this->view->datosProductos = [];
            $this->view->datosLocales = [];
            $this->view->datosEmpleados = [];

            require_once 'models/user_session.php';
            require_once 'models/usuario.php';
            $userSession = new userSession();
            $this->view->username = $userSession->getCurrentUser();
        }
        function render(){
            //$productos = $this->view->datos = $this->model->get();
            $pedidos = $this->model->get();
            $this->view->datos = $pedidos;
            $this->view->mensaje = "";
            $this->view->render('pedidos/index');
        }
 
        function registrarPedido(){
            $fechaPedido = $_POST['fecha'];

            $idCliente = $_POST['cliente'];
            $url1 = explode('-',$idCliente);
            $cliente = $url1[1];



            $idEmpleado = $_POST['empleado'];
            $url2 = explode('-',$idEmpleado);
            $empleado = $url2[1];

            $idLocal = $_POST['local'];
            $url3 = explode('-',$idLocal);
            $local = $url3[1];


            //DETALLE PRODUCTO
            $cantidad = $_POST['cantidad'];


            $idProducto = $_POST['producto'];
            $url6 = explode('-',$idProducto);
            $producto = $url6[1];


            require_once 'models/productosmodel.php';
            $productoPrecio = new ProductosModel();
            $producto2 = $productoPrecio->getById($producto);


            $total = $cantidad*$producto2->getPrecio();;

            

            if($this->model->insert(['fecha'=> $fechaPedido , 'idCliente' => $cliente , 'idEmpleado'=> $empleado,'idLocal' => $local])){
                $mensaje = "Pedido Agregado";

                $pedido = $this->model->getLast();
                $idPedido = $pedido->getId();
                
                require_once 'models/detallepedidosmodel.php';
                $detallePedido = new detallePedidosModel();
                if($detallePedido->insert(['cantidad' => $cantidad,'total' => $total,'idProducto' => $producto,'idPedido' => $idPedido])){
                    echo "Detalle Pedido Agregado Exitosamente";
                }else{
                    echo "Detalle Pedido Agregado Exitosamente";
                }
                

    
            }else{
                $mensaje = "Pedido No Agregado!";
                echo 'ERROR';
            }
            /*
            
            */
            require_once 'models/empleadosmodel.php';
            $empleados = new EmpleadosModel();
            $this->view->datosEmpleados = $empleados->get();

            require_once 'models/localesmodel.php';
            $locales = new LocalesModel();
            $this->view->datosLocales = $locales->get();

            require_once 'models/productosmodel.php';
            $productos = new ProductosModel();
            $this->view->datosProductos = $productos->get();


            require_once 'models/clientesmodel.php';
            $clientes = new ClientesModel();

            $idCliente = $url1[1];
            $cliente = $clientes->getById($idCliente);
            $this->view->cliente = $cliente;

            //FONDO
            $this->view->datos = $clientes->get();;

            $this->view->mensaje = $mensaje;
            $this->view->render('clientes/registroPedido');


            
        }
    
        function verPedido($param = null){
            $idPedido = $param[0];
            $pedido = $this->model->getById($idPedido);
            $this->view->pedido = $pedido;
            /*
            echo $pedido->getId();
            echo '<br>';
            echo $pedido->getIdCliente();
            echo '<br>';
            echo $pedido->getIdEmpleado();
            echo '<br>';
            */
            //CARGA LOS DATOS DE FONDO
            $pedidos = $this->model->get();
            $this->view->datos = $pedidos;
            
            
            $_SESSION['id_pedido'] =  $idPedido;
            $this->view->mensaje = "Detalle del Pedido : ".$_SESSION['id_pedido'] ;
            
            //CARGAR LOS DATOS PEDIDO
            require_once 'models/clientesmodel.php';
            $cliente = new ClientesModel();
            $this->view->cliente  = $cliente->getById($pedido->getIdCliente());

            require_once 'models/empleadosmodel.php';
            $empleado = new empleadosModel();
            $this->view->empleado2  = $empleado->getById($pedido->getIdEmpleado());
            // echo $this->view->empleado2->getNombre();

            require_once 'models/localesmodel.php';
            $local = new LocalesModel();
            $this->view->local2  = $local->getById($pedido->getIdLocal());

            //CARGAR LOS DATOS DEL DETALLE PEDIDO
            require_once 'models/detallepedidosModel.php';
            $detallePedido = new detallepedidosModel();
            $this->view->detallePedido  = $detallePedido->getByIdPedido($pedido->getId());
            // echo $this->view->detallePedido->getCantidad();
            // echo $this->view->detallePedido->getTotal();
            require_once 'models/productosmodel.php';
            $producto = new productosModel();
            $this->view->producto  = $producto->getById($this->view->detallePedido->getIdProducto());
            $this->view->render('pedidos/consulta');
            
        }
    }


?>