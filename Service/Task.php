<?php
    namespace Service;

    class Task
    {
        private $conn;
        private $password = "";
        private $username = "root";
        private $database = "todolist";
        private $servername = "localhost";

        /**
        * Constructor function used to create a database connection
        */
        public function __construct()
        {
            // Create connection
            $this->conn = new \mysqli(
                $this->servername,
                $this->username,
                $this->password,
                $this->database
            );

            // Check connection
            if ($this->conn->connect_error)
                die("Não foi possível estabelecer uma conexão com o banco de dados.");
        }

        /**
        * Function used to get all saved tasks from database
        * @param $order String
        * @return Array
        */
        public function getTasks ($order = "DESC")
        {
            $sql = "SELECT * FROM task ORDER BY done ASC, sort_order $order";
            $stmt = $this->conn->prepare($sql);

            $stmt->execute();
            $result = $stmt->get_result()->fetch_all();
            $stmt->close();

            return $result;
        }

        public function testEmpty ($value)
        {
            return empty($value);
        }

        /**
        * Function used to save a new task
        * @param $values Array
        * @throws Exception
        */
        public function saveTask ($values)
        {
            if (array_filter($values, array($this, "testEmpty")))
                throw new \Exception("Os valores não podem estar vazios.");

            $sql = "INSERT INTO task (type, content, sort_order, done)
                VALUES (?, ?, ?, ?)";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param(
                "ssib",
                $values['type'],
                $values['content'],
                $values['sort_order'],
                $values['done']
            );

            $stmt->execute();
            $stmt->close();
        }

        public function __destruct ()
        {
            $this->conn->close();
        }
    }
