-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 05. Nov 2021 um 17:50
-- Server-Version: 10.4.21-MariaDB
-- PHP-Version: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `ppoker`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `spiele`
--

CREATE TABLE `spiele` (
  `SpielID` int(11) NOT NULL,
  `Einrichtungsdatum` date NOT NULL,
  `Task` text NOT NULL,
  `Beschreibung` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `spielkarte`
--

CREATE TABLE `spielkarte` (
  `SpielID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Karte` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `Vorname` text NOT NULL,
  `Nachname` text NOT NULL,
  `Mail` text NOT NULL,
  `Passwort` text NOT NULL,
  `Registrierungsdatum` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `spiele`
--
ALTER TABLE `spiele`
  ADD PRIMARY KEY (`SpielID`);

--
-- Indizes für die Tabelle `spielkarte`
--
ALTER TABLE `spielkarte`
  ADD PRIMARY KEY (`SpielID`),
  ADD UNIQUE KEY `UserID` (`UserID`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
