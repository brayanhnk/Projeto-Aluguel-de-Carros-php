<?php

    require_once __DIR__ . "/../model/AluguelModel.php";
    require_once __DIR__ . "/../model/VeiculoModel.php";

    class AluguelController {
        public static function formularioAluguel($pdo) {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {

                if(empty($_SESSION['usuario'])) {
                    header('Location: ?p=fazer-login');
                    exit;
                }

                $token = $_POST['csrf_token'] ?? null;

                CsrfUtilitario::validarCsrf($token);

                $id_veiculo = $_POST['id_veiculo'] ?? null;

                if(empty($id_veiculo) || is_null($id_veiculo)) {
                    header('Location: ?p=veiculos');
                    exit;
                }

                $veiculo = VeiculoModel::buscarVeiculoPorId($pdo, $id_veiculo);
                if (empty($veiculo) || is_null($veiculo) || !$veiculo->disponivel) {
                    header('Location: ?p=veiculos');
                    exit;
                }

                $erro = $_SESSION['erro_aluguel'] ?? null;
                unset($_SESSION['erro_aluguel']);
                $token = CsrfUtilitario::gerarCsrf();
                include_once __DIR__ . '/../view/formularioAluguel.php';

            } else {
                header("Location: ?p=veiculos");
                exit;
            }
        }

        public static function confirmarAluguel($pdo) {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {

                if(empty($_SESSION['usuario'])) {
                    header('Location: ?p=fazer-login');
                    exit;
                }

                $token = $_POST['csrf_token'] ?? null;

                CsrfUtilitario::validarCsrf($token);

                $id_veiculo = $_POST['id_veiculo'] ?? null;

                if(empty($id_veiculo) || is_null($id_veiculo)) {
                    header('Location: ?p=veiculos');
                    exit;
                }

                $veiculo = VeiculoModel::buscarVeiculoPorId($pdo, $id_veiculo);

                if(empty($veiculo) || !$veiculo->disponivel) {
                    header('Location: ?p=veiculos');
                    exit;
                }

                $data_inicio = $_POST['data_inicio'] ?? null;
                $data_fim = $_POST['data_fim'] ?? null;

                if(is_null($data_inicio) || is_null($data_fim)) {
                    header('Location: ?p=veiculos');    
                    exit;                
                }

                if($data_inicio < date('Y-m-d') || $data_fim <= $data_inicio) {
                    $erro = 'Datas inválidas. A retirada deve ser hoje ou depois, e a devolução deve ser após a retirada.';
                    $token = CsrfUtilitario::gerarCsrf();
                    include_once __DIR__ . '/../view/formularioAluguel.php';
                    return;
                }

                $dias = (int) round((strtotime($data_fim) - strtotime($data_inicio)) / 86400);
                $total = $veiculo->preco_diaria * $dias;

                $dados = [
                    'usuario_id' => $_SESSION['id'],
                    'veiculo_id' => $id_veiculo,
                    'data_inicio' => $data_inicio,
                    'data_fim' => $data_fim,
                    'total' => $total,
                    'status' => 'ativo'
                ];

                AluguelModel::inserirAluguel($pdo, $dados);
                VeiculoModel::atualizarDisponibilidade($pdo, $id_veiculo, 0);
                header('Location: ?p=meus-Alugueis');
                exit;
                
            } else {
                header('Location: ?p=veiculos');
                exit;
            }
        }

        public static function meusAlugueis($pdo) {

            if(empty($_SESSION['usuario'])) {
                header('Location: ?p=fazer-login');
                exit;
            }
        
            $mensagem = $_GET['msg'] ?? null;
            $alugueis = AluguelModel::listarAlugueisPorUsuario($pdo, $_SESSION['id']);
            $token    = CsrfUtilitario::gerarCsrf();
        
            include_once __DIR__ . '/../view/meusAlugueis.php';
        }
        public static function devolverAluguel($pdo) {
        
            if(empty($_SESSION['usuario'])) {
                header('Location: ?p=fazer-login');
                exit;
            }
        
            if($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Location: ?p=meus-alugueis');
                exit;
            }
        
            $token = $_POST['csrf_token'] ?? null;
            CsrfUtilitario::validarCsrf($token);
        
            $aluguel_id = (int) ($_POST['aluguel_id'] ?? 0);
        
            if(!$aluguel_id) {
                header('Location: ?p=meus-alugueis&msg=erro');
                exit;
            }
        
            $aluguel = AluguelModel::buscarAluguelPorId($pdo, $aluguel_id);
        
            if(empty($aluguel) || $aluguel->usuario_id != $_SESSION['id']) {
                header('Location: ?p=meus-alugueis&msg=erro');
                exit;
            }
        
            if(!in_array($aluguel->status, ['pendente', 'ativo'])) {
                header('Location: ?p=meus-alugueis&msg=nao_permitido');
                exit;
            }
        
            AluguelModel::atualizarStatus($pdo, $aluguel_id, 'finalizado');
            VeiculoModel::atualizarDisponibilidade($pdo, $aluguel->veiculo_id, 1);
        
            header('Location: ?p=meus-alugueis&msg=devolvido');
            exit;
        }
        public static function alterarAluguel($pdo) {
        
            if(empty($_SESSION['usuario'])) {
                header('Location: ?p=fazer-login');
                exit;
            }
        
            if($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Location: ?p=meus-alugueis');
                exit;
            }
        
            $token = $_POST['csrf_token'] ?? null;
            CsrfUtilitario::validarCsrf($token);
        
            $aluguel_id  = (int) ($_POST['aluguel_id']  ?? 0);
            $data_inicio = $_POST['data_inicio'] ?? null;
            $data_fim    = $_POST['data_fim']    ?? null;
        
            if(!$aluguel_id || !$data_inicio || !$data_fim) {
                header('Location: ?p=meus-alugueis&msg=erro');
                exit;
            }
        
            $aluguel = AluguelModel::buscarAluguelPorId($pdo, $aluguel_id);
        
            if(empty($aluguel) || $aluguel->usuario_id != $_SESSION['id']) {
                header('Location: ?p=meus-alugueis&msg=erro');
                exit;
            }
        
            if(!in_array($aluguel->status, ['pendente', 'ativo'])) {
                header('Location: ?p=meus-alugueis&msg=nao_permitido');
                exit;
            }
        
            if($data_inicio < date('Y-m-d') || $data_fim <= $data_inicio) {
                header('Location: ?p=meus-alugueis&msg=datas_invalidas');
                exit;
            }
        
            $veiculo = VeiculoModel::buscarVeiculoPorId($pdo, $aluguel->veiculo_id);
            $dias    = (int) round((strtotime($data_fim) - strtotime($data_inicio)) / 86400);
            $total   = $veiculo->preco_diaria * $dias;
        
            $dados = [
                'veiculo_id'  => $aluguel->veiculo_id,
                'data_inicio' => $data_inicio,
                'data_fim'    => $data_fim,
                'total'       => $total,
                'status'      => $aluguel->status,
            ];
        
            AluguelModel::editarAluguel($pdo, $aluguel_id, $dados);
        
            header('Location: ?p=meus-alugueis&msg=alterado');
            exit;
        }
        public static function cancelarAluguel($pdo) {
        
            if(empty($_SESSION['usuario'])) {
                header('Location: ?p=fazer-login');
                exit;
            }
        
            if($_SERVER['REQUEST_METHOD'] !== 'POST') {
                header('Location: ?p=meus-alugueis');
                exit;
            }
        
            $token = $_POST['csrf_token'] ?? null;
            CsrfUtilitario::validarCsrf($token);
        
            $aluguel_id = (int) ($_POST['aluguel_id'] ?? 0);
        
            if(!$aluguel_id) {
                header('Location: ?p=meus-alugueis&msg=erro');
                exit;
            }
        
            $aluguel = AluguelModel::buscarAluguelPorId($pdo, $aluguel_id);
        
            if(empty($aluguel) || $aluguel->usuario_id != $_SESSION['id']) {
                header('Location: ?p=meus-alugueis&msg=erro');
                exit;
            }
        
            if(!in_array($aluguel->status, ['pendente', 'ativo'])) {
                header('Location: ?p=meus-alugueis&msg=nao_permitido');
                exit;
            }
        
            AluguelModel::atualizarStatus($pdo, $aluguel_id, 'cancelado');
            VeiculoModel::atualizarDisponibilidade($pdo, $aluguel->veiculo_id, 1);
        
            header('Location: ?p=meus-alugueis&msg=cancelado');
            exit;
        }  

    }

?>