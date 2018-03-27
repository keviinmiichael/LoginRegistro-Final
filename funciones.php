<?php
session_start();

if (isset($_COOKIE['id'])) {
    $_SESSION['id'] = $_COOKIE['id'];
}

function crearUsuario($data, $imagen){
    $usuario = [
        'name' => $data['name'],
        'email' => $data['email'],
        'pass' => password_hash($data['pass'], PASSWORD_DEFAULT),
        'pais' => $data['pais'],
        'id' => traerUltimoID(),
        'foto' => 'img/' . $data['email']. '.' . pathinfo($_FILES[$imagen]['name'], PATHINFO_EXTENSION),
    ];

    return $usuario;
}

function guardarUsuario($data,$imagen){
    $usuario = crearUsuario($data,$imagen);

    $usuarioJSON = json_encode($usuario);

    // $usuarioJSON = $usuarioJSON . PHP_EOL

    file_put_contents('usuarios.json', $usuarioJSON . PHP_EOL , FILE_APPEND );
}

function validar($datos, $archivo){
    $arrayADevolver = [];
    $name = trim($datos['name']);
    $email = trim($datos['email']);
    $pais = trim($datos['pais']);
    $pass = trim($datos['pass']);
    $rpass = trim($datos['rpass']);

    if ($name == '') {
        $arrayADevolver['name'] = "Completa tu nombre";
    }
    if ($pais == '') {
        $arrayADevolver['pais'] = "Decime de donde sos";
    }
    if ($email == '') {
        $arrayADevolver['email'] = "Completa tu email";
    }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $arrayADevolver['email'] = "Por favor poner un email de verdad, gatx.";
    }elseif (existeMail($email)) {
        $arrayADevolver['email'] = 'Ya existe el email.';
    }
    if ($pass == '' || $rpass == '') {
        $arrayADevolver['pass'] = "Por favor completa tus passwords";
    }elseif ($pass != $rpass) {
        $arrayADevolver['pass'] = "Tus contraseñas no coinciden";
    }
    if ($_FILES[$archivo]['error'] != UPLOAD_ERR_OK) {
        $arrayADevolver['avatar'] = "Che, subí una foto !";
    }

    return $arrayADevolver;
}

function traerTodos(){
    $todosJSON = file_get_contents('usuarios.json');

    $usuariosArray = explode(PHP_EOL, $todosJSON);

    array_pop($usuariosArray);

    $todosPHP = [];

    foreach ($usuariosArray as $unUsuario) {
        $todosPHP[] = json_decode($unUsuario, true);
    }
    return $todosPHP;
}

function traerUltimoID(){
    $todos = traerTodos();

    if (count($todos) == 0) {
        return 1;
    }

    $ultimoUsuario = array_pop($todos);

    $ultimoID = $ultimoUsuario['id'];

    return $ultimoID + 1;

}

function existeMail($mail){
    $todos = traerTodos();

    foreach ($todos as $unUsuario) {
        if ($unUsuario['email'] == $mail) {
            return $unUsuario;
        }
    }
    return false;
}

function guardarImagen($imagen){
    $errores = [];

    if ($_FILES[$imagen]['error'] == UPLOAD_ERR_OK) {
        $nombreArchivo = $_FILES[$imagen]['name'];

        $ext = pathinfo($nombreArchivo, PATHINFO_EXTENSION);

        $archivoFisico = $_FILES[$imagen]['tmp_name'];

        if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'JPG') {

            $dondeEstoyParado = dirname(__FILE__);

            $rutaFinalConNombre = $dondeEstoyParado . '/img/'. $_POST['email'] . '.' . $ext;

            move_uploaded_file($archivoFisico, $rutaFinalConNombre);

        }else {
                $errores['avatar'] = 'Tu archivo tiene un formato no valido =D';
        }

    }else {
        $errores['avatar'] = 'No subiste nada';
    }

    return $errores;
}

function validarLogin($datos){
    $arrayADevolver = [];
    $email = trim($datos['email']);
    $pass = trim($datos['pass']);

    if ($email == '') {
        $arrayADevolver['email'] = 'Completa tu email.';
    }elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $arrayADevolver['email'] = 'Pone un email valido, papanatas.';
    }elseif (!existeMail($email)) {
        $arrayADevolver['email'] = 'Este email no esta registrado.';
    }else {
        $usuario = existeMail($email);

        if (!password_verify($pass, $usuario['pass'])) {
            $arrayADevolver['pass'] = 'Credenciales incorrectas.';
        }
    }


    return $arrayADevolver;

}

function loguear($usuario){
    $_SESSION['id'] = $usuario['id'];
}

function estaLogueado(){
    return isset($_SESSION['id']);
}

function traerPorID($id){
    $todos = traerTodos();

    foreach ($todos as $usuario) {
        if ($usuario['id'] == $id) {
            return $usuario;
        }
    }
    return false;
}

 ?>
