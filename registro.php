<?php
	require_once('funciones.php');

	if (estaLogueado()) {
		header('location: perfil.php');
		exit;
	}

	// Array de países para el foreach en el select
	$paises = ['Argentina', 'Brasil', 'Colombia', 'Sin Mundial'];

	// Variables para persistencia
	$name = '';
	$email = '';
	$pais = '';

	// Array de errores vacío
	$errores = [];

	// Si envían algo por $_POST
	if ($_POST) {
		// Persisto los datos con la información que envía el usuario por $_POST
		$name = trim($_POST['name']);
		$email = trim($_POST['email']);
		$pais = trim($_POST['pais']);

		// Valido y guardo en errores
		$errores = validar($_POST, 'avatar');

		// Si el array de errorres está vacío, es porque no hubo errores, por lo tanto procedo con lo siguiente
		if (empty($errores)) {

			$errores = guardarImagen('avatar');

			if (empty($errores)) {
				// En la variable $usuario, guardo al usuario creado con la función crearUsuario() la cual recibe los datos de $_POST y el avatar
				$usuario = guardarUsuario($_POST, 'avatar');

				header('location: felicidades.php');
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
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/style.css">
	</head>
   <body>
		<?php if (!empty($errores)): ?>
			<div class="div-errores alert alert-danger">
				<ul>
					<?php foreach ($errores as $value): ?>
					<li><?=$value?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>

		<div class="data-form">
			<form  method="post" enctype="multipart/form-data">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="name">Nombre:</label>
							<input type="text" class="form-control" name="name" value="<?=$name?>">
							<?php if (isset($errores['name'])): ?>
								<span style="color: red;">
									<b class="glyphicon glyphicon-exclamation-sign"></b>
									<?=$errores['name'];?>
								</span>
							<?php endif; ?>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="name">Email:</label>
							<input class="form-control" type="text" name="email" value="<?=$email?>">
							<?php if (isset($errores['email'])): ?>
								<span style="color: red;">
									<b class="glyphicon glyphicon-exclamation-sign"></b>
									<?=$errores['email'];?>
								</span>
							<?php endif; ?>
		            </div>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="name">Contraseña:</label>
							<input class="form-control" type="text" name="pass" value="">
							<?php if (isset($errores['pass'])): ?>
								<span style="color: red;">
									<b class="glyphicon glyphicon-exclamation-sign"></b>
									<?=$errores['pass'];?>
								</span>
							<?php endif; ?>
		            </div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="name">Repetir Contraseña:</label>
							<input class="form-control" type="text" name="rpass" value="">
							<?php if (isset($errores['pass'])): ?>
		    					<span style="color: red;">
									<b class="glyphicon glyphicon-exclamation-sign"></b>
									<?=$errores['pass'];?>
								</span>
							<?php endif; ?>
		            </div>
					</div>
				</div>

				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="name">País:</label>
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
									<span style="color: red;">
										<b class="glyphicon glyphicon-exclamation-sign">
										</b><?=$errores['pais'];?>
									</span>
								<?php endif; ?>
		            </div>
					</div>
					<div class="col-xs-6">
						<div class="form-group">
							<label for="name">Subir imagen:</label>
							<input class="form-control" type="file" name="avatar">
							<?php if (isset($errores['avatar'])): ?>
		    					<span style="color: red;">
									<b class="glyphicon glyphicon-exclamation-sign"></b>
									<?=$errores['avatar'];?>
								</span>
							<?php endif; ?>
						</div>
					</div>
				</div>

            <button class="btn btn-primary" type="submit">Enviar</button>
        </form>
	  	</div>
   </body>
</html>
