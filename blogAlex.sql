-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Lun 23 Décembre 2013 à 10:59
-- Version du serveur: 5.6.12-log
-- Version de PHP: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `blog`
--
CREATE DATABASE IF NOT EXISTS `blog` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `blog`;

-- --------------------------------------------------------

--
-- Structure de la table `billets`
--

CREATE TABLE IF NOT EXISTS `billets` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `titre` varchar(64) DEFAULT NULL,
  `body` text,
  `cat_id` int(11) DEFAULT '1',
  `date` datetime DEFAULT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Contenu de la table `billets`
--

INSERT INTO `billets` (`id`, `titre`, `body`, `cat_id`, `date`) VALUES
(1, 'PACES', 'On entend parler que de ça ces derniers jours, PACES par-ci PACES par-là.\r\n\r\nMoi aussi j''ai passé des exams sur 2 jours, et j''en ai pas fait tout un foin de mon brevet !', 1, '2013-12-19 15:47:36'),
(2, 'Concert : nolwenn live', 'c''est d''la balle, Ca vaut bien Mick Jagger et Iggy Stooges reunis.\r\nAngus Young doit l''ecouter en boucle...', 3, '2006-11-30 11:29:50'),
(3, 'Billet test', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam at augue velit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nunc consectetur nunc vel tortor interdum tempor. Suspendisse porttitor sem vitae blandit tincidunt. Suspendisse porttitor sollicitudin velit non convallis. Vivamus semper, erat quis scelerisque varius, lacus ligula dapibus lacus, in vestibulum mauris dui quis orci. Aliquam in nunc eu magna elementum vulputate. Nullam congue urna at malesuada fringilla. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam lobortis sodales augue, mattis porttitor justo hendrerit sed.', 1, '2013-12-18 15:46:46'),
(4, 'Projet de web', 'Pour le projet de web de S3 (le premier S3, des 3), il nous a été demandé de faire un blog. Dans un blog il y a des articles. Chaque article contient un titre, et un contenu. Ainsi qu''une date. Dans l''affichage de base on ne doit pas voir tout le contenu d''un article mais seulement les xx premiers caractères. Devons-nous recharger une page avec un article seul lorsque l''on veut lire la suite ou vaut mieux faire une petite animation pour dérouler l''article ?\r\nTant de questions sans réponse !', 1, '2013-12-19 15:37:42'),
(5, 'Lorem ipsum', 'Je modifie le body wesh Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer adipiscing metus a lectus porta, vitae porta sapien consequat. Cras vitae mauris id nulla lobortis venenatis in vitae tellus. Integer et nisl sit amet ipsum viverra accumsan. Aenean ac enim tincidunt, scelerisque sapien at, pellentesque enim. Donec sit amet condimentum diam. Ut eget lectus at augue commodo adipiscing. Vestibulum sodales mattis lacus, eu dapibus nisi. Nunc porta ultrices pellentesque. Nam et ipsum placerat, convallis nisl quis, rhoncus arcu. Duis pellentesque ut tellus in facilisis. Nunc vel dapibus libero. Vestibulum eu hendrerit nunc. Vestibulum congue hendrerit nibh id laoreet. Duis diam erat, ullamcorper mattis interdum sed, tempus a nulla. Ut magna ipsum, ornare pretium feugiat id, egestas sed massa.\n\nSed vel mauris vitae velit elementum iaculis in quis turpis. Quisque tempor lacus est, eget mollis enim egestas blandit. Nunc a dui vitae mi blandit cursus ac a ante. Aliquam erat volutpat. Proin a feugiat odio, eu rutrum arcu. In eu aliquam mi, sed tempor nisl. In iaculis urna id condimentum facilisis. Praesent sed justo sed eros rhoncus tempor. Quisque pharetra mi nec orci porttitor, quis lobortis nunc faucibus. Nam ac sem dignissim, egestas augue ut, fermentum elit. Nam pulvinar, augue ac volutpat aliquet, lacus urna tristique nisl, vel porta metus magna id enim. Curabitur arcu mauris, mollis at pretium et, lacinia ac neque. Cras elementum arcu ac gravida dignissim. Suspendisse cursus urna in sem ornare, vitae volutpat augue porta. Praesent commodo purus et nunc feugiat mattis.\n\nDuis eget hendrerit tellus, in tincidunt neque. Aenean nec lacus dictum, sodales libero sed, condimentum turpis. In sagittis cursus nibh. Nunc velit est, sagittis sed accumsan eu, pellentesque eget mauris. Nunc a lacus adipiscing, laoreet mauris id, convallis nulla. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Pellentesque hendrerit enim neque, ac semper mauris congue in. Morbi sed cursus velit.', 1, '2013-12-18 15:50:04'),
(6, 'Expression Communication', 'Donc demain on a un partiel sisi posey.\r\nPierre est venu prendre mes cours parce qu''avec son prof il a rien fait à part branlé le chien.\r\nÇa va que c''est une base de données locale parce que j''écris vraiment n''importe quoi.\r\nMais du coup j''avais que 5 articles et m''en fallait un 6ième pour tester ma dernier méthode en php de la mort qui tue. ', 3, '2013-12-19 21:41:06');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `titre` varchar(64) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65 ;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`id`, `titre`, `description`) VALUES
(1, 'sport', 'tout sur le sport en general'),
(2, 'cinema', 'tout sur le cinema'),
(3, 'music', 'toute la music que j''aaiiiimeuh, elle vient de la, elle vient du bluuuuuuzee'),
(4, 'tele', 'tout sur les programmes tele, les emissions, les series, et vos stars preferes'),
(5, 'categorie test', 'description de la categorie de test');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
