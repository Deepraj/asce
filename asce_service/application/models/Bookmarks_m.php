<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Bookmarks_m extends CI_Model
{
    
    private $table_name			= 'users';			// user accounts
    private $session_table_name = 'ci_sessions';
    private $profile_table_name	= 'user_profiles';
	private $hightlight_tablename = 't_bookmark'; // Highlight
	

    function __construct()
    {
        parent::__construct();
	}
	
    // Add users Bookmarks
    function addbookmark($bookmark_chapid,$bookmark_title,$section_id,$bookmark_start,$bookmark_end,$tag_name,$target_id,$content,$user_id,$cus_book_id,$addbookmark)
    {
		
		//echo "fdfdgdgd".$addbookmark; die;
        $this->db->select('t_bmkchapid,t_bmkusrid,t_bmktitle,t_bmksecid,t_bmkdata,t_bmktagname,t_bmkpgeid');
        $this->db->from('t_bookmark');
		$query = $this->db->get();
        $query->result(); 
		
		if($section_id != ''){
        $this->db->set('t_bmkid',$addbookmark);
        $this->db->set('t_bmkchapid',$bookmark_chapid);
		$this->db->set('t_bmktitle',$bookmark_title);
		$this->db->set('t_bmktxtstart',$bookmark_start);
		$this->db->set('t_bmktxtend',$bookmark_end);
		$this->db->set('t_bmktagname',$tag_name);
		$this->db->set('t_bmkpgeid',$target_id);
		$this->db->set('t_bmkdata',$content);
		
		$this->db->set('t_bmksecid',$section_id);
		$this->db->set('t_bmkcus_book_id',$cus_book_id);
		$this->db->set('t_bmkusrid',$user_id);
		$this->db->set('t_bmkcreateddate', 'NOW()', FALSE);
		$this->db->set('t_bmkupdateddate', 'NOW()', FALSE);
		$this->db->insert('t_bookmark', $this);
		//print $this->db->last_query(); die();
        return $this->db->insert_id();
		}
		
		else{
		$this->db->set('t_bmkchapid',$bookmark_chapid);
		$this->db->set('t_bmktitle',$bookmark_title);
		$this->db->set('t_bmkcus_book_id',$cus_book_id);
		$this->db->set('t_bmkusrid',$user_id);
		$this->db->set('t_bmkcreateddate', 'NOW()', FALSE);
		$this->db->set('t_bmkupdateddate', 'NOW()', FALSE);
		$this->db->insert('t_bookmark', $this);
        return $this->db->insert_id();
		
		}
    }
	
    // Retreive users Bookmarks	
	function retrivebookmark($chapId,$user_id,$cus_book_id)
    {
		if($chapId == '')
		 {
			$this->db->select('t_bmkid,t_bmkusrid,t_bmktitle,t_bmkchapid,t_bmksecid,t_bmkdata,t_bmkpgeid,t_bmktagname');
			$this->db->from('t_bookmark');
			$this->db->order_by("t_bmkid", "desc");
			$this->db->order_by("t_bmkid", "desc");
			$this->db->where(array('t_bmkusrid' => $user_id, 't_bmkcus_book_id' => $cus_book_id ));
			$query = $this->db->get();
			return $query->result();  
		 } 
		else
		  {
			$this->db->select('t_bmkid,t_bmkchapid,t_bmkusrid,t_bmktitle,t_bmkchapid,t_bmksecid,t_bmkdata,t_bmkpgeid,t_bmktagname');
			$this->db->from('t_bookmark');
			$this->db->order_by("t_bmkid", "desc");
			$this->db->order_by("t_bmkid", "desc");
			$this->db->where(array('t_bmkusrid' => $user_id,'t_bmkcus_book_id' => $cus_book_id,'t_bmkchapid'=> $chapId));
			$query = $this->db->get();
			//$bookmark_section['t_bmkid'] = $query->result(); 
			//$bookmark_section['t_bmksecid'] = $chapId;
			//echo $this->db->last_query(); die;
			return $query->result(); 
		  }
    }
	
	// Delete users Bookmarks	
	function deletebookmark($user_id,$cus_book_id,$bookmarkId)
	{
		$this->db->select('t_bmkid');
        $this->db->from('t_bookmark');
		$this->db->where(array('t_bmkusrid' => $user_id, 't_bmkcus_book_id' => $cus_book_id,'t_bmkid'=>$bookmarkId));
		$query = $this->db->get();
		$this->db->delete('t_bookmark', array('t_bmkid' => $bookmarkId));
		return $bookmarkId;
 	}
}