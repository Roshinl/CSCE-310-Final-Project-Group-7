-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 08, 2022 at 05:39 PM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`user_id`) VALUES
(6),
(7);

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
  `status` tinyint(1) NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`app_id`, `course_id`, `tutor_id`, `student_id`, `appoint_date`, `appoint_start_time`, `appoint_end_time`, `description`, `status`) VALUES
(4, 1, 5, 1, '2022-12-21', '10:00:00', '12:00:00', NULL, 1),
(6, 1, 5, 1, '2022-12-15', '10:00:00', '12:00:00', NULL, 1),
(7, 2, 5, 1, '2022-12-27', '10:00:00', '11:00:00', NULL, 1),
(8, 3, 8, 1, '2022-12-31', '09:00:00', '12:00:00', NULL, 2),
(9, 2, 5, 1, '2022-12-15', '13:00:00', '14:00:00', NULL, 1),
(10, 3, 5, 1, '2022-12-31', '13:00:00', '16:00:00', NULL, 0);

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
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Triggers `cart`
--
DELIMITER $$
CREATE TRIGGER `increment_cart_id` BEFORE INSERT ON `cart` FOR EACH ROW BEGIN
	SET NEW.cart_id = (SELECT IFNULL(MAX(cart_id),0) + 1 FROM cart);
END
$$
DELIMITER ;

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
(1, 'Engineering Mathematics I', 151, 'Calculus 1'),
(2, 'Programming Studios', 315, 'Project based'),
(3, 'Database Systems', 310, 'Databases');

--
-- Triggers `courses`
--
DELIMITER $$
CREATE TRIGGER `increment_course_id` BEFORE INSERT ON `courses` FOR EACH ROW BEGIN
	SET NEW.course_id = (SELECT IFNULL(MAX(course_id),0) + 1 FROM courses);
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
(4, 1, 'VISA', '123', '123', '123', '2022-12-30'),
(5, 1, 'Mastercard', '12345', '123', '123', '2022-12-15');

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
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `app_id`, `user_id`, `content`, `num_stars`, `review_date_time`) VALUES
(1, 4, 6, 'good', 3, '2022-12-07 16:43:36');

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
,`user_id` int(11)
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
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tutor`
--

CREATE TABLE `tutor` (
  `user_id` int(11) NOT NULL,
  `rate` double DEFAULT NULL,
  `review_avrg` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tutor`
--

