-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 24, 2024 at 03:53 PM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `monitor_db`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `ArchiveData`$$
CREATE  PROCEDURE `ArchiveData` ()  BEGIN
    START TRANSACTION;

    -- Archive indicators
    INSERT INTO indicators_archive (
        id, indicator_title, definition, baseline, target, data_source, frequency, responsible, reporting, status, organization_id, created_at, updated_at
    )
    SELECT 
        i.id, i.indicator_title, i.definition, i.baseline, i.target, i.data_source, i.frequency, i.responsible, i.reporting, 'archived' AS status, i.organization_id, i.created_at, i.updated_at
    FROM 
        indicators i
    WHERE 
        i.status IN ('public', 'archived') 
        AND NOT EXISTS (
            SELECT 1 FROM responses r 
            WHERE r.indicator_id = i.id AND r.status IN ('draft', 'review')
        )
    ON DUPLICATE KEY UPDATE 
        indicator_title = VALUES(indicator_title), 
        definition = VALUES(definition), 
        baseline = VALUES(baseline), 
        target = VALUES(target), 
        data_source = VALUES(data_source), 
        frequency = VALUES(frequency), 
        responsible = VALUES(responsible), 
        reporting = VALUES(reporting), 
        status = VALUES(status),
        organization_id = VALUES(organization_id),
        created_at = VALUES(created_at), 
        updated_at = VALUES(updated_at);

    -- Archive responses
    INSERT INTO responses_archive (
        id, indicator_id, current, progress, notes, lessons, recommendations, files, status, organization_id, user_id, created_at
    )
    SELECT 
        r.id, r.indicator_id, r.current, r.progress, r.notes, r.lessons, r.recommendations, r.files, 'archived' AS status, r.organization_id, r.user_id, r.created_at
    FROM 
        responses r
    WHERE 
        r.status IN ('public', 'archived') 
        AND r.indicator_id IN (
            SELECT i.id
            FROM indicators i
            WHERE i.status IN ('public', 'archived') 
            AND NOT EXISTS (
                SELECT 1 FROM responses r2 
                WHERE r2.indicator_id = i.id AND r2.status IN ('draft', 'review')
            )
        )
    ON DUPLICATE KEY UPDATE 
        indicator_id = VALUES(indicator_id), 
        current = VALUES(current), 
        progress = VALUES(progress), 
        notes = VALUES(notes), 
        lessons = VALUES(lessons), 
        recommendations = VALUES(recommendations), 
        files = VALUES(files),
        status = VALUES(status), 
        organization_id = VALUES(organization_id),
        user_id = VALUES(user_id), 
        created_at = VALUES(created_at);

    -- Derived table for indicators to be deleted
    CREATE TEMPORARY TABLE tmp_indicators AS
    SELECT i.id
    FROM indicators i
    WHERE i.status IN ('public', 'archived')
    AND NOT EXISTS (
        SELECT 1 FROM responses r 
        WHERE r.indicator_id = i.id AND r.status IN ('draft', 'review')
    );

    -- Derived table for responses to be deleted
    CREATE TEMPORARY TABLE tmp_responses AS
    SELECT r.id
    FROM responses r
    WHERE r.status IN ('public', 'archived')
    AND r.indicator_id IN (
        SELECT i.id
        FROM indicators i
        WHERE i.status IN ('public', 'archived')
        AND NOT EXISTS (
            SELECT 1 FROM responses r2 
            WHERE r2.indicator_id = i.id AND r2.status IN ('draft', 'review')
        )
    );

    -- Delete archived responses
    DELETE FROM responses 
    WHERE id IN (SELECT id FROM tmp_responses);

    -- Delete archived indicators
    DELETE FROM indicators 
    WHERE id IN (SELECT id FROM tmp_indicators);

    DROP TEMPORARY TABLE tmp_responses;
    DROP TEMPORARY TABLE tmp_indicators;

    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `ArchiveOrganisationData`$$
