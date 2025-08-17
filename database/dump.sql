-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 17/08/2025 às 04:27
-- Versão do servidor: 10.4.27-MariaDB
-- Versão do PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `fiap_php_db`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `classes_students_tbl`
--

CREATE TABLE `classes_students_tbl` (
  `id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL COMMENT 'Referência para a turma (classes_tbl)',
  `student_id` int(11) NOT NULL COMMENT 'Referência para o aluno (students_tbl)',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Data e hora da matrícula',
  `deleted_at` datetime DEFAULT NULL COMMENT 'Data de exclusão lógica'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Relaciona alunos às turmas';

--
-- Despejando dados para a tabela `classes_students_tbl`
--

INSERT INTO `classes_students_tbl` (`id`, `class_id`, `student_id`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, '2025-08-16 14:42:01', NULL),
(2, 2, 1, '2025-08-16 14:42:01', NULL),
(3, 3, 1, '2025-08-16 14:42:01', NULL),
(4, 1, 2, '2025-08-16 14:42:01', NULL),
(5, 4, 2, '2025-08-16 14:42:01', NULL),
(6, 5, 2, '2025-08-16 14:42:01', NULL),
(7, 2, 3, '2025-08-16 14:42:01', NULL),
(8, 3, 3, '2025-08-16 14:42:01', NULL),
(9, 6, 3, '2025-08-16 14:42:01', NULL),
(10, 1, 4, '2025-08-16 14:42:01', NULL),
(11, 2, 4, '2025-08-16 14:42:01', NULL),
(12, 7, 4, '2025-08-16 14:42:01', NULL),
(13, 3, 5, '2025-08-16 14:42:01', NULL),
(14, 4, 5, '2025-08-16 14:42:01', NULL),
(15, 8, 5, '2025-08-16 14:42:01', NULL),
(16, 5, 6, '2025-08-16 14:42:01', NULL),
(17, 6, 6, '2025-08-16 14:42:01', NULL),
(18, 1, 6, '2025-08-16 14:42:01', NULL),
(19, 7, 7, '2025-08-16 14:42:01', NULL),
(20, 8, 7, '2025-08-16 14:42:01', NULL),
(21, 2, 7, '2025-08-16 14:42:01', NULL),
(22, 3, 8, '2025-08-16 14:42:01', NULL),
(23, 9, 8, '2025-08-16 14:42:01', NULL),
(24, 4, 8, '2025-08-16 14:42:01', NULL),
(25, 5, 9, '2025-08-16 14:42:01', NULL),
(26, 10, 9, '2025-08-16 14:42:01', NULL),
(27, 6, 9, '2025-08-16 14:42:01', NULL),
(28, 7, 10, '2025-08-16 14:42:01', NULL),
(29, 11, 10, '2025-08-16 14:42:01', NULL),
(30, 8, 10, '2025-08-16 14:42:01', NULL),
(31, 1, 11, '2025-08-16 14:42:01', NULL),
(32, 12, 11, '2025-08-16 14:42:01', NULL),
(33, 2, 11, '2025-08-16 14:42:01', NULL),
(34, 3, 12, '2025-08-16 14:42:01', NULL),
(35, 13, 12, '2025-08-16 14:42:01', NULL),
(36, 4, 12, '2025-08-16 14:42:01', NULL),
(37, 5, 13, '2025-08-16 14:42:01', NULL),
(38, 14, 13, '2025-08-16 14:42:01', NULL),
(39, 6, 13, '2025-08-16 14:42:01', NULL),
(40, 7, 14, '2025-08-16 14:42:01', NULL),
(41, 15, 14, '2025-08-16 14:42:01', NULL),
(42, 8, 14, '2025-08-16 14:42:01', NULL),
(43, 1, 15, '2025-08-16 14:42:01', NULL),
(44, 2, 15, '2025-08-16 14:42:01', NULL),
(45, 9, 15, '2025-08-16 14:42:01', NULL),
(46, 3, 16, '2025-08-16 14:42:01', NULL),
(47, 4, 16, '2025-08-16 14:42:01', NULL),
(48, 10, 16, '2025-08-16 14:42:01', NULL),
(49, 5, 17, '2025-08-16 14:42:01', NULL),
(50, 6, 17, '2025-08-16 14:42:01', NULL),
(51, 11, 17, '2025-08-16 14:42:01', NULL),
(52, 7, 18, '2025-08-16 14:42:01', NULL),
(53, 8, 18, '2025-08-16 14:42:01', NULL),
(54, 12, 18, '2025-08-16 14:42:01', NULL),
(55, 1, 19, '2025-08-16 14:42:01', NULL),
(56, 2, 19, '2025-08-16 14:42:01', NULL),
(57, 13, 19, '2025-08-16 14:42:01', NULL),
(58, 3, 20, '2025-08-16 14:42:01', NULL),
(59, 4, 20, '2025-08-16 14:42:01', NULL),
(60, 14, 20, '2025-08-16 14:42:01', NULL),
(61, 5, 21, '2025-08-16 14:42:01', NULL),
(62, 6, 21, '2025-08-16 14:42:01', NULL),
(63, 15, 21, '2025-08-16 14:42:01', NULL),
(64, 7, 22, '2025-08-16 14:42:01', NULL),
(65, 8, 22, '2025-08-16 14:42:01', NULL),
(66, 1, 22, '2025-08-16 14:42:01', NULL),
(67, 9, 23, '2025-08-16 14:42:01', NULL),
(68, 2, 23, '2025-08-16 14:42:01', NULL),
(69, 3, 23, '2025-08-16 14:42:01', NULL),
(70, 4, 24, '2025-08-16 14:42:01', NULL),
(71, 10, 24, '2025-08-16 14:42:01', NULL),
(72, 5, 24, '2025-08-16 14:42:01', NULL),
(73, 6, 25, '2025-08-16 14:42:01', NULL),
(74, 11, 25, '2025-08-16 14:42:01', NULL),
(75, 7, 25, '2025-08-16 14:42:01', NULL),
(76, 8, 26, '2025-08-16 14:42:01', NULL),
(77, 12, 26, '2025-08-16 14:42:01', NULL),
(78, 1, 26, '2025-08-16 14:42:01', NULL),
(79, 9, 27, '2025-08-16 14:42:01', NULL),
(80, 2, 27, '2025-08-16 14:42:01', NULL),
(81, 3, 27, '2025-08-16 14:42:01', NULL),
(82, 4, 28, '2025-08-16 14:42:01', NULL),
(83, 10, 28, '2025-08-16 14:42:01', NULL),
(84, 5, 28, '2025-08-16 14:42:01', NULL),
(85, 6, 29, '2025-08-16 14:42:01', NULL),
(86, 11, 29, '2025-08-16 14:42:01', NULL),
(87, 7, 29, '2025-08-16 14:42:01', NULL),
(88, 8, 30, '2025-08-16 14:42:01', NULL),
(89, 12, 30, '2025-08-16 14:42:01', NULL),
(90, 1, 30, '2025-08-16 14:42:01', NULL),
(91, 9, 31, '2025-08-16 14:42:01', NULL),
(92, 2, 31, '2025-08-16 14:42:01', NULL),
(93, 3, 31, '2025-08-16 14:42:01', NULL),
(94, 4, 32, '2025-08-16 14:42:01', NULL),
(95, 10, 32, '2025-08-16 14:42:01', NULL),
(96, 5, 32, '2025-08-16 14:42:01', NULL),
(97, 6, 33, '2025-08-16 14:42:01', NULL),
(98, 11, 33, '2025-08-16 14:42:01', NULL),
(99, 7, 33, '2025-08-16 14:42:01', NULL),
(100, 8, 34, '2025-08-16 14:42:01', NULL),
(101, 12, 34, '2025-08-16 14:42:01', NULL),
(102, 1, 34, '2025-08-16 14:42:01', NULL),
(103, 9, 35, '2025-08-16 14:42:01', NULL),
(104, 2, 35, '2025-08-16 14:42:01', NULL),
(105, 3, 35, '2025-08-16 14:42:01', NULL),
(106, 4, 36, '2025-08-16 14:42:01', NULL),
(107, 10, 36, '2025-08-16 14:42:01', NULL),
(108, 5, 36, '2025-08-16 14:42:01', NULL),
(109, 6, 37, '2025-08-16 14:42:01', NULL),
(110, 11, 37, '2025-08-16 14:42:01', NULL),
(111, 7, 37, '2025-08-16 14:42:01', NULL),
(112, 8, 38, '2025-08-16 14:42:01', NULL),
(113, 12, 38, '2025-08-16 14:42:01', NULL),
(114, 1, 38, '2025-08-16 14:42:01', NULL),
(115, 9, 39, '2025-08-16 14:42:01', NULL),
(116, 2, 39, '2025-08-16 14:42:01', NULL),
(117, 3, 39, '2025-08-16 14:42:01', NULL),
(118, 4, 40, '2025-08-16 14:42:01', NULL),
(119, 10, 40, '2025-08-16 14:42:01', NULL),
(120, 5, 40, '2025-08-16 14:42:01', NULL),
(121, 6, 41, '2025-08-16 14:42:01', NULL),
(122, 11, 41, '2025-08-16 14:42:01', NULL),
(123, 7, 41, '2025-08-16 14:42:01', NULL),
(124, 8, 42, '2025-08-16 14:42:01', NULL),
(125, 12, 42, '2025-08-16 14:42:01', NULL),
(126, 1, 42, '2025-08-16 14:42:01', NULL),
(127, 9, 43, '2025-08-16 14:42:01', NULL),
(128, 2, 43, '2025-08-16 14:42:01', NULL),
(129, 3, 43, '2025-08-16 14:42:01', NULL),
(130, 4, 44, '2025-08-16 14:42:01', NULL),
(131, 10, 44, '2025-08-16 14:42:01', NULL),
(132, 5, 44, '2025-08-16 14:42:01', NULL),
(133, 6, 45, '2025-08-16 14:42:01', NULL),
(134, 11, 45, '2025-08-16 14:42:01', NULL),
(135, 7, 45, '2025-08-16 14:42:01', NULL),
(136, 8, 46, '2025-08-16 14:42:01', NULL),
(137, 12, 46, '2025-08-16 14:42:01', NULL),
(138, 1, 46, '2025-08-16 14:42:01', NULL),
(139, 9, 47, '2025-08-16 14:42:01', NULL),
(140, 2, 47, '2025-08-16 14:42:01', NULL),
(141, 3, 47, '2025-08-16 14:42:01', NULL),
(142, 4, 48, '2025-08-16 14:42:01', NULL),
(143, 10, 48, '2025-08-16 14:42:01', NULL),
(144, 5, 48, '2025-08-16 14:42:01', NULL),
(145, 6, 49, '2025-08-16 14:42:01', NULL),
(146, 11, 49, '2025-08-16 14:42:01', NULL),
(147, 7, 49, '2025-08-16 14:42:01', NULL),
(148, 8, 50, '2025-08-16 14:42:01', NULL),
(149, 12, 50, '2025-08-16 14:42:01', NULL),
(150, 1, 50, '2025-08-16 14:42:01', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `classes_tbl`
--

CREATE TABLE `classes_tbl` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `classes_tbl`
--

INSERT INTO `classes_tbl` (`id`, `name`, `description`, `updated_at`, `deleted_at`) VALUES
(1, 'Turma A1', 'Turma inicial de alunos do curso de PHP.', '2025-08-16 14:22:47', NULL),
(2, 'Turma B2', 'Turma intermediária de desenvolvimento web.', '2025-08-16 14:22:47', NULL),
(3, 'Turma C3', 'Turma avançada com foco em Laravel e Vue.js.', '2025-08-16 14:22:47', NULL),
(4, 'Turma D4', 'Turma de práticas de banco de dados e SQL.', '2025-08-16 14:22:47', NULL),
(5, 'Turma E5', 'Turma de estudo de front-end e Bootstrap.', '2025-08-16 14:22:47', NULL),
(6, 'Turma F6', 'Turma de introdução a programação orientada a objetos.', '2025-08-16 14:22:47', NULL),
(7, 'Turma G7', 'Turma de PHP avançado e integração com APIs.', '2025-08-16 14:22:47', NULL),
(8, 'Turma H8', 'Turma de desenvolvimento de sistemas completos.', '2025-08-16 14:22:47', NULL),
(9, 'Turma I9', 'Turma prática de CRUD e autenticação.', '2025-08-16 14:22:47', NULL),
(10, 'Turma J10', 'Turma de testes automatizados e PHPUnit.', '2025-08-16 14:22:47', NULL),
(11, 'Turma K11', 'Turma de deploy e DevOps para aplicações PHP.', '2025-08-16 14:22:47', NULL),
(12, 'Turma L12', 'Turma de desenvolvimento mobile com PHP backend.', '2025-08-16 14:22:47', NULL),
(13, 'Turma M13', 'Turma de estudo de padrões de projeto e SOLID.', '2025-08-16 14:22:47', NULL),
(14, 'Turma N14', 'Turma de segurança em aplicações web.', '2025-08-16 14:22:47', NULL),
(15, 'Turma O15', 'Turma de projetos integradores e desafios práticos.', '2025-08-16 14:22:47', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `students_tbl`
--

CREATE TABLE `students_tbl` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `document` varchar(11) NOT NULL COMMENT 'Field intended for the student''s CPF',
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Stores student data in the system';

--
-- Despejando dados para a tabela `students_tbl`
--

INSERT INTO `students_tbl` (`id`, `name`, `date_of_birth`, `document`, `email`, `password`, `updated_at`, `deleted_at`) VALUES
(1, 'Ana Silva', '2000-05-12', '39053344705', 'ana.silva1@email.com', '$2y$10$hashAna1...', '2025-08-16 12:17:54', NULL),
(2, 'Bruno Souza', '1999-03-22', '62648716002', 'bruno.souza2@email.com', '$2y$10$hashBru2...', '2025-08-16 12:17:54', NULL),
(3, 'Carla Oliveira', '2001-07-18', '39053344715', 'carla.oliveira3@email.com', '$2y$10$hashCar3...', '2025-08-16 12:17:54', NULL),
(4, 'Diego Santos', '1998-11-05', '62648716030', 'diego.santos4@email.com', '$2y$10$hashDie4...', '2025-08-16 12:17:54', NULL),
(5, 'Eduarda Lima', '2002-09-30', '39053344722', 'eduarda.lima5@email.com', '$2y$10$hashEdu5...', '2025-08-16 12:17:54', NULL),
(6, 'Felipe Rocha', '1997-01-14', '62648716048', 'felipe.rocha6@email.com', '$2y$10$hashFel6...', '2025-08-16 12:17:54', NULL),
(7, 'Gabriela Martins', '2000-06-25', '39053344731', 'gabriela.martins7@email.com', '$2y$10$hashGab7...', '2025-08-16 12:17:54', NULL),
(8, 'Henrique Almeida', '1999-08-08', '62648716055', 'henrique.almeida8@email.com', '$2y$10$hashHen8...', '2025-08-16 12:17:54', NULL),
(9, 'Isabela Ferreira', '2001-10-19', '39053344748', 'isabela.ferreira9@email.com', '$2y$10$hashIsa9...', '2025-08-16 12:17:54', NULL),
(10, 'João Pedro', '1998-12-02', '62648716063', 'joao.pedro10@email.com', '$2y$10$hashJoa10...', '2025-08-16 12:17:54', NULL),
(11, 'Karen Azevedo', '2002-04-15', '39053344756', 'karen.azevedo11@email.com', '$2y$10$hashKar11...', '2025-08-16 12:17:54', NULL),
(12, 'Lucas Mendes', '1997-09-27', '62648716070', 'lucas.mendes12@email.com', '$2y$10$hashLuc12...', '2025-08-16 12:17:54', NULL),
(13, 'Mariana Costa', '2000-02-03', '39053344764', 'mariana.costa13@email.com', '$2y$10$hashMar13...', '2025-08-16 12:17:54', NULL),
(14, 'Nathan Ribeiro', '1999-06-12', '62648716089', 'nathan.ribeiro14@email.com', '$2y$10$hashNat14...', '2025-08-16 12:17:54', NULL),
(15, 'Olivia Torres', '2001-01-28', '39053344772', 'olivia.torres15@email.com', '$2y$10$hashOli15...', '2025-08-16 12:17:54', NULL),
(16, 'Paulo Henrique', '1998-05-10', '62648716097', 'paulo.henrique16@email.com', '$2y$10$hashPau16...', '2025-08-16 12:17:54', NULL),
(17, 'Rafaela Gomes', '2000-08-14', '39053344780', 'rafaela.gomes17@email.com', '$2y$10$hashRaf17...', '2025-08-16 12:17:54', NULL),
(18, 'Samuel Pinto', '1999-04-20', '62648716109', 'samuel.pinto18@email.com', '$2y$10$hashSam18...', '2025-08-16 12:17:54', NULL),
(19, 'Tatiane Souza', '2002-11-11', '39053344799', 'tatiane.souza19@email.com', '$2y$10$hashTat19...', '2025-08-16 12:17:54', NULL),
(20, 'Vinicius Costa', '1997-07-01', '62648716115', 'vinicius.costa20@email.com', '$2y$10$hashVin20...', '2025-08-16 12:17:54', NULL),
(21, 'Wesley Duarte', '1998-02-28', '39053344802', 'wesley.duarte21@email.com', '$2y$10$hashWes21...', '2025-08-16 12:17:54', NULL),
(22, 'Yasmin Rocha', '2000-10-23', '62648716124', 'yasmin.rocha22@email.com', '$2y$10$hashYas22...', '2025-08-16 12:17:54', NULL),
(23, 'Zeca Carvalho', '1999-09-09', '39053344815', 'zeca.carvalho23@email.com', '$2y$10$hashZec23...', '2025-08-16 12:17:54', NULL),
(24, 'Alice Prado', '2001-03-17', '62648716132', 'alice.prado24@email.com', '$2y$10$hashAli24...', '2025-08-16 12:17:54', NULL),
(25, 'Bernardo Lopes', '1998-12-25', '39053344823', 'bernardo.lopes25@email.com', '$2y$10$hashBer25...', '2025-08-16 12:17:54', NULL),
(26, 'Camila Duarte', '2002-01-09', '62648716141', 'camila.duarte26@email.com', '$2y$10$hashCam26...', '2025-08-16 12:17:54', NULL),
(27, 'Daniel Ribeiro', '1997-06-16', '39053344830', 'daniel.ribeiro27@email.com', '$2y$10$hashDan27...', '2025-08-16 12:17:54', NULL),
(28, 'Elisa Castro', '2000-09-05', '62648716159', 'elisa.castro28@email.com', '$2y$10$hashEli28...', '2025-08-16 12:17:54', NULL),
(29, 'Fernando Reis', '1999-05-21', '39053344848', 'fernando.reis29@email.com', '$2y$10$hashFer29...', '2025-08-16 12:17:54', NULL),
(30, 'Giovana Melo', '2001-12-13', '62648716167', 'giovana.melo30@email.com', '$2y$10$hashGio30...', '2025-08-16 12:17:54', NULL),
(31, 'Hugo Teixeira', '1998-07-08', '39053344856', 'hugo.teixeira31@email.com', '$2y$10$hashHug31...', '2025-08-16 12:17:54', NULL),
(32, 'Isadora Silva', '2000-04-19', '62648716175', 'isadora.silva32@email.com', '$2y$10$hashIsa32...', '2025-08-16 12:17:54', NULL),
(33, 'Júlia Freitas', '1999-11-27', '39053344864', 'julia.freitas33@email.com', '$2y$10$hashJul33...', '2025-08-16 12:17:54', NULL),
(34, 'Kaio Moura', '2002-02-06', '62648716183', 'kaio.moura34@email.com', '$2y$10$hashKai34...', '2025-08-16 12:17:54', NULL),
(35, 'Larissa Campos', '1997-08-29', '39053344872', 'larissa.campos35@email.com', '$2y$10$hashLar35...', '2025-08-16 12:17:54', NULL),
(36, 'Mateus Alves', '2000-01-15', '62648716191', 'mateus.alves36@email.com', '$2y$10$hashMat36...', '2025-08-16 12:17:54', NULL),
(37, 'Nicole Ramos', '1999-10-30', '39053344889', 'nicole.ramos37@email.com', '$2y$10$hashNic37...', '2025-08-16 12:17:54', NULL),
(38, 'Otávio Farias', '1998-05-02', '62648716205', 'otavio.farias38@email.com', '$2y$10$hashOta38...', '2025-08-16 12:17:54', NULL),
(39, 'Patrícia Nunes', '2001-09-12', '39053344897', 'patricia.nunes39@email.com', '$2y$10$hashPat39...', '2025-08-16 12:17:54', NULL),
(40, 'Rodrigo Cunha', '1997-03-21', '62648716213', 'rodrigo.cunha40@email.com', '$2y$10$hashRod40...', '2025-08-16 12:17:54', NULL),
(41, 'Sara Barbosa', '2000-12-24', '39053344901', 'sara.barbosa41@email.com', '$2y$10$hashSar41...', '2025-08-16 12:17:54', NULL),
(42, 'Thiago Lopes', '1999-06-06', '62648716221', 'thiago.lopes42@email.com', '$2y$10$hashThi42...', '2025-08-16 12:17:54', NULL),
(43, 'Ursula Pires', '2001-08-28', '39053344918', 'ursula.pires43@email.com', '$2y$10$hashUrs43...', '2025-08-16 12:17:54', NULL),
(44, 'Victor Hugo', '1998-01-11', '62648716230', 'victor.hugo44@email.com', '$2y$10$hashVic44...', '2025-08-16 12:17:54', NULL),
(45, 'William Silva', '2000-07-03', '39053344926', 'william.silva45@email.com', '$2y$10$hashWil45...', '2025-08-16 12:17:54', NULL),
(46, 'Xavier Prado', '1999-02-20', '62648716248', 'xavier.prado46@email.com', '$2y$10$hashXav46...', '2025-08-16 12:17:54', NULL),
(47, 'Yuri Matos', '2002-06-16', '39053344933', 'yuri.matos47@email.com', '$2y$10$hashYur47...', '2025-08-16 12:17:54', NULL),
(48, 'Zilda Fernandes', '1997-09-09', '62648716256', 'zilda.fernandes48@email.com', '$2y$10$hashZil48...', '2025-08-16 12:17:54', NULL),
(49, 'Arthur Nogueira', '2001-11-14', '39053344941', 'arthur.nogueira49@email.com', '$2y$10$hashArt49...', '2025-08-16 12:17:54', '2025-08-17 00:27:52'),
(50, 'Bianca Rezende', '1998-03-08', '62648716264', 'bianca.rezende50@email.com', '$2y$10$hashBia50...', '2025-08-16 12:17:54', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `users_tbl`
--

CREATE TABLE `users_tbl` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `users_tbl`
--

INSERT INTO `users_tbl` (`id`, `name`, `email`, `password`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'admin@php.com', '$2y$10$EmiQ.rihli1BjzJMUMkaKeilhk/qaeJ0q5ln9Pumc9tmpdpj56Qty', '2025-08-16 01:38:57', NULL);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `classes_students_tbl`
--
ALTER TABLE `classes_students_tbl`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_class_student` (`class_id`,`student_id`),
  ADD KEY `fk_student` (`student_id`);

--
-- Índices de tabela `classes_tbl`
--
ALTER TABLE `classes_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `students_tbl`
--
ALTER TABLE `students_tbl`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `document` (`document`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices de tabela `users_tbl`
--
ALTER TABLE `users_tbl`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `classes_students_tbl`
--
ALTER TABLE `classes_students_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT de tabela `classes_tbl`
--
ALTER TABLE `classes_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT de tabela `students_tbl`
--
ALTER TABLE `students_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de tabela `users_tbl`
--
ALTER TABLE `users_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `classes_students_tbl`
--
ALTER TABLE `classes_students_tbl`
  ADD CONSTRAINT `fk_class` FOREIGN KEY (`class_id`) REFERENCES `classes_tbl` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_student` FOREIGN KEY (`student_id`) REFERENCES `students_tbl` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
