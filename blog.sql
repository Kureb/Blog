-- phpMyAdmin SQL Dump
-- version 2.8.1
-- http://www.phpmyadmin.net
-- 
-- Serveur: localhost
-- GÃ©nÃ©rÃ© le : Jeudi 30 Novembre 2006 Ã  15:54
-- Version du serveur: 5.0.21
-- Version de PHP: 5.1.4
-- 
-- Base de donnÃ©es: `Toy_blog`
-- 

-- --------------------------------------------------------

-- 
-- Structure de la table `billets`
-- 

CREATE TABLE `billets` (
  `id` int(10) NOT NULL auto_increment,
  `titre` varchar(64) default NULL,
  `body` text,
  `cat_id` int(11) default '1',
  `date` datetime default NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- 
-- Contenu de la table `billets`
-- 

INSERT INTO `billets` (`id`, `titre`, `body`, `cat_id`, `date`) VALUES (1, 'go sluc, go', 'tout est dans le titre', 1, '2006-11-30 11:22:27'),
(2, 'Concert : nolwenn live', 'c''est d''la balle, Ca vaut bien Mick Jagger et Iggy Stooges reunis.\r\nAngus Young doit l''ecouter en boucle...', 3, '2006-11-30 11:29:50');

-- --------------------------------------------------------

-- 
-- Structure de la table `categorie`
-- 

CREATE TABLE `categorie` (
  `id` int(10) NOT NULL auto_increment,
  `titre` varchar(64) NOT NULL,
  `description` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- 
-- Contenu de la table `categorie`
-- 

INSERT INTO `categorie` (`id`, `titre`, `description`) VALUES (1, 'sport', 'tout sur le sport en general'),
(2, 'cinema', 'tout sur le cinema'),
(3, 'music', 'toute la music que j''aaiiiimeuh, elle vient de la, elle vient du bluuuuuuzee'),
(4, 'tele', 'tout sur les programmes tele, les emissions, les series, et vos stars preferes');
