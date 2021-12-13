
/*
Author 		: Arulkumar 
Requirement : create table custom book
Solution 	: select user custom book option
Created 	: 03.11.2015
*/

/*
Author   : Arulkumar 
Requirement : create table custom book
Solution  : select user custom book option
Created  : 03.11.2015
*/

CREATE TABLE IF NOT EXISTS `m_custbook` (
  `m_custbokid` int(11) NOT NULL AUTO_INCREMENT,
  `m_custmbokid` int(11) NOT NULL,
  `m_custbokvid` int(11) NOT NULL,
  `m_custboktitle` varchar(200) NOT NULL,
  `m_custbokdescription` mediumtext NOT NULL,
  `m_custchpvalidfrom` datetime NOT NULL,
  `m_custchpvalidto` datetime NOT NULL,
  `m_custchpprice` int(11) NOT NULL,
  `m_custbokthumb` varchar(100) NOT NULL,
  `m_custbokcreatedby` varchar(100) NOT NULL,
  `m_custbokupdatedby` varchar(100) NOT NULL,
  `m_custbokcreateddate` datetime NOT NULL,
  `m_custbokupdateddate` datetime NOT NULL,
  PRIMARY KEY (`m_custbokid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `t_custbookchapter` (
  `t_custchpid` int(11) NOT NULL AUTO_INCREMENT,
  `t_custchpcbokid` int(11) NOT NULL,
  `t_custchpmchpid` int(11) NOT NULL,
  `t_custchpbokvid` int(11) NOT NULL,
  `t_custchpcreateby` varchar(100) NOT NULL,
  `t_custchpupdatedby` varchar(100) NOT NULL,
  `t_custchpcreateddate` datetime NOT NULL,
  `t_custchpupdateddate` datetime NOT NULL,
  PRIMARY KEY (`t_custchpid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


ALTER TABLE `m_custbook` CHANGE `m_custchpvalidfrom` `m_custbokvalidfrom` DATETIME NOT NULL ,
CHANGE `m_custchpvalidto` `m_custbokvalidto` DATETIME NOT NULL ,
CHANGE `m_custchpprice` `m_custbokprice` INT( 11 ) NOT NULL 

/*
Author   : Arulkumar 
Requirement : Column name change in bookmark,notes and highlight
Solution  : select user custom book option
Created  : 03.11.2015
*/
ALTER TABLE `t_bookmark` CHANGE `t_bmkvolid` `t_bmkcus_book_id` SMALLINT( 5 ) UNSIGNED NOT NULL;
ALTER TABLE `t_txthighlight` CHANGE `t_txhvolid` `t_txhcus_book_id` INT( 11 ) NOT NULL;
ALTER TABLE `t_txtnotes` CHANGE `t_txnvolid` `t_txncus_book_id` MEDIUMINT( 9 ) NOT NULL; 

ALTER TABLE `t_txthighlight` CHANGE `t_txhcus_book_id` `t_txhcus_book_id` INT( 11 ) NOT NULL;
ALTER TABLE `t_txtnotes` CHANGE `t_txncus_book_id` `t_txncus_book_id` INT( 11 ) NOT NULL; 

 