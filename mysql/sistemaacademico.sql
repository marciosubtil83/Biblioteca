-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 29/05/2021 às 05:04
-- Versão do servidor: 10.4.19-MariaDB
-- Versão do PHP: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `sistemaacademico`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `aluno`
--

CREATE TABLE `aluno` (
  `id` int(8) UNSIGNED NOT NULL,
  `nome` varchar(50) NOT NULL,
  `login` varchar(20) NOT NULL,
  `senha` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `aluno`
--

INSERT INTO `aluno` (`id`, `nome`, `login`, `senha`) VALUES
(1, 'Henrique Luis de Abreu', 'henrique', '1234'),
(2, 'João Pedro Hoinacki Sucla', 'joao', '1234'),
(3, 'Marcio Alexsander Subtil', 'marcio', '1234'),
(4, 'Mayck de Oliveira Guimarães', 'mayck', '1234');

-- --------------------------------------------------------

--
-- Estrutura para tabela `atividade`
--

CREATE TABLE `atividade` (
  `id` int(6) UNSIGNED NOT NULL,
  `nome` varchar(50) NOT NULL,
  `peso` decimal(4,2) DEFAULT NULL,
  `disciplina` int(4) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `atividade`
--

INSERT INTO `atividade` (`id`, `nome`, `peso`, `disciplina`) VALUES
(1, '1º Trabalho Prático', '0.15', 1),
(2, '2º Trabalho Prático', '0.15', 1),
(3, '1ª Avaliação', '0.25', 1),
(4, '2ª Avaliação', '0.25', 1),
(6, 'Teste2', '0.53', 4),
(23, 'APS 1', '0.10', 7),
(24, 'APS 1', '0.10', 1),
(25, 'APS 1', '0.10', 5),
(26, 'APS 1', '0.10', 3),
(27, 'APS 1', '0.10', 2),
(28, 'APS 2', '0.10', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `disciplina`
--

CREATE TABLE `disciplina` (
  `id` int(4) UNSIGNED NOT NULL,
  `nome` varchar(50) NOT NULL,
  `professor` int(4) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `disciplina`
--

INSERT INTO `disciplina` (`id`, `nome`, `professor`) VALUES
(1, 'Programação Web', 1),
(2, 'Banco de Dados', 2),
(3, 'Ensino Religioso', 3),
(4, 'Introdução ao Java Script', 1),
(5, 'PHP e SQL', 1),
(7, 'Análise e Modelagem de Sistemas', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `matricula`
--

CREATE TABLE `matricula` (
  `aluno` int(8) UNSIGNED NOT NULL,
  `disciplina` int(4) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `matricula`
--

INSERT INTO `matricula` (`aluno`, `disciplina`) VALUES
(1, 1),
(1, 3),
(1, 4),
(1, 7),
(2, 1),
(2, 4),
(2, 7),
(3, 1),
(3, 4),
(3, 7),
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(4, 5),
(4, 7);

-- --------------------------------------------------------

--
-- Estrutura para tabela `nota`
--

CREATE TABLE `nota` (
  `aluno` int(8) UNSIGNED NOT NULL,
  `atividade` int(6) UNSIGNED NOT NULL,
  `valor` decimal(4,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `nota`
--

INSERT INTO `nota` (`aluno`, `atividade`, `valor`) VALUES
(1, 1, '8.80'),
(1, 2, '9.00'),
(1, 3, '6.00'),
(1, 4, '8.80'),
(1, 6, '6.00'),
(1, 23, '7.00'),
(1, 24, '10.00'),
(2, 1, '7.00'),
(2, 2, '9.00'),
(2, 3, '7.90'),
(2, 4, '8.10'),
(2, 6, '7.90'),
(2, 23, '8.00'),
(2, 24, '10.00'),
(3, 1, '8.10'),
(3, 2, '9.00'),
(3, 3, '7.00'),
(3, 4, '8.00'),
(3, 6, '8.10'),
(3, 23, '8.00'),
(3, 24, '10.00'),
(4, 1, '6.00'),
(4, 2, '9.00'),
(4, 3, '8.00'),
(4, 4, '9.00'),
(4, 6, '8.00'),
(4, 23, '8.00'),
(4, 24, '10.00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `professor`
--

CREATE TABLE `professor` (
  `id` int(4) UNSIGNED NOT NULL,
  `nome` varchar(50) NOT NULL,
  `login` varchar(20) NOT NULL,
  `senha` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `professor`
--

INSERT INTO `professor` (`id`, `nome`, `login`, `senha`) VALUES
(1, 'Eunelson José da Silva Junior', 'eunelson', '1234'),
(2, 'Cassiana Fagundes da Silva', 'cassiana', '1234'),
(3, 'Paulo Henrique dos Santos', 'ph', '1234');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `aluno`
--
ALTER TABLE `aluno`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `atividade`
--
ALTER TABLE `atividade`
  ADD PRIMARY KEY (`id`),
  ADD KEY `disciplina` (`disciplina`);

--
-- Índices de tabela `disciplina`
--
ALTER TABLE `disciplina`
  ADD PRIMARY KEY (`id`),
  ADD KEY `professor` (`professor`);

--
-- Índices de tabela `matricula`
--
ALTER TABLE `matricula`
  ADD PRIMARY KEY (`aluno`,`disciplina`),
  ADD KEY `disciplina` (`disciplina`);

--
-- Índices de tabela `nota`
--
ALTER TABLE `nota`
  ADD PRIMARY KEY (`aluno`,`atividade`),
  ADD KEY `atividade` (`atividade`);

--
-- Índices de tabela `professor`
--
ALTER TABLE `professor`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `aluno`
--
ALTER TABLE `aluno`
  MODIFY `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `atividade`
--
ALTER TABLE `atividade`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT de tabela `disciplina`
--
ALTER TABLE `disciplina`
  MODIFY `id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `professor`
--
ALTER TABLE `professor`
  MODIFY `id` int(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `atividade`
--
ALTER TABLE `atividade`
  ADD CONSTRAINT `atividade_ibfk_1` FOREIGN KEY (`disciplina`) REFERENCES `disciplina` (`id`);

--
-- Restrições para tabelas `disciplina`
--
ALTER TABLE `disciplina`
  ADD CONSTRAINT `disciplina_ibfk_1` FOREIGN KEY (`professor`) REFERENCES `professor` (`id`);

--
-- Restrições para tabelas `matricula`
--
ALTER TABLE `matricula`
  ADD CONSTRAINT `matricula_ibfk_1` FOREIGN KEY (`aluno`) REFERENCES `aluno` (`id`),
  ADD CONSTRAINT `matricula_ibfk_2` FOREIGN KEY (`disciplina`) REFERENCES `disciplina` (`id`);

--
-- Restrições para tabelas `nota`
--
ALTER TABLE `nota`
  ADD CONSTRAINT `nota_ibfk_1` FOREIGN KEY (`aluno`) REFERENCES `aluno` (`id`),
  ADD CONSTRAINT `nota_ibfk_2` FOREIGN KEY (`atividade`) REFERENCES `atividade` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
