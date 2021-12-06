<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="<?php echo constant('URL'); ?>public/css/styles.css">
</head>
<body>
    <?php $pagina_activa = "materiales";?>
    <?php require_once 'views/header.php';?>
    <?php require_once 'views/sidebar.php';?>
    <?php require_once 'main.php'; ?>
    <div id="modal" class="lightBox lightBox--show">
        <form action="<?php echo constant('URL') ?>materiales/registrarMaterial" id="form-modal" class="form" method="POST">
            <h2 class="form__title"><?php echo $this->mensaje; ?></h2>
            <div class="form__content">
                <div class="form__field form__field-50">
                    <label for="name" class="form__label">Descripcion: </label>
                    <input type="text" id="form-name" disabled name="name" value="<?php echo $this->material->getDescripcion(); ?>" class="form__input">
                </div>
                <div class="form__field form__field-50">
                    <label for="surname" class="form__label">Fecha: </label>
                    <input type="text" id="form-surname" disabled name="surname" value="<?php echo $this->material->getFecha(); ?>" required class="form__input">
                </div>
                <div class="form__field form__field-50">
                    <label for="email" class="form__label">Precio: </label>
                    <input type="email" id="form-email" disabled name="email" value="<?php echo $this->material->getPrecio(); ?>" required class="form__input">
                </div>
                <div class="form__field form__field-50">
                    <label for="surname" class="form__label">Stock: </label>
                    <input type="text" id="form-surname" disabled name="surname" value="<?php echo $this->material->getStock(); ?>" required class="form__input">
                </div>
            </div>  
        </form>
    </div>
    <?php require_once 'views/footer.php';?>
    <!-- <h1>Esta es la Vista de Main</h1> -->
    <script src="<?php echo constant('URL'); ?>public/js/scripts.js"></script>
</body>
</html>

