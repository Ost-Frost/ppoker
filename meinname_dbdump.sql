-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 08. Nov 2021 um 11:09
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
CREATE DATABASE IF NOT EXISTS `ppoker` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ppoker`;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `epic`
--

CREATE TABLE `epic` (
  `EpicID` varchar(500) NOT NULL,
  `Name` text NOT NULL,
  `Beschreibung` text NOT NULL,
  `Aufwand` int(11) NOT NULL,
  `Einrichtungsdatum` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `epic`
--

INSERT INTO `epic` (`EpicID`, `Name`, `Beschreibung`, `Aufwand`, `Einrichtungsdatum`) VALUES
('35', '123', '456', 45, '2021-11-09');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `epicspiel`
--

CREATE TABLE `epicspiel` (
  `EpicID` varchar(500) NOT NULL,
  `SpielID` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `spiele`
--

CREATE TABLE `spiele` (
  `SpielID` varchar(11) NOT NULL,
  `Einrichtungsdatum` date NOT NULL,
  `Task` text NOT NULL,
  `Beschreibung` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `spiele`
--

INSERT INTO `spiele` (`SpielID`, `Einrichtungsdatum`, `Task`, `Beschreibung`) VALUES
('111', '2021-11-01', 'ertz', 'qwertz');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `spielkarte`
--

CREATE TABLE `spielkarte` (
  `SpielID` varchar(11) NOT NULL,
  `UserID` varchar(11) NOT NULL,
  `Karte` int(11) NOT NULL DEFAULT 0,
  `Akzeptiert` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `user`
--

CREATE TABLE `user` (
  `UserID` varchar(11) NOT NULL,
  `Username` text NOT NULL,
  `Vorname` text NOT NULL,
  `Nachname` text NOT NULL,
  `Mail` text NOT NULL,
  `Passwort` text NOT NULL,
  `Registrierungsdatum` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`UserID`, `Username`, `Vorname`, `Nachname`, `Mail`, `Passwort`, `Registrierungsdatum`) VALUES
('123', 'PetersPopel69', 'Peter', 'Popelkopf', 'Peter.Popel@gmail.com', '123', '2021-11-01'),
('3456', 'tttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttttt', 'Ole \"fucking\"', 'Reimers', 'ole.reimers@fujitsu.com', 'ole123', '2021-11-07'),
('6188125006f', 'PeterPenis420', 'Peter', 'Penis', 'peter.penis@steif.com', '$2y$10$bECr4eHy6MqXxZxkw.plUeZoSeOoR.JWLklqfIxEvg4Agm0TEf/Ea', '2021-11-07');

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
  ADD PRIMARY KEY (`EpicID`),
  ADD UNIQUE KEY `EpicID` (`EpicID`),
  ADD UNIQUE KEY `SpielID` (`SpielID`);

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

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `epicspiel`
--
ALTER TABLE `epicspiel`
  ADD CONSTRAINT `epicspiel_ibfk_1` FOREIGN KEY (`EpicID`) REFERENCES `epic` (`EpicID`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `epicspiel_ibfk_2` FOREIGN KEY (`SpielID`) REFERENCES `spiele` (`SpielID`) ON DELETE SET NULL;

--
-- Constraints der Tabelle `spielkarte`
--
ALTER TABLE `spielkarte`
  ADD CONSTRAINT `spielkarte_ibfk_4` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`),
  ADD CONSTRAINT `spielkarte_ibfk_5` FOREIGN KEY (`SpielID`) REFERENCES `spiele` (`SpielID`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
