<?php
    session_start();
    $respuesta = [];
    if (isset($_SESSION["email"])) {

        include "lib.php";

        $eventos = $admin->getEventsByEmail($_SESSION["email"]);
        if(count($eventos)>0){
            $respuesta["eventos"] = $eventos;
            $respuesta["msg"] = "OK";
        }else{
            $respuesta["msg"] = "NO_DATA";
        }

    }else{
        $respuesta["msg"] = "REDIRECT";
    }

    echo json_encode($respuesta);
        

    


 ?>
