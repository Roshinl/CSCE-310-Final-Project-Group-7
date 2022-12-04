-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 04, 2022 at 11:20 PM
-- Server version: 5.7.24
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `group7`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `app_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `tutor_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `appoint_date` date NOT NULL,
  `appoint_start_time` time NOT NULL,
  `appoint_end_time` time NOT NULL,
  `description` text,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`app_id`, `course_id`, `tutor_id`, `student_id`, `appoint_date`, `appoint_start_time`, `appoint_end_time`, `description`, `status`) VALUES
(1, 1, 5, 1, '2022-12-14', '13:00:00', '15:00:00', NULL, 0),
(3, 1, 6, 4, '2022-12-28', '10:00:00', '15:00:00', NULL, 1),
(4, 1, 6, 4, '2022-12-19', '09:00:00', '10:00:00', NULL, 0),
(5, 1, 5, 1, '2022-12-28', '11:00:00', '13:00:00', NULL, 1);

--
-- Triggers `appointments`
--
DELIMITER $$
CREATE TRIGGER `increment_appointment_id` BEFORE INSERT ON `appointments` FOR EACH ROW BEGIN
	SET NEW.app_id = (SELECT IFNULL(MAX(app_id),0) + 1 FROM appointments);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `appointments_table_with_names`
-- (See below for the actual view)
--
CREATE TABLE `appointments_table_with_names` (
`app_id` int(11)
,`course_id` int(11)
,`course_name` text
,`tutor_id` int(11)
,`tutor_username` text
,`student_id` int(11)
,`student_username` text
,`appoint_date` date
,`appoint_start_time` time
,`appoint_end_time` time
,`status` tinyint(1)
);

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` int(11) NOT NULL,
  `course_name` text NOT NULL,
  `course_num` int(11) NOT NULL,
  `course_desc` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `course_num`, `course_desc`) VALUES
(1, 'Math for idiots', 151, 'Math for idiots. Nothing more, nothing less.');

--
-- Triggers `courses`
--
DELIMITER $$
CREATE TRIGGER `increment_course_id` BEFORE INSERT ON `courses` FOR EACH ROW BEGIN
	SET NEW.course_id = (SELECT IFNULL(MAX(course_id),0) + 1 FROM appointments);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `payment_info`
--

CREATE TABLE `payment_info` (
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `card_type` text NOT NULL,
  `card_num` text NOT NULL,
  `CVV` text NOT NULL,
  `zip_code` text NOT NULL,
  `exp_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `payment_info`
--

INSERT INTO `payment_info` (`payment_id`, `user_id`, `card_type`, `card_num`, `CVV`, `zip_code`, `exp_date`) VALUES
(1, 1, 'American Express', '123', '123', '123', '2022-11-01'),
(2, 4, 'Mastercard', '999', '888', '53453', '2022-12-30');

--
-- Triggers `payment_info`
--
DELIMITER $$
CREATE TRIGGER `increment_payment` BEFORE INSERT ON `payment_info` FOR EACH ROW BEGIN
	SET NEW.payment_id = (SELECT IFNULL(MAX(payment_id),0) + 1 FROM payment_info);
    UPDATE student SET has_payment = 1 WHERE user_id = NEW.user_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `app_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text,
  `num_stars` int(11) NOT NULL,
  `review_date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `reviews`
--
DELIMITER $$
CREATE TRIGGER `increment_review_id` BEFORE INSERT ON `reviews` FOR EACH ROW BEGIN
	SET NEW.review_id = (SELECT IFNULL(MAX(review_id), 0) + 1 FROM reviews);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `reviews_table_with_names`
-- (See below for the actual view)
--
CREATE TABLE `reviews_table_with_names` (
`review_id` int(11)
,`app_id` int(11)
,`content` text
,`num_stars` int(11)
,`review_date_time` datetime
,`tutor_id` int(11)
,`tutor_fname` text
,`tutor_lname` text
,`course_name` text
);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `user_id` int(11) NOT NULL,
  `has_payment` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`user_id`, `has_payment`) VALUES
