-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mar 10 Août 2021 à 12:56
-- Version du serveur :  5.7.14
-- Version de PHP :  7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `linkeo_database`
--

-- --------------------------------------------------------

--
-- Structure de la table `na_options`
--

CREATE TABLE `na_options` (
  `meta_key` varchar(150) NOT NULL,
  `meta_value` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `na_options`
--

INSERT INTO `na_options` (`meta_key`, `meta_value`) VALUES
('mode_maintenance', '0');

-- --------------------------------------------------------

--
-- Structure de la table `na_translations`
--

CREATE TABLE `na_translations` (
  `id` int(11) NOT NULL,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `na_translations_multilingual`
--

CREATE TABLE `na_translations_multilingual` (
  `id` int(11) NOT NULL,
  `id_translation` int(11) NOT NULL,
  `id_language` int(11) NOT NULL,
  `language_abbreviation` enum('en','fr') NOT NULL,
  `key` text,
  `value` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `na_users`
--

CREATE TABLE `na_users` (
  `id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `age` int(11) NOT NULL,
  `email` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `na_users`
--

INSERT INTO `na_users` (`id`, `name`, `age`, `email`) VALUES
(1, 'Tahina', 31, 'taksbeh@gmail.com');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `na_options`
--
ALTER TABLE `na_options`
  ADD PRIMARY KEY (`meta_key`),
  ADD KEY `key` (`meta_key`);

--
-- Index pour la table `na_translations`
--
ALTER TABLE `na_translations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `na_translations_multilingual`
--
ALTER TABLE `na_translations_multilingual`
  ADD PRIMARY KEY (`id`),
  ADD KEY `TrLangTr` (`id_translation`),
  ADD KEY `LangTrLang` (`id_language`);

--
-- Index pour la table `na_users`
--
ALTER TABLE `na_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `na_translations`
--
ALTER TABLE `na_translations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `na_translations_multilingual`
--
ALTER TABLE `na_translations_multilingual`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `na_users`
--
ALTER TABLE `na_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `na_translations_multilingual`
--
ALTER TABLE `na_translations_multilingual`
  ADD CONSTRAINT `TrLangTr` FOREIGN KEY (`id_translation`) REFERENCES `na_translations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
