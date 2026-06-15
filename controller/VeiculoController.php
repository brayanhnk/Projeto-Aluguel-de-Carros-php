<?php

    require_once __DIR__ . "/../model/VeiculoModel.php";

    class VeiculoController {
        public static function catalogo($pdo) {

            $veiculos = VeiculoModel::listarVeiculos($pdo);

            $token = CsrfUtilitario::gerarCsrf();

            $categorias = VeiculoModel::listarCategorias($pdo);
            include_once __DIR__ . "/../view/veiculos.php";
        }

        public static function painel($pdo) {
            include __DIR__ . "/../funcoes.php";

            requerAdmin();
    
            $veiculos = VeiculoModel::listarVeiculos($pdo);
            $mensagem = $_GET['msg'] ?? null;

            $token = CsrfUtilitario::gerarCsrf();
    
            include __DIR__ . '/../view/painel.php';
        }

        public static function cadastrarVeiculo($pdo) {
            include __DIR__ . "/../funcoes.php";

            requerAdmin();
    
            $erros = [];
            $dados = [];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                CsrfUtilitario::validarCsrf($_POST['csrf_token']);

                $tipo = $_POST['tipo'] ?? null;
                $marca = trim($_POST['marca'] ?? null);
                $modelo = trim($_POST['modelo'] ?? null);
                $ano = trim($_POST['ano'] ?? null);
                $cor = trim($_POST['cor'] ?? null);
                $placa = strtoupper(trim($_POST['placa'] ?? null));
                $categoria = $_POST['categoria'] ?? null;
                $preco_diaria = trim($_POST['preco_diaria'] ?? null);
                $quilometragem = trim($_POST['quilometragem'] ?? null);
                $imagem = null;
                $disponivel = 1;

                $tiposValidos = ['carro', 'moto'];
                $categoriasValidas = ['Econômico', 'Intermediário', 'SUV', 'Luxo', 'Esportiva', 'Utilitária'];
                $anoAtual = (int) date('Y');

                if (!in_array($tipo, $tiposValidos)) {
                    $erros[] = 'Tipo de veículo inválido.';
                }
                if (campoVazio($marca)) {
                    $erros[] = 'A marca é obrigatória.';
                }
                if (campoVazio($modelo)) {
                    $erros[] = 'O modelo é obrigatório.';
                }
                if (campoVazio($ano) || (int)$ano < 1900 || (int)$ano > $anoAtual + 1) {
                    $erros[] = 'Ano inválido.';
                }
                if (campoVazio($placa)) {
                    $erros[] = 'A placa é obrigatória.';
                } else if (!preg_match('/^[A-Z]{3}[0-9][A-Z0-9][0-9]{2}$/', $placa)) {
                    $erros[] = 'Placa inválida. Use o formato antigo (AAA9999) ou Mercosul (AAA9A99).';
                }
                if (!in_array($categoria, $categoriasValidas)) {
                    $erros[] = 'Categoria inválida.';
                }
                if (campoVazio($preco_diaria) || (float)$preco_diaria <= 0) {
                    $erros[] = 'Preço por diária inválido.';
                }
                if (campoVazio($quilometragem) || (int)$quilometragem < 0) {
                    $erros[] = 'Quilometragem inválida.';
                }

                if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] !== UPLOAD_ERR_NO_FILE) {
                    $file = $_FILES['imagem'];
                    $extPermitidas = ['jpg', 'jpeg', 'png', 'webp'];
                    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                    $maxBytes = 2 * 1024 * 1024;

                    if ($file['error'] !== UPLOAD_ERR_OK) {
                        $erros[] = 'Erro ao enviar a imagem.';
                    } elseif (!in_array($ext, $extPermitidas)) {
                        $erros[] = 'Formato de imagem inválido. Use PNG, JPG ou WEBP.';
                    } elseif ($file['size'] > $maxBytes) {
                        $erros[] = 'A imagem deve ter no máximo 2MB.';
                    } else {
                        $nomeArquivo = uniqid('veiculo_') . '.' . $ext;
                        $destino = __DIR__ . '/../imagens/' . $nomeArquivo;

                        if (move_uploaded_file($file['tmp_name'], $destino)) {
                            $imagem = $nomeArquivo;
                        } else {
                            $erros[] = 'Não foi possível salvar a imagem. Verifique as permissões da pasta.';
                        }
                    }
                }

                if (empty($erros)) {
                    $dados = [
                        'tipo' => $tipo,
                        'marca' => $marca,
                        'modelo' => $modelo,
                        'ano' => (int) $ano,
                        'cor' => $cor,
                        'placa' => $placa,
                        'categoria' => $categoria,
                        'preco_diaria' => (float) $preco_diaria,
                        'disponivel' => $disponivel,
                        'quilometragem' => (int) $quilometragem,
                        'imagem' => $imagem
                    ];

                    $linhasAfetadas = VeiculoModel::inserirVeiculo($pdo, $dados);

                    if($linhasAfetadas === 0) {
                        $erros[] = 'Erro ao cadastrar o veículo. Tente novamente.';
                    } else {
                        header('Location: ?p=painel&msg=cadastrado');
                        exit;
                    }
                }
            }

            $token = CsrfUtilitario::gerarCsrf();
            $categorias = ['Econômico', 'Intermediário', 'SUV', 'Luxo', 'Esportiva', 'Utilitária'];
            include __DIR__ . '/../view/cadastrarVeiculo.php';
        }

        public static function editarVeiculo($pdo) {
            include __DIR__ . "/../funcoes.php";
            requerAdmin();

            $id = $_GET['id'] ?? null;
            $veiculo = VeiculoModel::buscarVeiculoPorId($pdo, $id);
 
            if (!$veiculo) {
                header('Location: ?p=painel&msg=nao_encontrado');
                exit;
            }
 
            $erros = [];
            $dados = (array) $veiculo;
 
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                CsrfUtilitario::validarCsrf($_POST['csrf_token']);

                $tipo = $_POST['tipo'] ?? null;
                $marca = trim($_POST['marca'] ?? null);
                $modelo = trim($_POST['modelo'] ?? null);
                $ano = trim($_POST['ano'] ?? null);
                $cor = trim($_POST['cor'] ?? null);
                $placa = strtoupper(trim($_POST['placa'] ?? null));
                $categoria = $_POST['categoria'] ?? null;
                $preco_diaria = trim($_POST['preco_diaria'] ?? null);
                $quilometragem = trim($_POST['quilometragem'] ?? null);
                $disponivel = $_POST['disponivel'] ?? null;

                $tiposValidos = ['carro', 'moto'];
                $categoriasValidas = ['Econômico', 'Intermediário', 'SUV', 'Luxo', 'Esportiva', 'Utilitária'];
                $anoAtual = (int) date('Y');

                if (!in_array($tipo, $tiposValidos)) {
                    $erros[] = 'Tipo de veículo inválido.';
                }                                              
                if (campoVazio($marca)) {
                    $erros[] = 'A marca é obrigatória.';
                }                                                          
                if (campoVazio($modelo)) {
                    $erros[] = 'O modelo é obrigatório.';
                }                
                if (campoVazio($ano) || (int)$ano < 1900 || (int)$ano > $anoAtual + 1) {
                    $erros[] = 'Ano inválido.';
                }           
                if (campoVazio($placa)) {
                    $erros[] = 'A placa é obrigatória.';
                } else if (!preg_match('/^[A-Z]{3}[0-9][A-Z0-9][0-9]{2}$/', $placa)) {
                    $erros[] = 'Placa inválida. Use o formato AAA9999 ou Mercosul AAA9A99.';
                }               
                if (!in_array($categoria, $categoriasValidas)) {
                    $erros[] = 'Categoria inválida.';
                }                                   
                if (campoVazio($preco_diaria) || (float)$preco_diaria <= 0) {
                    $erros[] = 'Preço por diária inválido.';
                }                       
                if (!campoVazio($quilometragem) && (int)$quilometragem < 0) {
                    $erros[] = 'Quilometragem inválida.';
                }                     

                $imagemAtual = $veiculo->imagem ?? null;

                if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] !== UPLOAD_ERR_NO_FILE) {
                    $file = $_FILES['imagem'];
                    $extPermitidas = ['jpg', 'jpeg', 'png', 'webp'];
                    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                    $maxBytes = 2 * 1024 * 1024;

                    if ($file['error'] !== UPLOAD_ERR_OK) {
                        $erros[] = 'Erro ao enviar a imagem.';
                    } elseif (!in_array($ext, $extPermitidas)) {
                        $erros[] = 'Formato de imagem inválido. Use PNG, JPG ou WEBP.';
                    } elseif ($file['size'] > $maxBytes) {
                        $erros[] = 'A imagem deve ter no máximo 2MB.';
                    } else {
                        $nomeArquivo = uniqid('veiculo_') . '.' . $ext;
                        $destino = __DIR__ . '/../imagens/' . $nomeArquivo;

                        if (move_uploaded_file($file['tmp_name'], $destino)) {
                            $imagem = $nomeArquivo;
                        } else {
                            $erros[] = 'Não foi possível salvar a imagem. Verifique as permissões da pasta.';
                        }
                    }
                } else {
                    $imagem = $imagemAtual;
                }

                if (empty($erros)) {
                    $dados = [
                        'tipo' => $tipo,
                        'marca' => $marca,
                        'modelo' => $modelo,
                        'ano' => (int) $ano,
                        'cor' => $cor ?: null,
                        'placa' => $placa,
                        'categoria' => $categoria,
                        'preco_diaria' => (float) $preco_diaria,
                        'disponivel' => $disponivel,
                        'quilometragem' => (int) ($quilometragem ?: 0),
                        'imagem' => $imagem,
                    ];

                    $linhasAfetadas = VeiculoModel::editarVeiculo($pdo, $id, $dados);
                    if($linhasAfetadas === 0) {
                        header('Location: ?p=painel&msg=sem_alteracao');
                        exit;
                    }
                    header('Location: ?p=painel&msg=editado');
                    exit;
                }

                $dados = $_POST;
                $dados['id'] = $id;
                $dados['imagem'] = $imagem;
            }

            $token = CsrfUtilitario::gerarCsrf();

            $categorias = ['Econômico', 'Intermediário', 'SUV', 'Luxo', 'Esportiva', 'Utilitária'];
            include __DIR__ . '/../view/editarVeiculo.php';
        }

        public static function deletarVeiculo($pdo) {
            include __DIR__ . "/../funcoes.php";
            requerAdmin();

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                CsrfUtilitario::validarCsrf($_POST['csrf_token']);

                $id = $_POST['id'] ?? null;

                if(is_null($id) || empty($id)) {
                    header('Location: ?p=painel&msg=nao_encontrado');
                    exit;
                }

                if (VeiculoModel::veiculoTemAluguelVinculado($pdo, $id)) {
                    header('Location: ?p=painel&msg=veiculo_com_historico');
                    exit;
                }

                $linhasAfetadas = VeiculoModel::deletarVeiculo($pdo, $id);

                if($linhasAfetadas === 0) {
                    header('Location: ?p=painel&msg=nao_encontrado');
                    exit;
                }

                header('Location: ?p=painel&msg=deletado');
                exit;
            } else {
                header('Location: ?p=painel');
                exit;
            }
        }
    }

?>