-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2024 at 07:12 AM
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
-- Database: `campus_ministry`
--

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `Event_ID` int(11) NOT NULL,
  `Staff_ID` int(11) DEFAULT NULL,
  `E_Type` varchar(100) NOT NULL,
  `E_Year` int(11) NOT NULL,
  `E_Month` varchar(11) NOT NULL,
  `E_Day` int(11) NOT NULL,
  `E_Course` varchar(255) NOT NULL,
  `E_Religion` varchar(50) NOT NULL,
  `E_Location` varchar(100) NOT NULL,
  `E_file_ref` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`Event_ID`, `Staff_ID`, `E_Type`, `E_Year`, `E_Month`, `E_Day`, `E_Course`, `E_Religion`, `E_Location`, `E_file_ref`) VALUES
(133, 14, 'Retreat', 2024, '1', 1, 'BSCS', 'Muslim', 'ADZU', '../Evaluation Forms/Retreat/Event Feedback (Responses).xlsx'),
(134, 14, 'Recollection 02', 2024, '2', 2, 'BSIT , BSCS, BS NMCA', 'Christian', 'JHS Campus', '../Evaluation Forms/Recollection 02/Event Feedback (Responses).xlsx');

-- --------------------------------------------------------

--
-- Table structure for table `new_events`
--

CREATE TABLE `new_events` (
  `id` int(11) NOT NULL,
  `Event_ID` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `lastname` text NOT NULL,
  `firstname` text NOT NULL,
  `course` text NOT NULL,
  `gender` varchar(255) NOT NULL,
  `age` int(255) NOT NULL,
  `venue` text NOT NULL,
  `date` date NOT NULL,
  `L1` int(11) NOT NULL,
  `L2` int(11) NOT NULL,
  `L3` int(11) NOT NULL,
  `L4` int(11) NOT NULL,
  `L5` int(11) NOT NULL,
  `L6` int(11) NOT NULL,
  `C1` int(11) NOT NULL,
  `C2` int(11) NOT NULL,
  `C3` int(11) NOT NULL,
  `C4` int(11) NOT NULL,
  `C5` int(11) NOT NULL,
  `C6` int(11) NOT NULL,
  `C7` int(11) NOT NULL,
  `C8` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `new_events`
--

INSERT INTO `new_events` (`id`, `Event_ID`, `student_id`, `lastname`, `firstname`, `course`, `gender`, `age`, `venue`, `date`, `L1`, `L2`, `L3`, `L4`, `L5`, `L6`, `C1`, `C2`, `C3`, `C4`, `C5`, `C6`, `C7`, `C8`) VALUES
(23, 133, 220802, 'Caga-anan', 'Matthew', 'BSIT', 'Male', 20, 'Lantaka', '2024-11-11', 1, 2, 3, 4, 5, 4, 0, 0, 0, 0, 0, 0, 0, 0),
(24, 133, 220314, 'Napao', 'Rufia', 'BSIT', 'Female', 21, 'ADZU ', '2024-11-25', 3, 3, 3, 3, 3, 3, 0, 0, 0, 0, 0, 0, 0, 0),
(25, 134, 220802, 'Caga-anan', 'Matthew', 'BSIT', 'Male', 20, 'Lantaka', '2024-11-11', 1, 2, 3, 4, 5, 4, 0, 0, 0, 0, 0, 0, 0, 0),
(26, 134, 220314, 'Napao', 'Rufia', 'BSIT', 'Female', 21, 'ADZU ', '2024-11-25', 3, 3, 3, 3, 3, 3, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `Staff_ID` int(11) NOT NULL,
  `S_Name` varchar(100) NOT NULL,
  `S_Type` varchar(50) NOT NULL,
  `S_Password` varchar(255) NOT NULL,
  `S_Email` varchar(100) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`Staff_ID`, `S_Name`, `S_Type`, `S_Password`, `S_Email`, `is_admin`) VALUES
(14, 'Admin, A', 'Admin', '$2y$10$E2BWTlszSE7yGWKuSPTGOORlQz6AHm0sf7qazN70u.WzFuBO/5uGW', 'admin@adzu.edu.ph', 1),
(16, 'Lim, Dins', 'Recollection 02', '$2y$10$UHLXqymUAa28veEnlcZakOvPLjP9HpLsFqTNJQh.F6DguCT5Pb7Mi', 'dins@adzu.edu.ph', 0),
(25, 'Admin, A', 'Admin', '$2y$10$6YjAN5qzUYx12nYiTglBN.7Z7nlkOocAx6oZBsz9T2ltTajlyJ8BG', 'admin@adzu.edu.ph', 1),
(26, 'a, a', 'Developer', '$2y$10$vzuwsMtEU.Ht08B/Au0dVee9a36BdRbMtRiY.tkCCJUnBEvhHdfJq', 'a@adzu.edu.ph', 0),
(27, 'admin, admin', 'Admin', '$2y$10$48UMqD9PLs1S5I37YA1/6udOCtJCOjLQC4koYj0mLzf7ZSEElSd12', 'aadmin@adzu.edu.ph', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`Event_ID`),
  ADD KEY `Staff_ID` (`Staff_ID`);

--
-- Indexes for table `new_events`
--
ALTER TABLE `new_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Event_ID` (`Event_ID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`Staff_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `Event_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT for table `new_events`
--
ALTER TABLE `new_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `Staff_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`Staff_ID`) REFERENCES `staff` (`Staff_ID`);

--
-- Constraints for table `new_events`
--
ALTER TABLE `new_events`
  ADD CONSTRAINT `new_events_ibfk_1` FOREIGN KEY (`Event_ID`) REFERENCES `event` (`Event_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
