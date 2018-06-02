<?php
    class Autoloader
    {
        public static function register()
        {
            spl_autoload_register(function ($class) {
                $file = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';

                if (!file_exists($file))
                    throw new \Exception("Arquivo '$file' não encontrado.");

                require $file;
            });
        }
    }
    Autoloader::register();
