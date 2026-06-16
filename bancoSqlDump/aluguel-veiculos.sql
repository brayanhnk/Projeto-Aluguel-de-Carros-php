-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29/05/2026 às 03:53
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

CREATE DATABASE IF NOT EXISTS `aluguel-veiculos`
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE `aluguel-veiculos`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

DROP USER IF EXISTS 'aluguel_user'@'localhost';
CREATE USER 'aluguel_user'@'localhost' IDENTIFIED BY 'aluguel123';
GRANT ALL PRIVILEGES ON `aluguel-veiculos`.* TO 'aluguel_user'@'localhost';
FLUSH PRIVILEGES;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `aluguel-veiculos`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `alugueis`
--

CREATE TABLE `alugueis` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `veiculo_id` int(11) NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` enum('pendente','ativo','finalizado','cancelado') DEFAULT 'pendente',
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `alugueis`
--

INSERT INTO `alugueis` (`id`, `usuario_id`, `veiculo_id`, `data_inicio`, `data_fim`, `total`, `status`, `criado_em`) VALUES
(1, 2, 1, '2026-05-01', '2026-05-05', 600.00, 'finalizado', '2026-04-30 10:00:00'),
(2, 3, 4, '2026-05-10', '2026-05-12', 220.00, 'finalizado', '2026-05-09 09:00:00'),
(3, 4, 6, '2026-05-20', '2026-05-22', 180.00, 'ativo', '2026-05-19 14:00:00'),
(4, 5, 3, '2026-05-25', '2026-05-30', 1000.00, 'ativo', '2026-05-24 11:00:00'),
(5, 2, 10, '2026-06-01', '2026-06-03', 280.00, 'pendente', '2026-05-25 08:00:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `enderecos`
--

CREATE TABLE `enderecos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `rua` varchar(100) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `bairro` varchar(50) DEFAULT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `estado` char(2) DEFAULT NULL,
  `cep` varchar(9) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `enderecos`
--

INSERT INTO `enderecos` (`id`, `usuario_id`, `rua`, `numero`, `bairro`, `cidade`, `estado`, `cep`) VALUES
(1, 1, 'Rua das Flores', '100', 'Centro', 'Curitiba', 'PR', '80010-000'),
(2, 2, 'Av. Paraná', '250', 'Batel', 'Curitiba', 'PR', '80420-100'),
(3, 3, 'Rua das Palmeiras', '33', 'Água Verde', 'Curitiba', 'PR', '80620-050'),
(4, 4, 'Rua São Paulo', '88', 'Portão', 'Curitiba', 'PR', '81070-000'),
(5, 5, 'Alameda das Rosas', '5', 'Bigorrilho', 'Curitiba', 'PR', '80430-200');

-- --------------------------------------------------------

--
-- Estrutura para tabela `noticias`
--

CREATE TABLE `noticias` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `conteudo` text NOT NULL,
  `autor_id` int(11) NOT NULL,
  `publicado` tinyint(1) DEFAULT 1,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `noticias`
--

