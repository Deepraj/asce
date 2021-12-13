<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Highlights_m extends CI_Model
{
    
    private $table_name			= 'users';			// user accounts
    private $session_table_name = 'ci_sessions';
    private $profile_table_name	= 'user_profiles';
	private $hightlight_tablename = 't_txthighlight'; // Highlight

    function __construct()
    {
        parent::__construct();
    }
    
    function addhighlight_get()
    {
        
         $postedValue1 = $this->input->get('notesecid');
		$postedValue2 = $this->input->get('notes_start');
		$postedValue3 = $this->input->get('notes_end');
		$postedValue4 = $this->input->get('tag_name');
		$postedValue5 = $this->input->get('target_id');
		$postedValue6 = $this->input->get('t_txhchapid');
		$user_id = $_SESSION['user_id'];

        $this->db->select('t_txhid,t_txhdata,t_txhusrid','t_txhsecid','t_txhtxtstart','t_txhtxtend','t_txhtagname','t_txhpgeid','t_txhchapid');
        $this->db->from('t_txthighlight');
		$query = $this->db->get();
        $query->result(); 
		
         
        $this->db->set('t_txhsecid',$postedValue1);
		$this->db->set('t_txhtxtstart',$postedValue2);
		$this->db->set('t_txhtxtend',$postedValue3);
		$this->db->set('t_txhtagname',$postedValue4);
		$this->db->set('t_txhpgeid',$postedValue5);
		$this->db->set('t_txhpgeid',$postedValue5);
		$this->db->set('t_txhusrid',$user_id);
		$this->db->set('t_txhcreateddate', 'NOW()', FALSE);
		$this->db->set('t_txhupdateddate', 'NOW()', FALSE);
        $this->db->insert('t_txthighlight', $this);
            echo "inserted Sucessfully";
            return true;
    }
}