<?php
    class Auto extends FilesManager{
        public $patente;
        public $fechaIngreso;
        public $tipoIngreso;
        public $emailUsr;
        public $fechaEgreso;

        public function __construct($patente,$tipoIngreso,$emailUsr)
        {   
            $nameFile = get_class();
            parent::__construct($nameFile.'.json');
            $this->patente = $patente;
            $this->fechaIngreso = self::CargarHora();
            $this->tipoIngreso = $tipoIngreso;
            $this->emailUsr = $emailUsr;
            $this->fechaEgreso = null;
        }

        public function SaveCar()
        {
            parent::addJsonFile($this);
        }

        private static function CargarHora()
        {
            $dia = Date("d");
            $hora = Date("H");
            //return "Dia: ".$dia."- Hora:".$hora;  
            return $dia.$hora;
        }

        public static function FindCard($value)
        {
            $find = false;
            $listCar=parent::readFileJson(parent::getFileName());
            if($listCar!=null && count($listCar)>0){
                foreach ($listCar as $carJson) {
                    $auto = json_decode($carJson);
                    if($auto->patente == $value){
                        $auto->fechaEgreso = self::CargarHora();
                        var_dump($auto);
                    }
                }
            }
            return $find;
        }

        private function calcularPrecio($horaIngreso,$horaEgreso,$precio)
        {
            # code...
            //hasta aca llegue
        }

    }



?>