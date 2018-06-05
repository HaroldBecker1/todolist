<?php
    namespace Service;

    class Task extends Service
    {
        /**
        * Function used to get all saved tasks from database
        * @param $order integer
        * @return array
        */
        public function getTasks ($orderOption = 1)
        {
            $conn = $this->getConnection();
            $order = array(1 => 'ASC', 2 => 'DESC');

            $sql = "SELECT * FROM task ORDER BY done ASC,
                sort_order $order[$orderOption], date_created ASC";
            $stmt = $conn->prepare($sql);

            $stmt->execute();
            $stmt->setFetchMode(\PDO::FETCH_ASSOC);
            $result = $stmt->fetchAll();

            return json_encode($result);
        }

        /**
        * Function used to save a new task
        * @param $values array
        * @throws Exception
        */
        public function saveTask ($values)
        {
            $conn = $this->getConnection();

            if (array_filter($values, array($this, "testEmpty")))
                throw new \Exception("Os campos não podem estar vazios.");

            $sql = "INSERT INTO task (type, content, sort_order, done)
                VALUES (:type, :content, :sort_order, :done)";
            $stmt = $conn->prepare($sql);

            if (false === $stmt)
                throw new \Exception("Ocorreu um erro ao salvar a tarefa.");

            $stmt->bindParam(':type', $values['type']);
            $stmt->bindParam(':done', $values['done']);
            $stmt->bindParam(':content', $values['content']);
            $stmt->bindParam(':sort_order', $values['sort_order']);

            $stmt->execute();
        }

        /**
        * Function used to edit a task
        * @param $values array
        * @throws Exception
        */
        public function editTask ($values)
        {
            $conn = $this->getConnection();

            if (array_filter($values, array($this, "testEmpty")))
                throw new \Exception("Os campos não podem estar vazios.");

            $sql = "UPDATE task SET type = :type, content = :content,
                sort_order = :sort_order, done = :done WHERE uuid = :id";
            $stmt = $conn->prepare($sql);

            if (false === $stmt)
                throw new \Exception("Ocorreu um erro ao editar a tarefa.");

            $stmt->bindParam(':id', $values['id']);
            $stmt->bindParam(':type', $values['type']);
            $stmt->bindParam(':done', $values['done']);
            $stmt->bindParam(':content', $values['content']);
            $stmt->bindParam(':sort_order', $values['sort_order']);

            $stmt->execute();
        }

        /**
        * Function used to remove a task
        * @param $id integer
        * @throws Exception
        */
        public function deleteTask ($value)
        {
            $conn = $this->getConnection();
            $sql = "DELETE FROM task WHERE uuid = :id";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $value['id']);

            $stmt->execute();

            if ($stmt->rowCount() < 1)
                throw new \Exception("Ocorreu um erro ao remover a tarrefa.");
        }

        /**
        * Callback to test empty values in a matrix
        * @return boolean
        */
        public function testEmpty ($value)
        {
            return !isset($value);
        }
    }
