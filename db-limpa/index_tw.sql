-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Tempo de geração: 11-Jun-2026 às 23:07
-- Versão do servidor: 10.11.16-MariaDB-ubu2204
-- versão do PHP: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de dados: `index_tw`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `admin_memo`
--

CREATE TABLE `admin_memo` (
  `id` int(11) NOT NULL,
  `date` varchar(500) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `tworca` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `nazwa` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `tekst` mediumtext CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` enum('info','warning','error','success') DEFAULT 'info',
  `active` tinyint(1) DEFAULT 1,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `bookmarks`
--

CREATE TABLE `bookmarks` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_village` int(11) NOT NULL,
  `text` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `codigos`
--

CREATE TABLE `codigos` (
  `id` int(11) NOT NULL,
  `kod` varchar(12) NOT NULL,
  `wykorzystany` set('N','Y') NOT NULL DEFAULT 'N',
  `wykorzystal` int(11) NOT NULL DEFAULT 0,
  `wykorzystano` int(11) NOT NULL DEFAULT 0,
  `typ` set('1','2','3') NOT NULL DEFAULT '1',
  `po` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `conecoes`
--

CREATE TABLE `conecoes` (
  `id` int(11) NOT NULL,
  `client_ip` varchar(50) NOT NULL,
  `client_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `conta`
--

CREATE TABLE `conta` (
  `id` int(11) NOT NULL,
  `haslo` varchar(150) NOT NULL,
  `nazwa` varchar(50) NOT NULL,
  `serwery_gry` varchar(500) NOT NULL,
  `premium_p` int(11) NOT NULL DEFAULT 0,
  `email` varchar(100) NOT NULL,
  `language` varchar(10) DEFAULT 'pt_PT',
  `kod` text NOT NULL,
  `activated` set('1','0') NOT NULL DEFAULT '0',
  `notka` longtext CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `date_reg` varchar(500) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ip_reg` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `admin` int(11) NOT NULL DEFAULT 0,
  `session` varchar(5000) NOT NULL,
  `banned` enum('1','0') NOT NULL DEFAULT '0',
  `theme` varchar(20) NOT NULL DEFAULT 'modern'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `hall_of_fame`
--

CREATE TABLE `hall_of_fame` (
  `id` int(11) NOT NULL,
  `world_name` varchar(50) NOT NULL,
  `world_db` varchar(50) NOT NULL,
  `type` enum('player','tribe') NOT NULL,
  `rank` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `points` bigint(20) NOT NULL DEFAULT 0,
  `villages` int(11) NOT NULL DEFAULT 0,
  `members` int(11) DEFAULT NULL COMMENT 'Only for tribes',
  `closed_at` datetime NOT NULL,
  `closed_by` varchar(255) DEFAULT NULL COMMENT 'Admin who closed the world'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mapa`
--

CREATE TABLE `mapa` (
  `id` int(11) NOT NULL,
  `wym` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `data` varchar(50) NOT NULL,
  `text` varchar(1500) NOT NULL,
  `typ` enum('1','0') NOT NULL,
  `nazwa` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expires` int(11) NOT NULL,
  `created_at` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `player_awards_history`
--

CREATE TABLE `player_awards_history` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `world_db` varchar(50) NOT NULL,
  `world_name` varchar(50) NOT NULL,
  `player_name` varchar(255) NOT NULL,
  `awards_regular` text NOT NULL,
  `awards_daily` text NOT NULL,
  `final_points` bigint(20) DEFAULT 0,
  `final_rank` int(11) DEFAULT 0,
  `world_status` enum('active','closed') DEFAULT 'active',
  `saved_at` datetime NOT NULL,
  `closed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `premium_log`
--

CREATE TABLE `premium_log` (
  `id` int(11) NOT NULL,
  `gracz` int(11) NOT NULL,
  `tekst` varchar(5000) NOT NULL,
  `swiat` varchar(11) NOT NULL,
  `data` int(11) NOT NULL,
  `saldo` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `rules`
--

CREATE TABLE `rules` (
  `id` int(11) NOT NULL,
  `section` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `order_num` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `gracz` varchar(50) NOT NULL,
  `opis` varchar(500) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `admin_memo`
--
ALTER TABLE `admin_memo`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_active` (`active`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Índices para tabela `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Índices para tabela `codigos`
--
ALTER TABLE `codigos`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `conecoes`
--
ALTER TABLE `conecoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `conta`
--
ALTER TABLE `conta`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `hall_of_fame`
--
ALTER TABLE `hall_of_fame`
  ADD PRIMARY KEY (`id`),
  ADD KEY `world_db` (`world_db`),
  ADD KEY `type_rank` (`type`,`rank`);

--
-- Índices para tabela `mapa`
--
ALTER TABLE `mapa`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `token` (`token`),
  ADD KEY `expires` (`expires`);

--
-- Índices para tabela `player_awards_history`
--
ALTER TABLE `player_awards_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `world_db` (`world_db`),
  ADD KEY `world_status` (`world_status`),
  ADD KEY `account_world` (`account_id`,`world_db`),
  ADD KEY `idx_account_status` (`account_id`,`world_status`);

--
-- Índices para tabela `premium_log`
--
ALTER TABLE `premium_log`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `rules`
--
ALTER TABLE `rules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_order` (`order_num`);

--
-- Índices para tabela `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `admin_memo`
--
ALTER TABLE `admin_memo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `codigos`
--
ALTER TABLE `codigos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `conecoes`
--
ALTER TABLE `conecoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `conta`
--
ALTER TABLE `conta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `hall_of_fame`
--
ALTER TABLE `hall_of_fame`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `mapa`
--
ALTER TABLE `mapa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `player_awards_history`
--
ALTER TABLE `player_awards_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `premium_log`
--
ALTER TABLE `premium_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `rules`
--
ALTER TABLE `rules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
