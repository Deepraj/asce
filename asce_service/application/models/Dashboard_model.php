<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    
    private $table_name			= 'users';			// user accounts
    private $session_table_name = 'ci_sessions';
    private $profile_table_name	= 'user_profiles';
	private $section_tablename = 'm_section'; // Sections
	private $content_tablename = 'm_content'; // Contents
    
    function __construct()
    {
        parent::__construct();
    }
    
    //Get user information
    function userinfo_get($userid)
    {
        $this->db->select('id,email,username,m_usrfirstname,m_usrlastname,m_usraddress,m_usrzipcode');
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
	function getBookDetails(){
		$this->db->select('count(*) as totalBook');
		$this->db->from('m_book');
		$query=$this->db->get();
		return $query->result();
	}
	function getProductDetails(){
		$this->db->select('count(*) as totalProduct');
		$this->db->from('mps_product');
		$query=$this->db->get();
		return $query->result();
	}
	function getIndividualDetails(){
		$this->db->select('count(*) as individualCount');
		$this->db->from('mps_product');
		$this->db->where(array('license_id' => '1' ));
		$query=$this->db->get();
		return $query->result();
	}
	function getInstitutionalDetails(){
		$this->db->select('count(*) as institutionalCount');
		$this->db->from('mps_product');
		$this->db->where(array('license_id' => '2' ));
		$this->db->or_where(array('license_id' => '3' ));
		$query=$this->db->get();
		//echo $this->db->last_query(); die;
		return $query->result();
	}
	function getAllInstitute(){
		$this->db->select('count(*) as institutionsCount');
		$this->db->from('asce_licences');
		$this->db->where (  "(m_licence_type='IPBased' OR m_licence_type='MULTI')",null,false );
		$this->db->where (  "(m_custtype='I' OR m_custtype='C')",null,false );
		 $this->db->group_by('m_masterid'); 
		$query=$this->db->get();
		//echo $this->db->last_query(); die;
		$rowcount = $query->num_rows();
		return $rowcount;
	}
	function getAllIPBased(){
		//$this->db->distinct('m_orderid');
		$this->db->select('*');
		$this->db->from('asce_licences');
		
		$this->db->where('m_licence_type','IPBased');
		
		$this->db->where ( 'm_custtype','C');
		
		$this->db->group_by('m_masterid'); 
		$query=$this->db->get();
		$rowcount = $query->num_rows();
		
		return $rowcount;
	}
	function getAllEmailBased(){
		 $sql="select al.id,al.m_masterid,al.m_lablename,al.m_firstname,al.m_lastname,al.m_orderid,al.m_primaryemail,al.m_licence_type from asce_licences as al,asce_licences as alc where al.m_orderid !=alc.m_orderid and al.m_licence_type='MULTI' and (al.m_custtype='I' OR al.m_custtype='C') group by m_masterid order by id";
			 $query = $this->db->query($sql);
			 
			  //  $this->db->select ( 'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,m_licence_type' );
			    //$this->db->from ( 'asce_licences' );
				//$this->db->where ('m_custtype','I',null,false );
				//$this->db->where ( 'm_custtype','C' );
			   // $this->db->where (  "(m_custtype='I' OR m_custtype='C')",null,false );
				//$this->db->where (  "(m_licence_type='IPBased' OR m_licence_type='MULTI')",null,false );
		        //$this->db->where('m_licence_type','MULTI');
				//$this->db->group_by('m_masterid'); 
			    //$this->db->order_by ( 'id', 'asc' );
				//$query = $this->db->get (); 
			    return $query->result ();		
	}
	
	
	
	
	
	
	function get_multiuser($id=''){
		if($id==2){
		$sql1="select count(`al`.`m_orderid`) as total_id,al.id,al.m_masterid,al.m_lablename,al.m_orderid,al.m_firstname,al.m_custtype,al.m_lastname,al.m_orderid,al.m_primaryemail,al.m_licence_type from asce_licences as al LEFT JOIN asce_licences as a2 on al.m_orderid = a2.m_orderid where al.m_licence_type='MULTI' and al.m_custtype='C' group by m_masterid order by id";
		
	    $query1 = $this->db->query($sql1);
		
		return $query1->result ();
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	function getAllEmailIpBased(){
		$this->db->select('count(*) as countEmail');
		$this->db->from('asce_licences');
		$this->db->where ( 'm_custtype','I' );
		//$this->db->where('m_licence_type','MULTI');
		//$this->db->like('m_licence_type','Multi','both');
		$this->db->like('m_licence_type','IPBased');
		$query=$this->db->get();
		return $query->result();
	}
	function getAllUsers(){
	   /* $this->db->select('count(*) as usersCount');
		$this->db->from('asce_licences');
		$this->db->where (  "(m_licence_type='MULTI' OR m_licence_type='IPBASED')",null,false );
		$this->db->group_by('m_masterid'); 
		$query=$this->db->get();
		$rowcount = $query->num_rows();
		return $rowcount; */
		//$this->db->distinct('m_orderid');
		$this->db->select('count(*) as usersCount');
		$this->db->from('asce_licences');
		$this->db->where ('m_custtype','I');
		$this->db->group_by('m_masterid');
		$query=$this->db->get();
		//echo $this->db->last_query(); die;
		$rowcount = $query->num_rows();
		return $rowcount; 
	}
	function getInstituteUsers(){
		$this->db->select('count(*) as InstituteusersCount');
		$this->db->from('asce_licences');
		$this->db->where ( 'm_custtype','C' );
		//$this->db->where (  "(m_custtype='Institutional Admin' OR m_custtype='Institutional User' OR m_custtype='Institution')",null,false );
		$this->db->group_by('m_masterid'); 
		$query=$this->db->get();
		$rowcount = $query->num_rows();
		//echo $this->db->last_query(); die;
		return $rowcount;
	}
	// Function to delete a custom book
	
	
}