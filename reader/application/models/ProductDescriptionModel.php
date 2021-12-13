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
		   /* echo $id;
			exit; */
			$this->db->distinct();
			$this->db->select('*');
			$this->db->from('asce_product_book probook');
			$this->db->join('mps_product','mps_product.product_id=probook.product_id','inner');
			$this->db->join('m_book book','book.m_bokid=probook.book_id','inner');
			$this->db->join('m_volume','book.m_bokid=m_volume.m_volbokid','inner');
			$this->db->where('probook`.product_id="'.$id.'" and probook.status=1');
			$this->db->group_by('probook.book_id');
			$query = $this->db->get ();
			$test=$this->db->last_query();
			//echo $test; die;
			return $query->result ();
		}
		
	}