<?php 

    function validaCamposLogin($usuario, $senha){
        return empty(trim((string) $usuario)) || empty(trim((string) $senha));
    }

    function validaCamposRecuperarSenha($cpf, $dataNascimento, $novaSenha){
        return empty(trim((string) $cpf))
            || empty(trim((string) $dataNascimento))
            || empty(trim((string) $novaSenha));
    }

    function validarFormatoEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    function validarFormatoTelefone($telefone) {
        $telefone = preg_replace('/[^0-9]/', '', $telefone);
        return strlen($telefone) >= 10 && strlen($telefone) <= 11;
    }

    function validarDataNascimento($dataNascimento) {
        if (empty($dataNascimento)) return false;
        return checkdate(explode('-', $dataNascimento)[1], explode('-', $dataNascimento)[2], explode('-', $dataNascimento)[0]);
    }

    function validarUsuario($usuario) {
        $usuario = trim($usuario);
        return !empty($usuario) && strlen($usuario) >= 3 && preg_match('/^[a-zA-Z0-9\s_-]+$/', $usuario);
    }

    function validaCamposCadastro($usuario, $cpf, $dataNascimento, $email, $telefone, $senha) {
        $erros = [];
        
        if (empty(trim($usuario)) || !validarUsuario($usuario)) {
            $erros[] = 'Nome de usuário inválido. Deve ter mínimo 3 caracteres.';
        }
        
        if (empty(trim($cpf))) {
            $erros[] = 'CPF é obrigatório.';
        } elseif (cpfExisteNoBanco($cpf)) {
            $erros[] = 'Este CPF já está registrado no sistema.';
        }
        
        if (empty(trim($dataNascimento))) {
            $erros[] = 'Data de nascimento é obrigatória.';
        } elseif (!validarDataNascimento($dataNascimento)) {
            $erros[] = 'Data de nascimento inválida.';
        }
        
        if (empty(trim($email))) {
            $erros[] = 'E-mail é obrigatório.';
        } elseif (!validarFormatoEmail($email)) {
            $erros[] = 'E-mail inválido.';
        } elseif (emailExisteNoBanco($email)) {
            $erros[] = 'Este e-mail já está registrado no sistema.';
        }
        
        if (empty(trim($telefone))) {
            $erros[] = 'Telefone é obrigatório.';
        } elseif (!validarFormatoTelefone($telefone)) {
            $erros[] = 'Telefone inválido. Use formato (00) 00000-0000.';
        }
        
        global $errosCadastro;
        $errosCadastro = $erros;
        
        return !empty($erros);
    }

    function requerAdmin() {
        if (($_SESSION['perfil'] ?? '') !== 'admin') {
            header('Location: ?p=fazer-login');
            exit;
        }
    }

    function campoVazio($valor) {
        return is_null($valor) || empty($valor);
    }

?>