CREATE PROCEDURE `ArchiveOrganisationData` (IN `organization_id` INT)  BEGIN
    START TRANSACTION;

    -- Archive indicators
    INSERT INTO indicators_archive (
        id, indicator_title, definition, baseline, target, data_source, frequency, responsible, reporting, status, organization_id, created_at, updated_at
    )
    SELECT 
        i.id, i.indicator_title, i.definition, i.baseline, i.target, i.data_source, i.frequency, i.responsible, i.reporting, 'archived' AS status, i.organization_id, i.created_at, i.updated_at
    FROM 
        indicators i
    WHERE 
        i.organization_id = organization_id
        AND i.status IN ('public', 'archived') 
        AND NOT EXISTS (
            SELECT 1 FROM responses r 
            WHERE r.indicator_id = i.id AND r.status IN ('draft', 'review')
        )
    ON DUPLICATE KEY UPDATE 
        indicator_title = VALUES(indicator_title), 
        definition = VALUES(definition), 
        baseline = VALUES(baseline), 
        target = VALUES(target), 
        data_source = VALUES(data_source), 
        frequency = VALUES(frequency), 
        responsible = VALUES(responsible), 
        reporting = VALUES(reporting), 
        status = VALUES(status),
        organization_id = VALUES(organization_id),
        created_at = VALUES(created_at), 
        updated_at = VALUES(updated_at);

    -- Archive responses
    INSERT INTO responses_archive (
        id, indicator_id, current, progress, notes, lessons, recommendations, files, status, organization_id, user_id, created_at
    )
    SELECT 
        r.id, r.indicator_id, r.current, r.progress, r.notes, r.lessons, r.recommendations, r.files, 'archived' AS status, r.organization_id, r.user_id, r.created_at
    FROM 
        responses r
    WHERE 
        r.organization_id = organization_id
        AND r.status IN ('public', 'archived') 
        AND r.indicator_id IN (
            SELECT i.id
            FROM indicators i
            WHERE i.organization_id = organization_id
            AND i.status IN ('public', 'archived') 
            AND NOT EXISTS (
                SELECT 1 FROM responses r2 
                WHERE r2.indicator_id = i.id AND r2.status IN ('draft', 'review')
            )
        )
    ON DUPLICATE KEY UPDATE 
        indicator_id = VALUES(indicator_id), 
        current = VALUES(current), 
        progress = VALUES(progress), 
        notes = VALUES(notes), 
        lessons = VALUES(lessons), 
        recommendations = VALUES(recommendations), 
        files = VALUES(files),
        status = VALUES(status), 
        organization_id = VALUES(organization_id),
        user_id = VALUES(user_id), 
        created_at = VALUES(created_at);

    -- Derived table for indicators to be deleted
    CREATE TEMPORARY TABLE tmp_indicators AS
    SELECT i.id
    FROM indicators i
    WHERE i.organization_id = organization_id
    AND i.status IN ('public', 'archived')
    AND NOT EXISTS (
        SELECT 1 FROM responses r 
        WHERE r.indicator_id = i.id AND r.status IN ('draft', 'review')
    );

    -- Derived table for responses to be deleted
    CREATE TEMPORARY TABLE tmp_responses AS
    SELECT r.id
    FROM responses r
    WHERE r.organization_id = organization_id
    AND r.status IN ('public', 'archived')
    AND r.indicator_id IN (
        SELECT i.id
        FROM indicators i
        WHERE i.organization_id = organization_id
        AND i.status IN ('public', 'archived')
        AND NOT EXISTS (
            SELECT 1 FROM responses r2 
            WHERE r2.indicator_id = i.id AND r2.status IN ('draft', 'review')
        )
    );

    -- Delete archived responses
    DELETE FROM responses 
    WHERE id IN (SELECT id FROM tmp_responses);

    -- Delete archived indicators
    DELETE FROM indicators 
    WHERE id IN (SELECT id FROM tmp_indicators);

    DROP TEMPORARY TABLE tmp_responses;
    DROP TEMPORARY TABLE tmp_indicators;

    COMMIT;
