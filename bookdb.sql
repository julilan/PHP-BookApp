-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: db
-- Generation Time: 14.05.2023 klo 20:31
-- Palvelimen versio: 8.0.32
-- PHP Version: 8.1.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookdb`
--

-- --------------------------------------------------------

--
-- Rakenne taululle `books`
--

CREATE TABLE `books` (
  `id` int NOT NULL,
  `title` varchar(50) NOT NULL,
  `author` varchar(30) NOT NULL,
  `genre` varchar(25) NOT NULL,
  `description` varchar(200) NOT NULL,
  `link` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `image` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Vedos taulusta `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `genre`, `description`, `link`, `image`) VALUES
(1, 'All Systems Red', 'Martha Wells', 'Scifi', 'My favourite book about an antisocial android that loves soap dramas. It&#039;s the best book ever!', 'https://www.goodreads.com/book/show/32758901-all-systems-red', 'https://images-na.ssl-images-amazon.com/images/S/compressed.photo.goodreads.com/books/1631585309i/32758901.jpg'),
(9, 'Test 2', 'Test 2', 'Test', 'Hello again', '', ''),
(10, 'Palaldin', 'Hugo', 'Fantasy', 'asdasd', NULL, NULL),
(11, 'Hello', 'World', 'Hello', 'Hello', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