INSERT INTO `noticias` (`id`, `titulo`, `conteudo`, `autor_id`, `publicado`, `criado_em`, `atualizado_em`) VALUES
(1, 'Bônus especial para quem tirou CNH nos últimos 20 dias', 'Motoristas habilitados recentemente ganham 15% de desconto na primeira locação. Não perca essa oportunidade!', 1, 1, '2026-05-01 08:00:00', '2026-05-27 03:03:05'),
(2, 'Nova frota de SUVs chegou', 'Adicionamos 5 novos modelos SUV à nossa frota para o inverno. Mais espaço e conforto para toda a família nas estradas.', 1, 1, '2026-05-10 09:30:00', '2026-05-27 03:03:05'),
(3, 'Promoção de motos para o mês de junho', 'Aluguel de motos com até 20% de desconto durante todo o mês de junho. Aproveite a mobilidade urbana com economia.', 1, 1, '2026-05-18 11:00:00', '2026-05-27 03:03:05'),
(4, 'Cuidados essenciais ao alugar um veículo', 'Confira nossas dicas para garantir uma locação segura: verifique os documentos, inspecione o veículo e conheça as coberturas do seguro.', 1, 1, '2026-05-20 14:00:00', '2026-05-27 03:03:05'),
(5, 'Expansão: novos pontos de retirada em Curitiba', 'A partir de junho, você poderá retirar e devolver veículos em mais 3 pontos na cidade. Mais praticidade para você.', 1, 1, '2026-05-22 16:00:00', '2026-05-27 03:03:05');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pagamentos`
--

CREATE TABLE `pagamentos` (
  `id` int(11) NOT NULL,
  `aluguel_id` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `metodo` enum('cartao','pix','boleto') NOT NULL,
  `status` enum('pendente','aprovado','recusado') DEFAULT 'pendente',
  `pago_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pagamentos`
--

INSERT INTO `pagamentos` (`id`, `aluguel_id`, `valor`, `metodo`, `status`, `pago_em`) VALUES
(1, 1, 600.00, 'pix', 'aprovado', '2026-04-30 10:05:00'),
(2, 2, 220.00, 'cartao', 'aprovado', '2026-05-09 09:10:00'),
(3, 3, 180.00, 'boleto', 'aprovado', '2026-05-19 14:15:00'),
(4, 4, 1000.00, 'cartao', 'aprovado', '2026-05-24 11:20:00'),
(5, 5, 280.00, 'pix', 'pendente', '2026-05-25 08:00:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `cpf` varchar(14) NOT NULL,
  `data_nascimento` date DEFAULT NULL,
  `perfil` enum('admin','cliente') DEFAULT 'cliente',
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `telefone`, `cpf`, `data_nascimento`, `perfil`, `criado_em`) VALUES
(1, 'Admin Sistema', 'admin@aluguel.com', '$2y$10$mNf/YYYfjDKKWmXbxS6KeuKdJRS7QGZ3XXd8Nnoxik1RUiM1Ltj8C', '41999990001', '00000000001', '1990-01-01', 'admin', '2026-01-01 00:00:00'),
(2, 'Cauê Silva', 'caue@gmail.com', '$2y$10$mNf/YYYfjDKKWmXbxS6KeuKdJRS7QGZ3XXd8Nnoxik1RUiM1Ltj8C', '41996813503', '09842017468', '2006-07-27', 'cliente', '2026-05-21 04:02:45'),
(3, 'Ana Souza', 'ana@gmail.com', '$2y$10$mNf/YYYfjDKKWmXbxS6KeuKdJRS7QGZ3XXd8Nnoxik1RUiM1Ltj8C', '41988880002', '11122233344', '1995-03-15', 'cliente', '2026-02-10 10:00:00'),
(4, 'Carlos Lima', 'carlos@gmail.com', '$2y$10$mNf/YYYfjDKKWmXbxS6KeuKdJRS7QGZ3XXd8Nnoxik1RUiM1Ltj8C', '41977770003', '22233344455', '1988-07-22', 'cliente', '2026-03-05 14:30:00'),
(5, 'Mariana Costa', 'mariana@gmail.com', '$2y$10$mNf/YYYfjDKKWmXbxS6KeuKdJRS7QGZ3XXd8Nnoxik1RUiM1Ltj8C', '41966660004', '33344455566', '2000-11-30', 'cliente', '2026-04-18 09:15:00'),
(6, 'caue', '', '$2y$10$ilISn6ac7aXEh2aRNitASeGnkJbme1kZeqa5WasfaaDB8Gt2nxmbq', NULL, '', NULL, 'cliente', '2026-05-28 23:08:44'),
(13, 'jonas', 'jonas@gmail.com', '$2y$10$/P20tNeCbgO2qNZNYHa8OejaTMB6DtUMbEYCbTzjSoWv4f2MXZuoK', NULL, '142', '2006-08-24', 'cliente', '2026-05-29 00:58:28'),
(15, 'jose', 'caue.alves2707@gmail.com', '$2y$10$1YDd6ffxGAakiRvnmoIr.OZGTmaz8wH5VnPP/SX40IBNusxaO3Hr2', NULL, '12321', '2006-03-27', 'cliente', '2026-05-29 00:58:59');

-- --------------------------------------------------------

--
-- Estrutura para tabela `veiculos`
--

CREATE TABLE `veiculos` (
  `id` int(11) NOT NULL,
  `tipo` enum('carro','moto') NOT NULL DEFAULT 'carro',
  `marca` varchar(50) NOT NULL,
  `modelo` varchar(50) NOT NULL,
  `ano` int(11) NOT NULL,
  `cor` varchar(30) DEFAULT NULL,
  `placa` varchar(10) NOT NULL,
  `categoria` enum('Econômico','Intermediário','SUV','Luxo','Esportiva','Utilitária') NOT NULL,
  `preco_diaria` decimal(10,2) NOT NULL,
  `disponivel` tinyint(1) DEFAULT 1,
  `quilometragem` int(11) DEFAULT 0,
  `imagem` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `veiculos`
--

INSERT INTO `veiculos` (`id`, `tipo`, `marca`, `modelo`, `ano`, `cor`, `placa`, `categoria`, `preco_diaria`, `disponivel`, `quilometragem`, `imagem`) VALUES
(1, 'carro', 'Toyota', 'Corolla', 2022, 'Prata', 'BRA2E23', 'Intermediário', 210.00, 1, 45000, 'corolla.png'),
(2, 'carro', 'Honda', 'Civic', 2023, 'Prata', 'GHT3F45', 'Intermediário', 220.00, 1, 30000, 'civic.png'),
(3, 'carro', 'Volkswagen', 'T-Cross', 2022, 'Preto', 'MNO4G67', 'SUV', 200.00, 0, 45000, 'tcross.png'),
(4, 'carro', 'Chevrolet', 'Onix', 2023, 'Azul', 'PQR5H89', 'Econômico', 110.00, 1, 20000, 'onix.png'),
(5, 'carro', 'Jeep', 'Compass', 2021, 'Branco', 'STU6I01', 'SUV', 250.00, 1, 60000, 'compass.png'),
(6, 'moto', 'Honda', 'CB 500', 2022, 'Preto', 'VWX7J23', 'Esportiva', 180.00, 0, 24000, 'cb500.png'),
(7, 'moto', 'Yamaha', 'MT-07', 2023, 'Preto', 'YZA8K45', 'Esportiva', 230.00, 1, 15000, 'mt07.png'),
(8, 'moto', 'Honda', 'CG 160', 2021, 'Branco, vermelho e azul', 'BCD9L67', 'Utilitária', 90.00, 1, 60000, 'cg160.png'),
(9, 'moto', 'Yamaha', 'Fazer 250', 2022, 'Azul', 'EFG0M89', 'Utilitária', 110.00, 1, 30000, 'fazer250.png'),
(10, 'moto', 'Kawasaki', 'Ninja 400', 2023, 'Preto', 'HIJ1N01', 'Esportiva', 260.00, 0, 15000, 'ninja400.png');

-- --------------------------------------------------------

--
-- Estrutura para tabela `mensagens_contato`
--

CREATE TABLE `mensagens_contato` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `assunto` varchar(150) NOT NULL,
  `mensagem` text NOT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `alugueis`
--
ALTER TABLE `alugueis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `veiculo_id` (`veiculo_id`);

