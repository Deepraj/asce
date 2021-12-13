	<?php
	if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
	class ProductModel extends CI_Model {
		private $productTable = 'mps_product'; // user accounts
		private $rateTable = 'mps_rate';
		private $licenceTable = 'mps_license';
		private $customBook = 'm_custbook'; // Sections
		function __construct() {
			parent::__construct ();
		}
		function get_book($bookids = null) {
		    //print_r($bookids); die;
			$this->db->select ( '*' );
			$this->db->from ( 'm_book' );
			$this->db->join ( 'm_volume', 'm_volume.m_volbokid = m_book.m_bokid', 'inner' );
			$this->db->join ( 'asce_product_book', 'asce_product_book.book_id = m_book.m_bokid', 'inner' );
			//$this->db->where ( 'asce_product_book.status=1' );
			if(!empty($bookids)){
			$this->db->where_not_in ( 'm_bokid', $bookids );
			}
			$this->db->group_by ( "asce_product_book.book_id", "asce" );
			$this->db->order_by ( "m_book.m_updateddate", "desc" );
			$query = $this->db->get ();
		  // echo  $completeQuery = $this->db->last_query (); die;
			return $query->result ();
		}
		function get_Subscribed_Product($MasterCustomerId){
		//print_r($MasterCustomerId); die;
			$this->db->select ( '*' );
			$this->db->from ( 'asce_products' );
			$this->db->join ( 'asce_licences', 'asce_licences.m_masterid=asce_products.master_id', 'inner' );
			$this->db->join ( 'mps_product', 'mps_product.master_product_id=asce_products.product_id', 'inner' );
			$this->db->join ( 'asce_product_book', 'asce_product_book.product_id=mps_product.product_id', 'inner' );
			$this->db->join ( 'm_book', 'asce_product_book.book_id=m_book.m_bokid', 'inner' );
			$this->db->join ( 'm_volume', 'm_volume.m_volbokid=m_book.m_bokid', 'inner' );
			$this->db->where ( 'asce_products.master_id="' . $MasterCustomerId . '" and asce_products.line_status="A" and asce_products.licence_type="SINGLE" and asce_products.grace_date>="'.date('Y-m-d').'"');
			$this->db->or_where('asce_products.master_id="' . $MasterCustomerId . '" and asce_products.line_status="A" and asce_products.licence_type="MULTI" and asce_products.grace_date>="'.date('Y-m-d').'"');
			$this->db->or_where('asce_products.master_id="' . $MasterCustomerId . '" and asce_products.line_status="A" and asce_products.licence_type="IPBASED" and asce_products.grace_date>="'.date('Y-m-d').'"');
			$this->db->order_by ( "m_book.m_updateddate", "desc" );
			$this->db->group_by ( 'asce_products.product_id' );
			$query = $this->db->get ();
		    //echo  $finalQuery = $this->db->last_query (); die;
		     return $query->result ();
		}
		
		function get_Subscribed_Product_list($MasterCustomerId){
			//echo"hello";die;
		//print_r($MasterCustomerId); die;
		    $this->db->select ( '*' );
			$this->db->from ( 'asce_products' );
			$this->db->join ( 'asce_licences', 'asce_licences.m_masterid=asce_products.master_id', 'inner' );
			$this->db->join ( 'mps_product', 'mps_product.master_product_id=asce_products.product_id', 'inner' );
			$this->db->join ( 'asce_product_book', 'asce_product_book.product_id=mps_product.product_id', 'inner' );
			$this->db->join ( 'm_book', 'asce_product_book.book_id=m_book.m_bokid', 'inner' );
			$this->db->join ( 'm_volume', 'm_volume.m_volbokid=m_book.m_bokid', 'inner' );
			$this->db->where ( 'asce_products.master_id="' . $MasterCustomerId . '" and asce_products.line_status="A" and asce_products.licence_type="SINGLE" and asce_products.licence_type="MULTI" and asce_products.end_date>"'.date('Y-m-d').'"');
			$this->db->group_by ( 'asce_products.product_id' );
			$query = $this->db->get ();
		    $finalQuery = $this->db->last_query ();
			// echo $quur; die;
			return $query->result ();
		
		}
		
		function get_Subscribed_Book($master_id) {
			$this->db->select ( '*' );
			$this->db->from ( 'm_book' );
			$this->db->join ( 'm_volume', 'm_volume.m_volbokid = m_book.m_bokid', 'inner' );
			$this->db->join ( 'asce_product_book', 'asce_product_book.book_id = m_book.m_bokid', 'inner' );
			$this->db->join ( 'mps_product', 'mps_product.product_id = asce_product_book.product_id', 'inner' );
			$this->db->join ( 'asce_products', 'mps_product.master_product_id = asce_products.product_id', 'inner' );
			//$this->db->where ( 'asce_product_book.status=1' );
			$this->db->where ('asce_products.master_id="' . $master_id . '" and asce_products.line_status="A"');
			$this->db->order_by ( "m_book.m_updateddate", "desc" );
			$this->db->group_by ( "asce_product_book.book_id", "asce" );
			$query = $this->db->get ();
			//echo $completeQuery = $this->db->last_query (); die;
			return $query->result ();
		}
		function get_Subscribed_Book_Multi($master_id) {
			$this->db->select ( '*' );
			$this->db->from ( 'm_book' );
			$this->db->join ( 'm_volume', 'm_volume.m_volbokid = m_book.m_bokid', 'inner' );
			$this->db->join ( 'asce_product_book', 'asce_product_book.book_id = m_book.m_bokid', 'inner' );
			$this->db->join ( 'mps_product', 'mps_product.product_id = asce_product_book.product_id', 'inner' );
			$this->db->join ( 'asce_products', 'mps_product.master_product_id = asce_products.product_id', 'inner' );
			$this->db->where ( 'asce_products.licence_type="MULTI"');
			$this->db->where ('asce_products.master_id="' . $master_id . '" and asce_products.line_status="A"');
			$this->db->order_by ( "m_book.m_updateddate", "desc" );
			//$this->db->where ( 'asce_products.master_id=' . $master_id );
			$this->db->group_by ( "asce_product_book.book_id", "asce" );
			$query = $this->db->get ();
		  // echo  $completeQuery = $this->db->last_query (); die;
			return $query->result ();
		}
	
		
		function get_Subscribed_Book_Ip($master_id) {
			$this->db->select ( '*' );
			$this->db->from ( 'm_book' );
			$this->db->join ( 'm_volume', 'm_volume.m_volbokid = m_book.m_bokid', 'inner' );
			$this->db->join ( 'asce_product_book', 'asce_product_book.book_id = m_book.m_bokid', 'inner' );
			$this->db->join ( 'mps_product', 'mps_product.product_id = asce_product_book.product_id', 'inner' );
			$this->db->join ( 'asce_products', 'mps_product.master_product_id = asce_products.product_id', 'inner' );
			$this->db->where ( 'asce_products.licence_type="IPBASED"');
			$this->db->where ('asce_products.master_id="' . $master_id . '" and asce_products.line_status="A"');
			//$this->db->where ( 'asce_products.master_id=' . $master_id );
			$this->db->order_by ( "m_book.m_updateddate", "desc" );
			$this->db->group_by ( "asce_product_book.book_id", "asce" );
			$query = $this->db->get ();
		    $completeQuery = $this->db->last_query (); 
			return $query->result ();
		}
	
		function check_ip($ipaddress)
		{
			$this->db->select ( 'aui_status' );
			$this->db->from ( 'asce_ip_authentication as ip_auth' );
			$this->db->where ( "INET_ATON('$ipaddress') between INET_ATON(ip_auth.low_ip) and INET_ATON(ip_auth.high_ip) and ip_auth.aui_status='1'");
			$query = $this->db->get ();
			$completeQuery = $this->db->last_query ();
			//echo $completeQuery; die;
			return $query->result ();
		}
	
		function notsubcribedproduct($master_id)
		{
	    $this->db->select('m_masterid,m_lablename,m_firstname,m_lastname,m_licence_type');
		$this->db->from('asce_licences');
		$this->db->where('m_masterid="'.$master_id.'"');
		$query=$this->db->get();
		return $query->result();
		}
	
		function get_Subscribed_Book_list($master_id) {
			$this->db->select ( '*' );
			$this->db->from ( 'm_book' );
			$this->db->join ( 'm_volume', 'm_volume.m_volbokid = m_book.m_bokid', 'inner' );
			$this->db->join ( 'asce_product_book', 'asce_product_book.book_id = m_book.m_bokid', 'inner' );
			$this->db->join ( 'mps_product', 'mps_product.product_id = asce_product_book.product_id', 'inner' );
			$this->db->join ( 'asce_products', 'mps_product.master_product_id = asce_products.product_id', 'inner' );
			$this->db->where ( 'asce_product_book.status=1 and asce_products.licence_type="SINGLE" ' );
			$this->db->where ( 'asce_products.master_id=' . $master_id );
			$this->db->order_by ( "m_book.m_updateddate", "desc" );
			$this->db->group_by ( "asce_product_book.book_id", "asce" );
			$query = $this->db->get ();
			//$completeQuery = $this->db->last_query ();
			return $query->result ();
		}
	
	 public function getnoteorderid($LabelipName)
		{
			$this->db->select('m_orderid');
		    $this->db->from('asce_licences');
		    $this->db->where('m_lablename ="'.$LabelipName.'" ');
            $query = $this->db->get ();
			//echo $completeQuery = $this->db->last_query (); die;
			return $query->result ();
			
		}
		
		function EmailAuth($master_id){
		    $this->db->select('email');
		    $this->db->from('asce_institute_email_auth');
		    $this->db->where('master_id ="'.$master_id.'" ');
            $query = $this->db->get ();
			$quur=$this->db->last_query();
			//echo $quur; die;
			return $query->result ();
		}
		function getDetail($master_id){
		$this->db->select('m_masterid,m_lablename,m_orderid,m_firstname,m_lastname,m_licence_type');
		$this->db->from('asce_licences');
		$this->db->where('m_masterid="'.$master_id.'"');
		$query=$this->db->get();
		return $query->result();
		}
		
	}
?>	
