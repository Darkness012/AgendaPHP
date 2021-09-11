<?php

    include "lib.php";

    $respuesta["msg"] = "Error al eliminar el evento";
    if($admin->deleteEvent($_POST["id"])) $respuesta["msg"] = "OK";

    echo json_encode($respuesta);

 ?>
