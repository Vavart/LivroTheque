-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 30 déc. 2021 à 08:05
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `livrotheque`
--

-- --------------------------------------------------------

--
-- Structure de la table `livre`
--

CREATE TABLE `livre` (
  `ISBN` bigint(8) NOT NULL,
  `title` text NOT NULL,
  `author` text NOT NULL,
  `subject` text NOT NULL,
  `editor` text NOT NULL,
  `release_date` date NOT NULL,
  `pic` text NOT NULL,
  `abstract` longtext NOT NULL,
  `add_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `livre`
--

INSERT INTO `livre` (`ISBN`, `title`, `author`, `subject`, `editor`, `release_date`, `pic`, `abstract`, `add_date`) VALUES
(123456789, 'Un super livre', 'Un super auteur', 'self-help', 'Un super éditeur', '2025-04-01', '../assets/pictures/books/super_livre.jpg', ' Un super résumé', '0000-00-00 00:00:00'),
(2213706115, 'Devenir', 'Michelle Obama', 'politics', 'Fayard', '2018-11-13', '../assets/pictures/books/devenir_michelle_obama.jpg', ' &quot;Il y a encore tant de choses que j&#039;ignore au sujet de l&#039;Amérique, de la vie, et de ce que l&#039;avenir nous réserve. Mais je sais qui je suis. Mon père, Fraser, m&#039;a appris à travailler dur, à rire souvent et à tenir parole. Ma mère, Marian, à penser par moi-même et à faire entendre ma voix. Tous les deux ensemble, dans notre petit appartement du quartier du South Side de Chicago, ils m&#039;ont aidée à saisir ce qui faisait la valeur de notre histoire, de mon histoire, et plus largement de l&#039;histoire de notre pays. Même quand elle est loin d&#039;être belle et parfaite. Même quand la réalité se rappelle à vous plus que vous ne l&#039;auriez souhaité. Votre histoire vous appartient, et elle vous appartiendra toujours. À vous de vous en emparer.&quot;\r\nMichelle Obama', '0000-00-00 00:00:00'),
(2221247884, 'Toujours plus, +=+', 'Léna Situations', 'self-help', 'Robert Laffont', '2020-09-24', '../assets/pictures/books/toujours_plus_lena.jpg', ' &quot; Je vous jure, il est bien, achetez-le ! &quot;\r\nParce que, depuis le lycée, Lena est une adepte du développement personnel, elle a souhaité faire de ce livre un guide pratique à destination des jeunes pour dire NON à la déprime, à la morosité et à la spirale du négatif ; OUI au positif, à la joie, à l&#039;acceptation de soi et à la réussite. Un manuel pratique et militant, de bonne humeur et d&#039;esprit positif, qu&#039;elle résume elle-même sous cette formule : + = +', '0000-00-00 00:00:00'),
(2266268554, 'Miracle Morning', 'Hal Elrod', 'self-help', 'Pocket', '2017-06-14', '../assets/pictures/books/miracle_morning_hal_elrod.jpg', ' Et si la clef du bonheur et de la réussite se trouvait dans cette nouvelle résolution ? C&#039;est la découverte qui a changé la vie d&#039;Hal Elrod ainsi que celle de milliers de lecteurs.\r\nDémarrez votre journée par un moment rien qu&#039;à vous, profitez de ce moment de calme pour méditer, faire du sport, lire et préparer votre journée, comme une nouvelle aventure à entamer chaque matin. Et faites de votre quotidien un miracle !', '2021-12-26 09:42:03'),
(2290004448, 'L&#039;Alchimiste', 'Paulo Coelho', 'self-help', 'J&#039;AI LU', '2007-03-01', '../assets/pictures/books/lalchimiste_paulo_coelho.jpg', ' Santiago, un jeune berger andalou, part à la recherche d&#039;un trésor enfoui au pied des Pyramides.\r\nLorsqu&#039;il rencontre l&#039;Alchimiste dans le désert, celui-ci lui apprend à écouter son cœur, à lire les signes du destin et, par-dessus tout, à aller au bout de son rêve.\r\nMerveilleux conte philosophique destiné à l&#039;enfant qui sommeille en chaque être, ce livre a déjà marqué une génération de lecteurs.', '0000-00-00 00:00:00'),
(2849334650, 'L&#039;autoroute du millionnaire', 'MJ Demarco', 'finance', 'CONTRE-DIRES', '2018-10-02', '../assets/pictures/books/autoroute_du_millionnaire.jpg', ' La voie express vers la richesse\r\nAllez à l&#039;école, obtenez de bons diplômes et un poste de cadre. Achetez votre résidence principale dès que possible, limitez les dépenses au maximum et épargnez 10% de vos revenus. Si vous suivez ces recommandations, vous serez effectivement peut-être riche un jour... mais pas avant de nombreuses années ! Ou bien, oubliez ces conseils et devenez riche maintenant. Car, contrairement à la croyance populaire relayée par les différents gourous de l&#039;argent qui prônent un enrichissement lent sur plusieurs décennies, il existe une Voie rapide vers la richesse, une Autoroute qui décrit exactement comment MJ DeMarco, entrepreneur parti de zéro, est arrivé à devenir multimillionnaire et quasi-retraité trentenaire en respectant les 5 commandements qui mènent vers la richesse. Grâce à ce livre, qui va littéralement changer votre vie, vous comprendrez - quelles sont vos idées erronées sur l&#039;argent, et pourquoi vous ne deviendrez jamais riche en restant sur la file de droite toute votre vie, avec un boulot de salarié . - comment vous sentir riche dès à présent, même sans un rond . - comment vous enrichir en créant une entreprise dans le bon secteur . - comment faire exploser votre valeur nette de plus de 400 % (et dire adieu aux rendements boursiers à 8 % ! ) . - et bien d&#039;autres conseils pour acquérir le bon esprit et oser vous mettre sur la file de gauche avant d&#039;être trop âgé pour pouvoir vraiment profiter de la vie !', '0000-00-00 00:00:00'),
(2924061644, 'L&#039;art subtil de s&#039;en foutre', 'Mark Manson', 'self-help', 'Eyerolles', '2017-06-01', '../assets/pictures/books/lart_subtil_de_sen_foutre.jpg', ' Un livre de développement personnel pour ceux qui détestent le développement personnel\r\nLe discours ambiant nous pousse sans cesse à nous améliorer. Sois plus heureux. Sois en meilleure santé. Sois plus intelligent, plus rapide, plus riche, plus sexy, plus productif. Mais il faut en finir avec la pensée positive, nous dit Mark Manson. &quot;Soyons honnêtes : parfois tout va de travers, et il faut faire avec.&quot;\r\n\r\nDepuis quelques années, à travers son blog au succès phénoménal, Mark Manson explore les aspirations délirantes qui déforment notre perception du monde. Il propose ici sa sagesse pratique, joyeusement insolente. C&#039;est en regardant en face nos peurs, nos défauts et nos incertitudes - en arrêtant de fuir et d&#039;éviter -, que nous pourrons trouver le courage et la confiance qui nous manquent tant.', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `membre`
--

CREATE TABLE `membre` (
  `id` int(11) NOT NULL,
  `member_name` text NOT NULL,
  `surname` text NOT NULL,
  `email` text NOT NULL,
  `psw` text NOT NULL,
  `isAdmin` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `membre`
--

INSERT INTO `membre` (`id`, `member_name`, `surname`, `email`, `psw`, `isAdmin`) VALUES
(0, 'Admin', 'Admin', 'Admin', 'adgxs.r57O4tk', 1),
(1, 'Emily', 'Greene', 'emily.greene@hotmail.com', 'MoBjVRoYz.jEo', 0);

-- --------------------------------------------------------

--
-- Structure de la table `reservations`
--

CREATE TABLE `reservations` (
  `ISBN` bigint(8) UNSIGNED NOT NULL,
  `book_title` text NOT NULL,
  `book_author` text NOT NULL,
  `id_membre` int(11) NOT NULL,
  `loan_date` date NOT NULL,
  `due_date` date NOT NULL,
  `currentlyLoaned` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `reservations`
--

INSERT INTO `reservations` (`ISBN`, `book_title`, `book_author`, `id_membre`, `loan_date`, `due_date`, `currentlyLoaned`) VALUES
(2213706115, 'Devenir', 'Michelle Obama', 1, '2021-12-26', '2022-01-25', 1),
(2290004448, 'L&amp;#039;Alchimiste', 'Paulo Coelho', 1, '2021-12-25', '2021-12-26', 0),
(2849334650, 'L&amp;#039;autoroute du millionnaire', 'MJ Demarco', 1, '2021-12-25', '2021-12-26', 0);

-- --------------------------------------------------------

--
-- Structure de la table `stock`
--

CREATE TABLE `stock` (
  `ISBN` bigint(8) UNSIGNED NOT NULL,
  `total` int(11) NOT NULL,
  `ordered` int(11) NOT NULL,
  `loaned` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `stock`
--

INSERT INTO `stock` (`ISBN`, `total`, `ordered`, `loaned`) VALUES
(123456789, 0, 0, 0),
(2213706115, 6, 0, 1),
(2221247884, 4, 0, 0),
(2266268554, 11, 0, 0),
(2290004448, 7, 2, 0),
(2849334650, 3, 0, 0),
(2924061644, 0, 0, 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `livre`
--
ALTER TABLE `livre`
  ADD PRIMARY KEY (`ISBN`);

--
-- Index pour la table `membre`
--
ALTER TABLE `membre`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`ISBN`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
