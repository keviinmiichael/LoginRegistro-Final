<?php
require_once('funciones.php');

if (estaLogueado()) {
    header('location:perfil.php');
    exit;
}


$email = '';

$errores = [];

if ($_POST) {
    $email = trim($_POST['email']);

    $errores = validarLogin($_POST);

    if (empty($errores)) {

        $usuario = existeMail($email);

        loguear($usuario);

        if ($_POST['recordar']) {
            setcookie('id', $usuario['id'], time() + 3600 );
        }

        header('location:perfil.php');
        exit;
    }


}




 ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Logueate Compa!</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">

</head>
    <body>
        <div class="data-form">
            <form  method="post" enctype="multipart/form-data">
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
                Mantener Logueado!
                <input type="checkbox" name="recordar">
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
        </div>
    </body>
</html>
