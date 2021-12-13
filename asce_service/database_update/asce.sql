-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2015 at 10:44 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  `token` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`, `token`) VALUES
('02c87afe42151299668cf9f3686dc9a58429f80f', '::1', 1436257080, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363235373038303b, '149b1665eef00e14c276d024d4cc7aad'),
('086fb6cd562d1a64824607194b9663033c4b0cb0', '::1', 1436179834, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363137393739373b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, 'cd1be9c7c5c9731df442494897d87930'),
('0e8b0c767f33d5f6b0d38707be9038c0d09f5654', '::1', 1436189488, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363138393138383b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, '9afb6f375041c7c3f88e909a12baf860'),
('1644ccbe64c8159c21ff0aa4af340551c6ca4b59', '::1', 1436249095, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363234383931373b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, 'c02b0ba80704b75e7a1727ef810fcabd'),
('22458c3da7fda8782626fe898edc4714d76c4a0a', '::1', 1436180410, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363138303134313b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, 'f601868ffd315abe5e6a37cff60bea23'),
('22b0b7a01b2a6e019ea819aac6c35be3810a6088', '::1', 1436185305, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363138353035363b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, '986b83d978dd4b1ca1e31b84213b76dd'),
('2675a0a39d6bc995597183e268cb041300e495ad', '::1', 1436179690, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363137393339343b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, '1b1beeb25d2c804d43035b7051a4f011'),
('2e4dc789a6852f34b37edf46f776f8c72f41801e', '::1', 1436184545, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363138343237373b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, 'f8999313ea39ebb6b579dacf042e6960'),
('3028af326eadaa59d490662ce0bef8290f7fcf9d', '::1', 1436187773, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363138373636343b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, '6856a2071ea638a0b88cadfd6e1792ba'),
('32f80126f35b25d5161603152b79b268f0cf9e6d', '::1', 1436257360, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363235373336303b, '72629b09675611a92fcc8728e6166852'),
('3d7902f044b5b82cda128167d71107fdb7b23864', '::1', 1436258659, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363235383531393b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, ''),
('3f229cbce1eeff3a19fc29decd8a7aed3d90d14f', '::1', 1436176288, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363137363238383b6d6573736167657c733a38343a22596f752068617665207375636365737366756c6c7920726567697374657265642e20436865636b20796f757220656d61696c206164647265737320746f20616374697661746520796f7572206163636f756e742e223b5f5f63695f766172737c613a313a7b733a373a226d657373616765223b733a333a226f6c64223b7d, '47d743c8db82b77de7bc9e145f187e3b'),
('3fcc7eb824f372d55a04774284dee8d972b793c0', '::1', 1436191057, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363139313035373b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, 'dd60db1e483b0f85215a5b05db8be351'),
('46021eacd81d13bb36266a21823cc3e94d3f8e1b', '::1', 1436178737, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363137383532353b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, '4a6771ea6fe7b6ca4b239b0dd27ae7f6'),
('573d8ebb32387f9f3651c9f548926b586164a09f', '::1', 1436257142, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363235373134323b, '435c43463dc95b3434e477d2ec60af65'),
('5e4ffdcb385d57470cea6a0ae7b720c143cb638e', '::1', 1436184855, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363138343539303b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, 'ef68b7026a745280c49240401dd824df'),
('6048aa4bca1b37c0d48f1e386376602fec3bf203', '::1', 1436190613, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363139303336343b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, '1339c8aef6175aaed75651c84124c745'),
('609c060e9fa6de4265b7a1eb6a872acc7becd506', '::1', 1436183102, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363138323830393b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, '51c672b6941718ddf8f98e762787c2ad'),
('6aa3a8dd1b3ea816b58ff0e60ef152e623293241', '::1', 1436178467, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363137383435393b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2230223b, 'a1fa79430307328b76999ec4b373bed0'),
('6bad3507cfd91eb42dd4c7b3dc9e3faac9966dd5', '::1', 1436185463, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363138353435353b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, 'f1009713b9e78b2053c34927d0e13907'),
('90842dc9ec02809c9d789b8972ddf67e66215a93', '::1', 1436178497, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363137383438363b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2230223b, '603bb736987d111e7865bdbcc9714705'),
('91b0438835382f1ed7d4f664fe4be2f469c4d0a7', '::1', 1436186880, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363138363634393b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, '29ba54b81bb096b9dd6d2a584c52a907'),
('9990f50ae4fc054d67dc8943abe02af2ff33cb86', '::1', 1436182329, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363138323038383b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, '835412910f9d5bcce91e94079eb78a3c'),
('9d7be6305d20dd1b56a49359ad872415e2d2efd3', '::1', 1436181819, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363138313531393b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, '72acc5f8be6292d28b5dd5b6d5af9560'),
('9debc88a5a0eec1c805279880a060b3bafb8f5cb', '::1', 1436189762, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363138393533333b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, '3e4357c71ac012730dc356bb1008cfa4'),
('a9a02baf1b9abe6502f68ecd7cb10ef27843b2f6', '::1', 1436182767, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363138323436373b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, 'ab0b2b45184531949a907da45438b9a7'),
('a9d97de8cd7b26d1ea9ef49253673a65c2445f07', '::1', 1436186493, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363138363230363b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, '354e4271fab3c0e98d9024775fe96899'),
('abcc840b786bb8004eaca512b0ace4156c90a6df', '::1', 1436180692, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363138303435303b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, 'bfa55a35afee7e52664873ec817823a5'),
('afe719a9f4051fa423748ce153e0cadbb4f36f17', '::1', 1436181326, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363138313134343b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, 'f56c5e7197cfec9dabfa6772ddf258d2'),
('b4e26a877db2d0561505400bbac781bc45082574', '::1', 1436189094, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363138383833333b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, 'e5e7ef8dd9c3faec71a35c7505765417'),
('bf095ce0e390d716c039ff6a3f4bfe4c307365b0', '::1', 1436248667, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363234383431393b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, 'a2ee3220623823419fc76bca72e827e3'),
('cf5d59921df73c723e173e92c8b84f4f86ac714d', '::1', 1436190908, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363139303636383b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, 'cc4547ed119be7c3841eaf4affb23191'),
('d1238d6670ee92431ae52981cc618c6cf7e96835', '::1', 1436188460, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363138383137373b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, '6bb6802016430255e49dd3ee47407c65'),
('df4ef560a797c6e604a522dd2031f9058d354680', '::1', 1436190260, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363138393936393b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, '2edcafb8030cfdabea65ac4b9e908953'),
('dfdc841b898cbfd9326314cea0c45aa2c546d8f0', '::1', 1436179296, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363137393032313b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, '13fa1c20635c18c2927526b97b2d14c2'),
('ed6c0294dd1f354574e50a8d9adea90a6551d135', '::1', 1436248039, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363234383031323b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, '17dc9c6ef8d3193cd227aa95e6f245f0'),
('ede22c9820d6f71687bb02145e8c2210342ebff0', '::1', 1436187335, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363138373333333b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, 'bba42e12dfbd99b55ae65441b88b75c9'),
('f4c10c3fe90602faefadf1d6a2d79c1fb2ea5d92', '::1', 1436180933, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363138303831323b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, 'ae50ecf595be5e760e6aa148ac3ace73'),
('fead3e2bf7452f5ce7efb2e519e79f4fc89f1566', '::1', 1436188485, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363138383438353b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2231223b, '8d56b9f4c9a79c843d786d50d87b9d26');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(40) COLLATE utf8_bin NOT NULL,
  `login` varchar(50) COLLATE utf8_bin NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `m_book`
--

CREATE TABLE IF NOT EXISTS `m_book` (
  `m_bokid` smallint(5) unsigned NOT NULL COMMENT 'Book Identification',
  `m_bokisbn` varchar(15) NOT NULL COMMENT 'Book ISBN Number',
  `m_bokname` varchar(400) DEFAULT NULL COMMENT 'Book Name',
  `m_bokdesc` varchar(400) DEFAULT NULL COMMENT 'Book Description'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `m_chapter`
--

CREATE TABLE IF NOT EXISTS `m_chapter` (
  `m_chpid` mediumint(8) unsigned NOT NULL COMMENT 'Book Chapter Identification',
  `m_chpbokvid` smallint(5) unsigned NOT NULL COMMENT 'Book volume Identification',
  `m_chpname` varchar(255) DEFAULT NULL COMMENT 'Book Chapter Title',
  `m_chpseqorder` tinyint(3) unsigned NOT NULL COMMENT 'Chapter Sequence No. The chapters will be display based on this no. but no need to display this number',
  `m_chpisreqfilter` bit(20) NOT NULL COMMENT 'Book chapter filter',
  `m_chplinkpage` smallint(5) unsigned NOT NULL COMMENT 'Book Sub chapter Begin Page Number'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `m_language`
--

CREATE TABLE IF NOT EXISTS `m_language` (
  `m_lanid` tinyint(3) unsigned NOT NULL COMMENT 'Language Identification',
  `m_lanname` varchar(30) DEFAULT NULL COMMENT 'Language name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `m_page`
--

CREATE TABLE IF NOT EXISTS `m_page` (
  `m_pgeid` mediumint(8) unsigned NOT NULL COMMENT 'Book Pages Identification',
  `m_pgevolid` smallint(5) unsigned NOT NULL COMMENT 'Book volume Identification',
  `m_pgeschid` mediumint(8) unsigned NOT NULL COMMENT 'Book subchapter id',
  `m_pgecustomlabel` varchar(10) DEFAULT NULL COMMENT 'Page no given by user',
  `m_pgeseqorder` smallint(5) unsigned NOT NULL COMMENT 'Page Sequence number',
  `m_pgeshowinteractivity` tinyint(3) unsigned DEFAULT NULL COMMENT 'page interactivity''s(111)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `m_role`
--

CREATE TABLE IF NOT EXISTS `m_role` (
  `m_rolid` tinyint(3) unsigned NOT NULL COMMENT 'User role Identification',
  `m_rolname` varchar(400) DEFAULT NULL COMMENT 'Role Name'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `m_subchapter`
--

CREATE TABLE IF NOT EXISTS `m_subchapter` (
  `m_schid` mediumint(9) NOT NULL COMMENT 'Book Sub Chapter Identification',
  `m_schbokcid` mediumint(8) unsigned NOT NULL COMMENT 'Book Chapter Identification',
  `m_schtitle` varchar(255) DEFAULT NULL COMMENT 'Book Sub Chapter Title',
  `m_schseqorder` tinyint(3) unsigned NOT NULL COMMENT 'Subchapter Sequence Number',
  `m_schlinkpage` mediumint(9) DEFAULT NULL COMMENT 'Book Sub chapter link Page Sequence Number',
  `m_schisreqfilter` bit(20) NOT NULL COMMENT 'Book sub chapter filter',
  `m_schisintend` bit(20) NOT NULL COMMENT 'if the sub chapter is belongs to 4th level then True.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `m_user`
--

CREATE TABLE IF NOT EXISTS `m_user` (
  `m_usrid` mediumint(9) NOT NULL COMMENT 'User Identification',
  `m_usrwebid` mediumint(8) unsigned NOT NULL COMMENT 'User Web ID receive from primary source',
  `m_usrroleid` tinyint(3) unsigned NOT NULL COMMENT 'User Role Identification',
  `m_usrfirstname` varchar(256) DEFAULT NULL COMMENT 'User first name',
  `m_usrlastname` varchar(256) DEFAULT NULL COMMENT 'User last name',
  `m_usrimglink` varchar(256) DEFAULT NULL COMMENT 'User profile image',
  `m_usraddress` varchar(256) DEFAULT NULL COMMENT 'User address',
  `m_usremailid` varchar(256) DEFAULT NULL COMMENT 'User email identification',
  `m_usrzipcode` varchar(10) DEFAULT NULL COMMENT 'User zipcode',
  `m_usrtown` varchar(256) NOT NULL COMMENT 'User town',
  `m_usrprovid` tinyint(3) unsigned NOT NULL COMMENT 'User province identification',
  `m_usrlastvisiteddate` datetime NOT NULL COMMENT 'User last visited time',
  `m_usrsessionid` varchar(256) NOT NULL,
  `m_usrlastaccbookid` mediumint(8) unsigned NOT NULL COMMENT 'User last access book identification '
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `m_volume`
--

CREATE TABLE IF NOT EXISTS `m_volume` (
  `m_volid` smallint(5) unsigned NOT NULL COMMENT 'Book volume Identification',
  `m_volbokid` smallint(5) unsigned NOT NULL COMMENT 'Book Identification ',
  `m_volseqno` tinyint(3) unsigned NOT NULL COMMENT 'Book volume number',
  `m_voltitle` varchar(100) DEFAULT NULL COMMENT 'Book volume title',
  `m_volsubtitle` varchar(100) DEFAULT NULL COMMENT 'Book voulme subtitle',
  `m_volimgsize` varchar(15) DEFAULT NULL COMMENT 'Book swf size',
  `m_volimgpath` varchar(100) DEFAULT NULL COMMENT 'Book thumbnail image',
  `m_vollangid` tinyint(4) NOT NULL COMMENT 'Book language',
  `m_volauthor` varchar(250) DEFAULT NULL COMMENT 'Book author name',
  `m_volauthdesc` varchar(500) DEFAULT NULL COMMENT 'Book author description'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `t_bookmark`
--

CREATE TABLE IF NOT EXISTS `t_bookmark` (
  `t_bmkid` mediumint(8) unsigned NOT NULL COMMENT 'Bookmark Identification',
  `t_bmktitle` varchar(30) DEFAULT NULL COMMENT 'Bookmark title',
  `t_bmkvolid` smallint(5) unsigned NOT NULL COMMENT 'Book volume Identification',
  `t_bmkusrid` mediumint(8) unsigned NOT NULL COMMENT 'User identification',
  `t_bmkpage` smallint(5) unsigned NOT NULL COMMENT 'Book page identification',
  `t_bmkcreateddate` datetime NOT NULL COMMENT 'Bookmark created date',
  `t_bmkupdateddate` datetime NOT NULL COMMENT 'Bookmark updated date'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `token` varchar(250) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '1',
  `banned` tinyint(1) NOT NULL DEFAULT '0',
  `ban_reason` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `new_password_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `new_password_requested` datetime DEFAULT NULL,
  `new_email` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `new_email_key` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `created` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `token`, `email`, `activated`, `banned`, `ban_reason`, `new_password_key`, `new_password_requested`, `new_email`, `new_email_key`, `last_ip`, `last_login`, `created`, `modified`) VALUES
