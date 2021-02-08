-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2020 at 12:05 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL,
  `p_name` varchar(128) DEFAULT NULL,
  `p_phone_no` varchar(128) DEFAULT NULL,
  `p_quantity` int(11) DEFAULT NULL,
  `p_med_name` varchar(128) DEFAULT NULL,
  `p_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`customer_id`, `p_name`, `p_phone_no`, `p_quantity`, `p_med_name`, `p_date`) VALUES
(1, 'Ishan', '966-488-7672', 400, 'Paracetamol', '2020-05-13'),
(2, 'Rushil', '878-994-1122', 36, 'Metacin', '2020-05-14'),
(3, 'John', '977-457-2274', 141, 'Bumetanide', '2020-05-21'),
(4, 'Yash Patel', '922-168-5188', 164, 'Paracetamol', '2020-05-22'),
(5, 'Mukesh', '990-904-0040', 10, 'Paracetamol', '2020-05-24'),
(6, 'Vin Diesel', '888-718-4118', 15, 'Paracetamol', '2020-05-24');

-- --------------------------------------------------------

--
-- Table structure for table `stock`
--

CREATE TABLE `stock` (
  `medicine_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `category` varchar(128) DEFAULT NULL,
  `mgf_company` varchar(128) DEFAULT NULL,
  `price` float DEFAULT NULL,
  `current_stock` int(11) DEFAULT NULL,
  `chemical_comp` varchar(128) DEFAULT NULL,
  `super_stockist` varchar(128) DEFAULT NULL,
  `date_m` date DEFAULT NULL,
  `side_effects` varchar(128) DEFAULT NULL,
  `storage_condition` varchar(128) DEFAULT NULL,
  `warning` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `stock`
--

INSERT INTO `stock` (`medicine_id`, `user_id`, `name`, `category`, `mgf_company`, `price`, `current_stock`, `chemical_comp`, `super_stockist`, `date_m`, `side_effects`, `storage_condition`, `warning`) VALUES
(1, 1, 'Paracetamol', 'Painkiller', 'Cadilla Pharma', 2.4, 911, 'N-(2,3,5,6-tetradeuterio-4-hydroxyphenyl)acetamide', 'Hiren bhai(Plus Company)', '2020-05-13', 'low fever with nausea, stomach pain, and loss of appetite', 'Room Temperature', 'Remember, keep this and all other medicines out of the reach of children, never share your medicines with others, and use this m'),
(2, 1, 'Metacin', 'Fever Reducer', 'aamorb pharmaceuticals pvt ltd', 1, 704, 'NA', 'Star Company(Jayesh Bhai)', '2020-05-21', 'Nausea or Vomiting, Allergic skin reaction ,Gastric  Mouth Ulcer, Anemia Fatigue, Unusual bleeding or bruising', 'Room Temperature', 'The effect of this medicine lasts for an average duration of 4-6 hours.'),
(3, 1, 'Nadostine', 'Antifungals', 'Abbott India Ltd', 16, 340, 'Polyene', 'Kallostin Medicines( Yash Bhai)', '2020-05-13', 'Diarrhea, nausea or vomiting ,stomach pain', 'Room Temperature', 'Always consult your healthcare provider to ensure the information displayed on this page applies to your personal circumstances.'),
(4, 1, 'Bumetanide', 'Diuretics', 'Jazlyn Pharma', 4, 1259, '3-butylamino-4-phenoxy-5-sulfamoylbenzoic acid', 'NA', '2020-05-22', 'burning, redness, itching, or other signs of eye inflammation,Bone or joint pain', 'Room Temperature', 'Bumetanide is used to reduce extra fluid in the body (edema) caused by conditions such as heart failure, liver disease, and kidn');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`) VALUES
(1, 'Ishan Makadia', 'ishan.makadia@gmail.com', '313332b6c4e3c1ae00c3bc7f3eef3754'),
(2, 'Nimit Mehta', 'nimumehta83@gmail.com', '9098f594c49771a968bac317016e53ca'),
(3, 'Mukesh Makadia', 'mukesh.makadia202@gmail.com', '382d5e28d76623ddb72239303c674eaa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`medicine_id`),
  ADD KEY `profile_ibfk_2` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `email` (`email`),
  ADD KEY `password` (`password`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `stock`
--
ALTER TABLE `stock`
  MODIFY `medicine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `profile_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
