<?php

session_start();
if(isset($_SESSION["email"])){


    include "lib.php";

    $_POST["allDay"] = $_POST["allDay"]=='false'?0:1;
    $_POST["usuario_email"] = $_SESSION["email"];
    
    if($admin->createEvent($_POST)){
        $respuesta["msg"] = "OK";
        $respuesta["id"] = $admin->executeSQL(
            "SELECT id FROM eventos WHERE usuario_email = '".$_SESSION["email"]."' ORDER BY id DESC LIMIT 1"
            )->fetch(PDO::FETCH_ASSOC)["id"];
    } 
    
    else $respuesta["msg"] = "Error al insertar el evento en la base de datos";
    
    echo json_encode($respuesta);

}

    

 ?>
