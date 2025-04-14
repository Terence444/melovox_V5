-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 27 fév. 2025 à 19:53
-- Version du serveur : 8.3.0
-- Version de PHP : 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `melovox`
--

-- --------------------------------------------------------

--
-- Structure de la table `artistes`
--

DROP TABLE IF EXISTS `artistes`;
CREATE TABLE IF NOT EXISTS `artistes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int NOT NULL,
  `biographie` text,
  `photo_profil` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `utilisateur_id` (`utilisateur_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `artistes`
--

INSERT INTO `artistes` (`id`, `utilisateur_id`, `biographie`, `photo_profil`) VALUES
(1, 1, 'Ceci est un test de biographie d\'artiste\r\nLorem ipsum dolor sit amet. In doloremque repudiandae ut saepe quasi sed excepturi consequatur sit totam eveniet ab ipsum facilis. Ab quis nostrum aut blanditiis voluptas sit omnis fuga? Et tempore numquam est libero maiores aut galisum repellendus est maxime nesciunt. </p><p>Est deserunt blanditiis hic quae magni aut asperiores aliquid qui mollitia laboriosam et amet amet et voluptatum beatae sit inventore molestiae! Aut minus explicabo eos blanditiis laborum sit dolores expedita! </p><p>Est voluptas molestiae in explicabo unde aut tempora cumque sit quia culpa ex iure laborum sit odit iusto. Sit repudiandae fugiat cum quam architecto qui voluptatem pariatur ea alias illum aut itaque molestiae. Quo voluptas tempora et voluptas nisi est sequi quos eum eius iusto et recusandae voluptatum. Sit explicabo corrupti et quam dolorem sit quia officia et vero assumenda vel ipsam doloremque qui aliquam veniam ut excepturi quia!\r\n', 'fichiers_config/uploads/photos_profil/67c0ba2f63a3b.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `messages_contact`
--

DROP TABLE IF EXISTS `messages_contact`;
CREATE TABLE IF NOT EXISTS `messages_contact` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `est_artiste` enum('oui','non') NOT NULL,
  `message` text NOT NULL,
  `date_reception` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `messages_contact`
--

INSERT INTO `messages_contact` (`id`, `nom`, `prenom`, `email`, `est_artiste`, `message`, `date_reception`) VALUES
(1, 'loreal', 'paris', 'loreal.paris@gmail.com', 'oui', 'vrfergerghegrertger', '2025-02-27 01:33:08'),
(2, 'loreal', 'paris', 'loreal.paris@gmail.com', 'oui', 'vrfergerghegrertger', '2025-02-27 01:35:04');

-- --------------------------------------------------------

--
-- Structure de la table `musique`
--

DROP TABLE IF EXISTS `musique`;
CREATE TABLE IF NOT EXISTS `musique` (
  `id` int NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int NOT NULL,
  `titre` varchar(255) NOT NULL,
  `artiste` varchar(255) NOT NULL,
  `album` varchar(255) DEFAULT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `chemin_fichier` varchar(255) NOT NULL,
  `date_import` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `utilisateur_id` (`utilisateur_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `musique`
--

INSERT INTO `musique` (`id`, `utilisateur_id`, `titre`, `artiste`, `album`, `genre`, `chemin_fichier`, `date_import`) VALUES
(1, 1, 'All Nigth Long', 'Bob L\'eponge', 'Test', 'Pop', 'fichiers_config/uploads/musique/67c0ae0516fc3_All Night Long.mp3', '2025-02-27 22:25:09');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `prenom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `date_naissance` date NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `sexe` enum('homme','femme','ne_pas_repondre') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'ne_pas_repondre',
  `est_artiste` tinyint(1) NOT NULL,
  `partage_creations` tinyint(1) NOT NULL,
  `pays` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `pseudo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `mot_de_passe` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `photo_profil` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `date_inscription` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pseudo` (`pseudo`),
  UNIQUE KEY `email` (`email`(191))
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `date_naissance`, `email`, `sexe`, `est_artiste`, `partage_creations`, `pays`, `pseudo`, `mot_de_passe`, `photo_profil`, `date_inscription`) VALUES
(1, 'Bob', 'Sponge', '2024-04-10', 'bob.sponge@gmail.com', 'homme', 1, 1, 'France', 'Bob L\'éponge', '$2y$10$e4Bv9p3l68T3fEKdHP.A3eZJns54ynurjDO3v4G/PzTKB8/Qt/17O', NULL, '2025-02-26 23:57:35');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