END$$

DROP PROCEDURE IF EXISTS `GetAllArchivedResponses`$$
CREATE PROCEDURE `GetAllArchivedResponses` (IN `organization_id` INT)  BEGIN
    -- Initialize session variables
    SET @row_number := 0;
    SET @indicator_id := NULL;

    -- Query to join tables and calculate row numbers with organization_id filtering
    SELECT 
        response_number.*,
        indicators_archive.indicator_title,
        indicators_archive.baseline,
        indicators_archive.target,
        user_profile.name,
        CONCAT('Response ', response_number.response_tag) AS response_tag_label
    FROM 
        (
            SELECT 
                responses_archive.*,
                -- Calculate row number for each indicator_id partition
                @row_number := IF(@indicator_id = responses_archive.indicator_id, @row_number + 1, 1) AS response_tag,
                @indicator_id := responses_archive.indicator_id
            FROM 
                responses_archive
            -- This join initializes the session variables before processing the main query
            JOIN 
                (SELECT @row_number := 0, @indicator_id := NULL) AS vars
            WHERE 
                responses_archive.organization_id = organization_id
            ORDER BY 
                responses_archive.indicator_id, responses_archive.created_at
        ) AS response_number
    JOIN 
        indicators_archive ON indicators_archive.id = response_number.indicator_id
    JOIN 
        user_profile ON user_profile.user_id = response_number.user_id
    ORDER BY 
        response_number.indicator_id, response_number.user_id, response_number.created_at;
END$$

DROP PROCEDURE IF EXISTS `GetIndicatorArchivedResponses`$$
CREATE PROCEDURE `GetIndicatorArchivedResponses` (IN `input_indicator_id` INT)  BEGIN
    -- Initialize session variables
    SET @row_number := 0;
    SET @user_id := NULL;

    -- Query to join tables and calculate row numbers
    SELECT 
        response_number.*,
        indicators_archive.indicator_title,
        indicators_archive.baseline,
        indicators_archive.target,
        user_profile.name,
        CONCAT('Response ', response_number.response_tag) AS response_tag_label
    FROM 
        (
            SELECT 
                responses_archive.*,
                -- Calculate row number for each user_id partition
                @row_number := IF(@user_id = responses_archive.user_id, @row_number + 1, 1) AS response_tag,
                @user_id := responses_archive.user_id
            FROM 
                responses_archive
            -- This join initializes the session variables before processing the main query
            JOIN 
                (SELECT @row_number := 0, @user_id := NULL) AS vars
            WHERE 
                responses_archive.indicator_id = input_indicator_id
            ORDER BY 
                responses_archive.user_id, responses_archive.created_at
        ) AS response_number
    JOIN 
        indicators_archive ON indicators_archive.id = response_number.indicator_id
    JOIN 
        user_profile ON user_profile.user_id = response_number.user_id
    ORDER BY 
        response_number.user_id, response_number.created_at;
END$$

DROP PROCEDURE IF EXISTS `GetIndicatorResponses`$$
CREATE PROCEDURE `GetIndicatorResponses` (IN `input_indicator_id` INT)  BEGIN
    -- Initialize session variables
    SET @row_number := 0;
    SET @user_id := NULL;

    -- Query to join tables and calculate row numbers
    SELECT 
        response_number.*,
        indicators.indicator_title,
        indicators.baseline,
        indicators.target,
        user_profile.name,
        CONCAT('Response ', response_number.response_tag) AS response_tag_label
    FROM 
        (
            SELECT 
                responses.*,
                -- Calculate row number for each user_id partition
                @row_number := IF(@user_id = responses.user_id, @row_number + 1, 1) AS response_tag,
                @user_id := responses.user_id
            FROM 
                responses
            -- This join initializes the session variables before processing the main query
            JOIN 
                (SELECT @row_number := 0, @user_id := NULL) AS vars
            WHERE 
                responses.indicator_id = input_indicator_id
            ORDER BY 
                responses.user_id, responses.created_at
        ) AS response_number
    JOIN 
        indicators ON indicators.id = response_number.indicator_id
    JOIN 
        user_profile ON user_profile.user_id = response_number.user_id
    ORDER BY 
        response_number.user_id, response_number.created_at;
