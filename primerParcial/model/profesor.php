<?php
    class Profesor extends FilesManager{
        public $_nombre;
        public $_legajo;

        public function __construct($nombre,$legajo)
        {
            $nameFile = get_class();
            parent::__construct($nameFile.'.json');
            $this->_nombre = $nombre;
            $this->_legajo = $legajo;
        }

        public function __get($name)
        {
            return $this->$name;
        }

        public function __set($name,$value)
        {
            $this->$name=$value;
        }

        public function __toString()
        {
            return $this->_nombre.'*'.$this->_legajo;
        }

        public function SaveJsonFileTxt($objJson)
        {
            $funciono = parent::addJsonFile($objJson);
            echo " Se guardo un profesor ? $funciono";
        }

        public function ReadJsonFileTxt($name)
        {
            $prueba = parent::readFileJson($name);
            var_dump($prueba);
        }

        public function SaveSerialize()
        {
            $prueba = parent::serializeObj(json_encode($this));
            echo "veamos $prueba";
        }

        public function ReadDeserialize($name)
        {
            $prueba = parent::desSerializeObj($name);
            var_dump($prueba);
        }
        

    }



?>