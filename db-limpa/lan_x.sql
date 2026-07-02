-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Tempo de geração: 11-Jun-2026 às 23:05
-- Versão do servidor: 10.11.16-MariaDB-ubu2204
-- versão do PHP: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------

--
-- Estrutura da tabela `account_manager_construction`
--

CREATE TABLE `account_manager_construction` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `village_id` int(11) NOT NULL,
  `template_name` varchar(50) NOT NULL DEFAULT 'normal',
  `target_levels` text NOT NULL COMMENT 'JSON object with building target levels',
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `orders_completed` int(11) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `active_effects`
--

CREATE TABLE `active_effects` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `village_id` int(11) DEFAULT NULL,
  `effect_type` varchar(50) NOT NULL,
  `effect_value` varchar(100) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `item_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ally`
--

CREATE TABLE `ally` (
  `id` int(11) NOT NULL,
  `name` varchar(200) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `short` varchar(100) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `points` int(11) NOT NULL,
  `rank` int(11) NOT NULL,
  `best_points` int(11) NOT NULL,
  `members` int(11) NOT NULL,
  `villages` int(11) NOT NULL,
  `intern_text` longtext CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `intern_text_bb` text NOT NULL,
  `description` longtext CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `internal_text` text DEFAULT NULL,
  `description_bb` text NOT NULL,
  `homepage` varchar(640) NOT NULL,
  `irc` varchar(640) NOT NULL,
  `image` varchar(200) NOT NULL,
  `rezerwacje_czas` int(11) NOT NULL DEFAULT 3,
  `rezerwacje_max` int(11) NOT NULL DEFAULT 5,
  `killed_units_att` bigint(20) NOT NULL DEFAULT 0,
  `killed_units_def` bigint(20) NOT NULL DEFAULT 0,
  `killed_units_altogether` bigint(20) NOT NULL DEFAULT 0,
  `killed_units_att_rang` int(11) NOT NULL DEFAULT 0,
  `killed_units_def_rang` int(11) NOT NULL DEFAULT 0,
  `killed_units_altogether_rang` int(11) NOT NULL DEFAULT 0,
  `add_ffid` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ally_contracts`
--

CREATE TABLE `ally_contracts` (
  `id` int(11) NOT NULL,
  `from_ally` int(11) NOT NULL,
  `to_ally` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `text` text DEFAULT NULL,
  `date` int(11) NOT NULL,
  `end_date` int(11) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ally_events`
--

CREATE TABLE `ally_events` (
  `id` int(11) NOT NULL,
  `ally` int(11) NOT NULL,
  `time` varchar(200) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `message` text CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ally_forum_polls`
--

CREATE TABLE `ally_forum_polls` (
  `id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `multiple_choice` tinyint(1) NOT NULL DEFAULT 0,
  `max_choices` int(11) NOT NULL DEFAULT 1,
  `end_time` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ally_forum_poll_options`
--

CREATE TABLE `ally_forum_poll_options` (
  `id` int(11) NOT NULL,
  `poll_id` int(11) NOT NULL,
  `option_text` varchar(255) NOT NULL,
  `votes` int(11) NOT NULL DEFAULT 0,
  `position` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ally_forum_poll_votes`
--

CREATE TABLE `ally_forum_poll_votes` (
  `id` int(11) NOT NULL,
  `poll_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `voted_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ally_forum_posts`
--

CREATE TABLE `ally_forum_posts` (
  `id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) DEFAULT NULL,
  `edited_by` int(11) DEFAULT NULL,
  `edited_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ally_forum_read`
--

CREATE TABLE `ally_forum_read` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `thread_id` int(11) NOT NULL,
  `last_read_post_id` int(11) NOT NULL,
  `last_read_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ally_forum_sections`
--

CREATE TABLE `ally_forum_sections` (
  `id` int(11) NOT NULL,
  `ally_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ally_forum_threads`
--

CREATE TABLE `ally_forum_threads` (
  `id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `ally_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `is_sticky` tinyint(1) NOT NULL DEFAULT 0,
  `is_locked` tinyint(1) NOT NULL DEFAULT 0,
  `is_poll` tinyint(1) NOT NULL DEFAULT 0,
  `views` int(11) NOT NULL DEFAULT 0,
  `replies` int(11) NOT NULL DEFAULT 0,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `last_post_id` int(11) DEFAULT NULL,
  `last_post_user_id` int(11) DEFAULT NULL,
  `last_post_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ally_invites`
--

CREATE TABLE `ally_invites` (
  `id` int(11) NOT NULL,
  `from_ally` int(11) NOT NULL,
  `to_userid` int(11) NOT NULL,
  `to_username` varchar(200) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ally_reservations`
--

CREATE TABLE `ally_reservations` (
  `id` int(11) NOT NULL,
  `ally_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `village_id` int(11) NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `ally_statistics`
--

CREATE TABLE `ally_statistics` (
  `id` int(11) NOT NULL,
  `ally_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `points` int(11) DEFAULT 0,
  `villages` int(11) DEFAULT 0,
  `members` int(11) DEFAULT 0,
  `rank_position` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `announcement`
--

CREATE TABLE `announcement` (
  `id` int(11) NOT NULL,
  `text` text CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `link` varchar(320) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `graphic` varchar(100) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `awards`
--

CREATE TABLE `awards` (
  `id` int(11) NOT NULL,
  `od_gracza` int(11) NOT NULL,
  `do_gracza` int(11) NOT NULL,
  `kolor` varchar(15) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `blocked_players`
--

CREATE TABLE `blocked_players` (
  `id` int(11) NOT NULL,
  `blocker_id` int(11) NOT NULL COMMENT 'ID do jogador que bloqueou',
  `blocked_id` int(11) NOT NULL COMMENT 'ID do jogador bloqueado',
  `blocked_date` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Data do bloqueio',
  `reason` varchar(255) DEFAULT NULL COMMENT 'Razão do bloqueio (opcional)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='Jogadores bloqueados';

-- --------------------------------------------------------

--
-- Estrutura da tabela `blocked_users`
--

CREATE TABLE `blocked_users` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `blocked_user_id` int(11) NOT NULL,
  `blocked_at` int(11) NOT NULL
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
-- Estrutura da tabela `bot`
--

CREATE TABLE `bot` (
  `villageid` int(11) NOT NULL,
  `type` enum('deff','off','spy') NOT NULL,
  `finish_tec` enum('y','n') NOT NULL,
  `finish_build` enum('y','n') NOT NULL,
  `main` int(11) NOT NULL,
  `barracks` int(11) NOT NULL,
  `stable` int(11) NOT NULL,
  `garage` int(11) NOT NULL,
  `snob` int(11) NOT NULL,
  `smith` int(11) NOT NULL,
  `place` int(11) NOT NULL,
  `market` int(11) NOT NULL,
  `wood` int(11) NOT NULL,
  `stone` int(11) NOT NULL,
  `iron` int(11) NOT NULL,
  `storage` int(11) NOT NULL,
  `farm` int(11) NOT NULL,
  `hide` int(11) NOT NULL,
  `wall` int(11) NOT NULL,
  `tec_spear` enum('y','n') NOT NULL DEFAULT 'y',
  `tec_sword` enum('y','n') NOT NULL DEFAULT 'y',
  `tec_axe` enum('y','n') NOT NULL DEFAULT 'y',
  `tec_spy` enum('y','n') NOT NULL DEFAULT 'y',
  `tec_light` enum('y','n') NOT NULL DEFAULT 'y',
  `tec_heavy` enum('y','n') NOT NULL DEFAULT 'y',
  `tec_ram` enum('y','n') NOT NULL DEFAULT 'y',
  `tec_catapult` enum('y','n') NOT NULL DEFAULT 'y',
  `next_build` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `build`
--

CREATE TABLE `build` (
  `id` int(11) NOT NULL,
  `building` varchar(30) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `villageid` int(11) DEFAULT NULL,
  `end_time` int(11) NOT NULL,
  `build_time` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `conquer_log`
--

CREATE TABLE `conquer_log` (
  `id` int(11) NOT NULL,
  `village_id` int(11) NOT NULL,
  `unix_timestamp` int(11) NOT NULL,
  `new_owner` int(11) NOT NULL,
  `old_owner` int(11) NOT NULL,
  `points` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `daily_bonus_claims`
--

CREATE TABLE `daily_bonus_claims` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL COMMENT 'Player ID',
  `day` int(11) NOT NULL COMMENT 'Day claimed (1-9)',
  `month` int(11) NOT NULL COMMENT 'Month (1-12)',
  `year` int(11) NOT NULL COMMENT 'Year',
  `claimed_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Claim timestamp',
  `reward_claimed` text DEFAULT NULL COMMENT 'Reward received (JSON)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='Daily bonus claims by players';

-- --------------------------------------------------------

--
-- Estrutura da tabela `daily_bonus_config`
--

CREATE TABLE `daily_bonus_config` (
  `id` int(11) NOT NULL,
  `day` int(11) NOT NULL COMMENT 'Day number (1-9)',
  `chest_type` enum('normal','golden') NOT NULL DEFAULT 'normal' COMMENT 'Chest type',
  `reward_type` varchar(50) NOT NULL COMMENT 'Type: resources, premium, items, flags',
  `reward_data` text NOT NULL COMMENT 'JSON with reward details',
  `chest_image` varchar(255) DEFAULT NULL COMMENT 'Closed chest image path',
  `chest_image_open` varchar(255) DEFAULT NULL COMMENT 'Open chest image path',
  `description` varchar(255) DEFAULT NULL COMMENT 'Reward description'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='Daily bonus chest configuration';

-- --------------------------------------------------------

--
-- Estrutura da tabela `daily_bonus_streak`
--

CREATE TABLE `daily_bonus_streak` (
  `user_id` int(11) NOT NULL COMMENT 'Player ID',
  `current_streak` int(11) NOT NULL DEFAULT 0 COMMENT 'Current consecutive days',
  `last_claim_date` date DEFAULT NULL COMMENT 'Last claim date',
  `best_streak` int(11) NOT NULL DEFAULT 0 COMMENT 'Best streak ever',
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='Player login streak tracking';

-- --------------------------------------------------------

--
-- Estrutura da tabela `dealers`
--

CREATE TABLE `dealers` (
  `id` int(11) NOT NULL,
  `from_userid` int(11) NOT NULL,
  `to_userid` int(11) NOT NULL,
  `from_village` int(11) NOT NULL,
  `to_village` int(11) NOT NULL,
  `wood` int(11) NOT NULL,
  `stone` int(11) NOT NULL,
  `iron` int(11) NOT NULL,
  `start_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  `is_offer` int(11) NOT NULL DEFAULT 0,
  `dealers` int(11) NOT NULL DEFAULT 0,
  `type` varchar(4) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `decoration`
--

CREATE TABLE `decoration` (
  `id` int(11) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `typ` varchar(25) NOT NULL,
  `typ2` varchar(10) NOT NULL DEFAULT 'k'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `destory`
--

CREATE TABLE `destory` (
  `id` int(11) NOT NULL,
  `build` varchar(50) NOT NULL,
  `end_time` int(11) NOT NULL,
  `trwanie` int(11) NOT NULL,
  `villageid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `event_time` int(11) DEFAULT 0,
  `event_type` varchar(30) DEFAULT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `villageid` int(11) DEFAULT NULL,
  `knot_event` int(11) NOT NULL,
  `cid` varchar(32) CHARACTER SET latin1 COLLATE latin1_german1_ci DEFAULT '0',
  `can_knot` int(11) NOT NULL DEFAULT 0,
  `is_locked` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `event_horde_data`
--

CREATE TABLE `event_horde_data` (
  `user_id` int(11) NOT NULL,
  `energy` int(11) DEFAULT 10,
  `last_energy_update` int(11) DEFAULT NULL,
  `guidons` int(11) DEFAULT 0,
  `secret_combination` varchar(100) DEFAULT NULL,
  `locked_slots` varchar(100) DEFAULT '0,0,0,0,0',
  `last_attempt` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `event_horse_race`
--

CREATE TABLE `event_horse_race` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `distance` int(11) DEFAULT 0,
  `energy` int(11) DEFAULT 10,
  `trophies` int(11) DEFAULT 0,
  `last_energy_update` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `event_spring_data`
--

CREATE TABLE `event_spring_data` (
  `user_id` int(11) NOT NULL,
  `points` int(11) DEFAULT 0,
  `last_point_date` date DEFAULT NULL,
  `opened_boxes` text DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `farm_targets`
--

CREATE TABLE `farm_targets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `target_x` int(11) NOT NULL,
  `target_y` int(11) NOT NULL,
  `created_at` bigint(20) NOT NULL,
  `last_attack` bigint(20) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Farm Assistant target villages';

-- --------------------------------------------------------

--
-- Estrutura da tabela `favorite`
--

CREATE TABLE `favorite` (
  `id` int(11) NOT NULL,
  `gracz` int(11) NOT NULL,
  `wioska` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `flag_history`
--

CREATE TABLE `flag_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `flag_type` varchar(50) NOT NULL,
  `flag_level` int(11) NOT NULL,
  `reason` varchar(100) DEFAULT NULL,
  `acquired_at` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `flag_trades`
--

CREATE TABLE `flag_trades` (
  `id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL,
  `offered_flag_type` varchar(50) DEFAULT NULL,
  `offered_flag_level` int(11) DEFAULT NULL,
  `requested_flag_type` varchar(50) DEFAULT NULL,
  `requested_flag_level` int(11) DEFAULT NULL,
  `status` enum('pending','accepted','rejected','cancelled') DEFAULT 'pending',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `foruns`
--

CREATE TABLE `foruns` (
  `id` int(11) NOT NULL,
  `plemie` int(11) NOT NULL,
  `nazwa` text NOT NULL,
  `visible` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `friends`
--

CREATE TABLE `friends` (
  `id` int(11) NOT NULL,
  `type` enum('activ','pending') NOT NULL DEFAULT 'pending',
  `id_from` int(11) NOT NULL DEFAULT -1,
  `id_to` int(11) NOT NULL DEFAULT -1
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `friend_invites`
--

CREATE TABLE `friend_invites` (
  `id` int(11) NOT NULL,
  `inviter_id` int(11) NOT NULL COMMENT 'ID do jogador que enviou o convite',
  `email` varchar(255) NOT NULL COMMENT 'Email do convidado',
  `invite_code` varchar(50) NOT NULL COMMENT 'Código único do convite',
  `sent_date` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'Data de envio',
  `accepted_date` datetime DEFAULT NULL COMMENT 'Data de aceitação',
  `new_user_id` int(11) DEFAULT NULL COMMENT 'ID do novo utilizador (após registo)',
  `status` enum('pending','accepted','expired') DEFAULT 'pending' COMMENT 'Estado do convite'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci COMMENT='Convites de amigos';

-- --------------------------------------------------------

--
-- Estrutura da tabela `f_ankiety`
--

CREATE TABLE `f_ankiety` (
  `id` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `fid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `graczid` int(11) NOT NULL,
  `wioska` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `inventory_history`
--

CREATE TABLE `inventory_history` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `change_type` enum('add','use','expire','remove') NOT NULL,
  `quantity` int(11) NOT NULL,
  `source` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `type` enum('resource_pack','boost','protection','instant','special') NOT NULL,
  `effect_type` varchar(50) DEFAULT NULL,
  `effect_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`effect_data`)),
  `stackable` tinyint(1) DEFAULT 1,
  `max_stack` int(11) DEFAULT 999,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `kontrakty`
--

CREATE TABLE `kontrakty` (
  `id` int(11) NOT NULL,
  `od_plemienia` int(11) NOT NULL,
  `do_plemienia` int(11) NOT NULL,
  `typ` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `leitura`
--

CREATE TABLE `leitura` (
  `id` int(11) NOT NULL,
  `graczid` int(11) NOT NULL,
  `fid` int(11) NOT NULL,
  `tid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `login`
--

CREATE TABLE `login` (
  `login_locked` enum('yes','no') CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL DEFAULT 'no',
  `start` varchar(50) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `first_visit` tinyint(1) NOT NULL DEFAULT 0,
  `extern_auth` varchar(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `logins`
--

CREATE TABLE `logins` (
  `id` int(11) NOT NULL,
  `username` varchar(250) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `time` int(11) NOT NULL,
  `ip` varchar(30) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `userid` int(11) NOT NULL,
  `uv` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user` varchar(320) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `village` varchar(320) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `time` int(11) NOT NULL,
  `log` text CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `event_id` int(11) NOT NULL,
  `event_type` varchar(25) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mail_archiv`
--

CREATE TABLE `mail_archiv` (
  `id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL DEFAULT 0,
  `from_username` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `to_id` int(11) NOT NULL DEFAULT 0,
  `to_username` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `subject` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `text` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `time` int(11) NOT NULL DEFAULT 0,
  `owner` int(11) NOT NULL,
  `type` varchar(3) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mail_block`
--

CREATE TABLE `mail_block` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `blocked_id` int(11) NOT NULL,
  `blocked_name` varchar(150) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mail_in`
--

CREATE TABLE `mail_in` (
  `id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL DEFAULT 0,
  `from_username` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `to_id` int(11) NOT NULL DEFAULT 0,
  `to_username` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `subject` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `text` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_read` int(11) NOT NULL DEFAULT 0,
  `is_answered` int(11) NOT NULL DEFAULT 0,
  `is_archived` tinyint(1) NOT NULL DEFAULT 0,
  `output_id` int(11) NOT NULL DEFAULT 0,
  `time` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mail_out`
--

CREATE TABLE `mail_out` (
  `id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL DEFAULT 0,
  `from_username` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `to_id` int(11) NOT NULL DEFAULT 0,
  `to_username` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `subject` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '',
  `text` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `is_read` int(11) NOT NULL DEFAULT 0,
  `is_archived` tinyint(1) NOT NULL DEFAULT 0,
  `time` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `market_offers`
--

CREATE TABLE `market_offers` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `villageid` int(11) NOT NULL,
  `sell_wood` int(11) NOT NULL DEFAULT 0,
  `sell_stone` int(11) NOT NULL DEFAULT 0,
  `sell_iron` int(11) NOT NULL DEFAULT 0,
  `buy_wood` int(11) NOT NULL DEFAULT 0,
  `buy_stone` int(11) NOT NULL DEFAULT 0,
  `buy_iron` int(11) NOT NULL DEFAULT 0,
  `multi` int(11) NOT NULL DEFAULT 1,
  `max_time` int(11) NOT NULL DEFAULT 0,
  `create_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mentors`
--

CREATE TABLE `mentors` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `registered_at` int(11) NOT NULL,
  `max_mentees` int(11) DEFAULT 3,
  `active` tinyint(4) DEFAULT 1,
  `total_mentees` int(11) DEFAULT 0,
  `completed_mentees` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mentor_assignments`
--

CREATE TABLE `mentor_assignments` (
  `id` int(11) NOT NULL,
  `mentor_id` int(11) NOT NULL,
  `mentee_id` int(11) NOT NULL,
  `assigned_at` int(11) NOT NULL,
  `completed_at` int(11) DEFAULT NULL,
  `status` enum('active','completed','abandoned') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `movements`
--

CREATE TABLE `movements` (
  `id` int(11) NOT NULL,
  `from_village` int(11) DEFAULT NULL,
  `to_village` int(11) DEFAULT NULL,
  `units` varchar(350) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `type` varchar(15) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `start_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  `building` varchar(60) CHARACTER SET latin1 COLLATE latin1_german1_ci DEFAULT NULL,
  `from_userid` int(11) NOT NULL,
  `to_userid` int(11) NOT NULL,
  `to_hidden` int(11) DEFAULT 0,
  `wood` int(11) NOT NULL DEFAULT 0,
  `stone` int(11) NOT NULL DEFAULT 0,
  `iron` int(11) NOT NULL DEFAULT 0,
  `send_from_village` int(11) NOT NULL,
  `send_from_user` int(11) NOT NULL,
  `send_to_user` int(11) NOT NULL,
  `send_to_village` int(11) NOT NULL,
  `die` int(11) NOT NULL DEFAULT 0,
  `is_reloaded` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `offers`
--

CREATE TABLE `offers` (
  `id` int(11) NOT NULL,
  `sell` int(11) NOT NULL,
  `buy` int(11) NOT NULL,
  `sell_ress` varchar(5) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `buy_ress` varchar(5) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `multi` int(11) NOT NULL,
  `from_village` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `do_action` varchar(10) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `ratio_max` double NOT NULL,
  `userid` int(11) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `offers_multi`
--

CREATE TABLE `offers_multi` (
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `partilha_reservas`
--

CREATE TABLE `partilha_reservas` (
  `id` int(11) NOT NULL,
  `do_plemienia` int(11) NOT NULL DEFAULT 0,
  `od_plemienia` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `paypal_orders`
--

CREATE TABLE `paypal_orders` (
  `id` int(10) UNSIGNED NOT NULL,
  `paypal_order_id` varchar(50) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `package_index` tinyint(3) UNSIGNED NOT NULL,
  `points` int(10) UNSIGNED NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `currency` varchar(3) NOT NULL DEFAULT 'EUR',
  `status` enum('CREATED','COMPLETED','FAILED') NOT NULL DEFAULT 'CREATED',
  `created_at` datetime NOT NULL,
  `completed_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `players`
--

CREATE TABLE `players` (
  `id` int(11) NOT NULL,
  `ilosc` int(11) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `player_inventory`
--

CREATE TABLE `player_inventory` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1,
  `acquired_date` datetime DEFAULT current_timestamp(),
  `expires_date` datetime DEFAULT NULL,
  `source` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `player_statistics`
--

CREATE TABLE `player_statistics` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `points` int(11) DEFAULT 0,
  `villages` int(11) DEFAULT 0,
  `rank_position` int(11) DEFAULT 0,
  `villages_looted` int(11) DEFAULT 0,
  `resources_looted` int(11) DEFAULT 0,
  `units_defeated_att` int(11) DEFAULT 0,
  `units_defeated_def` int(11) DEFAULT 0,
  `units_lost_att` int(11) DEFAULT 0,
  `units_lost_def` int(11) DEFAULT 0,
  `resources_spent_units` int(11) DEFAULT 0,
  `resources_spent_buildings` int(11) DEFAULT 0,
  `resources_spent_research` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `posty`
--

CREATE TABLE `posty` (
  `id` int(11) NOT NULL,
  `graczid` int(11) NOT NULL,
  `temat` int(11) NOT NULL,
  `forum` int(11) NOT NULL,
  `data` int(11) NOT NULL,
  `msg` longtext NOT NULL,
  `msg_bb` longtext NOT NULL,
  `gracznazwa` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `premium_buildings`
--

CREATE TABLE `premium_buildings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `village_id` int(11) DEFAULT NULL,
  `building` varchar(50) DEFAULT NULL,
  `target_level` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT 5,
  `enabled` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `premium_config`
--

CREATE TABLE `premium_config` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `feature` varchar(50) NOT NULL,
  `config` text DEFAULT NULL,
  `enabled` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `construction_template` text DEFAULT NULL COMMENT 'JSON template for construction queue',
  `troops_template` text DEFAULT NULL COMMENT 'JSON template for troop recruitment',
  `research_template` text DEFAULT NULL COMMENT 'JSON template for research queue',
  `stock_template` text DEFAULT NULL COMMENT 'JSON template for stock distribution',
  `deliveries_template` text DEFAULT NULL COMMENT 'JSON template for supply routes',
  `stock_settings` text DEFAULT NULL,
  `notification_settings` text DEFAULT NULL,
  `custom_templates` text DEFAULT NULL COMMENT 'JSON object with custom building templates',
  `research_queue` text DEFAULT NULL COMMENT 'JSON array of research queue items',
  `research_custom_templates` text DEFAULT NULL COMMENT 'JSON object of custom research templates'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `premium_construction_queue`
--

CREATE TABLE `premium_construction_queue` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `village_id` int(11) NOT NULL,
  `building` varchar(50) NOT NULL,
  `target_level` int(11) NOT NULL,
  `priority` int(11) DEFAULT 0,
  `status` enum('pending','building','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `premium_exchange_stock`
--

CREATE TABLE `premium_exchange_stock` (
  `id` int(11) NOT NULL,
  `world_id` int(11) NOT NULL,
  `wood` bigint(20) NOT NULL DEFAULT 500000,
  `stone` bigint(20) NOT NULL DEFAULT 500000,
  `iron` bigint(20) NOT NULL DEFAULT 500000,
  `wood_capacity` bigint(20) NOT NULL DEFAULT 1000000,
  `stone_capacity` bigint(20) NOT NULL DEFAULT 1000000,
  `iron_capacity` bigint(20) NOT NULL DEFAULT 1000000,
  `last_update` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `premium_features_log`
--

CREATE TABLE `premium_features_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `feature_name` varchar(100) NOT NULL COMMENT 'premium_account, account_manager, farm_assistant, etc',
  `reason` varchar(255) DEFAULT NULL COMMENT 'Activation reason',
  `duration_days` int(11) NOT NULL,
  `points_spent` int(11) NOT NULL,
  `old_expiry` int(11) DEFAULT NULL COMMENT 'Unix timestamp',
  `new_expiry` int(11) NOT NULL COMMENT 'Unix timestamp',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `premium_gifts`
--

CREATE TABLE `premium_gifts` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `sender_username` varchar(255) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `recipient_username` varchar(255) NOT NULL,
  `feature_name` varchar(50) NOT NULL,
  `duration_days` int(11) NOT NULL,
  `points_spent` int(11) NOT NULL,
  `status` enum('pending','accepted','rejected') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `accepted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `premium_points_log`
--

CREATE TABLE `premium_points_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `transaction_type` varchar(50) NOT NULL COMMENT 'purchase, transfer_in, transfer_out, spend',
  `amount` int(11) NOT NULL COMMENT 'Positive for additions, negative for deductions',
  `balance_after` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `related_user_id` int(11) DEFAULT NULL COMMENT 'For transfers',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `premium_recruitment`
--

CREATE TABLE `premium_recruitment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `village_id` int(11) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `target_amount` int(11) DEFAULT NULL,
  `priority` int(11) DEFAULT 5,
  `enabled` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `premium_recruitment_queue`
--

CREATE TABLE `premium_recruitment_queue` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `village_id` int(11) NOT NULL,
  `unit_type` varchar(50) NOT NULL,
  `target_amount` int(11) NOT NULL,
  `priority` int(11) DEFAULT 0,
  `status` enum('pending','recruiting','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `premium_research`
--

CREATE TABLE `premium_research` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `village_id` int(11) DEFAULT NULL,
  `tech` varchar(50) DEFAULT NULL,
  `target_level` int(11) DEFAULT NULL,
  `enabled` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `premium_resources`
--

CREATE TABLE `premium_resources` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `source_village_id` int(11) DEFAULT NULL,
  `target_village_id` int(11) DEFAULT NULL,
  `resource_type` varchar(20) DEFAULT NULL,
  `threshold` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `enabled` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `premium_supply_routes`
--

CREATE TABLE `premium_supply_routes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `source_village_id` int(11) NOT NULL,
  `target_village_id` int(11) NOT NULL,
  `resource_type` enum('wood','stone','iron','all') DEFAULT 'all',
  `amount` int(11) DEFAULT 0,
  `active` tinyint(4) DEFAULT 1,
  `wood` int(11) DEFAULT 0,
  `clay` int(11) DEFAULT 0,
  `iron` int(11) DEFAULT 0,
  `days` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Array of day names' CHECK (json_valid(`days`)),
  `time` time DEFAULT '00:00:00',
  `last_executed` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `public_reports`
--

CREATE TABLE `public_reports` (
  `id` int(11) NOT NULL,
  `hash` varchar(32) NOT NULL,
  `report_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `published_at` int(11) NOT NULL,
  `view_count` int(11) DEFAULT 0,
  `show_all` tinyint(1) DEFAULT 0,
  `show_own_village` tinyint(1) DEFAULT 1,
  `show_own_units` tinyint(1) DEFAULT 1,
  `show_casualties` tinyint(1) DEFAULT 1,
  `show_enemy_village` tinyint(1) DEFAULT 0,
  `show_enemy_units` tinyint(1) DEFAULT 0,
  `show_enemy_casualties` tinyint(1) DEFAULT 0,
  `show_loot` tinyint(1) DEFAULT 0,
  `show_buildings` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `recruit`
--

CREATE TABLE `recruit` (
  `id` int(11) NOT NULL,
  `unit` varchar(40) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `num_unit` int(11) DEFAULT 0,
  `num_finished` int(11) DEFAULT 0,
  `last_reload` int(11) DEFAULT -1,
  `time_finished` int(11) NOT NULL,
  `time_start` int(11) NOT NULL,
  `time_per_unit` varchar(30) CHARACTER SET latin1 COLLATE latin1_german1_ci DEFAULT NULL,
  `building` varchar(35) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `villageid` int(11) NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `title` varchar(230) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `title_image` varchar(200) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `time` int(11) NOT NULL,
  `type` varchar(40) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `a_units` varchar(350) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `b_units` varchar(350) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `c_units` varchar(350) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `d_units` varchar(350) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `e_units` varchar(350) CHARACTER SET latin1 COLLATE latin1_german1_ci DEFAULT NULL,
  `f_units` varchar(500) NOT NULL,
  `agreement` varchar(20) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `ram` varchar(15) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `catapult` varchar(40) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `message` text CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `to_user` int(11) NOT NULL,
  `from_user` int(11) NOT NULL,
  `to_village` int(11) NOT NULL,
  `from_village` int(11) NOT NULL,
  `receiver_userid` int(11) NOT NULL,
  `is_new` int(11) NOT NULL DEFAULT 1,
  `in_group` varchar(40) CHARACTER SET latin1 COLLATE latin1_german1_ci DEFAULT NULL,
  `luck` varchar(6) CHARACTER SET latin1 COLLATE latin1_german1_ci DEFAULT NULL,
  `moral` int(11) DEFAULT NULL,
  `wins` varchar(15) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `hives` varchar(600) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `see_def_units` int(11) NOT NULL DEFAULT 1,
  `ally` int(11) NOT NULL,
  `allyname` varchar(200) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `from_username` varchar(200) NOT NULL,
  `to_username` varchar(200) NOT NULL,
  `sorowce_poz` varchar(100) NOT NULL,
  `budynki` varchar(300) NOT NULL,
  `att_pala_item` varchar(55) NOT NULL,
  `def_pala_item` varchar(55) NOT NULL,
  `att_pala_name` varchar(35) NOT NULL,
  `def_pala_name` varchar(35) NOT NULL,
  `pala_find_item` varchar(55) NOT NULL,
  `bonus_noc` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `research`
--

CREATE TABLE `research` (
  `id` int(11) NOT NULL,
  `research` varchar(30) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `villageid` int(11) NOT NULL,
  `end_time` int(11) NOT NULL,
  `trwanie` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `research_queue`
--

CREATE TABLE `research_queue` (
  `id` int(11) NOT NULL,
  `villageid` int(11) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `level` int(11) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `rezerwacje`
--

CREATE TABLE `rezerwacje` (
  `id` int(11) NOT NULL,
  `do_wioski` int(11) NOT NULL,
  `od_gracza` int(11) NOT NULL,
  `od_plemienia` int(11) NOT NULL,
  `start` int(11) NOT NULL,
  `koniec` int(11) NOT NULL,
  `od_gname` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `rezerwacje_log`
--

CREATE TABLE `rezerwacje_log` (
  `id` int(11) NOT NULL,
  `last_edit` int(11) NOT NULL,
  `czas_koniec` int(11) NOT NULL,
  `plemie` int(11) NOT NULL,
  `do_wioski` int(11) NOT NULL,
  `od_gracza` int(11) NOT NULL,
  `od_gname` varchar(75) NOT NULL,
  `proces` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `run_events`
--

CREATE TABLE `run_events` (
  `id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `save_players`
--

CREATE TABLE `save_players` (
  `id` int(11) NOT NULL,
  `round_id` int(11) NOT NULL DEFAULT 0,
  `username` varchar(200) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL DEFAULT '',
  `rank` int(11) NOT NULL DEFAULT 0,
  `ally` varchar(20) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL DEFAULT '',
  `points` int(11) NOT NULL DEFAULT 0,
  `villages` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `save_rounds`
--

CREATE TABLE `save_rounds` (
  `id` int(11) NOT NULL,
  `start` varchar(80) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL DEFAULT '',
  `end` varchar(80) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL DEFAULT '',
  `description` text CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `speed_units` varchar(10) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL DEFAULT '',
  `moral` int(11) NOT NULL DEFAULT 0,
  `speed` int(11) NOT NULL DEFAULT 0,
  `name` varchar(200) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL DEFAULT '',
  `map` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `sessions`
--

CREATE TABLE `sessions` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `sid` varchar(32) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `hkey` varchar(4) CHARACTER SET latin1 COLLATE latin1_german1_ci NOT NULL,
  `is_vacation` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `share_commands`
--

CREATE TABLE `share_commands` (
  `id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `to_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `support`
--

CREATE TABLE `support` (
  `id` int(11) NOT NULL,
  `subject` text NOT NULL,
  `uid` int(11) NOT NULL,
  `date` varchar(120) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `new` int(11) NOT NULL DEFAULT 0,
  `block` int(11) NOT NULL DEFAULT 0,
  `message` text NOT NULL,
  `new_admin` int(11) NOT NULL DEFAULT 0,
  `status` enum('open','answered','closed') DEFAULT 'open',
  `admin_reply` text DEFAULT NULL,
  `answered_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `support_post`
--

CREATE TABLE `support_post` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `date` varchar(120) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `username` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `message` text NOT NULL,
  `id_ticket` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `nazwa` text NOT NULL,
  `typ` int(11) NOT NULL DEFAULT 0,
  `graczid` int(11) NOT NULL,
  `forum` int(11) NOT NULL,
  `last_ptime` int(11) NOT NULL,
  `last_pauthor` text NOT NULL,
  `last_puid` int(11) NOT NULL,
  `odpowiedzi` int(11) NOT NULL DEFAULT 0,
  `is_close` int(11) NOT NULL DEFAULT 0,
  `important` int(11) NOT NULL DEFAULT 0,
  `pierwszy_post_id` int(11) NOT NULL,
  `czas_ut` int(11) NOT NULL,
  `gracznazwa` text NOT NULL,
  `show_wyn` int(11) NOT NULL,
  `odp` text NOT NULL,
  `wyn` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `twozenie_osady`
--

CREATE TABLE `twozenie_osady` (
  `okrag` int(11) NOT NULL DEFAULT 1,
  `osad_na_okragu` int(11) NOT NULL DEFAULT 0,
  `suma_wiosek` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `unit_place`
--

CREATE TABLE `unit_place` (
  `unit_spear` int(11) DEFAULT 0,
  `unit_sword` int(11) DEFAULT 0,
  `unit_axe` int(11) DEFAULT 0,
  `unit_mnich` int(11) DEFAULT 0,
  `unit_archer` int(11) NOT NULL DEFAULT 0,
  `unit_spy` int(11) DEFAULT 0,
  `unit_light` int(11) DEFAULT 0,
  `unit_cav_archer` int(11) NOT NULL DEFAULT 0,
  `unit_heavy` int(11) DEFAULT 0,
  `unit_ram` int(11) DEFAULT 0,
  `unit_catapult` int(11) DEFAULT 0,
  `unit_snob` int(11) DEFAULT 0,
  `unit_paladin` int(11) NOT NULL DEFAULT 0,
  `villages_from_id` int(11) NOT NULL DEFAULT 0,
  `villages_to_id` int(11) NOT NULL DEFAULT 0,
  `unit_militia` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `tw_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `hkey` varchar(50) NOT NULL,
  `username` varchar(150) DEFAULT NULL,
  `password` varchar(255) NOT NULL DEFAULT '',
  `start_gaming` int(11) NOT NULL,
  `last_restart` int(11) DEFAULT 0,
  `banned` enum('0','1') NOT NULL DEFAULT '0',
  `powod_banu` text NOT NULL,
  `poczatek_banu` int(11) NOT NULL,
  `koniec_banu` int(11) NOT NULL,
  `nr_banu` int(11) NOT NULL DEFAULT 0,
  `admin` enum('0','1') NOT NULL DEFAULT '0',
  `memo_name` varchar(50) NOT NULL DEFAULT 'Notatka',
  `premium_p` int(11) NOT NULL DEFAULT 250,
  `villages` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `ennobled_by` varchar(90) NOT NULL,
  `support_new` int(11) NOT NULL DEFAULT 0,
  `new_post` int(11) NOT NULL DEFAULT 0,
  `ally` int(11) NOT NULL DEFAULT -1,
  `ally_titel` varchar(200) NOT NULL,
  `ally_found` int(11) NOT NULL DEFAULT 0,
  `ally_lead` int(11) NOT NULL DEFAULT 0,
  `ally_invite` int(11) NOT NULL DEFAULT 0,
  `ally_diplomacy` int(11) NOT NULL DEFAULT 0,
  `ally_mass_mail` int(11) NOT NULL DEFAULT 0,
  `ally_mod_forum` int(11) NOT NULL DEFAULT 0,
  `ally_forum_switch` int(11) NOT NULL DEFAULT 0,
  `ally_forum_trust` int(11) NOT NULL DEFAULT 0,
  `rang` int(11) NOT NULL,
  `villages_mode` varchar(25) NOT NULL DEFAULT 'prod',
  `attacks` int(11) DEFAULT 0,
  `new_report` int(11) NOT NULL DEFAULT 0,
  `new_mail` int(11) DEFAULT 0,
  `mails_per_page` int(11) NOT NULL DEFAULT 12,
  `reports_per_page` int(11) NOT NULL DEFAULT 15,
  `market_sell` varchar(10) NOT NULL DEFAULT 'all',
  `market_buy` varchar(10) NOT NULL DEFAULT 'all',
  `market_ratio_max` varchar(5) NOT NULL DEFAULT '3',
  `killed_units_att` int(11) NOT NULL,
  `killed_units_att_rank` int(11) NOT NULL,
  `killed_units_def` int(11) NOT NULL,
  `killed_units_def_rank` int(11) NOT NULL,
  `killed_units_altogether` int(11) NOT NULL,
  `killed_units_altogether_rank` int(11) NOT NULL,
  `do_action` varchar(32) NOT NULL,
  `last_activity` int(11) NOT NULL,
  `birthday` varchar(10) NOT NULL,
  `vacation_id` int(11) NOT NULL DEFAULT -1,
  `vacation_name` varchar(150) NOT NULL,
  `vacation_accept` int(11) NOT NULL DEFAULT 0,
  `b_day` int(11) NOT NULL,
  `b_month` int(11) NOT NULL,
  `b_year` int(11) NOT NULL,
  `sex` enum('f','m','x') NOT NULL DEFAULT 'x',
  `home` varchar(150) NOT NULL,
  `image` varchar(20) NOT NULL,
  `personal_text` longtext NOT NULL,
  `personal_text_bb` longtext NOT NULL,
  `window_width` int(11) NOT NULL DEFAULT 840,
  `show_toolbar` int(11) NOT NULL DEFAULT 1,
  `quickbar_buildings` text DEFAULT NULL COMMENT 'JSON array of building keys for custom quickbar (max 8)',
  `dyn_menu` int(11) NOT NULL DEFAULT 1,
  `confirm_queue` int(11) NOT NULL DEFAULT 1,
  `map_size` int(11) NOT NULL DEFAULT 9,
  `classic_graphics` int(11) NOT NULL DEFAULT 0,
  `memo` longtext NOT NULL,
  `memo_bb` longtext NOT NULL,
  `map_reload` text NOT NULL,
  `aktu_vpage` int(11) NOT NULL DEFAULT 0,
  `o_labels` smallint(6) NOT NULL DEFAULT 1,
  `o_style` smallint(6) NOT NULL DEFAULT 1,
  `o_anims` smallint(6) NOT NULL DEFAULT 0,
  `monety` bigint(20) NOT NULL DEFAULT 0,
  `zlupione_sur` bigint(20) NOT NULL DEFAULT 0,
  `sfarmione_wioski` int(11) NOT NULL DEFAULT 0,
  `zniszczone_bud` int(11) NOT NULL DEFAULT 0,
  `zniszczone_mury` int(11) NOT NULL DEFAULT 0,
  `zab_szlachta` int(11) NOT NULL DEFAULT 0,
  `attacked_players` int(11) NOT NULL DEFAULT 0,
  `def_spy_attacks` int(11) NOT NULL DEFAULT 0,
  `zniszczone_armie` int(11) NOT NULL DEFAULT 0,
  `a_oferty` int(11) NOT NULL DEFAULT 0,
  `dni_w_plemieniu` int(11) NOT NULL DEFAULT 0,
  `awards_ally` int(11) NOT NULL DEFAULT 0,
  `awards_lastarel` int(11) NOT NULL DEFAULT 0,
  `podbicie_siebie` int(11) NOT NULL DEFAULT 0,
  `pech_szlachta` int(11) NOT NULL DEFAULT 0,
  `rycek_all_items` int(11) NOT NULL DEFAULT 0,
  `pok_ownunits` bigint(20) NOT NULL DEFAULT 0,
  `zab_jed_wwsp` bigint(20) NOT NULL DEFAULT 0,
  `wspieranie_inngr` int(11) NOT NULL DEFAULT 0,
  `zabite_jednostki` bigint(20) NOT NULL DEFAULT 0,
  `udane_rezerwacje` int(11) NOT NULL DEFAULT 0,
  `razy_rozp_nwg` int(11) NOT NULL DEFAULT 0,
  `day_zlupione_sur` int(11) NOT NULL DEFAULT 0,
  `day_sfarmione_wioski` int(11) NOT NULL DEFAULT 0,
  `day_pok_att` int(11) NOT NULL DEFAULT 0,
  `day_pok_def` int(11) NOT NULL DEFAULT 0,
  `day_podbicia` int(11) NOT NULL DEFAULT 0,
  `levele_odzanczen` longtext NOT NULL,
  `paladins` int(11) NOT NULL DEFAULT 0,
  `pala_name` varchar(35) NOT NULL DEFAULT 'Paladin',
  `pala_train` int(11) NOT NULL DEFAULT 0,
  `pala_items` varchar(500) NOT NULL,
  `pala_vill` int(11) NOT NULL,
  `pala_to_next_item` int(11) NOT NULL DEFAULT 0,
  `pala_aktu_item` varchar(55) NOT NULL,
  `dzienne_odznaczenia` longtext NOT NULL,
  `rezerwacje_nstr` int(11) NOT NULL DEFAULT 10,
  `awards_points` int(11) NOT NULL DEFAULT 0,
  `day_aw_points` int(11) NOT NULL DEFAULT 0,
  `awards_points_all` int(11) NOT NULL DEFAULT 0,
  `szcz_szlachta` int(11) NOT NULL DEFAULT 0,
  `award_rang` int(11) NOT NULL DEFAULT 1,
  `groups` longtext NOT NULL,
  `aktu_group` varchar(75) NOT NULL DEFAULT 'all',
  `villages_per_page` int(11) NOT NULL DEFAULT 30,
  `toolbar` varchar(15000) NOT NULL DEFAULT 'a:9:{i:0;a:3:{s:7:"obrazek";s:30:"/ds_graphic/buildings/main.png";s:5:"nazwa";s:6:"Edificio Principal";s:4:"link";s:45:"game.php?village=[akuvillage]&amp;screen=main";}i:1;a:3:{s:7:"foto";s:34:"/ds_graphic/buildings/barracks.png";s:5:"nome";s:7:"quartel";s:4:"link";s:49:"game.php?village=[akuvillage]&amp;screen=barracks";}i:2;a:3:{s:7:"foto";s:32:"/ds_graphic/buildings/stable.png";s:5:"nazwa";s:7:"EstÃ¡bulo";s:4:"link";s:47:"game.php?village=[akuvillage]&amp;screen=stable";}i:3;a:3:{s:7:"obrazek";s:32:"/ds_graphic/buildings/garage.png";s:5:"nazwa";s:8:"Warsztat";s:4:"link";s:47:"game.php?village=[akuvillage]&amp;screen=garage";}i:4;a:3:{s:7:"obrazek";s:30:"/ds_graphic/buildings/snob.png";s:5:"nazwa";s:5:"Paï¿½ac";s:4:"link";s:45:"game.php?village=[akuvillage]&amp;screen=snob";}i:5;a:3:{s:7:"obrazek";s:31:"/ds_graphic/buildings/smith.png";s:5:"nazwa";s:6:"Kuï¿½nia";s:4:"link";s:46:"game.php?village=[akuvillage]&amp;screen=smith";}i:6;a:3:{s:7:"obrazek";s:31:"/ds_graphic/buildings/place.png";s:5:"nazwa";s:4:"Plac";s:4:"link";s:46:"game.php?village=[akuvillage]&amp;screen=place";}i:7;a:3:{s:7:"obrazek";s:32:"/ds_graphic/buildings/market.png";s:5:"nazwa";s:5:"Rynek";s:4:"link";s:47:"game.php?village=[akuvillage]&amp;screen=market";}i:8;a:3:{s:7:"obrazek";s:34:"/ds_graphic/buildings/barracks.png";s:5:"nazwa";s:10:"Rekrutacja";s:4:"link";s:46:"game.php?village=[akuvillage]&amp;screen=train";}}',
  `hide_own_awards` int(11) NOT NULL DEFAULT 1,
  `hide_own_wtwaw` int(11) NOT NULL DEFAULT 1,
  `last_move` int(11) NOT NULL DEFAULT 0,
  `last_command` varchar(11) NOT NULL,
  `map_show_moral` int(11) NOT NULL DEFAULT 1,
  `map_show_ressis` int(11) NOT NULL DEFAULT 1,
  `map_show_workers` int(11) NOT NULL DEFAULT 1,
  `map_show_traders` int(11) NOT NULL DEFAULT 1,
  `map_show_troups` int(11) NOT NULL DEFAULT 1,
  `map_show_runtimes` int(11) NOT NULL DEFAULT 1,
  `map_show_mule_runtimes` int(11) NOT NULL DEFAULT 1,
  `snob_coins` int(11) NOT NULL DEFAULT 0,
  `snob_max_coins` int(11) NOT NULL DEFAULT 0,
  `bot` tinyint(1) DEFAULT 0,
  `premium_points` int(11) DEFAULT 250 COMMENT 'Premium points balance',
  `premium_active` tinyint(4) DEFAULT 0 COMMENT 'Premium status',
  `premium_expires` bigint(20) DEFAULT 0 COMMENT 'Premium expiration timestamp',
  `farm_templates` text DEFAULT NULL COMMENT 'Farm assistant templates A and B',
  `research_targets` text DEFAULT NULL COMMENT 'Research target levels',
  `account_manager_expires` datetime DEFAULT NULL,
  `farm_assistant_expires` datetime DEFAULT NULL,
  `wood_production_expires` datetime DEFAULT NULL,
  `clay_production_expires` datetime DEFAULT NULL,
  `iron_production_expires` datetime DEFAULT NULL,
  `premium_exchange_expires` int(11) DEFAULT 0,
  `show_active_worlds` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Show awards from other active worlds (0=hide, 1=show)',
  `show_closed_worlds` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Show awards from closed worlds (0=hide, 1=show)',
  `farm_assistant_auto_renew` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Auto-renew Farm Assistant subscription',
  `account_manager_auto_renew` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Auto-renew Account Manager subscription',
  `avatar` int(11) DEFAULT NULL,
  `ban_end` int(11) NOT NULL DEFAULT 0,
  `ort` varchar(64) DEFAULT NULL,
  `wood_production_auto_renew` tinyint(1) NOT NULL DEFAULT 0,
  `stone_production_auto_renew` tinyint(1) NOT NULL DEFAULT 0,
  `iron_production_auto_renew` tinyint(1) NOT NULL DEFAULT 0,
  `farm_auto_renew` tinyint(1) NOT NULL DEFAULT 0,
  `storage_auto_renew` tinyint(1) NOT NULL DEFAULT 0,
  `next_defeat_milestone` int(11) DEFAULT 200,
  `next_achievement_milestone` int(11) DEFAULT 150,
  `invite_reward_claimed` tinyint(4) DEFAULT 0,
  `clay_production_auto_renew` tinyint(1) DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `update_ally_stats_after_user_delete` AFTER DELETE ON `users` FOR EACH ROW BEGIN
    IF OLD.ally IS NOT NULL AND OLD.ally != -1 THEN
        UPDATE ally 
        SET members = (SELECT COUNT(*) FROM users WHERE ally = OLD.ally),
            villages = (SELECT COALESCE(SUM(villages), 0) FROM users WHERE ally = OLD.ally),
            points = (SELECT COALESCE(SUM(points), 0) FROM users WHERE ally = OLD.ally)
        WHERE id = OLD.ally;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_ally_stats_after_user_insert` AFTER INSERT ON `users` FOR EACH ROW BEGIN
    IF NEW.ally IS NOT NULL AND NEW.ally != -1 THEN
        UPDATE ally 
        SET members = (SELECT COUNT(*) FROM users WHERE ally = NEW.ally),
            villages = (SELECT COALESCE(SUM(villages), 0) FROM users WHERE ally = NEW.ally),
            points = (SELECT COALESCE(SUM(points), 0) FROM users WHERE ally = NEW.ally)
        WHERE id = NEW.ally;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_ally_stats_after_user_update` AFTER UPDATE ON `users` FOR EACH ROW BEGIN
    -- Update old ally stats if user left
    IF OLD.ally IS NOT NULL AND OLD.ally != -1 AND OLD.ally != NEW.ally THEN
        UPDATE ally 
        SET members = (SELECT COUNT(*) FROM users WHERE ally = OLD.ally),
            villages = (SELECT COALESCE(SUM(villages), 0) FROM users WHERE ally = OLD.ally),
            points = (SELECT COALESCE(SUM(points), 0) FROM users WHERE ally = OLD.ally)
        WHERE id = OLD.ally;
    END IF;
    
    -- Update new ally stats if user joined or points changed
    IF NEW.ally IS NOT NULL AND NEW.ally != -1 THEN
        UPDATE ally 
        SET members = (SELECT COUNT(*) FROM users WHERE ally = NEW.ally),
            villages = (SELECT COALESCE(SUM(villages), 0) FROM users WHERE ally = NEW.ally),
            points = (SELECT COALESCE(SUM(points), 0) FROM users WHERE ally = NEW.ally)
        WHERE id = NEW.ally;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_cosmetics`
--

CREATE TABLE `user_cosmetics` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `world_id` int(11) NOT NULL DEFAULT 1,
  `cosmetic_type` enum('name_color','name_animation','village_skin') NOT NULL,
  `cosmetic_value` varchar(50) NOT NULL,
  `purchased_at` timestamp NULL DEFAULT current_timestamp(),
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_flags`
--

CREATE TABLE `user_flags` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `flag_type` varchar(50) NOT NULL,
  `flag_level` int(11) NOT NULL DEFAULT 1,
  `count` int(11) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) DEFAULT 0,
  `acquired_at` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `villages`
--

CREATE TABLE `villages` (
  `id` int(11) NOT NULL,
  `x` int(11) NOT NULL,
  `y` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `userid` int(11) NOT NULL,
  `r_wood` varchar(230) DEFAULT '500',
  `r_stone` varchar(230) DEFAULT '500',
  `r_iron` varchar(230) DEFAULT '400',
  `r_bh` int(11) DEFAULT 52,
  `last_prod_aktu` int(11) NOT NULL,
  `points` int(11) DEFAULT 26,
  `continent` int(11) NOT NULL,
  `main` int(11) DEFAULT 1,
  `barracks` int(11) DEFAULT 0,
  `stable` int(11) DEFAULT 0,
  `church` int(11) DEFAULT 0,
  `garage` int(11) DEFAULT 0,
  `snob` int(11) DEFAULT 0,
  `smith` int(11) DEFAULT 0,
  `place` int(11) DEFAULT 1,
  `market` int(11) DEFAULT 0,
  `wood` int(11) DEFAULT 0,
  `stone` int(11) DEFAULT 0,
  `iron` int(11) DEFAULT 0,
  `storage` int(11) DEFAULT 1,
  `farm` int(11) DEFAULT 1,
  `hide` int(11) DEFAULT 0,
  `wall` int(11) DEFAULT 0,
  `watchtower` int(11) DEFAULT 0,
  `unit_spear_tec_level` int(11) DEFAULT 1 COMMENT 'Pesquisa',
  `unit_sword_tec_level` int(11) DEFAULT 0 COMMENT 'Pesquisa',
  `unit_axe_tec_level` int(11) DEFAULT 0 COMMENT 'Pesquisa',
  `unit_archer_tec_level` int(11) NOT NULL DEFAULT 0 COMMENT 'Pesquisa',
  `unit_spy_tec_level` int(11) DEFAULT 0 COMMENT 'Pesquisa',
  `unit_light_tec_level` int(11) DEFAULT 0 COMMENT 'Pesquisa',
  `unit_cav_archer_tec_level` int(11) NOT NULL DEFAULT 0 COMMENT 'Pesquisa',
  `unit_heavy_tec_level` int(11) DEFAULT 0 COMMENT 'Pesquisa',
  `unit_ram_tec_level` int(11) DEFAULT 0 COMMENT 'Pesquisa',
  `unit_catapult_tec_level` int(11) DEFAULT 0 COMMENT 'Pesquisa',
  `unit_snob_tec_level` int(11) DEFAULT 1 COMMENT 'Pesquisa',
  `unit_mnich_tec_level` int(11) DEFAULT 1 COMMENT 'Pesquisa',
  `trader_away` int(11) DEFAULT 0,
  `main_build` varchar(20) NOT NULL COMMENT '	',
  `all_unit_spear` int(11) NOT NULL DEFAULT 0 COMMENT 'ocupado na aldeia',
  `all_unit_sword` int(11) DEFAULT 0 COMMENT 'ocupado na aldeia	',
  `all_unit_axe` int(11) DEFAULT 0 COMMENT 'ocupado na aldeia	',
  `all_unit_mnich` int(11) DEFAULT 0 COMMENT 'ocupado na aldeia	',
  `all_unit_archer` int(11) NOT NULL DEFAULT 0 COMMENT 'ocupado na aldeia	',
  `all_unit_spy` int(11) DEFAULT 0 COMMENT 'ocupado na aldeia	',
  `all_unit_light` int(11) DEFAULT 0 COMMENT 'ocupado na aldeia	',
  `all_unit_cav_archer` int(11) NOT NULL DEFAULT 0 COMMENT 'ocupado na aldeia	',
  `all_unit_heavy` int(11) DEFAULT 0 COMMENT 'ocupado na aldeia	',
  `all_unit_ram` int(11) DEFAULT 0 COMMENT 'ocupado na aldeia	',
  `all_unit_catapult` int(11) DEFAULT 0 COMMENT 'ocupado na aldeia	',
  `all_unit_snob` int(11) DEFAULT 0 COMMENT 'ocupado na aldeia	',
  `all_unit_paladin` int(11) NOT NULL DEFAULT 0 COMMENT 'ocupado na aldeia	',
  `recruited_snobs` int(11) DEFAULT 0,
  `control_villages` int(11) DEFAULT 0,
  `attacks` int(11) DEFAULT 0,
  `agreement` varchar(200) DEFAULT '100',
  `agreement_aktu` int(11) NOT NULL,
  `snobed_by` int(11) DEFAULT -1,
  `dealers_outside` int(11) NOT NULL DEFAULT 0,
  `create_time` int(11) NOT NULL,
  `smith_tec` varchar(200) NOT NULL,
  `conmap_con` varchar(10) NOT NULL,
  `statue` int(11) DEFAULT 1,
  `last_barbar_build` int(11) NOT NULL DEFAULT 0,
  `bonus` int(11) NOT NULL DEFAULT 0,
  `group` varchar(75) NOT NULL DEFAULT 'all',
  `allw` varchar(230) NOT NULL DEFAULT '0',
  `alls` varchar(230) NOT NULL DEFAULT '0',
  `alli` varchar(230) NOT NULL DEFAULT '0',
  `botgroup` varchar(3) DEFAULT '',
  `militia_end_time` int(11) NOT NULL DEFAULT 0,
  `all_unit_militia` int(11) NOT NULL DEFAULT 0,
  `all_spear` int(11) NOT NULL DEFAULT 0,
  `all_sword` int(11) NOT NULL DEFAULT 0,
  `all_axe` int(11) NOT NULL DEFAULT 0,
  `all_archer` int(11) NOT NULL DEFAULT 0,
  `all_spy` int(11) NOT NULL DEFAULT 0,
  `all_light` int(11) NOT NULL DEFAULT 0,
  `all_marcher` int(11) NOT NULL DEFAULT 0,
  `all_heavy` int(11) NOT NULL DEFAULT 0,
  `all_ram` int(11) NOT NULL DEFAULT 0,
  `all_catapult` int(11) NOT NULL DEFAULT 0,
  `all_knight` int(11) NOT NULL DEFAULT 0,
  `all_snob` int(11) NOT NULL DEFAULT 0,
  `active_flag_type` varchar(50) DEFAULT NULL,
  `active_flag_level` int(11) DEFAULT 0,
  `group_id` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `village_groups`
--

CREATE TABLE `village_groups` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `world_statistics`
--

CREATE TABLE `world_statistics` (
  `id` int(11) NOT NULL,
  `players` int(11) NOT NULL DEFAULT 0,
  `villages` int(11) NOT NULL DEFAULT 0,
  `points` bigint(20) NOT NULL DEFAULT 0,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `account_manager_construction`
--
ALTER TABLE `account_manager_construction`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_village` (`user_id`,`village_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `village_id` (`village_id`),
  ADD KEY `active` (`active`);

--
-- Índices para tabela `active_effects`
--
ALTER TABLE `active_effects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `village_id` (`village_id`),
  ADD KEY `effect_type` (`effect_type`),
  ADD KEY `expires_at` (`expires_at`);

--
-- Índices para tabela `ally`
--
ALTER TABLE `ally`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rank` (`rank`),
  ADD KEY `name` (`name`),
  ADD KEY `short` (`short`);

--
-- Índices para tabela `ally_contracts`
--
ALTER TABLE `ally_contracts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_ally` (`from_ally`),
  ADD KEY `to_ally` (`to_ally`);

--
-- Índices para tabela `ally_events`
--
ALTER TABLE `ally_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ally` (`ally`),
  ADD KEY `time` (`time`);

--
-- Índices para tabela `ally_forum_polls`
--
ALTER TABLE `ally_forum_polls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `thread_id` (`thread_id`);

--
-- Índices para tabela `ally_forum_poll_options`
--
ALTER TABLE `ally_forum_poll_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `poll_id` (`poll_id`);

--
-- Índices para tabela `ally_forum_poll_votes`
--
ALTER TABLE `ally_forum_poll_votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `poll_user` (`poll_id`,`user_id`,`option_id`),
  ADD KEY `poll_id` (`poll_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices para tabela `ally_forum_posts`
--
ALTER TABLE `ally_forum_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `thread_id` (`thread_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `created_at` (`created_at`);

--
-- Índices para tabela `ally_forum_read`
--
ALTER TABLE `ally_forum_read`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_thread` (`user_id`,`thread_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `thread_id` (`thread_id`);

--
-- Índices para tabela `ally_forum_sections`
--
ALTER TABLE `ally_forum_sections`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ally_id` (`ally_id`);

--
-- Índices para tabela `ally_forum_threads`
--
ALTER TABLE `ally_forum_threads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `ally_id` (`ally_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `is_sticky` (`is_sticky`),
  ADD KEY `updated_at` (`updated_at`);

--
-- Índices para tabela `ally_invites`
--
ALTER TABLE `ally_invites`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `ally_reservations`
--
ALTER TABLE `ally_reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ally_id` (`ally_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `village_id` (`village_id`);

--
-- Índices para tabela `ally_statistics`
--
ALTER TABLE `ally_statistics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_ally_date` (`ally_id`,`date`),
  ADD KEY `idx_ally_date` (`ally_id`,`date`);

--
-- Índices para tabela `announcement`
--
ALTER TABLE `announcement`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `awards`
--
ALTER TABLE `awards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `od_gracza` (`od_gracza`),
  ADD KEY `do_gracza` (`do_gracza`);

--
-- Índices para tabela `blocked_players`
--
ALTER TABLE `blocked_players`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_block` (`blocker_id`,`blocked_id`),
  ADD KEY `idx_blocker` (`blocker_id`),
  ADD KEY `idx_blocked` (`blocked_id`);

--
-- Índices para tabela `blocked_users`
--
ALTER TABLE `blocked_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_block` (`user_id`,`blocked_user_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `blocked_user_id` (`blocked_user_id`);

--
-- Índices para tabela `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Índices para tabela `bot`
--
ALTER TABLE `bot`
  ADD PRIMARY KEY (`villageid`),
  ADD KEY `type` (`type`);

--
-- Índices para tabela `build`
--
ALTER TABLE `build`
  ADD PRIMARY KEY (`id`),
  ADD KEY `villageid` (`villageid`),
  ADD KEY `idx_build_village` (`villageid`);

--
-- Índices para tabela `conquer_log`
--
ALTER TABLE `conquer_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `new_owner` (`new_owner`),
  ADD KEY `old_owner` (`old_owner`),
  ADD KEY `village_id` (`village_id`),
  ADD KEY `unix_timestamp` (`unix_timestamp`);

--
-- Índices para tabela `daily_bonus_claims`
--
ALTER TABLE `daily_bonus_claims`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_claim` (`user_id`,`day`,`month`,`year`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_date` (`month`,`year`);

--
-- Índices para tabela `daily_bonus_config`
--
ALTER TABLE `daily_bonus_config`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_day` (`day`);

--
-- Índices para tabela `daily_bonus_streak`
--
ALTER TABLE `daily_bonus_streak`
  ADD PRIMARY KEY (`user_id`);

--
-- Índices para tabela `dealers`
--
ALTER TABLE `dealers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_village` (`from_village`),
  ADD KEY `to_village` (`to_village`);

--
-- Índices para tabela `decoration`
--
ALTER TABLE `decoration`
  ADD PRIMARY KEY (`id`),
  ADD KEY `x_y` (`x`,`y`),
  ADD KEY `kt` (`typ2`);

--
-- Índices para tabela `destory`
--
ALTER TABLE `destory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `villageid` (`villageid`);

--
-- Índices para tabela `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_type` (`event_type`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `event_time` (`event_time`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `villageid` (`villageid`),
  ADD KEY `idx_events_time_type` (`event_time`,`event_type`);

--
-- Índices para tabela `event_horde_data`
--
ALTER TABLE `event_horde_data`
  ADD PRIMARY KEY (`user_id`);

--
-- Índices para tabela `event_horse_race`
--
ALTER TABLE `event_horse_race`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Índices para tabela `event_spring_data`
--
ALTER TABLE `event_spring_data`
  ADD PRIMARY KEY (`user_id`);

--
-- Índices para tabela `farm_targets`
--
ALTER TABLE `farm_targets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_targets` (`user_id`),
  ADD KEY `idx_coords` (`target_x`,`target_y`);

--
-- Índices para tabela `favorite`
--
ALTER TABLE `favorite`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gracz` (`gracz`);

--
-- Índices para tabela `flag_history`
--
ALTER TABLE `flag_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices para tabela `flag_trades`
--
ALTER TABLE `flag_trades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_user` (`from_user_id`),
  ADD KEY `to_user` (`to_user_id`);

--
-- Índices para tabela `foruns`
--
ALTER TABLE `foruns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plemie` (`plemie`);

--
-- Índices para tabela `friends`
--
ALTER TABLE `friends`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`,`type`,`id_from`,`id_to`);

--
-- Índices para tabela `friend_invites`
--
ALTER TABLE `friend_invites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invite_code` (`invite_code`),
  ADD KEY `idx_inviter` (`inviter_id`),
  ADD KEY `idx_code` (`invite_code`),
  ADD KEY `idx_email` (`email`);

--
-- Índices para tabela `f_ankiety`
--
ALTER TABLE `f_ankiety`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tid` (`tid`),
  ADD KEY `uid` (`uid`),
  ADD KEY `fid` (`fid`);

--
-- Índices para tabela `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `graczid` (`graczid`);

--
-- Índices para tabela `inventory_history`
--
ALTER TABLE `inventory_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_date` (`user_id`,`created_at`),
  ADD KEY `idx_change_type` (`change_type`);

--
-- Índices para tabela `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_type` (`type`);

--
-- Índices para tabela `kontrakty`
--
ALTER TABLE `kontrakty`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `leitura`
--
ALTER TABLE `leitura`
  ADD PRIMARY KEY (`id`),
  ADD KEY `graczid` (`graczid`),
  ADD KEY `fid` (`fid`),
  ADD KEY `tid` (`tid`);

--
-- Índices para tabela `logins`
--
ALTER TABLE `logins`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `mail_archiv`
--
ALTER TABLE `mail_archiv`
  ADD PRIMARY KEY (`id`),
  ADD KEY `to_id` (`to_id`);

--
-- Índices para tabela `mail_block`
--
ALTER TABLE `mail_block`
  ADD PRIMARY KEY (`id`),
  ADD KEY `blocked_id` (`blocked_id`),
  ADD KEY `blocked_name` (`blocked_name`);

--
-- Índices para tabela `mail_in`
--
ALTER TABLE `mail_in`
  ADD PRIMARY KEY (`id`),
  ADD KEY `to_id` (`to_id`),
  ADD KEY `idx_mail_in_is_read` (`is_read`),
  ADD KEY `idx_mail_in_is_archived` (`is_archived`);

--
-- Índices para tabela `mail_out`
--
ALTER TABLE `mail_out`
  ADD PRIMARY KEY (`id`),
  ADD KEY `from_id` (`from_id`),
  ADD KEY `idx_mail_out_is_archived` (`is_archived`);

--
-- Índices para tabela `market_offers`
--
ALTER TABLE `market_offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`),
  ADD KEY `villageid` (`villageid`);

--
-- Índices para tabela `mentors`
--
ALTER TABLE `mentors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_active` (`active`);

--
-- Índices para tabela `mentor_assignments`
--
ALTER TABLE `mentor_assignments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mentee_id` (`mentee_id`),
  ADD KEY `idx_mentor` (`mentor_id`),
  ADD KEY `idx_mentee` (`mentee_id`),
  ADD KEY `idx_status` (`status`);

--
-- Índices para tabela `movements`
--
ALTER TABLE `movements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `end_time` (`end_time`),
  ADD KEY `send_from_village` (`send_from_village`),
  ADD KEY `send_from_user` (`send_from_user`),
  ADD KEY `send_to_user` (`send_to_user`),
  ADD KEY `send_to_village` (`send_to_village`),
  ADD KEY `from_hidden` (`to_hidden`),
  ADD KEY `type` (`type`);

--
-- Índices para tabela `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `offers_multi`
--
ALTER TABLE `offers_multi`
  ADD KEY `id` (`id`);

--
-- Índices para tabela `partilha_reservas`
--
ALTER TABLE `partilha_reservas`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `paypal_orders`
--
ALTER TABLE `paypal_orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `paypal_order_id` (`paypal_order_id`),
  ADD KEY `idx_user_id` (`user_id`),
  ADD KEY `idx_status` (`status`),
  ADD KEY `idx_created_at` (`created_at`);

--
-- Índices para tabela `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `player_inventory`
--
ALTER TABLE `player_inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_item` (`user_id`,`item_id`),
  ADD KEY `idx_expires` (`expires_date`);

--
-- Índices para tabela `player_statistics`
--
ALTER TABLE `player_statistics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_date` (`user_id`,`date`),
  ADD KEY `idx_user_date` (`user_id`,`date`);

--
-- Índices para tabela `posty`
--
ALTER TABLE `posty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `temat` (`temat`),
  ADD KEY `forum` (`forum`);

--
-- Índices para tabela `premium_buildings`
--
ALTER TABLE `premium_buildings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `village_id` (`village_id`);

--
-- Índices para tabela `premium_config`
--
ALTER TABLE `premium_config`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_feature` (`user_id`,`feature`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices para tabela `premium_construction_queue`
--
ALTER TABLE `premium_construction_queue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_status` (`user_id`,`status`),
  ADD KEY `idx_village_priority` (`village_id`,`priority`);

--
-- Índices para tabela `premium_exchange_stock`
--
ALTER TABLE `premium_exchange_stock`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `world_id` (`world_id`);

--
-- Índices para tabela `premium_features_log`
--
ALTER TABLE `premium_features_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_feature` (`feature_name`);

--
-- Índices para tabela `premium_gifts`
--
ALTER TABLE `premium_gifts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_recipient` (`recipient_id`,`status`),
  ADD KEY `idx_sender` (`sender_id`);

--
-- Índices para tabela `premium_points_log`
--
ALTER TABLE `premium_points_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_created` (`created_at`);

--
-- Índices para tabela `premium_recruitment`
--
ALTER TABLE `premium_recruitment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `village_id` (`village_id`);

--
-- Índices para tabela `premium_recruitment_queue`
--
ALTER TABLE `premium_recruitment_queue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_status` (`user_id`,`status`);

--
-- Índices para tabela `premium_research`
--
ALTER TABLE `premium_research`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `village_id` (`village_id`);

--
-- Índices para tabela `premium_resources`
--
ALTER TABLE `premium_resources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `source_village_id` (`source_village_id`),
  ADD KEY `target_village_id` (`target_village_id`);

--
-- Índices para tabela `premium_supply_routes`
--
ALTER TABLE `premium_supply_routes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user_active` (`user_id`,`active`),
  ADD KEY `idx_active_user` (`user_id`,`active`);

--
-- Índices para tabela `public_reports`
--
ALTER TABLE `public_reports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hash` (`hash`),
  ADD KEY `report_id` (`report_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices para tabela `recruit`
--
ALTER TABLE `recruit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `building` (`building`),
  ADD KEY `villageid` (`villageid`),
  ADD KEY `idx_recruit_village` (`villageid`);

--
-- Índices para tabela `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `receiver_userid` (`receiver_userid`),
  ADD KEY `group` (`in_group`),
  ADD KEY `idx_reports_is_new` (`is_new`);

--
-- Índices para tabela `research`
--
ALTER TABLE `research`
  ADD PRIMARY KEY (`id`),
  ADD KEY `villageid` (`villageid`);

--
-- Índices para tabela `research_queue`
--
ALTER TABLE `research_queue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `villageid` (`villageid`);

--
-- Índices para tabela `rezerwacje`
--
ALTER TABLE `rezerwacje`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx1` (`od_gracza`),
  ADD KEY `idx2` (`od_plemienia`);

--
-- Índices para tabela `rezerwacje_log`
--
ALTER TABLE `rezerwacje_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `czas_koniec` (`czas_koniec`);

--
-- Índices para tabela `run_events`
--
ALTER TABLE `run_events`
  ADD UNIQUE KEY `id` (`id`);

--
-- Índices para tabela `save_players`
--
ALTER TABLE `save_players`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `save_rounds`
--
ALTER TABLE `save_rounds`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sid` (`sid`),
  ADD KEY `userid` (`userid`);

--
-- Índices para tabela `share_commands`
--
ALTER TABLE `share_commands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_share` (`from_user_id`,`to_user_id`);

--
-- Índices para tabela `support`
--
ALTER TABLE `support`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `support_post`
--
ALTER TABLE `support_post`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `forum` (`forum`);

--
-- Índices para tabela `twozenie_osady`
--
ALTER TABLE `twozenie_osady`
  ADD PRIMARY KEY (`okrag`);

--
-- Índices para tabela `unit_place`
--
ALTER TABLE `unit_place`
  ADD UNIQUE KEY `unique_place` (`villages_from_id`,`villages_to_id`),
  ADD KEY `villages_from_id` (`villages_from_id`),
  ADD KEY `villages_to_id` (`villages_to_id`);

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`),
  ADD KEY `rang` (`rang`),
  ADD KEY `vacation_id` (`vacation_id`);

--
-- Índices para tabela `user_cosmetics`
--
ALTER TABLE `user_cosmetics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_world_type` (`user_id`,`world_id`,`cosmetic_type`),
  ADD KEY `idx_user_world` (`user_id`,`world_id`,`is_active`);

--
-- Índices para tabela `user_flags`
--
ALTER TABLE `user_flags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_flag` (`user_id`,`flag_type`,`flag_level`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices para tabela `villages`
--
ALTER TABLE `villages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `x_2` (`x`,`y`),
  ADD KEY `name` (`name`),
  ADD KEY `userid` (`userid`),
  ADD KEY `g1` (`group`),
  ADD KEY `continent` (`continent`),
  ADD KEY `idx_villages_userid_points` (`userid`,`points`),
  ADD KEY `idx_coords` (`x`,`y`);

--
-- Índices para tabela `village_groups`
--
ALTER TABLE `village_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices para tabela `world_statistics`
--
ALTER TABLE `world_statistics`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `date` (`date`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `account_manager_construction`
--
ALTER TABLE `account_manager_construction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `active_effects`
--
ALTER TABLE `active_effects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ally`
--
ALTER TABLE `ally`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ally_contracts`
--
ALTER TABLE `ally_contracts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ally_events`
--
ALTER TABLE `ally_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ally_forum_polls`
--
ALTER TABLE `ally_forum_polls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ally_forum_poll_options`
--
ALTER TABLE `ally_forum_poll_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ally_forum_poll_votes`
--
ALTER TABLE `ally_forum_poll_votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ally_forum_posts`
--
ALTER TABLE `ally_forum_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ally_forum_read`
--
ALTER TABLE `ally_forum_read`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ally_forum_sections`
--
ALTER TABLE `ally_forum_sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ally_forum_threads`
--
ALTER TABLE `ally_forum_threads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ally_invites`
--
ALTER TABLE `ally_invites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ally_reservations`
--
ALTER TABLE `ally_reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `ally_statistics`
--
ALTER TABLE `ally_statistics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `announcement`
--
ALTER TABLE `announcement`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `awards`
--
ALTER TABLE `awards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `blocked_players`
--
ALTER TABLE `blocked_players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `blocked_users`
--
ALTER TABLE `blocked_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `build`
--
ALTER TABLE `build`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `conquer_log`
--
ALTER TABLE `conquer_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `daily_bonus_claims`
--
ALTER TABLE `daily_bonus_claims`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `daily_bonus_config`
--
ALTER TABLE `daily_bonus_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `dealers`
--
ALTER TABLE `dealers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `decoration`
--
ALTER TABLE `decoration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `destory`
--
ALTER TABLE `destory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `event_horse_race`
--
ALTER TABLE `event_horse_race`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `farm_targets`
--
ALTER TABLE `farm_targets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `favorite`
--
ALTER TABLE `favorite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `flag_history`
--
ALTER TABLE `flag_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `flag_trades`
--
ALTER TABLE `flag_trades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `foruns`
--
ALTER TABLE `foruns`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `friends`
--
ALTER TABLE `friends`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `friend_invites`
--
ALTER TABLE `friend_invites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `f_ankiety`
--
ALTER TABLE `f_ankiety`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `inventory_history`
--
ALTER TABLE `inventory_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `kontrakty`
--
ALTER TABLE `kontrakty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `leitura`
--
ALTER TABLE `leitura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `logins`
--
ALTER TABLE `logins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `mail_archiv`
--
ALTER TABLE `mail_archiv`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `mail_block`
--
ALTER TABLE `mail_block`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `mail_in`
--
ALTER TABLE `mail_in`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `mail_out`
--
ALTER TABLE `mail_out`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `market_offers`
--
ALTER TABLE `market_offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `mentors`
--
ALTER TABLE `mentors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `mentor_assignments`
--
ALTER TABLE `mentor_assignments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `movements`
--
ALTER TABLE `movements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `partilha_reservas`
--
ALTER TABLE `partilha_reservas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `paypal_orders`
--
ALTER TABLE `paypal_orders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `players`
--
ALTER TABLE `players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `player_inventory`
--
ALTER TABLE `player_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `player_statistics`
--
ALTER TABLE `player_statistics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `posty`
--
ALTER TABLE `posty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `premium_buildings`
--
ALTER TABLE `premium_buildings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `premium_config`
--
ALTER TABLE `premium_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `premium_construction_queue`
--
ALTER TABLE `premium_construction_queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `premium_exchange_stock`
--
ALTER TABLE `premium_exchange_stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `premium_features_log`
--
ALTER TABLE `premium_features_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `premium_gifts`
--
ALTER TABLE `premium_gifts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `premium_points_log`
--
ALTER TABLE `premium_points_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `premium_recruitment`
--
ALTER TABLE `premium_recruitment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `premium_recruitment_queue`
--
ALTER TABLE `premium_recruitment_queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `premium_research`
--
ALTER TABLE `premium_research`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `premium_resources`
--
ALTER TABLE `premium_resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `premium_supply_routes`
--
ALTER TABLE `premium_supply_routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `public_reports`
--
ALTER TABLE `public_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `recruit`
--
ALTER TABLE `recruit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `research`
--
ALTER TABLE `research`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `research_queue`
--
ALTER TABLE `research_queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `rezerwacje`
--
ALTER TABLE `rezerwacje`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `rezerwacje_log`
--
ALTER TABLE `rezerwacje_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `save_players`
--
ALTER TABLE `save_players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `save_rounds`
--
ALTER TABLE `save_rounds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `sessions`
--
ALTER TABLE `sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `share_commands`
--
ALTER TABLE `share_commands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `support`
--
ALTER TABLE `support`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `support_post`
--
ALTER TABLE `support_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `user_cosmetics`
--
ALTER TABLE `user_cosmetics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `user_flags`
--
ALTER TABLE `user_flags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `villages`
--
ALTER TABLE `villages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `village_groups`
--
ALTER TABLE `village_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `world_statistics`
--
ALTER TABLE `world_statistics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
