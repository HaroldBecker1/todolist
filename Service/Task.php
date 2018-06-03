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
        * @throws Exception
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
                throw new \Exception("Não foi possível estabelecer".
                    "uma conexão com o banco de dados.");
        }

        /**
        * Function used to get all saved tasks from database
        * @param $order integer
        * @return array
        */
        public function getTasks ($orderOption = 1)
        {
            $order = array(1 => 'ASC', 2 => 'DESC');

            $sql = "SELECT * FROM task ORDER BY done ASC,
                sort_order $order[$orderOption], date_created ASC";
            $stmt = $this->conn->prepare($sql);

            $stmt->execute();
            $result = $stmt->get_result()->fetch_all();
            $stmt->close();

            return $result;
        }

        /**
        * Function used to save a new task
        * @param $values array
        * @throws Exception
        */
        public function saveTask ($values)
        {
            if (array_filter($values, array($this, "testEmpty")))
                throw new \Exception("Os campos não podem estar vazios.");

            $sql = "INSERT INTO task (type, content, sort_order, done)
                VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($sql);

            if (false === $stmt)
                throw new \Exception("Ocorreu um erro ao salvar a tarefa.");

            $stmt->bind_param(
                "ssii",
                $values['type'],
                $values['content'],
                $values['sort_order'],
                $values['done']
            );

            $stmt->execute();
            $stmt->close();
        }

        /**
        * Function used to edit a task
        * @param $values array
        * @throws Exception
        */
        public function editTask ($values)
        {
            if (array_filter($values, array($this, "testEmpty")))
                throw new \Exception("Os campos não podem estar vazios.");

            $sql = "UPDATE task SET type = ?, content = ?, sort_order = ?,
                done = ? WHERE uuid = ?";
            $stmt = $this->conn->prepare($sql);

            if (false === $stmt)
                throw new \Exception("Ocorreu um erro ao editar a tarefa.");

            $stmt->bind_param(
                "ssiii",
                $values['type'],
                $values['content'],
                $values['sort_order'],
                $values['done'],
                $values['id']
            );

            $stmt->execute();
            $stmt->close();
        }

        /**
        * Function used to remove a task
        * @param $id integer
        * @throws Exception
        */
        public function deleteTask ($id)
        {
            $sql = "DELETE FROM task WHERE uuid = ?";

            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("i", $id);

            $stmt->execute();
            $result = $stmt->affected_rows;
            $stmt->close();

            if ($result < 1)
                throw new \Exception("Ocorreu um erro ao remover a tarrefa.");
        }

        /**
        * Callback to test empty values in a matrix
        * @return boolean
        */
        public function testEmpty ($value)
        {
            return is_string($value)? empty($value): !isset($value);
        }

        /**
        * Magic method used to close the database connection
        */
        public function __destruct ()
        {
            $this->conn->close();
        }
    }
