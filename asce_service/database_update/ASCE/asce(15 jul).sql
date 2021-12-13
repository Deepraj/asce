-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2015 at 08:56 AM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `asce`
--

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `token` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(40) COLLATE utf8_bin NOT NULL,
  `login` varchar(50) COLLATE utf8_bin NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_book`
--

CREATE TABLE IF NOT EXISTS `m_book` (
  `m_bokid` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Book Identification',
  `m_bokisbn` varchar(15) NOT NULL COMMENT 'Book ISBN Number',
  `m_bokname` varchar(400) DEFAULT NULL COMMENT 'Book Name',
  `m_bokdesc` varchar(400) DEFAULT NULL COMMENT 'Book Description',
  `m_createdbyuser` varchar(255) NOT NULL,
  `m_updatedbyuser` varchar(255) NOT NULL,
  `m_createddate` datetime NOT NULL,
  `m_updateddate` datetime NOT NULL,
  PRIMARY KEY (`m_bokid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_chapter`
--

CREATE TABLE IF NOT EXISTS `m_chapter` (
  `m_chpid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Book Chapter Identification',
  `m_chpbokvid` smallint(5) unsigned NOT NULL COMMENT 'Book volume Identification',
  `m_chplabel` varchar(255) DEFAULT NULL COMMENT 'Book Chapter Label',
  `m_chptitle` varchar(255) NOT NULL COMMENT 'Book Chapter title',
  `m_chlinkpage` int(11) NOT NULL COMMENT 'Book Link Page',
  `m_chpseqorder` tinyint(3) unsigned NOT NULL COMMENT 'Chapter Sequence No. The chapters will be display based on this no. but no need to display this number',
  `m_chpisreqfilter` bit(20) NOT NULL COMMENT 'Book chapter filter',
  `m_chplinkpage` smallint(5) unsigned NOT NULL COMMENT 'Book Sub chapter Begin Page Number',
  `m_createdbyuser` varchar(255) NOT NULL,
  `m_updatedbyuser` varchar(255) NOT NULL,
  `m_createddate` datetime NOT NULL,
  `m_updateddate` datetime NOT NULL,
  PRIMARY KEY (`m_chpid`),
  KEY `m_chpbokvid` (`m_chpbokvid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_language`
--

CREATE TABLE IF NOT EXISTS `m_language` (
  `m_lanid` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Language Identification',
  `m_lanname` varchar(30) DEFAULT NULL COMMENT 'Language name',
  PRIMARY KEY (`m_lanid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_page`
--

CREATE TABLE IF NOT EXISTS `m_page` (
  `m_pgeid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Book Pages Identification',
  `m_pgevolid` smallint(5) unsigned NOT NULL COMMENT 'Book volume Identification',
  `m_pgeschid` mediumint(8) unsigned NOT NULL COMMENT 'Book subchapter id',
  `m_pageseqno` int(11) NOT NULL,
  `m_pagefileno` int(11) NOT NULL,
  `m_pgecustomlabel` varchar(10) DEFAULT NULL COMMENT 'Page no given by user',
  `m_pgeseqorder` smallint(5) unsigned NOT NULL COMMENT 'Page Sequence number',
  `m_pgeshowinteractivity` tinyint(3) unsigned DEFAULT NULL COMMENT 'page interactivity''s(111)',
  PRIMARY KEY (`m_pgeid`),
  UNIQUE KEY `m_pgevolid` (`m_pgevolid`),
  UNIQUE KEY `m_pgeschid` (`m_pgeschid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_role`
--

CREATE TABLE IF NOT EXISTS `m_role` (
  `m_rolid` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'User role Identification',
  `m_rolname` varchar(400) DEFAULT NULL COMMENT 'Role Name',
  PRIMARY KEY (`m_rolid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_section`
--

CREATE TABLE IF NOT EXISTS `m_section` (
  `m_sechid` mediumint(9) NOT NULL AUTO_INCREMENT COMMENT 'Book Sub Chapter Identification',
  `m_secbokcid` mediumint(8) unsigned NOT NULL COMMENT 'Book Chapter Identification',
  `m_seclabel` varchar(255) DEFAULT NULL COMMENT 'Book Sub Chapter Label',
  `m_sectitle` varchar(255) NOT NULL,
  `m_seclevel` int(11) NOT NULL,
  `m_secmasterid` int(11) NOT NULL,
  `m_secseqorder` tinyint(3) unsigned NOT NULL COMMENT 'Subchapter Sequence Number',
  `m_seclinkpage` mediumint(9) DEFAULT NULL COMMENT 'Book Sub chapter link Page Sequence Number',
  `m_createdbyuser` varchar(255) NOT NULL,
  `m_updatedbyuser` varchar(255) NOT NULL,
  `m_createddate` datetime NOT NULL,
  `m_updateddate` datetime NOT NULL,
  `m_secisreqfilter` bit(20) NOT NULL COMMENT 'Book sub chapter filter',
  `m_secisintend` bit(20) NOT NULL COMMENT 'if the sub chapter is belongs to 4th level then True.',
  PRIMARY KEY (`m_sechid`),
  KEY `m_secbokcid` (`m_secbokcid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=621 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_user`
--

CREATE TABLE IF NOT EXISTS `m_user` (
  `m_usrid` mediumint(9) NOT NULL AUTO_INCREMENT COMMENT 'User Identification',
  `m_usrwebid` mediumint(8) unsigned NOT NULL COMMENT 'User Web ID receive from primary source',
  `m_usrroleid` tinyint(3) unsigned NOT NULL COMMENT 'User Role Identification',
  `m_username` varchar(50) NOT NULL COMMENT 'Username',
  `m_password` varchar(50) NOT NULL COMMENT 'Password',
  `m_token` varchar(255) NOT NULL,
  `m_activated` int(11) NOT NULL,
  `m_banned` int(11) NOT NULL,
  `m_ban_reason` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `m_new_password_key` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `m_new_password_requested` datetime DEFAULT NULL,
  `m_usrfirstname` varchar(256) DEFAULT NULL COMMENT 'User first name',
  `m_usrlastname` varchar(256) DEFAULT NULL COMMENT 'User last name',
  `m_usrimglink` varchar(256) DEFAULT NULL COMMENT 'User profile image',
  `m_usraddress` varchar(256) DEFAULT NULL COMMENT 'User address',
  `m_usremailid` varchar(256) DEFAULT NULL COMMENT 'User email identification',
  `m_new_email` varchar(100) DEFAULT NULL,
  `m_new_email_key` varchar(50) DEFAULT NULL,
  `m_last_ip` varchar(50) DEFAULT NULL,
  `m_last_login` datetime NOT NULL,
  `m_created` datetime NOT NULL,
  `m_updated` datetime NOT NULL,
  `m_usrzipcode` varchar(10) DEFAULT NULL COMMENT 'User zipcode',
  `m_usrtown` varchar(256) NOT NULL COMMENT 'User town',
  `m_usrprovid` tinyint(3) unsigned NOT NULL COMMENT 'User province identification',
  `m_usrlastvisiteddate` datetime NOT NULL COMMENT 'User last visited time',
  `m_usrsessionid` varchar(256) NOT NULL,
  `m_usrlastaccbookid` mediumint(8) unsigned NOT NULL COMMENT 'User last access book identification ',
  PRIMARY KEY (`m_usrid`),
  KEY `m_usrroleid` (`m_usrroleid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `m_volume`
--

CREATE TABLE IF NOT EXISTS `m_volume` (
  `m_volid` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Book volume Identification',
  `m_volbokid` smallint(5) unsigned NOT NULL COMMENT 'Book Identification ',
  `m_volseqno` tinyint(3) unsigned NOT NULL COMMENT 'Book volume number',
  `m_volpageid` int(11) NOT NULL,
  `m_voltitle` varchar(100) DEFAULT NULL COMMENT 'Book volume title',
  `m_volsubtitle` varchar(100) DEFAULT NULL COMMENT 'Book voulme subtitle',
  `m_volimgsize` varchar(15) DEFAULT NULL COMMENT 'Book swf size',
  `m_volimgpath` varchar(100) DEFAULT NULL COMMENT 'Book thumbnail image',
  `m_vollangid` tinyint(4) NOT NULL COMMENT 'Book language',
  `m_volauthor` varchar(250) DEFAULT NULL COMMENT 'Book author name',
  `m_volauthdesc` varchar(500) DEFAULT NULL COMMENT 'Book author description',
  PRIMARY KEY (`m_volid`),
  KEY `m_vollangid` (`m_vollangid`),
  KEY `m_volbokid` (`m_volbokid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `t_bookmark`
--

CREATE TABLE IF NOT EXISTS `t_bookmark` (
  `t_bmkid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Bookmark Identification',
  `t_bmktitle` varchar(30) DEFAULT NULL COMMENT 'Bookmark title',
  `t_bmkvolid` smallint(5) unsigned NOT NULL COMMENT 'Book volume Identification',
  `t_bmkusrid` mediumint(8) unsigned NOT NULL COMMENT 'User identification',
  `t_bmkpage` smallint(5) unsigned NOT NULL COMMENT 'Book page identification',
  `t_bmkcreateddate` datetime NOT NULL COMMENT 'Bookmark created date',
  `t_bmkupdateddate` datetime NOT NULL COMMENT 'Bookmark updated date',
  PRIMARY KEY (`t_bmkid`),
  UNIQUE KEY `t_bmkvolid` (`t_bmkvolid`),
  UNIQUE KEY `t_bmkusrid` (`t_bmkusrid`),
  UNIQUE KEY `t_bmkpage` (`t_bmkpage`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `m_usrwebid` int(11) NOT NULL,
  `m_usrroleid` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `m_usrfirstname` varchar(255) COLLATE utf8_bin NOT NULL,
  `m_usrlastname` varchar(255) COLLATE utf8_bin NOT NULL,
  `m_usraddress` varchar(256) COLLATE utf8_bin NOT NULL,
  `token` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '1',
  `m_usrlastaccbookid` int(11) NOT NULL,
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `new_password_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `new_password_requested` datetime DEFAULT NULL,
  `new_email` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `new_email_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `m_usrzipcode` varchar(255) COLLATE utf8_bin NOT NULL,
  `m_usrtown` varchar(256) COLLATE utf8_bin NOT NULL,
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_autologin`
--

CREATE TABLE IF NOT EXISTS `user_autologin` (
  `key_id` char(32) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`key_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE IF NOT EXISTS `user_profiles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `country` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `m_chapter`
--
ALTER TABLE `m_chapter`
  ADD CONSTRAINT `m_chapter_ibfk_1` FOREIGN KEY (`m_chpbokvid`) REFERENCES `m_volume` (`m_volid`);

--
-- Constraints for table `m_page`
--
ALTER TABLE `m_page`
  ADD CONSTRAINT `m_page_ibfk_1` FOREIGN KEY (`m_pgevolid`) REFERENCES `m_volume` (`m_volid`);

--
-- Constraints for table `m_section`
--
ALTER TABLE `m_section`
  ADD CONSTRAINT `m_section_ibfk_1` FOREIGN KEY (`m_secbokcid`) REFERENCES `m_chapter` (`m_chpid`);

--
-- Constraints for table `m_volume`
--
ALTER TABLE `m_volume`
  ADD CONSTRAINT `m_volume_ibfk_1` FOREIGN KEY (`m_volbokid`) REFERENCES `m_book` (`m_bokid`);

--
-- Constraints for table `t_bookmark`
--
ALTER TABLE `t_bookmark`
  ADD CONSTRAINT `t_bookmark_ibfk_1` FOREIGN KEY (`t_bmkvolid`) REFERENCES `m_volume` (`m_volid`),
  ADD CONSTRAINT `t_bookmark_ibfk_2` FOREIGN KEY (`t_bmkpage`) REFERENCES `m_book` (`m_bokid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