INSERT INTO `tutor` (`user_id`, `rate`, `review_avrg`) VALUES
(5, NULL, NULL),
(8, NULL, NULL);

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
(5, '123', 'John', 'Smith', 'johnsmith', 'johnsmith@email.com', 1),
(6, '123', 'jane', 'doe', 'janedoe', 'janedoe@email.com', 2),
(7, '123', 'master', 'admin', 'masteradmin', 'masteradmin@email.com', 2),
(8, '123', 'jack', 'black', 'jack1', 'jackblack@yahoo.com', 1);

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
CREATE TRIGGER `update_admin` AFTER INSERT ON `user` FOR EACH ROW BEGIN
IF (NEW.is_tutor = 2) THEN
    	INSERT INTO admin (user_id) VALUES (NEW.user_id);
    END IF;
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
    	INSERT INTO tutor (user_id) VALUES (NEW.user_id);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_cart`
-- (See below for the actual view)
--
CREATE TABLE `user_cart` (
`user_id` int(11)
,`course_id` int(11)
,`course_name` text
,`course_num` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_courses_cart`
-- (See below for the actual view)
--
CREATE TABLE `user_courses_cart` (
`user_id` int(11)
,`course_id` int(11)
,`course_name` text
,`course_num` int(11)
,`course_desc` text
,`cart_id` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `user_table_with_paymentinfo`
-- (See below for the actual view)
--
CREATE TABLE `user_table_with_paymentinfo` (
`user_id` int(11)
,`payment_id` int(11)
,`user_fname` text
,`user_lname` text
,`username` text
,`card_type` text
,`card_num` text
,`CVV` text
,`zip_code` text
,`exp_date` date
);

-- --------------------------------------------------------

--
-- Structure for view `appointments_table_with_names`
--
DROP TABLE IF EXISTS `appointments_table_with_names`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `appointments_table_with_names`  AS SELECT `appointments`.`app_id` AS `app_id`, `courses`.`course_id` AS `course_id`, `courses`.`course_name` AS `course_name`, `appointments`.`tutor_id` AS `tutor_id`, `foo`.`username` AS `tutor_username`, `appointments`.`student_id` AS `student_id`, `bar`.`username` AS `student_username`, `appointments`.`appoint_date` AS `appoint_date`, `appointments`.`appoint_start_time` AS `appoint_start_time`, `appointments`.`appoint_end_time` AS `appoint_end_time`, `appointments`.`status` AS `status` FROM (((`appointments` join `user` `foo` on((`appointments`.`tutor_id` = `foo`.`user_id`))) join `user` `bar` on((`appointments`.`student_id` = `bar`.`user_id`))) join `courses` on((`appointments`.`course_id` = `courses`.`course_id`))) ORDER BY `appointments`.`tutor_id` ASC  ;

-- --------------------------------------------------------

--
-- Structure for view `reviews_table_with_names`
--
DROP TABLE IF EXISTS `reviews_table_with_names`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `reviews_table_with_names`  AS SELECT `reviews`.`review_id` AS `review_id`, `reviews`.`app_id` AS `app_id`, `reviews`.`user_id` AS `user_id`, `reviews`.`content` AS `content`, `reviews`.`num_stars` AS `num_stars`, `reviews`.`review_date_time` AS `review_date_time`, `appointments`.`tutor_id` AS `tutor_id`, `foo`.`user_fname` AS `tutor_fname`, `foo`.`user_lname` AS `tutor_lname`, `courses`.`course_name` AS `course_name` FROM (((`reviews` join `appointments` on((`reviews`.`app_id` = `appointments`.`app_id`))) join `courses` on((`courses`.`course_id` = `appointments`.`course_id`))) join `user` `foo` on((`appointments`.`tutor_id` = `foo`.`user_id`)))  ;

-- --------------------------------------------------------

--
-- Structure for view `user_cart`
--
DROP TABLE IF EXISTS `user_cart`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_cart`  AS SELECT `cart`.`user_id` AS `user_id`, `cart`.`course_id` AS `course_id`, `courses`.`course_name` AS `course_name`, `courses`.`course_num` AS `course_num` FROM (`cart` join `courses` on((`cart`.`course_id` = `courses`.`course_id`)))  ;

-- --------------------------------------------------------

--
-- Structure for view `user_courses_cart`
--
DROP TABLE IF EXISTS `user_courses_cart`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_courses_cart`  AS SELECT `user`.`user_id` AS `user_id`, `courses`.`course_id` AS `course_id`, `courses`.`course_name` AS `course_name`, `courses`.`course_num` AS `course_num`, `courses`.`course_desc` AS `course_desc`, `cart`.`cart_id` AS `cart_id` FROM ((`user` join `courses`) join `cart`) WHERE (`user`.`user_id` = `cart`.`user_id`) ORDER BY `user`.`user_id` ASC  ;

-- --------------------------------------------------------

--
-- Structure for view `user_table_with_paymentinfo`
--
DROP TABLE IF EXISTS `user_table_with_paymentinfo`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `user_table_with_paymentinfo`  AS SELECT `user`.`user_id` AS `user_id`, `payment_info`.`payment_id` AS `payment_id`, `user`.`user_fname` AS `user_fname`, `user`.`user_lname` AS `user_lname`, `user`.`username` AS `username`, `payment_info`.`card_type` AS `card_type`, `payment_info`.`card_num` AS `card_num`, `payment_info`.`CVV` AS `CVV`, `payment_info`.`zip_code` AS `zip_code`, `payment_info`.`exp_date` AS `exp_date` FROM (`user` join `payment_info`) WHERE (`user`.`user_id` = `payment_info`.`user_id`) ORDER BY `user`.`user_id` ASC  ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`app_id`),
  ADD KEY `appointments_ibfk_1` (`course_id`),
  ADD KEY `appointments_ibfk_2` (`tutor_id`),
  ADD KEY `appointments_ibfk_3` (`student_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD KEY `course_num` (`course_num`);

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
  ADD KEY `reviews_ibfk_2` (`user_id`);

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
  ADD KEY `index_username` (`username`(512)),
  ADD KEY `user_fname` (`user_fname`(255),`user_lname`(255));

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`tutor_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_3` FOREIGN KEY (`student_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `student` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
