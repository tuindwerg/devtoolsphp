-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Genereertijd: 03 mrt 2015 om 08:16
-- Serverversie: 5.6.13
-- PHP-versie: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `thsport`
--
CREATE DATABASE IF NOT EXISTS `thsport` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `thsport`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `beheerder`
--

CREATE TABLE IF NOT EXISTS `beheerder` (
  `gebruikersnaam` varchar(32) NOT NULL,
  `wachtwoord` varchar(255) NOT NULL,
  PRIMARY KEY (`gebruikersnaam`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden uitgevoerd voor tabel `beheerder`
--

INSERT INTO `beheerder` (`gebruikersnaam`, `wachtwoord`) VALUES
('admin', '827ccb0eea8a706c4c34a16891f84e7b');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `controlformulier`
--

CREATE TABLE IF NOT EXISTS `controlformulier` (
  `id` varchar(15) COLLATE latin1_general_ci NOT NULL,
  `voornaam` varchar(32) COLLATE latin1_general_ci NOT NULL,
  `achternaam` varchar(32) COLLATE latin1_general_ci NOT NULL,
  `email` varchar(32) COLLATE latin1_general_ci NOT NULL,
  `bericht` varchar(300) COLLATE latin1_general_ci NOT NULL,
  `control` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `evenement`
--

CREATE TABLE IF NOT EXISTS `evenement` (
  `datum` date NOT NULL,
  `toelichting_kort` varchar(45) NOT NULL,
  `toelichting_lang` varchar(500) DEFAULT NULL,
  `gesloten` tinyint(1) NOT NULL,
  PRIMARY KEY (`datum`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden uitgevoerd voor tabel `evenement`
--

INSERT INTO `evenement` (`datum`, `toelichting_kort`, `toelichting_lang`, `gesloten`) VALUES
('2014-12-05', 'Sinterklaas', NULL, 0),
('2014-12-25', 'Gesloten', 'Eerste kerstdag', 1),
('2014-12-26', 'Gesloten', 'Tweede kerstdag', 1),
('2014-12-31', 'Oudejaarsdag', NULL, 0),
('2015-01-01', 'Gesloten', 'Nieuwjaarsdag', 1),
('2015-02-14', 'Valentijnsdag', NULL, 0),
('2015-02-15', 'Carnaval', NULL, 0),
('2015-02-16', 'Carnaval', NULL, 0),
('2015-02-17', 'Carnaval', NULL, 0),
('2015-04-03', 'Goede vrijdag', NULL, 0),
('2015-04-05', 'Gesloten', 'Eerste paasdag', 1),
('2015-04-06', 'Gesloten', 'Tweede paasdag', 1),
('2015-04-27', 'Gesloten', 'Koningsdag', 1),
('2015-05-05', 'Gesloten', 'Bevrijdingsdag', 1),
('2015-05-14', 'Gesloten', 'Hemelvaartsdag', 1),
('2015-05-24', 'Gesloten', 'Eerste pinksterdag', 1),
('2015-05-25', 'Gesloten', 'Tweede pinksterdag', 1),
('2015-10-31', 'Halloween', NULL, 0),
('2015-11-11', 'Sint Maarten', 'Koeien hebben staarten', 0),
('2015-12-05', 'Sinterklaas', NULL, 0),
('2015-12-25', 'Gesloten', 'Eerste kerstdag', 1),
('2015-12-26', 'Gesloten', 'Tweede kerstdag', 1),
('2015-12-31', 'Oudejaarsdag', NULL, 0),
('2015-01-12', 'Speciale dag', 'Vandaag is een hele speciale dag, omdat we vandaag onze website opleveren! Groetjes', 0),
('2015-01-14', 'Nog een speciale dag', 'Vandaag presenteren we onze website! Nog meer groetjes.', 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `gesloten`
--

CREATE TABLE IF NOT EXISTS `gesloten` (
  `datum` date NOT NULL,
  `reden` varchar(255) NOT NULL,
  PRIMARY KEY (`datum`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden uitgevoerd voor tabel `gesloten`
--

INSERT INTO `gesloten` (`datum`, `reden`) VALUES
('2014-12-25', 'Eerste kerstdag'),
('2014-12-26', 'Tweede kerstdag'),
('2015-01-01', 'Nieuwjaarsdag'),
('2015-04-05', 'Eerste paasdag'),
('2015-04-06', 'Tweede paasdag'),
('2015-04-27', 'Koningsdag'),
('2015-05-05', 'Bevrijdingsdag'),
('2015-05-14', 'Hemelvaartsdag'),
('2015-05-24', 'Eerste pinksterdag'),
('2015-05-25', 'Tweede pinksterdag'),
('2015-12-25', 'Eerste kerstdag'),
('2015-12-26', 'Tweede kerstdag');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `groepsles`
--

CREATE TABLE IF NOT EXISTS `groepsles` (
  `groepsles` varchar(45) NOT NULL,
  `omschrijving` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`groepsles`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden uitgevoerd voor tabel `groepsles`
--

INSERT INTO `groepsles` (`groepsles`, `omschrijving`) VALUES
('Afvalgroep', 'Ongeveer 63% van de klanten in de sportschool heeft afvallen of afslanken als doelstelling. Deze doelstelling heeft vaak een cosmetische reden, terwijl de medische kant van overgewicht vaak wordt vergeten. Aandoeningen als diabetes, hart- en vaatziekten en een verhoogde bloeddruk steken eerder de kop op bij personen met overgewicht.'),
('Balance/Abr', 'Body Balance is een body & mind-groepsfitnessles. Deze les maakt gebruik van het traditionele yoga en tai chi. Oude culturen uit India en het verre oosten wijzen al eeuwen op de voordelen van een goede balans tussen lichaam en geest. Het is een alles omvattende workout die geest en lichaam in balans brengt. Onderdelen van Body Balance zijn gecontroleerd ademhalen, flexibiliteit, statische kracht, concentratie en meditatie.'),
('BBB', 'Deze les staat geheel in het teken van de drie grote spiergroepen: Buik, Billen en Benen en is geschikt voor zowel beginners als gevorderden. Er worden verschillende vormen van bewegen gebruikt, zoals spierversterkende oefeningen en conditionele oefeningen. De bewegingen worden gedaan op meeslepende muziek.'),
('Bekkeninst', 'Regelmatig fitness oefeningen doen biedt meer voordelen dan je in eerste instantie denkt. De meeste mensen geven gewichtsverlies als belangrijkste doel van hun fitness programma op, of ze willen er gespierder en fitter uitzien. Het is algemeen bekend dat fitness bijdraagt tot sterkere pezen en spieren. Tevens worden je botten steviger wanneer je regelmatig traint op kracht. Fitness doet echter veel meer je lichaam. Een kleine opsomming.'),
('Defence', 'Bij defence combineren we bepaalde bewegingsprincipes tot een effectief middel om de energie van de tegenstander in iedere aanvalssituatie te neutraliseren en in een tegenaanval hemzelf aan te wenden door toepassing van voor de situatie geschikte technieken.'),
('Explode', 'Regelmatig fitness oefeningen doen biedt meer voordelen dan je in eerste instantie denkt. De meeste mensen geven gewichtsverlies als belangrijkste doel van hun fitness programma op, of ze willen er gespierder en fitter uitzien. Het is algemeen bekend dat fitness bijdraagt tot sterkere pezen en spieren. Tevens worden je botten steviger wanneer je regelmatig traint op kracht. Fitness doet echter veel meer je lichaam. Een kleine opsomming.'),
('Pilates', 'Een groepsles pilates bestaat uit oefeningen voor stabiliteit en lichaamshouding waarbij de ademhaling en concentratie centraal staan. Een groepsles pilates is ideaal geschikt voor mensen die een training van het lichaam wil combineren met bewustwording. Pilates oefeningen zijn gericht op verbetering van lichaamshouding, -evenwicht en -controle. Verder worden ook de buik- en rugspieren getraind en leer je op een diepe en gezonde manier ademhalen.'),
('Showdance', 'Verschillende dansstijlen en soorten muziek komen voorbij om een intensieve workout te creeren waarbij u niet eens door heeft hoe hard u werkt. Zowel nieuwe hits als gezellige klassiekers komen voorbij om u bezweet, maar vooral met een glimlach de les door te laten komen.'),
('Spinning', 'Wilt u zich ook naar een gezonder leven trappen? Dan is spinning echt iets voor u! Spinning is een indoor-workout op de fiets. Op speciale fietsen wordt in een groep, onder leiding van een instructor, op muziek gefietst.\\r\\nSpinning is een heerlijke training die je zo zwaar kunt maken als je zelf wilt door aanpassing van de weerstand van je fiets. Dit Spinning programma komt uit Amerika en is wereldwijd een grote hit met name voor mensen die lekker willen transpireren zonder teveel na te denken.'),
('Zumba', 'Zumba combineert latin music en andere wereldmuziek samen met unieke en exotische danspasjes. Zumba lessen zijn geweldig voor de mind, body en soul. Kom en probeer dansen uit zoals de Salsa, Merengue, Flamenco, Hiphop, Cumbia, Samba, Calypso, Buikdans en veel meer. Zumba is een stoere aerobics/fitness interval training die wordt afgewisseld met snelle en langzame ritmes. Met Zumba verbruik je het maximale aan calorieën, verbrandt vet en brengt ook nog eens je lichaam mooi in vorm. In al onze zu');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `groepsles_activiteit`
--

CREATE TABLE IF NOT EXISTS `groepsles_activiteit` (
  `groepsles` varchar(45) NOT NULL,
  `week_dag` tinyint(1) NOT NULL COMMENT 'Maandag is 1, zondag is 7',
  `begintijd` time NOT NULL,
  `eindtijd` time DEFAULT NULL,
  PRIMARY KEY (`groepsles`,`week_dag`,`begintijd`),
  KEY `groepsles_2` (`groepsles`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden uitgevoerd voor tabel `groepsles_activiteit`
--

INSERT INTO `groepsles_activiteit` (`groepsles`, `week_dag`, `begintijd`, `eindtijd`) VALUES
('Afvalgroep', 6, '10:30:00', '11:30:00'),
('Balance/Abr', 4, '09:15:00', '10:15:00'),
('BBB', 1, '09:15:00', '10:00:00'),
('BBB', 2, '08:45:00', '09:15:00'),
('BBB', 2, '19:15:00', '20:15:00'),
('Bekkeninst.', 1, '20:00:00', NULL),
('Explode', 3, '19:45:00', '20:45:00'),
('Pilates', 3, '09:00:00', '10:00:00'),
('Pilates', 3, '18:45:00', '19:45:00'),
('Showdance', 5, '09:30:00', '10:30:00'),
('Zumba', 1, '10:00:00', '11:00:00'),
('Zumba', 2, '09:15:00', '10:15:00'),
('Balance/Abr', 6, '11:00:00', NULL),
('Defence', 5, '09:00:00', '10:00:00'),
('BBB', 4, '10:00:00', '21:00:00'),
('Defence', 4, '03:53:00', '06:45:00'),
('Afvalgroep', 5, '12:00:00', '13:00:00');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `openingstijden`
--

CREATE TABLE IF NOT EXISTS `openingstijden` (
  `week_dag` tinyint(1) NOT NULL COMMENT 'Maandag is 1, zondag is 7',
  `openingstijd` time DEFAULT NULL,
  `sluitingstijd` time DEFAULT NULL,
  PRIMARY KEY (`week_dag`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden uitgevoerd voor tabel `openingstijden`
--

INSERT INTO `openingstijden` (`week_dag`, `openingstijd`, `sluitingstijd`) VALUES
(1, '08:30:00', '22:00:00'),
(2, '10:00:00', '20:00:00'),
(3, '08:30:00', '22:00:00'),
(4, '08:30:00', '22:00:00'),
(5, '08:30:00', '19:00:00'),
(6, '10:00:00', '17:00:00'),
(7, NULL, NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `proefles`
--

CREATE TABLE IF NOT EXISTS `proefles` (
  `email` varchar(255) NOT NULL,
  `voornaam` varchar(35) NOT NULL,
  `achternaam` varchar(35) NOT NULL,
  `telefoonnr` int(10) NOT NULL,
  `activatiecode` varchar(15) NOT NULL,
  `ingestuurd` date NOT NULL,
  `proefles_datum` date DEFAULT NULL COMMENT 'Wanneer de proefles gegeven wordt',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `aantal_mails` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Gegevens worden uitgevoerd voor tabel `proefles`
--

INSERT INTO `proefles` (`email`, `voornaam`, `achternaam`, `telefoonnr`, `activatiecode`, `ingestuurd`, `proefles_datum`, `status`, `aantal_mails`) VALUES
('nepemail@mail.nl', 'Willem', 'De Boer', 612345678, 's4rbtk1xO6mAdHX', '2014-12-09', '2015-01-12', 2, 1),
('superfakemail@fake.nl', 'Bert', 'De Haan', 2034455888, 'faaFBgtGkg2AsXX', '2014-12-03', '2015-01-08', 2, 1),
('Fakefake@fake.nl', 'Britt', 'Jansen', 687459812, 'UGzLPRciw7PmqEA', '2014-12-12', '2015-01-22', 2, 2),
('shekib.hamidi@live.nl', 'Shekib', 'Hamidi', 1234567890, 'NQo452HEvKJaRDj', '2014-12-15', '2015-01-22', 2, 1),
('twanhuiskamp@hotmail.com', 'Twan', 'Huiskamp', 629547609, 'C8sxTgSAzRQEB4X', '2014-12-18', '2015-01-29', 2, 1),
('c3121423@trbvm.com', 'dc', 'sdf', 123, 'uIWtyfZw857qxli', '2015-01-06', '2015-02-18', 2, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `review`
--

CREATE TABLE IF NOT EXISTS `review` (
  `voornaam` varchar(35) COLLATE latin1_general_ci NOT NULL,
  `achternaam` varchar(35) COLLATE latin1_general_ci NOT NULL,
  `email` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `bericht` varchar(140) COLLATE latin1_general_ci NOT NULL,
  `waardering` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `activatiecode` varchar(15) COLLATE latin1_general_ci NOT NULL,
  `aantal_mails` tinyint(1) NOT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Gegevens worden uitgevoerd voor tabel `review`
--

INSERT INTO `review` (`voornaam`, `achternaam`, `email`, `bericht`, `waardering`, `status`, `activatiecode`, `aantal_mails`) VALUES
('Willem', 'de Vries', 'willemdevries@thsport.nl', 'T.H. Sport is een fantastische sportschool met een prachtige website!', 5, 2, 'NVT', 0),
('Jaap', 'Hendriksen', 'jaaphendriksen@thsport.nl', 'Ik heb drie jaar bij T.H. Sport gesport en er is altijd een hele leuke sfeer. Sinds ze de nieuwe website hebben komen er nog meer mensen!', 5, 2, 'BLA', 0),
('Bert', 'Hoek', 'bertie@kqlkslksfl.nl', 'Klantvriendelijkheid is in orde. Sportschool ziet er goed uit, maar de zalen zijn altijd een rommeltje.', 3, 2, 'asdfghjkl', 0),
('Henk', 'Timmer', 'henkiespenkie@henkieland.com', 'De sportschool ziet er goed uit!', 4, 2, 'maaktgeenflikke', 0),
('Test', 'test', 'c3099563@trbvm.com', 'alskjdlaskdjlaksd', 4, 0, '9NZMrvhxHAEijz6', 1),
('test', 'testagain', 'c3091921@trbvm.com', 'asdasasdfgasd', 4, 0, 'uM2tjfy0c5dI9vA', 1),
('', '', '', '', 0, 0, 'TdMmoqnpel4x7cR', 1),
('Test', 'test', 'lerrroi@gmail.com', 'rstsetsra', 3, 0, '6HUrsPFEiRCOkdM', 1),
('Leroy', 'de nieuwste', 'c3090076@trbvm.com', 'de nieuwste!', 4, 0, '5puU3XmYGv47R0q', 1),
('Test', 'test', 'l.helledoorn@gmail.com', 'test', 5, 0, '7MU4fROJQ9jqTkB', 2),
('henk', 'spenk', 'nnz60213@mciek.com', 'asdjkasd', 3, 0, '2GKRH3MQUoJVtlj', 1),
('1', '1', 'sample@email.tst', '1', 3, 0, '3e5WcxpkdUr4unD', 1),
('Leroy', 'De vries', 'c3107635@trbvm.com', 'alsjdlasjknkajsd', 4, 0, 'SQjqmvE0UKfchHk', 2);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
