
/*
Author 		: Arulkumar 
Requirement : Add panel Type
Solution 	: Define pages or commentry
Created 	: 06.10.2015
*/

ALTER TABLE `m_content` ADD `m_cntpaneltype` VARCHAR(100) NOT NULL AFTER `m_cnttype`;

ALTER TABLE `m_chapter` ADD `m_chppaneltype` VARCHAR( 100 ) NOT NULL AFTER `m_chpseqorder`; 

ALTER TABLE `m_section` ADD `m_secpaneltype` VARCHAR( 100 ) NOT NULL AFTER `m_secvid`; 

ALTER TABLE `m_content` ADD `m_cntcreatedby` DATETIME NOT NULL AFTER `m_cntpaneltype` ,
ADD `m_cntupdatedby` DATETIME NOT NULL AFTER `m_cntcreatedby`;
ALTER TABLE `m_book` ADD `m_boklangid` SMALLINT( 11 ) NOT NULL AFTER `m_bokdesc`;  


/*
Author 		: satheesh 
Requirement : language management
Solution 	: define language code
Created 	: 07.10.2015
*/


alter table `asce`.`m_language` 
   add column `m_lancode` varchar(30) null after `m_lanname`;
   
   /*
Author 		: Arulkumar 
Requirement : history management
Solution 	: table creation
Created 	: 08.10.2015
*/
   
   CREATE TABLE IF NOT EXISTS `m_history` (
  `m_histid` int(11) NOT NULL AUTO_INCREMENT,
  `m_histlinkid` varchar(100) NOT NULL,
  `m_histchapid` int(11) NOT NULL,
  `m_histvolid` int(11) NOT NULL,
  `m_histlabel` varchar(100) NOT NULL,
  `m_histtitle` longtext NOT NULL,
  `m_histdescription` longtext NOT NULL,
  `m_histcurcontent` longtext NOT NULL,
  `m_histnewcontent` longtext NOT NULL,
  `m_histusrid` int(11) NOT NULL,
  `m_histtype` varchar(100) NOT NULL,
  `m_histpaneltype` varchar(100) NOT NULL,
  `m_histcreatedby` varchar(100) NOT NULL,
  `m_histupdatedby` varchar(100) NOT NULL,
  `m_histcreateddate` datetime NOT NULL,
  `m-histupdateddate` datetime NOT NULL,
  PRIMARY KEY (`m_histid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `m_chapter` CHANGE `m_chlinkpage` `m_chlinkpage` VARCHAR( 100 ) NOT NULL COMMENT 'Book Link Page',
CHANGE `m_chpseqorder` `m_chpseqorder` VARCHAR( 100 ) NOT NULL COMMENT 'Chapter Sequence No. The chapters will be display based on this no. but no need to display this number'

ALTER TABLE `m_chapter` ADD `m_chpfilename` VARCHAR( 100 ) NOT NULL AFTER `m_chptitle`

   /*
Author 		: Arulkumar 
Requirement : Book management
Solution 	: table creation
Created 	: 19.10.2015
*/

ALTER TABLE `m_book` CHANGE `m_bokdesc` `m_bokdesc` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Book Description';
ALTER TABLE `m_book` ADD `m_boknamedes` MEDIUMTEXT NOT NULL AFTER `m_bokname`;
ALTER TABLE `m_book` ADD `m_bokauthorname` VARCHAR( 100 ) NOT NULL AFTER `m_boknamedes`;
ALTER TABLE `m_book` ADD `m_bokprice` VARCHAR( 100 ) NOT NULL AFTER `m_bokdesc`; 

/*
Author 		: Arulkumar 
Requirement : Book management
Solution 	: table creation
Created 	: 20.10.2015
*/
ALTER TABLE `m_book` CHANGE `m_bokname` `m_boktitle` VARCHAR( 400 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'Book Name',
CHANGE `m_boknamedes` `m_boksubtitle` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `m_book` CHANGE `m_bokprice` `m_bokprice` INT( 11 ) NOT NULL; 

/*
Author 		: satheesh 
Requirement : book thumbnail image
Solution 	: define language code
Created 	: 26.10.2015
*/

alter table m_book    add column m_bokthump varchar(255) null comment 'Book thumbnail image' after m_boklangid;

/*
Author 		: Arulkumar 
Requirement : book thumbnail image
Solution 	: define language code
Created 	: 29.10.2015
*/
ALTER TABLE `m_chapter` ADD `m_chptoctype` VARCHAR( 100 ) NOT NULL AFTER `m_chppaneltype` 