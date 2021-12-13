<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Auth_rest_model extends CI_Model
{
    
    private $table_name			= 'users';			// user accounts
    private $session_table_name = 'ci_sessions';
    private $profile_table_name	= 'user_profiles';

    function __construct()
    {
        parent::__construct();
    }
    
    function field_get()
    {
        
        $this->db->select('email,token,password');
        $this->db->from('users');
        $query = $this->db->get();
        return $query->result();  
        //return $ret[0]=email;
        
    }
    
    function ses_get()
    {
        $this->db->select('id,token');
        $this->db->from('ci_sessions');
        $query = $this->db->get();
        return $query->result();
    }
        
}