(1, 'arulbtech', '$2a$08$bbVaauIrsmrmUDinw3vD2udmzpuFYHInVT6ik1VSwFPpcU30eHUMy', 'X*d95Cp_U8Pz@4A', 'arulbtech@gmail.com', 1, 0, NULL, NULL, NULL, NULL, '59e40b20d563b468f0d7279ebb0632e0', '::1', '2015-07-07 10:42:55', '2015-07-06 11:51:28', '2015-07-07 08:42:55');

-- --------------------------------------------------------

--
-- Table structure for table `user_autologin`
--

CREATE TABLE IF NOT EXISTS `user_autologin` (
  `key_id` char(32) COLLATE utf8_bin NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `user_agent` varchar(150) COLLATE utf8_bin NOT NULL,
  `last_ip` varchar(40) COLLATE utf8_bin NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE IF NOT EXISTS `user_profiles` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `country` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `website` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ci_sessions`
--
ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_book`
--
ALTER TABLE `m_book`
  ADD PRIMARY KEY (`m_bokid`);

--
-- Indexes for table `m_chapter`
--
ALTER TABLE `m_chapter`
  ADD PRIMARY KEY (`m_chpid`), ADD UNIQUE KEY `m_chpbokvid` (`m_chpbokvid`);

--
-- Indexes for table `m_language`
--
ALTER TABLE `m_language`
  ADD PRIMARY KEY (`m_lanid`);

--
-- Indexes for table `m_page`
--
ALTER TABLE `m_page`
  ADD PRIMARY KEY (`m_pgeid`), ADD UNIQUE KEY `m_pgevolid` (`m_pgevolid`), ADD UNIQUE KEY `m_pgeschid` (`m_pgeschid`);

--
-- Indexes for table `m_role`
--
ALTER TABLE `m_role`
  ADD PRIMARY KEY (`m_rolid`);

--
-- Indexes for table `m_subchapter`
--
ALTER TABLE `m_subchapter`
  ADD PRIMARY KEY (`m_schid`), ADD UNIQUE KEY `m_schbokcid` (`m_schbokcid`);

--
-- Indexes for table `m_user`
--
ALTER TABLE `m_user`
  ADD PRIMARY KEY (`m_usrid`), ADD UNIQUE KEY `m_usrroleid` (`m_usrroleid`), ADD UNIQUE KEY `m_usrroleid_2` (`m_usrroleid`), ADD UNIQUE KEY `m_usrprovid` (`m_usrprovid`);

--
-- Indexes for table `m_volume`
--
ALTER TABLE `m_volume`
  ADD PRIMARY KEY (`m_volid`), ADD UNIQUE KEY `m_volbokid` (`m_volbokid`), ADD UNIQUE KEY `m_vollangid` (`m_vollangid`);

--
-- Indexes for table `t_bookmark`
--
ALTER TABLE `t_bookmark`
  ADD PRIMARY KEY (`t_bmkid`), ADD UNIQUE KEY `t_bmkvolid` (`t_bmkvolid`), ADD UNIQUE KEY `t_bmkusrid` (`t_bmkusrid`), ADD UNIQUE KEY `t_bmkpage` (`t_bmkpage`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_autologin`
--
ALTER TABLE `user_autologin`
  ADD PRIMARY KEY (`key_id`,`user_id`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `m_book`
--
ALTER TABLE `m_book`
  MODIFY `m_bokid` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Book Identification';
--
-- AUTO_INCREMENT for table `m_chapter`
--
ALTER TABLE `m_chapter`
  MODIFY `m_chpid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Book Chapter Identification';
--
-- AUTO_INCREMENT for table `m_language`
--
ALTER TABLE `m_language`
  MODIFY `m_lanid` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Language Identification';
--
-- AUTO_INCREMENT for table `m_page`
--
ALTER TABLE `m_page`
  MODIFY `m_pgeid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Book Pages Identification';
--
-- AUTO_INCREMENT for table `m_role`
--
ALTER TABLE `m_role`
  MODIFY `m_rolid` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'User role Identification';
--
-- AUTO_INCREMENT for table `m_subchapter`
--
ALTER TABLE `m_subchapter`
  MODIFY `m_schid` mediumint(9) NOT NULL AUTO_INCREMENT COMMENT 'Book Sub Chapter Identification';
--
-- AUTO_INCREMENT for table `m_user`
--
ALTER TABLE `m_user`
  MODIFY `m_usrid` mediumint(9) NOT NULL AUTO_INCREMENT COMMENT 'User Identification';
--
-- AUTO_INCREMENT for table `m_volume`
--
ALTER TABLE `m_volume`
  MODIFY `m_volid` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Book volume Identification';
--
-- AUTO_INCREMENT for table `t_bookmark`
--
ALTER TABLE `t_bookmark`
  MODIFY `t_bmkid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Bookmark Identification';
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
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
-- Constraints for table `m_subchapter`
--
ALTER TABLE `m_subchapter`
ADD CONSTRAINT `m_subchapter_ibfk_1` FOREIGN KEY (`m_schbokcid`) REFERENCES `m_chapter` (`m_chpid`);

--
-- Constraints for table `m_user`
--
ALTER TABLE `m_user`
ADD CONSTRAINT `m_user_ibfk_1` FOREIGN KEY (`m_usrroleid`) REFERENCES `m_role` (`m_rolid`);

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
