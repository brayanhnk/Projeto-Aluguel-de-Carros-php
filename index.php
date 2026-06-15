<?php 

    session_start();
    
    $url = $_GET['p'] ?? null;

    require "./banco.php";    
    require "./controller/AutenticacaoController.php";
    require "./controller/AluguelController.php";
    require "./controller/ContatoController.php";
    require "./controller/VeiculoController.php";
    require "./controller/SobreNosController.php";
    require_once __DIR__ . "/utilitarios/CsrfUtilitario.php";

    include "./view/componentes/header.php";

    if($url == 'fazer-login'){
        AutenticacaoController::fazerLogin();
    }
    else if($url == 'cadastrar'){
        AutenticacaoController::fazerCadastro();
    }
    else if($url == 'recuperar-senha'){
        AutenticacaoController::recuperarSenha();
    }
    else if($url == 'sobre'){
        SobreNosController::exibirSobre();
    }
    else if($url == "veiculos") {
        VeiculoController::catalogo($pdo);
    }
    else if($url == 'logout'){
        AutenticacaoController::logout();
    }
    else if($url == 'alugar') {
        AluguelController::formularioAluguel($pdo);
    } 
    else if($url == 'confirmar-aluguel') {
        AluguelController::confirmarAluguel($pdo);
    }
    else if($url == 'painel') {
        VeiculoController::painel($pdo);
    }
    else if($url == 'cadastrar-veiculo') {
        VeiculoController::cadastrarVeiculo($pdo);
    } 
    else if($url == 'editar-veiculo') {
        VeiculoController::editarVeiculo($pdo);
    }
    else if($url == 'deletar-veiculo') {
        VeiculoController::deletarVeiculo($pdo);
    }
    else {
        echo "Página não encontrada";
    }

?>