<?php

    include "lib.php";

    //USER1
    $user1["email"] = "user1@email.com";
    $user1["nombre_completo"] = "Name1 example";
    $user1["pass"] = "pass";
    $user1["fecha_nacimiento"] = "2000-05-31";

    //USER2
    $user2["email"] = "user2@email.com";
    $user2["nombre_completo"] = "Name2 example";
    $user2["pass"] = "pass";
    $user2["fecha_nacimiento"] = "2001-03-01";

    //USER3
    $user3["email"] = "user3@email.com";
    $user3["nombre_completo"] = "Name3 example";
    $user3["pass"] = "pass";
    $user3["fecha_nacimiento"] = "2002-08-16";

    //CREATING
    $admin->createUser($user1);
    $admin->createUser($user2);
    $admin->createUser($user3);

    echo "SUCCESS";

 ?>
