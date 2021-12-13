
/*
Author 		: Arul
Requirement : Add new table for search module 
Solution 	: 
Created 	: 28.09.2015
*/


CREATE TABLE IF NOT EXISTS `m_content` (
  `m_cntid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `m_cntsecid` varchar(100) NOT NULL,
  `m_cntchapid` int(11) NOT NULL,
  `m_cntvolid` int(11) NOT NULL,
  `m_cntlabel` varchar(100) NOT NULL,
  `m_cnttitle` varchar(100) NOT NULL,
  `m_cntcaption` longtext CHARACTER SET latin1 NOT NULL,
  `m_cnttype` varchar(100) NOT NULL,
  `m_cntcreateddate` datetime NOT NULL,
  `m_cntupdateddate` datetime NOT NULL,
  PRIMARY KEY (`m_cntid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*
Author 		: Arul
Requirement : Add new column for section table 
Solution 	: 
Created 	: 28.09.   
*/

ALTER TABLE `m_section` ADD `m_secvid` INT( 11 ) NOT NULL AFTER `m_secbokcid`;

/*
Author 		: Arul
Requirement : Services for content 
Solution 	: 
Created 	: 28.09.2015
*/

Service : Book
Method: contentdetails

/*
Author 		: Arul
Requirement : Filter option for content search 
Solution 	: 
Created 	: 29.09.2015
*/
1. Chapter
2. Section
3. Table
4. Figure


Service : Searchcontent
Method: contentdetails

ALTER TABLE `m_content` CHANGE `m_cntsecid` `m_cntlinkid` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;


/*
Author 		: satheesh 
Requirement : Limit string length 
Solution 	: Defined a mysql function
Created 	: 28.09.2015
*/



delimiter $$

drop function if exists `getLimitString`$$

create function `getLimitString`( raw longtext, strSerch longtext ) returns longtext charset utf8
    deterministic
begin
	declare iStart, iEnd, iLength, iPos int;
	declare returnString longtext;
	set strSerch = TRIM(strSerch);
	set iLength = 200;
	set iPos = POSITION(strSerch in raw);
	if iLength > LENGTH(raw) then
		set returnString = raw;
	elseif iPos>0 then
		if (iLength/2) > iPos then
			set returnString = SUBSTRING(raw, 1, iLength);
		else
			set returnString = SUBSTRING(raw, (iPos- (iLength/2)) , iLength);
		end if;
	end if ;
	if LENGTH(returnString) > (iLength/2) then
		set returnString = SUBSTRING(returnString, POSITION(' ' in returnString)+1  , iLength);
	end if;
	
	return returnString;
end$$

delimiter ;

/*
Author 		: satheesh 
Requirement : Limit string length 
Solution 	: Defined a mysql function
Created 	: 28.09.2015
*/


delimiter $$

drop function if exists `getLimitString`$$

create function `getLimitString`( raw longtext, strSerch longtext ) returns longtext charset utf8
    deterministic
begin
	declare iStart, iEnd, iLength, iPos int;
	declare returnString longtext;
	set strSerch = TRIM(strSerch);
	set iLength = 100;
	set iPos = POSITION(strSerch in raw);
	if iLength > LENGTH(raw) then
		set returnString = raw;
	elseif iPos>0 then
		if (iLength/2) > iPos then
			set returnString = SUBSTRING(raw, 1, iLength);
		else
			set returnString = SUBSTRING(raw, (iPos- (iLength/2)) , iLength);
		end if;
	end if ;
	if (LENGTH(returnString) > (iLength/2)) and (POSITION(strSerch in returnString) = 0) then
		set returnString = SUBSTRING(returnString, POSITION(' ' in returnString)+1  , iLength);
	end if;
	
	return returnString;
end$$

delimiter ;


/*
Author 		: satheesh 
Requirement : Limit string length 
Solution 	: Defined a mysql function
Created 	: 01.10.2015
*/



delimiter $$
drop function if exists `getLimitString`$$

create function `getLimitString`( raw longtext, strSerch longtext ) returns longtext charset utf8
    deterministic
begin
	declare iStart, iEnd, iLength, iPos int;
	declare returnString longtext;
	set strSerch = TRIM(strSerch);
	set iLength = 100;
	set iPos = POSITION(strSerch in raw);
	if iLength > LENGTH(raw) then
		set returnString = raw;
	elseif iPos>0 then
		if (iLength/2) > iPos then
			set returnString = SUBSTRING(raw, 1, iLength);
		else
			set returnString = SUBSTRING(raw, (iPos- (iLength/2)) , iLength);
		end if;
	end if ;
	if (LENGTH(returnString) > (iLength/2)) and (POSITION(strSerch in returnString) = 0) then
		set returnString = SUBSTRING(returnString, POSITION(' ' in returnString)+1  , iLength);
	end if;
	
	if ( iPos < 1 ) then
		set returnString = SUBSTRING(raw, 1 , iLength);
	end if;
	
	if iLength < LENGTH(raw)  then
		set returnString = SUBSTRING( returnString , 1, LENGTH(returnString) - LOCATE(' ', REVERSE(returnString)));
	end if;
	
	if ( ( POSITION(returnString in raw) + LENGTH(returnString) ) < LENGTH(raw) && iLength < LENGTH(raw) ) then
		set returnString = CONCAT(returnString ,'...');
	end if;
	
	return returnString;
end$$

delimiter ;
