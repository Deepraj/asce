<?php

if (! defined ( 'BASEPATH' ))
	exit ( 'No direct script access allowed' );
class Crons extends CI_Model {
	public static $bookid=0;
	private $table_name = 'asce_cronfiles_queue'; // user accounts
	function __construct() {
		parent::__construct ();
	}
	
	
	// Get session details
	function getCurrentQueqe() {
		$this->db->select( );
		$this->db->from ( $this->table_name );
                $this->db->where(array('status'=>0));
                //$this->db->limit(1);
		$query = $this->db->get ();
                
		return $query->result ();
	}
        function setCronFlage($ids){
            $status=1;
			//$cur_bookid=0;
			$cur_bookid = $this->getCurentBookId($ids);
			$cur_bookid =$cur_bookid->bookid;
			
			//echo "<pre>";print_r($cur_bookid); die;
            $this->db->where_in("id", $ids);
            $data["status"] = $status;
            $this->db->update($this->table_name, $data);
            //die($this->db->last_query());
        }
		function getCurentBookId($ids)
		{
		$this->db->select( );
		$this->db->from ( $this->table_name );
                $this->db->where(array('id'=>$ids));
                $this->db->limit(1);
		  $query = $this->db->get ();
           return $query->row ();		  
		}
		function tableLastId()
		{
			$this->db->select( );
		    $this->db->from ( $this->table_name );
			$this->db->order_by("id", "desc");
            $this->db->limit(1);
            $query = $this->db->get();
			//die($this->db->last_query());
            return  $query->row();	
			
		}
		function getCurentBookTitle()
		{
		$this->db->select('m_boktitle');
		$this->db->from ('m_book');
			//$this->db->order_by("id", "desc");
            //$this->db->limit(1);
            $query = $this->db->get();
			//die($this->db->last_query());
            return $query->result ();		
		}
}