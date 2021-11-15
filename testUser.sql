-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 15. Nov 2021 um 21:07
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

--
-- Daten für Tabelle `user`
--

INSERT INTO `user` (`UserID`, `Username`, `Vorname`, `Nachname`, `Mail`, `Passwort`, `Registrierungsdatum`) VALUES
('618a8486cf3', 'felix69', 'felix', 'schmessaaer', 'felix@felix.felix', '$2y$10$S4EnXcJfV6xYPevAjpZNv.u/EbM/U0jTkqaYtPibdXTynI//PPJ9G', '2021-11-09'),
('618a86aa0f2', 'PetersPapa', 'peter', 'papa', '123@123', '$2y$10$mg8B2hdgfnJV8X7ZBdmFAeC.SV.VPMF9Cm4C86RI85Y5oMbkDYHNu', '2021-11-09'),
('618a86c33cd', 'petersPapagei', 'peter', 'papagei', '123@124', '$2y$10$1qkK3for/qMGXtshnFx7juTZAVTMDE/aMB55wbDuVCx74mwUiozva', '2021-11-09'),
('618a86db956', 'petersProstituierte', 'Peter', 'Prostituierte', '123@125', '$2y$10$4IpxlE6hUXMMeEOFBs.W3uggzhJdOCOOVC8RnSAKbZTtvububRQc6', '2021-11-09'),
('618a86fbd95', 'PetersPenthouse', 'Peter', 'Penthouse', '123@12', '$2y$10$dSOk8yfy/oGCIQKRXOc8oOlWA.Xt5aGyk35wwQzNjJz4FwQS.pyZ2', '2021-11-09'),
('618c4c614f4', '&amp;&lt;&gt;&lt;as66666666666666', 'asdsssssssssssssssssssssssss', 'asdasd', 'abc@abc.de', '$2y$10$5LyTrExyuAei3H4ASQkcYet53ZOQcVDRxp6VgCuLWTj7suSLYCcjy', '2021-11-10'),
('618c521e7a5', 'JuanCarliBoy', 'Juan', 'Carli', 'Juan@Carlos.de', '$2y$10$/iy.o7GJlKCsZss4GtIRbuDftXhYRLXf.jDWbhA00VkRSrb2FiMnW', '2021-11-11'),
('618d1fdf43a', '$&gt;.&lt;$%', 'Ferdinand', 'Reimers', 'avery.powell@microtech.com', '$2y$10$DzAJe66H7IVWCmW2Q0d0U.ICf4VwkhYX5owOdFFziB/4WFFd6kkjC', '2021-11-11'),
('618d207443a', '&amp;1234&amp;', 'test', 'test', 'test@test.de', '$2y$10$51wMNYedjK9NcuConcESGuxtt/v7HGstkw30KMjIp8e3mOSQSIaDW', '2021-11-11'),
('618d208f194', '%___%', 'test', 'test', 'test@test.com', '$2y$10$QUEI3vqWkCV9bu5Oy6MCneuYcqBLdEubSzYNMO4cLpbOmJZA5Dohq', '2021-11-11'),
('6192315c317', '&gt;.&lt;', 'test', 'test', 'test@test.eu', '$2y$10$9PkejgDb32s8NwjZm8RJk.8qLXwG.Si5bNLU.5kQmBHmNfCXqZ7HW', '2021-11-15'),
('619245ae5d4', 'felix70', 'test', 'Fertig', 'freddie.burke@microtech.com', '$2y$10$C0eALWuWOgMBRrz0PJhxgeb6QssHsneR4f3KCxM8HHbHeEjcYIrmS', '2021-11-15'),
('61924692830', 'felix71', 'test', 'Fertig', 'freddie.burke@microtech.de', '$2y$10$dmnss/Pe2.Y7qYi1LIGsUuwbdPw28zMLi6V8PWgKguQcM6Glum6/a', '2021-11-15'),
('6192475233d', '&amp;1234', 'test', 'test', 'constance.robinson@microtech.com', '$2y$10$bSKDY9JQVXIH9AqOsbIDUe9qDev4W7RAXZFoB4TQcy89EzJBN8sj2', '2021-11-15'),
('61924b494ca', 'felix420', 'test', 'test', 'ferdinand@fertig.com', '$2y$10$GB/opyUAl2EMflcs/3/n5eVfESwpRV9UKTNwVtfXcw/pM.WFh4XHG', '2021-11-15');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
