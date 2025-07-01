-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01/07/2025 às 21:45
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
-- Procedimentos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_agendamentos_por_email` (IN `p_email` VARCHAR(255))   BEGIN
  SELECT
    a.id_agendamento,
    a.usuario_id,
    u.email,
    a.data,
    a.horario_inicio,
    a.horario_fim
  FROM agenda a
  JOIN usuarios u
    ON a.usuario_id = u.id
  WHERE u.email = p_email
  ORDER BY a.data, a.horario_inicio;
END$$

--
-- Funções
--
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_slots_livres` (`p_data` DATE) RETURNS INT(11) DETERMINISTIC BEGIN
  DECLARE vagas INT;

  -- Conta quantos agendamentos já existem na data
  SELECT COUNT(*) INTO vagas
    FROM agenda
   WHERE data = p_data;

  -- Total de slots = 22; vagas livres = 22 – agendamentos
  SET vagas = 22 - vagas;

  -- Nunca menor que zero
  RETURN GREATEST(vagas, 0);
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
(5, 4, '2025-07-02', '13:30:00', '14:00:00'),
(8, 4, '2025-06-28', '19:00:00', '19:30:00');

--
-- Acionadores `agenda`
--
DELIMITER $$
CREATE TRIGGER `trg_agendamento_before_insert` BEFORE INSERT ON `agenda` FOR EACH ROW BEGIN
  -- 1. Data não pode ser no passado
  IF NEW.data < CURDATE() THEN
    SIGNAL SQLSTATE '45000' 
      SET MESSAGE_TEXT = 'Data de agendamento não pode ser no passado';
  END IF;

  -- 2. Calcular automaticamente o horário_fim (+30m)
  SET NEW.horario_fim = ADDTIME(NEW.horario_inicio,'00:30:00');

  -- 3. Se for o mesmo dia, o horário de início não pode ser antes da hora atual
  IF NEW.data = CURDATE() AND NEW.horario_inicio <= CURTIME() THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Horário de início não pode ser no passado';
  END IF;

  -- 4. Só permite se o horário_fim for até no máximo 19:00
  IF NEW.horario_fim > '19:00:00' THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Agendamentos não podem terminar após às 19:00';
  END IF;

  -- 5. Prevenir conflito exato
  IF EXISTS (
    SELECT 1 FROM `agenda`
     WHERE data = NEW.data
       AND horario_inicio = NEW.horario_inicio
  ) THEN
    SIGNAL SQLSTATE '45000' 
      SET MESSAGE_TEXT = 'Já existe agendamento no mesmo horário de início';
  END IF;

  -- 6. Prevenir sobreposição
  IF EXISTS (
    SELECT 1 FROM `agenda`
     WHERE data = NEW.data
       AND (
         NEW.horario_inicio BETWEEN horario_inicio AND horario_fim
      OR NEW.horario_fim    BETWEEN horario_inicio AND horario_fim
      OR horario_inicio      BETWEEN NEW.horario_inicio AND NEW.horario_fim
       )
  ) THEN
    SIGNAL SQLSTATE '45000' 
      SET MESSAGE_TEXT = 'Horário sobreposto a outro agendamento';
  END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_agendamento_before_update` BEFORE UPDATE ON `agenda` FOR EACH ROW BEGIN
  -- 1. Data não pode ser no passado
  IF NEW.data < CURDATE() THEN
    SIGNAL SQLSTATE '45000' 
      SET MESSAGE_TEXT = 'Data de agendamento não pode ser no passado';
  END IF;

  -- 2. Só horário comercial (08:00–19:00)
  IF TIME(NEW.horario_inicio) < '08:00:00'
     OR TIME(NEW.horario_inicio) > '19:00:00' THEN
    SIGNAL SQLSTATE '45000' 
      SET MESSAGE_TEXT = 'Fora do horário comercial (08:00–19:00)';
  END IF;

  -- 3. Calcular horário_fim (+30m)
  SET NEW.horario_fim = ADDTIME(NEW.horario_inicio,'00:30:00');

  -- 4. Prevenir conflito exato (ignorando o próprio registro)
  IF EXISTS (
    SELECT 1 FROM `agenda`
     WHERE id_agendamento <> OLD.id_agendamento
       AND data = NEW.data
       AND horario_inicio = NEW.horario_inicio
  ) THEN
    SIGNAL SQLSTATE '45000' 
      SET MESSAGE_TEXT = 'Já existe agendamento no mesmo horário de início';
  END IF;

  -- 5. Prevenir sobreposição (ignorando o próprio registro)
  IF EXISTS (
    SELECT 1 FROM `agenda`
     WHERE id_agendamento <> OLD.id_agendamento
       AND data = NEW.data
       AND (
         NEW.horario_inicio BETWEEN horario_inicio AND horario_fim
      OR NEW.horario_fim    BETWEEN horario_inicio AND horario_fim
      OR horario_inicio      BETWEEN NEW.horario_inicio AND NEW.horario_fim
       )
  ) THEN
    SIGNAL SQLSTATE '45000' 
      SET MESSAGE_TEXT = 'Horário sobreposto a outro agendamento';
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
  MODIFY `id_agendamento` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

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
