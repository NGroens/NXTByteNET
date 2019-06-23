-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Erstellungszeit: 22. Mai 2019 um 13:43
-- Server-Version: 10.2.24-MariaDB
-- PHP-Version: 7.1.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `nxtbyte_z`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `affiliates`
--

CREATE TABLE `affiliates` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `affiliate_id` varchar(255) NOT NULL,
  `amount` decimal(43,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `affiliate_clicks`
--

CREATE TABLE `affiliate_clicks` (
  `id` int(11) NOT NULL,
  `affiliate_id` varchar(255) NOT NULL,
  `clicker_ip` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bonus_codes`
--

CREATE TABLE `bonus_codes` (
  `id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL,
  `amount` decimal(43,2) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `bonus_codes`
--

INSERT INTO `bonus_codes` (`id`, `code`, `amount`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'RadioBotsEU', '1.00', '2019-05-06 20:55:05', '2019-05-06 20:57:56', '2019-05-06 20:57:56');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `news`
--

CREATE TABLE `news` (
  `id` int(11) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `user_info` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `product_prices`
--

CREATE TABLE `product_prices` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(43,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `product_prices`
--

INSERT INTO `product_prices` (`id`, `product_name`, `price`) VALUES
(1, 'VOICEBOT', '0.60'),
(2, 'TEAMSPEAK', '0.18');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `radiobots`
--

CREATE TABLE `radiobots` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `bot_name` varchar(255) NOT NULL,
  `location` int(11) NOT NULL,
  `state` enum('ACTIVE','SUSPENDED','DISABLED','DELETED','NEED_INSTALL') NOT NULL,
  `server_addr` varchar(255) DEFAULT NULL,
  `volume` int(11) DEFAULT NULL,
  `server_password` varchar(255) DEFAULT NULL,
  `default_channel` varchar(255) DEFAULT NULL,
  `channel_password` varchar(255) DEFAULT NULL,
  `template_name` varchar(255) NOT NULL,
  `bot_id` int(11) DEFAULT NULL,
  `price` decimal(43,2) DEFAULT NULL,
  `expire_at` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `radiobot_hosts`
--

CREATE TABLE `radiobot_hosts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `public_name` varchar(255) NOT NULL,
  `node_ip` varchar(255) NOT NULL,
  `node_port` int(11) NOT NULL,
  `node_user` varchar(255) NOT NULL,
  `node_password` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `basicAuth` varchar(255) NOT NULL,
  `port` int(11) NOT NULL,
  `state` enum('ACTIVE','DISABLED','FULL') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `radiobot_hosts`
--

INSERT INTO `radiobot_hosts` (`id`, `name`, `public_name`, `node_ip`, `node_port`, `node_user`, `node_password`, `username`, `token`, `basicAuth`, `port`, `state`, `created_at`, `updated_at`) VALUES
(1, 'TS3-RadioBots #001', 'Deutschland (FRA)', 'ip', 22, 'root', 'server_pw', 'username', 'token', 'username:ts3ab:token', 58913, 'ACTIVE', '2019-02-16 00:28:50', '2019-05-22 13:33:42');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `radiobot_webradio_list`
--

CREATE TABLE `radiobot_webradio_list` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `settings`
--

CREATE TABLE `settings` (
  `login` int(11) NOT NULL,
  `register` int(11) NOT NULL DEFAULT 1,
  `start_amount` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `settings`
--

INSERT INTO `settings` (`login`, `register`, `start_amount`) VALUES
(1, 1, '0.00');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `teamspeaks`
--

CREATE TABLE `teamspeaks` (
  `id` int(11) NOT NULL,
  `status` enum('UNUSED','ONLINE','OFFLINE') NOT NULL,
  `slots` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `node_id` int(11) NOT NULL,
  `teamspeak_ip` varchar(255) NOT NULL,
  `teamspeak_port` varchar(255) NOT NULL,
  `sid` int(11) NOT NULL,
  `expire_at` datetime NOT NULL,
  `suspended` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `teamspeak_hosts`
--

CREATE TABLE `teamspeak_hosts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `login_ip` varchar(255) NOT NULL,
  `login_port` int(11) NOT NULL,
  `login_name` varchar(255) NOT NULL,
  `login_passwort` varchar(255) NOT NULL,
  `status` enum('ACTIVE','DISABLED') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `teamspeak_hosts`
--

INSERT INTO `teamspeak_hosts` (`id`, `name`, `login_ip`, `login_port`, `login_name`, `login_passwort`, `status`) VALUES
(1, 'TS-Instanz 01', 'ip', 10011, 'serveradmin', 'pw', 'ACTIVE');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `categorie` enum('ALLGEMEIN','TECHNIK','BUCHHALTUNG') NOT NULL,
  `priority` enum('NORMAL','MITTEL','HOCH','PARTNER') NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('OPEN','CLOSED') NOT NULL,
  `last_msg` enum('CUSTOMER','SUPPORT') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `ticket_message`
--

CREATE TABLE `ticket_message` (
  `id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `writer_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `topup_actions`
--

CREATE TABLE `topup_actions` (
  `id` int(11) NOT NULL,
  `method` varchar(255) NOT NULL,
  `percent` decimal(12,2) NOT NULL,
  `expire_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `topup_actions`
--

INSERT INTO `topup_actions` (`id`, `method`, `percent`, `expire_at`, `updated_at`, `created_at`) VALUES
(1, 'PAYSAFECARD', '1.10', NULL, '2019-05-07 01:17:07', '2019-05-07 01:17:07'),
(2, 'PAYPAL', '1.25', NULL, '2019-05-07 01:17:07', '2019-05-07 01:17:07'),
(3, 'CREDITCARD', '1.25', NULL, '2019-05-07 01:17:07', '2019-05-07 01:17:07');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `gateway` enum('paysafecard','intern','creditcard','paypal') NOT NULL,
  `state` enum('PENDING','ABORT','DONE') NOT NULL,
  `amount` decimal(43,2) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `tid` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `transfer_money`
--

CREATE TABLE `transfer_money` (
  `id` int(11) NOT NULL,
  `sender_name` varchar(255) NOT NULL,
  `receiver_name` varchar(255) NOT NULL,
  `amount` decimal(43,2) NOT NULL,
  `key` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('USER','SUPPORT','ADMIN') NOT NULL,
  `status` enum('PENDING','ACTIVE','BANNED') NOT NULL,
  `flagged` enum('NO','YES') NOT NULL,
  `amount` decimal(42,2) NOT NULL,
  `bonus_amount` decimal(43,2) DEFAULT NULL,
  `verify_code` varchar(255) DEFAULT NULL,
  `account_note` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `vorname` varchar(255) DEFAULT NULL,
  `nachname` varchar(255) DEFAULT NULL,
  `strasse` varchar(255) DEFAULT NULL,
  `postleitzahl` varchar(255) DEFAULT NULL,
  `stadt` varchar(255) DEFAULT NULL,
  `land` varchar(255) DEFAULT NULL,
  `msg_order` int(11) NOT NULL DEFAULT 1,
  `msg_money` int(11) NOT NULL DEFAULT 1,
  `msg_support` int(11) NOT NULL DEFAULT 1,
  `affiliate_id` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user_transactions`
--

CREATE TABLE `user_transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `art` enum('INTERN','ORDER','RENEW') NOT NULL,
  `amount` decimal(43,2) NOT NULL,
  `description` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `affiliates`
--
ALTER TABLE `affiliates`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `affiliate_clicks`
--
ALTER TABLE `affiliate_clicks`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `bonus_codes`
--
ALTER TABLE `bonus_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `product_prices`
--
ALTER TABLE `product_prices`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `radiobots`
--
ALTER TABLE `radiobots`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `radiobot_hosts`
--
ALTER TABLE `radiobot_hosts`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `radiobot_webradio_list`
--
ALTER TABLE `radiobot_webradio_list`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`login`);

--
-- Indizes für die Tabelle `teamspeaks`
--
ALTER TABLE `teamspeaks`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `teamspeak_hosts`
--
ALTER TABLE `teamspeak_hosts`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indizes für die Tabelle `ticket_message`
--
ALTER TABLE `ticket_message`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `topup_actions`
--
ALTER TABLE `topup_actions`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `transfer_money`
--
ALTER TABLE `transfer_money`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indizes für die Tabelle `user_transactions`
--
ALTER TABLE `user_transactions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `affiliates`
--
ALTER TABLE `affiliates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `affiliate_clicks`
--
ALTER TABLE `affiliate_clicks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT für Tabelle `bonus_codes`
--
ALTER TABLE `bonus_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `news`
--
ALTER TABLE `news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT für Tabelle `product_prices`
--
ALTER TABLE `product_prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT für Tabelle `radiobots`
--
ALTER TABLE `radiobots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT für Tabelle `radiobot_hosts`
--
ALTER TABLE `radiobot_hosts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `radiobot_webradio_list`
--
ALTER TABLE `radiobot_webradio_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT für Tabelle `settings`
--
ALTER TABLE `settings`
  MODIFY `login` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `teamspeaks`
--
ALTER TABLE `teamspeaks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT für Tabelle `teamspeak_hosts`
--
ALTER TABLE `teamspeak_hosts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT für Tabelle `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT für Tabelle `ticket_message`
--
ALTER TABLE `ticket_message`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT für Tabelle `topup_actions`
--
ALTER TABLE `topup_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT für Tabelle `transfer_money`
--
ALTER TABLE `transfer_money`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT für Tabelle `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT für Tabelle `user_transactions`
--
ALTER TABLE `user_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
