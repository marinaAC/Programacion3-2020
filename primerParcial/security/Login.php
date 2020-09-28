<?php
    require_once './security/Auth.php';
    class Login{

        public static function ValidCredencial($email,$pass)
        {
            $uss = new Usuario($email,$pass);
            if($uss->FindUss()){
                $token = Auth::SignIn($uss);
                return $token;
            }else{
                echo "Usuario no encontrado";
            }
            
        }
    }


?>