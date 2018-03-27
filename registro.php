<?php
require_once('funciones.php');

if (estaLogueado()) {
    header('location:perfil.php');
    exit;
}

$paises = ['Argentina', 'Brasil', 'Colombia', 'Sin Mundial'];

$name = '';
$email = '';
$pais = '';

$errores = [];

if ($_POST) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $pais = trim($_POST['pais']);


    $errores = validar($_POST, 'avatar');


    if (empty($errores)) {

        $errores = guardarImagen('avatar');

        if (count($errores) == 0) {
            guardarUsuario($_POST, 'avatar');

            header('location:felicidades.php');
            exit;
        }

    }



}

 ?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Formulario</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">

    </head>
    <body>
        <div class="data-form">
        <form  method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Nombre:</label>
                <input type="text" class="form-control" name="name" value="<?=$name?>">
                <?php if (isset($errores['name'])): ?>
    				<span style="color: red;"><?=$errores['name'];?></span>
    			<?php endif; ?>
            </div>
            <br><br>
            <div class="form-group">
                <label for="name">Email:</label>
                <input class="form-control" type="text" name="email" value="<?=$email?>">
                <?php if (isset($errores['email'])): ?>
    				<span style="color: red;"><?=$errores['email'];?></span>
    			<?php endif; ?>
            </div>
            <br><br>
            <div class="form-group">
                <label for="name">Contraseña:</label>
                <input class="form-control" type="text" name="pass" value="">
                <?php if (isset($errores['pass'])): ?>
    				<span style="color: red;"><?=$errores['pass'];?></span>
    			<?php endif; ?>
            </div>
            <br><br>
            <div class="form-group">
                <label for="name">Repetir Contraseña:</label>
                <input class="form-control" type="text" name="rpass" value="">
                <?php if (isset($errores['pass'])): ?>
    				<span style="color: red;"><?=$errores['pass'];?></span>
    			<?php endif; ?>
            </div>
            <br><br>
            <div class="form-group">
                Pais:
                <select class="form-control" class="" name="pais">
                    <option value="">Elegi País</option>
                    <?php foreach ($paises as $value): ?>
                        <?php if ($value == $pais): ?>
                            <option selected value="<?=$value?>"><?=$value?></option>
                        <?php else: ?>
                            <option value="<?=$value?>"><?=$value?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
                <?php if (isset($errores['pais'])): ?>
    				<span style="color: red;"><?=$errores['pais'];?></span>
    			<?php endif; ?>
            </div>
            <br><br>
            <div class="form-group">
                <label for="name">Cargá tu imagen:</label>
                <input class="form-control" type="file" name="avatar" value="">
                <?php if (isset($errores['pass'])): ?>
    				<span style="color: red;"><?=$errores['avatar'];?></span>
    			<?php endif; ?>
            </div>
            <br><br>
            <button class="btn btn-primary mb-2" type="submit">Enviar</button>
        </form>

        <?php if (count($errores) > 0 ): ?>
            <div class="div-errores">
                <ul>
                <?php foreach ($errores as $value): ?>
                    <li><?=$value?></li>
                <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        </div>
    </body>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</html>
