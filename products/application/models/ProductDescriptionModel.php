<?php
if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class ProductDescriptionModel extends CI_Model {
	private $productTable = 'mps_product'; // user accounts
	private $rateTable = 'mps_rate';
	private $licenceTable = 'mps_license';
	private $customBook = 'm_custbook'; // Sections
	function __construct() {
		parent::__construct ();
	}
	// Get user information
	function getAllBooks($id) {
		$this->db->select ( '*' );
		$this->db->from ( 'asce_product_book' );
		$this->db->join ( 'mps_product', 'asce_product_book.product_id=mps_product.product_id', 'inner' );
		$this->db->join ( 'mps_license', 'mps_license.license_id=asce_product_book.license_id', 'inner' );
		$this->db->join ( 'm_book', 'asce_product_book.book_id=m_book.m_bokid', 'inner' );
		$this->db->join ( 'm_volume', 'm_volume.m_volbokid=m_book.m_bokid', 'inner' );
		$this->db->where ( 'asce_product_book.status=1' );
		$this->db->where ( 'asce_product_book.book_id', $id );
		$this->db->group_by ( 'asce_product_book.product_id' );
		$query = $this->db->get ();
		$finalQuery = $this->db->last_query ();
		return $query->result ();
	}
	function getAllProducts($id, $prodids = null) {
		//print_r( $prodids); die;
		$this->db->select ( '*' );
		$this->db->from ( 'asce_product_book' );
		$this->db->join ( 'mps_product', 'asce_product_book.product_id=mps_product.product_id', 'inner' );
		$this->db->join ( 'mps_license', 'mps_license.license_id=asce_product_book.license_id', 'inner' );
		$this->db->join ( 'm_book', 'asce_product_book.book_id=m_book.m_bokid', 'inner' );
		$this->db->join ( 'm_volume', 'm_volume.m_volbokid=m_book.m_bokid', 'inner' );
		$this->db->where ( 'asce_product_book.book_id', $id );
		$this->db->where ( 'asce_product_book.status=1' );
		if (! empty ( $prodids )) {
			$this->db->where_not_in ( 'mps_product.product_id', $prodids );
		}
		$this->db->group_by ( 'asce_product_book.product_id' );
		$query = $this->db->get ();
		$finalQuery = $this->db->last_query ();
		//PRINT_R($finalQuery); die;
		return $query->result ();
	}
	function getSubsBook($productId = null) {
		$this->db->select ( 'asce_product_book.book_id,m_book.m_bokdesc,m_book.m_bokid,m_book.m_boktitle,m_book.m_bokisbn,asce_product_book.product_id,asce_product_book.license_id' );
		$this->db->from ( 'asce_product_book' );
		$this->db->join ( 'mps_product', 'mps_product.product_id=asce_product_book.product_id', 'inner' );
		$this->db->join ( 'm_book', 'asce_product_book.book_id=m_book.m_bokid', 'inner' );
		if (! empty ( $productId )) {
		$this->db->where_in ( 'asce_product_book.product_id', $productId );
		}
		$this->db->where ( 'asce_product_book.status=1' );
		$query = $this->db->get ();
		$finalQuery = $this->db->last_query (); 
		return $query->result ();
	}
	function getbook($productId = null) {
		$product_id = explode ( ',', $productId );
		$count = count ( $product_id );
		if ($count > 0) {
			$this->db->select ( 'asce_product_book.book_id,m_book.m_bokdesc,m_book.m_bokid,m_book.m_boktitle,asce_product_book.product_id,asce_product_book.license_id' );
			$this->db->from ( 'asce_product_book' );
			$this->db->join ( 'mps_product', 'mps_product.product_id=asce_product_book.product_id', 'inner' );
			$this->db->join ( 'm_book', 'asce_product_book.book_id=m_book.m_bokid', 'inner' );
			$this->db->where_in ( 'asce_product_book.product_id', $product_id );
			$this->db->where ( 'asce_product_book.status=1' );
			$query = $this->db->get ();
			$finalQuery = $this->db->last_query ();
			return $query->result ();
		}
	}
	function getDetailBooks($bookname) {
		$this->db->select ( 'm_boktitle,m_boksubtitle,m_bokdesc,m_bokprice,m_bokauthorname' );
		$this->db->from ( 'm_book' );
		$this->db->where ( 'm_bokid', $bookname );
		$query = $this->db->get ();
		$finalQuery = $this->db->last_query ();
		return $query->result ();
	}
	function get_AllSubscriptions($userId) {
		$this->db->select ( 'subscription.*,product.product_name' );
		$this->db->from ( 'asce_products as subscription' );
		$this->db->where ( array (
				'subscription.master_id' => $userId,
				'subscription.line_status' =>'A',
		) );
		$this->db->join ( 'mps_product product', 'subscription.product_id = product.master_product_id', 'left' );
		$this->db->group_by('subscription.order_id'); 
		$query = $this->db->get ();
			//echo $this->db->last_query(); die;
		$query = $query->result_array ();
		return $query;
	}
	
	function getDemoBookInfo($id) {
		$this->db->select ( '*' );
		$this->db->from ( 'm_book' );
		$this->db->join ( 'm_volume', 'm_book.m_bokid=m_volume.m_volbokid' );
		$this->db->join ( 'asce_product_book', 'asce_product_book.book_id=m_book.m_bokid', 'inner' );
		$this->db->join ( 'mps_product', 'mps_product.product_id=asce_product_book.product_id', 'inner' );
		$this->db->where ( 'm_book.m_bokid', $id );
		$this->db->group_by ( 'asce_product_book.book_id' );
		$query = $this->db->get ();
		$finalQuery = $this->db->last_query ();
		return $query->result ();
	}
	
	function getBookInfo($id) {
		$this->db->select ( '*' );
		$this->db->from ( 'm_book' );
		$this->db->join ( 'm_volume', 'm_book.m_bokid=m_volume.m_volbokid' );
		$this->db->where ( 'm_book.m_bokid', $id );
		$query = $this->db->get ();
		$finalQuery = $this->db->last_query ();
		return $query->result ();
	}
	function get_Subscribed_Product($master_id) {
	// print_r($master_id); die;
		$this->db->select ( 'asce_product_book.product_id,asce_product_book.book_id,
       mps_product.product_name,mps_product.product_discription,mps_product.master_product_id,asce_products.licence_type' );
		$this->db->from ( 'asce_product_book' );
		$this->db->join ( 'mps_product', 'asce_product_book.product_id=mps_product.product_id', 'inner' );
		$this->db->join ( 'asce_products', 'mps_product.master_product_id=asce_products.product_id', 'inner' );
		//$this->db->join ( 'mps_license', 'mps_license.license_id=asce_product_book.license_id', 'inner' );
		$this->db->join ( 'm_book', 'asce_product_book.book_id=m_book.m_bokid', 'inner' );
		$this->db->join ( 'm_volume', 'm_volume.m_volbokid=m_book.m_bokid', 'inner' );
		$this->db->where ( 'asce_product_book.status=1' );
		$this->db->where ( 'asce_products.master_id', $master_id );
		$this->db->group_by ( 'asce_product_book.product_id' );
		$query = $this->db->get ();
	    $finalQuery = $this->db->last_query (); 
		//print_r($finalQuery); die;
		return $query->result ();
	}
}