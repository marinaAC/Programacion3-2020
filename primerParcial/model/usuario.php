<?php 
    class Usuario extends FilesManager{
        public $_email;
        public $_pass;
        public $type_user;

        public function __construct($email,$pass,$type_user = null)
        {
            $nameFile = get_class();
            
            parent::__construct($nameFile.'.json');
            $this->_email = $email;
            $this->_pass = $pass;
            if($type_user=='admin'){
                $this->type_user = 'admin';
            }  else {
                $this->type_user = 'user';
            }
        }

        public function __get($name)
        {
            return $this->$name;
        }

        public function __set($name, $value)
        {
            $this->$name=$value;
        }

        public function __toString()
        {
            return $this->_email."*".$this->_pass.PHP_EOL;
        }

        public function RegistrarUss()
        {
            if(!$this->FindUss()){
                parent::addJsonFile(json_encode($this));
            }else{
                echo "El usuario ya se encuentra registrado";
            }
        }

        public function FindUss()
        {
            $find = false;
            $listUss=parent::readFileJson(parent::getFileName());
            if($listUss!=null && count($listUss)>0){
                foreach ($listUss as $userJson) {
                    $user = json_decode($userJson);
                    if($user->_email == $this->_email && $user->_pass == $this->_pass){
                        $this->type_user = $user->type_user;
                        $find = true;
                    }
                }
            }
            return $find;
        }

        public function isAdmin()
        {
            $admin = false;
            $listUss=parent::readFileJson(parent::getFileName());
            if($listUss!=null && count($listUss)>0){
                foreach ($listUss as $userJson) {
                    $user = json_decode($userJson);
                    if($user->type_user=='admin'){
                        $admin = true;
                    }
                }
            }
            return $admin;
        }
        
    }


?>