END$$

DROP PROCEDURE IF EXISTS `GetResponses`$$
CREATE PROCEDURE `GetResponses` (IN `organization_id` INT)  BEGIN
    -- Initialize session variables
    SET @row_number := 0;
    SET @indicator_id := NULL;

    -- Query to join tables and calculate row numbers with organization_id filtering
    SELECT 
        response_number.*,
        indicators.indicator_title,
        indicators.baseline,
        indicators.target,
        user_profile.name,
        CONCAT('Response ', response_number.response_tag) AS response_tag_label
    FROM 
        (
            SELECT 
                responses.*,
                -- Calculate row number for each indicator_id partition
                @row_number := IF(@indicator_id = responses.indicator_id, @row_number + 1, 1) AS response_tag,
                @indicator_id := responses.indicator_id
            FROM 
                responses
            -- This join initializes the session variables before processing the main query
            JOIN 
                (SELECT @row_number := 0, @indicator_id := NULL) AS vars
            WHERE 
                responses.organization_id = organization_id
            ORDER BY 
                responses.indicator_id, responses.created_at
        ) AS response_number
    JOIN 
        indicators ON indicators.id = response_number.indicator_id
    JOIN 
        user_profile ON user_profile.user_id = response_number.user_id
    ORDER BY 
        response_number.indicator_id, response_number.user_id, response_number.created_at;
END$$

DROP PROCEDURE IF EXISTS `GetUserArchivedResponses`$$
CREATE PROCEDURE `GetUserArchivedResponses` (IN `input_user_id` INT)  BEGIN
    -- Initialize session variables
    SET @row_number := 0;
    SET @indicator_id := NULL;

    -- Query to join tables and calculate row numbers
    SELECT 
        response_number.*,
        indicators_archive.indicator_title,
        indicators_archive.baseline,
        indicators_archive.target,
        user_profile.name,
        CONCAT('Response ', response_number.response_tag) AS response_tag_label
    FROM 
        (
            SELECT 
                responses_archive.*,
                -- Calculate row number for each indicator_id partition
                @row_number := IF(@indicator_id = responses_archive.indicator_id, @row_number + 1, 1) AS response_tag,
                @indicator_id := responses_archive.indicator_id
            FROM 
                responses_archive
            -- This join initializes the session variables before processing the main query
            JOIN 
                (SELECT @row_number := 0, @indicator_id := NULL) AS vars
            WHERE 
                responses_archive.user_id = input_user_id
            ORDER BY 
                responses_archive.indicator_id, responses_archive.created_at
        ) AS response_number
    JOIN 
        indicators_archive ON indicators_archive.id = response_number.indicator_id
    JOIN 
        user_profile ON user_profile.user_id = response_number.user_id
    ORDER BY 
        response_number.indicator_id, response_number.user_id, response_number.created_at;
END$$

DROP PROCEDURE IF EXISTS `GetUserResponses`$$
CREATE PROCEDURE `GetUserResponses` (IN `input_user_id` INT)  BEGIN
    -- Initialize session variables
    SET @row_number := 0;
    SET @indicator_id := NULL;

    -- Query to join tables and calculate row numbers
    SELECT 
        response_number.*,
        indicators.indicator_title,
        indicators.baseline,
        indicators.target,
        user_profile.name,
        CONCAT('Response ', response_number.response_tag) AS response_tag_label
    FROM 
        (
            SELECT 
                responses.*,
                -- Calculate row number for each indicator_id partition
                @row_number := IF(@indicator_id = responses.indicator_id, @row_number + 1, 1) AS response_tag,
                @indicator_id := responses.indicator_id
            FROM 
                responses
            -- This join initializes the session variables before processing the main query
            JOIN 
                (SELECT @row_number := 0, @indicator_id := NULL) AS vars
            WHERE 
                responses.user_id = input_user_id
            ORDER BY 
                responses.indicator_id, responses.created_at
        ) AS response_number
    JOIN 
        indicators ON indicators.id = response_number.indicator_id
    JOIN 
        user_profile ON user_profile.user_id = response_number.user_id
    ORDER BY 
        response_number.indicator_id, response_number.user_id, response_number.created_at;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `app_users`
