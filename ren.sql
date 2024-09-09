-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 30 mai 2023 à 18:53
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ren`
--

-- --------------------------------------------------------

--
-- Structure de la table `entities`
--

DROP TABLE IF EXISTS `entities`;
CREATE TABLE IF NOT EXISTS `entities` (
  `number` int NOT NULL AUTO_INCREMENT,
  `numbertext` int NOT NULL,
  `entity` varchar(250) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `label` varchar(30) NOT NULL,
  PRIMARY KEY (`number`),
  KEY `numbertext_fk` (`numbertext`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `entities`
--

INSERT INTO `entities` (`number`, `numbertext`, `entity`, `label`) VALUES
(1, 0, 'Popocatepetl', 'PRODUCT'),
(2, 0, 'Mexique', 'ORG'),
(3, 0, 'Paris', 'LOC'),
(4, 0, 'la France', 'LOC'),
(5, 0, 'XIIe', 'MISC'),
(6, 0, 'internationales134', 'LOC'),
(7, 0, 'Ville Lumière', 'LOC'),
(8, 0, 'Seine5', 'MISC'),
(9, 0, 'Parisiens5', 'MISC');

-- --------------------------------------------------------

--
-- Structure de la table `texts`
--

DROP TABLE IF EXISTS `texts`;
CREATE TABLE IF NOT EXISTS `texts` (
  `number` int NOT NULL AUTO_INCREMENT,
  `domaine` varchar(50) NOT NULL,
  `theme` varchar(100) NOT NULL,
  `language` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `iduser` int NOT NULL,
  PRIMARY KEY (`number`),
  KEY `iduser_fk` (`iduser`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `profession` varchar(250) NOT NULL,
  `password` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='table containing information about users';

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `profession`, `password`) VALUES
(1, 'Luca', 'Rosset', 'luca.rosset@mail.com', 'Data analist', '1234luca'),
(8, 'Robert', 'Shumann', 'robert.shumann@mail.com', 'Data analist', '123'),
(7, 'Omar', 'Ly', 'omar.ly@mail.com', 'Data scientist', '12345'),
(6, 'Sophie', 'Marceau', 'sophie.marceau@mail.com', 'Data scientist', '123'),
(9, 'Pierre', 'Omar', 'pierre.omar@mail.com', 'Data scientist', '123'),
(10, 'Leo', 'Machin', 'leo.machin@mail.com', 'Data analist', '12345');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
