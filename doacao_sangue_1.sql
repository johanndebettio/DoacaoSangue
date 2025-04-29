-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29/04/2025 às 16:05
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `doacao_sangue`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `doacao`
--

CREATE TABLE `doacao` (
  `id` int(11) NOT NULL,
  `tipo_sanguineo` varchar(10) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `local` varchar(255) DEFAULT NULL,
  `comentarios` text DEFAULT NULL,
  `acao` enum('doar','receber') NOT NULL,
  `data_criacao` datetime DEFAULT current_timestamp(),
  `usuario_email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `doacao`
--

INSERT INTO `doacao` (`id`, `tipo_sanguineo`, `telefone`, `local`, `comentarios`, `acao`, `data_criacao`, `usuario_email`) VALUES
(5, 'A+', '(42) 94389-0423', 'Hemepar', '', 'doar', '2025-04-29 02:06:09', 'maria@gmail.com'),
(6, 'AB+', '(42) 99438-9849', 'Hemepar', 'Urgente', 'receber', '2025-04-29 10:31:58', 'joao@gmail.com'),
(7, 'O+', '(42) 94389-4833', 'HU', 'Imediato', 'receber', '2025-04-29 10:41:31', 'felipe@gmail.com'),
(8, 'O-', '(42) 94394-8394', 'HU', '', 'doar', '2025-04-29 10:42:03', 'ana@gmail.com');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `email` varchar(100) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `endereco` text NOT NULL,
  `tipo_sanguineo` varchar(5) NOT NULL,
  `alergias` varchar(255) DEFAULT NULL,
  `tipo_usuario` tinyint(4) DEFAULT 0,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`email`, `nome`, `senha`, `telefone`, `endereco`, `tipo_sanguineo`, `alergias`, `tipo_usuario`, `criado_em`) VALUES
('ana@gmail.com', 'Ana', '$2y$10$C7pQrsMHO/gtmik6VHQDOujS/mmUqpUUQ3sJHAUGk5Rx/JXx5QB4i', '(42) 99948-3984', 'Rua: Rua dos Cachorros Brilhantes, Número: 2122, Bairro: Nova Rússia, Cidade: Ponta Grossa, Estado: Paraná, País: Brasil, Complemento: Casa da Frente', 'O-', 'Frutos do mar', 0, '2025-04-29 13:37:51'),
('felipe@gmail.com', 'Felipe', '$2y$10$bWnR8Z90bEPZN/pC7liJfuqrKPCi/Gi0iHQ4VUw6Lzm5BjGnndBXu', '(42) 94839-4389', 'Rua: Rua dos Bois, Número: 237, Bairro: Santa Paula, Cidade: Ponta Grossa, Estado: Paraná, País: Brasil, Complemento: Perto da padaria', 'O+', 'Leite', 0, '2025-04-29 13:40:00'),
('joao@gmail.com', 'João', '$2y$10$D4T1.oNZDWJigk.mx5tupeVpwLiwz9ReItiqs2lO5Rhr8oUwuuYpy', '(42) 93409-2309', 'Rua: Casas do Cisnes, Número: 233, Bairro: Jardim Carvalho, Cidade: Ponta Grossa, Estado: Paraná, País: Brasil, Complemento: Fundos', 'AB+', 'Nenhuma', 0, '2025-04-29 04:00:20'),
('johan@gmail.com', 'Johan', '$2y$10$ptwhoCIFh/JMy0yh.cu/QOadrl7Z1HTNXct60H4OghgfNaPCVqase', '(42) 94832-9048', 'Rua: Ernani Batista Rosas, Número: 2121, Bairro: Jardim Carvalho, Cidade: Ponta Grossa, Estado: Paraná, País: Brasil, Complemento: Fundos', 'O+', 'Camarão', 1, '2025-04-29 06:53:19'),
('maria@gmail.com', 'Maria', '$2y$10$kSLy1BFbUUFpMiJoRSCnVOzViipQzuEvYT90qcORkKP/jhSZhSqra', '(42) 94389-0483', 'Rua: Augusto Celso, Número: 3112, Bairro: Uvaranas, Cidade: Ponta Grossa, Estado: Paraná, País: Brasil, Complemento: Frente', 'A+', 'Anestésicos', 0, '2025-04-29 05:05:49');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `doacao`
--
ALTER TABLE `doacao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_email` (`usuario_email`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `doacao`
--
ALTER TABLE `doacao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `doacao`
--
ALTER TABLE `doacao`
  ADD CONSTRAINT `doacao_ibfk_1` FOREIGN KEY (`usuario_email`) REFERENCES `usuario` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
