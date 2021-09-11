<?php
 
    include "lib.php";


    $respuesta["msg"] = "Error al actualizar evento";
    if($admin->updateEvent($_POST)) $respuesta["msg"] = "OK";

    echo json_encode($respuesta);
?>
