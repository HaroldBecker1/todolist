<?php
    namespace Service;

    use Config\Config;
    use \PDO;

    class DBConnection
    {
        /**
        * Returns a mysql connection instance
        * @throws Exception
        */
        public function getMysqlConnection ()
        {
            $config = new Config();
            $params = $config->getConfig();

            try {
                $connection = new PDO("mysql:host=$params[servername];dbname=$params[database]",
                    $params['username'], $params['password']);
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                throw new \Exception("Não foi possível estabelecer".
                    "uma conexão com o banco de dados.");
            }

            return $connection;
        }
    }