--

DROP TABLE IF EXISTS `app_users`;
CREATE TABLE IF NOT EXISTS `app_users` (
  `id` int(250) NOT NULL AUTO_INCREMENT,
  `username` varchar(250) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(250) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'User',
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `email_confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `profile_created` tinyint(1) NOT NULL DEFAULT '0',
  `organization_id` int(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_users`
--

INSERT INTO `app_users` (`id`, `username`, `email`, `password`, `role`, `approved`, `email_confirmed`, `profile_created`, `organization_id`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'muherezajoel40@gmail.com', '$2y$10$RDnmmofYj9kr./CgO1zWfuK0WUL6M6xLTx3x0gJaGo6.MRGJBiylC', 'Administrator', 0, 0, 1, 1, '2024-06-24 15:41:07', '2024-06-24 15:47:45');

-- --------------------------------------------------------

--
-- Table structure for table `confirm_email_codes`
--

DROP TABLE IF EXISTS `confirm_email_codes`;
CREATE TABLE IF NOT EXISTS `confirm_email_codes` (
  `id` int(250) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `otp` varchar(6) NOT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `indicators`
--

DROP TABLE IF EXISTS `indicators`;
CREATE TABLE IF NOT EXISTS `indicators` (
  `id` int(250) NOT NULL AUTO_INCREMENT,
  `indicator_title` text NOT NULL,
  `definition` text NOT NULL,
  `baseline` varchar(250) DEFAULT NULL,
  `target` varchar(250) DEFAULT NULL,
  `data_source` text NOT NULL,
  `frequency` varchar(11) NOT NULL,
  `responsible` text NOT NULL,
  `reporting` text NOT NULL,
  `status` enum('draft','review','public','archived') NOT NULL DEFAULT 'draft',
  `organization_id` int(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `indicators_archive`
--

DROP TABLE IF EXISTS `indicators_archive`;
CREATE TABLE IF NOT EXISTS `indicators_archive` (
  `id` int(250) NOT NULL,
  `indicator_title` text NOT NULL,
  `definition` text NOT NULL,
  `baseline` varchar(250) DEFAULT NULL,
  `target` varchar(250) DEFAULT NULL,
  `data_source` text NOT NULL,
  `frequency` varchar(11) NOT NULL,
  `responsible` text NOT NULL,
  `reporting` text NOT NULL,
  `status` enum('draft','review','public','archived') NOT NULL,
  `organization_id` int(250) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `organizations`
--

DROP TABLE IF EXISTS `organizations`;
CREATE TABLE IF NOT EXISTS `organizations` (
  `id` int(250) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `logo` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `organizations`
--

INSERT INTO `organizations` (`id`, `name`, `logo`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', NULL, '2024-06-24 15:37:59', '2024-06-24 15:37:59'),
(2, 'Sunbird AI', 'http://localhost/monitor/uploads/images/66799576902f2.png', '2024-06-24 15:49:20', '2024-06-24 15:49:20'),
(3, 'Open Data Analytics', 'http://localhost/monitor/uploads/images/6679958b5c1ce.png', '2024-06-24 15:49:39', '2024-06-24 15:49:39'),
(4, 'UN Global Pulse', 'http://localhost/monitor/uploads/images/6679959f4ec27.png', '2024-06-24 15:49:58', '2024-06-24 15:49:58');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

DROP TABLE IF EXISTS `reports`;
CREATE TABLE IF NOT EXISTS `reports` (
  `id` int(250) NOT NULL AUTO_INCREMENT,
  `indicator_id` int(250) NOT NULL,
  `organization_id` int(250) NOT NULL,
  `report_data` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `generated_by` int(250) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `indicator_id` (`indicator_id`),
  KEY `organization_id` (`organization_id`),
  KEY `generated_by` (`generated_by`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `responses`
--

DROP TABLE IF EXISTS `responses`;
CREATE TABLE IF NOT EXISTS `responses` (
  `id` int(250) NOT NULL AUTO_INCREMENT,
  `indicator_id` int(250) NOT NULL,
  `current` int(20) NOT NULL,
  `progress` decimal(10,2) NOT NULL,
  `notes` text NOT NULL,
  `lessons` text NOT NULL,
  `recommendations` text NOT NULL,
  `files` json DEFAULT NULL,
  `status` enum('draft','review','public','archived') NOT NULL DEFAULT 'draft',
  `organization_id` int(250) NOT NULL,
  `user_id` int(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `indicator_id` (`indicator_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `responses_archive`
--

DROP TABLE IF EXISTS `responses_archive`;
CREATE TABLE IF NOT EXISTS `responses_archive` (
  `id` int(250) NOT NULL,
  `indicator_id` int(250) NOT NULL,
  `current` int(20) NOT NULL,
  `progress` decimal(10,2) NOT NULL,
  `notes` text NOT NULL,
  `lessons` text NOT NULL,
  `recommendations` text NOT NULL,
  `files` json DEFAULT NULL,
  `status` enum('draft','review','public','archived') NOT NULL,
  `organization_id` int(250) NOT NULL,
  `user_id` int(250) NOT NULL,
  `created_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `indicator_id` (`indicator_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

DROP TABLE IF EXISTS `user_profile`;
CREATE TABLE IF NOT EXISTS `user_profile` (
  `id` int(250) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `nin` varchar(100) NOT NULL,
  `dob` date NOT NULL,
  `gender` varchar(10) NOT NULL,
  `about` text,
  `company` varchar(100) DEFAULT NULL,
  `job` varchar(100) DEFAULT NULL,
  `country` varchar(50) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `image_url` text NOT NULL,
  `district` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `organization_id` int(250) NOT NULL,
  `village` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nin` (`nin`),
  KEY `user_id` (`user_id`),
  KEY `user_profile_ibfk_1` (`organization_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`id`, `name`, `nin`, `dob`, `gender`, `about`, `company`, `job`, `country`, `phone`, `image_url`, `district`, `user_id`, `organization_id`, `village`, `created_at`, `updated_at`) VALUES
(1, 'Muhereza Joel', 'CM2301000FLSAD', '1998-12-14', 'male', 'I am a passionate, confident and result oriented software developer who loves to build software for the world to use.', 'Alinare Research and Innovation', 'Senior Software engineer and Tech Consultant', 'Uganda', '0764165464', 'http://localhost/monitor/uploads/images/66799487d25af.jpg', 'Kabarole', 1, 1, 'Kibimba', '2024-06-24 18:47:45', '2024-06-24 18:47:45');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `confirm_email_codes`
--
ALTER TABLE `confirm_email_codes`
  ADD CONSTRAINT `confirm_email_codes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `app_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`indicator_id`) REFERENCES `indicators` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reports_ibfk_2` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reports_ibfk_3` FOREIGN KEY (`generated_by`) REFERENCES `app_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `responses`
--
ALTER TABLE `responses`
  ADD CONSTRAINT `responses_ibfk_1` FOREIGN KEY (`indicator_id`) REFERENCES `indicators` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `user_profile_ibfk_1` FOREIGN KEY (`organization_id`) REFERENCES `organizations` (`id`);

DELIMITER $$
--
-- Events
--
DROP EVENT IF EXISTS `archive_event`$$
CREATE EVENT `archive_event` ON SCHEDULE EVERY 1 MONTH STARTS '2024-06-19 11:53:06' ON COMPLETION NOT PRESERVE ENABLE DO CALL Archive_Data()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
