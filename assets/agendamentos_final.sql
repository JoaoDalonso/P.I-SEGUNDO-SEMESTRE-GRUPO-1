-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 23/06/2025 às 18:03
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
-- Banco de dados: `agendamentos`
--

DELIMITER $$
--
-- Funções
--
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_contar_agendamentos` (`p_usuario_id` INT) RETURNS INT(11) DETERMINISTIC BEGIN
  DECLARE total INT;
  SELECT COUNT(*) INTO total
    FROM agenda
   WHERE usuario_id = p_usuario_id;
  RETURN total;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `agenda`
--

CREATE TABLE `agenda` (
  `id_agendamento` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `data` date NOT NULL,
  `horario_inicio` time NOT NULL,
  `horario_fim` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `agenda`
--

INSERT INTO `agenda` (`id_agendamento`, `usuario_id`, `data`, `horario_inicio`, `horario_fim`) VALUES
(5, 4, '2025-06-24', '13:30:00', '14:00:00');

--
-- Acionadores `agenda`
--
DELIMITER $$
CREATE TRIGGER `trg_atualiza_horario_fim` BEFORE UPDATE ON `agenda` FOR EACH ROW BEGIN
  SET NEW.horario_fim = ADDTIME(NEW.horario_inicio, '00:30:00');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_calcula_horario_fim` BEFORE INSERT ON `agenda` FOR EACH ROW BEGIN
  SET NEW.horario_fim = ADDTIME(NEW.horario_inicio, '00:30:00');
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_prevenir_conflito` BEFORE INSERT ON `agenda` FOR EACH ROW BEGIN
  IF EXISTS (
    SELECT 1
      FROM `agenda`
     WHERE `usuario_id`     = NEW.usuario_id
       AND `data`           = NEW.data
       AND `horario_inicio` = NEW.horario_inicio
  ) THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Conflito: usuário já possui agendamento nesse dia e horário';
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_validar_data_agendamento` BEFORE INSERT ON `agenda` FOR EACH ROW BEGIN
  IF NEW.`data` < CURDATE() THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Data inválida: não é possível agendar em data passada';
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_validar_data_agendamento_update` BEFORE UPDATE ON `agenda` FOR EACH ROW BEGIN
  IF NEW.`data` < CURDATE() THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Data inválida: não é possível alterar para uma data passada';
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `telefone` varchar(20) NOT NULL DEFAULT '55'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `senha`, `telefone`) VALUES
(3, 'admin@gmail.com', 'admin', '5519989494397'),
(4, 'jjdalonso@gmail.com', '123', '+5519989494397');

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `vw_agendamentos_futuros`
-- (Veja abaixo para a visão atual)
--
CREATE TABLE `vw_agendamentos_futuros` (
`id_agendamento` int(10) unsigned
,`usuario_id` int(10) unsigned
,`data` date
,`horario_inicio` time
,`horario_fim` time
);

-- --------------------------------------------------------

--
-- Estrutura para view `vw_agendamentos_futuros`
--
DROP TABLE IF EXISTS `vw_agendamentos_futuros`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_agendamentos_futuros`  AS SELECT `agenda`.`id_agendamento` AS `id_agendamento`, `agenda`.`usuario_id` AS `usuario_id`, `agenda`.`data` AS `data`, `agenda`.`horario_inicio` AS `horario_inicio`, `agenda`.`horario_fim` AS `horario_fim` FROM `agenda` WHERE `agenda`.`data` >= curdate() ;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `agenda`
--
ALTER TABLE `agenda`
  ADD PRIMARY KEY (`id_agendamento`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agenda`
--
ALTER TABLE `agenda`
  MODIFY `id_agendamento` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `agenda`
--
ALTER TABLE `agenda`
  ADD CONSTRAINT `agenda_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
