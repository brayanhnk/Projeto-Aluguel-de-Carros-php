<?php

    class VeiculoModel {

        public static function listarVeiculos($pdo) {
            return $pdo->query("SELECT * FROM veiculos")->fetchAll();
        }

        public static function buscarVeiculoPorId($pdo, $id) {
            $busca = $pdo->prepare("SELECT * FROM veiculos WHERE id = ?");
            $busca->execute([$id]);
            return $busca->fetch();
        }

        public static function inserirVeiculo($pdo, $dados) {
            $busca = $pdo->prepare("
                INSERT INTO veiculos (tipo, marca, modelo, ano, cor, placa, categoria, preco_diaria, disponivel, quilometragem, imagem)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $busca->execute([
                $dados['tipo'],
                $dados['marca'],
                $dados['modelo'],
                $dados['ano'],
                $dados['cor'],
                $dados['placa'],
                $dados['categoria'],
                $dados['preco_diaria'],
                $dados['disponivel'],
                $dados['quilometragem'],
                $dados['imagem']
            ]);
            return $pdo->lastInsertId();
        }

        public static function editarVeiculo($pdo, $id, $dados) {
            $busca = $pdo->prepare("
                UPDATE veiculos
                SET tipo = ?, marca = ?, modelo = ?, ano = ?, cor = ?, placa = ?, categoria = ?, preco_diaria = ?, disponivel = ?, quilometragem = ?, imagem = ?
                WHERE id = ?
            ");
            $busca->execute([
                $dados['tipo'],
                $dados['marca'],
                $dados['modelo'],
                $dados['ano'],
                $dados['cor'],
                $dados['placa'],
                $dados['categoria'],
                $dados['preco_diaria'],
                $dados['disponivel'],
                $dados['quilometragem'],
                $dados['imagem'],
                $id
            ]);
            return $busca->rowCount();
        }

        public static function deletarVeiculo($pdo, $id) {
            $busca = $pdo->prepare("DELETE FROM veiculos WHERE id = ?");
            $busca->execute([$id]);
            return $busca->rowCount();
        }

    }

?>