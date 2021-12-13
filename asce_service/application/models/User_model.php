<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
require_once (APPPATH . '/libraries/phpass-0.1/PasswordHash.php');
class User_model extends CI_Model {
	private $table_name = 'users'; // user accounts
	private $asce_status = 'asce_status';
	private $session_table_name = 'ci_sessions';
	private $profile_table_name = 'user_profiles';
	private $section_tablename = 'm_section'; // Sections
	private $content_tablename = 'm_content'; // Contents
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
		return $query->result ();
	}
	
	// Get session details
	function ses_get() {
		$this->db->select ( 'id,token' );
		$this->db->from ( 'ci_sessions' );
		$query = $this->db->get ();
		return $query->result ();
	}
	// function for getting all titles
	function list_Titles() {
		$this->db->select ( 'id,title' );
		$this->db->from ( 'asce_title' );
		$query = $this->db->get ();
		$recSet = $query->result ();
		$results = array ();
		foreach ( $recSet as $row ) {
			$results [$row->title] = $row->title;
		}
		return $results;
	}
	// function for getting all Status
	function list_Status() {
		$this->db->select ( 'id,Name,Value' );
		$this->db->from ( 'asce_status' );
		$query = $this->db->get ();
		$recSet = $query->result ();
		$results = array ();
		foreach ( $recSet as $row ) {
			$results [$row->Value] = $row->Name;
		}
		return $results;
	}
	// ////Function for getting All Products
	function list_AllProducts() {
		$this->db->select ( 'm_boktitle,m_bokid,m_volid' );
		$this->db->from ( 'm_book' );
		$this->db->join ( 'm_volume', 'm_volume.m_volbokid = m_book.m_bokid', 'inner' );
		$query = $this->db->get ();
		$recSet = $query->result ();
		$results = array ();
		foreach ( $recSet as $row ) {
			$results [$row->m_bokid] = $row->m_boktitle;
		}
		return $results;
	}
	// Function to list all Currency
	function list_AllCurrency() {
		$this->db->select ( 'currency_id,currency_code,currency_name' );
		$this->db->from ( 'asce_currency' );
		$query = $this->db->get ();
		$recSet = $query->result ();
		$results = array ();
		foreach ( $recSet as $row ) {
			$results [$row->currency_id] = $row->currency_code;
		}
		return $results;
	}
	
	function get_Corporation($orderId){
	$this->db->select('id,m_masterid');
	$this->db->from('asce_licences');
	$this->db->where('m_orderid',$orderId);
	$this->db->where('m_custtype','C');
    $query = $this->db->get ();
	//echo $this->db->last_query(); die;
	$result = $query->result ();
	return $result; 
	}
	// Function to list all IP Versions
	function list_AllIpVersions() {
		$this->db->select ( 'id,title' );
		$this->db->from ( 'asce_ipversion' );
		$query = $this->db->get ();
		$recSet = $query->result ();
		$results = array ();
		foreach ( $recSet as $row ) {
			$results [$row->id] = $row->title;
		}
		return $results;
	}
	// Function to list all IP Versions
	function list_AllCountries() {
		$this->db->select ( 'id,country_code,country_name' );
		$this->db->from ( 'asce_country' );
		$query = $this->db->get ();
		$recSet = $query->result ();
		$results = array ();
		foreach ( $recSet as $row ) {
			$results [$row->country_name] = $row->country_name;
		}
		return $results;
	}
	function add_User($email,$firstname,$username,$address,$city,$zipcode,$password,$roleId){
		$password = $this->tank_auth->getHashedPass ( $password );
		$ipAddress = $this->input->ip_address ();
		$this->db->set ( 'email', $email );
		$this->db->set ( 'm_usrfirstname', $firstname );
		$this->db->set ( 'username', $username );
		$this->db->set ( 'password', $password );
		$this->db->set ( 'm_usraddress', $address );
		$this->db->set ( 'm_usrtown', $city );
		$this->db->set ( 'm_usrzipcode', $zipcode );
		$this->db->set ( 'activated', $roleId );
		$this->db->set ( 'm_usrroleid', '2' );
		$this->db->set ( 'token', 'X*d95Cp_U8Pz@4A' );
		$this->db->set ( 'last_ip', $ipAddress );
		$this->db->set ( 'created', 'NOW()', false );
		$this->db->set ( 'modified', 'NOW()', false );
		$this->db->insert ( 'users', $this );
		$user_id = $this->db->insert_id ();
		return $user_id;
	}
	function add_UserDetails($insertedUserId,$addresstype,$country,$state,$phone,$memberid){
		$this->db->set ( 'id', $insertedUserId );
		$this->db->set ( 'address_type', $addresstype );
		$this->db->set ( 'country', $country );
		$this->db->set ( 'state', $state );
		$this->db->set ( 'phone', $phone );
		$this->db->set ( 'member_id', $memberid );
		$this->db->insert ( 'asce_user_details', $this );
		$userdetails_id = $this->db->insert_id ();
		return $userdetails_id;
	}
	// ############Function For Dashboard Count#################/////////
	public function list_Individual_Users() {
		// exit;
		
			$this->db->select ( 'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,	m_custtype' );
			$this->db->from ( 'asce_licences' );
			$this->db->where ('m_custtype','I');
			$this->db->group_by('m_masterid');
			$this->db->order_by ( 'id', 'asc' );
			$query = $this->db->get ();
			return $query->result ();
		
	}
	///////////////////////////////////////////////////////////////////
	// ############Function For Institutional User Count#################/////////
	public function list_Institutional_Users() {
		// exit;
			$this->db->select ( 'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,	m_custtype' );
			$this->db->from ( 'asce_licences' );
			$this->db->where ( 'm_custtype','C' );
			$this->db->group_by('m_masterid');
			$this->db->order_by ( 'id', 'asc' );
			$query = $this->db->get ();
			return $query->result ();
	}
	
	
	public function list_All_Users() {
		// exit;
			$this->db->select ( 'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,	m_custtype' );
			$this->db->from ( 'asce_licences' );
			$this->db->where (  "(m_licence_type='MULTI' OR m_licence_type='IPBASED' OR m_licence_type='SINGLE')",null,false );
			$this->db->group_by('m_masterid');
			$this->db->order_by ( 'id', 'asc' );
			$query = $this->db->get ();
			return $query->result ();
	}
	
	///////////////////////////////////////////////////////////////////
	// #############Function For Viewing The Users
		public function list_Users($userid,$searchName,$searchEmail,$searchStatus,$sortBy,$fname,$lname) {
		   $userid=trim($userid);
		   $searchName=trim($searchName);
		   $searchEmail=trim($searchEmail);
		   $searchStatus=trim($searchStatus);
		   $fname=trim($fname);
		   $lname=trim($lname);
		// exit;
		if ($searchName == '' && $searchEmail == '' && $searchStatus == '' && $sortBy == '') {
			$this->db->select ( 'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,	m_custtype,m_licence_type' );
			$this->db->from ( 'asce_licences' );
			//$this->db->where ( "(m_licence_type!='MULTI' AND m_licence_type!='IPBASED')",null,false );
			$this->db->where ('m_custtype','I');
			$this->db->group_by('asce_licences.m_masterid');
			$this->db->order_by ( 'id', 'asc' );
			$query = $this->db->get ();
			return $query->result ();
		} else if ($sortBy != '') {
			$this->db->select (  'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,m_custtype' );
			$this->db->from ( 'asce_licences' );
			//$this->db->where ( "(m_licence_type!='MULTI' AND m_licence_type!='IPBASED')",null,false );
			$this->db->where ('m_custtype','I');
			$this->db->like ( 'm_lablename', $sortBy, 'after' );
			$this->db->group_by('m_orderid');
			$this->db->order_by ( 'id', 'desc' );
			$query = $this->db->get ();
			//echo $this->db->last_query(); die;
			return $query->result ();
		} else if ($searchName != '' || $searchEmail != '' || $fname != ''|| $lname!='') {
			$this->db->select ( 'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,m_custtype' );
			$this->db->from ( "asce_licences" );
			//$this->db->where ( "(m_licence_type!='MULTI' OR m_licence_type!='IPBASED')",null,false );
			$this->db->where ('m_custtype','I');
			$this->db->like ( '	m_masterid', $searchName);
			$this->db->like ( 'm_primaryemail', $searchEmail );
			$this->db->like ( 'm_lablename', $fname, 'both' );
			$this->db->like ( 'm_lablename', $lname, 'both' );
			$this->db->group_by('m_masterid');
			$this->db->order_by ( 'id', 'desc' );
			$query = $this->db->get ();
			//$aa = $this->db->last_query();
			//echo $aa; die;
			return $query->result ();
		}
	}
	// ###################Function for deleting all subscriptions related to User
	function deleteUserSubscription($userId) {
		$this->db->delete ( 'asce_institute_subscription', array (
				'user_id' => $userId
		) );
		return $userId;
	}
	######################### Function for adding subscription
	function add_UserSubscription($insertedUserId,$product_id,$start_date,$end_date,$currency_id,$price,$status,$created_by,$lastupdated_by){
		$this->db->set ( 'user_id', $insertedUserId );
		$this->db->set ( 'product_id', $product_id );
		$this->db->set ( 'start_date', $start_date );
		$this->db->set ( 'end_date', $end_date );
		$this->db->set ( 'currency_id', $currency_id );
		$this->db->set ( 'price', $price );
		$this->db->set ( 'status', $status );
		$this->db->set ( 'created_date', 'NOW()', false );
		$this->db->set ( 'lastupdated_date', 'NOW()', false );
		$this->db->insert ( 'asce_institute_subscription', $this );
		$subscription_id = $this->db->insert_id ();
		return $subscription_id;
	}
	#############################Get User Details Specific to User Id
	function get_User($id)
	{
		$this->db->select ( '*' );
		$this->db->from ( 'asce_licences as users' );
	//	$this->db->join('asce_products as product','product.master_id = users.m_masterid', 'inner' );
		$this->db->join('asce_products as product','product.order_id = users.m_orderid', 'inner' );
		$this->db->where ( array (
				'users.id' => $id
		) );
		$query = $this->db->get ();
		//echo $this->db->last_query();die;
		$query = $query->result ();
		return $query;
	}
	// ##########################Function For Getting Subscriptions Related To User
	function get_AllSubscriptions($userId) {
		$this->db->select ( 'subscription.*,product.product_name' );
		$this->db->from ( 'asce_products as subscription' );
		$this->db->where ( array (
				'subscription.master_id' => $userId
		) );
		$this->db->join ( 'mps_product product', 'subscription.product_id = product.master_product_id', 'inner' );
		$this->db->group_by('subscription.order_id');
		$query = $this->db->get ();
		//echo $this->db->last_query(); die;
		$query = $query->result_array ();
		return $query;
	}
        function get_AllSubscriptionsIndivisual($userId) {
		$this->db->select ( 'subscription.*,product.product_name' );
		$this->db->from ( 'asce_products as subscription' );
		$this->db->where ( array (
				'subscription.master_id' => $userId,
                                'licence_type'=>'single'
		) );
		$this->db->join ( 'mps_product product', 'subscription.product_id = product.master_product_id', 'inner' );
		$this->db->group_by('subscription.order_id');
		$query = $this->db->get ();
		//echo $this->db->last_query(); die;
		$query = $query->result_array ();
		return $query;
	}
	###########For Updating User
	function update_User($email,$firstname,$username,$address,$city,$zipcode,$password,$id,$roleId){
		$ipAddress = $this->input->ip_address ();
		$this->db->set ( 'email', $email );
		$this->db->set ( 'm_usrfirstname', $firstname );
		$this->db->set ( 'username', $username );
	if (! empty ( $password )) {
			$password = $this->tank_auth->getHashedPass ( $password );
			$this->db->set ( 'password', $password );
		}
		$this->db->set ( 'm_usraddress', $address );
		$this->db->set ( 'm_usrtown', $city );
		$this->db->set ( 'm_usrroleid', $roleId );
		$this->db->set ( 'm_usrzipcode', $zipcode );
		$this->db->set ( 'modified', 'NOW()', false );
		$this->db->where ( 'id', $id );
		$this->db->update ( 'users', $this );
		$user_id = $this->db->insert_id ();
		return $user_id;
	}
	function update_UserDetails($id,$addresstype,$country,$state,$phone,$memberid){
		  $this->db->set ( 'id', $id );
		  $this->db->set ( 'address_type', $addresstype );
		  $this->db->set ( 'country', $country );
		  $this->db->set ( 'state', $state );
		  $this->db->set ( 'phone', $phone );
		  $this->db->set ( 'member_id', $memberid );
		  $this->db->where ( 'id', $id );
		  $this->db->update ( 'asce_user_details', $this );
		  $userdetails_id = $this->db->insert_id ();
		  return $userdetails_id;
	}
	function deleteUser($userId){
		$this->db->delete ( 'users', array (
				'id' => $userId
		) );
		$this->db->delete ( 'asce_user_details', array (
				'id' => $userId
		) );
		$this->db->delete ( 'asce_institute_subscription', array (
				'user_id' => $userId
		) );
		return $userId;
	}
}
