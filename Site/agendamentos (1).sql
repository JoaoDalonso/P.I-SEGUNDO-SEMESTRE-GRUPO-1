-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 10/06/2025 às 01:19
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
CREATE DATABASE IF NOT EXISTS `agendamentos` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `agendamentos`;

DELIMITER $$
--
-- Procedimentos
--
DROP PROCEDURE IF EXISTS `dias_para_proximo_agendamento`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `dias_para_proximo_agendamento` (IN `p_usuario_id` INT, OUT `out_dias` INT)   BEGIN
    DECLARE dias_restantes INT;

    SELECT DATEDIFF(MIN(data_agendamento), CURDATE())
    INTO dias_restantes
    FROM agendamentos
    WHERE usuario_id = p_usuario_id
      AND data_agendamento >= CURDATE();

    IF dias_restantes IS NULL THEN
        SET out_dias = -1;
    ELSE
        SET out_dias = dias_restantes;
    END IF;
END$$

--
-- Funções
--
DROP FUNCTION IF EXISTS `valida_agendamento`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `valida_agendamento` (`data_agendamento_param` DATE, `horario_param` TIME) RETURNS TINYINT(1) DETERMINISTIC BEGIN
    DECLARE dia_semana INT;

    -- Descobre o dia da semana (1 = Domingo, 2 = Segunda, ..., 7 = Sábado)
    SET dia_semana = DAYOFWEEK(data_agendamento_param);

    -- Validação: apenas de segunda (2) a sexta (6)
    IF dia_semana < 2 OR dia_semana > 6 THEN
        RETURN FALSE;
    END IF;

    -- Validação: horário deve estar entre 08:00 e 18:00
    IF horario_param < '08:00:00' OR horario_param >= '18:00:00' THEN
        RETURN FALSE;
    END IF;

    -- Validação: NÃO pode estar entre 12:00 e 13:30
    IF horario_param >= '12:00:00' AND horario_param < '13:30:00' THEN
        RETURN FALSE;
    END IF;

    -- Se passou em todas as validações
    RETURN TRUE;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `agendamentos`
--
-- Criação: 09/06/2025 às 22:56
-- Última atualização: 09/06/2025 às 23:07
--

DROP TABLE IF EXISTS `agendamentos`;
CREATE TABLE `agendamentos` (
  `id` int(10) UNSIGNED NOT NULL,
  `usuario_id` int(10) UNSIGNED NOT NULL,
  `telefone` varchar(13) NOT NULL,
  `data_agendamento` date NOT NULL,
  `horario` time NOT NULL,
  `saida` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONAMENTOS PARA TABELAS `agendamentos`:
--

--
-- Tabela truncada antes do insert `agendamentos`
--

TRUNCATE TABLE `agendamentos`;
--
-- Despejando dados para a tabela `agendamentos`
--

INSERT DELAYED IGNORE INTO `agendamentos` (`id`, `usuario_id`, `telefone`, `data_agendamento`, `horario`, `saida`) VALUES
(22, 2, '5519989494397', '2025-06-09', '14:30:00', '15:00:00'),
(23, 4, '19989494398', '2025-07-14', '14:30:00', '15:00:00');

--
-- Acionadores `agendamentos`
--
DROP TRIGGER IF EXISTS `trg_agendamento_before_insert`;
DELIMITER $$
CREATE TRIGGER `trg_agendamento_before_insert` BEFORE INSERT ON `agendamentos` FOR EACH ROW BEGIN
  -- 4.a) Calcula saida como 30 minutos após o horário escolhido
  SET NEW.saida = ADDTIME(NEW.horario, '00:30:00');

  -- 4.b) Verifica se existe algum outro agendamento no mesmo dia cuja faixa [horario, saida) colida com a faixa do novo
  IF EXISTS (
    SELECT 1
    FROM agendamentos AS a
    WHERE a.data_agendamento = NEW.data_agendamento
      AND (
        (NEW.horario < a.saida)
        AND (a.horario < NEW.saida)
      )
  ) THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Conflito de horário: já existe agendamento nesta faixa de 30 minutos.';
  END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_agendamento_before_update`;
DELIMITER $$
CREATE TRIGGER `trg_agendamento_before_update` BEFORE UPDATE ON `agendamentos` FOR EACH ROW BEGIN
  -- 5.a) Recalcula saida como 30 minutos após o horário atualizado
  SET NEW.saida = ADDTIME(NEW.horario, '00:30:00');

  -- 5.b) Verifica sobreposição (ignora o próprio ID em caso de atualização)
  IF EXISTS (
    SELECT 1
    FROM agendamentos AS a
    WHERE a.data_agendamento = NEW.data_agendamento
      AND a.id <> NEW.id
      AND (
        (NEW.horario < a.saida)
        AND (a.horario < NEW.saida)
      )
  ) THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Conflito de horário ao atualizar: já existe agendamento nesta faixa de 30 minutos.';
  END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_validar_agendamento_insert`;
DELIMITER $$
CREATE TRIGGER `trg_validar_agendamento_insert` BEFORE INSERT ON `agendamentos` FOR EACH ROW BEGIN
    -- Se a validação falhar, aborta com erro
    IF NOT valida_agendamento(NEW.data_agendamento, NEW.horario) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Agendamento inválido: deve ser de segunda a sexta, das 08:00 às 18:00 (exceto 12:00–13:30).';
    END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_validar_agendamento_update`;
DELIMITER $$
CREATE TRIGGER `trg_validar_agendamento_update` BEFORE UPDATE ON `agendamentos` FOR EACH ROW BEGIN
    -- Se a validação falhar, aborta com erro
    IF NOT valida_agendamento(NEW.data_agendamento, NEW.horario) THEN
        SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Agendamento inválido: deve ser de segunda a sexta, das 08:00 às 18:00 (exceto 12:00–13:30).';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--
-- Criação: 09/06/2025 às 22:55
-- Última atualização: 09/06/2025 às 23:02
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
  `id` int(10) UNSIGNED NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- RELACIONAMENTOS PARA TABELAS `usuarios`:
--

--
-- Tabela truncada antes do insert `usuarios`
--

TRUNCATE TABLE `usuarios`;
--
-- Despejando dados para a tabela `usuarios`
--

INSERT DELAYED IGNORE INTO `usuarios` (`id`, `nome`, `email`, `senha`, `telefone`, `data_cadastro`) VALUES
(3, 'admin', 'admin@gmail.com', '$2y$10$BJBUcXtmfKFLcl4GYa51qe706kCerqI7jHi77A0DILsiZVq271NkO', '19989494397', '2025-06-09 23:01:35'),
(4, 'pimentinha', 'pimenta@gmail.com', '$2y$10$w.cisjanMoNMLgbBJQ3Pa.n0aL5fPERI4kpCkVxgeBMAsk3kAwhuC', '19989494398', '2025-06-09 23:02:28');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unq_agendamento_data_horario` (`data_agendamento`,`horario`),
  ADD KEY `idx_agendamentos_usuario` (`usuario_id`);

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
-- AUTO_INCREMENT de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
