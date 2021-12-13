<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Custombook_model extends CI_Model
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
	
	function delete_custombook($user_id,$custbook_id){

		$this->db->delete('m_custbook', array('m_custbokvid' => $custbook_id,'m_custbokcreatedby'=> $user_id ));
		return $custbook_id;
	}
	
	function delete_custchapter ($user_id,$customchap_id)
	{
		$this->db->delete('t_custbookchapter', array('t_custchpbokvid' => $customchap_id,'t_custchpcreateby'=> $user_id ));
		
	}
	
	
	function custom_booksearch($search,$from_date,$to_date){
		
		
			$this->db->select ('m_custboktitle,m_custbokdescription,m_custbokprice,m_bokisbn,m_volnumber,m_custbokthumb,m_custbokvalidfrom,m_custbokvalidto,m_boktitle' ); 
			
			$this->db->like("(m_custboktitle like '%" . addslashes($search) ."%' or m_custbokdescription like '%" . addslashes($search) ."%' or m_custbokprice like '%" . addslashes($search) ."%' )");
			$this->db->from ('m_custbook');
			$this->db->where('m_custbokvalidfrom >=', $from_date);
			$this->db->where('m_custbokvalidto <=', $to_date); 
			$this->db->join ( 'm_volume', 'm_volume.m_volbokid = m_custbook.m_custmbokid' , 'inner' );
			$this->db->join ( 'm_book', 'm_bokid = m_volbokid' , 'inner' );
			$query = $this->db->get ();
			return $query->result();
		
	}
	
	function show_custombook($user_id,$search,$from_date,$to_date){
	
		if($search == '' && $from_date == '' && $to_date == ''){	
			$this->db->select ('m_custboktitle,m_custbokid,m_custmbokid,m_custbokdescription,m_custbokprice,m_custbokvalidfrom,m_custbokvalidto,m_custbokthumb,m_volnumber,m_bokisbn,m_boktitle' ); 
			$this->db->from ('m_custbook');
			$this->db->join ( 'm_volume', 'm_volume.m_volbokid = m_custbook.m_custmbokid' , 'inner' );
			$this->db->join ( 'm_book', 'm_bokid = m_volbokid' , 'inner' );
			$this->db->where(array('m_custbokcreatedby' =>$user_id));
			$query = $this->db->get();
			$resultSet = $query->result();
			return $resultSet;	
		}
		else{
		
			$this->db->select ('m_custboktitle,m_custbokid,m_custmbokid,m_custbokdescription,m_custbokprice,m_bokisbn,m_volnumber,m_custbokthumb,m_custbokvalidfrom,m_custbokvalidto,m_boktitle' ); 
			
			$this->db->like("(m_custboktitle like '%" . addslashes($search) ."%' or m_custbokdescription like '%" . addslashes($search) ."%' or m_custbokprice like '%" . addslashes($search) ."%' )");
			$this->db->from ('m_custbook');
			$this->db->where('m_custbokvalidfrom >=', $from_date);
			$this->db->where('m_custbokvalidto <=', $to_date); 
			$this->db->join ( 'm_volume', 'm_volume.m_volbokid = m_custbook.m_custmbokid' , 'inner' );
			$this->db->join ( 'm_book', 'm_bokid = m_volbokid' , 'inner' );
			$query = $this->db->get ();
			return $query->result();
		
		}
	}
	
	function custum_chapters($volId){
		$this->db->select ('m_chapter.m_chpid chapId, m_chapter.m_chlinkpage chapSrc, m_chapter.m_chpseqorder chapSeq, m_chapter.m_chppaneltype chappaneltype, m_chapter.m_chplabel chapLabel, m_chapter.m_chptitle chapTitle, m_chapter.m_chppaneltype chapPaneltype, m_chptoctype contenttype, t_custchpmchpid'); 
		$this->db->from ('m_chapter');
		$this->db->join ( 't_custbookchapter', 't_custbookchapter.t_custchpbokvid = m_chapter. 	m_chpbokvid' , 'inner' );
		$this->db->where( array('t_custchpmchpid'=>$volId) );
		$this->db->order_by("m_chptoctype", "desc"); 
		$this->db->order_by("chapSeq");
		$query = $this->db->get();
		echo $this->db->last_query();exit;
		return $query->result();
	}
	
	
	
	function list_primarybook(){
	
		$this->db->select ('m_boktitle,m_bokid,m_volid' ); 
		$this->db->from ('m_book');
		$this->db->join ( 'm_volume', 'm_volume.m_volbokid = m_book.m_bokid' , 'inner' );
		$query = $this->db->get ();
		$recSet = $query->result();
		$results = array();
			foreach (  $recSet as $row){
				$results[$row->m_bokid.'-'.$row->m_volid] = $row->m_boktitle;
			}
		return $results;
		
	}
	
	function get_isbn($bookid){
		$this->db->select ('m_bokisbn' ); 
		$this->db->from ('m_book');
		$this->db->where(array('m_bokid' =>$bookid));
		$query = $this->db->get ();
		$recSet = $query->result();
		return $recSet[0]->m_bokisbn;
	}
	function get_volnumber($book_id){
		$this->db->select ('m_volnumber,m_bokid' ); 
		$this->db->from ('m_book');
		$this->db->join ( 'm_volume', 'm_volbokid = m_bokid' , 'inner' );
		$this->db->where(array('m_bokid' =>$book_id));
		$query = $this->db->get ();
		$recSet = $query->result();
		return $recSet[0]->m_volnumber;
	}
	function get_vol_number($volid){
		$this->db->select ('m_volnumber' ); 
		$this->db->from ('m_volume');
		$this->db->where(array('m_volid' =>$volid));
		$query = $this->db->get ();
		$recSet = $query->result();
		return $recSet[0]->m_volnumber;
	}
	
	
	function list_custumchapter($book_id){
	
		$this->db->select ('m_chpid id,m_chpfilename chapter'); 
		$this->db->from ('m_book');
		$this->db->join ( 'm_volume', 'm_volume.m_volbokid = m_book.m_bokid' , 'inner' );
		$this->db->join ( 'm_chapter', 'm_chpbokvid = m_volid' , 'inner' );
		$this->db->where(array('m_bokid' =>$book_id));
		$query = $this->db->get ();
		$resultSet = $query->result();		
		return $resultSet;
	}
	
	function add_custumbook ($user_id,$custmbokid,$custbokvid,$custboktitle,$custbokdescription,$custchpvalidfrom,$custchpvalidto,$custchpprice,$cusbook_thumb)
	{
		$this->db->set('m_custbokcreatedby',$user_id);
		$this->db->set('m_custbokupdatedby',$user_id);
		$this->db->set('m_custmbokid',$custmbokid);
		$this->db->set('m_custbokvid',$custbokvid);
		$this->db->set('m_custboktitle',$custboktitle);
		$this->db->set('m_custbokdescription',$custbokdescription);
		$this->db->set('m_custbokvalidfrom',$custchpvalidfrom);
		$this->db->set('m_custbokvalidto',$custchpvalidto);
		$this->db->set('m_custbokprice',$custchpprice);
		$this->db->set('m_custbokthumb',$cusbook_thumb);
		$this->db->set('m_custbokcreateddate','NOW()',false);
		$this->db->set('m_custbokupdateddate','NOW()',false);
		$this->db->insert('m_custbook', $this);
		$book_id = $this->db->insert_id();
		return $book_id;
	}
	
	function add_custumchapter ($user_id,$book_id,$custbokvid,$chapid)
	{
		$this->db->set('t_custchpcreateby',$user_id);
		$this->db->set('t_custchpupdatedby',$user_id);
		$this->db->set('t_custchpcbokid',$book_id);
		$this->db->set('t_custchpmchpid',$chapid);
		$this->db->set('t_custchpbokvid',$custbokvid);
		$this->db->set('t_custchpcreateddate','NOW()',false);
		$this->db->set('t_custchpupdateddate','NOW()',false);
		$this->db->insert('t_custbookchapter', $this);
		$book_id = $this->db->insert_id();
		return $book_id;
	}
	
	function edit_custombook($custbokid){
		$this->db->select ("*,DATE_FORMAT(m_custbokvalidfrom, '%d-%m-%Y') m_custbokvalidfrom ,DATE_FORMAT(m_custbokvalidto, '%d-%m-%Y') m_custbokvalidto"); 		
		$this->db->from ('m_custbook');
		$this->db->where( array('m_custbokid'=>$custbokid));
		$query = $this->db->get ();
		$recSet = $query->result();
		return $recSet[0];
	}
	
	function edit_customchapter($cusbokid){
		$this->db->select ('t_custchpmchpid'); 		
		$this->db->from ('t_custbookchapter');
		$query = $this->db->get ();
		$recSet = $query->result();
		return $recSet;
	}
	
	
	function update_custombook($user_id,$custombook_id,$custmbokid,$custbokvid,$customBookTilte,$customBookDesc,$customBookPrice,$custbokvalidfrom,$custbokvalidto,$img){
	
		$data = array(
               'm_custboktitle' => $customBookTilte,
               'm_custbokdescription' => $customBookDesc,
			   'm_custmbokid' => $custmbokid,
               'm_custbokvid' => $custbokvid,
               'm_custbokprice' => $customBookPrice,
			   'm_custbokvalidfrom' =>$custbokvalidfrom,
			   'm_custbokvalidto'=>$custbokvalidto,
			   'm_custbokupdateddate'=>'NOW()',
			   'm_custbokupdatedby'=>$user_id,
			   'm_custbokthumb'=> $img
		    );

		$this->db->where('m_custbokid', $custombook_id);
		$this->db->update('m_custbook', $data);
		//echo $this->db->last_query();exit;
		//$query = $this->db->get ();
		return $custombook_id;
	}
	
	function delete_custumbook ($user_id,$custombook_id)
	{
		$this->db->delete('m_custbook', array('m_custbokid' => $custombook_id,'m_custbokcreatedby'=> $user_id ));
		return $custombook_id;
		
	}
	
	function delete_custumchapter ($user_id,$custombook_id)
	{
		$this->db->delete('t_custbookchapter', array('t_custchpcbokid' => $custombook_id,'t_custchpcreateby'=> $user_id ));
		
	}
	
	
	
}