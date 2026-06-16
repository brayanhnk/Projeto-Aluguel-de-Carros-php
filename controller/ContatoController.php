<?php

require_once __DIR__ . '/../model/ContatoModel.php';

class ContatoController {
    public static function exibirContato($pdo) {

        $mensagemErro = "";
        $mensagemSucesso = "";

        $nome = "";
        $email = "";
        $assunto = "";
        $mensagemUsuario = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $nome = trim($_POST["nome"] ?? "");
            $email = trim($_POST["email"] ?? "");
            $assunto = trim($_POST["assunto"] ?? "");
            $mensagemUsuario = trim($_POST["mensagem"] ?? "");

            // Validação simples
            if (empty($nome) || empty($email) || empty($assunto) || empty($mensagemUsuario)) {
                $mensagemErro = "Por favor, preencha todos os campos.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $mensagemErro = "Por favor, insira um email válido.";
            } else {
                if (ContatoModel::inserirMensagem($pdo, $nome, $email, $assunto, $mensagemUsuario)) {
                    $mensagemSucesso = "Mensagem recebida! Nossa equipe entrará em contato em breve.";
                    
                    // Limpa os campos após o envio
                    $nome = "";
                    $email = "";
                    $assunto = "";
                    $mensagemUsuario = "";
                } else {
                    $mensagemErro = "Ocorreu um erro ao enviar a mensagem. Por favor, tente novamente.";
                }
            }
        }

        include "./view/contato.php";
    }
}
?>