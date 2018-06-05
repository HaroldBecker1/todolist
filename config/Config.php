<?php
    namespace Config;

    class Config
    {
        public function getConfig()
        {
            return array(
                "password" => "",
                "username" => "root",
                "database" => "todolist",
                "servername" => "localhost",
            );
        }
    }
