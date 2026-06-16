<?php

class ContatoModel {
    public static function inserirMensagem($pdo, $nome, $email, $assunto, $mensagem) {
        $stmt = $pdo->prepare(
            "INSERT INTO mensagens_contato (nome, email, assunto, mensagem) VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([$nome, $email, $assunto, $mensagem]);
    }
}

?>
