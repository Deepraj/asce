<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Usersinfo_model extends CI_Model
{
    
    private $table_name			= 'users';			// user accounts
    private $session_table_name = 'ci_sessions';
    private $profile_table_name	= 'user_profiles';
	
    function __construct()
    {
        parent::__construct();
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
}