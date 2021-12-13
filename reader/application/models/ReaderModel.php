<?php
if (! defined ( 'BASEPATH' ))
		exit ( 'No direct script access allowed' );
	class ReaderModel extends CI_Model {
		private $productTable = 'mps_product'; // user accounts
		private $rateTable = 'mps_rate';
		private $licenceTable = 'mps_license';
		private $customBook = 'm_custbook'; // Sections
		function __construct() {
			parent::__construct ();
		}
						
		function getInfo($MasterCustomerId){
			$this->db->select('*');
			$this->db->from ('asce_licences');
			$this->db->where('m_masterid="'.$MasterCustomerId.'"');
			$query = $this->db->get ();
			return $query->result ();
		}
	
		function getAllBooks($MasterCustomerId) {			
			$this->db->select('*');
			$this->db->from('asce_products');
			$this->db->join('asce_licences','asce_licences.m_masterid=asce_products.master_id','inner');
			$this->db->join('mps_product','mps_product.master_product_id=asce_products.product_id','inner');
			$this->db->join('asce_product_book','asce_product_book.product_id=mps_product.product_id','inner');
			$this->db->join('m_book','asce_product_book.book_id=m_book.m_bokid','inner');
			$this->db->join('m_volume','m_volume.m_volbokid=m_book.m_bokid','inner');
			$this->db->where('asce_products.master_id="'.$MasterCustomerId.'" and asce_products.line_status="A" and asce_products.licence_type="SINGLE"');
			$this->db->group_by('asce_products.product_id');
			$query = $this->db->get ();
			$quur=$this->db->last_query();
			//echo $quur; die;
			return $query->result ();
			// return $ret[0]=email;
		}
		
		
		function getIpaddress($ipaddress){
		   // print_r($ipaddress); die;  
			$this->db->select ('*' );
			$this->db->from ('asce_ip_authentication as ip_auth' );
			$this->db->join('asce_products','ip_auth.master_id=asce_products.master_id','inner');
			$this->db->join('asce_licences','asce_licences.m_masterid=asce_products.master_id','inner');
			$this->db->join ('mps_product','mps_product.master_product_id=asce_products.product_id','inner');
			$this->db->join('asce_product_book','asce_product_book.product_id=mps_product.product_id','inner');
			$this->db->join ('m_book','asce_product_book.book_id = m_book.m_bokid','inner');
			$this->db->join ('m_volume', 'm_book.m_bokid = m_volume.m_volbokid', 'inner' );
			$this->db->where ("INET_ATON('$ipaddress') between INET_ATON(ip_auth.low_ip) and INET_ATON(ip_auth.high_ip) and asce_products.line_status='A' and asce_products.licence_type='IPBASED'");
			$this->db->group_by('ip_auth.institute_id');
			//$this->db->where ('asce_product_book.status=1');
			$query = $this->db->get ();
			$que=$this->db->last_query();
			//echo $que; die;    
			return $query->result();
		}
         		
		
		function insert($arr_data){
		  $this->db->insert('asce_licences',$arr_data);
			
		}
		
		function update($MasterCustomerId,$Alldata){
			$this->db->where('m_masterid', $MasterCustomerId);
			$this->db->update('asce_licences', $Alldata);
			
		}
		
		function insertOrder($order_arr){
		 $this->db->insert('asce_products',$order_arr);
			
		}
		
		function UpdateOrder($MasterCustomerId,$order_arr){
			$this->db->where('master_id', $MasterCustomerId);
			$this->db->update('asce_products', $order_arr);	
		}
		
		function getOrder($MasterCustomerId){
			$this->db->select('*');
			$this->db->from('asce_products');
			$this->db->where('master_id="'.$MasterCustomerId.'"');
			$query = $this->db->get ();
			return $query->result ();
		}
		
		function getSingleUser(){
			$this->db->select('*');
			$this->db->from('asce_products');
			$this->db->join('asce_licences','asce_licences.m_masterid=asce_products.master_id','inner');
			$this->db->where('asce_products.licence_type="SINGLE"');
			$query = $this->db->get ();
			return $query->result ();
		}
		
		function InsertDetail($order_id,$flag){
			$data=array(
			 'order_id'=>$order_id,
			  'flag' =>$flag,
			   'created_date'=>date('Y-m-d:h:i:sa')
			);
			
			$this->db->insert('asce_sendmail',$data);
		}
		
		function Insertip($master_id,$ip){
		$data=array(
		'master_id'=>$master_id,
		'ipaddress'=>$ip,
		'flag'=>1,
		'created_date'=>date('Y-m-d:H:i:s')
		);
		$this->db->insert('asce_ip_count',$data);
		}
		
		function getIp($master_id){
		$this->db->select('ipaddress,COUNT(ipaddress) AS num_of_time');
		$this->db->from('asce_ip_count');
		$this->db->where('master_id="'.$master_id.'" and flag=1');
		$query = $this->db->get ();
		//echo $que=$this->db->last_query(); die;
		return $query->result ();
		}
		
		function getNumIp($master_id){
		$this->db->select('ipaddress');
		$this->db->from('asce_ip_count');
		$this->db->where('master_id="'.$master_id.'"');
		$query = $this->db->get();
		return $query->result ();
		}
		
		function getDetail($order_id){
			$this->db->select('*');
			$this->db->from('asce_sendmail');
			$this->db->where('order_id="'.$order_id.'"');
			$query = $this->db->get ();
			return $num = $query->num_rows();
		}
		
		function updateip($flag,$iprange){
		      $update=array(
			  'flag' =>$flag
			  );
		    $this->db->where('ipaddress', $iprange);
			$this->db->update('asce_ip_count', $update);
			//echo $this->db->last_query();die;
		}
		
		function userinsert($inusert){
		$this->db->insert('users',$inusert);
		}
		
		function selectInsert($MasterCustomerId){
			$this->db->select('*');
			$this->db->from('users');
			$this->db->where('master_id',$MasterCustomerId);
			$query = $this->db->get ();
			return $num = $query->num_rows();
		}
		
		function UpdateInsert($MasterCustomerId,$updateuser){
		    $this->db->where('master_id', $MasterCustomerId);
			$this->db->update('users', $updateuser);
		}
		
		function limit_text($text, $limit) {
			if (str_word_count($text, 0) > $limit) {
				$words = str_word_count($text, 2);
				$pos = array_keys($words);
				$text = substr($text, 0, $pos[$limit]) . '...';
			}
		 return $text;
		}
		
	}
?>