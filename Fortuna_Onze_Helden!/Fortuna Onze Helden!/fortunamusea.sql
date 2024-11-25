-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 25 nov 2024 om 11:49
-- Serverversie: 10.4.21-MariaDB
-- PHP-versie: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fortunamusea`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `clubs`
--

CREATE TABLE `clubs` (
  `id` int(255) NOT NULL,
  `name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `clubs`
--

INSERT INTO `clubs` (`id`, `name`) VALUES
(1, 'Fortuna Sittard'),
(2, 'Fortuna 54'),
(3, 'Sittardia');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `spelers`
--

CREATE TABLE `spelers` (
  `id` int(255) NOT NULL,
  `achternaam` varchar(60) NOT NULL,
  `voornaam` varchar(60) NOT NULL,
  `seizoenen` varchar(255) DEFAULT NULL,
  `gespeeldbij` int(255) NOT NULL DEFAULT 1,
  `afbeelding` varchar(255) DEFAULT NULL,
  `nationaliteit` varchar(60) DEFAULT NULL,
  `geboortedatum` date DEFAULT NULL,
  `geboorteplaats` varchar(255) DEFAULT NULL,
  `sterfdatum` date DEFAULT NULL,
  `positie` varchar(255) DEFAULT NULL,
  `debuut` varchar(255) DEFAULT NULL,
  `ookgespeeldvoor` varchar(255) DEFAULT NULL,
  `bijzonderheden` text DEFAULT NULL,
  `rugnummer` int(11) NOT NULL,
  `URL` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `spelers`
--

INSERT INTO `spelers` (`id`, `achternaam`, `voornaam`, `seizoenen`, `gespeeldbij`, `afbeelding`, `nationaliteit`, `geboortedatum`, `geboorteplaats`, `sterfdatum`, `positie`, `debuut`, `ookgespeeldvoor`, `bijzonderheden`, `rugnummer`, `URL`) VALUES
(1, 'Lemey', 'Diede', '', 1, 'f4567a76-ecf0-494e-857c-28ea32ed301c.png', 'Belgisch', '1996-10-07', '', NULL, 'Keeper', '16-09-2022 Ajax uit (4-0)', 'Anderlecht, AGSM Verona, Mozzanica, U.S. Sassuolo', 'Verkozen tot beste keepster van de SAW (Italiaanse league) in 2022.', 1, 'https://www.youtube.com/watch?v=nRVKApHCPCs'),
(2, 'van Koot', 'Moïsa', '', 1, '15905860-d843-411a-af7a-4a15c259fb39.png', 'Nederlands', '2001-06-09', 'Lichtenvoorde', NULL, 'Verdediger', '16-09-2022 Ajax uit (4-0)', 'PEC-Zwolle', 'Aanvoerder van PEC-Zwolle seizoen 2021-2022.', 2, 'https://www.youtube.com/watch?v=nRVKApHCPCs'),
(3, 'van Diemen', 'Samantha', '', 1, 'dcc6d277-f525-4339-b046-10c49e160e34.png', 'Nederlands', '2002-01-28', 'Leiden', NULL, 'Verdediger', '16-09-2022 Ajax uit (4-0)', 'Ajax, Feyenoord', 'Speelde 3 wedstrijden voor de Oranje leeuwinnen o.a. tegen Japan.', 4, 'https://www.youtube.com/watch?v=nRVKApHCPCs'),
(4, 'Erman', 'Kristina', '', 1, '2694c7bd-c62f-49d6-a5e4-c48e7a18b376.png', 'Sloveens', '1993-09-28', 'Celje', NULL, 'Verdediger', '16-09-2022 Ajax uit (4-0)', 'Torres Calcio, ASDCF Riviera di Romagna, FC Twente, PSV, Ferencváros', 'Kristina speelde o.a in Italie, Noorwegen en Ijsland en is meervoudig Sloveens international.', 5, 'https://www.youtube.com/watch?v=nRVKApHCPCs'),
(5, 'Knol', 'Anna', '', 1, '242e76a3-42af-4496-b09b-e3c501c9f39d.png', 'Nederlands', '2001-06-13', 'Wognum', NULL, 'Verdediger', '16-09-2022 Ajax uit (4-0)', 'VV Alkmaar, Empoli', 'Anna speelde bij VV Alkmaar in de spits, maar ontwikkelde zich in Italië als centrale verdediger.', 6, 'https://www.youtube.com/watch?v=nRVKApHCPCs'),
(6, 'Anstonsdóttir', 'Hildur', '', 1, 'bb596e83-56fb-4fee-9235-21188250ca94.png', 'Ijslands', '1995-09-18', 'Reykjavik', NULL, 'Middenvelder', '16-09-2022 Ajax uit (4-0)', 'Valur, Breiðablik\r\n', 'Hildur heeft verschillende Championsleague wedstrijden gespeeld o.a. tegen Real Madrid.', 7, 'https://www.youtube.com/watch?v=nRVKApHCPCs'),
(7, 'Foederer', 'Dana', '', 1, '4938a275-d8d7-4c5a-a791-b137e5a8010a.png', 'Nederlands', '2002-07-27', 'Veldhoven', NULL, 'Middenvelder', '25-09-2022 Feyenoord thuis (0-1)', 'PSV, sc Heerenveen\r\n', 'Dana werd player of the match bij de 3-0 zegen tegen de VS op het WK onder 20 in Costa Rica.', 8, 'https://www.youtube.com/watch?v=nRVKApHCPCs'),
(8, 'Ólafsdóttir Grós', 'Maria', '', 1, '95d2d835-51c8-4a5d-9fde-7591b7144167.png', 'Ijslands/Zweeds', '2003-02-05', 'Þjóðskrá Íslands', NULL, 'Aanvaller', '...', 'Thór/ KA, Celtic ', 'In 2021-2022 won María met Celtic de Scotish cup. María is jeugdinternational voor IJsland. Hier speelde ze o.a. tegen Engeland en Wales.', 9, 'https://www.youtube.com/watch?v=nRVKApHCPCs'),
(9, 'Muhtaj', 'farkhunda', '', 1, 'd533d99e-9339-4657-ae0a-f70f04e74495.png', 'Afgaans/Canadees', '1997-11-15', 'Islambad', NULL, 'Aanvaller', '', 'Vaughan Azzurri, Durham United FA, Fatih Vatan S.K.', 'Farkhunda is aanvoerster van het Afgaanse nationale elftal en zet zich veel in voor vrouwenrechten.', 10, 'https://www.youtube.com/watch?v=nRVKApHCPCs'),
(10, 'Tuin', 'Alieke', '', 1, '7c920d0b-1e48-4542-a190-696ed9c47546.png', 'Nederlands', '2001-01-24', 'Groningen', NULL, 'Verdediger', '16-09-2022 Ajax uit (4-0)', 'sc Heerenveen, VV Alkmaar', 'Eerste Fortunees die opgeroepen is voor de Oranje Leeuwinnen.', 11, 'https://www.youtube.com/watch?v=nRVKApHCPCs'),
(11, 'Huizenga', 'Hanna ', '', 1, '84a16659-c1f9-491d-a822-3877f66308c0.png', 'Nederlands', '2005-07-04', 'Groningen', NULL, 'Aanvaller', '16-09-2022 Ajax uit (4-0)', 'sc Heerenveen', 'Jongste Fortuna vrouw.', 12, 'https://www.youtube.com/watch?v=nRVKApHCPCs'),
(12, 'Hulst', 'Charlotte', '', 1, '0b72628b-d241-4078-b982-085c189b3648.png', 'Nederlands', '2003-04-22', 'Beverwijk', NULL, 'Aanvaller', '16-09-2022 Ajax uit (4-0)', 'VV Alkmaar', 'Voormalig international zaalvoetbal van het Nederlandsteam.', 13, 'https://www.youtube.com/watch?v=nRVKApHCPCs'),
(13, 'van Heeswijk', 'Amber', '', 1, 'a8b6dfa6-2701-4365-b091-b9ea4e4a0aeb.png', 'Nederlands', '2000-08-02', 'Venray', NULL, 'Middenvelder', '16-09-2022 Ajax uit (4-0)', 'Borussia Mönchengladbach\r\n', 'Werd in 2019 genomineerd voor sporttalent van het jaar in Venray.', 14, 'https://www.youtube.com/watch?v=nRVKApHCPCs'),
(14, 'Teulings', 'Jarne', '', 1, '7d1677c2-e6ba-4b15-9563-63113ef6a2e9.png', 'Belgisch', '2002-01-11', 'Leuven (B)', NULL, 'Aanvaller', '16-09-2022 Ajax uit (4-0)', 'FC Twente, KRC Genk, RSC Anderlecht, Oud-Heverlee Leuven\r\n', 'Won samen met Tessa Wullaert de Belgische beker en werd kampioen van de Belgische league.', 15, 'https://www.youtube.com/watch?v=nRVKApHCPCs'),
(15, 'Iliano', 'Isabella', '', 1, 'dc1e0b1c-1a10-4c1d-b150-e515ced38afb.png', 'Belgisch', '1997-03-02', 'Gent (B)', NULL, 'Verdediger', '11-12-2022 FC Twente uit (6-0)', 'Gent, Club Brugge', 'Maakt na een langdurige knie blessure (ruim een jaar) eindelijk haar eerste minuten voor de Fortuna vrouwen.', 16, 'https://www.youtube.com/watch?v=nRVKApHCPCs'),
(16, 'Wolters', 'Caroliena', '', 1, '599741c6-efb4-4c2c-9bea-cec99cb8f176.png', 'Nederlands', '1996-07-30', 'Maastricht', NULL, 'Aanvaller', '16-09-2022 Ajax uit (4-0)', 'Florida Gulf Coast Dutch Lions FC, Alemannia Aachen, KRC Genk, Achilles ’29, Dayton Dutch Lions FC, Standard de Liège\r\n', 'Scoorde voor standard Luik een doelpunt in de Champions League.', 17, 'https://www.youtube.com/watch?v=nRVKApHCPCs'),
(17, 'Dinkla', 'Claire', '', 1, 'b586bf43-7975-48ef-9d2e-ca4456eeb88d.png', 'Nederlands', '2002-06-22', 'Alkmaar', NULL, 'keeper', '...', 'Ajax, sc Heerenveen', 'Won in 2020-2021 de Eredivisie cup met Ajax.', 18, 'https://www.youtube.com/watch?v=nRVKApHCPCs'),
(18, 'Wullaert', 'Tessa', '', 1, '15f1a272-642f-4419-8569-dbb2ca9c355f.png', 'Belgisch', '1993-03-19', 'Tielt (B)', NULL, 'Aanvaller', '16-09-2022 Ajax uit (4-0)', 'Zulte VV, RSC Anderlecht, Standard Luik, VFL Wolfsburg, Manchester City', 'Speelde 2x de championaleague finale met Wolfsburg. Werd 2x kampioen van Duitsland en won 3x de DFB-POKAL met Wolfsburg. Won de FA Cup met Manchester City. En won meerdere bekers in België met Anderlecht.  en Standard Luik. Wullaert is ook topschutter aller tijde van België. \r\n', 19, 'https://www.youtube.com/watch?v=nRVKApHCPCs'),
(19, 'Renzen', 'Britt', '', 1, '4e46c430-4992-4964-8ad7-bae57047481a.png', 'Nederlands', '2002-05-14', 'Maastricht', NULL, 'Keeper', '', 'Standard Luik\r\n', 'Renzen is vanuit de amateurs terug gekomen in het profvoetbal bij Fortuna Sittard.\r\n', 0, 'https://www.youtube.com/watch?v=nRVKApHCPCs'),
(20, 'Delacauw', 'Féli', '', 1, '476112c6-8a02-4656-8790-055a3e22f77e.png', 'Belgisch', '2002-04-04', 'Oostende', NULL, 'Middenvelder', '16-09-2022 Ajax uit (4-0)', 'Gent', 'Won 2x de Belgische beker in de jeugd van Gent. Delacauw speelde het EK in 2022 met België. ', 21, 'https://www.youtube.com/watch?v=nRVKApHCPCs');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'Fortuna', '$2y$10$IlVRCRj3uZlhDPCe27MyQegVlcym2i1IDjWki.a5EK.gMHk2tXW4y');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `clubs`
--
ALTER TABLE `clubs`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `spelers`
--
ALTER TABLE `spelers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `gespeeldbij` (`gespeeldbij`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `clubs`
--
ALTER TABLE `clubs`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT voor een tabel `spelers`
--
ALTER TABLE `spelers`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `spelers`
--
ALTER TABLE `spelers`
  ADD CONSTRAINT `spelers_ibfk_1` FOREIGN KEY (`gespeeldbij`) REFERENCES `clubs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
