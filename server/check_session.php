<?php
    session_start();

    if (isset($_SESSION["email"])){
        $respuesta["code"] = 1;
    } 
    else{
        $respuesta["code"] = 0;
    } 

    echo json_encode($respuesta);

?>