--
-- Índices de tabela `enderecos`
--
ALTER TABLE `enderecos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autor_id` (`autor_id`);

--
-- Índices de tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aluguel_id` (`aluguel_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cpf` (`cpf`);

--
-- Índices de tabela `veiculos`
--
ALTER TABLE `veiculos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `placa` (`placa`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `alugueis`
--
ALTER TABLE `alugueis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `enderecos`
--
ALTER TABLE `enderecos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de tabela `veiculos`
--
ALTER TABLE `veiculos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `mensagens_contato`
--
ALTER TABLE `mensagens_contato`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `alugueis`
--
ALTER TABLE `alugueis`
  ADD CONSTRAINT `alugueis_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `alugueis_ibfk_2` FOREIGN KEY (`veiculo_id`) REFERENCES `veiculos` (`id`);

--
-- Restrições para tabelas `enderecos`
--
ALTER TABLE `enderecos`
  ADD CONSTRAINT `enderecos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Restrições para tabelas `noticias`
--
ALTER TABLE `noticias`
  ADD CONSTRAINT `noticias_ibfk_1` FOREIGN KEY (`autor_id`) REFERENCES `usuarios` (`id`);

--
-- Restrições para tabelas `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD CONSTRAINT `pagamentos_ibfk_1` FOREIGN KEY (`aluguel_id`) REFERENCES `alugueis` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
