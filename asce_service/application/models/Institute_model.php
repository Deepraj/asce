<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
require_once (APPPATH . '/libraries/phpass-0.1/PasswordHash.php');
class Institute_model extends CI_Model {
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
	function add_Institute($instituteName, $instituteCode, $ipBased, $concurrentUsers, $insStatus, $contactFirstName, $contactLastName, $streetAddress, $contact_state, $insCity, $insCountry, $insPostalCode, $insEmail, $insPhone, $ipBased, $referralUrl, $accessToken, $logo_name) {
		$this->db->set ( 'concurrent_users', $concurrentUsers );
		$this->db->set ( 'contact_firstname', $contactFirstName );
		$this->db->set ( 'contact_lastname', $contactLastName );
		$this->db->set ( 'contact_street_address', $streetAddress );
		$this->db->set ( 'contact_state', $contact_state );
		$this->db->set ( 'contact_country', $insCountry );
		$this->db->set ( 'contact_city', $insCity );
		$this->db->set ( 'contact_email', $insEmail );
		$this->db->set ( 'contact_phone', $insPhone );
		$this->db->set ( 'institution_code', $instituteCode );
		$this->db->set ( 'institution_name', $instituteName );
		$this->db->set ( 'contact_postal_code', $insPostalCode );
		$this->db->set ( 'institution_status', $insStatus );
		$this->db->set ( 'is_ip', $ipBased );
		$this->db->set ( 'is_referelURL', $referralUrl );
		$this->db->set ( 'is_accessToken', $accessToken );
		$this->db->set ( 'logo', $logo_name );
		$this->db->set ( 'created_date', 'NOW()', false );
		$this->db->set ( 'lastupdated_date', 'NOW()', false );
		$this->db->insert ( 'asce_institution_details', $this );
		$institute_id = $this->db->insert_id ();
		return $institute_id;
	}
	function add_InstituteAdmin($userTitle, $username, $password, $m_usrfirstname, $m_usrlastname, $email, $activated, $institute_id) {
		$password = $this->tank_auth->getHashedPass ( $password );
		$ipAddress = $this->input->ip_address ();
		$this->db->set ( 'userTitle', $userTitle );
		$this->db->set ( 'username', $username );
		$this->db->set ( 'password', $password );
		$this->db->set ( 'm_usrfirstname', $m_usrfirstname );
		$this->db->set ( 'm_usrlastname', $m_usrlastname );
		$this->db->set ( 'email', $email );
		$this->db->set ( 'activated', $activated );
		$this->db->set ( 'institution_id', $institute_id );
		$this->db->set ( 'm_usrroleid', '2' );
		$this->db->set ( 'token', 'X*d95Cp_U8Pz@4A' );
		$this->db->set ( 'last_ip', $ipAddress );
		$this->db->set ( 'created', 'NOW()', false );
		$this->db->set ( 'modified', 'NOW()', false );
		$this->db->insert ( 'users', $this );
		$admin_id = $this->db->insert_id ();
		return $admin_id;
	}
	function add_InstituteSubscription($institute_id, $product_id, $start_date, $end_date, $currency_id, $price, $status, $created_by, $lastupdated_by) {
		$this->db->set ( 'institute_id', $institute_id );
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
	function add_IPAuthentications($institution_id, $ip_version, $low_ip, $low_ip, $high_ip, $aui_status,$masterid,$productid) {
		//echo $productid; die;
		$this->db->set ( 'master_id', $masterid );
		$this->db->set ( 'ip_version', $ip_version );
		$this->db->set ( 'low_ip', $low_ip );
		$this->db->set ( 'high_ip', $high_ip );
		$this->db->set ( 'aui_status', $aui_status );
		$this->db->set ( 'productid', $productid );
		$this->db->set ( 'created_date', 'NOW()', false );
		$this->db->set ( 'lastupdated_date', 'NOW()', false );
		$this->db->insert ( 'asce_ip_authentication', $this );
		//print $this->db->last_query();
	//	die();
		$ipAuth_id = $this->db->insert_id ();
		return $ipAuth_id;
	}
	function add_EmailAuthentication($master_id, $email_auth, $first_name, $last_name,$product_id,$order_id) {
		$this->db->set ( 'master_id', $master_id );
		$this->db->set ( 'order_id', $order_id );
		$this->db->set ( 'email', $email_auth );
		$this->db->set ( 'first_name', $first_name );
		//$this->db->set ( 'middle_name', $middle_name );
		$this->db->set ( 'last_name', $last_name );
		$this->db->set ( 'product_id', $product_id );
		$this->db->set ( 'created_date', 'NOW()', false );
		$this->db->set ( 'lastupdated_date', 'NOW()', false );
		$this->db->insert ( 'asce_institute_email_auth', $this );
		//print $this->db->last_query();
		//die();
		$referal_id = $this->db->insert_id ();
		return $referal_id;
	}
	function add_AccessToken($institute_id, $token, $expirydate) {
		$this->db->set ( 'institute_id', $institute_id );
		$this->db->set ( 'access_key', $token );
		$this->db->set ( 'status', 1 );
		$this->db->set ( 'expiry_date', 'NOW() + INTERVAL 1 YEAR', false );
		$this->db->insert ( 'asce_ins_acesstokens', $this );
		$referal_id = $this->db->insert_id ();
		return $referal_id;
	}
	// ####################Function For Deleting Institute
	public function deleteInstitute($instituteId) {
		$this->db->delete ( 'asce_institution_details', array (
				'institution_id' => $instituteId 
		) );
		$this->db->delete ( 'users', array (
				'institution_id' => $instituteId 
		) );
		$this->db->delete ( 'asce_institute_http_referer', array (
				'institution_id' => $instituteId 
		) );
		$this->db->delete ( 'asce_institute_subscription', array (
				'institute_id' => $instituteId 
		) );
		$this->db->delete ( 'asce_ins_acesstokens', array (
				'institute_id' => $instituteId 
		) );
		$this->db->delete ( 'asce_ip_authentication', array (
				'institute_id' => $instituteId 
		) );
		return $instituteId;
	}
	// #############Function For Viewing The Institute
		public function list_Institute($userid,$searchMastercustomerid,$searchOrder,$searchLablename,$sortBy,$id,$fname,$lname) {
		// exit;
		$userid=trim($userid);
		$searchMastercustomerid=trim($searchMastercustomerid);
		$searchOrder=trim($searchOrder);
		$searchLablename=trim($searchLablename);
		$fname=trim($fname);
		$lname=trim($lname);
		
		if($id==1){
			$this->db->select ( 'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,m_licence_type' );
		    $this->db->from ( 'asce_licences' );
			//$this->db->where (  "(m_custtype='I' OR m_custtype='C')",null,false );
			$this->db->where (  "(m_custtype='C')",null,false );
			//$this->db->where (  "(m_licence_type='IPBased' OR m_licence_type='MULTI')",null,false );
			  $this->db->where('m_licence_type','IPBased');
		    //$this->db->like('m_licence_type','IPBASED','both');
		    $this->db->group_by('m_masterid'); 
			$this->db->order_by ( 'id', 'asc' );
			$query = $this->db->get (); 
			return  $query->result ();
		}else if($id==2 || $id==4){
						
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
		else if($id==3){
				$this->db->select ( 'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,m_licence_type' );
				$this->db->from ( 'asce_licences' );
				//$this->db->where ( 'm_custtype','C' );
				$this->db->where ( 'm_custtype','I' );
				//$this->db->like('m_licence_type','MULTI');
				$this->db->like('m_licence_type','IPBASED','both');
				$this->db->group_by('m_masterid'); 
				$this->db->order_by ( 'id', 'asc' );
				$query = $this->db->get ();
       return $query->result ();
  }else if($id==4){
	 $this->db->select ( 'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,m_licence_type' );
			    $this->db->from ( 'asce_licences' );
				$this->db->where("(m_licence_type='IPBased' OR m_licence_type='MULTI')");
			    $this->db->where (  "(m_custtype='I' OR m_custtype='C')",null,false );
				$this->db->group_by('m_masterid'); 
			    $this->db->order_by ( 'id', 'asc' );
			    $query = $this->db->get (); 
			    return  $query->result ();
  }
		else{
		    if ($searchMastercustomerid == '' && $searchOrder == '' && $searchLablename == '' && $sortBy == ''&& $fname =='' && $lname=='') {
			  
			  $this->db->select ( 'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,m_licence_type' );
			    $this->db->from ( 'asce_licences' );
				$this->db->where ( 'm_custtype','C' );
				 $this->db->group_by('asce_licences.m_masterid'); 
			    $this->db->order_by ( 'id', 'asc' );
			    $query = $this->db->get ();
			//echo $this->db->last_query(); die;
			    return $query->result ();
		    } else if ($sortBy != '') {
			//	echo "fdf"; die;
			    $this->db->select (  'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,m_licence_type' );
			    $this->db->from ( 'asce_licences' );
				 $this->db->where (  "(m_custtype='C')",null,false );
				$this->db->where ( "(	m_licence_type='MULTI' OR 	m_licence_type='IPBASED')",null,false );
			   // $this->db->where ( 'm_custtype','I' );
			    $this->db->like ( 'Upper(m_lablename)', $sortBy, 'after' );
				$this->db->group_by('m_masterid');
			    $this->db->order_by ( 'id', 'desc' );
			    $query = $this->db->get ();
			    return $query->result ();
		    } else if ($searchMastercustomerid != '' || $searchOrder != '' ||  $fname != ''|| $lname!='') {
				
			    $this->db->select ( 'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,m_licence_type' );
			    $this->db->from ( "asce_licences" );
				//$this->db->where (  m_custtype='C',null,false );
			    $this->db->where ( 'm_custtype','C' );
			    $this->db->like ( '	m_masterid', $searchMastercustomerid );
			    $this->db->like ( 'm_orderid', $searchOrder );
			   $this->db->like ( 'm_lablename', $fname, 'both' );
			    $this->db->like ( 'm_lablename', $lname, 'both' );
			//	$this->db->group_by('m_masterid');
				$this->db->group_by('m_orderid');
			    $this->db->order_by ( 'id', 'desc' );
			    $query = $this->db->get ();
			//echo $this->db->last_query(); die;
			    return $query->result ();
		    }
		}
	}
	
	public function list_InstituteI($userid,$searchMastercustomerid,$searchOrder,$searchLablename,
$sortBy,$id,$fname,$lname) {
		// exit;
		$userid=trim($userid);
		$searchMastercustomerid=trim($searchMastercustomerid);
		$searchOrder=trim($searchOrder);
		$searchLablename=trim($searchLablename);
		$fname=trim($fname);
		$lname=trim($lname);
		
		if($id==1){
			$this->db->select ( 'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,m_licence_type' );
		    $this->db->from ( 'asce_licences' );
			//$this->db->where (  "(m_custtype='I' OR m_custtype='C')",null,false );
			$this->db->where (  "(m_custtype='C')",null,false );
			//$this->db->where (  "(m_licence_type='IPBased' OR m_licence_type='MULTI')",null,false );
			  $this->db->where('m_licence_type','IPBased');
		    //$this->db->like('m_licence_type','IPBASED','both');
		    $this->db->group_by('m_masterid'); 
			$this->db->order_by ( 'id', 'asc' );
			$query = $this->db->get (); 
			return  $query->result ();
		}else if($id==2 || $id==4){
						
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
		else if($id==3){
				$this->db->select ( 'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,m_licence_type' );
				$this->db->from ( 'asce_licences' );
				//$this->db->where ( 'm_custtype','C' );
				$this->db->where ( 'm_custtype','I' );
				//$this->db->like('m_licence_type','MULTI');
				$this->db->like('m_licence_type','IPBASED','both');
				$this->db->group_by('m_masterid'); 
				$this->db->order_by ( 'id', 'asc' );
				$query = $this->db->get ();
       return $query->result ();
  }else if($id==4){
	 $this->db->select ( 'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,m_licence_type' );
			    $this->db->from ( 'asce_licences' );
				$this->db->where("(m_licence_type='IPBased' OR m_licence_type='MULTI')");
			    $this->db->where (  "(m_custtype='I' OR m_custtype='C')",null,false );
				$this->db->group_by('m_masterid'); 
			    $this->db->order_by ( 'id', 'asc' );
			    $query = $this->db->get (); 
			    return  $query->result ();
  }
		else{
		    if ($searchMastercustomerid == '' && $searchOrder == '' && $searchLablename == '' && $sortBy == ''&& $fname =='' && $lname=='') {
			  
			  $this->db->select ( 'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,m_licence_type' );
			    $this->db->from ( 'asce_licences' );
				$this->db->where ( 'm_custtype','C' );
				 $this->db->group_by('asce_licences.m_masterid'); 
			    $this->db->order_by ( 'id', 'asc' );
			    $query = $this->db->get ();
			//echo $this->db->last_query(); die;
			    return $query->result ();
		    } else if ($sortBy != '') {
				//echo "fdf"; die;
			    $this->db->select (  'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,m_licence_type' );
			    $this->db->from ( 'asce_licences' );
				 $this->db->where (  "(m_custtype='C')",null,false );
				$this->db->where ( "( 	m_licence_type='IPBASED')",null,false );
			   // $this->db->where ( 'm_custtype','I' );
			    $this->db->like ( 'Upper(m_lablename)', $sortBy, 'after' );
				$this->db->group_by('m_masterid');
			    $this->db->order_by ( 'id', 'desc' );
			    $query = $this->db->get ();
			    return $query->result ();
		    } else if ($searchMastercustomerid != '' || $searchOrder != '' ||  $fname != ''|| $lname!='') {
				
			    $this->db->select ( 'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,m_licence_type' );
			    $this->db->from ( "asce_licences" );
				 $this->db->where (  "(m_custtype='I' OR m_custtype='C')",null,false );
			  //  $this->db->where ( 'm_custtype','I' );
			    $this->db->like ( '	m_masterid', $searchMastercustomerid );
			    $this->db->like ( 'm_orderid', $searchOrder );
			   $this->db->like ( 'm_lablename', $fname, 'both' );
			    $this->db->like ( 'm_lablename', $lname, 'both' );
			//	$this->db->group_by('m_masterid');
				$this->db->group_by('m_orderid');
			    $this->db->order_by ( 'id', 'desc' );
			    $query = $this->db->get ();
			//echo $this->db->last_query(); die;
			    return $query->result ();
		    }
		}
	}
	
	public function list_InstituteII($userid,$searchMastercustomerid,$searchOrder,$searchLablename,$sortBy,$id,$fname,$lname) {
		// exit;
		//echo $sortBy; die;
		$userid=trim($userid);
		$searchMastercustomerid=trim($searchMastercustomerid);
		$searchOrder=trim($searchOrder);
		$searchLablename=trim($searchLablename);
		$fname=trim($fname);
		$lname=trim($lname);
		
		if($id==1){
			//echo $sortBy.'ftuft'; die;
			$this->db->select ( 'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,m_licence_type' );
		    $this->db->from ( 'asce_licences' );
			//$this->db->where (  "(m_custtype='I' OR m_custtype='C')",null,false );
			$this->db->where (  "(m_custtype='C')",null,false );
			//$this->db->where (  "(m_licence_type='IPBased' OR m_licence_type='MULTI')",null,false );
			  $this->db->where('m_licence_type','IPBased');
		    //$this->db->like('m_licence_type','IPBASED','both');
		    $this->db->group_by('m_masterid'); 
			$this->db->order_by ( 'id', 'asc' );
			$query = $this->db->get (); 
			return  $query->result ();
		}else if(($id==2 || $id==4) && $sortBy =="" ){
					//echo ''; die;	
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
		else if($id==3){
				$this->db->select ( 'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,m_licence_type' );
				$this->db->from ( 'asce_licences' );
				//$this->db->where ( 'm_custtype','C' );
				$this->db->where ( 'm_custtype','I' );
				//$this->db->like('m_licence_type','MULTI');
				$this->db->like('m_licence_type','IPBASED','both');
				$this->db->group_by('m_masterid'); 
				$this->db->order_by ( 'id', 'asc' );
				$query = $this->db->get ();
       return $query->result ();
  }else if($id==4){
	 $this->db->select ( 'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,m_licence_type' );
			    $this->db->from ( 'asce_licences' );
				$this->db->where("(m_licence_type='IPBased' OR m_licence_type='MULTI')");
			    $this->db->where (  "(m_custtype='I' OR m_custtype='C')",null,false );
				$this->db->group_by('m_masterid'); 
			    $this->db->order_by ( 'id', 'asc' );
			    $query = $this->db->get (); 
			    return  $query->result ();
  }
		else{
		    if ($searchMastercustomerid == '' && $searchOrder == '' && $searchLablename == '' && $sortBy == ''&& $fname =='' && $lname=='') {
			  
			  $this->db->select ( 'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,m_licence_type' );
			    $this->db->from ( 'asce_licences' );
				$this->db->where ( 'm_custtype','C' );
				 $this->db->group_by('asce_licences.m_masterid'); 
			    $this->db->order_by ( 'id', 'asc' );
			    $query = $this->db->get ();
			//echo $this->db->last_query(); die;
			    return $query->result ();
		    }
			else if ($sortBy != '') {
			//echo "fdf"; die;
			    $this->db->select (  'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,m_licence_type' );
			    $this->db->from ( 'asce_licences' );
				 $this->db->where (  "(m_custtype='I' OR m_custtype='C')",null,false );
				$this->db->where ( "(	m_licence_type='MULTI')",null,false );
			   // $this->db->where ( 'm_custtype','I' );
			    $this->db->like ( 'Upper(m_lablename)', $sortBy, 'after' );
				$this->db->group_by('m_masterid');
			    $this->db->order_by ( 'id', 'desc' );
			    $query = $this->db->get ();
				//echo $this->db->last_query(); die;
			    return $query->result ();
		    } else if ($searchMastercustomerid != '' || $searchOrder != '' ||  $fname != ''|| $lname!='') {
				
			    $this->db->select ( 'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,m_licence_type' );
			    $this->db->from ( "asce_licences" );
				 $this->db->where (  "(m_custtype='I' OR m_custtype='C')",null,false );
			  //  $this->db->where ( 'm_custtype','I' );
			    $this->db->like ( '	m_masterid', $searchMastercustomerid );
			    $this->db->like ( 'm_orderid', $searchOrder );
			   $this->db->like ( 'm_lablename', $fname, 'both' );
			    $this->db->like ( 'm_lablename', $lname, 'both' );
			//	$this->db->group_by('m_masterid');
				$this->db->group_by('m_orderid');
			    $this->db->order_by ( 'id', 'desc' );
			    $query = $this->db->get ();
			//echo $this->db->last_query(); die;
			    return $query->result ();
		    }
		}
	}
	
	public function list_InstituteIII($userid,$searchMastercustomerid,$searchOrder,$searchLablename,$sortBy,$id,$fname,$lname) {
		// exit;
		$userid=trim($userid);
		$searchMastercustomerid=trim($searchMastercustomerid);
		$searchOrder=trim($searchOrder);
		$searchLablename=trim($searchLablename);
		$fname=trim($fname);
		$lname=trim($lname);
		
		if($id==1){
			$this->db->select ( 'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,m_licence_type' );
		    $this->db->from ( 'asce_licences' );
			//$this->db->where (  "(m_custtype='I' OR m_custtype='C')",null,false );
			$this->db->where (  "(m_custtype='C')",null,false );
			//$this->db->where (  "(m_licence_type='IPBased' OR m_licence_type='MULTI')",null,false );
			  $this->db->where('m_licence_type','IPBased');
		    //$this->db->like('m_licence_type','IPBASED','both');
		    $this->db->group_by('m_masterid'); 
			$this->db->order_by ( 'id', 'asc' );
			$query = $this->db->get (); 
			return  $query->result ();
		}else if($id==2 || $id==4){
						
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
		else if($id==3){
				$this->db->select ( 'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,m_licence_type' );
				$this->db->from ( 'asce_licences' );
				//$this->db->where ( 'm_custtype','C' );
				$this->db->where ( 'm_custtype','I' );
				//$this->db->like('m_licence_type','MULTI');
				$this->db->like('m_licence_type','IPBASED','both');
				$this->db->group_by('m_masterid'); 
				$this->db->order_by ( 'id', 'asc' );
				$query = $this->db->get ();
       return $query->result ();
  }else if($id==4){
	 $this->db->select ( 'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,m_licence_type' );
			    $this->db->from ( 'asce_licences' );
				$this->db->where("(m_licence_type='IPBased' OR m_licence_type='MULTI')");
			    $this->db->where (  "(m_custtype='I' OR m_custtype='C')",null,false );
				$this->db->group_by('m_masterid'); 
			    $this->db->order_by ( 'id', 'asc' );
			    $query = $this->db->get (); 
			    return  $query->result ();
  }
		else{
		    if ($searchMastercustomerid == '' && $searchOrder == '' && $searchLablename == '' && $sortBy == ''&& $fname =='' && $lname=='') {
			  
			  $this->db->select ( 'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,m_licence_type' );
			    $this->db->from ( 'asce_licences' );
				$this->db->where ( 'm_custtype','C' );
				 $this->db->group_by('asce_licences.m_masterid'); 
			    $this->db->order_by ( 'id', 'asc' );
			    $query = $this->db->get ();
			//echo $this->db->last_query(); die;
			    return $query->result ();
		    } else if ($sortBy != '') {
			//	echo "fdf"; die;
			    $this->db->select (  'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,m_licence_type' );
			    $this->db->from ( 'asce_licences' );
				 $this->db->where (  "(m_custtype='I' OR m_custtype='C')",null,false );
				$this->db->where ( "(	m_licence_type='MULTI' OR 	m_licence_type='IPBASED')",null,false );
			   // $this->db->where ( 'm_custtype','I' );
			    $this->db->like ( 'Upper(m_lablename)', $sortBy, 'after' );
				$this->db->group_by('m_masterid');
			    $this->db->order_by ( 'id', 'desc' );
			    $query = $this->db->get ();
			    return $query->result ();
		    } else if ($searchMastercustomerid != '' || $searchOrder != '' ||  $fname != ''|| $lname!='') {
				
			    $this->db->select ( 'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,m_licence_type' );
			    $this->db->from ( "asce_licences" );
				 $this->db->where (  "(m_custtype='I' OR m_custtype='C')",null,false );
			  //  $this->db->where ( 'm_custtype','I' );
			    $this->db->like ( '	m_masterid', $searchMastercustomerid );
			    $this->db->like ( 'm_orderid', $searchOrder );
			   $this->db->like ( 'm_lablename', $fname, 'both' );
			    $this->db->like ( 'm_lablename', $lname, 'both' );
			//	$this->db->group_by('m_masterid');
				$this->db->group_by('m_orderid');
			    $this->db->order_by ( 'id', 'desc' );
			    $query = $this->db->get ();
			//echo $this->db->last_query(); die;
			    return $query->result ();
		    }
		}
	}
	
	function get_multiuser($id=''){
		if($id==2 || $id==4){
		$sql1="select count(`al`.`m_orderid`) as total_id,al.id,al.m_masterid,al.m_lablename,al.m_orderid,al.m_firstname,al.m_custtype,al.m_lastname,al.m_orderid,al.m_primaryemail,al.m_licence_type from asce_licences as al LEFT JOIN asce_licences as a2 on al.m_orderid = a2.m_orderid where al.m_licence_type='MULTI' and al.m_custtype='C' group by m_masterid order by id";
		
	    $query1 = $this->db->query($sql1);
		
		return $query1->result ();
		}
	}
	
	function get_multiuserAll(){
		
	 $this->db->select ( 'id,m_masterid,m_lablename,m_firstname,m_lastname,m_orderid,m_primaryemail,m_licence_type' );
			    $this->db->from ( 'asce_licences' );
				$this->db->where("(m_licence_type='IPBased' )");
			    $this->db->where (  "(m_custtype='C')",null,false );
				$this->db->group_by('m_masterid'); 
			    $this->db->order_by ( 'id', 'asc' );
			    $query = $this->db->get (); 
			    return  $query->result ();
		
	}
	function get_Institute($id)
	{//echo $id; die;
		$this->db->select ( '*' );
		$this->db->from ( 'asce_licences as users' );
		$this->db->where ( array (
				'users.id' => $id
		) );
		$query = $this->db->get ();
		//echo $this->db->last_query();
		$query = $query->result ();
		return $query;
	}
	function getMasterID($id){
		$this->db->select ( 'm_masterid' );
		$this->db->from ( 'asce_licences as users' );
		$this->db->where ( array (
				'users.id' => $id
		) );
		$query = $this->db->get ();
		//echo $this->db->last_query();
		$query = $query->result ();
		return $query;
		
	}
	// ##########################Function For Getting Subscriptions Related To Institute
	function get_AllSubscriptions($userId) {
		$this->db->select ( 'subscription.*,product.product_name' );
		$this->db->from ( 'asce_products as subscription' );
		$this->db->where ( array (
				'subscription.master_id' => $userId
		) );
		$this->db->join ( 'mps_product product', 'subscription.product_id = product.master_product_id', 'left' );
		$this->db->group_by('subscription.order_id'); 
		$query = $this->db->get ();
			//echo $this->db->last_query(); die;
		$query = $query->result_array ();
		return $query;
	}
	// ##########################Function For Getting IP Address Related To Institute
	function get_AllIpAddress($masterId,$productid='') {
		$this->db->select ( '*' );
		$this->db->from ( 'asce_ip_authentication' );
		$this->db->where ( array (
				'master_id' => $masterId 
		) );
		if($productid!='')
		{
		$this->db->where ( array (
				'productid' => $productid 
		) );	
		}
		$query = $this->db->get ();
		$query = $query->result_array ();
		return $query;
	}
	// ##############################Function for getting All Refferals Related To Given Institute
	function get_AllEmails($masterid,$productid='') {
		$this->db->select ( '*' );
		$this->db->from ( 'asce_institute_email_auth' );
		$this->db->where ( array (
				'master_id' => $masterid 
		) );
		if($productid!='')
		{
		$this->db->where ( array (
				'order_id' => $productid 
		) );	
		}
		$query = $this->db->get ();
		$query = $query->result_array ();
		return $query;
	}
	
	
	
/* 	function get_AllsearchEmails($masterid,$productid)
	{
		
		$this->db->select ( '*' );
		$this->db->from ( 'asce_institute_email_auth' );
		$this->db->where ( array (
				'master_id' => $masterid,
                'product_id' => $productid				
		) );
		$query = $this->db->get ();
		//$query = $query->result_array ();
		return $query;
	
	}
	 */
	//all count
	function record_count($masterid) {
		//die($masterid);
		$this->db->select ( '*' );
		$this->db->from ( 'asce_institute_email_auth' );
		/*$this->db->where ( array (
				'master_id' => $masterid 
		) );*/
		$query = $this->db->get ();
		
		$num = $query->num_rows();
		//echo $this->db->last_query();die;
		return $num;
	}
	
	function editerow($urlid)
	{//echo $urlid; die;
		$this->db->select ( '*' );
		$this->db->from ( 'asce_institute_email_auth' );
		$this->db->where ( array (
				'http_referer_id' => $urlid		
		) );
		$query = $this->db->get ();
		$query = $query->result_array ();
		
		/* $this->db->select ( 'product_name' );
		$this->db->from ( 'mps_product' );
		$this->db->where ( array (
				'master_product_id' => $query[0]['product_id']		
		) );
		//print_r($query[0]['product_id']); die;
		//echo $query; die;
		$query1 = $this->db->get ();
		$query1 = $query1->result_array ();
		  
		$query2=array_merge($query,$query1);  */
		return $query;
	}
	
	public function checkediterow($editemails,$hrefids,$editeorderids)
	{
		$this->db->select ( '*' );
		$this->db->from ( 'asce_institute_email_auth' );
		$this->db->where('email',$editemails);
		$this->db->where('order_id',$editeorderids);
		$this->db->where('http_referer_id !=',$hrefids);
		$query = $this->db->get ();
		//echo $this->db->last_query();die;
		$num = $query->num_rows ();
		return $num;
	}

	
	 function checkaddrow($addemails,$addorderids)
	 {
		$this->db->select ( '*' );
		$this->db->from ( 'asce_institute_email_auth' );
		$this->db->where('email',$addemails);
		$this->db->where('order_id',$addorderids);
		//$this->db->where('http_referer_id !=',$hrefids);
		$query = $this->db->get ();
		//echo $this->db->last_query();die;
		$num = $query->num_rows ();
		return $num; 
	 }
	
	// ######################Function For Getting All Access Token
	function get_AllAccessTokens($instituteId) {
		$this->db->select ( '*' );
		$this->db->from ( 'asce_ins_acesstokens' );
		$this->db->where ( array (
				'institute_id' => $instituteId 
		) );
		$query = $this->db->get ();
		$query = $query->result_array ();
		return $query;
	}
	// #####################Function for Updating The Institute
	function updateInstitute($instituteName, $instituteCode, $ipBased, $referralUrl, $accessToken, $concurrentUsers, $logo, $id) {
		$this->db->set ( 'institution_code', $instituteCode );
		$this->db->set ( 'institution_name', $instituteName );
		$this->db->set ( 'is_ip', $ipBased );
		$this->db->set ( 'is_referelURL', $referralUrl );
		$this->db->set ( 'is_accessToken', $accessToken );
		$this->db->set ( 'concurrent_users', $concurrentUsers );
		$this->db->set ( 'logo', $logo );
		$this->db->set ( 'lastupdated_date', 'NOW()', false );
		$this->db->where ( 'institution_id', $id );
		$this->db->update ( 'asce_institution_details', $this );
		return $id;
	}
	// #####################Function for Updating Admin Status
	function updateInstituteAdmin($userTitle, $username, $password, $m_usrfirstname, $m_usrlastname, $email, $activated, $id) {
		$this->db->set ( 'userTitle', $userTitle );
		$this->db->set ( 'username', $username );
		if (! empty ( $password )) {
			$password = $this->tank_auth->getHashedPass ( $password );
			$this->db->set ( 'password', $password );
		}
		$this->db->set ( 'm_usrfirstname', $m_usrfirstname );
		$this->db->set ( 'm_usrlastname', $m_usrlastname );
		$this->db->set ( 'email', $email );
		$this->db->set ( 'activated', $activated );
		$this->db->set ( 'modified', 'NOW()', false );
		$this->db->where ( 'institution_id', $id );
		$this->db->update ( 'users', $this );
		return $id;
	}
	// ##################Function for Updating Institute Details
	function updateInstituteDetails($contactFirstName, $contactLastName, $contact_state, $streetAddress, $insCity, $insCountry, $insPostalCode, $insEmail, $insPhone, $id) {
		$this->db->set ( 'contact_firstname', $contactFirstName );
		$this->db->set ( 'contact_lastname', $contactLastName );
		$this->db->set ( 'contact_street_address', $streetAddress );
		$this->db->set ( 'contact_state', $contact_state );
		$this->db->set ( 'contact_country', $insCountry );
		$this->db->set ( 'contact_city', $insCity );
		$this->db->set ( 'contact_email', $insEmail );
		$this->db->set ( 'contact_phone', $insPhone );
		$this->db->set ( 'contact_postal_code', $insPostalCode );
		$this->db->where ( 'institution_id', $id );
		$this->db->update ( 'asce_institution_details', $this );
		return $id;
	}
	// #####################Function for updating ip status
	function updateAccessStatues($ipBased, $referralUrl, $accessToken, $id) {
		
		$this->db->set ( 'is_ip', $ipBased );
		$this->db->set ( 'is_referelURL', $referralUrl );
		$this->db->set ( 'is_accessToken', $accessToken );
		$this->db->where ( 'institution_id', $id );
		$this->db->update ( 'asce_institution_details', $this );
		return $id;
	}
	// #####################Function for updating ip status
	function updateIPStatues($ipBased, $id) {
		$this->db->set ( 'is_ip', $ipBased );
		$this->db->where ( 'institution_id', $id );
		$this->db->update ( 'asce_institution_details', $this );
		return $id;
	}
	function updaterow($rowsid,$auivalue)
	{
		//echo $rowsid."//".$auivalue; die;
		$this->db->set ( 'aui_status', $auivalue );
		$this->db->where ( 'ipauth_id', $rowsid );
		$this->db->update ( 'asce_ip_authentication', $this );
		//$aa=$this->db->last_query();
		//echo $aa; die;
		return $rowsid;
		
	}
	
	// #####################Function for updating Refferal status
	function updateRefferalStatues($referralUrl, $id) {
		$this->db->set ( 'is_referelURL', $referralUrl );
		$this->db->where ( 'institution_id', $id );
		$this->db->update ( 'asce_institution_details', $this );
		return $id;
	}
	// #####################Function for Access Token status
	function updateAccessTokenStatues($accessToken, $id) {
		$this->db->set ( 'is_accessToken', $accessToken );
		$this->db->where ( 'institution_id', $id );
		$this->db->update ( 'asce_institution_details', $this );
		return $id;
	}
	// ###################Function for deleting all subscriptions related to institute
	function deleteInstituteSubscription($instituteId) {
		$this->db->delete ( 'asce_institute_subscription', array (
				'institute_id' => $instituteId 
		) );
		return $instituteId;
	}
	// ######################Function for deleting IP addresses related to given Institute
	function deleteInstituteIP($masterid,$productid) {
		$this->db->delete ( 'asce_ip_authentication', array (
				'master_id' => $masterid,
                'productid'	=> $productid			
		) );
		//$aa=$this->db->last_query();
		//echo $aa; die;
		return $masterid;
	}
	// ####################Function for deleting Institute Refferals
	function deleteInstituteRefferals($masterid) {
		$this->db->delete( 'asce_institute_email_auth', array (
				'master_id' => $masterid 
		) );
		return $masterid;
	}
	
	
	
	function get_ManageInstitute($email)
	{
		$this->db->select ( 'email,order_id' );
		$this->db->from ( 'asce_institute_email_auth ' );
		$this->db->where ( array (
				'email' => $email 
		));
		$query = $this->db->get ();
		$query = $query->result_array ();
		return $query;
		
	}
	// ###################Check Whether the Institute Code Already Exist
	function getInstituteDetails($instituteCode) {
		$this->db->select ( 'institution_code' );
		$this->db->from ( 'asce_institution_details as ins_details' );
		$this->db->where ( array (
				'ins_details.institution_code' => $instituteCode 
		) );
		$query = $this->db->get ();
		$num = $query->num_rows ();
		return $num;
	}
	// #############Check Whether The Admin Email Id already Exists or not
	function getInstituteAdminEmail($emailId) {
		$this->db->select ( 'email' );
		$this->db->from ( 'users as users' );
		$this->db->where ( array (
				'users.email' => $emailId 
		) );
		$query = $this->db->get ();
		$num = $query->num_rows ();
		return $num;
	}
	// #############Check Whether The Admin User Name already Exists or not
	function getInstituteAdminUserName($userName) {
		$this->db->select ( 'username' );
		$this->db->from ( 'users as user' );
		$this->db->where ( array (
				'user.username' => $userName 
		) );
		$query = $this->db->get ();
		$num = $query->num_rows ();
		return $num;
	}
	// #############Check Whether The Admin User Name already Exists or not
	function getInstituteIPRangeValue($IPRangeValue) {
	//	echo $IPRangeValue; die;
		$this->db->select ( 'ipauth_id,low_ip,high_ip' );
		$this->db->from ( 'asce_ip_authentication as ip_auth' );
		$this->db->where ("ip_auth.low_ip='$IPRangeValue' or ip_auth.high_ip='$IPRangeValue'");
		$query = $this->db->get ();
		$num = $query->num_rows ();
		$aa = $this->db->last_query();
		//echo $aa; die;
		return $num;
	}
	function updateurldata($inshrefid, $insEmail,$insFirstName,$insLastName)
	{
		
     $this->db->set ( 'first_name', $insFirstName );
	 $this->db->set ( 'last_name', $insLastName );
	  $this->db->set ( 'email', $insEmail );
		$this->db->where ( 'http_referer_id', $inshrefid  );
		$this->db->update ( 'asce_institute_email_auth', $this );
		//$aa = $this->db->last_query();
		//echo $aa; die;
		
	}
	
	function getInstituteIPPopupRangeValue($MinIPRange,$MaxIPRange,$productid,$masterid) {
	//echo $masterid."//". $productid.$MinIPRange.$MaxIPRange; die;
		$this->db->select ( 'ipauth_id,low_ip,high_ip' );
		$this->db->from ( 'asce_ip_authentication as ip_auth' );
		//$this->db->where ("ip_auth.low_ip='$MinIPRange' or ip_auth.high_ip='$MaxIPRange'");
		$this->db->where ( array (
				'ip_auth.master_id' => $masterid,
                'ip_auth.productid'	=> $productid,
               ' ip_auth.low_ip'=>$MaxIPRange,
               ' ip_auth.low_ip'=>$MinIPRange			   
		) );
		$query = $this->db->get ();
		$num = $query->num_rows ();
		//$aa = $this->db->last_query();
//echo $aa; die;
		return $num;
	}
	
	function get_Admin($orderId)
	{ //echo $orderId ;  die;
		$this->db->select ( '*' );
		$this->db->from ( 'asce_licences' );
		$this->db->where("m_orderid",$orderId);
		$this->db->where("m_custtype",'I');
		$query =$this->db->get()->result();
		$aa = $this->db->last_query();
      //echo $aa; die;
		return $query;

	}
	function get_AdminByOderId($UserInfo=array()){
            $this->db->select ('master_id');
            $masterid = $UserInfo['m_masterid'];
            $m_orderid = $UserInfo['m_orderid'];
            $this->db->from('asce_products' );
            $this->db->where("order_id",$m_orderid);
            $this->db->where("master_id!='".$masterid."'");
            $query =$this->db->get()->row();
            $aa = $this->db->last_query();
            return $query;
            //$sql = "SELECT * FROM `asce_products` WHERE `order_id`='".$UserInfo."' and master_id!='000009961148'";
            //$sql2 = "SELECT * FROM `asce_licences` WHERE `m_masterid`='000000739925'";
	}
        
        function get_AdminByMasterId($masterid=0){
		$this->db->select ( '*' );
		$this->db->from ( 'asce_licences' );
		$this->db->where("m_masterid",$masterid);
		$query =$this->db->get()->result();
		$aa = $this->db->last_query();
		return $query;
        }
	//--------File Upload Code----------------------------------------
		
	function isExistEmail($email,$usermaster,$product_id)
	{
		//print_r($email); die;
		$success = array();
	    $this->db->select ( 'email' );
		$this->db->from ( 'asce_institute_email_auth' );
		$this->db->where ( array (
				'email' => $email,
                'master_id' =>$usermaster,
                'product_id' => $product_id 				
		) );
		
		$query = $this->db->get ()->result();
		//print_r($query); die;
		//$aa = $this->db->last_query();
		//echo $aa; die;
		if(count($query)>0)
		{		//print_r($query); die;
	
			return $query[0]->email;
		}
		else{
			return false;
		}
	}
	
	
	
	
	
	
	function insertxml($data)
	{
		//print_r($data); die;
		$flag=0;
	$error="";
	//$max =3;
		$success = array();
		
		$fname = $data['FirstName'];
		//echo $fname; die;
		 $usermaster = $data['usermaster'];
		
		$PrimaryEmailAddress =$data['PrimaryEmailAddress'];
		
		$this->db->select ( 'licence_count' );
		$this->db->from ( 'asce_products' );
		
		$this->db->where("master_id", $usermaster );
		//$this->db->where("licence_type", $LicenceInfo );
		$this->db->where("product_id",$data['product_id'] );
		$this->db->where("order_id",$data['order_id'] );
		$query = $this->db->get ()->result();
		$aa=$this->db->last_query();
		//echo $aa; die;
		$as = $query;
		$max = $as[0]->licence_count;
		if($max=='N')
		{
		$this->db->select ( 'Nigotiate_count' );
		$this->db->from ( 'asce_products' );
		
		$this->db->where("master_id", $usermaster );
		//$this->db->where("licence_type", $LicenceInfo );
		//$this->db->where("product_id",$data['product_id'] );
		$this->db->where("order_id",$data['order_id'] );
		$query = $this->db->get ()->result();
		$aa=$this->db->last_query();
		//echo $aa; die;
		$as = $query;
		$max = $as[0]->Nigotiate_count;
		}
		
		
			if (!filter_var($PrimaryEmailAddress, FILTER_VALIDATE_EMAIL) === false) {
         
		  $success[]="$PrimaryEmailAddress is a valid email address";
		 
         } else {
			 $error="$PrimaryEmailAddress ";
			//print_r($error); die;
			 $flag=1;
         
          }
		  $data["error"]=$error;
	//print_r($data); die;
	$newinserted =0;
	if($flag==0){
	$this->db->select ( '*' );
		$this->db->from ( 'asce_institute_email_auth' );
		
		$this->db->where("master_id", $usermaster );
		//$this->db->where("product_id",$data['product_id'] );
		$this->db->where("order_id",$data['order_id'] );
		$query = $this->db->get ();
		$num = $query->num_rows ();
		if($num<$max)
		{
      $this->db->insert('asce_institute_email_auth',array('product_id'=>$data['product_id'],'order_id'=>$data['order_id'],'product_name'=>$data['product_name'],'master_id'=>$data['usermaster'],'first_name'=>$data['FirstName'],'last_name'=>$data['LastName'],'email'=>$data['PrimaryEmailAddress']));
	    $data['insertemail'] =$data['PrimaryEmailAddress'];
	$newinserted=1;
	}
	}
	 $data['insertflage']=$newinserted;
	return $data;
	}
	function insertcsv($data,$usermaster,$product_id,$product_name,$order_id)
	{ 
	 // print_r($data[2]); die;
	    $Firstname1 = trim($data[0]);
	    $FirstName = preg_replace('/[0-9]+/', '',$Firstname1);
		$LastName = trim($data[1]);
        $flag=0;
	    $error="";
		//$max =3;
		$success = array();
		$PrimaryEmailAddress =$data[2];
		
		$this->db->select ( 'licence_count' );
		$this->db->from ( 'asce_products' );
		
		$this->db->where("master_id", $usermaster );
		//$this->db->where("licence_type", $LicenceInfo );
		$this->db->where("product_id",$product_id );
		$this->db->where("order_id",$order_id );
		$query = $this->db->get ()->result();
		$aa=$this->db->last_query();
		//echo $aa; die;
		$as = $query;
		$max = $as[0]->licence_count;
		if($max=='N')
		{
		$this->db->select ( 'Nigotiate_count' );
		$this->db->from ( 'asce_products' );
		
		$this->db->where("master_id", $usermaster );
		//$this->db->where("licence_type", $LicenceInfo );
		//$this->db->where("product_id",$product_id );
		$this->db->where("order_id",$order_id );
		$query = $this->db->get ()->result();
		$aa=$this->db->last_query();
		//echo $aa; die;
		$as = $query;
		$max = $as[0]->Nigotiate_count;
		}
		
		
		
		
	
			if (!filter_var($PrimaryEmailAddress, FILTER_VALIDATE_EMAIL) === false) {
         
		  $success[]="$PrimaryEmailAddress is a valid email address";
		 
         } else {
			 $error="$PrimaryEmailAddress ";
			//print_r($error); die;
			 $flag=1;
         
          }
		  $data["error"]=$error;
		  $newinserted =0;
    if($flag==0){
         $this->db->select ( '*' );
		 $this->db->from ( 'asce_institute_email_auth' );
		
		$this->db->where("master_id", $usermaster );
		//$this->db->where("product_id", $product_id );
		$this->db->where("order_id",$order_id );
		$query = $this->db->get ();
		$num = $query->num_rows ();
		if($num<$max)
		{	
	$insert=$this->db->insert('asce_institute_email_auth',array('product_id'=>$product_id,'order_id'=>$order_id,'product_name'=>$product_name,'master_id'=>$usermaster,'first_name'=>$FirstName,'last_name'=>$LastName,'email'=>$PrimaryEmailAddress));
    $data['insertemail'] =$PrimaryEmailAddress;
   $newinserted=1;
	}
	 }
	  $data['insertflage']=$newinserted;
	return $data;
	}
	
	
	function insertxlxs($val,$usermaster,$product_id,$product_name,
 $order_id)
	{
		//echo "fdf"; die;
			$flag=0;
			$error=""; 
			//$max =3;
			$success = array();
			$FirstName1 = trim($val['A']);
			$FirstName = preg_replace('/[0-9]+/', '', $FirstName1);		
			$LastName = trim($val['B']); 
			$PrimaryEmailAddress =$val['C']; 
			
			
		$this->db->select ( 'licence_count' );
		$this->db->from ( 'asce_products' );
		
		$this->db->where("master_id", $usermaster );
		//$this->db->where("licence_type", $LicenceInfo );
		$this->db->where("product_id",$product_id );
		$this->db->where("order_id",$order_id );
		$query = $this->db->get ()->result();
		$aa=$this->db->last_query();
		//echo $aa; die;
		$as = $query;
		$max = $as[0]->licence_count;
		//echo $max; die;	
		if($max=='N')
		{
		$this->db->select ( 'Nigotiate_count' );
		$this->db->from ( 'asce_products' );
		
		$this->db->where("master_id", $usermaster );
		//$this->db->where("licence_type", $LicenceInfo );
		//$this->db->where("product_id",$product_id );
		$this->db->where("order_id",$order_id );
		$query = $this->db->get ()->result();
		$aa=$this->db->last_query();
		//echo $aa; die;
		$as = $query;
		$max = $as[0]->Nigotiate_count;	
		}			
			
		if (!filter_var($PrimaryEmailAddress, FILTER_VALIDATE_EMAIL) === false) {
         
		  $success[]="$PrimaryEmailAddress is a valid email address";
		 
         } else {
			 $error="$PrimaryEmailAddress ";
			
			 $flag=1;
         
          }
    $data["error"]=$error;
	$newinserted =0;
	if($flag==0){
	$this->db->select ( '*' );
		$this->db->from ( 'asce_institute_email_auth' );
		
		$this->db->where("master_id", $usermaster );
		//$this->db->where("product_id", $product_id );
		$this->db->where("order_id",$order_id );
		$query = $this->db->get ();
		$num = $query->num_rows ();
		//echo $num; die;
		if($num<$max)
		{
			//echo "fdfd"; die;
    $this->db->insert('asce_institute_email_auth',array('product_id'=>$product_id,'order_id'=>$order_id,'product_name'=>$product_name, 'master_id'=>$usermaster,'first_name'=>$FirstName,'last_name'=>$LastName,'email'=>$PrimaryEmailAddress)); 
	
    $data['insertemail'] =$PrimaryEmailAddress;
	$newinserted=1;
	}
	}
	 $data['insertflage']=$newinserted;
     return $data; 
	}
	
	function inserttxt($data)
	{     //print_r($data); die;
	$flag=0;
	$error="";
   // $max =3;	
		$success = array();
	     $masterid = trim($data['usermaster']);
		 $product_id = trim($data['product_id']);
		 $product_name = trim($data['product_name']);
		 $order_id = trim($data['order_id']);
		 $Firstname1 = trim($data['fname']);
	     $FirstName = preg_replace('/[0-9]+/', '',$Firstname1);
         $LastName = trim($data['lname']); 
         $PrimaryEmailAddress = trim($data['email']);
		 
		 	$this->db->select ( 'licence_count' );
		$this->db->from ( 'asce_products' );
		
		$this->db->where("master_id", $masterid );
		//$this->db->where("licence_type", $LicenceInfo );
		$this->db->where("product_id",$product_id );
		$this->db->where("order_id",$order_id );
		$query = $this->db->get ()->result();
		$aa=$this->db->last_query();
		//echo $aa; die;
		$as = $query;
		$max = $as[0]->licence_count;
		 if($max=='N')
		 {
			$this->db->select ( 'Nigotiate_count' );
		$this->db->from ( 'asce_products' );
		
		$this->db->where("master_id", $masterid );
		//$this->db->where("licence_type", $LicenceInfo );
		//$this->db->where("product_id",$product_id );
		$this->db->where("order_id",$order_id );
		$query = $this->db->get ()->result();
		$aa=$this->db->last_query();
		//echo $aa; die;
		$as = $query;
		$max = $as[0]->Nigotiate_count; 
		 }
		 
		 if (!filter_var($PrimaryEmailAddress, FILTER_VALIDATE_EMAIL) === false) {
         //echo "true";die;
		  $success[]="$PrimaryEmailAddress is a valid email address";
		 
         } else {
			 
			  $error="$PrimaryEmailAddress ";
			
			 $flag=1;
         
          }

		 $data["error"]=$error;
   
     $newinserted =0;
   
	if($flag==0){
	$this->db->select ( '*' );
		$this->db->from ( 'asce_institute_email_auth' );
		
		$this->db->where("master_id", $masterid );
		$this->db->where("product_id", $product_id );
		$this->db->where("order_id", $order_id );
		$query = $this->db->get ();
		$num = $query->num_rows ();
		if($num<$max)
		{
      $insert=$this->db->insert('asce_institute_email_auth',array('product_id'=>$product_id,'order_id'=>$order_id,'product_name'=>$product_name,'master_id'=>$masterid,'first_name'=>$FirstName,'last_name'=>$LastName,'email'=>$PrimaryEmailAddress)); 
	 //echo $this->db->last_query() ; die;
	  $data['insertemail'] =$PrimaryEmailAddress;
	 $newinserted=1;
     }
	}
 $data['insertflage']=$newinserted;	
     return $data; 		 
	}
	
	function getInsertemail($data,$LicenceInfo)
	{
		$flag =0;
		//error_reporting(0);
		//echo $LicenceInfo; die; 
	//$max =3;
	// $newinserted =0;
	//echo"<pre>"; print_r($data);
	
	$this->db->select ( 'licence_count' );
		$this->db->from ( 'asce_products' );
		
		$this->db->where("master_id", $data['usermaster'] );
		$this->db->where("licence_type", $LicenceInfo );
		$this->db->where("product_id",$data['productid'] );
		$this->db->where("order_id",$data['order_id'] );
		$query = $this->db->get ()->result();
		$aa=$this->db->last_query();
		
		$as = $query;
		$max = $as[0]->licence_count;
		if($max=='N')
		{
			$this->db->select ( 'Nigotiate_count' );
		$this->db->from ( 'asce_products' );
		
		$this->db->where("master_id", $data['usermaster'] );
		$this->db->where("licence_type", $LicenceInfo );
		//$this->db->where("product_id",$data['productid'] );
		$this->db->where("order_id",$data['order_id'] );
		$query = $this->db->get ()->result();
		//$aa=$this->db->last_query();
			//echo $aa; die;
			$as = $query;
		$max = $as[0]->Nigotiate_count;
		}
		//print_r($max);  die;
		//$max = $query->num_rows ();
	
	
	$this->db->select ( '*' );
		$this->db->from ( 'asce_institute_email_auth' );
		
		$this->db->where("master_id", $data['usermaster'] );
		//$this->db->where("product_id", $data['productid'] );
		$this->db->where("order_id",$data['order_id'] );
		$query = $this->db->get ();
		$num = $query->num_rows ();
		//echo $num; die;
		if($num<$max)
		{
	$insert=$this->db->insert('asce_institute_email_auth',array('product_id'=>$data['productid'],'order_id'=>$data['order_id'],'product_name'=>$data['product_name'],'master_id'=>$data['usermaster'],'first_name'=>$data['insFirstName'],'last_name'=>$data['insLastName'],'email'=>$data['insEmail']));
   $flag=1;	
	}
	return $flag;
   	}
	
	
	
	
	function getInsertip($data)
	{
		
	$LicenceInfo ="IPBASED";
	
	$insert=$this->db->insert('asce_ip_authentication',array('ip_version'=>$data['insIpVersion'],'productid'=>$data['productid'],'master_id'=>$data['usermaster'],'low_ip'=>$data['insMinIp'],'high_ip'=>$data['insMaxIp'],'aui_status'=>$data['ipStatus']));
	
	
	return $insert;
   	}
	function countinsertip($usermaster)
	{
	   $this->db->select ('*');
		$this->db->from ( 'asce_ip_authentication' );
		$this->db->where ('master_id',$usermaster);
		$this->db->where ('aui_status',1);
       // $this->db->where ('m_custtype',I);		
		$query = $this->db->get ();
		$num = $query->num_rows ();
		//$as = $this->db->last_query();
		//echo $num; die;
		if($num<2)
		{
		return '1';	
		}
		else{
	return '0';
	
	}
   	}
	
	
	function Deletet_Ip_Row($rowid)
	{//echo $emails; die;
	$this->db->delete( 'asce_ip_authentication', array (
				'ipauth_id' => $rowid 
		) );
		$as = $this->db->last_query();
		//echo $as; die;
		return $rowid;	
	}
	
	
	
	
	
	
	
	function deleteemail($emails)
	{//echo $emails; die;
	$this->db->delete( 'asce_institute_email_auth', array (
				'http_referer_id' => $emails 
		) );
		$as = $this->db->last_query();
		//echo $as; die;
		return $emails;	
	}
	//---------------------end here--------------------------
	//-------Edit License Count-------/////////////
	function updateLicense($master_id,$order_id,$data){
	
	    $this->db->where('master_id', $master_id);
		 $this->db->where('order_id', $order_id);
        $this->db->update('asce_products', $data);
		//$as = $this->db->last_query();
		//echo $as; die;
	    return true;
	}
	function fetchDetail($to_email){
	    $this->db->select ( 'asce_institute_email_auth.first_name,asce_institute_email_auth.last_name,asce_institute_email_auth.email,asce_licences.m_orderid,asce_licences.m_lablename,asce_licences.m_primaryemail,asce_licences.m_firstname');
		$this->db->from ( 'asce_institute_email_auth' );
		$this->db->join('asce_licences','asce_institute_email_auth.master_id=asce_licences.m_masterid');
		$this->db->where ('asce_institute_email_auth.email',$to_email);	 
		$query = $this->db->get ()->result();
		return $query;
	
	}
	
	
	function corporateemail($orderid){
	    $this->db->select ('m_primaryemail');
		$this->db->from ( 'asce_licences' );
		$this->db->where ('m_orderid',$orderid);
        $this->db->where ('m_custtype',I);		
		$query = $this->db->get ()->result();
		//$as = $this->db->last_query();
		//echo $as; die;
		return $query;
	
	}
	
	
	function deleteAdmin($adminid)
	{
	//echo $adminid; die;
	    $status =0;
		$this->db->set ( 'status', $status );
		$this->db->where ( 'id', $adminid  );
		$this->db->update ( 'asce_licences', $this );
		$as = $this->db->last_query();
		//echo $as; die;
		return $adminid;
	
	
	
	
	
	//$this->db->delete( 'asce_licences', array (
	//			'id' => $adminid 
	//	) );	
	//	return $adminid;
	}
	
	function Getlicencecunt($usermaster,$product_id)
	{ 
		  $this->db->select ( 'licence_count' );
		$this->db->from ( 'asce_products' );
		
	    $this->db->where ( 'master_id', $usermaster  );
		$this->db->where ( 'product_id', $product_id );
		$query = $this->db->get ()->result();
		return $query;
	}
	
	function fetchDetailip($usermaster){
	$this->db->select('m_orderid');
	$this->db->from('asce_licences');
	$this->db->where ('m_masterid',$usermaster);
	$result=$this->db->get()->result();
	//echo $this->db->last_query(); die;
	return $result;
	}
	
	function fetchcarporationemail($orderid){
    $this->db->select('m_primaryemail,m_firstname,m_lastname');
	$this->db->from('asce_licences');
	$this->db->where ('m_orderid',$orderid);
	$this->db->where ('m_custtype',I);
	$result=$this->db->get()->result();
	//echo $this->db->last_query(); die;
	return $result;
	}
	
}
