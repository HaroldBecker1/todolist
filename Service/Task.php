<?php
    namespace Service;

    class Task
    {
        private $servername = "localhost";
        private $username = "";
        private $password = "";

        public function __construct()
        {
            // Create connection
            $conn = new \mysqli($this->servername, $this->username, $this->password);

            // Check connection
            if ($conn->connect_error)
                die("Não foi possível estabelecer uma conexão com o banco de dados.");
        }
    }
