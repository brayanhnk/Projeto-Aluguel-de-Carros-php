-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2026 at 08:51 PM
-- Server version: 8.0.43
-- PHP Version: 8.2.12

CREATE DATABASE IF NOT EXISTS `aluguel-veiculos`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE `aluguel-veiculos`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;

DROP USER IF EXISTS 'aluguel_user'@'localhost';
CREATE USER 'aluguel_user'@'localhost' IDENTIFIED BY 'aluguel123';
GRANT ALL PRIVILEGES ON `aluguel-veiculos`.* TO 'aluguel_user'@'localhost';
FLUSH PRIVILEGES;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `aluguel-veiculos`
--

-- --------------------------------------------------------

--
-- Table structure for table `alugueis`
--

CREATE TABLE `alugueis` (
  `id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `veiculo_id` int NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` enum('pendente','ativo','finalizado','cancelado') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'pendente',
  `criado_em` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alugueis`
--

INSERT INTO `alugueis` (`id`, `usuario_id`, `veiculo_id`, `data_inicio`, `data_fim`, `total`, `status`, `criado_em`) VALUES
(1, 2, 1, '2026-05-01', '2026-05-05', 600.00, 'finalizado', '2026-04-30 10:00:00'),
(2, 3, 4, '2026-05-10', '2026-05-12', 220.00, 'finalizado', '2026-05-09 09:00:00'),
(3, 4, 6, '2026-05-20', '2026-05-22', 180.00, 'ativo', '2026-05-19 14:00:00'),
(4, 5, 3, '2026-05-25', '2026-05-30', 1000.00, 'ativo', '2026-05-24 11:00:00'),
(5, 2, 10, '2026-06-01', '2026-06-03', 280.00, 'pendente', '2026-05-25 08:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `enderecos`
--

CREATE TABLE `enderecos` (
  `id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `rua` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `numero` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `bairro` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cidade` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estado` char(2) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cep` varchar(9) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enderecos`
--

INSERT INTO `enderecos` (`id`, `usuario_id`, `rua`, `numero`, `bairro`, `cidade`, `estado`, `cep`) VALUES
(1, 1, 'Rua das Flores', '100', 'Centro', 'Curitiba', 'PR', '80010-000'),
(2, 2, 'Av. Paraná', '250', 'Batel', 'Curitiba', 'PR', '80420-100'),
(3, 3, 'Rua das Palmeiras', '33', 'Água Verde', 'Curitiba', 'PR', '80620-050'),
(4, 4, 'Rua São Paulo', '88', 'Portão', 'Curitiba', 'PR', '81070-000'),
(5, 5, 'Alameda das Rosas', '5', 'Bigorrilho', 'Curitiba', 'PR', '80430-200');

-- --------------------------------------------------------

--
-- Table structure for table `noticias`
--

CREATE TABLE `noticias` (
  `id` int NOT NULL,
  `titulo` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `conteudo` text COLLATE utf8mb4_general_ci NOT NULL,
  `autor_id` int NOT NULL,
  `publicado` tinyint(1) DEFAULT '1',
  `criado_em` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atualizado_em` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `noticias`
--

INSERT INTO `noticias` (`id`, `titulo`, `conteudo`, `autor_id`, `publicado`, `criado_em`, `atualizado_em`) VALUES
(1, 'Bônus especial para quem tirou CNH nos últimos 20 dias', 'Motoristas habilitados recentemente ganham 15% de desconto na primeira locação. Não perca essa oportunidade!', 1, 1, '2026-05-01 08:00:00', '2026-05-27 03:03:05'),
(2, 'Nova frota de SUVs chegou', 'Adicionamos 5 novos modelos SUV à nossa frota para o inverno. Mais espaço e conforto para toda a família nas estradas.', 1, 1, '2026-05-10 09:30:00', '2026-05-27 03:03:05'),
(3, 'Promoção de motos para o mês de junho', 'Aluguel de motos com até 20% de desconto durante todo o mês de junho. Aproveite a mobilidade urbana com economia.', 1, 1, '2026-05-18 11:00:00', '2026-05-27 03:03:05'),
(4, 'Cuidados essenciais ao alugar um veículo', 'Confira nossas dicas para garantir uma locação segura: verifique os documentos, inspecione o veículo e conheça as coberturas do seguro.', 1, 1, '2026-05-20 14:00:00', '2026-05-27 03:03:05'),
(5, 'Expansão: novos pontos de retirada em Curitiba', 'A partir de junho, você poderá retirar e devolver veículos em mais 3 pontos na cidade. Mais praticidade para você.', 1, 1, '2026-05-22 16:00:00', '2026-05-27 03:03:05');

-- --------------------------------------------------------

--
-- Table structure for table `pagamentos`
--

CREATE TABLE `pagamentos` (
  `id` int NOT NULL,
  `aluguel_id` int NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `metodo` enum('cartao','pix','boleto') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` enum('pendente','aprovado','recusado') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'pendente',
  `pago_em` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pagamentos`
--

INSERT INTO `pagamentos` (`id`, `aluguel_id`, `valor`, `metodo`, `status`, `pago_em`) VALUES
(1, 1, 600.00, 'pix', 'aprovado', '2026-04-30 10:05:00'),
(2, 2, 220.00, 'cartao', 'aprovado', '2026-05-09 09:10:00'),
(3, 3, 180.00, 'boleto', 'aprovado', '2026-05-19 14:15:00'),
(4, 4, 1000.00, 'cartao', 'aprovado', '2026-05-24 11:20:00'),
(5, 5, 280.00, 'pix', 'pendente', '2026-05-25 08:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `nome` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `senha` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `telefone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cpf` varchar(14) COLLATE utf8mb4_general_ci NOT NULL,
  `cnh` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `data_nascimento` date DEFAULT NULL,
  `perfil` enum('admin','cliente') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'cliente',
  `criado_em` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `telefone`, `cpf`, `cnh`, `data_nascimento`, `perfil`, `criado_em`) VALUES
(1, 'Admin Sistema', 'admin@aluguel.com', '$2y$10$mNf/YYYfjDKKWmXbxS6KeuKdJRS7QGZ3XXd8Nnoxik1RUiM1Ltj8C', '41999990001', '00000000001', '0000001', '1990-01-01', 'admin', '2026-01-01 00:00:00'),
(2, 'Cauê Silva', 'caue@gmail.com', '$2y$10$mNf/YYYfjDKKWmXbxS6KeuKdJRS7QGZ3XXd8Nnoxik1RUiM1Ltj8C', '41996813503', '09842017468', '2718901', '2006-07-27', 'cliente', '2026-05-21 04:02:45'),
(3, 'Ana Souza', 'ana@gmail.com', '$2y$10$mNf/YYYfjDKKWmXbxS6KeuKdJRS7QGZ3XXd8Nnoxik1RUiM1Ltj8C', '41988880002', '11122233344', '1234502', '1995-03-15', 'cliente', '2026-02-10 10:00:00'),
(4, 'Carlos Lima', 'carlos@gmail.com', '$2y$10$mNf/YYYfjDKKWmXbxS6KeuKdJRS7QGZ3XXd8Nnoxik1RUiM1Ltj8C', '41977770003', '22233344455', '2345603', '1988-07-22', 'cliente', '2026-03-05 14:30:00'),
(5, 'Mariana Costa', 'mariana@gmail.com', '$2y$10$mNf/YYYfjDKKWmXbxS6KeuKdJRS7QGZ3XXd8Nnoxik1RUiM1Ltj8C', '41966660004', '33344455566', '3456704', '2000-11-30', 'cliente', '2026-04-18 09:15:00');

-- --------------------------------------------------------

--
-- Table structure for table `veiculos`
--

CREATE TABLE `veiculos` (
  `id` int NOT NULL,
  `tipo` enum('carro','moto') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'carro',
  `marca` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `modelo` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `ano` int NOT NULL,
  `cor` varchar(30) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `placa` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `categoria` enum('economico','intermediario','suv','luxo','esportiva','utilitaria') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `preco_diaria` decimal(10,2) NOT NULL,
  `disponivel` tinyint(1) DEFAULT '1',
  `quilometragem` int DEFAULT '0',
  `imagem` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `veiculos`
--

INSERT INTO `veiculos` (`id`, `tipo`, `marca`, `modelo`, `ano`, `cor`, `placa`, `categoria`, `preco_diaria`, `disponivel`, `quilometragem`, `imagem`) VALUES
(1, 'carro', 'Toyota', 'Corolla', 2022, 'Prata', 'BRA2E23', 'intermediario', 150.00, 1, 15000, 'corolla.jpg'),
(2, 'carro', 'Honda', 'Civic', 2023, 'Preto', 'GHT3F45', 'intermediario', 170.00, 1, 8000, 'civic.jpg'),
(3, 'carro', 'Volkswagen', 'T-Cross', 2022, 'Branco', 'MNO4G67', 'suv', 200.00, 1, 22000, 'tcross.jpg'),
(4, 'carro', 'Chevrolet', 'Onix', 2023, 'Vermelho', 'PQR5H89', 'economico', 110.00, 1, 5000, 'onix.jpg'),
(5, 'carro', 'Jeep', 'Compass', 2021, 'Cinza', 'STU6I01', 'suv', 250.00, 1, 35000, 'compass.jpg'),
(6, 'moto', 'Honda', 'CB 500', 2022, 'Azul', 'VWX7J23', 'esportiva', 90.00, 1, 12000, 'cb500.jpg'),
(7, 'moto', 'Yamaha', 'MT-07', 2023, 'Preto', 'YZA8K45', 'esportiva', 120.00, 1, 3000, 'mt07.jpg'),
(8, 'moto', 'Honda', 'CG 160', 2021, 'Vermelho', 'BCD9L67', 'utilitaria', 60.00, 1, 28000, 'cg160.jpg'),
(9, 'moto', 'Yamaha', 'Fazer 250', 2022, 'Prata', 'EFG0M89', 'utilitaria', 75.00, 1, 18000, 'fazer250.jpg'),
(10, 'moto', 'Kawasaki', 'Ninja 400', 2023, 'Verde', 'HIJ1N01', 'esportiva', 140.00, 1, 1500, 'ninja400.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alugueis`
--
ALTER TABLE `alugueis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `veiculo_id` (`veiculo_id`);

--
-- Indexes for table `enderecos`
--
ALTER TABLE `enderecos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indexes for table `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autor_id` (`autor_id`);

--
-- Indexes for table `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `aluguel_id` (`aluguel_id`);

--
-- Indexes for table `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cpf` (`cpf`),
  ADD UNIQUE KEY `cnh` (`cnh`);

--
-- Indexes for table `veiculos`
--
ALTER TABLE `veiculos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `placa` (`placa`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alugueis`
--
ALTER TABLE `alugueis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `enderecos`
--
ALTER TABLE `enderecos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pagamentos`
--
ALTER TABLE `pagamentos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `veiculos`
--
ALTER TABLE `veiculos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alugueis`
--
ALTER TABLE `alugueis`
  ADD CONSTRAINT `alugueis_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `alugueis_ibfk_2` FOREIGN KEY (`veiculo_id`) REFERENCES `veiculos` (`id`);

--
-- Constraints for table `enderecos`
--
ALTER TABLE `enderecos`
  ADD CONSTRAINT `enderecos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `noticias`
--
ALTER TABLE `noticias`
  ADD CONSTRAINT `noticias_ibfk_1` FOREIGN KEY (`autor_id`) REFERENCES `usuarios` (`id`);

--
-- Constraints for table `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD CONSTRAINT `pagamentos_ibfk_1` FOREIGN KEY (`aluguel_id`) REFERENCES `alugueis` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
