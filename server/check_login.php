<?php


    include "lib.php";

    $user["email"] = $_POST["username"];
    $user["pass"] = $_POST["password"];

    $codigo = $admin->validateUser($user)["code"];

    $respuesta["msg"] = "Datos no validos";

    if($codigo===VALID_DATA){
        $respuesta["msg"] = "OK";
    }
    else if ($codigo === WRONG_PASS){
        $respuesta["msg"] = "Contraseña incorrecta";
    }

    echo json_encode($respuesta);
 ?>
