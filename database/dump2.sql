-- Script completo do banco de dados fiap_php_db para MySQL

CREATE DATABASE IF NOT EXISTS `fiap_php_db`;
USE `fiap_php_db`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- Tabela `classes_tbl`
-- --------------------------------------------------------
CREATE TABLE `classes_tbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` text NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `classes_tbl` (`id`, `name`, `description`, `updated_at`, `deleted_at`) VALUES
(1, 'Turma A1', 'Turma inicial de alunos do curso de PHP.', '2025-08-17 05:00:40', NULL),
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
-- Tabela `students_tbl`
-- --------------------------------------------------------
CREATE TABLE `students_tbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `date_of_birth` date NOT NULL,
  `document` varchar(11) NOT NULL COMMENT 'CPF do aluno',
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `students_tbl` (`id`, `name`, `date_of_birth`, `document`, `email`, `password`, `updated_at`, `deleted_at`) VALUES
(1, 'Ana Silva', '1999-05-12', '35606151006', 'ana.silva1@email.com', '$2y$10$QzvKxoz/aAPmk.GcovO50O8rygh.H1T/n/Bpsg/WUu1', '2025-08-17 07:52:51', NULL),
(2, 'Bruno Souza', '1999-03-22', '62648716002', 'bruno.souza2@email.com', '$2y$10$hashBru2...', '2025-08-16 12:17:54', NULL);
-- (adicione todos os demais registros conforme seu arquivo original)

-- --------------------------------------------------------
-- Tabela `classes_students_tbl`
-- --------------------------------------------------------
CREATE TABLE `classes_students_tbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL COMMENT 'Referência para a turma (classes_tbl)',
  `student_id` int(11) NOT NULL COMMENT 'Referência para o aluno (students_tbl)',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Data e hora da matrícula',
  `deleted_at` datetime DEFAULT NULL COMMENT 'Data de exclusão lógica',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_class_student` (`class_id`,`student_id`),
  KEY `fk_student` (`student_id`),
  CONSTRAINT `fk_class` FOREIGN KEY (`class_id`) REFERENCES `classes_tbl` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_student` FOREIGN KEY (`student_id`) REFERENCES `students_tbl` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `classes_students_tbl` (`id`, `class_id`, `student_id`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, '2025-08-16 14:42:01', NULL),
(2, 2, 1, '2025-08-16 14:42:01', NULL);
-- (adicione todos os demais registros conforme seu arquivo original)

-- --------------------------------------------------------
-- Tabela `users_tbl`
-- --------------------------------------------------------
CREATE TABLE `users_tbl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `users_tbl` (`id`, `name`, `email`, `password`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', 'admin@php.com', '$2y$10$EmiQ.rihli1BjzJMUMkaKeilhk/qaeJ0q5ln9Pumc9tmpdpj56Qty', '2025-08-16 01:38:57', NULL);

COMMIT;