<?php
    namespace Service;

    use Service\DBConnection;

    abstract class Service
    {
        private $conn;

        /**
        * Constructor function used to call a database connection
        * @throws Exception
        */
        public function __construct()
        {
            $conn = new DBConnection();
            $this->conn = $conn->getMysqlConnection();
        }

        public function getConnection()
        {
            return $this->conn;
        }

    }
