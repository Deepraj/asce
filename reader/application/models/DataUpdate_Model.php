<?php
if (! defined ( 'BASEPATH' ))
		exit ( 'No direct script access allowed' );
	class DataUpdate_Model extends CI_Model {
	
		function __construct() {
			parent::__construct ();
		}	
		
		 function getInfo($MasterCustomerId){
			$this->db->select('*');
			$this->db->from ('asce_licences');
			$this->db->where('m_masterid="'.$MasterCustomerId.'"');
			$query = $this->db->get ();
			$quur=$this->db->last_query();
			//echo $quur; die;
			return $query->num_rows();
		} 
		function getData($MasterCustomerId){
			$this->db->select('*');
			$this->db->from ('asce_licences');
			$this->db->where('m_masterid="'.$MasterCustomerId.'"');
			$query = $this->db->get ();
			return $query->result ();
		}
	  	
		function getOrder($MasterCustomerId){
			$this->db->select('*');
			$this->db->from('asce_products');
			$this->db->where('master_id="'.$MasterCustomerId.'"');
			$query = $this->db->get ();
			$quur=$this->db->last_query();
			//echo $quur; die;
			return $query->num_rows();
		}
		
		function getByemail($MasterCustomerId){
			$this->db->select('*');
			$this->db->from('asce_institute_email_auth');
			$this->db->join('asce_products','asce_products.master_id=asce_institute_email_auth.master_id','inner');
			$this->db->where('asce_institute_email_auth.master_id="'.$MasterCustomerId.'" and asce_products.licence_type="MULTI" and asce_products.line_status="A"');
			$query=$this->db->get();
			$quer=$this->db->last_query();
			//echo $quer; die;
			return $query->result();
		}
		
		function getDate($MasterCustomerId){
			$this->db->select('*');
			$this->db->from('asce_products');
			$this->db->where('master_id="'.$MasterCustomerId.'" and licence_type="SINGLE"');
			$query = $this->db->get ();
			$qq=$this->db->last_query();
			//echo $qq; die;
			return $query->result ();
		}
		
		function insert($arr_data){
			
		  $this->db->insert('asce_licences',$arr_data);
		  return ($this->db->affected_rows() > 0) ? true : false;
			
		}
		
		function insertOrder($order_array){
		 $this->db->insert('asce_products', $order_array);
			
		} 
		
	  function Update($MasterCustomerId,$arr_data){
			$this->db->where('m_masterid', $MasterCustomerId);
			$this->db->update('asce_licences', $arr_data);
			
		}
		
		
		function UpdateOrder($OrderNo,$order_array){
			//print_r($order_array); die;
			$this->db->where('order_id', $OrderNo);
			$this->db->update('asce_products', $order_array);
			
		}
		
		
	  
		
	}
?>