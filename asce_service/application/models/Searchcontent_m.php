	<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Searchcontent_m extends CI_Model
{
    
    private $table_name			= 'users';			// user accounts
    private $session_table_name = 'ci_sessions';
    private $profile_table_name	= 'user_profiles';
	private $content_tablename = 'm_content'; // Contents
    
    function __construct()
    {
        parent::__construct();
    }
    
    //Get user information
    function userinfo_get($userid)
    {
        $this->db->select('id,email,token,username,password,m_usrfirstname,m_usrlastname,m_usraddress,m_usrzipcode');
        $this->db->from('users');
		$this->db->where(array('id' => $userid ));
        $query = $this->db->get();
        return $query->result();  
        //return $ret[0]=email;
        
    }
   
    
    //Get session details
    function ses_get()
    {
        $this->db->select('id,token');
        $this->db->from('ci_sessions');
        $query = $this->db->get();
        return $query->result();
    }
	
	// Get Content Details
	
	function normalSearch_get($cnt,$count,$volId,$bookType,$customBkId = 0){
		//echo $bookType."////".$customBkId; die;
	//echo "<pre>";print_r($cnt); die;
		$cnt_search = $cnt['searchText'];
		$start = $cnt['searchContentLength'];
		$where = array();
		$where['m_cntvolid'] =  $volId;
		if($cnt['chapter_search']!='All' )
		{
			 $where['m_chlinkpage']   = $cnt['chapter_search'];
		}
			
		
		if($bookType == "PRIMARY")
			$where['t_custchpcbokid'] =  $customBkId;
		
			
		$this->db->select('m_cntid, m_cntlinkid,m_chlinkpage m_cntchapid,m_cntvolid,m_cntlabel,m_cnttitle,getLimitString(m_cntcaption,"'.addslashes($cnt_search) .'") m_cntcaption,m_cnttype,m_cntpaneltype, m_chptoctype toctype',true);
		$this->db->like("(m_cntlabel like '%" . addslashes($cnt_search) ."%' or m_cnttitle like '%" . addslashes($cnt_search) ."%' or m_cntcaption like '%" . addslashes($cnt_search) ."%' )",true);
		$this->db->join('m_chapter', 'm_chapter.m_chpid = m_content.m_cntchapid', 'inner');
		if($bookType == "PRIMARY")
			$this->db->join('t_custbookchapter', 'm_chpid = t_custchpmchpid', 'inner');
			
		$this->db->limit($count, $start);
		$this->db->from('m_content');
		$this->db->where($where);
		$this->db->order_by("m_chlinkpage");
		$this->db->order_by("m_cntlabel");
		$query = $this->db->get();
		//echo $this->db->last_query(); die;
		$returnArr['record'] = $query->result();  
		
		$this->db->select('m_cntid',true);
		$this->db->like("(m_cntlabel like '%" . addslashes($cnt_search) ."%' or m_cnttitle like '%" . addslashes($cnt_search) ."%' or m_cntcaption like '%" . addslashes($cnt_search) ."%' )",true);
		$this->db->from('m_content');
		$this->db->join('m_chapter', 'm_chapter.m_chpid = m_content.m_cntchapid', 'inner');
		if($bookType == "PRIMARY")
			$this->db->join('t_custbookchapter', 'm_chpid = t_custchpmchpid', 'inner');
		$this->db->where($where);
		$query = $this->db->get();
		
		$returnArr['count'] = $query->num_rows();
		return $returnArr;
			
	
	}
	
	function normalSearch_refine($cnt,$count,$volId,$bookType,$customBkId = 0){
		
		$cnt_search = $cnt['searchText'];
		$start = $cnt['searchContentLength'];
		$where = " m_cntvolid = $volId ";
		$where_refine = "";
		if($cnt['figure_caption'] == "true")
			$where_refine .= " ( m_cnttype = 'Figure' and m_cnttitle like '%" . addslashes($cnt_search) ."%' )  ";
			
		if($cnt['table_caption'] == "true"){
			$where_refine = ($where_refine !="" ? $where_refine." or " : '' );
			$where_refine .= " ( m_cnttype = 'Table' and m_cnttitle like '%" . addslashes($cnt_search) ."%' )  ";
		}
		if($cnt['table_content'] == "true"){
			$where_refine = ($where_refine !="" ? $where_refine." or " : '' );
			$where_refine .= " ( ( m_cnttype = 'Section' or  m_cnttype = 'Chapter' )  and ( m_cntlabel like '%" . addslashes($cnt_search) ."%' or m_cnttitle like '%" . addslashes($cnt_search) ."%' ) )  ";
		}
		if($cnt['reference'] == "true"){
			$where_refine = ($where_refine !="" ? $where_refine." or " : '' );
			$where_refine .= " ( m_cnttype = 'References' and ( m_cntlabel like '%" . addslashes($cnt_search) ."%' or m_cnttitle like '%" . addslashes($cnt_search) ."%' or m_cntcaption like '%" . addslashes($cnt_search) ."%' ) )  ";
		}
		
		if($cnt['appendixes'] == "true"){
			$where_refine = ($where_refine !="" ? $where_refine." or " : '' );
			$where_refine .= " ( m_chptoctype = 'APPENDIX' and ( m_cntlabel like '%" . addslashes($cnt_search) ."%' or m_cnttitle like '%" . addslashes($cnt_search) ."%' or m_cntcaption like '" . addslashes($cnt_search) ."%' )  )  ";
		}
		
		if($cnt['front_matter'] == "true"){
			$where_refine = ($where_refine !="" ? $where_refine." or " : '' );
			$where_refine .= " ( m_chptoctype = 'FRONT_MATTER' and ( m_cntlabel like '%" . addslashes($cnt_search) ."%' or m_cnttitle like '%" . addslashes($cnt_search) ."%' or m_cntcaption like '%" . addslashes($cnt_search) ."%' )  )  ";
		}
		
		
		
		if(strlen($where_refine) != 0 )
			$where .= " and ( " . $where_refine .")";
		
		if($bookType == "CUSTOM" && strlen($where) != 0 )
			$where .= " and ( t_custchpcbokid = " . $customBkId .")";
			
		$this->db->select('m_cntid,m_cntlinkid, m_chlinkpage m_cntchapid, m_cntvolid,m_cntlabel,m_cnttitle,getLimitString(m_cntcaption,"'. addslashes($cnt_search) .'") m_cntcaption,m_cnttype,m_cntpaneltype , m_chptoctype toctype');
	
		$this->db->limit($count, $start);
		$this->db->from('m_content');
		$this->db->join('m_chapter', 'm_chapter.m_chpid = m_content.m_cntchapid', 'inner');

		if($bookType == "CUSTOM")
			$this->db->join('t_custbookchapter', 'm_chpid = t_custchpmchpid', 'inner');

		$this->db->order_by("m_chlinkpage");
		$this->db->order_by("m_cntlabel");
		$this->db->where($where);
		$query = $this->db->get();
		
//		echo $this->db->last_query();


		$returnArr['record'] = $query->result();  
		$this->db->select('m_cntid');
		$this->db->from('m_content');
		$this->db->join('m_chapter', 'm_chapter.m_chpid = m_content.m_cntchapid', 'inner');

		if($bookType == "CUSTOM")
			$this->db->join('t_custbookchapter', 'm_chpid = t_custchpmchpid', 'inner');

		$this->db->where($where);
		$query = $this->db->get();
		$returnArr['count'] = $query->num_rows();
		return $returnArr;
	
	}
	
	
	function advanceSearch($cnt,$count,$volId,$bookType,$customBkId = 0){
		//echo "<pre>"; print_r($cnt); die;
		$cnt_search = $cnt['searchText'];
		$start = $cnt['searchContentLength'];
		$where = " m_cntvolid = $volId ";
		$where_refine = '';
		if($cnt['figure_caption'] == "true")
			$where_refine .= " ( m_cnttype = 'Figure' and m_cnttitle like '%$cnt_search%' )  ";
			
		if($cnt['table_caption'] == "true"){
			$where_refine = ($where_refine !="" ? $where_refine." or " : '' );
			$where_refine .= " ( m_cnttype = 'Table' and m_cnttitle like '%$cnt_search%' )  ";
		}
		if($cnt['table_content'] == "true"){
			$where_refine = ($where_refine !="" ? $where_refine." or " : '' );
			$where_refine .= " ( ( m_cnttype = 'Section' or  m_cnttype = 'Chapter' )  and ( m_cntlabel like '%$cnt_search%' or m_cnttitle like '%$cnt_search%' ) )  ";
		}
		if($cnt['reference'] == "true"){
			$where_refine = ($where_refine !="" ? $where_refine." or " : '' );
			$where_refine .= " ( m_cnttype = 'References' and ( m_cntlabel like '%$cnt_search%' or m_cnttitle like '%$cnt_search%' or m_cntcaption like '%$cnt_search%' ) )  ";
		}
		
		if($cnt['appendixes'] == "true"){
			$where_refine = ($where_refine !="" ? $where_refine." or " : '' );
			$where_refine .= " ( m_chptoctype = 'APPENDIX'  and ( m_cntlabel like '%$cnt_search%' or m_cnttitle like '%$cnt_search%' or m_cntcaption like '%$cnt_search%' )  )  ";
		}
		
		if($cnt['front_matter'] == "true"){
			$where_refine = ($where_refine !="" ? $where_refine." or " : '' );
			$where_refine .= " ( m_chptoctype = 'FRONT_MATTER' and ( m_cntlabel like '%$cnt_search%' or m_cnttitle like '%$cnt_search%' or m_cntcaption like '%$cnt_search%' )  )  ";
		}
		
		if(strlen($where_refine) != 0 ){
			$where .= " and ( " . $where_refine .")";
		}
		
		$where_chapter = '';
		
         if($cnt['chapter_search'] == "Selected"){
			 $where_chapter .= " m_chlinkpage >= '" . $cnt['adv_srch_chap_from'] ."' and  m_chlinkpage <= '". $cnt['adv_srch_chap_to']."'" ; 
			
			
		}else if($cnt['chapter_search'] !="All"){
			$where_chapter .= " m_chlinkpage = " . $cnt['chapter_search'] ;
		}

		if(strlen($where_chapter) != 0 )
			$where .= " and ( " . $where_chapter .")";
			
		$where_cType = '';
		if($cnt['page_seach'] == "true"){
			$where_cType .= " m_cntpaneltype = 'PAGES' " ;
		}
		if($cnt['commentry_seach'] == "true"){
			if(strlen($where_cType) != 0 )
				$where_cType .= ' or ';
			$where_cType .= "  m_cntpaneltype = 'COMMENTARY' " ;
		}

		if(strlen($where_cType) != 0 )
			$where .= " and ( " . $where_cType .")";
			
			
		$like = '';
		if(strlen($where_refine) == 0 )		{
			$where .= " and ( m_cntlabel like '%$cnt_search%' or m_cnttitle like '%$cnt_search%' or m_cntcaption like '%$cnt_search%' ) ";
		}
		
		if($bookType == "CUSTOM" && strlen($where) != 0 )
			$where .= " and ( t_custchpcbokid = " . $customBkId .")";

			
		$this->db->select('m_cntid, m_cntlinkid,m_chlinkpage m_cntchapid,m_cntvolid,m_cntlabel,m_cnttitle,getLimitString(m_cntcaption,"'.$cnt_search .'") m_cntcaption,m_cnttype,m_cntpaneltype , m_chptoctype toctype');
		
		
		$this->db->join('m_chapter', 'm_chapter.m_chpid = m_content.m_cntchapid', 'inner');

		if($bookType == "CUSTOM")
			$this->db->join('t_custbookchapter', 'm_chpid = t_custchpmchpid', 'inner');
//echo "<>";print_r($where); die;
		$this->db->where($where);
		$this->db->limit($count, $start);
		$this->db->from('m_content');
		$this->db->order_by("m_chlinkpage");
		$this->db->order_by("m_cntlabel");
		$query = $this->db->get();
		
		//echo $this->db->last_query(); die;

		$returnArr['record'] = $query->result();  
		$this->db->select('m_cntid');
		$this->db->from('m_content');
		$this->db->join('m_chapter', 'm_chapter.m_chpid = m_content.m_cntchapid', 'inner');
		
		if($bookType == "CUSTOM")
			$this->db->join('t_custbookchapter', 'm_chpid = t_custchpmchpid', 'inner');

		$this->db->where($where);
		$query = $this->db->get();
		$returnArr['count'] = $query->num_rows();
		return $returnArr;
	
	}
	
	function appdata_get(){
	
	$this->db->select ( 'id,username,m_usrlastaccbookid,m_chpbokvid,m_chplabel,m_chptitle,m_secbokcid,m_seclabel,m_sectitle,m_seclevel,m_secmasterid,' ); 
    $this->db->from ( 'm_chapter' );
    $this->db->join ( 'users', 'users.id = m_chapter.m_chpbokvid' , 'left' );
    $this->db->join ( 'm_section', 'm_section.m_secbokcid = m_chapter.m_chpid' , 'left' );
	$query = $this->db->get ();
    return $query->result ();
	}
        
}