<?php

    const INVALID_DATA = 0;
    const VALID_DATA = 1;
    const WRONG_PASS = 2;

    class DBAdmin{

        private $dbAdmin;
        private $user;
        private $pass;
        private $dbName;

        public function __construct($user = "agenda_admin", $pass = "1234", $db="app_agenda")
        {
            $this->user = $user;
            $this->pass = $pass;
            $this->dbName = $db;
            
        }

        //CONNECTORS
        public function initConnection(){
            $this->dbAdmin = new PDO("mysql:localhost=localhost;dbname=".$this->dbName, $this->user, $this->pass);
        }
        public function closeConnection(){
            $this->dbAdmin = null;
        }


        //CRUD
        public function createUser($user){

            $passEncripted = password_hash($user["pass"], PASSWORD_DEFAULT);
            $result = $this->executeSQL(
                "INSERT INTO usuarios VALUES (
                    '".$user['email']."',
                    '".$user['nombre_completo']."',
                    '".$passEncripted."',
                    '".$user['fecha_nacimiento']."')"
            );

            return $result;
        }
        public function createEvent($evento){

            //GETTING FLIEDS AND VALUES
            $fields = "";
            $values = "";

            $count = 0;
            $max = count($evento)-1;
            foreach ($evento as $key => $value) {

                $fields .= $key.($count===$max?"":", ");
                $values .= "'".$value.($count===$max?"'":"', ");

                $count++;
            }
            
            //EXECUTING
            $result = $this->executeSQL("INSERT INTO eventos (".$fields.") VALUES (".$values.")");

            return $result;
        }

        public function getUserByEmail($email){
            return $this->executeSQL(
                "SELECT nombre_completo, email, fecha_nacimiento FROM usuarios WHERE email = '".$email."'")
                ->fetch(PDO::FETCH_ASSOC);
        }
        public function getEventsByEmail($email){
            return $this->executeSQL(
                "SELECT id, title, start, start_hour, end, end_hour, allDay FROM eventos WHERE usuario_email = '".$email."'")
                ->fetchAll(PDO::FETCH_ASSOC);
        }

        public function updateEvent($evento){

            //GETTING FLIEDS AND VALUES
            $info = "";

            $count = 0;
            $max = count($evento)-1;
            foreach ($evento as $key => $value) {

                if($count!=0) $info .= $key."='".$value.($count===$max?"'":"', ");
                
                $count++;
            }

            //EXECUTING
            return $this->executeSQL("UPDATE eventos SET ".$info." WHERE id = ".$evento["id"]);
        }

        public function deleteEvent($id){
            return $this->executeSQL("DELETE FROM eventos WHERE id = ".$id);
        }

        public function validateUser($user){
            $sentencia = "SELECT pass FROM usuarios WHERE email = '".$user["email"]."'";
            $result = $this->executeSQL($sentencia)->fetchAll(PDO::FETCH_ASSOC);
            $respuesta = [];

            if(count($result) == 0){
                $respuesta["code"] = INVALID_DATA;
            }else{
                $code = password_verify($user["pass"], $result[0]["pass"])?VALID_DATA:WRONG_PASS;
                $respuesta["code"] = $code;

                if($code==VALID_DATA){
                    $respuesta["user"] = $this->getUserByEmail($user["email"]);
                    $eventos = $this->getEventsByEmail($user["email"]);

                    session_start();
                    $_SESSION["email"] = $user["email"];
                    
                    if(count($eventos)>0){
                        $respuesta["eventos"] = $eventos;
                        $_SESSION["eventos"] = $respuesta["eventos"];
                    }
                }
            }

            return $respuesta;

        }

        //UTILS
        public function executeSQL($sentencia){
            $this->initConnection();
            $result = $this->dbAdmin->query($sentencia);
            $this->closeConnection();

            return $result;
        }
    

    }
    
    $admin = new DBAdmin();
?>