(1, 1),
(4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tutor`
--

CREATE TABLE `tutor` (
  `user_id` int(11) NOT NULL,
  `rate` double DEFAULT NULL,
  `review_avrg` double DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tutor`
--

INSERT INTO `tutor` (`user_id`, `rate`, `review_avrg`, `is_admin`) VALUES
(5, NULL, NULL, 0),
(6, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `password` text NOT NULL,
  `user_fname` text NOT NULL,
  `user_lname` text NOT NULL,
  `username` text NOT NULL,
  `email` text NOT NULL,
  `is_tutor` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `password`, `user_fname`, `user_lname`, `username`, `email`, `is_tutor`) VALUES
(1, '123', 'jason', 'lai', 'jasonlai', 'jasonlai@cringe.com', 0),
(4, '123', '123', '123', '123', '1234', 0),
(5, '123', 'John', 'Smith', 'johnsmith', 'johnsmith@email.com', 1),
(6, '123', 'Jane', 'Doe', 'janedoe', 'janedoe@email.com', 1);

--
-- Triggers `user`
--
DELIMITER $$
CREATE TRIGGER `increment_userID` BEFORE INSERT ON `user` FOR EACH ROW BEGIN
	SET NEW.user_id = (SELECT IFNULL(MAX(user_id),0) + 1 FROM user);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_student` AFTER INSERT ON `user` FOR EACH ROW BEGIN
IF (NEW.is_tutor = 0) THEN
    	INSERT INTO student (user_id, has_payment) VALUES (NEW.user_id, 0);
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `update_tutor` AFTER INSERT ON `user` FOR EACH ROW BEGIN
IF (NEW.is_tutor = 1) THEN
    	INSERT INTO tutor (user_id, is_admin) VALUES (NEW.user_id, 0);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure for view `appointments_table_with_names`
--
DROP TABLE IF EXISTS `appointments_table_with_names`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `appointments_table_with_names`  AS SELECT `appointments`.`app_id` AS `app_id`, `courses`.`course_id` AS `course_id`, `courses`.`course_name` AS `course_name`, `appointments`.`tutor_id` AS `tutor_id`, `foo`.`username` AS `tutor_username`, `appointments`.`student_id` AS `student_id`, `bar`.`username` AS `student_username`, `appointments`.`appoint_date` AS `appoint_date`, `appointments`.`appoint_start_time` AS `appoint_start_time`, `appointments`.`appoint_end_time` AS `appoint_end_time`, `appointments`.`status` AS `status` FROM (((`appointments` join `user` `foo` on((`appointments`.`tutor_id` = `foo`.`user_id`))) join `user` `bar` on((`appointments`.`student_id` = `bar`.`user_id`))) join `courses` on((`appointments`.`course_id` = `courses`.`course_id`)))  ;

-- --------------------------------------------------------

--
-- Structure for view `reviews_table_with_names`
--
DROP TABLE IF EXISTS `reviews_table_with_names`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `reviews_table_with_names`  AS SELECT `reviews`.`review_id` AS `review_id`, `reviews`.`app_id` AS `app_id`, `reviews`.`content` AS `content`, `reviews`.`num_stars` AS `num_stars`, `reviews`.`review_date_time` AS `review_date_time`, `appointments`.`tutor_id` AS `tutor_id`, `foo`.`user_fname` AS `tutor_fname`, `foo`.`user_lname` AS `tutor_lname`, `courses`.`course_name` AS `course_name` FROM (((`reviews` join `appointments` on((`reviews`.`app_id` = `appointments`.`app_id`))) join `courses`) join `user` `foo` on((`appointments`.`tutor_id` = `foo`.`user_id`)))  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`app_id`),
  ADD KEY `appointments_ibfk_1` (`course_id`),
  ADD KEY `appointments_ibfk_2` (`tutor_id`),
  ADD KEY `appointments_ibfk_3` (`student_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`);

--
-- Indexes for table `payment_info`
--
ALTER TABLE `payment_info`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `student_id` (`user_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `reviews_ibfk_1` (`app_id`),
  ADD KEY `student_id` (`user_id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tutor`
--
ALTER TABLE `tutor`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `index_username` (`username`(512));

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`tutor_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_3` FOREIGN KEY (`student_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment_info`
--
ALTER TABLE `payment_info`
  ADD CONSTRAINT `payment_info_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `student` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`app_id`) REFERENCES `appointments` (`app_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `student` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `student`
--
ALTER TABLE `student`
  ADD CONSTRAINT `student_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tutor`
--
ALTER TABLE `tutor`
  ADD CONSTRAINT `tutor_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
