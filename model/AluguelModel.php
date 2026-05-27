<?php

    class AluguelModel {

        public static function listarAlugueis($pdo) {
            $busca = $pdo->query("
                SELECT a.*, u.nome AS usuario_nome, v.marca, v.modelo
                FROM alugueis a
                JOIN usuarios u ON a.usuario_id = u.id
                JOIN veiculos v ON a.veiculo_id = v.id
            ");
            return $busca->fetchAll();
        }

        public static function listarAlugueisPorUsuario($pdo, $usuario_id) {
            $busca = $pdo->prepare("
                SELECT a.*, v.marca, v.modelo, v.tipo
                FROM alugueis a
                JOIN veiculos v ON a.veiculo_id = v.id
                WHERE a.usuario_id = ?
                ORDER BY a.criado_em DESC
            ");
            $busca->execute([$usuario_id]);
            return $busca->fetchAll();
        }

        public static function buscarAluguelPorId($pdo, $id) {
            $busca = $pdo->prepare("
                SELECT a.*, u.nome AS usuario_nome, v.marca, v.modelo
                FROM alugueis a
                JOIN usuarios u ON a.usuario_id = u.id
                JOIN veiculos v ON a.veiculo_id = v.id
                WHERE a.id = ?
            ");
            $busca->execute([$id]);
            return $busca->fetch();
        }

        public static function inserirAluguel($pdo, $dados) {
            $busca = $pdo->prepare("
                INSERT INTO alugueis (usuario_id, veiculo_id, data_inicio, data_fim, total, status)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $busca->execute([
                $dados['usuario_id'],
                $dados['veiculo_id'],
                $dados['data_inicio'],
                $dados['data_fim'],
                $dados['total'],
                $dados['status'] ?? 'pendente'
            ]);
            return $pdo->lastInsertId();
        }

        public static function editarAluguel($pdo, $id, $dados) {
            $busca = $pdo->prepare("
                UPDATE alugueis
                SET veiculo_id = ?, data_inicio = ?, data_fim = ?, total = ?, status = ?
                WHERE id = ?
            ");
            $busca->execute([
                $dados['veiculo_id'],
                $dados['data_inicio'],
                $dados['data_fim'],
                $dados['total'],
                $dados['status'],
                $id
            ]);
            return $busca->rowCount();
        }

        public static function deletarAluguel($pdo, $id) {
            $busca = $pdo->prepare("DELETE FROM alugueis WHERE id = ?");
            $busca->execute([$id]);
            return $busca->rowCount();
        }

        public static function atualizarStatus($pdo, $id, $status) {
            $busca = $pdo->prepare("UPDATE alugueis SET status = ? WHERE id = ?");
            $busca->execute([$status, $id]);
            return $busca->rowCount();
        }

    }

?>