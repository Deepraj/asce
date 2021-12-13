	<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Book_model extends CI_Model
{
    
    private $table_name			= 'users';			// user accounts
    private $session_table_name = 'ci_sessions';
    private $profile_table_name	= 'user_profiles';
	private $section_tablename = 'm_section'; // Sections
    private $notes_tablename = 't_txtnotes'; // Notes

    function __construct()
    {
        parent::__construct();
    }
    
    //insert notes
    function addnotes_get()
    {
        
        $postedValue = $this->input->get('data');
        
         $this->db->select('t_txnid,t_txndata,t_txnusrid');
        $this->db->from('t_txtnotes');
		$query = $this->db->get();
        $query->result(); 
		
         
			$this->db->set('t_txndata',$postedValue);
			$this->db->insert('t_txtnotes', $this);
            echo "inserted Sucessfully";
            return true;
      
        
    }
    //Get user information
    function userinfo_get()
    {
        $this->db->select('id,email,token,username,password,m_usrfirstname,m_usrlastname,m_usraddress,m_usrzipcode');
        $this->db->from('users');
		$this->db->where(array('id' => $_SESSION['user_id'] ));
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
	// Get Book Details
	function bookdetails_get(){
		
		$this->db->select ('m_book.m_bokid, m_book.m_bokisbn, m_book.m_bokname, m_book.m_createdby, m_volume.m_volid, m_volume.m_volbokid, m_volume.m_voltitle,m_volume.m_vollangid, m_volume.m_volnumber vol_no ,m_language.m_lanname' ); 
    $this->db->from ( 'm_book' );
    $this->db->join ( 'm_volume', 'm_volume.m_volbokid = m_book.m_bokid' , 'left' );
    $this->db->join ( 'm_language', 'm_language.m_lanid = m_volume.m_volbokid' , 'left' );
    $query = $this->db->get ();
    return $query->result();
		
	}
	
	
	//Get chapter details (For use)
	function chapterdetails_get(){

	$this->db->select('m_chapter.m_chpid, m_chapter.m_chpseqorder, m_chapter.m_chpbokvid, m_chapter.m_chplabel, m_chapter.m_chptitle,m_section.m_sechid, m_section.m_seclevel, m_section.m_secmasterid, m_section.m_secbokcid, m_section.m_seclabel, m_section.m_sectitle');
	$this->db->from('m_chapter', 'm_section');
	$this->db->join('m_section', 'm_secbokcid = m_chpid');
	$query = $this->db->get();
	return $query->result();
	
	}
	
	function chapters_get(){
		$this->db->select('m_chapter.m_chpid chapId, m_chapter.m_chlinkpage chapSrc, m_chapter.m_chpseqorder chapSeq, m_chapter.m_chplabel chapLabel, m_chapter.m_chptitle chapTitle');
		$query = $this->db->get('m_chapter');
		return $query->result();
	}
	
	function sectiondetails_get(){
		$this->db->select('m_section.m_sechid secId, m_section.m_seclevel secLevel , m_section.m_seclabel secSrc , m_section.m_secmasterid secMasterId, m_section.m_secbokcid chapId, m_section.m_seclabel secLabel, m_section.m_sectitle secTitle');
		$query = $this->db->get('m_section');
		return $query->result();
	}
    
    function navigatesec_get(){
		$this->db->select('m_section.m_seclabel, m_section.m_sectitle');
		$query = $this->db->get('m_section');
		return $query->result();
	}
	
	function appdata_get(){
	
	$this->db->select ( 'id,username,m_usrlastaccbookid,m_chpbokvid,m_chplabel,m_chptitle,m_secbokcid,m_seclabel,m_sectitle,m_seclevel,m_secmasterid,' ); 
    $this->db->from ( 'm_chapter' );
    $this->db->join ( 'users', 'users.id = m_chapter.m_chpbokvid' , 'left' );
    $this->db->join ( 'm_section', 'm_section.m_secbokcid = m_chapter.m_chpid' , 'left' );
	$query = $this->db->get ();
    return $query->result ();
	}
	
	function chapandsec_get(){
		$this->db->select('m_section.m_sechid, m_section.m_seclevel, m_section.m_secmasterid, m_section.m_secbokcid, m_section.m_seclabel, m_section.m_sectitle,m_chapter.m_chpid, m_chapter.m_chpseqorder, m_chapter.m_chpbokvid, m_chapter.m_chplabel, m_chapter.m_chptitle');
		$this->db->from('m_section', 'm_chapter');
		$this->db->join('m_section', 'm_secbokcid = m_chpid');
		$book_vol = $this->db->get();
		return $book_vol->result();
	}
        
}