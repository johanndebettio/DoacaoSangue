-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29/04/2025 às 08:59
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
(4, 'AB+', '(42) 94384-9023', 'Hemepar', '', 'receber', '2025-04-29 02:04:48', 'joao@gmail.com'),
(5, 'A+', '(42) 94389-0423', 'Hemepar', '', 'doar', '2025-04-29 02:06:09', 'maria@gmail.com');

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
('joao@gmail.com', 'João', '$2y$10$D4T1.oNZDWJigk.mx5tupeVpwLiwz9ReItiqs2lO5Rhr8oUwuuYpy', '(42) 93409-2309', 'Rua: Casas do Cisnes, Número: 233, Bairro: Jardim Carvalho, Cidade: Ponta Grossa, Estado: Paraná, País: Brasil, Complemento: Fundos', 'AB+', 'Nenhuma', 0, '2025-04-29 04:00:20'),
('johan@gmail.com', 'johan', '$2y$10$ptwhoCIFh/JMy0yh.cu/QOadrl7Z1HTNXct60H4OghgfNaPCVqase', '(42) 94832-9048', 'Rua: Ernani Batista Rosas, Número: 2121, Bairro: Jardim Carvalho, Cidade: Ponta Grossa, Estado: Paraná, País: Brasil, Complemento: Fundos', 'O+', 'Camarão', 1, '2025-04-29 06:53:19'),
('maria@gmail.com', 'Maria', '$2y$10$kSLy1BFbUUFpMiJoRSCnVOzViipQzuEvYT90qcORkKP/jhSZhSqra', '(42) 94389-0483', 'Rua: Augusto Celso, Número: 3112, Bairro: Uvaranas, Cidade: Ponta Grossa, Estado: Paraná, País: Brasil, Complemento: Frente', 'A+', '', 0, '2025-04-29 05:05:49');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
