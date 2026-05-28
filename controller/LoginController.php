<?php 

    class LoginController {


        public static function fazerLogin() {
            include __DIR__ . '/../model/UsuarioModel.php';
        
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
                
                $usuario = $_POST['nome'] ?? null;
                $senha = $_POST['senha'] ?? null;
                
                if(is_null($usuario) || is_null($senha)){
                    echo "Preencha os campos";
                    } else {
                        if(fazerLogin($usuario, $senha)){
                            session_start();
                            $_SESSION['usuario'] = $usuario;
                        header('location: ?p=home');
                    } else {
                        return false;
                    } 
                }
            }
            include __DIR__ . '/../view/componentes/login.php';
        }

    }

?>