<?php
	if (! defined ( 'BASEPATH' ))exit ( 'No direct script access allowed' );
	 class IpuserModel extends CI_Model {
		function __construct() {
			parent::__construct ();
		}
		
	  function SubUserlist($master_id){
	  
	  
	  $this->db->select ( '*' );
		$this->db->from ( 'asce_ip_authentication as products' );
		
		
		$this->db->join ( 'asce_products subscription ', 'products.master_id = subscription.master_id', 'inner' );
		$this->db->where ( array (
				'products.master_id' => $master_id 
		) );
		$this->db->group_by('products.ipauth_id');
		$query = $this->db->get ();
		$query = $query->result_array ();
		return $query;
	  
		//$this->db->select('http_referer_id,email,first_name,middle_name,last_name');
		//$this->db->from('asce_institute_email_auth');
		//$this->db->where ('master_id=' . $master_id );
		//$query = $this->db->get ();
		//$completeQuery = $this->db->last_query ();
		//return $query->result ();
	}
	function deleteSubUser($id){
	    $this->db->where('http_referer_id', $id);
        $this->db->delete('asce_institute_email_auth');
	}
	function EditSubUser($id){
	    $this->db->select('email,first_name,middle_name,last_name');
		$this->db->from('asce_institute_email_auth');
		$this->db->where ('http_referer_id=' .$id );
		$query = $this->db->get ();
		$completeQuery = $this->db->last_query ();
		return $query->result ();
	}
	
	function selectReportdata($search_from_date,$search_to_date,$master_id,$email)
	{

	/* $year = DateTime::createFromFormat('Y', $year, new DateTimeZone('UTC'));
    $year= $year->getTimestamp();
    $starttimestamp = $year."-".$month."-"."01"." "."00:00:00";
	$datevalue = "01-".$month."-".$year." 00:00:00";
    $starttimestamp =  strtotime($datevalue);
	$enddatevalue = $month."-30-".$year." 00:00:00";
	$endtimestamp = $year."-".$month."-"."31"." "."23:58:00";
    $endtimestamp =  strtotime($enddatevalue);
	echo $datevalue."--".$enddatevalue;echo "<hr>";
	echo $starttimestamp."****".$endtimestamp;die;
	echo $year."///".$month."////".$master_id; die; */
	$this->db->select('id,date_format(creat_date,"%M-%Y") as month');
	$this->db->from(' asce_userlogs');
	//$where = "date_format(creat_date,'%Y') ='$year' AND master_id='$master_id' AND email!='$email'";
	$where = "date_format(creat_date,'%Y-%m')>='$search_from_date' AND date_format(creat_date,'%Y-%m')<='$search_to_date' AND master_id='$master_id' AND email!='$email'";
	$this->db->where($where);
	//$this->db->group_by('sessid');
    $result = $this->db->get()->result();
	 return $result;
	// return $this->db->get()->result();
	//echo $completeQuery = $this->db->last_query (); die;
	
	
	}
	
	
	function selectIPReportdata($search_from_date,$search_to_date,$master_id,$email)
	{
	//		print_r($search_from_date.'--to--'.$search_to_date.'--id--'.$master_id.'--email--'.$email);echo "<hr>"; //die;
	/* $year = DateTime::createFromFormat('Y', $year, new DateTimeZone('UTC'));
    $year= $year->getTimestamp();
    $starttimestamp = $year."-".$month."-"."01"." "."00:00:00";
	$datevalue = "01-".$month."-".$year." 00:00:00";
    $starttimestamp =  strtotime($datevalue);
	$enddatevalue = $month."-30-".$year." 00:00:00";
	$endtimestamp = $year."-".$month."-"."31"." "."23:58:00";
    $endtimestamp =  strtotime($enddatevalue);
	echo $datevalue."--".$enddatevalue;echo "<hr>";
	echo $starttimestamp."****".$endtimestamp;die;
	echo $year."///".$month."////".$master_id; die; */
	
	$this->db->select('id,date_format(creat_date,"%M-%Y") as month');
	$this->db->from(' asce_userlogs');
	//$where = "date_format(creat_date,'%Y') ='$year' AND master_id='$master_id' AND email!='$email'";
	$where = "date_format(creat_date,'%Y-%m')>='$search_from_date' AND date_format(creat_date,'%Y-%m')<='$search_to_date' AND master_id='$master_id'";
	$this->db->where($where);
	$this->db->group_by('sessid');
    $result = $this->db->get()->result();
	//echo $completeQuery = $this->db->last_query (); die;
	 return $result;
	// return $this->db->get()->result();
	 //echo $completeQuery = $this->db->last_query (); die;
	}
	
	function selectmonthReportdata($search_from_date,$search_to_date,$master_id,$email)
	{
		//echo $search_from_date ;echo'-------'; echo $search_to_date;
	$this->db->select('id,date_format(creat_date,"%M-%Y") as month');
	$this->db->from(' asce_userlogs');
	//$where = "date_format(creat_date,'%Y') ='$year' AND master_id='$master_id' AND email!='$email'";
	$where = "date_format(creat_date,'%Y-%m')>='$search_from_date' AND date_format(creat_date,'%Y-%m')<='$search_to_date' AND master_id='$master_id' AND email!='$email'";
	$this->db->where($where);
	//$this->db->group_by('sessid');
    $result = $this->db->get()->result();
	 return $result;
	 //echo '<pre>';print_r($result);	 
    //echo $completeQuery = $this->db->last_query (); die;	
	}
	
	function selectIPmonthReportdata($search_from_date,$search_to_date,$master_id,$email)
	{
	$this->db->select('id,date_format(creat_date,"%M %Y") as month');
	$this->db->from(' asce_userlogs');
	$where = "date_format(creat_date,'%Y-%m')>='$search_from_date' AND date_format(creat_date,'%Y-%m')<='$search_to_date' AND master_id='$master_id' AND email!='$email' AND flag='1'";
	//$where = "date_format(creat_date,'%Y') ='$year' AND master_id='$master_id' AND email!='$email'AND flag='1'";
	$this->db->where($where);
	return $this->db->get()->result();
	//echo $completeQuery = $this->db->last_query (); die;	
	}
	
	function getInstituteDetail($master_id){
	$this->db->select('m_lablename');
	$this->db->from('asce_licences');
	$this->db->where('m_masterid',$master_id);
	return $this->db->get()->result();
	}
		
	function updateSubUser($id,$data)
	{
		$this->db->where('http_referer_id', $id);
		$this->db->update('asce_institute_email_auth',$data);
	}
	function fetchdata($email,$first_name,$sortBy,$master_id){
	$email=trim($email);
	$first_name=trim($first_name);
	if($email !='' && $first_name !=''){
	$this->db->select('http_referer_id,email,first_name,middle_name,last_name');
	$this->db->from(' asce_institute_email_auth');
	$where = "email='".$email."' AND first_name='".$first_name."'";
	$this->db->where($where);
	$query = $this->db->get ();
	$completeQuery = $this->db->last_query ();
	return $query->result ();
	}else if($email!=''){
	$this->db->select('http_referer_id,email,first_name,middle_name,last_name');
	$this->db->from(' asce_institute_email_auth');
	$where = "email='".$email."'";
	$this->db->where($where);
	$query = $this->db->get ();
	$completeQuery = $this->db->last_query ();
	return $query->result ();
	}else if($first_name !=''){
	$this->db->select('http_referer_id,email,first_name,middle_name,last_name');
	$this->db->from(' asce_institute_email_auth');
	$where = "first_name='".$first_name."'";
	$this->db->where($where);
	$query = $this->db->get ();
	$completeQuery = $this->db->last_query ();
	return $query->result ();
	}else if($sortBy !=''){
    $this->db->select('http_referer_id,email,first_name,middle_name,last_name');
	$this->db->from(' asce_institute_email_auth');
	$this->db->like('first_name',$sortBy, 'after');
	$query = $this->db->get ();
	$completeQuery = $this->db->last_query ();
	return $query->result ();  
	}else{
	$this->db->select('http_referer_id,email,first_name,middle_name,last_name');
	$this->db->from(' asce_institute_email_auth');
	$this->db->where ('master_id=' . $master_id );
	$query = $this->db->get ();
	$completeQuery = $this->db->last_query ();
	return $query->result ();
	}
  }
 }
?>	