<?php 

    function addUsuario($usuario, $cpf, $dataNascimento, $email, $telefone, $senha) {
        global $pdo;
        
        try {
            $resp = $pdo->prepare("
                INSERT INTO usuarios (id, nome, cpf, data_nascimento, email, telefone, senha)
                VALUES (null, :nome, :cpf, :data_nascimento, :email, :telefone, :senha)
            ");
            
            $resp->execute([
                ':nome'           => $usuario,
                ':cpf'            => $cpf,
                ':data_nascimento'=> $dataNascimento,
                ':email'          => $email,
                ':telefone'       => $telefone,
                ':senha'          => $senha
                ]);
                
                return true; 

        } catch (PDOException $e) {
            error_log("Erro ao inserir usuário: " . $e->getMessage());
            return false; 
        }
    }

    function recuperarSenha($cpf, $dataNascimento, $novaSenha){
        
        global $pdo;
        $resp = $pdo->query("SELECT * FROM usuarios WHERE cpf='$cpf' AND data_nascimento='$dataNascimento';");

        if($resp->rowCount() > 0){
            $hash = password_hash($novaSenha, PASSWORD_DEFAULT);
            $pdo->query("UPDATE usuarios SET senha='$hash' WHERE cpf='$cpf';");
            return true;
        } else {
            echo "Usuário não encontrado";
            return false;
        }
    }

    function fazerLogin($usuario, $senha){

        global $pdo;
        $resp = $pdo->query("SELECT * FROM usuarios WHERE nome='$usuario';");

        if($resp->rowCount() > 0){
            $usu = $resp->fetch();
            if(password_verify($senha, $usu->senha)){
                    session_start();
                    $_SESSION['usuario'] = $usuario;
                    $_SESSION['id'] = $usu->id;
                    $_SESSION['perfil'] = $usu->perfil;
                    return true;
                } else {
                    return false;
            }
        } else {
              return false;
        }
    }

    function emailExisteNoBanco($email) {

        global $pdo;
        try {
            $resp = $pdo->prepare("SELECT COUNT(*) as count FROM usuarios WHERE email = :email");
            $resp->execute([':email' => $email]);
            $result = $resp->fetch(PDO::FETCH_ASSOC);  
            return $result['count'] > 0;
        } catch (PDOException $e) {
            error_log("Erro ao verificar email: " . $e->getMessage());
            return false;
        }
    }

    function cpfExisteNoBanco($cpf) {

        global $pdo;
        try {
            $resp = $pdo->prepare("SELECT COUNT(*) as count FROM usuarios WHERE cpf = :cpf");
            $resp->execute([':cpf' => $cpf]);
            $result = $resp->fetch(PDO::FETCH_ASSOC);  
            return $result['count'] > 0;
        } catch (PDOException $e) {
            error_log("Erro ao verificar CPF: " . $e->getMessage());
            return false;
        }
    }

?>