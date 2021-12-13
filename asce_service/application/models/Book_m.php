<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Book_m extends CI_Model {
	private $table_name = 'users'; // user accounts
	private $session_table_name = 'ci_sessions';
	private $profile_table_name = 'user_profiles';
	private $section_tablename = 'm_section'; // Sections
	private $content_tablename = 'm_content'; // Contents
	private $loggedTable = 'asce_noof_login'; //
	function __construct() {
		parent::__construct ();
	}
	
	// Get user information
	function userinfo_get($userid) {
		$this->db->select ( 'id,email,username,m_usrfirstname,m_usrlastname,m_usraddress,m_usrzipcode' );
		$this->db->from ( 'users' );
		$this->db->where ( array (
				'id' => $userid 
		) );
		$query = $this->db->get ();
		//echo $this->db->last_query(); die;
		return $query->result ();
		// return $ret[0]=email;
	}
	
	function subuserinfo_gets($email) {
	    //print_r($email); die;
		$this->db->select ( 'master_id' );
		$this->db->from ( 'asce_institute_email_auth' );
		$this->db->where ( array (
				'email' => $email 
		) );
		$query = $this->db->get ();
		$result =$query->result ();
		if($result)
		{
		   return 'subuser';
		}
		else if(!$result)
		{
			$lic='C';
		  $this->db->select ( 'm_licence_type' );
		$this->db->from ( 'asce_licences' );
		$this->db->where ( array (
				'm_primaryemail' => $email,
                'm_custtype'=>$lic			
		) );
		$this->db->group_by('m_licence_type'); 
		$query = $this->db->get ();
		//echo $this->db->last_query(); die;
		$result= $query->result();
		//echo count($result[0]); die;
		
		//print_r($result); die;
		
		if($result)
		{
		
		return 'subuser';
		
		}
		
	 if(!$result)
		{
			$lic='I';
			 $this->db->select ( 'm_licence_type' );
		$this->db->from ( 'asce_licences' );
		$this->db->where ( array (
				'm_primaryemail' => $email,
                'm_custtype'=>$lic			
		) );
		$this->db->group_by('m_licence_type'); 
		$query = $this->db->get ();
		//echo $this->db->last_query(); die;
		$result= $query->result();
		}
		if(!$result)
		{
			return 'subuser';
		}
		if($result)
		{
			if($result[0]->m_licence_type=="SINGLE")
		{
		return 'subuser';
		}
		elseif($result[0]->m_licence_type!="SINGLE")
		{
			//echo"fhfhfh"; die;
		return 'admin';	
		}
		}
		
		}
		//return ($result['master_id'])?true:false;
		
	}
	
	function subuserorderinfo_gets($orderid)
	{
		  $this->db->select ( '*' );
		$this->db->from ( 'asce_licences' );
		$this->db->where ( array (
				'm_orderid' => $orderid 
		) );
		$query = $this->db->get ();
		$result =$query->result ();
		if($result)
		{
		   return 'subuser';
		}
	}
	
	function subuserComoninfo_gets($email)
	{
		  //print_r($email); die;
		$this->db->select ( 'master_id' );
		$this->db->from ( 'asce_institute_email_auth' );
		$this->db->where ( array (
				'email' => $email 
		) );
		$query = $this->db->get ();
		$result =$query->result ();
		if($result)
		{
		   return 'subuser';
		}
		else
		{
			$lic='I';
		  $this->db->select ( 'm_licence_type' );
		$this->db->from ( 'asce_licences' );
		$this->db->where ( array (
				'm_primaryemail' => $email,
                 'm_custtype'=>	$lic			
		) );
		$this->db->group_by('m_licence_type'); 
		$query = $this->db->get ();
		//echo $this->db->last_query(); die;
		$result= $query->result ();
		//print_r($result);
		
		return $result;
		
		if(!$result)
		{
		return 'subuser';	
		}
		}
		//return ($result['master_id'])?true:false;
		
	}
	
	
	
function subuserinfo_get($email) {
   $this->db->select ( 'master_id' );
		$this->db->from ( 'asce_institute_email_auth' );
		$this->db->where ( array (
				'email' => $email 
		) );
		$query = $this->db->get ();
		$result= $query->result ();
		//print_r($result);
		
		return $result;
	}
	
	
	// Get session details
	function ses_get() {
		$this->db->select ( 'id,token' );
		$this->db->from ( 'ci_sessions' );
		$query = $this->db->get ();
		return $query->result ();
	}
	function SelectUser($user_id) {
		// echo $user_id; die;
		$this->db->select ( '*' );
		$this->db->from ( 'users' );
		$this->db->where ( 'master_id', $user_id );
		$query = $this->db->get ();
		//$query= $this->db->last_query();
	//echo $query; die;
		return $query->result ();
	}
	// custom chapter get
	function custom_chapters_get($custom_bookid) {
		$this->db->select ( 'm_chapter.m_chpid chapId, m_chapter.m_chlinkpage chapSrc, m_chapter.m_chpseqorder chapSeq, m_chapter.m_chppaneltype chappaneltype, m_chapter.m_chplabel chapLabel, m_chapter.m_chptitle chapTitle, m_chapter.m_chppaneltype chapPaneltype, m_chptoctype contenttype' );
		$this->db->from ( 'm_chapter' );
		$this->db->join ( 't_custbookchapter', 'm_chpid = t_custchpmchpid', 'inner' );
		$this->db->where ( array (
				't_custchpcbokid' => $custom_bookid 
		) );
		$this->db->order_by ( "m_chptoctype", "desc" );
		$this->db->order_by ( "chapSeq" );
		$query = $this->db->get ();
		// echo $this->db->last_query();
		return $query->result ();
	}
	/* ------------------------------For Getting All Data For History Panel----------- */
	// custom chapter get
	function getAllHistoryContents($bok_id,$typeofHistory='') {
                if($typeofHistory == ''){
					$typeofHistory = 'diff_edition';
				}
                
                $this->db->select ( 'id,book_id,DATE_FORMAT(created_date,"%d/%b/%Y") as created_date,version,DATE_FORMAT(final_version,"%m-%d-%Y") as final_version,chapter_no,section_no,data' );
                $this->db->from ( 'asce_content_data' );
                $this->db->where ( array (
                                'book_id' => $bok_id ,'history_type'=>$typeofHistory
                ) );
                //$this->db->order_by ( "chapter_no asc,final_version desc" );
                $this->db->order_by ( "id asc" );
                $query = $this->db->get ();
                return $query->result ();
	}
	/* -----------------------------------------------End------------------------------ */
	/* --------------------------------------Method Overloading----------------------------------- */
	/* ------------------------------For Getting All Data For History Panel----------- */
	// custom chapter get
	function getAllHistoryContentsDynamic($bok_id, $searchType, $chapterNo, $commentaryNo,$chapControl, $versionControl) {
		$this->db->select ( 'id,book_id,DATE_FORMAT(created_date,"%d/%b/%Y") as created_date,version,DATE_FORMAT(final_version,"%m-%d-%Y") as final_version,chapter_no,section_no,data' );
		$this->db->from ( 'asce_content_data' );
		$this->db->where ( 'book_id', $bok_id );
		if ($chapControl == 'current_chapter') {
			$historyChapter=strstr($chapterNo, '_', true);
			if($historyChapter!=false)
				$chapterNo=$historyChapter;
			$this->db->where ( 'chapter_no', $chapterNo );
		}
		$this->db->order_by ( "final_version desc" );
		$query = $this->db->get ();
		$completeQuery = $this->db->last_query ();
		return $query->result ();
	}
	/*----------------------------------- Getting History Contents Different Edition ----------------------*/
	function getAllHistoryContentsDiffEdition($bok_id, $searchType, $chapterNo, $commentaryNo,$chapControl, $versionControl) {
		$this->db->select ( 'history_version.book_one_id,history.version_id,history.chapter_no,history.section_no,history.data,history.filenamed,history.created_date' );
		$this->db->from ( 'asce_version_history history_version' );
		$this->db->join('asce_history history','history_version.version_id=history.version_id','inner');
		$this->db->where ( 'history_version.book_one_id', $bok_id );
		$this->db->where ( 'history_version.active_status',1 );
		if ($chapControl != 'all_chapter') {
			$historyChapter=strstr($chapterNo, '_', true);
			if($historyChapter!=false)
			$chapterNo=$historyChapter;
			$this->db->where ( 'history.chapter_no', $chapterNo );
		}
		if($chapControl == 'all_chapter'){
			$this->db->order_by('history.chapter_no','desc');
			//$this->db->limit ( '50' );
		}
		$query = $this->db->get ();
		$completeQuery = $this->db->last_query ();
		//echo $completeQuery; die;
		return $query->result ();
	}
	/*--------------------------------------------------End------------------------------------------------*/
	/* -----------------------------------------------End------------------------------ */
	/* ---------------------------------Getting History Data Between Two Dates--------------------- */
	/* ------------------------------For Getting All Data For History Panel----------- */
	// custom chapter get
	function getAllDataBetweenDate($bok_id, $startDate, $endDate) {
		$this->db->select ( 'id,book_id,DATE_FORMAT(created_date,"%d/%b/%Y") as created_date,version,DATE_FORMAT(final_version,"%m-%d-%Y") as final_version,chapter_no,section_no,data' );
		$this->db->from ( 'asce_content_data' );
		$this->db->where ( 'book_id', $bok_id );
		$this->db->where ( 'DATE_FORMAT(final_version,"%m-%d-%Y") between ' . " '$startDate' " . 'and' . " '$endDate' " );
		$this->db->order_by ( "final_version", "desc" );
		// $this->db->where('DATE_FORMAT(created_date,"%d/%b/%Y") between "'.$startDate. '"and" ."'.$endDate.'"');
		// $error=$this->db->_error_message();
		$query = $this->db->get ();
		$completeQuery = $this->db->last_query ();
		return $query->result ();
		// return $query;
	}
	/* -----------------------------------------------End------------------------------ */
	/* ----------------------------------------------End------------------------------------------- */
	// custom section details
	function custom_sectiondetails_get($custom_bookid) {
		$this->db->select ( "m_section.m_sechid secId, m_section.m_seclevel secLevel , m_section.m_seclinkpage secSrc , m_section.m_secmasterid secMasterId, m_section.m_secbokcid chapId, CASE WHEN m_section.m_sectitle LIKE 'Part %' THEN '' ELSE m_section.m_seclabel END AS secLabel, m_section.m_sectitle secTitle, m_section.m_secpaneltype secPaneltype" );
		$this->db->from ( 'm_section' );
		$this->db->join ( 't_custbookchapter', 'm_secbokcid = t_custchpmchpid', 'inner' );
		$this->db->where ( array (
				't_custchpcbokid' => $custom_bookid 
		) );
		$query = $this->db->get ();
		$query_deta = $this->db->last_query ();
		// echo $this->db->last_query();
		return $query->result ();
	}
	
	// Book List
	function list_book($userid, $search, $search_from_date, $search_to_date, $sortBy) {
		// echo $sortBy;
		if ($search == '' && $search_from_date == '' && $search_to_date == '' && $sortBy == '') {
			$this->db->select ( 'm_bokid,m_bokisbn,m_bokdesc,m_boktitle,m_boksubtitle,m_bokauthorname,m_bokprice,m_bokthump,m_volnumber,m_volid' );
			$this->db->from ( 'm_book' );
			$this->db->join ( 'm_volume', 'm_volume.m_volbokid = m_book.m_bokid', 'inner' );
			$this->db->order_by ( 'm_createddate', 'desc' );
			// $this->db->where(array('m_createdby' =>$userid));
			$query = $this->db->get ();
			$finalQuery = $this->db->last_query ();
			return $query->result ();
		} else if ($search != '') {
			$this->db->select ( 'm_bokid,m_bokisbn,m_bokdesc,m_boktitle,m_boksubtitle,m_bokauthorname,m_bokprice,m_bokthump,m_volnumber,m_volid,m_createddate,m_updateddate' );
			// $this->db->like("(m_boktitle like '%" . addslashes($search) ."%' or m_bokdesc like '%" . addslashes($search) ."%' or m_bokauthorname like '%" . addslashes($search) ."%' )");
			$this->db->or_like ( 'm_boktitle', $search );
			// $this->db->or_like('m_bokdesc',$search);
			// $this->db->or_like('m_bokauthorname',$search);
			$this->db->from ( 'm_book' );
			// $this->db->where('m_createddate >=', $search_from_date);
			// $this->db->where('m_updateddate <=', $search_to_date);
			// $this->db->where('m_createddate >=', $search_from_date);
			// $this->db->where('m_updateddate <=', $search_to_date);
			$this->db->join ( 'm_volume', 'm_volume.m_volbokid = m_book.m_bokid', 'inner' );
			$this->db->order_by ( 'm_createddate', 'desc' );
			$query = $this->db->get ();
			$finalQuery = $this->db->last_query ();
			$finalQuery = $this->db->last_query ();
			return $query->result ();
		} else if ($sortBy != '') {
			$this->db->select ( 'm_bokid,m_bokisbn,m_bokdesc,m_boktitle,m_boksubtitle,m_bokauthorname,m_bokprice,m_bokthump,m_volnumber,m_volid,m_createddate,m_updateddate' );
			// $this->db->like("(m_boktitle like '%" . addslashes($search) ."%' or m_bokdesc like '%" . addslashes($search) ."%' or m_bokauthorname like '%" . addslashes($search) ."%' )");
			$this->db->like ( 'm_boktitle', $sortBy, 'after' );
			$this->db->from ( 'm_book' );
			// $this->db->where('m_createddate >=', $search_from_date);
			// $this->db->where('m_updateddate <=', $search_to_date);
			$this->db->join ( 'm_volume', 'm_volume.m_volbokid = m_book.m_bokid', 'inner' );
			$this->db->order_by ( 'm_createddate', 'desc' );
			$query = $this->db->get ();
			$finalQuery = $this->db->last_query ();
			return $query->result ();
		} else {
			
			$this->db->select ( 'm_bokid,m_bokisbn,m_bokdesc,m_boktitle,m_boksubtitle,m_bokauthorname,m_bokprice,m_bokthump,m_volnumber,m_volid,m_createddate,m_updateddate' );
			// $this->db->like("(m_boktitle like '%" . addslashes($search) ."%' or m_bokdesc like '%" . addslashes($search) ."%' or m_bokauthorname like '%" . addslashes($search) ."%' )");
			$this->db->or_like ( 'm_boktitle', $search );
			// $this->db->or_like('m_bokdesc',$search);
			// $this->db->or_like('m_bokauthorname',$search);
			// $this->db->from ('m_custbook');
			$this->db->from ( 'm_book' );
			$this->db->where ( 'm_createddate >=', $search_from_date );
			$this->db->where ( 'm_updateddate <=', $search_to_date );
			$this->db->join ( 'm_volume', 'm_volume.m_volbokid = m_book.m_bokid', 'inner' );
			$this->db->order_by ( 'm_createddate', 'desc' );
			$query = $this->db->get ();
			$finalQuery = $this->db->last_query ();
			return $query->result ();
		}
	}
	function get_book($id) {
		$this->db->select ( '*' );
		$this->db->from ( 'm_book' );
		$this->db->join ( 'm_volume', 'm_volume.m_volbokid = m_book.m_bokid', 'inner' );
		$this->db->where ( array (
				'm_bokid' => $id 
		) );
		$query = $this->db->get ();
		// echo $this->db->last_query();die;
		return $query->result ();
	}
	
	// Search a book content
	function book_search($search, $search_from_date, $search_to_date) {
		$this->db->select ( 'm_bokid,m_bokisbn,m_bokdesc,m_boktitle,m_boksubtitle,m_bokauthorname,m_bokprice,m_bokthump,m_volnumber,m_volid,m_createddate,m_updateddate' );
		$this->db->like ( "(m_boktitle like '%" . addslashes ( $search ) . "%' or m_bokdesc like '%" . addslashes ( $search ) . "%' or m_bokauthorname like '%" . addslashes ( $search ) . "%' )" );
		$this->db->from ( 'm_book' );
		$this->db->where ( 'm_createddate >=', $search_from_date );
		$this->db->where ( 'm_updateddate <=', $search_to_date );
		$this->db->join ( 'm_volume', 'm_volume.m_volbokid = m_book.m_bokid', 'inner' );
		$query = $this->db->get ();
		echo $this->db->last_query ();
		return $query->result ();
	}
	
	// Edot a book
	function edit_book($isbn) {
		$this->db->select ( 'm_bokisbn,m_bokdesc,m_boktitle,m_boksubtitle,m_bokauthorname,m_bokprice' );
		$this->db->from ( 'm_book' );
		$this->db->where ( array (
				'm_bokisbn' => $isbn 
		) );
		$query = $this->db->get ();
		return $query->result ();
	}
	
	// update a book
	function update_book($book_id, $book_title, $booktitledes, $authors, $description, $isbn, $img) {
		$data = array (
				'm_boktitle' => $book_title,
				'm_boksubtitle' => $booktitledes,
				'm_bokauthorname' => $authors,
				'm_bokdesc' => $description,
				'm_bokisbn' => $isbn,
				'm_bokthump' => $img 
		);
		// print_r($data); die;
		$this->db->where ( 'm_bokid', $book_id );
		$this->db->update ( 'm_book', $data );
		// $query = $this->db->get ();
		// echo $this->db->last_query(); die;
		return $book_id;
	}
	
	// Delete a whole book
	function delete_book($book_id) {
		$deleted=$this->db->delete ( 'm_book', array (
				'm_bokid' => $book_id
				//'m_createdby' => $user_id 
		) );
		
	   return $book_id;
	}
	function deletebook($bookid) {
	    $this->db->select ( '*' );
		$this->db->from ( 'asce_product_book' );
		$this->db->where ( array (
				'book_id' => $bookid 
		) );
		$query = $this->db->get ();
	    $completeQuery = $this->db->last_query (); 
		$recset=$query->num_rows ();  
		//$recset = $query->result ();
		/* $count=count ( $recset ); 
		echo $count; die; */
		if ( $recset>0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Delete a chapter
	function delete_chapter($user_id,$volid) {
	
	 $this->db->select('m_chpid');
        $this->db->from('m_chapter');
		$this->db->where(array('m_createdby' => $user_id, 'm_chpbokvid' => $volid));
		$query = $this->db->get ();
		
		$this->db->delete('m_chapter', array('m_chpbokvid' => $volid));
		//echo $this->db->last_query (); die;
		return $query->result ();
	
	
	
		
	}
	
	// Delete a section
	function delete_section($user_id, $chap_id) {
	
	 $this->db->select('m_sechid');
        $this->db->from('m_section');
		$this->db->where(array('m_createdby' => $user_id, 'm_secbokcid' => $chap_id));
		$query = $this->db->get ();
		
		$this->db->delete('m_section', array('m_secbokcid' => $chap_id));
		//echo $this->db->last_query (); die;
		return $query->row ();
	
	}
	
	// Delete a volume
	function delete_volume($user_id, $varid) {
	    $this->db->select('	m_volid');
        $this->db->from('m_volume');
		$this->db->where(array('m_createdby' => $user_id, 'm_volbokid' => $varid));
		$query = $this->db->get ();
		
		$this->db->delete('m_volume', array('m_volbokid' => $varid));
		//echo $this->db->last_query (); die;
		return $query->row();
	}
	
	// Delete a coontent
	function delete_content($user_id,$cont_id) {
	$deleted=$this->db->delete ( 'm_content', array (
				'm_cntchapid' => $cont_id,
				'm_cntcreatedby' => $user_id 
		) );
		
	}
	
	// Delete a bookmark
	function delete_bookmark($user_id, $cus_book_id) {
		$this->db->delete ( 't_bookmark', array (
				't_bmkcus_book_id' => $cus_book_id,
				't_bmkusrid' => $user_id 
		) );
		return $cus_book_id;
	}
	
	// Delete a highlight
	function delete_txthighlight($user_id, $cus_book_id) {
		$this->db->delete ( 't_txthighlight', array (
				't_txhcus_book_id' => $cus_book_id,
				't_txhusrid' => $user_id 
		) );
		return $cus_book_id;
	}
	
	// Delete a notes
	function delete_txtnotes($user_id, $cus_book_id) {
		$this->db->delete ( 't_txtnotes', array (
				't_txncus_book_id' => $cus_book_id,
				't_txnusrid' => $user_id 
		) );
		return $cus_book_id;
	}
	// Get Content Details
	function contentdetails_get($cnt_type, $cnt_search) {
		$cnt_search = "standard";
		if ($cnt_type == '') {
			$this->db->select ( 'm_cntid,m_cntsecid,m_cntchapid,m_cntvolid,m_cntlabel,m_cnttitle,m_cntcaption,m_cnttype' );
			$this->db->like ( 'm_cntlabel', $cnt_search );
			$this->db->like ( 'm_cnttitle', $cnt_search );
			$this->db->like ( 'm_cntcaption', $cnt_search );
			$this->db->from ( 'm_content' );
			$query = $this->db->get ();
			return $query->result ();
		} else {
			$this->db->select ( 'm_cntid,m_cntsecid,m_cntchapid,m_cntvolid,m_cntlabel,m_cnttitle,m_cntcaption,m_cnttype' );
			$this->db->from ( 'm_content' );
			$this->db->where ( array (
					'm_cnttype' => $cnt_type 
			) );
			$query = $this->db->get ();
			return $query->result ();
		}
	}
	
	// Get Book Details
	function bookdetails_get($book_id, $vol_id) {
		$this->db->select ( 'm_book.m_bokid, m_book.m_bokisbn, m_book.m_boktitle, m_book.m_createdby, m_volume.m_volid, m_volume.m_volbokid, m_volume.m_voltitle,m_volume.m_vollangid, m_volume.m_volnumber vol_no ,m_language.m_lanname' );
		$this->db->from ( 'm_book' );
		$this->db->join ( 'm_volume', 'm_volume.m_volbokid = m_book.m_bokid', 'left' );
		$this->db->join ( 'm_language', 'm_language.m_lanid = m_volume.m_volbokid', 'left' );
		$this->db->where ( array (
				'm_bokid' => $book_id,
				'm_volid' => $vol_id 
		) );
		$query = $this->db->get ();
		//echo  $this->db->last_query(); die;
		return $query->result ();
	}
	
	// Get chapter details (For use)
	function chapterdetails_get() {
		$this->db->select ( 'm_chapter.m_chpid, m_chapter.m_chpseqorder, m_chapter.m_chpbokvid, m_chapter.m_chplabel, m_chapter.m_chptitle,m_section.m_sechid, m_section.m_seclevel, m_section.m_secmasterid, m_section.m_secbokcid, m_section.m_seclabel, m_section.m_sectitle' );
		$this->db->from ( 'm_chapter', 'm_section' );
		$this->db->join ( 'm_section', 'm_secbokcid = m_chpid' );
		$query = $this->db->get ();
		return $query->result ();
	}
	function chapters_get($volId) {
		$this->db->select ( 'm_book.m_boktitle,m_chapter.m_chpid chapId, m_chapter.m_chlinkpage chapSrc, m_chapter.m_chpseqorder chapSeq, m_chapter.m_chppaneltype chappaneltype, m_chapter.m_chplabel chapLabel, m_chapter.m_chptitle chapTitle, m_chapter.m_chppaneltype chapPaneltype, m_chptoctype contenttype' );
		$this->db->from ( 'm_chapter' );
		$this->db->join('m_volume','m_volume.m_volid=m_chapter.m_chpbokvid');
		$this->db->join ( 'm_book', 'm_volume.m_volbokid=m_book.m_bokid' );
		$this->db->where ( array (
				'm_chpbokvid' => $volId 
		) );
		// $this->db->where( array('m_chppaneltype'=>"PAGES") );
		$this->db->order_by ( "m_chptoctype", "desc" );
		$this->db->order_by ( "chapSeq" );
		$query = $this->db->get ();
		$resulvalue = $query->result ();
		foreach($resulvalue as $keyt=>&$datavalue){
			if(strlen($datavalue->chapTitle)>30){
				$datavalue->chapTitle = substr($datavalue->chapTitle,0,30)."...";
			}
			
		}
		//echo "<pre>.123";print_r($resulvalue);die;
		return $resulvalue;
	}
	
	// Get section details (For use)
	function sectiondetails_get($volId) {
		$this->db->select ( 'm_section.m_sechid secId, m_section.m_seclevel secLevel , m_section.m_seclinkpage secSrc , m_section.m_secmasterid secMasterId, m_section.m_secbokcid chapId, m_section.m_seclabel secLabel, m_section.m_sectitle secTitle, m_section.m_secpaneltype secPaneltype' );
		$this->db->where ( array (
				'm_secvid' => $volId 
		) );
	       //	$this->db->where ( array (
		//		'm_secpaneltype' => "PAGES" 
		//) );
		$query = $this->db->get ( 'm_section' );
		// log_message('error', $this->db->last_query());
		return $query->result ();
	}
	function printsec_get() {
		// $this->db->select('m_section.m_sechid secId, m_section.m_seclevel secLevel , m_section.m_seclinkpage secSrc , m_section.m_secmasterid secMasterId, m_section.m_secbokcid chapId, m_section.m_seclabel secLabel, m_section.m_sectitle secTitle');
		$this->db->select ( 'm_section.m_sechid secId, m_section.m_secbokcid chapId, m_section.m_seclabel secLabel, m_section.m_sectitle secTitle' );
		$query = $this->db->get ( 'm_section' );
		return $query->result ();
	}
	function printchap_get() {
		$this->db->select ( 'm_chapter.m_chpid chapId, m_chapter.m_chptitle chapTitle' );
		$query = $this->db->get ( 'm_chapter' );
		return $query->result ();
	}
	
	// Navigation for sections
	


function navigatesec_get($volId) {
  /* $SQL="SELECT `m_section`.`m_seclabel`, `m_section`.`m_sectitle`, `m_section`.`m_seclinkpage`, INET_ATON(m_seclabel)n , case when m_seclabel RLIKE '[A-Z]' then 2 ELSE 1 END t FROM `m_section` WHERE `m_secvid` = '".$volId."' ORDER BY t,n ASC";
  $query = $this->db->query($SQL); */

       // return $query->result_array();
   $this->db->select ( 'm_section.m_seclabel, m_section.m_sectitle,m_section.m_seclinkpage' );
  $this->db->where ( array (
    'm_secvid' => $volId 
  ) );
  $this->db->order_by ( "m_seclabel", "asc" );
  $query = $this->db->get ( 'm_section' );
  //echo $completeQuery = $this->db->last_query (); die; 
  return $query->result ();
 }



//function navigatesec_get($volId) {
//		$this->db->select ( 'm_section.m_seclabel, m_section.m_sectitle,m_section.m_seclinkpage' );
//		$this->db->where ( array (
//				'm_secvid' => $volId 
//		) );
//		$this->db->order_by ( "m_seclabel", "asc" );
//		$query = $this->db->get ( 'm_section' );
//		return $query->result ();
//	}
	
	// Get custom navigation sections
	function custom_navigatesec_get($custom_book_id) {
		$this->db->select ( 'm_section.m_seclabel, m_section.m_sectitle,m_section.m_seclinkpage' );
		$this->db->from ( 'm_section' );
		$this->db->join ( 't_custbookchapter', 'm_secbokcid = t_custchpmchpid', 'inner' );
		$this->db->where ( array (
				't_custchpcbokid' => $custom_book_id 
		) );
		$this->db->order_by ( "m_seclabel", "asc" );
		$query = $this->db->get ();
		// echo $this->db->last_query();
		return $query->result ();
	}
	function appdata_get() {
		$this->db->select ( 'id,username,m_usrlastaccbookid,m_chpbokvid,m_chplabel,m_chptitle,m_secbokcid,m_seclabel,m_sectitle,m_seclevel,m_secmasterid,' );
		$this->db->from ( 'm_chapter' );
		$this->db->join ( 'users', 'users.id = m_chapter.m_chpbokvid', 'left' );
		$this->db->join ( 'm_section', 'm_section.m_secbokcid = m_chapter.m_chpid', 'left' );
		$query = $this->db->get ();
		return $query->result ();
	}
	
	// Get chapter and sections
	function chapandsec_get() {
		$this->db->select ( 'm_section.m_sechid, m_section.m_seclevel, m_section.m_secmasterid, m_section.m_secbokcid, m_section.m_seclabel, m_section.m_sectitle,m_chapter.m_chpid, m_chapter.m_chpseqorder, m_chapter.m_chpbokvid, m_chapter.m_chplabel, m_chapter.m_chptitle' );
		$this->db->from ( 'm_section', 'm_chapter' );
		$this->db->join ( 'm_section', 'm_secbokcid = m_chpid' );
		$book_vol = $this->db->get ();
		return $book_vol->result ();
	}
	
	// Check whether the book is valid
	function is_valid_book($book_id, $vol_id) {
		$this->db->select ( 'm_bokid' );
		$this->db->from ( 'm_book' );
		$this->db->join ( 'm_volume', 'm_volume.m_volbokid = m_book.m_bokid', 'inner' );
		$this->db->where ( array (
				'm_bokid' => $book_id 
		) );
		$this->db->where ( array (
				'm_volid' => $vol_id 
		) );
		$query = $this->db->get ();
		$recset = $query->result ();
		if (count ( $recset ) > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Get the custom book details
	function get_custom_book_details($book_id) {
		$this->db->select ( 'm_custbokvid,m_custmbokid' );
		$this->db->from ( 'm_custbook' );
		$this->db->where ( array (
				'm_custbokid' => $book_id 
		) );
		$query = $this->db->get ();
		$recset = $query->result ();
		if (count ( $recset )) {
			return $recset [0];
		} else {
			return false;
		}
	}
	/* ------------------------------New Method For Updating New Added Content--------------------------- */
	function add_UpdateContent($book_id, $book_vol_id, $isbn, $version) {
		$this->db->set ( 'book_id ', $book_id );
		$this->db->set ( 'book_vol_id', $book_vol_id );
		$this->db->set ( 'isbn_no', $isbn );
		$this->db->set ( 'version', $version );
		$this->db->set ( 'created_date', 'NOW()', FALSE );
		$this->db->insert ( 'asce_updated_content' );
		$inserted_id = $this->db->insert_id ();
		return $inserted_id;
	}
	/* -----------------------------------------------End------------------------------------------------ */
	/* ------------------------------New Method For Updating New Added Content Data--------------------------- */
	function add_ContentData($book_id, $book_vol_id, $isbn, $version, $finalVersion, $data, $chapter_no, $section_no) {
		$time = strtotime ( $finalVersion );
		$finalVersion = date ( 'Y-m-d', $time );
		$this->db->set ( 'book_id ', $book_id );
		$this->db->set ( 'book_vol_id', $book_vol_id );
		$this->db->set ( 'isbn_no', $isbn );
		$this->db->set ( 'version', $version );
		$this->db->set ( 'final_version', $finalVersion );
		$this->db->set ( 'chapter_no', $chapter_no );
		$this->db->set ( 'section_no', $section_no );
		$this->db->set ( 'data', $data );
		$this->db->set ( 'created_date', 'NOW()', FALSE );
		$this->db->insert ( 'asce_content_data' );
		$inserted_id = $this->db->insert_id ();
		return $inserted_id;
	}
	
	function getBookName($bokId) {
		$this->db->select ( 'm_boktitle' );
		$this->db->from ( 'm_book' );
		$this->db->where ( array (
				'm_bokid' => $bokId 
		) );
		$query = $this->db->get ();
		$recset = $query->result_array ();
		$recset = $recset [0] ['m_boktitle'];
		return $bookName;
	}
	/* ----------------------------------------------Method for getting last Updated data--------------- */
	function getLastUpdated($book_id,$currLoadedChapter) {
		$this->db->select ( 'id,book_id,DATE_FORMAT(created_date,"%d/%b/%Y") as created_date,version,DATE_FORMAT(final_version,"%m-%d-%Y") as final_version,chapter_no,section_no,data' );
		$this->db->from ( 'asce_content_data' );
		$this->db->where ( 'book_id', $book_id );
		$this->db->where ( 'chapter_no', $currLoadedChapter );
		$this->db->order_by ( "final_version", "desc" );
		$this->db->limit('1');
		$query = $this->db->get ();
		$completeQuery = $this->db->last_query ();
		$last_updated=$query->result_array ();
		if(!empty($last_updated)){
		$last_updated=$last_updated[0]['chapter_no'].'_'.$last_updated[0]['version'];
		return $last_updated;
		}
	}
	/* -----------------------------------------------End------------------------------------------------ */
	/*------------------------Method for delete Books folder from upload and book------*/
	function delete_dir($dir){
   //print_r($dir); die;
    $files = glob($dir . '/*');
	foreach ($files as $file) {
		if(is_dir($file) && $file=='xml')
		continue;
		is_dir($file) ? self::delete_dir($file) : unlink($file);
	}
	rmdir($dir);
 	return;
   }
   function delete_zip($dir){
	    $dir=$dir.'.zip';
	 // print_r($dir.'.zip');  die;
	     unlink($dir);
	  }
	  function getIsbn($bokid){
	    $this->db->select ('m_bokisbn');
		$this->db->from ( 'm_book' );
		$this->db->where ('m_bokid ='.$bokid);
		$query = $this->db->get ();
	    $finalQuery=$this->db->last_query(); 
		//echo $query->result(); die;
		return $query->result();
	  }
	  
      function delete_isbn($path){
  	    //die($path);
	//$this->delete_dir($path);
	    $files = glob($path . '/*');
	   foreach ($files as $file) {
		if(is_dir($file) && $file=='book')
		continue;
		is_dir($file) ? self::delete_isbn($file) : unlink($file);
	    }
	    rmdir($path);
 	    return;
    }
    //delete login
    function deleteLoggedInfo($sessionId) {
        $this->db->where('active_sessionid', $sessionId);
        $this->db->delete($this->loggedTable);
        $this->db->last_query();
    }

    function save_ContentData( $data, $chapter_no, $section_no,$history_type) {
		$time = strtotime ( $finalVersion );
		$finalVersion = date ( 'Y-m-d', $time );
		$this->db->set ( 'book_id ', 10 );
		$this->db->set ( 'book_vol_id', 24 );
		$this->db->set ( 'isbn_no', '1234123456788' );
		$this->db->set ( 'version', 1 );
		$this->db->set ( 'history_type', $history_type );
		$this->db->set ( 'chapter_no', $chapter_no );
		$this->db->set ( 'section_no', $section_no );
		$this->db->set ( 'data', $data );
		$this->db->set ( 'created_date', 'NOW()', FALSE );
		$this->db->insert ( 'asce_content_data' );
		$inserted_id = $this->db->insert_id ();
		return $inserted_id;
	}
}
