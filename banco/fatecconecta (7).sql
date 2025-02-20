-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19/02/2025 às 17:27
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
-- Banco de dados: `fatecconecta`
--
CREATE DATABASE IF NOT EXISTS `fatecconecta` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `fatecconecta`;

-- --------------------------------------------------------

--
-- Estrutura para tabela `administradores`
--

CREATE TABLE `administradores` (
  `id_adm` int(11) NOT NULL,
  `nome_adm` varchar(100) NOT NULL,
  `email_adm` varchar(50) NOT NULL,
  `fone_adm` varchar(14) NOT NULL,
  `senha_adm` text NOT NULL,
  `senhaconf_adm` varchar(30) NOT NULL,
  `tipo_admin` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `administradores`
--

INSERT INTO `administradores` (`id_adm`, `nome_adm`, `email_adm`, `fone_adm`, `senha_adm`, `senhaconf_adm`, `tipo_admin`) VALUES
(23, 'Maria', 'maria@admin', '18 996910303', '$2y$10$zW77nL7OuCHpPEurrn4IzuWcTP5bEsQ8SrmRNNzavGS3m01M4GZpq', '', 'admin'),
(24, 'Maria', 'maria@admin', '18 996910303', '$2y$10$Uv4ubA9aVHYNBaqelh056.hmlqVJT6/NTRJo3T1QOXFVwZ2spcpci', '', 'admin'),
(25, 'Beatriz', 'beatriz@beatriz', '18 996910303', '$2y$10$EL0T0t7mK6j05Rq7R.Dy5O3D5ET9SXYQvMHmYegE4B1Nb2xdYfKqK', '', 'admin'),
(26, 'Maria', 'maria@maria', '18 996910303', '$2y$10$fmKXfaF3q7QTk13.dDTgneE.4c1txL.9g3HkPutOTNMmPJUqFHuU.', '', 'admin');

-- --------------------------------------------------------

--
-- Estrutura para tabela `alunos`
--

CREATE TABLE `alunos` (
  `id_alu` int(11) NOT NULL,
  `nome_alu` varchar(100) NOT NULL,
  `cpf_alu` varchar(14) NOT NULL,
  `id_cid` int(11) NOT NULL,
  `email_alu` varchar(50) NOT NULL,
  `fone_alu` varchar(15) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `id_inst` int(11) NOT NULL,
  `senha_alu` text NOT NULL,
  `senhaconf_alu` varchar(30) NOT NULL,
  `data` date NOT NULL DEFAULT current_timestamp(),
  `tipo_alu` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `alunos`
--

INSERT INTO `alunos` (`id_alu`, `nome_alu`, `cpf_alu`, `id_cid`, `email_alu`, `fone_alu`, `id_curso`, `id_inst`, `senha_alu`, `senhaconf_alu`, `data`, `tipo_alu`) VALUES
(5, 'Simone', '1111', 1, 'silva@silva', '996910303', 1, 1, '1232', '123', '2024-10-24', 'aluno'),
(7, 'Marjory', '1111', 1, 'marjory@marjory', '99944548', 1, 1, '$2y$10$1UifeHougWpUAfgbq8/UlOE', '$2y$10$CDku4EB1Ae9eqScvhYVG5es', '2024-10-24', ''),
(8, 'Aninha', '1111', 1, 'aninnha@aninha', '998745858', 1, 1, '$2y$10$OZemwRec6qbr7LWyRM2aK.8', '$2y$10$OqttsGnUeTgeduJs0ZuP2uh', '2024-10-24', ''),
(32, 'Simone', '123.456.785-66', 2, 'silva@silva', '18 99691 0303', 1, 1, '$2y$10$QMsTcP/g3gbWg8IsQ.b.Sel', '', '2024-11-07', ''),
(35, 'ana', '123.456.785-66', 1, 'silva@silva', '18 99691 0303', 1, 1, '$2y$10$Z3GIOngEEkak9ze39QU.sOb', '', '2024-11-10', ''),
(39, 'Simone', '123.456.785-66', 1, 'silva@silva', '18 99691 0303', 1, 1, '$2y$10$89QSg3ZVQOpkgij1dyw5tek', '', '2025-01-06', ''),
(40, 'Simone', '123.456.785-66', 1, 'ggg', '444', 1, 1, '$2y$10$X4NMDmLyGEL1bbRjL13CR.8', '', '2025-01-10', ''),
(48, 'Gabriel', '123.456.785-66', 1, 'gabriel@gmail.com', '18 99691 0303', 1, 1, '$2y$10$dJWz5X1VTZGWhDwjB/uof.hHNDCwYzbAZfZ/axrSZ7qZZNqvdsTzm', '', '2025-01-10', 'aluno'),
(50, 'ana', '123.456.785-66', 1, 'ana@aninha', '18 99691 0303', 1, 1, '$2y$10$z1RtEPMaXl3JEenaNXMaueEWSe6nWOUFqxmAmGLECegZBT93pLoO2', '', '2025-01-17', 'aluno'),
(51, 'Renan Ramalho', '222.444.555-25', 1, 'renan@renan', '1899774547', 1, 1, '$2y$10$PN0kpOXYMwKYHPMmkKCQseaEFsjomajOx1yhd.FBGUjSFypaqgGG.', '', '2025-01-28', 'aluno'),
(52, 'Tau&atilde;', '144.233.544-55', 1, 'taua@taua', '17988554477', 1, 1, '$2y$10$L6yzgffmDdmJcqyT0b0S.uHH33B5nkvMCOd0P0nh/iEUW/K09AEA.', '', '2025-01-28', 'aluno'),
(55, 'Kauê Xavier', '123.456.785-66', 1, 'kaue@gmail.com', '18 3603 1218', 1, 6, '$2y$10$2RvXS3ksiFmK6WlJ0KHClOKInaNbJTh.7rofBKGc9qv9kO9iqAfOS', '', '2025-01-28', 'aluno'),
(56, 'julia', '123.456.785-66', 6, 'julia@julia', '18997825262', 4, 2, '$2y$10$9nlBPTVHbNYN2iJjHU9Z9OIIg3yr65iwChU996UrC1XzgHFoBdUwm', '', '2025-02-12', 'aluno');

-- --------------------------------------------------------

--
-- Estrutura para tabela `apresentacao`
--

CREATE TABLE `apresentacao` (
  `id_aprentacao` int(11) NOT NULL,
  `resposta_apresentacao` varchar(10) NOT NULL,
  `id_pro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `area`
--

CREATE TABLE `area` (
  `id_area` int(11) NOT NULL,
  `nome_area` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `area`
--

INSERT INTO `area` (`id_area`, `nome_area`) VALUES
(1, 'Tecnologia1'),
(2, 'Engenharia'),
(3, 'Gestão Empresarialll'),
(8, 'Nutrição'),
(9, 'Engenharia de Produção');

-- --------------------------------------------------------

--
-- Estrutura para tabela `avaliadores`
--

CREATE TABLE `avaliadores` (
  `id_ava` int(11) NOT NULL,
  `nome_ava` varchar(100) NOT NULL,
  `cpf_ava` varchar(14) NOT NULL,
  `email_ava` varchar(50) NOT NULL,
  `fone_ava` varchar(15) NOT NULL,
  `senha_ava` text NOT NULL,
  `senhaconf_ava` varchar(30) NOT NULL,
  `tipo_ava` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `avaliadores`
--

INSERT INTO `avaliadores` (`id_ava`, `nome_ava`, `cpf_ava`, `email_ava`, `fone_ava`, `senha_ava`, `senhaconf_ava`, `tipo_ava`) VALUES
(1, 'Renata', '09739529623', 'avaliador@renata', '996910303', '$2y$10$qm9kjAYtNlztAWtn9HwcF.m', '$2y$10$qm9kjAYtNlztAWtn9HwcF.m', '0'),
(2, 'Renata', '09739529623', 'avaliador@renata', '996910303', '$2y$10$lWGkXrTe4owiuJcB4XZ0zeq', '$2y$10$lWGkXrTe4owiuJcB4XZ0zeq', '0'),
(3, 'Renata', '09739529623', 'avaliador@renata', '996910303', '$2y$10$xw5uQOw0tbodsZ9e06oJFOO', '$2y$10$xw5uQOw0tbodsZ9e06oJFOO', '0'),
(5, 'aaaat', '09739529623', 'avaliador@lu', '(99) 6910303', '$2y$10$1tffSebjyhvpW.fW9Ock9OK', '$2y$10$1tffSebjyhvpW.fW9Ock9OK', '0'),
(6, 'Ronni', '09739529623', 'ronni@ronni', '(99) 6910303', '$2y$10$I0gcxVtPMkeapwz.CrtpD.y', '$2y$10$I0gcxVtPMkeapwz.CrtpD.y', '0'),
(7, 'Luciana', '09739529623', 'lu@lu', '(99) 6910303', '$2y$10$UaJ.jRmgbd6exw1jG3l2reiPlVZDrIz98rzlvbNj3XXlLyygVQP3e', '$2y$10$UaJ.jRmgbd6exw1jG3l2rei', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cidades`
--

CREATE TABLE `cidades` (
  `id_cid` int(11) NOT NULL,
  `nome_cidade` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cidades`
--

INSERT INTO `cidades` (`id_cid`, `nome_cidade`) VALUES
(1, 'Araçatuba'),
(2, 'Birigui'),
(3, 'Penápolis'),
(4, 'Santópolis'),
(5, 'Lins'),
(6, 'Guararapes'),
(7, 'Adamantina'),
(8, 'Coroados'),
(9, 'Alto Alegre'),
(11, 'Lins1');

-- --------------------------------------------------------

--
-- Estrutura para tabela `cursos`
--

CREATE TABLE `cursos` (
  `id_curso` int(11) NOT NULL,
  `nome_curso` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `cursos`
--

INSERT INTO `cursos` (`id_curso`, `nome_curso`) VALUES
(1, 'Análise e Desenvolvimento de Sistemas'),
(2, 'Biocombustíveis'),
(3, 'Administração'),
(4, 'Engenharia'),
(7, 'Medicina'),
(8, 'Biomedicina1');

-- --------------------------------------------------------

--
-- Estrutura para tabela `eventoativado`
--

CREATE TABLE `eventoativado` (
  `id_ati` int(11) NOT NULL,
  `ati_descricao` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `eventos`
--

CREATE TABLE `eventos` (
  `id_evento` int(11) NOT NULL,
  `nome_evento` varchar(100) NOT NULL,
  `evento_datainicio` date NOT NULL,
  `evento_datafim` date NOT NULL,
  `horario_evento` varchar(10) NOT NULL,
  `local_evento` varchar(50) NOT NULL,
  `status` enum('ativo','inativo') DEFAULT 'inativo',
  `descricao` text DEFAULT NULL,
  `imagem` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `eventos`
--

INSERT INTO `eventos` (`id_evento`, `nome_evento`, `evento_datainicio`, `evento_datafim`, `horario_evento`, `local_evento`, `status`, `descricao`, `imagem`) VALUES
(2, 'Fatec Aberta', '2025-01-07', '2025-01-14', '17:56', 'Araçatuba', 'inativo', NULL, 'uploads/imagem.jpg'),
(3, 'Fatec Aberta', '2025-01-14', '2025-01-21', '20:00', 'Araçatuba', 'inativo', NULL, 'uploads/imagem.jpg'),
(4, 'Hackathon', '2025-05-22', '2025-05-24', '15:00', 'Araçatuba', 'ativo', 'dddd', 'menu_alunos/uploads/1739557467_img-fatec.png'),
(5, 'Hackathon4', '2025-03-14', '2025-03-16', '14:00', 'Araçatuba', 'inativo', 'dddddd', 'menu_alunos/uploads/1739557836_img-fatec.png'),
(6, 'teste', '2025-04-14', '2025-06-14', '14:00', 'Araçatuba', 'ativo', NULL, 'uploads/img-fatec.png'),
(7, 'kkk', '2025-05-02', '2025-05-03', '14:00', 'Araçatuba', 'inativo', 'jjjjj', 'uploads/1739391730_img-fatec.png');

-- --------------------------------------------------------

--
-- Estrutura para tabela `instituicao`
--

CREATE TABLE `instituicao` (
  `id_inst` int(11) NOT NULL,
  `nome_inst` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `instituicao`
--

INSERT INTO `instituicao` (`id_inst`, `nome_inst`) VALUES
(1, 'Fatec'),
(2, 'Unisalesiano'),
(5, 'UniToledo'),
(6, 'USP');

-- --------------------------------------------------------

--
-- Estrutura para tabela `livro`
--

CREATE TABLE `livro` (
  `id_livro` int(11) NOT NULL,
  `titulo_livro` varchar(100) NOT NULL,
  `autor_livro` varchar(100) NOT NULL,
  `editora_livro` varchar(100) NOT NULL,
  `genero_livro` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Despejando dados para a tabela `livro`
--

INSERT INTO `livro` (`id_livro`, `titulo_livro`, `autor_livro`, `editora_livro`, `genero_livro`) VALUES
(1, 'Crianças da Guerra', 'Viola Ardone', 'Faro Editorial', 'Ficção');

-- --------------------------------------------------------

--
-- Estrutura para tabela `orientadores`
--

CREATE TABLE `orientadores` (
  `id_ori` int(11) NOT NULL,
  `nome_ori` varchar(100) NOT NULL,
  `cpf_ori` varchar(14) NOT NULL,
  `email_ori` varchar(50) NOT NULL,
  `fone_ori` varchar(15) NOT NULL,
  `senha_ori` text NOT NULL,
  `senhaconf_ori` varchar(30) NOT NULL,
  `tipo_ori` varchar(50) NOT NULL DEFAULT 'Orientador',
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `orientadores`
--

INSERT INTO `orientadores` (`id_ori`, `nome_ori`, `cpf_ori`, `email_ori`, `fone_ori`, `senha_ori`, `senhaconf_ori`, `tipo_ori`, `data_cadastro`) VALUES
(1, 'Saulo Zambotti', '', '', '', '', '', 'Orien', '2025-01-28 19:31:43'),
(2, 'Renata Goes', '', '', '', '', '', 'Orien', '2025-01-28 20:11:30'),
(3, 'Ronnie Marcos Rillo', '14254545544', 'ronnie@ronnie', '', '$2y$10$FPoxYqdoDPyfEUSkgIj6oe/5DOs3R8aVJzEvqI5depjWHQEIEwciu', '$2y$10$FPoxYqdoDPyfEUSkgIj6oe/', 'Orien', '2025-02-17 18:35:22'),
(6, 'silva leite', '09739529323', 'silva@leite', '(18) 99544-8545', '$2y$10$SnzVuZLAlijXGMoIaE76VeoxxuvFZArSJ2P582K6HeFuWUbc8gGry', '$2y$10$SnzVuZLAlijXGMoIaE76Veo', 'Orientador', '2025-02-17 20:18:06');

-- --------------------------------------------------------

--
-- Estrutura para tabela `projeto`
--

CREATE TABLE `projeto` (
  `id_pro` int(11) NOT NULL,
  `id_area` int(11) NOT NULL,
  `tema` varchar(100) NOT NULL,
  `id_alu` int(11) NOT NULL,
  `aluno2` varchar(50) NOT NULL,
  `aluno3` varchar(50) NOT NULL,
  `aluno4` varchar(50) NOT NULL,
  `aluno5` varchar(50) NOT NULL,
  `orientador` varchar(100) NOT NULL,
  `inseriranexo` varchar(500) NOT NULL,
  `id_evento` int(11) NOT NULL,
  `status` enum('Pendente','Aprovado','Reprovado') DEFAULT 'Pendente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `projeto`
--

INSERT INTO `projeto` (`id_pro`, `id_area`, `tema`, `id_alu`, `aluno2`, `aluno3`, `aluno4`, `aluno5`, `orientador`, `inseriranexo`, `id_evento`, `status`) VALUES
(4, 1, 'Tecnologia', 50, '0', 'Ana', 'Marjory', 'Diogo', 'Renata', 'uploads/ELISANGELA-REVISADO.docx', 2, 'Reprovado'),
(5, 2, 'Natureza', 40, '0', 'Ana', 'Marjory', 'Diogo', 'Renata', 'menu_alunos/uploads/Documento sem título.docx', 2, 'Pendente'),
(6, 3, 'Enfermagem', 8, '0', 'Ana', 'Marjory', 'Diogo', 'Renata', 'menu_alunos/uploads/Documento sem título.docx', 2, 'Pendente'),
(7, 1, 'Inteligência Artificial', 39, '0', 'Ana', 'Marjory', 'Diogo', 'Renata', 'menu_alunos/uploads/SimoneSeminario.docx', 2, 'Pendente'),
(8, 1, 'Nasa', 35, '0', 'Ana', 'Marjory', 'Diogo', 'Luciana', 'menu_alunos/uploads/SimoneSeminario (2).docx', 2, 'Aprovado'),
(9, 1, 'Selva', 51, '52', '49', '55', '7', 'Renata', 'menu_alunos/uploads/Documento sem título (2).docx', 2, 'Pendente'),
(10, 8, 'teste', 52, '49', '51', '48', '7', 'Luciana', 'menu_alunos/uploads/Documento sem título (2).docx', 2, 'Pendente');

-- --------------------------------------------------------

--
-- Estrutura para tabela `resultado`
--

CREATE TABLE `resultado` (
  `id_resultado` int(11) NOT NULL,
  `resposta` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `tipo` enum('admin','aluno') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id_adm`);

--
-- Índices de tabela `alunos`
--
ALTER TABLE `alunos`
  ADD PRIMARY KEY (`id_alu`),
  ADD KEY `fk_id_cid` (`id_cid`),
  ADD KEY `fk_id_inst` (`id_inst`),
  ADD KEY `fk_cursos` (`id_curso`);

--
-- Índices de tabela `apresentacao`
--
ALTER TABLE `apresentacao`
  ADD PRIMARY KEY (`id_aprentacao`),
  ADD KEY `fk_apresentacao` (`id_pro`);

--
-- Índices de tabela `area`
--
ALTER TABLE `area`
  ADD PRIMARY KEY (`id_area`);

--
-- Índices de tabela `avaliadores`
--
ALTER TABLE `avaliadores`
  ADD PRIMARY KEY (`id_ava`);

--
-- Índices de tabela `cidades`
--
ALTER TABLE `cidades`
  ADD PRIMARY KEY (`id_cid`);

--
-- Índices de tabela `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id_curso`);

--
-- Índices de tabela `eventoativado`
--
ALTER TABLE `eventoativado`
  ADD PRIMARY KEY (`id_ati`);

--
-- Índices de tabela `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`id_evento`);

--
-- Índices de tabela `instituicao`
--
ALTER TABLE `instituicao`
  ADD PRIMARY KEY (`id_inst`);

--
-- Índices de tabela `livro`
--
ALTER TABLE `livro`
  ADD PRIMARY KEY (`id_livro`);

--
-- Índices de tabela `orientadores`
--
ALTER TABLE `orientadores`
  ADD PRIMARY KEY (`id_ori`);

--
-- Índices de tabela `projeto`
--
ALTER TABLE `projeto`
  ADD PRIMARY KEY (`id_pro`),
  ADD KEY `fk_alunos` (`id_alu`),
  ADD KEY `fk_area` (`id_area`),
  ADD KEY `fk_projeto` (`id_evento`);

--
-- Índices de tabela `resultado`
--
ALTER TABLE `resultado`
  ADD PRIMARY KEY (`id_resultado`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id_adm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de tabela `alunos`
--
ALTER TABLE `alunos`
  MODIFY `id_alu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT de tabela `apresentacao`
--
ALTER TABLE `apresentacao`
  MODIFY `id_aprentacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `area`
--
ALTER TABLE `area`
  MODIFY `id_area` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `avaliadores`
--
ALTER TABLE `avaliadores`
  MODIFY `id_ava` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `cidades`
--
ALTER TABLE `cidades`
  MODIFY `id_cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id_curso` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `eventoativado`
--
ALTER TABLE `eventoativado`
  MODIFY `id_ati` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `eventos`
--
ALTER TABLE `eventos`
  MODIFY `id_evento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `instituicao`
--
ALTER TABLE `instituicao`
  MODIFY `id_inst` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `livro`
--
ALTER TABLE `livro`
  MODIFY `id_livro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `orientadores`
--
ALTER TABLE `orientadores`
  MODIFY `id_ori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `projeto`
--
ALTER TABLE `projeto`
  MODIFY `id_pro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `resultado`
--
ALTER TABLE `resultado`
  MODIFY `id_resultado` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `alunos`
--
ALTER TABLE `alunos`
  ADD CONSTRAINT `fk_cursos` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id_curso`),
  ADD CONSTRAINT `fk_id_cid` FOREIGN KEY (`id_cid`) REFERENCES `cidades` (`id_cid`),
  ADD CONSTRAINT `fk_id_inst` FOREIGN KEY (`id_inst`) REFERENCES `instituicao` (`id_inst`);

--
-- Restrições para tabelas `apresentacao`
--
ALTER TABLE `apresentacao`
  ADD CONSTRAINT `fk_apresentacao` FOREIGN KEY (`id_pro`) REFERENCES `projeto` (`id_pro`);

--
-- Restrições para tabelas `projeto`
--
ALTER TABLE `projeto`
  ADD CONSTRAINT `fk_alunos` FOREIGN KEY (`id_alu`) REFERENCES `alunos` (`id_alu`),
  ADD CONSTRAINT `fk_area` FOREIGN KEY (`id_area`) REFERENCES `area` (`id_area`),
  ADD CONSTRAINT `fk_projeto` FOREIGN KEY (`id_evento`) REFERENCES `eventos` (`id_evento`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
