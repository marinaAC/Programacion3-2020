<?php
    class FilesManager{
        private $_nameFile;

        public function __construct($name)
        {
            $this->_nameFile = $name;
        }
        

        public function getFileName()
        {
            return $this->_nameFile;
        }


        public function AddLine($line)
        {
            $lineAdded = false;
            $file = fopen($this->_nameFile,'a+');
            if($file != null){
                fwrite($file,$line.PHP_EOL);           
                $lineAdded = true;
            }
            else{
                //lanzaria excepcion
            }
            fclose($file);
            return $lineAdded;

        }

        public function ReadLine()
        {
            $readFile = array();
            $file = fopen($this->_nameFile,'a+');
            if($file != null){
                while (!feof($file)) {
                    $line = fgets($file);
                    $data = explode('*',$line);
                    //transforarmo en un encode json_encode
                    if(count($data)>0){
                        array_push($readFile,$data);
                    }
                }
            }
            else{
                //lanzaria excepcion
            }
            fclose($file);
            return $readFile;
        }

        public static function ReadLineAtributte($fileName)
        {

            //Utilizar json decode para leerlo
            $readFile = array();
            $file = fopen($fileName,'r');
            if($file != null){
                while (!feof($file)) {
                    $line = fgets($file);
                    $data = explode('*',$line);
                    if(count($data)>0){
                        array_push($readFile,$data);
                    }
                }
            }
            else{
                //lanzaria excepcion
            }
            fclose($file);
            return $readFile;
        }

        public function addJsonFile($jsonObject)
        {
            $wroteFile = false;
            try {
                $jsonRead = FilesManager::readFileJson($this->_nameFile);
                $file = fopen($this->_nameFile,'w');
                if($file != null){
                    $arrayToSave = $this->validateJsonArray($jsonRead,$jsonObject);
                    fwrite($file,json_encode($arrayToSave));
                    $wroteFile = true;
                    fclose($file);
                }
                else{
                    echo "Hubo un problema al leer el archivo $this->_nameFile".PHP_EOL;
                    
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
            
            return $wroteFile;
        }


        public static function readFileJson($nameFile)
        {
            $jsonToReturn = null;
            if(is_readable($nameFile)){
                try {
                    $file = fopen($nameFile,'r');
                    if($file != null){
                        $size = filesize($nameFile);
                        if($size == 0){
                            $jsonToReturn = [];
                        }else{
                            $fread = fread($file,$size);
                            $jsonToReturn = json_decode($fread);
                        }
                        fclose($file);
                    }else{
                        echo "El archivo no existe $nameFile".PHP_EOL;
                    }  
                
                } catch (\Throwable $th) {
                    echo "Hubo un problema al leer el archivo $nameFile / el archivo no existe".PHP_EOL;
                }
            }
            return $jsonToReturn;
        }

        private function validateJsonArray($arrayValidate,$jsonToSave)
        {
            if($arrayValidate != null && count($arrayValidate)>0){
                array_push($arrayValidate,$jsonToSave);
                return $arrayValidate;
            }else{
                $newArray = array();
                array_push($newArray,$jsonToSave);
                return $newArray;
            }  
        }

        public function serializeObj($jsonObject)
        {
            $wroteFile = false;
            $jsonRead = FilesManager::desSerializeObj($this->_nameFile);
           
            $file = fopen($this->_nameFile,'w');
            if($file != null){
                $arrayToSave = $this->validateJsonArray($jsonRead,$jsonObject);
                fwrite($file,serialize($arrayToSave));
                $wroteFile = true;
                fclose($file);
            }
            else{
                echo "Hubo un problema al leer el archivo $this->_nameFile".PHP_EOL;
            }
                
            
            return $wroteFile;
        }

        public static function desSerializeObj($nameFile)
        {
            $arrayJson = null;
            try {
                if(is_readable($nameFile)){
                    $file = fopen($nameFile,'r');
                    if($file != null){
                        $size = filesize($nameFile);
                        if($size == 0){
                            $arrayJson = [];
                        }else{
                            $fread = fread($file,$size);
                            $arrayJson = unserialize($fread);
                        }
                        fclose($file);
                    }else{
                        echo "Hubo un problema al leer el archivo $nameFile".PHP_EOL;
                    }
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
            return $arrayJson;
        }

    }




?>