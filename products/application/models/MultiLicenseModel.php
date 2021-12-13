<?php
//error_reporting(1);
	if (! defined ( 'BASEPATH' ))exit ( 'No direct script access allowed' );
	 class MultiLicenseModel extends CI_Model {
		function __construct() {
			parent::__construct ();
		}
		
	  function SubsProdList($master_id){
		$this->db->select('http_referer_id,email,first_name,middle_name,last_name');
		$this->db->from('asce_institute_email_auth');
		$this->db->where ('master_id=' . $master_id );
		$query = $this->db->get ();
		$completeQuery = $this->db->last_query ();
		return $query->result ();
	}
	function get_AllSubscriptions($userId) {
	//print_r($userId); die;
		$this->db->select ( 'subscription.*,product.product_name' );
		$this->db->from ( 'asce_products as subscription' );
		$this->db->where('subscription.master_id', $userId);
		$this->db->where('subscription.line_status','A');
		$this->db->join ( 'mps_product product', 'subscription.product_id = product.master_product_id', 'left' );
		$this->db->group_by('subscription.order_id');
		$query = $this->db->get ();
		$finalQuery= $this->db->last_query();
	//echo $finalQuery; die;
		$query = $query->result_array ();
		return $query;
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
	function fetchdata($productId,$productName,$sortBy,$master_id){
	$productId=trim($productId);
	$productName=trim($productName);
	$sortBy=trim($sortBy);
	$where=array();
	if($productId !=''){
	  $where = array (
	      'subscription.product_id'=> $productId
		) ;
		$this->db->select ('subscription.*,product.product_name');
		$this->db->from ( 'asce_products as subscription' );
		$this->db->where ($where);
		$this->db->where('subscription.master_id',$master_id);
		$this->db->where('subscription.line_status','A');
		$this->db->join ( 'mps_product product', 'subscription.product_id = product.master_product_id', 'inner' );
		$this->db->group_by('subscription.product_id'); 
		$query = $this->db->get ();
	    $completeQuery = $this->db->last_query ();
	    //print_r($completeQuery); die;
	    $query = $query->result_array ();
	    return $query;
		
	}else if($productName!=''){
	    $where = 'product.product_name like '.'"%'.$productName.'%"';			
		$this->db->select ('subscription.*,product.product_name');
		$this->db->from ( 'asce_products as subscription' );
		$this->db->where ($where);
		$this->db->where('subscription.master_id',$master_id);
		$this->db->where('subscription.line_status','A');
		$this->db->join ( 'mps_product product', 'subscription.product_id = product.master_product_id', 'inner' );
		$this->db->group_by('subscription.product_id'); 
		$query = $this->db->get ();
	    $completeQuery = $this->db->last_query ();
	    //print_r($completeQuery); die;
	    $query = $query->result_array ();
	    return $query;
		
	}else if(!empty($sortBy)){
		$where ="product.product_name like '$sortBy%'";
		$this->db->select ('subscription.*,product.product_name');
		$this->db->from ( 'asce_products as subscription' );
		$this->db->where ($where);
		$this->db->where('subscription.master_id',$master_id);
		$this->db->where('subscription.line_status','A');
		$this->db->join ( 'mps_product product', 'subscription.product_id = product.master_product_id', 'inner' );
		$this->db->group_by('subscription.product_id'); 
		$query = $this->db->get ();
	    $completeQuery = $this->db->last_query ();
	   // print_r($completeQuery); die;
	    $query = $query->result_array ();
	    return $query;
	}else{
	    $this->db->select ('subscription.*,product.product_name');
		$this->db->from ( 'asce_products as subscription' );
		$this->db->where('subscription.master_id',$master_id);
		$this->db->where('subscription.line_status','A');
		$this->db->join ( 'mps_product product', 'subscription.product_id = product.master_product_id', 'inner' );
		$this->db->group_by('subscription.product_id'); 
		$query = $this->db->get ();
	    $completeQuery = $this->db->last_query ();
	    //print_r($completeQuery); die;
	    $query = $query->result_array ();
	    return $query;
	}
 }
 }
?>	
