-- Author: Arulkumar
-- Database: ASCE
-- Details: Structure and Data

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

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `token`, `ip_address`, `timestamp`, `data`) VALUES
('0522321f3d94080af09c5872dafcb691f4b983e4', 'b2f872acf34985ff3d1cb035b5f08b90', '192.168.27.55', 1436867176, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363836363838303b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('05b110b9a55efc44dd484edeee29bc84d13bcb34', 'a2a9432e8081a1a836a9dc55601164f9', '192.168.27.55', 1436881808, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363838313531383b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('06469428621f0112d97ec438dba3bf0f090699c5', 'd24428df54d580a754b86b77695bcbfa', '192.168.27.55', 1436950779, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363935303737323b),
('0a9df3a65d5220991d75d9b5e7de40074fe0fd03', '485d40fb23195a5b2c501b9aed2489f9', '192.168.27.55', 1436866614, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363836363535323b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('11ebc05f63a6d47ddfa330d83e2d7b34e20b6a81', '3b6e60d83c50e434aabf9adb6d2e3b20', '192.168.27.55', 1436876467, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363837363337323b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('1295629d1e96b0624544df943efe05945f08fc0f', 'cf3c0ccd6ef69c77421f8eb7e5d4fb44', '192.168.27.55', 1436862245, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363836323031393b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('15da1333947ad8b130d7002dcfe8dc54db55c406', 'deb90967632956dfc218f40946066bf2', '192.168.27.55', 1436882349, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363838323234393b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('180d042949d4e32685d1f3ecc29c4f8b948128ca', '3e5d15381165d5e5f5d26eaf8068f6b7', '192.168.27.55', 1436880232, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363838303233323b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('1fe94f73688feb69d48c139d5b8d77666a95714a', '8299c8b2b1b490f468e96dc91c852469', '192.168.27.55', 1436877559, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363837373432383b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('20fb456df7be2ac3406552713d4210fb354a5ef6', '52a185f08dd47af7c4d5818208166dde', '192.168.27.55', 1436879431, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363837393232393b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('2777e204ad95a7911425a883ea5a05d05c2fb7e8', 'cb069880b325d2ce8baf90ec7f05306a', '192.168.27.55', 1436949451, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363934393135393b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('2dd8322c383219a273cab79bca7984ee8c0ff0ee', 'bdd42b4b696aa9ad98b1c5c55bee893b', '192.168.27.55', 1436940382, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363934303335393b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('2f2dbf69a5c799f376fc435dd95f8d4b50a04330', '2d88e76b57fda3a58df414b5e4d0d6fa', '192.168.27.55', 1436869654, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363836393432383b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('38332b4a36d0043e78a06c49ef90be0ac4cc4382', '99227c2f7fc6af4877183c4b72df9946', '192.168.27.55', 1436867890, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363836373834373b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('3b1a064fb761cab62fa426114bbb0db52f28cb79', '5945b4d6f898d69d0e2480530b35a868', '192.168.27.55', 1436868917, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363836383737383b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('3cc896349d884886798c4e3750866cd347a759b1', 'dec565dcf40b6285554ad3e6f785f865', '192.168.27.55', 1436870081, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363836393738313b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('49d670bf06d87ab41072fd43a0c81083df37586f', 'eb6499598047d6dfc9f0ebe60368e986', '192.168.27.55', 1436865698, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363836353631393b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('5500e9014f387fb4eeab3fd831f164c57d9ea06c', '2606780e488f512722c9e011ec45a792', '192.168.27.55', 1436875575, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363837353437313b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('5fd34230f6c3f2c6e44f115f6f692d3494014436', 'c8454b3c1cd28defaa93b4f0eb0b6761', '::1', 1436932846, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363933323834363b),
('60f2e4201d17d87a66aaee58aa0787aa4511ccf7', '0dd75d1ea2bf62a502ba299cb86c2562', '192.168.27.55', 1436881096, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363838313039363b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('665628919ce71ecbc754f75db6e0a0443e72836d', '17a3cab316524c61cae7b0838d077f89', '192.168.27.55', 1436856644, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363835363632333b),
('6a8d452b285827843a887bb0e9213b4acaf9b2ca', '421ab05432264785782a896fd52c6d34', '192.168.27.55', 1436857055, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363835373032313b),
('745592a81137486112e3f9590e46a2f17d836171', '7ce607727f986ae1a110ae634cd7147d', '192.168.27.55', 1436882984, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363838323732373b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('79a664dcf28325686fdcc11a4a48672aa811d39a', '1cd86681a08ea98cdae8a15f5a2dbc82', '192.168.27.55', 1436857917, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363835373836373b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2230223b),
('79f2b8c92c27a2ac07b0049d296b293121137400', 'c9bf0d4ee883651a0ca866b5867a0cd6', '192.168.27.55', 1436869376, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363836393039383b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('8b87df134caa5828ecf02ec538dbc5b411a3fc58', 'd2039754393396ea637711f92045d49e', '192.168.27.55', 1436937321, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363933373332303b),
('929c446bf4a43cb7573689093eb831094eae538f', 'cc7b13b2effd0426fd033e42127d687a', '192.168.27.55', 1436867815, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363836373532383b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('9313ff11ab685b8f99758b92c772bafdd1d35dbc', 'aca4aa9a1b76e2a66e16096d5a9d8ff6', '192.168.27.55', 1436876332, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363837363035323b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('94092688621994d6276f4ea774828763a5267f3e', '9469933481a638b2a7179ca4b510d415', '192.168.27.55', 1436877000, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363837363934393b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('964550e06b6ab0d29af2752766b61c99161208e4', '471ae29f6a1552b925a27e33624cde6e', '192.168.27.55', 1436949721, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363934393731313b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('97a04cd58a4bf4c627d3118bed3adfcd6b362747', '55662d3175f0ee2c16f8989ba318e0c5', '192.168.27.55', 1436945241, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363934353234313b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('9a2d4e434369339cec13c859216f53a6608c357b', '977aff821b3d1d76025939c1461dcad9', '192.168.27.55', 1436950064, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363935303036333b),
('a303dc4d6a6aa72094f2cfb102a26ec79f37185d', '04d9882bbe733de02201379ea6d7d277', '192.168.27.55', 1436879975, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363837393835313b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('a50fb9549d02da89c5271e52fdd414ee6cbbf803', 'd20bd1246d3b4ecd8ca74ab37c4014d9', '192.168.27.55', 1436862727, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363836323732373b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('a68d478d74fbc927ae0f5da20d60ce40ef72ce3e', 'f21003f943c6625444fee25f68e22248', '192.168.27.55', 1436861542, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363836313438353b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('ab5fe888f9e81822b2025f6c9002c1b9444a06fd', '61481fb14bd4f4fa2972b34ed1d02106', '192.168.27.55', 1436874866, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363837343833363b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('ade1141b1fe73a938070b6bc3a63f214da52125b', '89993d143643ffe5dba06acfb21cdebd', '192.168.27.55', 1436858020, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363835373933373b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('afb6a00d482176eab604f8dff2066f5ac9b33a3d', '279f7d94fa19bba08b36e8d9c6a38a7e', '192.168.27.55', 1436870821, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363837303734333b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('b1fee6645dd48b5507167048bc4c14bd3f466ee4', '18e9285f1fea953bc52deb00b2ddedde', '192.168.27.55', 1436881983, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363838313933313b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('bf96b1295c21044f64552d98f9c762eee74340e5', 'a6b1622076d134db0c48c69a144e57ac', '192.168.27.55', 1436870167, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363837303131343b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('c348da0e83897f04ed920f24b72205ec2784be74', 'd456bbe16fc642ab5c09e111d18e20e3', '192.168.27.55', 1436949041, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363934383738313b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('c6158ac3ab71b74375dedca835c71d826f6bb40f', '38c6389d779ea42f7e550fca4975bb0f', '192.168.27.55', 1436864078, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363836343037383b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('cec7be60b9347555f1cf4419f61d9c29652dc4c8', '6a715514a3ef56df90851413e391a816', '192.168.27.55', 1436942718, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363934323731373b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('d444e90a34ed9a728a53ffafdb067c119d382871', '84ad5b62aa2d95131942f842259df371', '192.168.27.55', 1436856605, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363835363430383b),
('d51e16c92edfef09e7f00387aa391b18ccfe2a8e', '23f2054d1b1c35b5f4c2aad95498ec60', '192.168.27.55', 1436865611, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363836353331373b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('d9bd15871cca83d59ada338c4edfabbf213cc578', '4ffdd1efca67c9aac4ef82d4f5e4664b', '127.0.0.1', 1436942716, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363934323731363b),
('e00391054f81c5010a22497e93901204bf370e24', '3e13b694290ff4c027823fc84403b21e', '192.168.27.55', 1436884352, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363838343036353b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('ea4688f7241be0cb2eb888343c5b5a868e18d739', '9934580fcae81a89919f6a43d84c187a', '192.168.27.55', 1436932928, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363933323834373b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('f327ecbf15ee5bc24d0c05f75c028b4214db8850', 'c02c09d1330f86a4bcab1b9265148772', '192.168.27.55', 1436874594, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363837343533343b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('f700025fda169b65e68d5e1027360fbbaab4de9d', '41cf422fb4139c852e069e1434699664', '192.168.27.55', 1436857857, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363835373831363b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6274656368223b7374617475737c733a313a2230223b),
('fe65a657fc097a94d41402d61baeb15572b9296e', '90116ce3bfee473604b0390727f44ffe', '192.168.27.55', 1436884408, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363838343430383b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b),
('ffcfac1b76cf2ac46d50dac46f8d6b9fc6852b89', '9c94dfab240d42231e90de1010837c3c', '192.168.27.55', 1436863857, 0x5f5f63695f6c6173745f726567656e65726174657c693a313433363836333539303b757365725f69647c733a313a2231223b757365726e616d657c733a393a226172756c6b756d6172223b7374617475737c733a313a2231223b);

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

--
-- Dumping data for table `m_book`
--

INSERT INTO `m_book` (`m_bokid`, `m_bokisbn`, `m_bokname`, `m_bokdesc`, `m_createdbyuser`, `m_updatedbyuser`, `m_createddate`, `m_updateddate`) VALUES
(1, '9780784412916', 'Minimum Design Loads for Buildings and Other Structures', 'Desec', 'arulkumar', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

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

--
-- Dumping data for table `m_chapter`
--

INSERT INTO `m_chapter` (`m_chpid`, `m_chpbokvid`, `m_chplabel`, `m_chptitle`, `m_chlinkpage`, `m_chpseqorder`, `m_chpisreqfilter`, `m_chplinkpage`, `m_createdbyuser`, `m_updatedbyuser`, `m_createddate`, `m_updateddate`) VALUES
(25, 1, 'Chapter 1', 'General', 0, 0, '0', 0, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 1, 'Chapter C2', 'Combinations of Loads', 0, 0, '0', 0, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, 1, 'Chapter C4', 'Live Loads', 0, 0, '0', 0, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(28, 1, 'Chapter 7', 'Snow Loads', 0, 0, '0', 0, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, 1, 'Chapter 10', 'Ice Loads—Atmospheric Icing', 0, 0, '0', 0, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, 1, 'Chapter 11', 'Seismic Design Criteria', 0, 0, '0', 0, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(32, 1, 'Chapter 12', 'Seismic Design Requirements for Building Structures', 0, 0, '0', 0, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(33, 1, 'Chapter 13', 'Seismic Design Requirements for Nonstructural Components', 0, 0, '0', 0, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(34, 1, 'Chapter 15', 'Seismic Design Requirements For Nonbuilding Structures', 0, 0, '0', 0, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(35, 1, 'Chapter 29', 'Wind Loads On Other Structures and Building Appurtenances—MWFRS', 0, 0, '0', 0, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `m_language`
--

CREATE TABLE IF NOT EXISTS `m_language` (
  `m_lanid` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Language Identification',
  `m_lanname` varchar(30) DEFAULT NULL COMMENT 'Language name',
  PRIMARY KEY (`m_lanid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `m_language`
--

INSERT INTO `m_language` (`m_lanid`, `m_lanname`) VALUES
(1, 'English');

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

--
-- Dumping data for table `m_section`
--

INSERT INTO `m_section` (`m_sechid`, `m_secbokcid`, `m_seclabel`, `m_sectitle`, `m_seclevel`, `m_secmasterid`, `m_secseqorder`, `m_seclinkpage`, `m_createdbyuser`, `m_updatedbyuser`, `m_createddate`, `m_updateddate`, `m_secisreqfilter`, `m_secisintend`) VALUES
(2, 25, '1.1', 'Scope', 0, 2, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(3, 25, '1.2', 'Definitions and Symbols', 0, 3, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(4, 25, '1.2.1', 'Definitions.', 1, 3, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(5, 25, '1.2.2', 'Symbols.', 1, 3, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(6, 25, '1.3', 'Basic Requirements', 0, 6, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(7, 25, '1.3.1', 'Strength and Stiffness.', 1, 6, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(8, 25, '1.3.1.1', 'Strength Procedures.', 2, 7, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(9, 25, '1.3.1.2', 'Allowable Stress Procedures.', 2, 7, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(10, 25, '1.3.1.3', 'Performance-Based Procedures.', 2, 7, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(11, 25, '1.3.1.3.1', 'Analysis', 3, 10, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(12, 25, '1.3.1.3.2', 'Testing', 3, 10, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(13, 25, '1.3.1.3.3', 'Documentation', 3, 10, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(14, 25, '1.3.1.3.4', 'Peer Review', 3, 10, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(15, 25, '1.3.2', 'Serviceability.', 1, 6, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(16, 25, '1.3.3', 'Self-Straining Forces.', 1, 6, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(17, 25, '1.3.4', 'Analysis.', 1, 6, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(18, 25, '1.3.5', 'Counteracting Structural Actions.', 1, 6, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(19, 25, '1.4', 'General Structural Integrity', 0, 19, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(20, 25, '1.4.1', '>Load Combinations of Integrity Loads.', 1, 19, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(21, 25, '1.4.1.1', 'Strength Design Notional Load Combinations.', 2, 20, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(22, 25, '1.4.1.2', 'Allowable Stress Design Notional Load Combinations.', 2, 20, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(23, 25, '1.4.2', 'Load Path Connections.', 1, 19, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(24, 25, '1.4.3', 'Lateral Forces.', 1, 19, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(25, 25, '1.4.4', 'Connection to Supports.', 1, 19, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(26, 25, '1.4.5', 'Anchorage of Structural Walls.', 1, 19, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(27, 25, '1.4.6', 'Extraordinary Loads and Events.', 1, 19, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(28, 25, '1.5', 'Classification of Buildings and Other Structures', 0, 28, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(29, 25, '1.5.1', 'Risk Categorization.', 1, 28, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(30, 25, '1.5.2', 'Multiple Risk Categories.', 1, 28, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(31, 25, '1.5.3', 'Toxic, Highly Toxic, and Explosive Substances.', 1, 28, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(32, 25, '1.6', 'Additions and Alterations to Existing Structures', 0, 32, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(33, 25, '1.7', 'Load Tests', 0, 33, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(34, 25, '1.8', 'Consensus Standards and Other Referenced Documents', 0, 34, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(35, 26, 'C2.1', 'General', 0, 35, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(36, 26, 'C2.2', 'Symbols', 0, 36, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(37, 26, 'C2.3', 'Combining Factored Loads Using Strength Design', 0, 37, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(38, 26, 'C2.3.1', 'Applicability.', 1, 37, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(39, 26, 'C2.3.2', 'Basic Combinations.', 1, 37, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(40, 26, 'C2.3.3', 'Load Combinations Including Flood Load.', 1, 37, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(41, 26, 'C2.3.4', 'Load Combinations Including Atmospheric Ice Loads.', 1, 37, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(42, 26, 'C2.3.5', 'Load Combinations Including Self-Straining Loads.', 1, 37, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(43, 26, 'C2.3.6', 'Load Combinations for Nonspecified Loads.', 1, 37, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(44, 26, 'C2.4', 'Combining Nominal Loads Using Allowable Stress Design', 0, 44, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(45, 26, 'C2.4.1', 'Basic Combinations.', 1, 44, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(46, 26, 'C2.4.2', 'Load Combinations Including Flood Load.', 1, 44, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(47, 26, 'C2.4.3', 'Load Combinations Including Atmospheric Ice Loads.', 1, 44, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(48, 26, 'C2.4.4', 'Load Combinations Including Self-Straining Loads.', 1, 44, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(49, 26, 'C2.5', 'Load Combinations for Extraordinary Events', 0, 49, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(50, 27, 'C4.3', 'Uniformly Distributed Live Loads', 0, 50, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(51, 27, 'C4.3.1', 'Required Live Loads.', 1, 50, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(52, 27, 'C4.3.2', 'Provision for Partitions.', 1, 50, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(53, 27, 'C4.3.3', 'Partial Loading.', 1, 50, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(54, 27, 'C4.4', 'Concentrated Live Loads', 0, 54, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(55, 27, 'C4.4.1', 'Helipads.', 1, 54, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(56, 27, 'C4.5', 'Loads on Handrail, Guardrail, Grab Bar and Vehicle Barrier Systems, and Fixed Ladders', 0, 56, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(57, 27, 'C4.5.1', 'Loads on Handrail and Guardrail Systems.', 1, 56, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(58, 27, 'C4.5.2', 'Loads on Grab Bar Systems.', 1, 56, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(59, 27, 'C4.5.3', 'Loads on Vehicle Barrier Systems.', 1, 56, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(60, 27, 'C4.5.4', 'Loads on Fixed Ladders.', 1, 56, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(61, 27, 'C4.6', 'Impact Loads', 0, 61, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(62, 27, 'C4.7', 'Reduction in Live Loads', 0, 62, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(63, 27, 'C4.7.1', 'General.', 1, 62, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(64, 27, 'C4.7.3', 'Heavy Live Loads.', 1, 62, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(65, 27, 'C4.7.4', 'Passenger Vehicle Garages.', 1, 65, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(66, 27, 'C4.7.6', 'Limitations on One-Way Slabs.', 1, 65, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(67, 27, 'C4.8', 'Reduction in Roof Live Loads', 0, 67, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(68, 27, 'C4.8.2', 'Flat, Pitched, and Curved Roofs.', 1, 67, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(69, 27, 'C4.8.3', 'Special Purpose Roofs.', 1, 67, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(70, 27, 'C4.9', 'Crane Loads', 0, 70, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(71, 28, '7.1', 'Symbols', 0, 71, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(72, 28, '7.2', 'Ground Snow Loads, \\npg', 0, 72, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(73, 28, '7.3', 'Flat Roof Snow Loads, \\npf', 0, 73, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(74, 28, '7.3.1', 'Exposure Factor, \\nCe.', 1, 73, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(75, 28, '7.3.2', 'Thermal Factor, \\nCt.', 1, 73, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(76, 28, '7.3.3', 'Importance Factor, \\nIs.', 1, 73, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(77, 28, '7.3.4', 'Minimum Snow Load for Low-Slope Roofs, \\npm.', 1, 73, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(78, 28, '7.4', 'Sloped Roof Snow Loads, \\nps', 0, 78, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(79, 28, '7.4.1', 'Warm Roof Slope Factor, \\nCs.', 1, 78, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(80, 28, '7.4.2', 'Cold Roof Slope Factor, \\nCs.', 1, 78, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(81, 28, '7.4.3', 'Roof Slope Factor for Curved Roofs.', 1, 78, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(82, 28, '7.4.4', 'Roof Slope Factor for Multiple Folded Plate, Sawtooth, and Barrel Vault Roofs.', 1, 78, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(83, 28, '7.4.5', 'Ice Dams and Icicles Along Eaves.', 1, 78, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(84, 28, '7.5', 'Partial Loading', 0, 84, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(85, 28, '7.5.1', 'Continuous Beam Systems.', 1, 84, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(86, 28, '7.5.2', 'Other Structural Systems.', 1, 84, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(87, 28, '7.6', 'Unbalanced Roof Snow Loads', 0, 87, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(88, 28, '7.6.1', 'Unbalanced Snow Loads for Hip and Gable Roofs.', 1, 87, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(89, 28, '7.6.2', 'Unbalanced Snow Loads for Curved Roofs.', 1, 87, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(90, 28, '7.6.3', 'Unbalanced Snow Loads for Multiple Folded Plate, Sawtooth, and Barrel Vault Roofs.', 1, 87, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(91, 28, '7.6.4', 'Unbalanced Snow Loads for Dome Roofs.', 1, 87, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(92, 28, '7.7', 'Drifts on Lower Roofs (Aerodynamic Shade)', 0, 92, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(93, 28, '7.7.1', 'Lower Roof of a Structure.', 1, 92, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(94, 28, '7.7.2', 'Adjacent Structures.', 1, 92, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(95, 28, '7.8', 'Roof Projections and Parapets', 0, 95, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(96, 28, '7.9', 'Sliding Snow', 0, 96, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(97, 28, '7.10', 'Rain-on-Snow Surcharge Load', 1, 96, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(98, 28, '7.11', 'Ponding Instability', 1, 96, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(99, 28, '7.12', 'Existing Roofs', 1, 96, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(100, 30, '10.1', 'General', 0, 100, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(101, 30, '10.1.1', 'Site-Specific Studies.', 1, 100, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(102, 30, '10.1.2', 'Dynamic Loads.', 1, 100, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(103, 30, '10.1.3', 'Exclusions.', 1, 100, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(104, 30, '10.2', 'Definitions', 0, 104, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(105, 30, '10.3', 'Symbols', 0, 105, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(106, 30, '10.4', 'Ice Loads Due To Freezing Rain', 0, 106, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(107, 30, '10.4.1', 'Ice Weight.', 1, 106, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(108, 30, '10.4.2', 'Nominal Ice Thickness.', 1, 106, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(109, 30, '10.4.3', 'Height Factor.', 1, 106, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(110, 30, '10.4.4', 'Importance Factors.', 1, 106, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(111, 30, '10.4.5', 'Topographic Factor.', 1, 106, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(112, 30, '10.4.6', 'Design Ice Thickness for Freezing Rain.', 1, 106, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(113, 30, '10.5', 'Wind on Ice-Covered Structures', 0, 113, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(114, 30, '10.5.1', 'Wind on Ice-Covered Chimneys, Tanks, and Similar Structures.', 1, 113, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(115, 30, '10.5.2', 'Wind on Ice-Covered Solid Freestanding Walls and Solid Signs.', 1, 113, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(116, 30, '10.5.3', 'Wind on Ice-Covered Open Signs and Lattice Frameworks.', 1, 113, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(117, 30, '10.5.4', 'Wind on Ice-Covered Trussed Towers.', 1, 113, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(118, 30, '10.5.5', 'Wind on Ice-Covered Guys and Cables.', 1, 113, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(119, 30, '10.6', 'Design Temperatures for Freezing Rain', 0, 119, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(120, 30, '10.7', 'Partial Loading', 0, 120, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(121, 30, '10.8', 'Design Procedure', 0, 121, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(122, 30, '10.9', 'Consensus Standards And Other Referenced Documents', 0, 122, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(123, 31, '11.1', 'General', 0, 123, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(124, 31, '11.1.1', 'Purpose.', 1, 123, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(125, 31, '11.1.2', 'Scope.', 1, 123, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(126, 31, '11.1.3', 'Applicability.', 1, 123, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(127, 31, '11.1.4', 'Alternate Materials and Methods of Construction.', 1, 123, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(128, 31, '11.2', 'Definitions', 0, 128, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(129, 31, '11.3', 'Symbols', 0, 129, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(130, 31, '11.4', 'Seismic Ground Motion Values', 0, 130, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(131, 31, '11.4.1', 'Mapped Acceleration Parameters.', 1, 130, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(132, 31, '11.4.2', 'Site Class.', 1, 130, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(133, 31, '11.4.3', 'Site Coefficients and Risk-Targeted Maximum Considered Earthquake (\\nMCER) Spectral Response Acceleration Parameters.', 1, 130, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(134, 31, '11.4.4', 'Design Spectral Acceleration Parameters.', 1, 130, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(135, 31, '11.4.5', 'Design Response Spectrum.', 1, 130, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(136, 31, '11.4.6', 'Risk-Targeted Maximum Considered Earthquake (\\nMCER) Response Spectrum.', 1, 130, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(137, 31, '11.4.7', 'Site-Specific Ground Motion Procedures.', 1, 130, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(138, 31, '11.5', 'Importance Factor and Risk Category', 0, 138, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(139, 31, '11.5.1', 'Importance Factor.', 1, 138, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(140, 31, '11.5.2', 'Protected Access for Risk Category IV.', 1, 138, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(141, 31, '11.6', 'Seismic Design Category', 0, 141, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(142, 31, '11.7', 'Design Requirements for Seismic Design Category A', 0, 142, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(143, 31, '11.8', 'Geologic Hazards and Geotechnical Investigation', 0, 143, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(144, 31, '11.8.1', 'Site Limitation for Seismic Design Categories E and F.', 1, 143, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(145, 31, '11.8.2', 'Geotechnical Investigation Report Requirements for Seismic Design Categories C through F.', 1, 143, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(146, 31, '11.8.3', 'Additional Geotechnical Investigation Report Requirements for Seismic Design Categories D through F.', 1, 143, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(147, 32, '12.1', 'Structural Design Basis', 0, 147, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(148, 32, '12.1.1', 'Basic Requirements.', 1, 148, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(149, 32, '12.1.2', 'Member Design, Connection Design, and Deformation Limit.', 1, 148, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(150, 32, '12.1.3', 'Continuous Load Path and Interconnection.', 1, 148, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(151, 32, '12.1.4', 'Connection to Supports.', 1, 148, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(152, 32, '12.1.5', 'Foundation Design.', 1, 148, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(153, 32, '12.1.6', 'Material Design and Detailing Requirements.', 0, 148, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(154, 32, '12.2', 'Structural System Selection', 0, 154, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(155, 32, '12.2.1', 'Selection and Limitations.', 1, 154, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(156, 32, '12.2.2', 'Combinations of Framing Systems in Different Directions.', 1, 154, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(157, 32, '12.2.3', 'Combinations of Framing Systems in the Same Direction.', 1, 154, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(158, 32, '12.2.3.1', 'R, \\nCd, and \\nΩ0 Values for Vertical Combinations.', 2, 157, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(159, 32, '12.2.3.2', 'Two-Stage Analysis Procedure.', 2, 157, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(160, 32, '12.2.3.3', 'R, \\nCd, and \\nΩ0 Values for Horizontal Combinations.', 2, 157, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(161, 32, '12.2.4', 'Combination Framing Detailing Requirements.', 1, 154, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(162, 32, '12.2.5', 'System-Specific Requirements.', 1, 154, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(163, 32, '12.2.5.1', 'Dual System.', 2, 162, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(164, 32, '12.2.5.2', 'Cantilever Column Systems.', 2, 162, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(165, 32, '12.2.5.3', 'Inverted Pendulum-Type Structures.', 2, 162, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(166, 32, '12.2.5.4', 'Increased Structural Height Limit for Steel Eccentrically Braced Frames, Steel Special Concentrically Braced Frames, Steel Buckling-Restrained Braced Frames, Steel Special Plate Shear Walls, and Special Reinforced Concrete Shear Walls.', 2, 162, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(167, 32, '12.2.5.5', 'Special Moment Frames in Structures Assigned to Seismic Design Categories D through F.', 2, 162, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(168, 32, '12.2.5.6', 'Steel Ordinary Moment Frames', 2, 162, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(169, 32, '12.2.5.6.1', 'Seismic Design Category D or E', 3, 168, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(170, 32, '12.2.5.6.2', 'Seismic Design Category F.', 3, 168, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(171, 32, '12.2.5.7', 'Steel Intermediate Moment Frames', 2, 162, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(172, 32, '12.2.5.7.1', 'Seismic Design Category D', 3, 171, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(173, 32, '12.2.5.7.2', 'Seismic Design Category E', 3, 171, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(174, 32, '12.2.5.7.3', 'Seismic Design Category F', 3, 171, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(175, 32, '12.2.5.8', 'Shear Wall-Frame Interactive Systems.', 2, 162, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(176, 32, '12.3', 'Diaphragm Flexibility, Configuration Irregularities, And Redundancy', 0, 176, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(177, 32, '12.3.1', 'Diaphragm Flexibility.', 1, 176, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(178, 32, '12.3.1.1', 'Flexible Diaphragm Condition.', 2, 177, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(179, 32, '12.3.1.2', 'Rigid Diaphragm Condition.', 2, 177, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(180, 32, '12.3.1.3', 'Calculated Flexible Diaphragm Condition.', 2, 177, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(181, 32, '12.3.2', 'Irregular and Regular Classification.', 1, 176, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(182, 32, '12.3.2.1', 'Horizontal Irregularity.', 2, 177, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(183, 32, '12.3.2.2', 'Vertical Irregularity.', 2, 177, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(184, 32, '12.3.3', 'Limitations and Additional Requirements for Systems with Structural Irregularities', 1, 176, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(185, 32, '12.3.3.1', 'Prohibited Horizontal and Vertical Irregularities for Seismic Design Categories D through F.', 2, 184, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(186, 32, '12.3.3.2', 'Extreme Weak Stories.', 2, 184, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(187, 32, '12.3.3.3', 'Elements Supporting Discontinuous Walls or Frames.', 2, 184, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(188, 32, '12.3.3.4', 'Increase in Forces Due to Irregularities for Seismic Design Categories D through F.', 2, 184, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(189, 32, '12.3.4', 'Redundancy.', 1, 176, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(190, 32, '12.3.4.1', 'Conditions Where Value of \\nρ is 1.0.', 2, 189, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(191, 32, '12.3.4.2', 'Redundancy Factor, \\nρ, for Seismic Design Categories D through F.', 2, 189, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(192, 32, '12.4', 'Seismic Load Effects and Combinations', 0, 192, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(193, 32, '12.4.1', 'Applicability.', 1, 192, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(194, 32, '12.4.2', 'Seismic Load Effect.', 1, 192, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(195, 32, '12.4.2.1', 'Horizontal Seismic Load Effect.', 2, 194, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(196, 32, '12.4.2.2', 'Vertical Seismic Load Effect.', 2, 194, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(197, 32, '12.4.2.3', 'Seismic Load Combinations.', 2, 194, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(198, 32, '12.4.3', 'Seismic Load Effect Including Overstrength Factor.', 1, 192, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(199, 32, '12.4.3.1', 'Horizontal Seismic Load Effect with Overstrength Factor.', 2, 198, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(200, 32, '12.4.3.2', 'Load Combinations with Overstrength Factor.', 2, 198, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(201, 32, '12.4.3.3', 'Allowable Stress Increase for Load Combinations with Overstrength.', 2, 198, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(202, 32, '12.4.4', 'Minimum Upward Force for Horizontal Cantilevers for Seismic Design Categories D through F.', 1, 192, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(203, 32, '12.5', 'Direction of Loading', 0, 203, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(204, 32, '12.5.1', 'Direction of Loading Criteria.', 1, 203, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(205, 32, '12.5.2', 'Seismic Design Category B.', 1, 203, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(206, 32, '12.5.3', 'Seismic Design Category C.', 1, 203, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(207, 32, '12.5.4', 'Seismic Design Categories D through F.', 1, 203, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(208, 32, '12.6', 'Analysis Procedure Selection', 0, 208, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(209, 32, '12.7', 'Modeling Criteria', 0, 209, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(210, 32, '12.7.1', 'Foundation Modeling.', 1, 209, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(211, 32, '12.7.2', 'Effective Seismic Weight.', 1, 209, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(212, 32, '12.7.3', 'Structural Modeling.', 1, 209, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(213, 32, '12.7.4', 'Interaction Effects.', 1, 209, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(214, 32, '12.8', 'Equivalent Lateral Force Procedure', 0, 214, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(215, 32, '12.8.1', 'Seismic Base Shear.', 1, 214, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(216, 32, '12.8.1.1', 'Calculation of Seismic Response Coefficient.', 2, 215, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(217, 32, '12.8.1.2', 'Soil Structure Interaction Reduction.', 2, 215, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(218, 32, '12.8.1.3', 'Maximum \\nSs Value in Determination of \\nCs.', 2, 215, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(219, 32, '12.8.2', 'Period Determination.', 1, 214, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(220, 32, '12.8.2.1', 'Approximate Fundamental Period.', 2, 219, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(221, 32, '12.8.3', 'Vertical Distribution of Seismic Forces.', 1, 214, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(222, 32, '12.8.4', 'Horizontal Distribution of Forces.', 1, 214, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(223, 32, '12.8.4.1', 'Inherent Torsion.', 2, 222, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(224, 32, '12.8.4.2', 'Accidental Torsion.', 2, 222, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(225, 32, '12.8.4.3', 'Amplification of Accidental Torsional Moment.', 2, 222, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(226, 32, '12.8.5', 'Overturning.', 1, 214, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(227, 32, '12.8.6', 'Story Drift Determination.', 1, 214, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(228, 32, '12.8.6.1', 'Minimum Base Shear for Computing Drift.', 2, 227, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(229, 32, '12.8.6.2', 'Period for Computing Drift.', 2, 227, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(230, 32, '12.8.7', 'P-Delta Effects.', 1, 214, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(231, 32, '12.9', 'Modal Response Spectrum Analysis', 0, 231, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(232, 32, '12.9.1', 'Number of Modes.', 1, 231, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(233, 32, '12.9.2', 'Modal Response Parameters.', 1, 231, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(234, 32, '12.9.3', 'Combined Response Parameters.', 1, 231, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(235, 32, '12.9.4', 'Scaling Design Values of Combined Response.', 1, 231, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(236, 32, '12.9.4.1', 'Scaling of Forces.', 2, 235, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(237, 32, '12.9.4.2', 'Scaling of Drifts.', 2, 235, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(238, 32, '12.9.5', 'Horizontal Shear Distribution.', 1, 231, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(239, 32, '12.9.6', 'P-Delta Effects.', 1, 231, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(240, 32, '12.9.7', 'Soil Structure Interaction Reduction.', 1, 231, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(241, 32, '12.10', 'Diaphragms, Chords, And Collectors', 0, 241, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(242, 32, '12.10.1', 'Diaphragm Design.', 1, 241, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(243, 32, '12.10.1.1', 'Diaphragm Design Forces.', 2, 242, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(244, 32, '12.10.2', 'Collector Elements.', 1, 241, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(245, 32, '12.10.2.1', 'Collector Elements Requiring Load Combinations with Overstrength Factor for Seismic Design Categories C through F.', 2, 244, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(246, 32, '12.11', 'Structural Walls and Their Anchorage', 0, 246, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(247, 32, '12.11.1', 'Design for Out-of-Plane Forces.', 1, 246, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(248, 32, '12.11.2', 'Anchorage of Structural Walls and Transfer of Design Forces into Diaphragms', 1, 246, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(249, 32, '12.11.2.1', 'Wall Anchorage Forces.', 2, 248, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(250, 32, '12.11.2.2', 'Additional Requirements for Diaphragms in Structures Assigned to Seismic Design Categories C through F', 2, 248, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(251, 32, '12.11.2.2.1', 'Transfer of Anchorage Forces into Diaphragm.', 3, 250, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(252, 32, '12.11.2.2.2', 'Steel Elements of Structural Wall Anchorage System.', 3, 250, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(253, 32, '12.11.2.2.3', 'Wood Diaphragms.', 3, 250, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(254, 32, '12.11.2.2.4', 'Metal Deck Diaphragms.', 3, 250, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(255, 32, '12.11.2.2.5', 'Embedded Straps.', 3, 250, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(256, 32, '12.11.2.2.6', 'Eccentrically Loaded Anchorage System.', 3, 250, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(257, 32, '12.11.2.2.7', 'Walls with Pilasters.', 3, 250, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(258, 32, '12.12', 'Drift and Deformation', 0, 258, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(259, 32, '12.12.1', 'Story Drift Limit.', 1, 258, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(260, 32, '12.12.1.1', 'Moment Frames in Structures Assigned to Seismic Design Categories D through F.', 2, 259, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(261, 32, '12.12.2', 'Diaphragm Deflection.', 1, 258, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(262, 32, '12.12.3', 'Structural Separation.', 1, 258, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(263, 32, '12.12.4', 'Members Spanning between Structures.', 1, 258, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(264, 32, '12.12.5', 'Deformation Compatibility for Seismic Design Categories D through F.', 1, 258, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(265, 32, '12.13', 'Foundation Design', 0, 265, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(266, 32, '12.13.1', 'Design Basis.', 1, 265, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(267, 32, '12.13.2', 'Materials of Construction.', 1, 265, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(268, 32, '12.13.3', 'Foundation Load-Deformation Characteristics.', 1, 265, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(269, 32, '12.13.4', 'Reduction of Foundation Overturning.', 1, 265, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(270, 32, '12.13.5', 'Requirements for Structures Assigned to Seismic Design Category C.', 1, 265, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(271, 32, '12.13.5.1', 'Pole-Type Structures.', 2, 270, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(272, 32, '12.13.5.2', 'Foundation Ties.', 2, 270, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(273, 32, '12.13.5.3', 'Pile Anchorage Requirements.', 2, 270, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(274, 32, '12.13.6', 'Requirements for Structures Assigned to Seismic Design Categories D through F.', 1, 265, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(275, 32, '12.13.6.1', 'Pole-Type Structures.', 2, 274, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(276, 32, '12.13.6.2', 'Foundation Ties.', 2, 274, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(277, 32, '12.13.6.3', 'General Pile Design Requirement.', 2, 274, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(278, 32, '12.13.6.4', 'Batter Piles.', 2, 274, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(279, 32, '12.13.6.5', 'Pile Anchorage Requirements.', 2, 274, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(280, 32, '12.13.6.6', 'Splices of Pile Segments.', 2, 274, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(281, 32, '12.13.6.7', 'Pile Soil Interaction.', 2, 274, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(282, 32, '12.13.6.8', 'Pile Group Effects.', 2, 274, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(283, 32, '12.14', 'Simplified Alternative Structural Design Criteria For Simple Bearing Wall or Building Frame Systems', 0, 283, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(284, 32, '12.14.1', 'General', 1, 283, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(285, 32, '12.14.1.1', 'Simplified Design Procedure.', 2, 284, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(286, 32, '12.14.1.2', 'Reference Documents.', 2, 284, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(287, 32, '12.14.1.3', 'Definitions.', 2, 284, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(288, 32, '12.14.1.4', 'Notation', 2, 284, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(289, 32, '12.14.2', 'Design Basis.', 1, 283, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(290, 32, '12.14.3', 'Seismic Load Effects and Combinations.', 1, 283, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(291, 32, '12.14.3.1', 'Seismic Load Effect.', 2, 290, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(292, 32, '12.14.3.1.1', 'Horizontal Seismic Load Effect.', 2, 290, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(293, 32, '12.14.3.1.2', 'Vertical Seismic Load Effect.', 2, 290, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(294, 32, '12.14.3.1.3', 'Seismic Load Combinations.', 2, 290, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(295, 32, '12.14.3.2', 'Seismic Load Effect Including a 2.5 Overstrength Factor.', 1, 283, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(296, 32, '12.14.3.2.1', 'Horizontal Seismic Load Effect with a 2.5 Overstrength Factor.', 2, 295, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(297, 32, '12.14.3.2.2', 'Load Combinations with Overstrength Factor.', 2, 295, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(298, 32, '12.14.3.2.3', 'Allowable Stress Increase for Load Combinations with Overstrength.', 2, 295, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(299, 32, '12.14.4', 'Seismic Force-Resisting System', 1, 283, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(300, 32, '12.14.4.1', 'Selection and Limitations.', 2, 299, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(301, 32, '12.14.4.2', 'Combinations of Framing Systems', 2, 299, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(302, 32, '12.14.4.2.1', 'Horizontal Combinations.', 3, 301, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(303, 32, '12.14.4.2.2', 'Vertical Combinations.', 3, 301, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(304, 32, '12.14.4.2.3', 'Combination Framing Detailing Requirements.', 3, 301, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(305, 32, '12.14.5', 'Diaphragm Flexibility.', 1, 283, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(306, 32, '12.14.6', 'Application of Loading.', 1, 283, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(307, 32, '12.14.7', 'Design and Detailing Requirements.', 1, 283, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(308, 32, '12.14.7.1', 'Connections.', 2, 307, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(309, 32, '12.14.7.2', 'Openings or Reentrant Building Corners.', 2, 307, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(310, 32, '12.14.7.3', 'Collector Elements.', 2, 307, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(311, 32, '12.14.7.4', 'Diaphragms.', 2, 307, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(312, 32, '12.14.7.5', 'Anchorage of Structural Walls.', 2, 307, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(313, 32, '12.14.7.5.1', 'Transfer of Anchorage Forces into Diaphragms.', 3, 312, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(314, 32, '12.14.7.5.2', 'Wood Diaphragms.', 3, 312, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(315, 32, '12.14.7.5.3', 'Metal Deck Diaphragms.', 3, 312, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(316, 32, '12.14.7.5.4', 'Embedded Straps.', 3, 312, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(317, 32, '12.14.7.6', 'Bearing Walls and Shear Walls.', 3, 312, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(318, 32, '12.14.7.7', 'Anchorage of Nonstructural Systems.', 3, 312, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(319, 32, '12.14.8', 'Simplified Lateral Force Analysis Procedure.', 1, 283, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(320, 32, '12.14.8.1', 'Seismic Base Shear.', 2, 319, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(321, 32, '12.14.8.2', 'Vertical Distribution.', 2, 319, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(322, 32, '12.14.8.3', 'Horizontal Shear Distribution.', 2, 319, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(323, 32, '12.14.8.3.1', 'Flexible Diaphragm Structures.', 3, 322, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(324, 32, '12.14.8.3.2', 'Structures with Diaphragms that Are Not Flexible.', 3, 322, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(325, 32, '12.14.8.3.2.1', 'Torsion.', 4, 324, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(326, 32, '12.14.8.4', 'Overturning.', 2, 319, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(327, 32, '12.14.8.5', 'Drift Limits and Building Separation.', 2, 319, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(405, 33, '13.1', 'General', 0, 405, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(406, 33, '13.1.1', 'Scope.', 1, 405, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(407, 33, '13.1.2', 'Seismic Design Category.', 1, 405, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(408, 33, '13.1.3', 'Component Importance Factor.', 1, 405, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(409, 33, '13.1.4', 'Exemptions.', 1, 405, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(410, 33, '13.1.5', 'Application of Nonstructural Component Requirements to Nonbuilding Structures.', 1, 405, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(411, 33, '13.1.6', 'Reference Documents.', 1, 405, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(412, 33, '13.1.7', 'Reference Documents Using Allowable Stress Design.', 1, 405, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(413, 33, '13.2', 'General Design Requirements', 0, 413, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(414, 33, '13.2.1', 'Applicable Requirements for Architectural, Mechanical, and Electrical Components, Supports, and Attachments.', 1, 413, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(415, 33, '13.2.2', 'Special Certification Requirements for Designated Seismic Systems.', 1, 413, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(416, 33, '13.2.3', 'Consequential Damage.', 1, 143, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(417, 33, '13.2.4', 'Flexibility.', 1, 413, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(418, 33, '13.2.5', 'Testing Alternative for Seismic Capacity Determination.', 1, 413, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(419, 33, '13.2.6', 'Experience Data Alternative for Seismic Capacity Determination.', 1, 413, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(420, 33, '13.2.7', 'Construction Documents.', 1, 413, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(421, 33, '13.3', 'Seismic Demands on Nonstructural Components', 0, 421, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(422, 33, '13.3.1', 'Seismic Design Force.', 1, 421, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(423, 33, '13.3.2', 'Seismic Relative Displacements.', 1, 421, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(424, 33, '13.3.2.1', 'Displacements within Structures.', 2, 423, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(425, 33, '13.3.2.2', 'Displacements between Structures.', 2, 423, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(426, 33, '13.4', 'Nonstructural Component Anchorage', 0, 426, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(427, 33, '13.4.1', 'Design Force in the Attachment.', 1, 426, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(428, 33, '13.4.2', 'Anchors in Concrete or Masonry', 1, 426, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(429, 33, '13.4.2.1', 'Anchors in Concrete.', 2, 428, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(430, 33, '13.4.2.2', 'Anchors in Masonry.', 2, 428, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(431, 33, '13.4.2.3', 'Post-Installed Anchors in Concrete and Masonry.', 2, 428, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(432, 33, '13.4.3', 'Installation Conditions.', 1, 426, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(433, 33, '13.4.4', 'Multiple Attachments.', 1, 426, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(434, 33, '13.4.5', 'Power Actuated Fasteners.', 1, 426, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(435, 33, '13.4.6', 'Friction Clips.', 1, 426, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(436, 33, '13.5', 'Architectural Components', 0, 436, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(437, 33, '13.5.1', 'General.', 1, 436, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(438, 33, '13.5.2', 'Forces and Displacements.', 1, 436, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(439, 33, '13.5.3', 'Exterior Nonstructural Wall Elements and Connections.', 1, 436, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(440, 33, '13.5.4', 'Glass.', 1, 436, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(441, 33, '13.5.5', 'Out-of-Plane Bending.', 1, 436, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(442, 33, '13.5.6', 'Suspended Ceilings.', 1, 436, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(443, 33, '13.5.6.1', 'Seismic Forces.', 2, 442, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0');
INSERT INTO `m_section` (`m_sechid`, `m_secbokcid`, `m_seclabel`, `m_sectitle`, `m_seclevel`, `m_secmasterid`, `m_secseqorder`, `m_seclinkpage`, `m_createdbyuser`, `m_updatedbyuser`, `m_createddate`, `m_updateddate`, `m_secisreqfilter`, `m_secisintend`) VALUES
(444, 33, '13.5.6.2', 'Industry Standard Construction for Acoustical Tile or Lay-in Panel Ceilings.', 2, 442, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(445, 33, '13.5.6.2.1', 'Seismic Design Category C.', 3, 444, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(446, 33, '13.5.6.2.2', 'Seismic Design Categories D through F.', 3, 444, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(447, 33, '13.5.6.3', 'Integral Construction.', 2, 442, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(448, 33, '13.5.7', 'Access Floors', 1, 436, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(449, 33, '13.5.7.1', 'General.', 2, 448, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(450, 33, '13.5.7.2', 'Special Access Floors.', 2, 448, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(451, 33, '13.5.8', 'Partitions.', 1, 436, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(452, 33, '13.5.8.1', 'General.', 2, 448, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(453, 33, '13.5.8.2', 'Glass.', 2, 448, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(454, 33, '13.5.9', 'Glass in Glazed Curtain Walls, Glazed Storefronts, and Glazed Partitions', 1, 436, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(455, 33, '13.5.9.1', 'General.', 2, 454, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(456, 33, '13.5.9.2', 'Seismic Drift Limits for Glass Components.', 2, 454, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(457, 33, '13.6', 'Mechanical and Electrical Components', 0, 457, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(458, 33, '13.6.1', 'General.', 1, 457, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(459, 33, '13.6.2', 'Component Period.', 1, 457, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(460, 33, '13.6.3', 'Mechanical Components.', 1, 457, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(461, 33, '13.6.4', 'Electrical Components.', 1, 457, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(462, 33, '13.6.5', 'Component Supports.', 1, 457, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(463, 33, '13.6.5.1', 'Design Basis.', 2, 462, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(464, 33, '13.6.5.2', 'Design for Relative Displacement.', 2, 462, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(465, 33, '13.6.5.3', 'Support Attachment to Component.', 2, 462, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(466, 33, '13.6.5.4', 'Material Detailing Requirements.', 2, 462, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(467, 33, '13.6.5.5', 'Additional Requirements.', 2, 462, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(468, 33, '13.6.5.6', 'Conduit, Cable Tray, and Other Electrical Distribution Systems (Raceways).', 2, 462, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(469, 33, '13.6.6', 'Utility and Service Lines.', 1, 457, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(470, 33, '13.6.7', 'Ductwork.', 1, 457, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(471, 33, '13.6.8', 'Piping Systems.', 1, 457, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(472, 33, '13.6.8.1', 'ASME Pressure Piping Systems.', 2, 471, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(473, 33, '13.6.8.2', 'Fire Protection Sprinkler Piping Systems.', 2, 471, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(474, 33, '13.6.8.3', 'Exceptions.', 2, 471, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(475, 33, '13.6.9', 'Boilers and Pressure Vessels.', 1, 457, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(476, 33, '13.6.10', 'Elevator and Escalator Design Requirements.', 1, 457, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(477, 33, '13.6.10.1', 'Escalators, Elevators, and Hoistway Structural System.', 2, 476, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(478, 33, '13.6.10.2', 'Elevator Equipment and Controller Supports and Attachments.', 2, 476, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(479, 33, '13.6.10.3', 'Seismic Controls for Elevators.', 2, 476, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(480, 33, '13.6.10.4', 'Retainer Plates.', 2, 476, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(481, 33, '13.6.11', 'Other Mechanical and Electrical Components.', 1, 457, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(482, 34, '15.1', 'General', 0, 481, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(483, 34, '15.1.1', 'Nonbuilding Structures.', 1, 482, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(484, 34, '15.1.2', 'Design.', 1, 482, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(485, 34, '15.1.3', 'Structural Analysis Procedure Selection.', 1, 482, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(486, 34, '15.2', 'Reference Documents', 0, 486, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(487, 34, '15.3', 'Nonbuilding Structures Supported By Other Structures', 0, 487, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(488, 34, '15.3.1', 'Less than 25% Combined Weight Condition.', 1, 487, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(489, 34, '15.3.2', 'Greater than or Equal to 25% Combined Weight Condition.', 1, 487, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(490, 34, '15.3.3', 'Architectural, Mechanical, and Electrical Components.', 1, 487, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(491, 34, '15.4', 'Structural Design Requirements', 0, 491, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(492, 34, '15.4.1', 'Design Basis.', 1, 491, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(493, 34, '15.4.1.1', 'Importance Factor.', 2, 492, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(494, 34, '15.4.2', 'Rigid Nonbuilding Structures.', 1, 491, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(495, 34, '15.4.3', 'Loads.', 1, 491, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(496, 34, '15.4.4', 'Fundamental Period.', 1, 491, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(497, 34, '15.4.5', 'Drift Limitations.', 1, 491, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(498, 34, '15.4.6', 'Materials Requirements.', 1, 491, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(499, 34, '15.4.7', 'Deflection Limits and Structure Separation.', 1, 491, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(500, 34, '15.4.8', 'Site-Specific Response Spectra.', 1, 491, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(501, 34, '15.4.9', 'Anchors in Concrete or Masonry.', 1, 491, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(502, 34, '15.4.9.1', 'Anchors in Concrete.', 2, 501, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(503, 34, '15.4.9.2', 'Anchors in Masonry.', 2, 501, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(504, 34, '15.4.9.3', 'Post-Installed Anchors in Concrete and Masonry.', 2, 501, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(505, 34, '15.5', 'Nonbuilding Structures Similar To Buildings.', 0, 504, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(506, 34, '15.5.1', 'General.', 1, 505, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(507, 34, '15.5.2', 'Pipe Racks', 1, 505, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(508, 34, '15.5.2.1', 'Design Basis.', 2, 507, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(509, 34, '15.5.3', 'Steel Storage Racks.', 1, 505, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(510, 34, '15.5.3.1', '', 2, 509, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(511, 34, '15.5.3.2', '', 2, 509, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(512, 34, '15.5.3.4', 'Alternative.', 2, 509, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(513, 34, '15.5.3.5', 'General Requirements.', 2, 509, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(514, 34, '15.5.3.6', 'Operating Weight.', 2, 509, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(515, 34, '15.5.3.7', 'Vertical Distribution of Seismic Forces.', 2, 509, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(516, 34, '15.5.3.8', 'Seismic Displacements.', 2, 509, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(517, 34, '15.5.4', 'Electrical Power Generating Facilities', 1, 505, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(518, 34, '15.5.4.1', 'General.', 2, 517, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(519, 34, '15.5.4.2', 'Design Basis.', 2, 517, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(520, 34, '15.5.5', 'Structural Towers for Tanks and Vessels', 1, 505, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(521, 34, '15.5.5.1', 'General.', 2, 520, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(522, 34, '15.5.6', 'Piers and Wharves', 1, 505, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(523, 34, '15.5.6.1', 'General.', 2, 522, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(524, 34, '15.5.6.2', 'Design Basis.', 2, 552, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(525, 34, '15.6', 'General Requirements For Nonbuilding Structures Not Similar To Buildings', 0, 525, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(526, 34, '15.6.1', 'Earth-Retaining Structures.', 1, 525, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(527, 34, '15.6.2', 'Stacks and Chimneys.', 1, 525, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(528, 34, '15.6.3', 'Amusement Structures.', 1, 525, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(529, 34, '15.6.4', 'Special Hydraulic Structures.', 1, 525, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(530, 34, '15.6.4.1', 'Design Basis.', 2, 529, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(531, 34, '15.6.5', 'Secondary Containment Systems.', 1, 525, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(532, 34, '15.6.5.1', 'Freeboard.', 2, 531, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(533, 34, '15.6.6', 'Telecommunication Towers.', 1, 525, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(534, 34, '15.7', 'Tanks And Vessels', 0, 534, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(535, 34, '15.7.1', 'General.', 1, 534, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(536, 34, '15.7.2', 'Design Basis.', 1, 534, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(537, 34, '15.7.3', 'Strength and Ductility.', 1, 534, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(538, 34, '15.7.4', 'Flexibility of Piping Attachments.', 1, 534, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(539, 34, '15.7.5', 'Anchorage.', 1, 534, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(540, 34, '15.7.6', 'Ground-Supported Storage Tanks for Liquids', 1, 534, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(541, 34, '15.7.6.1', 'General.', 2, 540, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(542, 34, '15.7.6.1.1', 'Distribution of Hydrodynamic and Inertia Forces.', 3, 541, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(543, 34, '15.7.6.1.2', 'Sloshing.', 3, 541, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(544, 34, '15.7.6.1.3', 'Equipment and Attached Piping.', 3, 541, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(545, 34, '15.7.6.1.4', 'Internal Elements.', 3, 541, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(546, 34, '15.7.6.1.5', 'Sliding Resistance.', 3, 541, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(547, 34, '15.7.6.1.6', 'Local Shear Transfer.', 3, 541, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(548, 34, '15.7.6.1.7', 'Pressure Stability.', 3, 541, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(549, 34, '15.7.6.1.8', 'Shell Support.', 3, 541, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(550, 34, '15.7.6.1.9', 'Repair, Alteration, or Reconstruction.', 3, 541, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(551, 34, '15.7.7', 'Water Storage and Water Treatment Tanks and Vessels.', 1, 534, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(552, 34, '15.7.7.1', 'Welded Steel.', 2, 551, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(553, 34, '15.7.7.2', 'Bolted Steel.', 2, 551, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(554, 34, '15.7.7.3', 'Reinforced and Prestressed Concrete.', 2, 551, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(555, 34, '15.7.8', 'Petrochemical and Industrial Tanks and Vessels Storing Liquids.', 1, 534, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(556, 34, '15.7.8.1', 'Welded Steel.', 2, 555, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(557, 34, '15.7.8.2', 'Bolted Steel.', 2, 555, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(558, 34, '15.7.8.3', 'Reinforced and Prestressed Concrete.', 2, 555, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(559, 34, '15.7.9', 'Ground-Supported Storage Tanks for Granular Materials.', 1, 534, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(560, 34, '15.7.9.1', 'General.', 2, 559, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(561, 34, '15.7.9.2', 'Lateral Force Determination.', 2, 559, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(562, 34, '15.7.9.3', 'Force Distribution to Shell and Foundation.', 2, 559, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(563, 34, '15.7.9.3.1', 'Increased Lateral Pressure.', 3, 562, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(564, 34, '15.7.9.3.2', 'Effective Mass.', 3, 562, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(565, 34, '15.7.9.3.3', 'Effective Density.', 3, 562, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(566, 34, '15.7.9.3.4', 'Lateral Sliding.', 3, 552, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(567, 34, '15.7.9.3.5', 'Combined Anchorage Systems.', 3, 552, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(568, 34, '15.7.9.4', 'Welded Steel Structures.', 2, 559, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(569, 34, '15.7.9.5', 'Bolted Steel Structures.', 2, 559, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(570, 34, '15.7.9.6', 'Reinforced Concrete Structures.', 2, 559, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(571, 34, '15.7.9.7', 'Prestressed Concrete Structures.', 2, 559, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(572, 34, '15.7.10', 'Elevated Tanks and Vessels for Liquids and Granular Materials', 1, 534, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(573, 34, '15.7.10.1', 'General.', 2, 572, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(574, 34, '15.7.10.2', 'Effective Mass.', 2, 572, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(575, 34, '15.7.10.3', 'P-Delta Effects.', 2, 572, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(576, 34, '15.7.10.4', 'Transfer of Lateral Forces into Support Tower.', 2, 572, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(577, 34, '15.7.10.5', 'Evaluation of Structures Sensitive to Buckling Failure.', 2, 572, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(578, 34, '15.7.10.6', 'Welded Steel Water Storage Structures.', 2, 572, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(579, 34, '15.7.10.7', 'Concrete Pedestal (Composite) Tanks.', 2, 572, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(580, 34, '15.7.10.7.1', 'Analysis Procedures.', 3, 579, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(581, 34, '15.7.10.7.2', 'Structure Period.', 3, 579, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(582, 34, '15.7.11', 'Boilers and Pressure Vessels', 1, 534, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(583, 34, '15.7.11.1', 'General.', 2, 582, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(584, 34, '15.7.11.2', 'ASME Boilers and Pressure Vessels.', 2, 582, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(585, 34, '15.7.11.3', 'Attachments of Internal Equipment and Refractory.', 2, 582, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(586, 34, '15.7.11.4', 'Coupling of Vessel and Support Structure.', 2, 582, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(587, 34, '15.7.11.5', 'Effective Mass.', 2, 582, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(588, 34, '15.7.11.6', 'Other Boilers and Pressure Vessels.', 2, 582, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(589, 34, '15.7.11.7', 'Supports and Attachments for Boilers and Pressure Vessels.', 2, 582, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(590, 34, '15.7.12', 'Liquid and Gas Spheres', 1, 534, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(591, 34, '15.7.12.1', 'General.', 2, 590, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(592, 34, '15.7.12.2', 'ASME Spheres.', 2, 590, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(593, 34, '15.7.12.3', 'Attachments of Internal Equipment and Refractory.', 2, 590, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(594, 34, '15.7.12.4', 'Effective Mass.', 2, 590, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(595, 34, '15.7.12.5', 'Post and Rod Supported.', 2, 590, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(596, 34, '15.7.12.6', 'Skirt Supported.', 2, 590, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(597, 34, '15.7.13', 'Refrigerated Gas Liquid Storage Tanks and Vessels', 1, 534, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(598, 34, '15.7.13.1', 'General.', 2, 597, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(599, 34, '15.7.14', 'Horizontal, Saddle-Supported Vessels for Liquid or Vapor Storage', 1, 534, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(600, 34, '15.7.14.1', 'General.', 2, 599, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(601, 34, '15.7.14.2', 'Effective Mass.', 2, 599, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(602, 34, '15.7.14.3', 'Vessel Design.', 2, 599, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(603, 35, '29.1', 'Scope', 0, 603, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(604, 35, '29.1.1', 'Structure Types.', 1, 603, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(605, 35, '29.1.2', 'Conditions.', 1, 603, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(606, 35, '29.1.3', 'Limitations.', 1, 603, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(607, 35, '29.1.4', 'Shielding.', 1, 603, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(608, 35, '29.2', 'General Requirements', 0, 608, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(609, 35, '29.2.1', 'Wind Load Parameters Specified in Chapter \\n26.', 1, 608, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(610, 35, '29.3', 'Velocity Pressure', 0, 610, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(611, 35, '29.3.1', 'Velocity Pressure Exposure Coefficient.', 1, 610, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(612, 35, '29.3.2', 'Velocity Pressure.', 1, 610, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(613, 35, '29.4', 'Design Wind Loads—Solid Freestanding Walls and Solid Signs', 0, 613, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(614, 35, '29.4.1', 'Solid Freestanding Walls and Solid Freestanding Signs, Other Structures.', 1, 613, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(615, 35, '29.4.2', 'Solid Attached Signs.', 1, 613, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(616, 35, '29.5', 'Design Wind Loads—Other Structures', 0, 616, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(617, 35, '29.5.1', 'Rooftop Structures And Equipment For Buildings With \\nh≤60ft (18.3 m).', 1, 616, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(618, 35, '29.6', 'Parapets', 0, 0, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(619, 35, '29.7', 'Roof Overhangs', 0, 619, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0'),
(620, 35, '29.8', 'Minimum Design Wind Loading', 0, 620, 0, NULL, '', '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0', '0');

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

--
-- Dumping data for table `m_user`
--

INSERT INTO `m_user` (`m_usrid`, `m_usrwebid`, `m_usrroleid`, `m_username`, `m_password`, `m_token`, `m_activated`, `m_banned`, `m_ban_reason`, `m_new_password_key`, `m_new_password_requested`, `m_usrfirstname`, `m_usrlastname`, `m_usrimglink`, `m_usraddress`, `m_usremailid`, `m_new_email`, `m_new_email_key`, `m_last_ip`, `m_last_login`, `m_created`, `m_updated`, `m_usrzipcode`, `m_usrtown`, `m_usrprovid`, `m_usrlastvisiteddate`, `m_usrsessionid`, `m_usrlastaccbookid`) VALUES
(1, 0, 0, 'arulkumar', '$2a$08$mQ4llcQAc/aiFZ1GTyUAku/63OKc/wgLn/m5M3/WRLu', '881a979af560b01077637ad39a7b02db', 0, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'arulbtech@gmail.com', NULL, '13b3d86129b773568dd8bfe46f1f9ff7', '192.168.27.55', '0000-00-00 00:00:00', '2015-07-14 08:47:08', '0000-00-00 00:00:00', NULL, '', 0, '0000-00-00 00:00:00', '', 0);

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

--
-- Dumping data for table `m_volume`
--

INSERT INTO `m_volume` (`m_volid`, `m_volbokid`, `m_volseqno`, `m_volpageid`, `m_voltitle`, `m_volsubtitle`, `m_volimgsize`, `m_volimgpath`, `m_vollangid`, `m_volauthor`, `m_volauthdesc`) VALUES
(1, 1, 1, 1, 'vol title', NULL, NULL, NULL, 1, NULL, NULL);

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

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `m_usrwebid`, `m_usrroleid`, `username`, `password`, `m_usrfirstname`, `m_usrlastname`, `m_usraddress`, `token`, `email`, `activated`, `m_usrlastaccbookid`, `banned`, `ban_reason`, `new_password_key`, `new_password_requested`, `new_email`, `new_email_key`, `last_ip`, `last_login`, `m_usrzipcode`, `m_usrtown`, `created`, `modified`) VALUES
(1, 0, 0, 'arulkumar', '$2a$08$PukRFiJcQcWhi7YPtXuDFOm7hoKjXQydgfwOPciebt0FL6iV74Hi6', 'arulkumar', 'sankarlal', 'plot no:20 Door No:3 Saraswathi Nagar 5th street adambakkam', 'X*d95Cp_U8Pz@4A', 'arulbtech@gmail.com', 1, 1, 0, NULL, NULL, NULL, NULL, '48523dec4f370d0d498289f48b515b0c', '192.168.27.55', '2015-07-15 10:59:06', '600088', 'Adambakkam', '2015-07-14 09:11:30', '2015-07-15 08:59:06');

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
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `country`, `website`) VALUES
(1, 1, NULL, NULL),
(2, 1, NULL, NULL),
(3, 2, NULL, NULL);

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
