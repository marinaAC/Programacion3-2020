<?php
    require_once './model/filesManager.php';
    require_once './model/usuario.php';
    require_once './security/Login.php';
    require_once './model/Precio.php';
    require_once './model/Auto.php';

    require __DIR__ . '/vendor/autoload.php';

    use \Firebase\JWT\JWT;

    $method = $_SERVER['REQUEST_METHOD'];

    $path_info = $_SERVER['PATH_INFO'] ?? '';

    

    switch ($method) {
        case 'POST':
            
            switch ($path_info) {
                case '/registro':
                    $email = $_POST['email'] ?? '';
                    $tipo = $_POST['tipo'] ?? '';
                    $password = $_POST['password'] ?? '';

                    if($email != '' && $tipo != '' && $password != ''){
                        $uss = new Usuario($email,$password,$tipo);
                        $uss->RegistrarUss();
                    }else{
                        echo "Los valores pasados por parametros se encontraban vacios";
                    }
                    break;
                case '/login':
                    $email = $_POST['email'] ?? '';
                    $password = $_POST['password'] ?? '';
                    if($email != '' && $password != ''){
                        $token = Login::ValidCredencial($email,$password);
                        $_SERVER['HTTP_TOKEN'] = $token;
                        echo "$token";
                    }
                break;

                case '/precio':
                    $token = $_SERVER['HTTP_TOKEN'];
                    $hora = $_POST['precio_hora'] ?? '';
                    $precio_estadia = $_POST['precio_estadia'] ?? '';
                    $precio_mensual = $_POST['precio_mensual'] ?? '';
                    $data = Auth::GetData($token);
                    if($hora != '' && $precio_estadia != '' && $precio_mensual != '' && $data->type_user == 'admin' ){
                        $precio = new Precio($hora,$precio_estadia,$precio_mensual);
                        $precio->CargarPrecio($data);
                    }else{
                        echo "No se pudo cargar correctamente los precios";
                    }

                break;

                case '/ingreso':
                    $token = $_SERVER['HTTP_TOKEN'];
                    $data = Auth::GetData($token);
                    if($data->type_user == 'user'){
                        $patente = $_POST['patente'] ?? '';
                        $tipo = $_POST['tipo'] ?? '';
                        if($patente != '' && $tipo != ''){
                            $auto = new Auto($patente,$tipo,$data->_email);
                            $auto->SaveCar();
                        }
                    }
                break;

                default:
                    echo "No ingreso nada valido en la url";
                    break;
            }

            break;
        case 'GET':
            $path = explode('/',$path_info);
            if($path[1] == 'retiro'){
                $token = $_SERVER['HTTP_TOKEN'];
                $data = Auth::GetData($token);
                if($data->type_user == 'user'){
                    $patente= $path[2];
                    Auto::FindCard($patente);
                }
            }
            switch ($path_info) {
                case '/retiro':
                    break;
                case '/ingreso':
                break;
                case '/importe/:tipo':
                break;
                default:
                    # code...
                    break;
            }
        break;
        default:
             echo "No entro a uno de los metodos conocidos";
                        break;
    }


?>