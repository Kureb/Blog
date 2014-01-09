-- phpMyAdmin SQL Dump
-- version 4.0.6
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 09, 2014 at 08:22 AM
-- Server version: 5.5.33
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `Billets`
--

CREATE TABLE `Billets` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `titre` varchar(64) DEFAULT NULL,
  `body` text,
  `cat_id` int(11) DEFAULT '1',
  `date` datetime DEFAULT NULL,
  `auteur` varchar(20) DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `Billets`
--

INSERT INTO `Billets` (`id`, `titre`, `body`, `cat_id`, `date`, `auteur`) VALUES
(1, 'PACES', 'On entend parler que de ça ces derniers jours, PACES par-ci PACES par-là.\r\n\r\nMoi aussi j''ai passé des exams sur 2 jours, et j''en ai pas fait tout un foin de mon brevet !', 1, '2013-12-19 15:47:36', 'Alexandre'),
(2, 'Concert : nolwenn live', 'c''est d''la balle, Ca vaut bien Mick Jagger et Iggy Stooges reunis.\r\nAngus Young doit l''ecouter en boucle...', 3, '2006-11-30 11:29:50', 'Vincent'),
(3, 'Billet test', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam at augue velit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nunc consectetur nunc vel tortor interdum tempor. Suspendisse porttitor sem vitae blandit tincidunt. Suspendisse porttitor sollicitudin velit non convallis. Vivamus semper, erat quis scelerisque varius, lacus ligula dapibus lacus, in vestibulum mauris dui quis orci. Aliquam in nunc eu magna elementum vulputate. Nullam congue urna at malesuada fringilla. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam lobortis sodales augue, mattis porttitor justo hendrerit sed.', 1, '2013-12-18 15:46:46', 'Alexandre'),
(4, 'Projet de web', 'Pour le projet de web de S3 (le premier S3, des 3), il nous a été demandé de faire un blog. Dans un blog il y a des articles. Chaque article contient un titre, et un contenu. Ainsi qu''une date. Dans l''affichage de base on ne doit pas voir tout le contenu d''un article mais seulement les xx premiers caractères. Devons-nous recharger une page avec un article seul lorsque l''on veut lire la suite ou vaut mieux faire une petite animation pour dérouler l''article ?\r\nTant de questions sans réponse !', 1, '2013-12-19 15:37:42', 'Alexandre'),
(5, 'Lorem ipsum', 'Je modifie le body wesh Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer adipiscing metus a lectus porta, vitae porta sapien consequat. Cras vitae mauris id nulla lobortis venenatis in vitae tellus. Integer et nisl sit amet ipsum viverra accumsan. Aenean ac enim tincidunt, scelerisque sapien at, pellentesque enim. Donec sit amet condimentum diam. Ut eget lectus at augue commodo adipiscing. Vestibulum sodales mattis lacus, eu dapibus nisi. Nunc porta ultrices pellentesque. Nam et ipsum placerat, convallis nisl quis, rhoncus arcu. Duis pellentesque ut tellus in facilisis. Nunc vel dapibus libero. Vestibulum eu hendrerit nunc. Vestibulum congue hendrerit nibh id laoreet. Duis diam erat, ullamcorper mattis interdum sed, tempus a nulla. Ut magna ipsum, ornare pretium feugiat id, egestas sed massa.\n\nSed vel mauris vitae velit elementum iaculis in quis turpis. Quisque tempor lacus est, eget mollis enim egestas blandit. Nunc a dui vitae mi blandit cursus ac a ante. Aliquam erat volutpat. Proin a feugiat odio, eu rutrum arcu. In eu aliquam mi, sed tempor nisl. In iaculis urna id condimentum facilisis. Praesent sed justo sed eros rhoncus tempor. Quisque pharetra mi nec orci porttitor, quis lobortis nunc faucibus. Nam ac sem dignissim, egestas augue ut, fermentum elit. Nam pulvinar, augue ac volutpat aliquet, lacus urna tristique nisl, vel porta metus magna id enim. Curabitur arcu mauris, mollis at pretium et, lacinia ac neque. Cras elementum arcu ac gravida dignissim. Suspendisse cursus urna in sem ornare, vitae volutpat augue porta. Praesent commodo purus et nunc feugiat mattis.\n\nDuis eget hendrerit tellus, in tincidunt neque. Aenean nec lacus dictum, sodales libero sed, condimentum turpis. In sagittis cursus nibh. Nunc velit est, sagittis sed accumsan eu, pellentesque eget mauris. Nunc a lacus adipiscing, laoreet mauris id, convallis nulla. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque hendrerit enim neque, ac semper mauris congue in. Morbi sed cursus velit.', 1, '2013-12-18 15:50:04', 'Latino88'),
(6, 'Expression Communication', 'Donc demain on a un partiel sisi posey.\r\nPierre est venu prendre mes cours parce qu''avec son prof il a rien fait à part branlé le chien.\r\nÇa va que c''est une base de données locale parce que j''écris vraiment n''importe quoi.\r\nMais du coup j''avais que 5 articles et m''en fallait un 6ième pour tester ma dernier méthode en php de la mort qui tue. ', 3, '2013-12-19 21:41:06', 'Vincent'),
(42, 'TEst', 'fbbfndrfgv\r\ndvq, q;,sd\r\nqs,vnkdsvbq vs', 3, '2014-01-08 18:54:00', 'Admin'),
(41, 'Nouvel Article lol', 'Ca marche une fois sur mille je ne comprends pas pourquoi', 1, '2014-01-08 18:49:17', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `titre` varchar(64) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65 ;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`id`, `titre`, `description`) VALUES
(1, 'sport', 'tout sur le sport en general'),
(2, 'cinema', 'tout sur le cinema'),
(3, 'music', 'toute la music que j''aaiiiimeuh, elle vient de la, elle vient du bluuuuuuzee'),
(4, 'tele', 'tout sur les programmes tele, les emissions, les series, et vos stars preferes'),
(5, 'categorie test', 'description de la categorie de test');

-- --------------------------------------------------------

--
-- Table structure for table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `userid` int(10) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `mail` varchar(100) DEFAULT NULL,
  `chmod` int(1) DEFAULT NULL,
  UNIQUE KEY `userid` (`userid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `utilisateurs`
--

INSERT INTO `utilisateurs` (`userid`, `login`, `password`, `mail`, `chmod`) VALUES
(18, 'Beruk', '6e6b6ae0b07872f6f3f799cad082882317c1714f', 'alexandre.daussy@gmail.com', 0),
(17, 'Kureb', 'e52b604cb436539cb710e33d9c496ccad05eeb83', 'alex@lol.fr', 0),
(16, 'Test', 'a94a8fe5ccb19ba61c4c0873d391e987982fbbd3', 'admin@gmail.com', 0),
(15, 'Admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin@gmail.com', 1),
(14, 'Utilisateur', 'd3961aa89e29d15cfb52600dc0bd51548fc538a4', 'utilisateur@gmail.com', 0);
