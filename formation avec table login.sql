-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 19 jan. 2023 à 10:22
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
-- Base de données : `formation`
--

-- --------------------------------------------------------

--
-- Structure de la table `appartenir_cat`
--

DROP TABLE IF EXISTS `appartenir_cat`;
CREATE TABLE IF NOT EXISTS `appartenir_cat` (
  `id_categories` int NOT NULL,
  `id_formation` int NOT NULL,
  PRIMARY KEY (`id_categories`,`id_formation`),
  KEY `appartenir_cat_formation0_FK` (`id_formation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `avoir_media`
--

DROP TABLE IF EXISTS `avoir_media`;
CREATE TABLE IF NOT EXISTS `avoir_media` (
  `id_formation` int NOT NULL,
  `id_media` int NOT NULL,
  PRIMARY KEY (`id_formation`,`id_media`),
  KEY `avoir_media_media0_FK` (`id_media`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `avoir_ref`
--

DROP TABLE IF EXISTS `avoir_ref`;
CREATE TABLE IF NOT EXISTS `avoir_ref` (
  `id_competence` int NOT NULL,
  `id_reference` int NOT NULL,
  PRIMARY KEY (`id_competence`,`id_reference`),
  KEY `avoir_ref_reference0_FK` (`id_reference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id_categories` int NOT NULL AUTO_INCREMENT,
  `titre_categories` varchar(255) NOT NULL,
  PRIMARY KEY (`id_categories`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `competence`
--

DROP TABLE IF EXISTS `competence`;
CREATE TABLE IF NOT EXISTS `competence` (
  `id_competence` int NOT NULL AUTO_INCREMENT,
  `titre_competence` varchar(255) NOT NULL,
  `desc_competence` varchar(255) NOT NULL,
  PRIMARY KEY (`id_competence`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `effectuer_type_formation`
--

DROP TABLE IF EXISTS `effectuer_type_formation`;
CREATE TABLE IF NOT EXISTS `effectuer_type_formation` (
  `id_type_formation` int NOT NULL,
  `id_formation` int NOT NULL,
  PRIMARY KEY (`id_type_formation`,`id_formation`),
  KEY `effectuer_type_formation_formation0_FK` (`id_formation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `formation`
--

DROP TABLE IF EXISTS `formation`;
CREATE TABLE IF NOT EXISTS `formation` (
  `id_formation` int NOT NULL AUTO_INCREMENT,
  `titre_formation` varchar(50) NOT NULL,
  `description_formation` varchar(255) NOT NULL,
  `code_formation` varchar(50) NOT NULL,
  `condition_formation` varchar(255) NOT NULL,
  `metier_viser_formation` varchar(255) NOT NULL,
  `frais_scolarite_formation` varchar(255) NOT NULL,
  `lieu_formation` varchar(255) NOT NULL,
  `duree_formation` varchar(255) NOT NULL,
  `id_niveau` int NOT NULL,
  PRIMARY KEY (`id_formation`),
  KEY `formation_niveau_FK` (`id_niveau`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `logindashboard`
--

DROP TABLE IF EXISTS `logindashboard`;
CREATE TABLE IF NOT EXISTS `logindashboard` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `logindashboard`
--

INSERT INTO `logindashboard` (`id`, `username`, `password`) VALUES
(1, 'hassan', '$2y$10$XVlvAgoftWRGdeB0mWVDPe3hiGZcUrQyiB5aJMfr4mhoGO1E5yVbm');

-- --------------------------------------------------------

--
-- Structure de la table `media`
--

DROP TABLE IF EXISTS `media`;
CREATE TABLE IF NOT EXISTS `media` (
  `id_media` int NOT NULL AUTO_INCREMENT,
  `nom_media` varchar(50) NOT NULL,
  `url_media` varchar(255) NOT NULL,
  PRIMARY KEY (`id_media`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `niveau`
--

DROP TABLE IF EXISTS `niveau`;
CREATE TABLE IF NOT EXISTS `niveau` (
  `id_niveau` int NOT NULL AUTO_INCREMENT,
  `titre_niveau` varchar(50) NOT NULL,
  PRIMARY KEY (`id_niveau`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `posseder`
--

DROP TABLE IF EXISTS `posseder`;
CREATE TABLE IF NOT EXISTS `posseder` (
  `id_competence` int NOT NULL,
  `id_formation` int NOT NULL,
  PRIMARY KEY (`id_competence`,`id_formation`),
  KEY `posseder_formation0_FK` (`id_formation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `reference`
--

DROP TABLE IF EXISTS `reference`;
CREATE TABLE IF NOT EXISTS `reference` (
  `id_reference` int NOT NULL AUTO_INCREMENT,
  `numeros_reference` varchar(50) NOT NULL,
  `titre_reference` varchar(255) NOT NULL,
  PRIMARY KEY (`id_reference`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `type_formation`
--

DROP TABLE IF EXISTS `type_formation`;
CREATE TABLE IF NOT EXISTS `type_formation` (
  `id_type_formation` int NOT NULL AUTO_INCREMENT,
  `titre_type_formation` varchar(50) NOT NULL,
  PRIMARY KEY (`id_type_formation`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `appartenir_cat`
--
ALTER TABLE `appartenir_cat`
  ADD CONSTRAINT `appartenir_cat_categories_FK` FOREIGN KEY (`id_categories`) REFERENCES `categories` (`id_categories`),
  ADD CONSTRAINT `appartenir_cat_formation0_FK` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id_formation`);

--
-- Contraintes pour la table `avoir_media`
--
ALTER TABLE `avoir_media`
  ADD CONSTRAINT `avoir_media_formation_FK` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id_formation`),
  ADD CONSTRAINT `avoir_media_media0_FK` FOREIGN KEY (`id_media`) REFERENCES `media` (`id_media`);

--
-- Contraintes pour la table `avoir_ref`
--
ALTER TABLE `avoir_ref`
  ADD CONSTRAINT `avoir_ref_competence_FK` FOREIGN KEY (`id_competence`) REFERENCES `competence` (`id_competence`),
  ADD CONSTRAINT `avoir_ref_reference0_FK` FOREIGN KEY (`id_reference`) REFERENCES `reference` (`id_reference`);

--
-- Contraintes pour la table `effectuer_type_formation`
--
ALTER TABLE `effectuer_type_formation`
  ADD CONSTRAINT `effectuer_type_formation_formation0_FK` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id_formation`),
  ADD CONSTRAINT `effectuer_type_formation_type_formation_FK` FOREIGN KEY (`id_type_formation`) REFERENCES `type_formation` (`id_type_formation`);

--
-- Contraintes pour la table `formation`
--
ALTER TABLE `formation`
  ADD CONSTRAINT `formation_niveau_FK` FOREIGN KEY (`id_niveau`) REFERENCES `niveau` (`id_niveau`);

--
-- Contraintes pour la table `posseder`
--
ALTER TABLE `posseder`
  ADD CONSTRAINT `posseder_competence_FK` FOREIGN KEY (`id_competence`) REFERENCES `competence` (`id_competence`),
  ADD CONSTRAINT `posseder_formation0_FK` FOREIGN KEY (`id_formation`) REFERENCES `formation` (`id_formation`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
