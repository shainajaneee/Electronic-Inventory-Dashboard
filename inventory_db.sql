-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 02, 2025 at 02:46 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `supplier` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`id`, `name`, `description`, `quantity`, `price`, `supplier`, `created_at`, `updated_at`) VALUES
(1, 'Cellphone', 'Gadget', 50, 5000.00, 'Realme', '2025-11-02 01:44:42', '2025-11-02 01:44:42'),
(2, 'USB Flash Drive', '32GB, USB 3.0', 50, 8.99, 'Tech Supplies Co', '2025-11-02 01:45:11', '2025-11-02 01:45:11'),
(3, 'Wireless Mouse', 'Ergonomic, black', 25, 15.50, 'Gadget World', '2025-11-02 01:45:11', '2025-11-02 01:45:11'),
(4, 'Keyboard', 'Mechanical, RGB backlit', 12, 45.00, 'KeyTech', '2025-11-02 01:45:11', '2025-11-02 01:45:11'),
(5, 'HDMI Cable', '2 meters, high-speed', 8, 5.99, 'Cable Hub', '2025-11-02 01:45:11', '2025-11-02 01:45:11'),
(6, 'Laptop Stand', 'Adjustable, aluminum', 15, 25.75, 'Office Gear', '2025-11-02 01:45:11', '2025-11-02 01:45:11'),
(7, 'External HDD', '1TB, USB 3.0', 5, 60.00, 'Storage Solutions', '2025-11-02 01:45:11', '2025-11-02 01:45:11'),
(8, 'Monitor 24\"', 'Full HD, LED', 0, 120.00, 'Display Center', '2025-11-02 01:45:11', '2025-11-02 01:45:54'),
(9, 'Printer Ink Black', 'Original brand ink cartridge', 30, 18.50, 'Print Supplies', '2025-11-02 01:45:11', '2025-11-02 01:45:11'),
(10, 'Ethernet Cable', 'Cat6, 1 meter', 40, 3.50, 'Cable Hub', '2025-11-02 01:45:11', '2025-11-02 01:45:11'),
(11, 'Webcam 1080p', 'HD, built-in microphone', 7, 35.00, 'Gadget World', '2025-11-02 01:45:11', '2025-11-02 01:45:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
