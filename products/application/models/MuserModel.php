<?php
	if (! defined ( 'BASEPATH' ))exit ( 'No direct script access allowed' );
	 class MuserModel extends CI_Model {
		function __construct() {
			parent::__construct ();
		}
	  function SubUserlist($master_id){
		$this->db->select('http_referer_id,email,first_name,middle_name,last_name,product_id,order_id,product_name');
		$this->db->from('asce_institute_email_auth');
		$this->db->where ('master_id=' . $master_id );
		$query = $this->db->get ();
		$completeQuery = $this->db->last_query ();
		return $query->result ();
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
	function updateSubUser($id,$data)
	{
		$this->db->where('http_referer_id', $id);
		$this->db->update('asce_institute_email_auth',$data);
	}
	

	function get_Allproduct($master_id) {

		$this->db->select ( 'subscription.*,product.product_name' );
		$this->db->from ( 'asce_products as subscription' );
		$this->db->where ( array (
				'subscription.master_id' => $master_id,
				'subscription.line_status'=>'A'
		) );
		$this->db->join ( 'mps_product product', 'subscription.product_id = product.master_product_id', 'left' );
		$this->db->group_by('subscription.order_id'); 
		$query = $this->db->get ();
		//echo $this->db->last_query(); die;
		$query = $query->result_array ();
		return $query;
	}

	function get_AllEmails($masterid,$productid='') {
	    $this->db->select ( '*' );
		$this->db->from ( 'asce_institute_email_auth' );
		$this->db->where ( array (
				'master_id' => $masterid 
		) );
		if($productid !='')
		{
		$this->db->where ( array (
				'order_id' => $productid 
		));	
		}
		$query = $this->db->get ();
		$query = $query->result_array ();
		//echo $this->db->last_query(); die;
		return $query;
	}
	
	function fetchDetailsubuser($to_email){
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
	
	function fetchdata($email,$first_name,$sortBy,$master_id){
	$email=trim($email);
	$first_name=trim($first_name);
	if($email !='' && $first_name !=''){
	$this->db->select('http_referer_id,email,first_name,middle_name,last_name,product_id');
	$this->db->from(' asce_institute_email_auth');
	$where = "email='".$email."' AND first_name='".$first_name."'";
	$this->db->where($where);
	$this->db->where('master_id',$master_id);
	$query = $this->db->get ();
	$completeQuery = $this->db->last_query ();
	return $query->result ();
	}else if($email!=''){
	$this->db->select('http_referer_id,email,first_name,middle_name,last_name,product_id');
	$this->db->from(' asce_institute_email_auth');
	$where = "email='".$email."'";
	$this->db->where($where);
	$this->db->where('master_id',$master_id);
	$query = $this->db->get ();
	$completeQuery = $this->db->last_query ();
	return $query->result ();
	}else if($first_name !=''){
	$this->db->select('http_referer_id,email,first_name,middle_name,last_name,product_id');
	$this->db->from(' asce_institute_email_auth');
	$where = "first_name='".$first_name."'";
	$this->db->where($where);
	$this->db->where('master_id',$master_id);
	$query = $this->db->get ();
	$completeQuery = $this->db->last_query ();
	return $query->result ();
	}else if($sortBy !=''){
    $this->db->select('http_referer_id,email,first_name,middle_name,last_name,product_id');
	$this->db->from(' asce_institute_email_auth');
	$this->db->where('master_id',$master_id);
	$this->db->like('first_name',$sortBy, 'after');
	$query = $this->db->get ();
	$completeQuery = $this->db->last_query ();
	return $query->result ();  
	}else{
	$this->db->select('http_referer_id,email,first_name,middle_name,last_name,product_id');
	$this->db->from(' asce_institute_email_auth');
	$this->db->where ('master_id=' . $master_id );
	$query = $this->db->get ();
	$completeQuery = $this->db->last_query ();
	return $query->result ();
	}
  }
  function fetchDetail($to_email){
	    $this->db->select ( '*' );
		$this->db->from ( 'asce_institute_email_auth' );
		$this->db->join('asce_licences','asce_institute_email_auth.master_id=asce_licences.m_masterid');
		$this->db->where ('asce_institute_email_auth.email',$to_email);	 
		$query = $this->db->get ()->result();
		return $query;
	
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
  function isExistEmail($email,$usermaster,$product_id)
	{
		//print_r($email); die;
		$success = array();
	 $this->db->select ( 'email' );
		$this->db->from ( 'asce_institute_email_auth' );
		$this->db->where ( array (
				'email' => $email,
                'master_id' =>$usermaster,
                'product_id' =>$product_id				
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
		//echo $max."/////".$num; die;
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
	$this->db->select ( 'licence_count' );
		$this->db->from ( 'asce_products' );
		
		$this->db->where("master_id", $data['usermaster'] );
		$this->db->where("licence_type", $LicenceInfo );
		$this->db->where("product_id",$data['product_id'] );
		$this->db->where("order_id",$data['order_id'] );
		$query = $this->db->get ()->result();
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
	// $newinserted =0;
	//echo"<pre>"; print_r($max);die;
	$this->db->select ( '*' );
		$this->db->from ( 'asce_institute_email_auth' );
		
		$this->db->where("master_id", $data['usermaster'] );
		//$this->db->where("product_id", $data['product_id'] );
		$this->db->where("order_id",$data['order_id'] );
		$query = $this->db->get ();
		$num = $query->num_rows ();
		
		if($num<$max)
		{
	$insert=$this->db->insert('asce_institute_email_auth',array('product_id'=>$data['product_id'],'order_id'=>$data['order_id'],'product_name'=>$data['product_name'],'master_id'=>$data['usermaster'],'first_name'=>$data['insFirstName'],'last_name'=>$data['insLastName'],'email'=>$data['insEmail'])); 
	}
	if($insert){
	return '1';
	}else{
	return '0';
	
	}
   	}
	
		function checkCorporaitionMultiAdmin ( $master_id ){
			//echo $OnlineEmailAddress; die;
		$this->db->select ( 'm_orderid' );
		$this->db->from ( 'asce_licences' );
		//$this->db->join ( 'asce_licences', 'asce_institute_email_auth.master_id=asce_licences.m_masterid', 'inner' );
		$this->db->where ( 'm_masterid="' . $master_id . '"' );
		$query = $this->db->get ()->result ();
		return $query;
		///$qq = $this->db->last_query ();
		// echo $qq; die;
		
	}
	
	function checkOrderidMultiAdmin ( $orderid){
		$licencetype="C";
		$this->db->select ( 'm_lastname,m_primaryemail,m_masterid' );
		$this->db->from ( 'asce_licences' );
		$this->db->where ( 'm_custtype="' . $licencetype . '" and m_orderid="' . $orderid . '"' );
		$query = $this->db->get ()->result ();
		$qq = $this->db->last_query ();
		// echo $qq; die;
		//print_r($query[0]); die;
		$result = $query[0]->m_lastname;
		//print_r($result); die;
		//$query->num_rows(); 
		if(is_array($query) && (!empty($result)))
		{
			return $query;
		}
		else{
			return false;
		}	
	}
	
	
  
 }
?>	