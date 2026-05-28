<?php 

    // function addUsuario($usuario, $senha){
    //     global $banco;
    //     $banco->query("INSERT INTO usuarios (id, nome, senha) VALUES (null, '$usuario', '$senha');");
    // }

    function fazerLogin($usuario, $senha){

        global $pdo;
        $resp = $pdo->query("SELECT * FROM usuarios WHERE nome='$usuario';");

        if($resp->rowCount() > 0){
            $usu = $resp->fetch();
            if(password_verify($senha, $usu->senha)){
                    session_start();
                    $_SESSION['usuario'] = $usuario;
                    $_SESSION['id'] = $usu->id;
                    return true;
                } else {
                    echo "ERRO - SENHA";
                    return false;
            }
        } else {
              echo "ERRO - USUÁRIO";
              return false;
        }
    }

?>