-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 27, 2025 at 06:48 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wine_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'laragraves', '$2y$10$3EsSBXtMNlUt4s6ey38DguAp2s8Ky.tdSv2.qfxNt9zPy3cM6uHyu'),
(2, 'wineExpert', '$2y$10$mZTu4ayfs31GI.DtyV0kFeuyBQX1ZHt5fhbFAlblcdn6QJsb5NHAO'),
(3, 'barbara', '$2y$10$p18ImmsuxAc3DGSNiCFer.xR5V5tOmKZC2N1Y1mnnumrt/36LPi1O');

-- --------------------------------------------------------

--
-- Table structure for table `tasting-notes`
--

CREATE TABLE `tasting-notes` (
  `note_id` int(11) NOT NULL,
  `wine_fk` int(11) NOT NULL,
  `flavour_note` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasting-notes`
--

INSERT INTO `tasting-notes` (`note_id`, `wine_fk`, `flavour_note`) VALUES
(4, 2, 'lime'),
(5, 2, 'petrol'),
(6, 2, 'slate/mineral'),
(7, 3, 'black fruit'),
(8, 3, 'cedar'),
(9, 4, 'grapefruit'),
(10, 4, 'stone fruit'),
(11, 4, 'slate/mineral'),
(12, 5, 'bell pepper'),
(13, 5, 'raspberry'),
(14, 5, 'smoky'),
(15, 6, 'pear'),
(16, 6, 'saline/maritime'),
(17, 7, 'cranberry'),
(18, 7, 'strawberry'),
(19, 8, 'floral'),
(20, 9, 'elderflower'),
(21, 9, 'citrus zest'),
(22, 10, 'black olive'),
(23, 10, 'plum'),
(24, 10, 'earthy'),
(25, 11, 'slate_mineral'),
(26, 11, 'citrus_zest'),
(35, 12, 'cedar'),
(36, 12, 'floral'),
(44, 13, 'mushroom'),
(45, 13, 'earthy'),
(46, 14, 'earthy'),
(47, 14, 'citrus_zest'),
(48, 15, 'wild_cherry'),
(49, 15, 'black_fruit'),
(50, 15, 'cedar'),
(51, 15, 'smoky'),
(52, 15, 'black_olive');

-- --------------------------------------------------------

--
-- Table structure for table `wine`
--

CREATE TABLE `wine` (
  `wine_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `winery` varchar(255) NOT NULL,
  `region` enum('Okanagan Valley','Similkameen Valley','Vancouver Island','Fraser Valley','Thompson Valley') NOT NULL,
  `colour` enum('Red','White','Rose','Sparkling') NOT NULL,
  `body` enum('Light','Medium','Full','') NOT NULL,
  `sweetness` enum('Dry','Off-dry','Sweet','') NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wine`
--

INSERT INTO `wine` (`wine_id`, `name`, `winery`, `region`, `colour`, `body`, `sweetness`, `price`, `description`, `image_url`, `updated_at`) VALUES
(2, 'Synchromesh Riesling', 'Synchromesh Wines', 'Okanagan Valley', 'White', 'Light', 'Off-dry', 28.50, 'A highly aromatic Riesling with great acidity, showing notes of lime, petrol, and slate.', 'images/synchromesh-riesling.png', '2025-11-24 21:57:56'),
(3, 'Burrowing Owl Athene', 'Burrowing Owl Estate', 'Okanagan Valley', 'Red', 'Full', 'Dry', 49.99, 'A Bordeaux-style blend with dense black fruit, cedar, and a long, powerful finish.', 'images/burrowing-owl.png', '2025-11-24 21:57:56'),
(4, 'Orofino Chardonnay', 'Orofino Vineyards', 'Similkameen Valley', 'White', 'Medium', 'Dry', 31.00, 'Mineral-driven Chardonnay with subtle oak, notes of grapefruit and stone fruit.', 'images/orofino-riesling.png', '2025-11-24 21:57:56'),
(5, 'Seven Stones Cabernet Franc', 'Seven Stones Winery', 'Similkameen Valley', 'Red', 'Medium', 'Dry', 40.00, 'Classic Similkameen Cab Franc, exhibiting bell pepper, raspberry, and a smoky complexity.', 'images/seven-stones-cab-franc.png', '2025-11-24 21:57:56'),
(6, 'Unsworth Pinot Gris', 'Unsworth Vineyards', 'Vancouver Island', 'White', 'Medium', 'Dry', 25.99, 'A crisp, fresh Pinot Gris with maritime influence, featuring pear and saline notes.', 'images/unsworth-pinot-gris.avif', '2025-11-24 21:57:56'),
(7, 'Sandhill Rose', 'Sandhill', 'Vancouver Island', 'Rose', 'Light', 'Dry', 27.00, 'Features raspberry, black tea, and peach notes leading to a spicy finish.', 'images/sandhill-rose.jpg', '2025-11-24 21:57:56'),
(8, 'Backyard Vineyards Nosey Rosé', 'Backyard Vineyards', 'Fraser Valley', 'Rose', 'Light', 'Off-dry', 22.50, 'A slightly sweeter Rosé with soft floral notes and balanced acidity.', 'images/backyard-rose.png', '2025-11-24 21:57:56'),
(9, 'Chaberton Bacchus', 'Domaine de Chaberton', 'Fraser Valley', 'White', 'Light', 'Off-dry', 19.95, 'A unique, aromatic German varietal with notes of elderflower and citrus zest.', 'images/chaberton-bacchus.webp', '2025-11-24 21:57:56'),
(10, 'Monte Creek Ranch Foch', 'Monte Creek Ranch', 'Thompson Valley', 'Red', 'Medium', 'Dry', 24.99, 'A cool-climate red, showcasing Maréchal Foch with earthy notes of black olive and plum.', 'images/monte-foch.png', '2025-11-24 21:57:56'),
(11, 'Traditional Brut', 'Summerhill Pyramid Winery', 'Okanagan Valley', 'Sparkling', 'Light', 'Dry', 39.99, 'Classic Traditional Method Brut with fine bubbles, offering notes of baked apple, brioche, and citrus zest.', 'images/wine_69260e03e9d643.95946749.jpg', '2025-11-25 20:15:04'),
(12, 'Marsanne Roussanne', 'Black Hills Estate Winery', 'Okanagan Valley', 'White', 'Full', 'Dry', 34.00, 'A rich, full-bodied blend combining notes of honeysuckle and white peach with a round, creamy finish.', 'images/wine_69277f2ce06371.87906453.png', '2025-11-26 22:29:00'),
(13, 'Okanagan Falls Pinot Noir', 'Blue Mountain Vineyard', 'Okanagan Valley', 'Red', 'Medium', 'Sweet', 45.00, 'Elegant and earthy Pinot Noir with notes of wild cherry, mushroom, and fine tannins.', 'images/wine_69278bea8e2a43.03710637.webp', '2025-11-26 23:23:22'),
(14, 'Gold Label Brut', 'Blue Mountain Vineyard and Cellars', 'Okanagan Valley', 'Sparkling', 'Medium', 'Dry', 32.00, 'Traditional Method blend of Chardonnay/Pinot Noir. Crisp, refreshing, with fine bubbles and complex notes of apple, brioche, and citrus.', 'images/wine_69279ca13e3065.02867883.jpg', '2025-11-27 00:34:41'),
(15, 'Corcelettes Estate Talus', 'Corcelettes Estate Winery', 'Similkameen Valley', 'Red', 'Full', 'Dry', 49.90, 'A bold, deeply structured Bordeaux blend. Rich with black fruit, graphite, tobacco, and long, firm tannins.', 'images/wine_69279f5c132985.56391976.png', '2025-11-27 00:46:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `password` (`password`);

--
-- Indexes for table `tasting-notes`
--
ALTER TABLE `tasting-notes`
  ADD PRIMARY KEY (`note_id`),
  ADD KEY `wine_fk` (`wine_fk`);

--
-- Indexes for table `wine`
--
ALTER TABLE `wine`
  ADD PRIMARY KEY (`wine_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tasting-notes`
--
ALTER TABLE `tasting-notes`
  MODIFY `note_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `wine`
--
ALTER TABLE `wine`
  MODIFY `wine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tasting-notes`
--
ALTER TABLE `tasting-notes`
  ADD CONSTRAINT `tasting-notes_ibfk_1` FOREIGN KEY (`wine_fk`) REFERENCES `wine` (`wine_id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
