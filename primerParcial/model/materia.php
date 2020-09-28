<?php
    class Materia extends FilesManager{
        private $_id;
        private $_nombre;
        private $_cuatrimestre;

        public function __construct($id,$nombre,$cuatrimestre)
        {
            $this->_nombre = $nombre;
            $this->_id=$id;
            $this->_cuatrimestre = $cuatrimestre;
        }

        
    }


?>