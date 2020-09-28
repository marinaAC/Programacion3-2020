<?php
    class Precio extends FilesManager{
        public $hora;
        public $estadia;
        public $mensual;

        public function __construct($hora,$estadia,$mensual)
        {
            $nameFile = get_class();
            parent::__construct($nameFile.'.json');
            $this->hora = $hora;
            $this->estadia = $estadia;
            $this->mensual = $mensual;
        }

        public function __get($name)
        {
            return $this->$name;
        }


        public function CargarPrecio($user)
        {
            $cargo = false;
            if($user != null){
                parent::addJsonFile($this);
                $cargo = true;
            }
            return $cargo;
        }



    }



?>