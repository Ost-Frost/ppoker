-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 16. Dez 2021 um 09:54
-- Server-Version: 10.4.21-MariaDB
-- PHP-Version: 8.0.10

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
CREATE DATABASE IF NOT EXISTS `ppoker` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ppoker`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `epic`
--

CREATE TABLE `epic` (
  `EpicID` varchar(13) NOT NULL,
  `Name` text NOT NULL,
  `Beschreibung` text NOT NULL,
  `Aufwand` int(11) NOT NULL,
  `Einrichtungsdatum` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `epicspiel`
--

CREATE TABLE `epicspiel` (
  `EpicID` varchar(13) NOT NULL,
  `SpielID` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `epicuser`
--

CREATE TABLE `epicuser` (
  `EpicID` varchar(13) NOT NULL,
  `UserID` varchar(13) NOT NULL,
  `UserStatus` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `spiele`
--

CREATE TABLE `spiele` (
  `SpielID` varchar(13) NOT NULL,
  `Einrichtungsdatum` date NOT NULL,
  `Task` text NOT NULL,
  `Beschreibung` text NOT NULL,
  `Aufwand` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `spielkarte`
--

CREATE TABLE `spielkarte` (
  `SpielID` varchar(13) NOT NULL,
  `UserID` varchar(13) NOT NULL,
  `Karte` int(11) NOT NULL DEFAULT 0,
  `Akzeptiert` tinyint(1) DEFAULT 0,
  `UserStatus` tinyint(3) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `UserID` varchar(13) NOT NULL,
  `Username` text NOT NULL,
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
-- Indizes für die Tabelle `epic`
--
ALTER TABLE `epic`
  ADD PRIMARY KEY (`EpicID`);

--
-- Indizes für die Tabelle `epicspiel`
--
ALTER TABLE `epicspiel`
  ADD PRIMARY KEY (`EpicID`,`SpielID`) USING BTREE,
  ADD KEY `SpielID` (`SpielID`);

--
-- Indizes für die Tabelle `epicuser`
--
ALTER TABLE `epicuser`
  ADD PRIMARY KEY (`EpicID`,`UserID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indizes für die Tabelle `spiele`
--
ALTER TABLE `spiele`
  ADD PRIMARY KEY (`SpielID`);

--
-- Indizes für die Tabelle `spielkarte`
--
ALTER TABLE `spielkarte`
  ADD PRIMARY KEY (`SpielID`,`UserID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indizes für die Tabelle `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `epicspiel`
--
ALTER TABLE `epicspiel`
  ADD CONSTRAINT `epicspiel_ibfk_1` FOREIGN KEY (`EpicID`) REFERENCES `epic` (`EpicID`) ON DELETE CASCADE,
  ADD CONSTRAINT `epicspiel_ibfk_2` FOREIGN KEY (`SpielID`) REFERENCES `spiele` (`SpielID`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `epicuser`
--
ALTER TABLE `epicuser`
  ADD CONSTRAINT `epicuser_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE,
  ADD CONSTRAINT `epicuser_ibfk_2` FOREIGN KEY (`EpicID`) REFERENCES `epic` (`EpicID`) ON DELETE CASCADE;

--
-- Constraints der Tabelle `spielkarte`
--
ALTER TABLE `spielkarte`
  ADD CONSTRAINT `spielkarte_ibfk_1` FOREIGN KEY (`SpielID`) REFERENCES `spiele` (`SpielID`) ON DELETE CASCADE,
  ADD CONSTRAINT `spielkarte_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
