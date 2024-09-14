-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 04 juin 2024 à 04:37
-- Version du serveur : 10.4.25-MariaDB
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ags_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id` int(255) NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `number` int(255) NOT NULL,
  `password` text NOT NULL,
  `stat` int(11) NOT NULL DEFAULT 0,
  `admin` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `name`, `email`, `number`, `password`, `stat`, `admin`) VALUES
(1, 'Iyehah/Hacen', 'iyehah@gmail.com', 43000038, '111', 1, 1),
(2, 'Med Vall/Khatry', 'medvall@gmail.com', 44115709, '222', 1, 0),
(21, 'x', 'x@gmail.com', 12345678, '333', 0, 0),
(22, 'Hamoude', 'hamoude@gmail.com', 42762525, '222', 0, 0),
(23, 'Ismaail', 'ismail@gmail.com', 43257752, '333', 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `product_id` int(255) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `price` int(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`product_id`, `title`, `description`, `price`, `amount`, `img`) VALUES
(15, 'Chair', 'Black-2 Chair', 300, 12, '6.png'),
(16, 'Shirt', 'Smokey Shirt', 150, 0, '9.png'),
(17, 'watsh', 'Brown watsh', 100, 2, '17.png'),
(18, 'Airpods', 'Black Airpods', 300, 6, '14.png'),
(19, 'Sheos', 'Black Sheos', 200, 2, '19.png'),
(20, 'Sheos', 'Wheat Sheos', 200, 3, '18.png'),
(21, 'Shirt', 'Summer shirt', 300, 12, '15.png'),
(22, 'Back bag', 'green bag', 500, 0, '16 (2).png'),
(24, 'Glasses', 'glasses', 150, 0, '13.png'),
(25, 'Cair', 'Brown Seat', 300, 0, '5.png');

-- --------------------------------------------------------

--
-- Structure de la table `requests`
--

CREATE TABLE `requests` (
  `id` int(255) NOT NULL,
  `img` text NOT NULL,
  `product_id` int(11) NOT NULL,
  `title` text NOT NULL,
  `price` int(255) NOT NULL,
  `amount` int(255) NOT NULL,
  `client_id` int(255) NOT NULL,
  `client_email` text NOT NULL,
  `client_name` text NOT NULL,
  `client_number` int(255) NOT NULL,
  `comment` text NOT NULL,
  `date` date NOT NULL,
  `stat` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `requests`
--

INSERT INTO `requests` (`id`, `img`, `product_id`, `title`, `price`, `amount`, `client_id`, `client_email`, `client_name`, `client_number`, `comment`, `date`, `stat`) VALUES
(118, '19.png', 19, 'Sheos', 200, 1, 2, 'medvall@gmail.com', 'Med Vall/Khatry', 44115709, 'no comment', '2024-05-12', 1),
(119, '9.png', 16, 'Shirt', 150, 20, 2, 'medvall@gmail.com', 'Med Vall/Khatry', 44115709, 'no comment', '2024-05-12', 0),
(186, '13.png', 24, 'Glasses', 150, 1, 1, 'iyehah@gmail.com', 'Iyehah/Hacen', 43000038, 'no comment', '2024-06-04', 0),
(187, '18.png', 20, 'Sheos', 200, 6, 1, 'iyehah@gmail.com', 'Iyehah/Hacen', 43000038, 'no comment', '2024-06-04', 0),
(188, '19.png', 19, 'Sheos', 200, 8, 1, 'iyehah@gmail.com', 'Iyehah/Hacen', 43000038, 'no comment', '2024-06-04', 0),
(189, '17.png', 17, 'watsh', 100, 1, 1, 'iyehah@gmail.com', 'Iyehah/Hacen', 43000038, 'no comment', '2024-06-04', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Index pour la table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
