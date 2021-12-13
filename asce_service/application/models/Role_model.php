<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'/libraries/phpass-0.1/PasswordHash.php');
class Role_model extends CI_Model
{
    
    private $table_name			= 'users';	// user accounts
    private $asce_status        ='asce_status';
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
    }
   
    
    //Get session details
    function ses_get()
    {
        $this->db->select('id,token');
        $this->db->from('ci_sessions');
        $query = $this->db->get();
        return $query->result();
    }
    //function for getting all Roles
    function listAllRoles()
    {
    	$this->db->select ('*');
    	$this->db->from('asce_role');
    	$query=$this->db->get();
    	$recSet = $query->result();
    	$results = array();
    	foreach (  $recSet as $row){
    		$results[$row->id] = $row->description;
    	}
    	return $results;
    }
	//function for getting all titles
    function listAllRoleModules()
    {
    	$this->db->select ('*');
    	$this->db->from('asce_module');
    	$query=$this->db->get();
    	$recSet = $query->result();
    	$results = array();
			foreach (  $recSet as $row){
				$results[$row->title] = $row->title;
			}
		return $results;
    }
    ######## Function For getting Role Models
    public function listRolePermission($role_id) {
    	$this->db->select('module.title,module.module_id,permission.read,permission.modify,permission.role_id');
        $this->db->from('asce_module module');
        $this->db->join('asce_role_permission permission',"module.module_id=permission.module_id and permission.role_id = '" . $role_id . "'",'left');
        $query=$this->db->get();
        $results = $query->result_array();
        return $results;
    }
    ####### Function for Updating Role for Selected Role
   public function updateUserRole($preveledges,$id)
   {
   	if(count($preveledges)>0)
   	{
   		$this->db->delete('asce_role_permission', array('role_id' => $id));
   	}
   	foreach ( $preveledges as $key => $value ) {
   		$insertData = array (
   				'module_id' => $key,
   				'role_id' => $id,
   				'read' => ((isset ( $value ['read'] ) && $value ['read'] == 'on') ? 1 : 0),
   				'modify' => ((isset ( $value ['modify'] ) && $value ['modify'] == 'on') ? 1 : 0)
   		);
   		$this->db->insert('asce_role_permission', $insertData);
   }
   }
}